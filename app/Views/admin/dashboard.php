<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 5, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 5 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 5, SASS and PUG.js. It's fully customizable and modular.">
    <title>VALI - ADMIN</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('/public/css/main.css'); ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
      :root {
        /* Variables visuales del dashboard.
           Si despues quieres cambiar el look, empieza por este bloque. */
        --panel-ink: #17313a;
        --panel-muted: #5b737b;
        --panel-line: rgba(23, 49, 58, 0.1);
        --panel-shell: linear-gradient(180deg, #f4faf8 0%, #edf4f6 100%);
        --panel-card: linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(242, 248, 247, 0.96) 100%);
        --panel-accent: #0f766e;
        --panel-shadow: 0 22px 50px rgba(23, 49, 58, 0.12);
      }

      /* Fondo general.
         Puedes modificarlo si luego quieres otro ambiente para el admin. */
      body.app {
        background:
          radial-gradient(circle at top right, rgba(15, 118, 110, 0.12), transparent 28%),
          radial-gradient(circle at left center, rgba(245, 158, 11, 0.08), transparent 26%),
          var(--panel-shell);
      }

      .section-title-green {
        margin-bottom: 22px;
      }

      .section-title-green h1 {
        color: #00695c;
        margin-bottom: 6px;
      }

      .section-title-green p {
        color: #00897b;
        margin-bottom: 0;
      }


      /* Panel del formulario.
         Este bloque usa el mismo estilo base que la pantalla Users. */
      .hero-tile {
        border-radius: 18px;
        background: var(--panel-card);
        color: var(--panel-ink);
        overflow: hidden;
        position: relative;
        border: 1px solid var(--panel-line);
        box-shadow: var(--panel-shadow);
        backdrop-filter: blur(10px);
        padding: 16px;
      }

      .hero-tile::after {
        content: "";
        position: absolute;
        inset: auto -55px -65px auto;
        width: 210px;
        height: 210px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(15, 118, 110, 0.16) 0%, rgba(15, 118, 110, 0) 72%);
      }

      .hero-tile::before {
        content: "";
        position: absolute;
        inset: -40px auto auto -45px;
        width: 170px;
        height: 170px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0) 74%);
      }

      /* Etiqueta superior del panel.
         Puedes cambiar este texto en el HTML si quieres otro nombre. */
      .hero-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 5px 10px;
        border-radius: 999px;
        margin-bottom: 10px;
        background: rgba(15, 118, 110, 0.08);
        color: var(--panel-accent);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
      }

      /* Tarjetas generales.
         Si luego quieres compactarlas o agrandarlas, toca este bloque. */
      .tile {
        border-radius: 18px;
        border: 1px solid var(--panel-line);
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.96) 0%, rgba(246, 250, 251, 0.98) 100%);
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.07);
        padding: 16px;
      }

      .tile .tile-title,
      .hero-tile .tile-title {
        color: var(--panel-ink);
        margin-bottom: 8px;
        font-weight: 800;
        font-size: 1.12rem;
      }

      /* Texto de apoyo dentro del formulario. */
      .panel-note {
        margin-bottom: 12px;
        color: var(--panel-muted);
        font-size: 0.9rem;
      }

      /* Inputs y selects.
         Si luego quieres bordes mas suaves o mas fuertes, cambia aqui. */
      .tile .form-control,
      .tile .form-select,
      .hero-tile .form-control,
      .hero-tile .form-select {
        min-height: 42px;
        border-radius: 12px;
        border: 1px solid rgba(91, 115, 123, 0.2);
        background: rgba(255, 255, 255, 0.88);
        color: var(--panel-ink);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.6);
      }

      .tile .form-control:focus,
      .tile .form-select:focus,
      .hero-tile .form-control:focus,
      .hero-tile .form-select:focus {
        border-color: rgba(15, 118, 110, 0.42);
        box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12);
      }

      .hero-tile .form-label,
      .tile .form-label {
        color: var(--panel-ink);
        font-weight: 700;
        letter-spacing: 0.02em;
      }

      /* Botones principales.
         Si quieres otro color o sombra, modifica este bloque. */
      .tile .btn-primary,
      .hero-tile .btn-primary {
        border: 0;
        border-radius: 12px;
        min-height: 44px;
        background: linear-gradient(135deg, #0f766e 0%, #155e75 100%);
        box-shadow: 0 14px 30px rgba(15, 118, 110, 0.22);
        font-weight: 700;
        letter-spacing: 0.02em;
      }

      .tile .btn-primary:hover,
      .tile .btn-primary:focus,
      .hero-tile .btn-primary:hover,
      .hero-tile .btn-primary:focus {
        background: linear-gradient(135deg, #115e59 0%, #164e63 100%);
      }

      /* Tarjeta derecha de la tabla.
         Usa el mismo acabado que la tabla de Users. */
      .table-glow {
        position: relative;
      }

      .table-glow::before {
        content: "";
        position: absolute;
        inset: -1px;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(15, 118, 110, 0.12), rgba(255, 255, 255, 0));
        pointer-events: none;
      }

      /* Tabla de niveles.
         Si luego preguntas "como modifico la tabla", este es el bloque. */
      .levels-table-wrap {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(15, 118, 110, 0.1);
        background: rgba(255, 255, 255, 0.86);
      }

      .levels-table-wrap thead th {
        background: linear-gradient(180deg, #eef8f6 0%, #e7f0ef 100%);
        color: var(--panel-ink);
        border-bottom: 0;
      }

      .levels-table-wrap tbody tr {
        transition: background-color 0.2s ease, transform 0.2s ease;
      }

      .levels-table-wrap tbody tr:hover {
        background: #f8fffd;
        transform: translateY(-1px);
        box-shadow: inset 4px 0 0 var(--panel-accent);
      }

      .levels-table-wrap .btn-warning,
      .levels-table-wrap .btn-danger {
        border-radius: 10px;
      }

      #levelStatus {
        display: none;
      }
    </style>
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?= base_url(route_to('adminDashboard')); ?>">Admin</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <li class="app-search">
          <!--<input class="app-search__input" type="search" placeholder="Search">
          <button class="app-search__button"><i class="bi bi-search"></i></button>
        </li> -->
        <?= $this->include('admin/partials/notifications') ?>
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Open Profile Menu"><i class="bi bi-person fs-4"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="<?= base_url(route_to('settings')); ?>"><i class="bi bi-gear me-2 fs-5"></i> Settings</a></li>
            <li><a class="dropdown-item" href="<?= base_url(route_to('profile')); ?>"><i class="bi bi-person me-2 fs-5"></i> Profile</a></li>
            <li><a class="dropdown-item" href="<?= base_url(route_to('logout')); ?>"><i class="bi bi-box-arrow-right me-2 fs-5"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 48 48'%3E%3Ccircle cx='24' cy='24' r='24' fill='%2300695c'/%3E%3Ccircle cx='24' cy='18' r='8' fill='white'/%3E%3Cpath d='M10 40c2.8-7 10-10 14-10s11.2 3 14 10' fill='white'/%3E%3C/svg%3E" alt="User Icon">
        <div>
          <?php // Este nombre se guarda en sesion cuando el usuario inicia sesion correctamente. ?>
          <p class="app-sidebar__user-name"><?= esc(session('user_name') ?? 'Administrador') ?></p>
          <?php // Esta linea muestra el rol visible dentro del panel admin. ?>
          <p class="app-sidebar__user-designation">Administrador</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="<?= base_url(route_to('adminDashboard')); ?>"><i class="app-menu__icon bi bi-speedometer"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li><a class="app-menu__item" href="<?= base_url(route_to('adminUsers')); ?>"><i class="app-menu__icon bi bi-people"></i><span class="app-menu__label">Users</span></a></li>
      </ul>
    </aside>
    <main class="app-content">
      <div class="section-title-green">
        <div>
          <h1><i class="bi bi-speedometer"></i> DASHBOARD DE ADMINISTRADOR </h1>
          <p>SESION DE ADMINISTRADOR</p>
        </div>
      </div>

      <!-- Sección de Gestión de Niveles -->
      <div class="row mt-4">
        <!-- Formulario para agregar nivel -->
        <div class="col-md-4">
          <!-- Panel del formulario.
               Si luego preguntas como modificarlo, revisa .hero-tile y .hero-kicker. -->
          <div class="tile hero-tile">
            <div class="hero-kicker">
              <i class="bi bi-stars"></i>
              Panel de niveles
            </div>
            <h4 class="tile-title">Nuevo Nivel</h4>
            <p class="panel-note">Crea niveles nuevos desde un panel mas limpio y facil de leer.</p>
            <div id="levelStatus" class="alert" role="alert"></div>
            <form id="levelForm">
              <div class="mb-3">
                <?= form_label('Level', 'level', ['class' => 'form-label']); ?>
                <?= form_input(['type' => 'text', 'name' => 'level', 'id'=>'level', 'value'=>old('level'), 'placeholder'=>'Insert the new level', 'class' => 'form-control']); ?>
                <small id="levelHelp" class="form-text text-muted"><p class="text-danger"><?= validation_show_error('level') ?></p></small>
              </div>
              <?php
                $data = [
                    'name'    => 'btnLevel',
                    'id'      => 'btnLevel',
                    'type'    => 'button',
                    'class'   => 'btn btn-primary w-100',
                    'content' => '<i class="bi bi-plus fs-5 me-2"></i>Add Level',
                ];
                echo form_button($data);
              ?>
            </form>
          </div>
        </div>

        <!-- Tabla de niveles -->
        <div class="col-md-8">
          <!-- Tarjeta de la tabla.
               Si luego preguntas como modificarla, revisa .table-glow y .levels-table-wrap. -->
          <div class="tile table-glow">
            <h4 class="tile-title">Lista de niveles</h4>
            <div class="table-responsive levels-table-wrap">
              <table id="myTableLevels" class="table table-striped table-hover mb-0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Level</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- DataTable llena esta tabla por AJAX.
                       Si luego preguntas por que no hay filas fijas aqui,
                       es porque el contenido lo construye public/js/levels.js -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="<?= base_url('/public/js/jquery-3.7.0.min.js'); ?>"></script>
    <script src="<?= base_url('/public/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('/public/js/main.js'); ?>"></script>
    <script src="<?= base_url('/public/js/levels.js'); ?>"></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      window.appLevelRoutes = {
        create: "<?= base_url(route_to('apiCreate')) ?>",
        read: "<?= base_url(route_to('readLevel')) ?>",
        delete: "<?= base_url(route_to('apiDelete')) ?>",
        editBase: "<?= rtrim(base_url('admin/levels/edit'), '/') ?>"
      };

      document.addEventListener('DOMContentLoaded', function () {
        const successMessage = <?= json_encode(session()->getFlashdata('success')) ?>;
        const errorMessage = <?= json_encode(session()->getFlashdata('error')) ?>;

        if (successMessage) {
          Swal.fire({
            title: successMessage,
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
          });
        }

        if (errorMessage) {
          Swal.fire({
            title: errorMessage,
            icon: 'error',
            timer: 1800,
            showConfirmButton: false
          });
        }
      });
    </script>
    
    <!-- Page specific javascripts-->
    <script type="text/javascript">
      // Google analytics script
      if(document.location.hostname == 'pratikborsadiya.in') {
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-72504830-1', 'auto');
        ga('send', 'pageview');
      }
    </script>
  </body>
</html>
