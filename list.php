<?php /* views/projects/list.php */ ?>
<div class="page-header">
  <div>
    <div class="page-heading">Projects</div>
    <div class="page-sub"><?= $pg['total'] ?> projects found</div>
  </div>
  <div class="flex gap-1">
    <a href="/projects/create" class="btn btn-primary">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4v16m8-8H4"/></svg>
      New Project
    </a>
  </div>
</div>

<!-- Filters -->
<div class="card mb-2" style="padding:.875rem 1.25rem">
  <form method="GET" action="/projects" class="flex flex-center gap-1" style="flex-wrap:wrap">
    <input type="text" name="search" class="form-control" style="max-width:220px" placeholder="Search projects…" value="<?= e($search) ?>">
    <select name="type" class="form-control" style="max-width:180px">
      <option value="">All Types</option>
      <?php foreach (PROJECT_TYPES as $k => $v): ?>
        <option value="<?= e($k) ?>" <?= $type === $k ? 'selected' : '' ?>><?= e($v) ?></option>
      <?php endforeach; ?>
    </select>
    <select name="status" class="form-control" style="max-width:160px">
      <option value="">All Statuses</option>
      <?php foreach (PROJECT_STATUSES as $k => $v): ?>
        <option value="<?= e($k) ?>" <?= $status === $k ? 'selected' : '' ?>><?= e($v) ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
    <?php if ($search || $type || $status): ?>
      <a href="/projects" class="btn btn-secondary">Clear</a>
    <?php endif; ?>
    <div style="margin-left:auto;display:flex;gap:.375rem">
      <a href="?<?= http_build_query(array_merge($_GET,['view'=>'card'])) ?>" class="btn btn-sm <?= $view==='card'?'btn-primary':'btn-secondary' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
      </a>
      <a href="?<?= http_build_query(array_merge($_GET,['view'=>'table'])) ?>" class="btn btn-sm <?= $view==='table'?'btn-primary':'btn-secondary' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
      </a>
    </div>
  </form>
</div>

<?php if ($view === 'table'): ?>
<!-- Table View -->
<div class="card">
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>Code</th><th>Project</th><th>Type</th><th>Status</th><th>Priority</th>
          <th>Manager</th><th>Tasks</th><th>Tickets</th><th>End Date</th><th></th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$projects): ?>
          <tr><td colspan="10"><div class="empty-state"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M3 7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg><div class="es-title">No projects found</div></div></td></tr>
        <?php else: ?>
          <?php foreach ($projects as $p): ?>
          <tr>
            <td><span class="text-xs fw-600 text-muted"><?= e($p['project_code']) ?></span></td>
            <td>
              <div style="display:flex;align-items:center;gap:.5rem">
                <span class="color-dot" style="background:<?= e($p['color_label']??'#6366f1') ?>"></span>
                <div>
                  <div class="fw-600"><?= e($p['name']) ?></div>
                  <?php if ($p['client_name']): ?><div class="text-xs text-muted"><?= e($p['client_name']) ?></div><?php endif; ?>
                </div>
              </div>
            </td>
            <td><?= status_badge($p['project_type']) ?></td>
            <td><?= status_badge($p['status']) ?></td>
            <td><?= priority_badge($p['priority']) ?></td>
            <td class="text-muted"><?= $p['first_name'] ? e($p['first_name'].' '.$p['last_name']) : '—' ?></td>
            <td><span class="badge badge-secondary"><?= (int)$p['open_tasks'] ?></span></td>
            <td><?php if ($p['open_tickets']): ?><span class="badge badge-danger"><?= (int)$p['open_tickets'] ?></span><?php else: ?>—<?php endif; ?></td>
            <td class="text-muted"><?= fmt_date($p['end_date']) ?></td>
            <td><a href="/projects/<?= (int)$p['id'] ?>" class="btn btn-sm btn-outline">Open</a></td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php else: ?>
<!-- Card View -->
<?php if (!$projects): ?>
  <div class="empty-state card"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M3 7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg><div class="es-title">No projects found</div><p>Create your first project to get started.</p></div>
<?php else: ?>
<div class="grid-3">
  <?php foreach ($projects as $p): ?>
  <?php
    $days = days_until($p['end_date']);
    $dCls = $days === null ? '' : ($days < 0 ? 'color:var(--red)' : ($days <= 7 ? 'color:var(--yellow)' : ''));
    $dLbl = $days === null ? '' : ($days < 0 ? abs($days).'d overdue' : ($days === 0 ? 'Due today' : $days.'d left'));
  ?>
  <div class="card" style="border-top:3px solid <?= e($p['color_label']??'#6366f1') ?>;display:flex;flex-direction:column">
    <div style="padding:1rem 1.25rem;flex:1">
      <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.5rem;margin-bottom:.75rem">
        <div>
          <div class="text-xs text-muted fw-600 mb-1"><?= e($p['project_code']) ?></div>
          <div class="fw-700" style="font-size:.9375rem;color:var(--gray-800)"><?= e($p['name']) ?></div>
          <?php if ($p['client_name']): ?><div class="text-xs text-muted mt-1"><?= e($p['client_name']) ?></div><?php endif; ?>
        </div>
        <?= status_badge($p['status']) ?>
      </div>
      <div style="display:flex;gap:.375rem;flex-wrap:wrap;margin-bottom:.875rem">
        <?= status_badge($p['project_type']) ?>
        <?= priority_badge($p['priority']) ?>
      </div>
      <?php if ($p['completion_percent'] ?? 0): ?>
      <div style="margin-bottom:.75rem">
        <div style="display:flex;justify-content:space-between;font-size:.7rem;color:var(--gray-500);margin-bottom:.25rem">
          <span>Progress</span><span><?= (int)$p['completion_percent'] ?>%</span>
        </div>
        <div class="progress-bar"><div class="progress-fill" style="width:<?= (int)$p['completion_percent'] ?>%"></div></div>
      </div>
      <?php endif; ?>
      <div style="display:flex;gap:1rem;font-size:.75rem;color:var(--gray-500)">
        <span>👥 <?= (int)$p['member_count'] ?> members</span>
        <span>✅ <?= (int)$p['open_tasks'] ?> tasks</span>
        <?php if ($p['open_tickets']): ?><span style="color:var(--red)">🔧 <?= (int)$p['open_tickets'] ?> tickets</span><?php endif; ?>
      </div>
    </div>
    <div style="padding:.75rem 1.25rem;border-top:1px solid var(--gray-100);display:flex;align-items:center;justify-content:space-between">
      <?php if ($dLbl): ?><span class="text-xs fw-600" style="<?= $dCls ?>"><?= $dLbl ?></span><?php else: ?><span></span><?php endif; ?>
      <a href="/projects/<?= (int)$p['id'] ?>" class="btn btn-sm btn-primary">Open →</a>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
<?php endif; ?>

<!-- Pagination -->
<?php if ($pg['last_page'] > 1): ?>
<div style="display:flex;justify-content:center;gap:.375rem;margin-top:1.5rem">
  <?php for ($i = 1; $i <= $pg['last_page']; $i++): ?>
    <a href="?<?= http_build_query(array_merge($_GET,['page'=>$i])) ?>"
       class="btn btn-sm <?= $i === $pg['page'] ? 'btn-primary' : 'btn-secondary' ?>"><?= $i ?></a>
  <?php endfor; ?>
</div>
<?php endif; ?>

<!-- Quick Create Modal -->
<div class="modal-overlay" id="quickCreateModal">
  <div class="modal modal-md">
    <div class="modal-header">
      <span class="modal-title">Quick Create Project</span>
      <button class="modal-close" onclick="closeModal('quickCreateModal')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="modal-body">
      <p class="text-muted text-sm mb-2">Use the full form for all options.</p>
      <a href="/projects/create" class="btn btn-primary">Go to Create Project</a>
    </div>
  </div>
</div>
