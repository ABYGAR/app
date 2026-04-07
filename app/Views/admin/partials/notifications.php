<?php
$pendingRegistrations = $pendingRegistrations ?? [];
$assignableLevels = $assignableLevels ?? [];
$pendingCount = count($pendingRegistrations);
?>
<li class="dropdown">
  <a class="app-nav__item position-relative" href="#" data-bs-toggle="dropdown" aria-label="Show notifications">
    <i class="bi bi-bell fs-5"></i>
    <?php if ($pendingCount > 0): ?>
      <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill"><?= $pendingCount ?></span>
    <?php endif; ?>
  </a>
  <ul class="app-notification dropdown-menu dropdown-menu-right" style="min-width: 360px;">
    <li class="app-notification__title">
      <?= $pendingCount > 0 ? 'Solicitudes pendientes: ' . $pendingCount : 'No hay solicitudes pendientes' ?>
    </li>
    <?php if ($pendingCount > 0): ?>
      <div class="app-notification__content">
        <?php foreach ($pendingRegistrations as $pending): ?>
          <li class="px-3 py-2 border-bottom">
            <div class="mb-2">
              <strong><?= esc(trim(($pending['person'] ?? '') . ' ' . ($pending['first_name'] ?? '') . ' ' . ($pending['last_name'] ?? ''))) ?></strong>
              <div class="small text-muted"><?= esc($pending['fk_phone'] ?? '') ?></div>
            </div>
            <form method="post" action="<?= base_url(route_to('adminPendingApprove', $pending['pk_user'])) ?>">
              <div class="mb-2">
                <select class="form-select form-select-sm" name="level" required>
                  <option value="">Asignar como...</option>
                  <?php foreach ($assignableLevels as $level): ?>
                    <option value="<?= esc($level['pk_level']) ?>"><?= esc($level['label']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <button class="btn btn-sm btn-success w-100" type="submit">Aceptar solicitud</button>
            </form>
          </li>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <li class="app-notification__footer"><a href="#">Sin notificaciones por ahora.</a></li>
    <?php endif; ?>
  </ul>
</li>
