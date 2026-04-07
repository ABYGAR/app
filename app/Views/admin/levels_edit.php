<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 5, SASS and PUG.js. It's fully customizable and modular.">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
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
    <link rel="stylesheet" type="text/css" href="<?= base_url('/public/css/main.css'); ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
      .panel-entrance {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.55s ease, transform 0.55s ease;
      }

      .panel-entrance.is-visible {
        opacity: 1;
        transform: translateY(0);
      }

      /* Hero superior.
         Si despues quieres cambiar este encabezado, empieza por aqui. */
      .edit-hero {
        border-radius: 20px;
        background: linear-gradient(135deg, #004d40 0%, #00695c 45%, #26a69a 100%);
        color: #fff;
        position: relative;
        overflow: hidden;
      }

      .edit-hero::before {
        content: "";
        position: absolute;
        right: -45px;
        top: -35px;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.12);
      }

      .edit-hero .tile-title,
      .edit-hero p,
      .edit-hero small {
        color: inherit;
      }

      /* Tarjeta del formulario.
         Aqui puedes modificar radios, inputs y separacion del formulario. */
      .edit-form-card {
        border-radius: 18px;
      }

      .edit-form-card .form-control,
      .edit-form-card .form-select {
        min-height: 46px;
        border-radius: 12px;
      }

      /* Tarjeta lateral de resumen.
         Si luego quieres editar este panel derecho, revisa este bloque. */
      .profile-side {
        border-radius: 18px;
        background: #f7fbfa;
        border: 1px solid #dcefeb;
      }

      .profile-badge {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #00695c, #26a69a);
        color: #fff;
        font-size: 1.4rem;
      }

      .meta-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: #fff;
        border: 1px solid #d8ebe7;
        margin-bottom: 10px;
      }
    </style>
  </head>
  <body class="app sidebar-mini">
    <header class="app-header"><a class="app-header__logo" href="<?= base_url(route_to('adminDashboard')); ?>">Admin</a>
      <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <ul class="app-nav">
        <li class="app-search"></li>
        <?= $this->include('admin/partials/notifications') ?>
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
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 48 48'%3E%3Ccircle cx='24' cy='24' r='24' fill='%2300695c'/%3E%3Ccircle cx='24' cy='18' r='8' fill='white'/%3E%3Cpath d='M10 40c2.8-7 10-10 14-10s11.2 3 14 10' fill='white'/%3E%3C/svg%3E" alt="User Icon">
        <div>
          <?php // El nombre visible sale de la sesion para personalizar el sidebar. ?>
          <p class="app-sidebar__user-name"><?= esc(session('user_name') ?? 'Administrador') ?></p>
          <?php // La descripcion inferior indica que seguimos dentro del panel admin. ?>
          <p class="app-sidebar__user-designation">Administrador</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="<?= base_url(route_to('adminDashboard')); ?>"><i class="app-menu__icon bi bi-speedometer"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li><a class="app-menu__item" href="<?= base_url(route_to('adminUsers')); ?>"><i class="app-menu__icon bi bi-people"></i><span class="app-menu__label">Users</span></a></li>
      </ul>
    </aside>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="bi bi-pencil-square"></i> Edit Nivel</h1>
          <p>Actualiza nivel</p>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="tile edit-hero panel-entrance" style="transition-delay: 0.05s;">
            <h4 class="tile-title">Editar Nivel</h4>
            <p class="mb-2">Haz cambios desde un panel mas ordenado, con mejor distribucion y enfoque visual.</p>
            <small>Actualiza el nombre del nivel sin perder contexto.</small>
          </div>
          <div class="tile edit-form-card panel-entrance" style="transition-delay: 0.15s;">
            <h4 class="tile-title">Editar Nivel</h4>
            <?= form_open(base_url(route_to('adminLevelsUpdate', $level['pk_level']))); ?>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">ID</label>
                  <input class="form-control" type="text" value="<?= esc($level['pk_level']) ?>" readonly>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Nivel</label>
                  <input class="form-control" type="text" name="level" value="<?= esc(old('level') ?: $level['level']) ?>" placeholder="Nivel">
                  <small class="text-danger"><?= validation_show_error('level') ?></small>
                </div>
              </div>
              <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary" type="submit"><i class="bi bi-save me-2"></i>Guardar</button>
                <a class="btn btn-secondary" href="<?= base_url(route_to('adminLevels')); ?>">Cancelar</a>
              </div>
            <?= form_close(); ?>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="tile profile-side panel-entrance" style="transition-delay: 0.25s;">
            <div class="d-flex align-items-center gap-3 mb-4">
              <div class="profile-badge">
                <i class="bi bi-layers"></i>
              </div>
              <div>
                <h5 class="mb-1"><?= esc($level['level'] ?? 'Sin nivel') ?></h5>
                <small class="text-muted">Vista rapida del nivel</small>
              </div>
            </div>
            <div class="meta-chip">
              <i class="bi bi-hash"></i>
              <span>ID <?= esc($level['pk_level']) ?></span>
            </div>
            <div class="meta-chip">
              <i class="bi bi-tag"></i>
              <span><?= esc($level['level'] ?? 'Sin nombre') ?></span>
            </div>
            <hr>
            <p class="mb-2">Este panel te ayuda a editar el nivel sin que toda la vista se sienta larga o pesada.</p>
            <a class="btn btn-outline-primary w-100" href="<?= base_url(route_to('adminLevels')); ?>">Volver a niveles</a>
          </div>
        </div>
      </div>
    </main>
    <script src="<?= base_url('/public/js/jquery-3.7.0.min.js'); ?>"></script>
    <script src="<?= base_url('/public/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('/public/js/main.js'); ?>"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.panel-entrance').forEach(function (panel) {
          requestAnimationFrame(function () {
            panel.classList.add('is-visible');
          });
        });
      });
    </script>
  </body>
</html>
