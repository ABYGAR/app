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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
      :root {
        /* Variables base de la pantalla de niveles.
           Si luego quieres cambiar el estilo, empieza por aqui. */
        --panel-ink: #17313a;
        --panel-muted: #5b737b;
        --panel-line: rgba(23, 49, 58, 0.1);
        --panel-shell: linear-gradient(180deg, #f4faf8 0%, #edf4f6 100%);
        --panel-card: linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(242, 248, 247, 0.96) 100%);
        --panel-accent: #0f766e;
        --panel-shadow: 0 22px 50px rgba(23, 49, 58, 0.12);
      }

      /* Fondo general del panel.
         Puedes tocarlo si luego quieres otro ambiente visual. */
      body.app {
        background:
          radial-gradient(circle at top right, rgba(15, 118, 110, 0.12), transparent 28%),
          radial-gradient(circle at left center, rgba(245, 158, 11, 0.08), transparent 26%),
          var(--panel-shell);
      }

      .app-content {
        position: relative;
        padding-top: 14px;
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

      /* Panel principal del formulario.
         Si luego preguntas como modificarlo, revisa .hero-tile y .hero-kicker. */
      .hero-tile {
        border-radius: 18px;
        background: var(--panel-card);
        color: var(--panel-ink);
        overflow: hidden;
        position: relative;
        border: 1px solid var(--panel-line);
        box-shadow: var(--panel-shadow);
        backdrop-filter: blur(10px);
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
         Si quieres compactar o expandir los contenedores, toca este bloque. */
      .hero-tile.tile,
      .tile.table-glow {
        padding: 16px;
      }

      .tile:not(.hero-tile) {
        border-radius: 18px;
        border: 1px solid var(--panel-line);
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.96) 0%, rgba(246, 250, 251, 0.98) 100%);
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.07);
      }

      .tile .tile-title,
      .hero-tile .tile-title {
        color: var(--panel-ink);
        font-weight: 800;
        margin-bottom: 8px;
        font-size: 1.12rem;
      }

      .tile-subtitle {
        margin-bottom: 12px;
        color: var(--panel-muted);
        font-size: 0.9rem;
      }

      /* Inputs y selects del formulario.
         Si luego preguntas por bordes, color o foco, revisa este bloque. */
      .hero-tile .form-control,
      .hero-tile .form-select {
        min-height: 42px;
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid rgba(91, 115, 123, 0.2);
        color: var(--panel-ink);
        border-radius: 12px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.6);
      }

      .hero-tile .form-control:focus,
      .hero-tile .form-select:focus {
        border-color: rgba(15, 118, 110, 0.42);
        box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12);
      }

      .hero-tile .form-label {
        color: var(--panel-ink);
        font-weight: 700;
        letter-spacing: 0.02em;
      }

      /* Boton principal de crear.
         Si quieres otro color o forma, modifica aqui. */
      .hero-tile .btn-primary {
        border: 0;
        border-radius: 12px;
        min-height: 44px;
        background: linear-gradient(135deg, #0f766e 0%, #155e75 100%);
        box-shadow: 0 14px 30px rgba(15, 118, 110, 0.22);
        font-weight: 700;
        letter-spacing: 0.02em;
      }

      .hero-tile .btn-primary:hover,
      .hero-tile .btn-primary:focus {
        background: linear-gradient(135deg, #115e59 0%, #164e63 100%);
      }

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
         Si luego preguntas como cambiar la tabla, este es el bloque. */
      .levels-table-wrap {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(15, 118, 110, 0.1);
        background: rgba(255, 255, 255, 0.86);
      }

      .levels-table-wrap thead th {
        background: linear-gradient(180deg, #eef8f6 0%, #e7f0ef 100%);
        border-bottom: 0;
        color: var(--panel-ink);
      }

      .levels-table-wrap tbody tr {
        transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
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

      @media (max-width: 991px) {
        .hero-tile.tile,
        .tile.table-glow {
          padding: 14px;
        }
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
          <?php // Nombre mostrado en el sidebar segun la sesion actual. ?>
          <p class="app-sidebar__user-name"><?= esc(session('user_name') ?? 'Administrador') ?></p>
          <?php // Etiqueta del rol visible dentro del panel admin. ?>
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
          <h1><i class="bi bi-layers"></i> Niveles</h1>
          <p>Administra niveles</p>
        </div>
      </div>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
      <?php endif; ?>

      <div class="row">
        <div class="col-lg-5">
          <div class="tile hero-tile">
            <div class="hero-kicker">
              <i class="bi bi-stars"></i>
              Panel de niveles
            </div>
            <h4 class="tile-title">Crear Nivel</h4>
            <p class="tile-subtitle">Agrega un nivel nuevo desde este formulario.</p>
            <?= form_open('#', ['id' => 'levelForm']); ?>
              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label">Nivel</label>
                  <input class="form-control" type="text" name="level" id="level" value="<?= esc(old('level')) ?>" placeholder="Nivel">
                  <small class="text-danger"><?= validation_show_error('level') ?></small>
                </div>
              </div>
              <div class="d-grid mt-4">
                <?php
                  $data = [
                      'name'    => 'btnLevel',
                      'id'      => 'btnLevel',
                      'type'    => 'button',
                      'class'   => 'btn btn-primary',
                      'content' => '<i class="bi bi-plus fs-5 me-2"></i>Crear',
                  ];

                  echo form_button($data);
                ?>
              </div>
            <?= form_close(); ?>
          </div>
        </div>

        <div class="col-lg-7">
          <div class="tile table-glow">
            <h4 class="tile-title">Lista de Niveles</h4>
            <div class="table-responsive levels-table-wrap">
              <table id="myTableLevels" class="table table-hover mb-0">
                <tbody>
                  <!-- DataTable llena esta tabla por AJAX.
                       Si despues preguntas como cambiar las filas, revisa public/js/levels.js -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
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
    </script>
  </body>
</html>
