<?php /* views/users/notifications.php */ ?>
<div class="page-header">
  <div><div class="page-heading">Notifications</div><div class="page-sub"><?= $pg['total'] ?> total</div></div>
</div>
<div class="card">
  <div class="card-body" style="padding:0">
    <?php if (!$notifs): ?>
      <div class="empty-state" style="padding:3rem"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg><div class="es-title">No notifications</div></div>
    <?php else: foreach ($notifs as $n): ?>
      <div style="padding:.875rem 1.25rem;border-bottom:1px solid var(--gray-100);display:flex;gap:.75rem;<?= !$n['is_read']?'background:#f8fbff':'' ?>">
        <div class="ni-icon <?= e($n['type']) ?>" style="flex-shrink:0">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
        </div>
        <div style="flex:1">
          <div class="fw-600 text-sm"><?= e($n['title']) ?></div>
          <div class="text-sm text-muted"><?= e($n['message']) ?></div>
          <div class="text-xs text-muted mt-1"><?= time_ago($n['created_at']) ?></div>
        </div>
        <?php if (!$n['is_read']): ?><div class="ni-dot" style="flex-shrink:0;margin-top:.5rem"></div><?php endif; ?>
      </div>
    <?php endforeach; endif; ?>
  </div>
</div>
