<?php /* views/users/employees.php */ ?>
<div class="page-header">
  <div><div class="page-heading">Employees</div><div class="page-sub"><?= count($employees) ?> active employees</div></div>
</div>
<div class="card">
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Employee</th><th>Code</th><th>Department</th><th>Designation</th><th>Phone</th><th>Joined</th><th>Status</th></tr></thead>
      <tbody>
        <?php if (!$employees): ?>
          <tr><td colspan="7"><div class="empty-state" style="padding:2rem">No employees found.</div></td></tr>
        <?php else: foreach ($employees as $emp): ?>
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:.625rem">
              <div style="width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,#1e40af,#3b82f6);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;flex-shrink:0">
                <?= strtoupper(mb_substr($emp['first_name'],0,1).mb_substr($emp['last_name'],0,1)) ?>
              </div>
              <div>
                <div class="fw-600"><?= e($emp['first_name'].' '.$emp['last_name']) ?></div>
                <div class="text-xs text-muted"><?= e($emp['email']??'') ?></div>
              </div>
            </div>
          </td>
          <td><span class="badge badge-secondary"><?= e($emp['employee_code']) ?></span></td>
          <td class="text-muted"><?= e($emp['department']??'—') ?></td>
          <td class="text-muted"><?= e($emp['designation']??'—') ?></td>
          <td class="text-muted"><?= e($emp['phone']??'—') ?></td>
          <td class="text-muted"><?= fmt_date($emp['date_of_joining']) ?></td>
          <td><?= $emp['user_active'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">No Account</span>' ?></td>
        </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
