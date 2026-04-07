<!DOCTYPE html>
<html lang="es">
  <head>
    <meta name="description" content="Panel docente con listado de alumnos por grupo, matricula y materia.">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VillaNet - Docente</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('/public/css/main.css'); ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
      :root {
        --teacher-accent: #0f766e;
        --teacher-accent-soft: #dff7f2;
        --teacher-ink: #12323a;
        --teacher-border: #d9e6e8;
      }

      body {
        background:
          radial-gradient(circle at top right, rgba(15, 118, 110, 0.10), transparent 28%),
          linear-gradient(180deg, #f7fbfb 0%, #eef5f6 100%);
      }

      .teacher-shell {
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 12px 28px rgba(15, 118, 110, 0.10);
        padding: 24px 28px;
        margin-bottom: 22px;
        border: 1px solid rgba(15, 118, 110, 0.08);
      }

      .teacher-hero {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
      }

      .teacher-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: var(--teacher-accent-soft);
        color: var(--teacher-accent);
        font-weight: 700;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        font-size: 0.78rem;
      }

      .teacher-kpis {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 18px;
        margin-bottom: 22px;
      }

      .teacher-kpi {
        background: #fff;
        border-radius: 18px;
        padding: 20px 22px;
        border: 1px solid var(--teacher-border);
        box-shadow: 0 10px 24px rgba(18, 50, 58, 0.07);
      }

      .teacher-kpi__label {
        margin: 0 0 8px;
        color: #53717a;
        font-size: 0.95rem;
      }

      .teacher-kpi__value {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        color: var(--teacher-ink);
      }

      .teacher-table-card {
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--teacher-border);
        box-shadow: 0 16px 32px rgba(18, 50, 58, 0.08);
      }

      .teacher-table-card__head {
        padding: 20px 24px;
        border-bottom: 1px solid var(--teacher-border);
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: center;
        flex-wrap: wrap;
      }

      .teacher-table-card__title {
        margin: 0;
        color: var(--teacher-ink);
      }

      .teacher-search {
        max-width: 320px;
        width: 100%;
      }

      .teacher-empty {
        padding: 32px 24px;
        text-align: center;
        color: #53717a;
      }

      .teacher-table {
        margin-bottom: 0;
      }

      .teacher-table thead th {
        background: #f2f7f8;
        color: var(--teacher-ink);
        border-bottom: 1px solid var(--teacher-border);
        white-space: nowrap;
      }

      .teacher-table td {
        vertical-align: middle;
      }

      .teacher-pill {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 999px;
        background: var(--teacher-accent-soft);
        color: var(--teacher-accent);
        font-weight: 700;
        font-size: 0.8rem;
      }

      .teacher-meta {
        color: #53717a;
        font-size: 0.9rem;
      }

      @media (max-width: 768px) {
        .teacher-shell,
        .teacher-kpi,
        .teacher-table-card__head {
          padding: 18px;
        }
      }
    </style>
  </head>
  <body class="app sidebar-mini">
    <header class="app-header"><a class="app-header__logo" href="<?= base_url(route_to('docenteDashboard')); ?>">Docente</a>
      <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <ul class="app-nav">
        <li class="dropdown"><a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Open Profile Menu"><i class="bi bi-person fs-4"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="<?= base_url(route_to('settings')); ?>"><i class="bi bi-gear me-2 fs-5"></i> Settings</a></li>
            <li><a class="dropdown-item" href="<?= base_url(route_to('profile')); ?>"><i class="bi bi-person me-2 fs-5"></i> Profile</a></li>
            <li><a class="dropdown-item" href="<?= base_url(route_to('logout')); ?>"><i class="bi bi-box-arrow-right me-2 fs-5"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>

    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?= esc(session('user_name') ?? 'Docente') ?></p>
          <p class="app-sidebar__user-designation">Docente</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item active" href="<?= base_url(route_to('docenteDashboard')); ?>"><i class="app-menu__icon bi bi-speedometer"></i><span class="app-menu__label">Dashboard</span></a></li>
      </ul>
    </aside>

    <main class="app-content">
      <div class="teacher-shell">
        <div class="teacher-hero">
          <div>
            <span class="teacher-badge"><i class="bi bi-mortarboard-fill"></i> Panel principal</span>
            <h1 class="mb-2 mt-3"><i class="bi bi-mortarboard"></i> Dashboard Docente</h1>
            <p class="mb-0 text-muted">Consulta a todos tus alumnos por grupo, matricula, nombre, apellidos y materia.</p>
          </div>
          <div class="text-end">
            <div class="teacher-meta">Docente: <?= esc(session('user_name') ?? 'Docente') ?></div>
            <div class="teacher-meta">Registros activos del ciclo actual</div>
          </div>
        </div>
      </div>

      <section class="teacher-kpis">
        <article class="teacher-kpi">
          <p class="teacher-kpi__label">Alumnos unicos</p>
          <p class="teacher-kpi__value"><?= esc((string) ($teacherSummary['students'] ?? 0)) ?></p>
        </article>
        <article class="teacher-kpi">
          <p class="teacher-kpi__label">Grupos asignados</p>
          <p class="teacher-kpi__value"><?= esc((string) ($teacherSummary['groups'] ?? 0)) ?></p>
        </article>
        <article class="teacher-kpi">
          <p class="teacher-kpi__label">Materias</p>
          <p class="teacher-kpi__value"><?= esc((string) ($teacherSummary['subjects'] ?? 0)) ?></p>
        </article>
        <article class="teacher-kpi">
          <p class="teacher-kpi__label">Asignaciones</p>
          <p class="teacher-kpi__value"><?= esc((string) ($teacherSummary['assignments'] ?? 0)) ?></p>
        </article>
      </section>

      <section class="teacher-table-card">
        <div class="teacher-table-card__head">
          <div>
            <h2 class="teacher-table-card__title h4 mb-1">Listado de alumnos</h2>
            <p class="mb-0 text-muted">Puedes buscar por cualquier dato visible en la tabla.</p>
          </div>
          <div class="teacher-search">
            <input id="teacherTableSearch" class="form-control" type="search" placeholder="Buscar por matricula, grupo, alumno o materia">
          </div>
        </div>

        <?php if (! empty($teacherStudents)): ?>
          <div class="table-responsive">
            <table class="table teacher-table align-middle">
              <thead>
                <tr>
                  <th>Matricula</th>
                  <th>Nombre</th>
                  <th>Apellidos</th>
                  <th>Grupo</th>
                  <th>Materia</th>
                  <th>Detalles</th>
                </tr>
              </thead>
              <tbody id="teacherStudentsBody">
                <?php foreach ($teacherStudents as $student): ?>
                  <tr>
                    <td><?= esc($student['student_code']) ?></td>
                    <td><?= esc($student['person']) ?></td>
                    <td><?= esc(trim(($student['first_name'] ?? '') . ' ' . ($student['last_name'] ?? ''))) ?></td>
                    <td><span class="teacher-pill"><?= esc($student['school_group']) ?></span></td>
                    <td><?= esc($student['subject_name']) ?></td>
                    <td class="teacher-meta"><?= esc($student['notes'] ?: 'Sin observaciones') ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="teacher-empty">
            <h3 class="h5">Aun no hay alumnos asignados</h3>
            <p class="mb-0">Cuando registres relaciones docente-alumno en <code>tbl_teacher_students</code>, aqui apareceran por grupo, matricula y materia.</p>
          </div>
        <?php endif; ?>
      </section>
    </main>

    <script src="<?= base_url('/public/js/jquery-3.7.0.min.js'); ?>"></script>
    <script src="<?= base_url('/public/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('/public/js/main.js'); ?>"></script>
    <script>
      const teacherSearch = document.getElementById('teacherTableSearch');
      const teacherRows = Array.from(document.querySelectorAll('#teacherStudentsBody tr'));

      if (teacherSearch && teacherRows.length > 0) {
        teacherSearch.addEventListener('input', function () {
          const term = this.value.trim().toLowerCase();

          teacherRows.forEach(function (row) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
          });
        });
      }
    </script>
  </body>
</html>
