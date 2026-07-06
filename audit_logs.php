<?php /* views/users/audit_logs.php */ ?>
<div class="page-header">
  <div><div class="page-heading">Audit Logs</div><div class="page-sub"><?= number_format($pg['total']) ?> total entries</div></div>
</div>
<div class="card">
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Time</th><th>User</th><th>Action</th><th>Entity</th><th>Description</th><th>IP</th></tr></thead>
      <tbody>
        <?php foreach ($logs as $l): ?>
        <tr>
          <td class="text-xs text-muted" style="white-space:nowrap"><?= fmt_date($l['created_at'],'d M Y H:i') ?></td>
          <td class="fw-600"><?= e($l['user_name']??'System') ?></td>
          <td><span class="badge badge-secondary"><?= e($l['action']) ?></span></td>
          <td class="text-muted"><?= e($l['entity_type']??'—') ?> <?= $l['entity_id']?'#'.$l['entity_id']:'' ?></td>
          <td class="text-sm"><?= e(mb_substr($l['description']??'',0,80)) ?></td>
          <td class="text-xs text-muted"><?= e($l['ip_address']??'—') ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (!$logs): ?><tr><td colspan="6"><div class="empty-state" style="padding:2rem">No logs found.</div></td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php if ($pg['last_page']>1): ?>
<div style="display:flex;justify-content:center;gap:.375rem;margin-top:1.5rem">
  <?php for ($i=1;$i<=$pg['last_page'];$i++): ?>
    <a href="?page=<?= $i ?>" class="btn btn-sm <?= $i===$pg['page']?'btn-primary':'btn-secondary' ?>"><?= $i ?></a>
  <?php endfor; ?>
</div>
<?php endif; ?>
