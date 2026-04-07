<!DOCTYPE html>
<html lang="es">
  <head>
    <meta name="description" content="Panel de alumno listo para personalizar.">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VillaNet - Alumno</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('/public/css/main.css'); ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
      .student-shell {
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
        padding: 24px 28px;
        margin-bottom: 22px;
      }
    </style>
  </head>
  <body class="app sidebar-mini">
    <header class="app-header"><a class="app-header__logo" href="<?= base_url(route_to('alumnoDashboard')); ?>">Alumno</a>
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
          <p class="app-sidebar__user-name"><?= esc(session('user_name') ?? 'Alumno') ?></p>
          <p class="app-sidebar__user-designation">Alumno</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item active" href="<?= base_url(route_to('alumnoDashboard')); ?>"><i class="app-menu__icon bi bi-speedometer"></i><span class="app-menu__label">Dashboard</span></a></li>
      </ul>
    </aside>

    <main class="app-content">
      <!-- Este contenedor envuelve el encabezado principal del dashboard del alumno. -->
      <div class="student-shell">
        <h1 class="mb-1"><i class="bi bi-backpack2"></i> Dashboard Alumno</h1>
        <p class="mb-0 text-muted">Vista base lista para personalizar</p>
      </div>
    </main>

    <script src="<?= base_url('/public/js/jquery-3.7.0.min.js'); ?>"></script>
    <script src="<?= base_url('/public/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('/public/js/main.js'); ?>"></script>
  </body>
</html>
