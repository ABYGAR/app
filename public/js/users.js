let tableUsers;

$(document).ready(function ()
{
    myUsersTable();
    buttonUser();
});

function myUsersTable()
{
    const url = (window.appUserRoutes && window.appUserRoutes.read) || "http://localhost/ci4/admin/users/read";

    if (!$.fn.DataTable.isDataTable('#myTableUsers'))
    {
        tableUsers = new DataTable('#myTableUsers',
        {
            ajax:
            {
                url: url,
                type: 'GET',
                dataSrc: ''
            },

            responsive: true,
            scrollCollapse: true,
            scrollX: true,
            autoWidth: false,
            deferRender: true,

            columns:
            [
                {
                    title: "ID",
                    data: null,
                    width: "10%",
                    className: "text-center",
                    render: function (data, type, row, meta)
                    {
                        // Mostramos un consecutivo visual en la tabla.
                        // Asi, si se elimina un usuario, la numeracion se recorre sola
                        // sin modificar el pk_user real almacenado en la base de datos.
                        const start = meta.settings._iDisplayStart || 0;
                        return start + meta.row + 1;
                    }
                },
                { title: "Telefono", data: "fk_phone", width: "18%" },
                {
                    title: "Nombre",
                    data: null,
                    width: "30%",
                    render: function (data, type, row)
                    {
                        return `${row.person ?? ''} ${row.first_name ?? ''} ${row.last_name ?? ''}`.trim();
                    }
                },
                { title: "Nivel", data: "level", width: "17%" },
                {
                    title: "Locked",
                    data: "locked",
                    width: "10%",
                    className: "text-center",
                    render: function (data)
                    {
                        return parseInt(data, 10) === 1 ? 'Si' : 'No';
                    }
                },
                { title: "Acciones", data: null, width: "15%", className: "text-center" }
            ],

            columnDefs:
            [
                {
                    targets: 5,
                    orderable: false,
                    render: function (data, type, row)
                    {
                        return `
                            <a class="btn btn-warning btn-edit btn-sm me-1"
                               href="${window.appUserRoutes.editBase}/${row.pk_user}"
                               title="Editar usuario">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <button class="btn btn-danger btn-delete btn-sm"
                                    data-pk_user="${row.pk_user}"
                                    title="Eliminar usuario ${row.pk_user}">
                                <i class="fa fa-trash"></i>
                            </button>`;
                    }
                }
            ],

            aLengthMenu:
            [
                [3, 5, 10, -1], [3, 5, 10, "Todos"]
            ],

            language:
            {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            }
        });

        actionUsersTable();
    }
    else
    {
        tableUsers.ajax.reload();
    }
}

function actionUsersTable()
{
    $('#myTableUsers tbody').on('click', '.btn-delete', function ()
    {
        const pkUser = $(this).data('pk_user');
        deleteUser([pkUser]);
    });
}

function buttonUser()
{
    $('#btnUser').click(function ()
    {
        const payload =
        {
            phone: $('#phone').val(),
            name: $('#name').val(),
            firstName: $('#firstName').val(),
            lastName: $('#lastName').val(),
            level: $('#userLevel').val(),
            password: $('#password').val()
        };

        createUser(payload);
    });
}

function createUser(payload)
{
    const url = (window.appUserRoutes && window.appUserRoutes.create) || "http://localhost/ci4/admin/users/apiCreate";

    $.ajax({
        type: 'POST',
        url: url,
        data: payload,

        success: function (response)
        {
            if (response.status == 200)
            {
                Swal.fire({
                    title: response.message,
                    icon: response.icon,
                    timer: 1500,
                    showConfirmButton: false
                });

                $('#phone, #name, #firstName, #lastName, #password').val('');
                $('#userLevel').val('');
                tableUsers.ajax.reload();
                return;
            }

            Swal.fire({
                title: response.message || 'No se pudo crear el usuario',
                icon: response.icon || 'error'
            });
        },

        error: function ()
        {
            Swal.fire({
                title: 'Error en la solicitud AJAX',
                icon: 'error'
            });
        }
    });
}

function deleteUser(user)
{
    const url = (window.appUserRoutes && window.appUserRoutes.delete) || "http://localhost/ci4/admin/users/apiDelete";

    $.ajax({
        type: 'POST',
        url: url,
        data: { user: user },

        success: function (response)
        {
            if (response.status == 200)
            {
                Swal.fire({
                    title: response.message,
                    icon: response.icon,
                    timer: 1500,
                    showConfirmButton: false
                });

                tableUsers.ajax.reload();
                return;
            }

            Swal.fire({
                title: response.message || 'No se pudo eliminar el usuario',
                icon: response.icon || 'error'
            });
        },

        error: function ()
        {
            Swal.fire({
                title: 'Error en la solicitud AJAX',
                icon: 'error'
            });
        }
    });
}
