<?php /* views/users/profile.php */ ?>
<div class="page-header">
  <div><div class="page-heading">My Profile</div><div class="page-sub">Your account information</div></div>
</div>
<div style="display:grid;grid-template-columns:300px 1fr;gap:1.5rem;align-items:start">
  <div class="card" style="text-align:center">
    <div class="card-body">
      <div style="width:72px;height:72px;border-radius:18px;background:linear-gradient(135deg,#1e40af,#3b82f6);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.75rem;font-weight:900;margin:0 auto 1rem">
        <?= strtoupper(mb_substr($u['name'],0,1)) ?>
      </div>
      <div class="fw-700" style="font-size:1.125rem"><?= e($u['name']) ?></div>
      <div class="text-muted text-sm mt-1"><?= e($u['email']) ?></div>
      <div style="margin-top:.75rem"><?= status_badge($u['role']) ?></div>
      <div class="divider" style="border-top:1px solid var(--gray-100);margin:1rem 0"></div>
      <div style="text-align:left">
        <div style="display:flex;justify-content:space-between;padding:.5rem 0;border-bottom:1px solid var(--gray-50)"><span class="text-muted text-sm">Last Login</span><span class="text-sm fw-600"><?= $u['last_login_at'] ? fmt_date($u['last_login_at'],'d M Y') : 'Never' ?></span></div>
        <div style="display:flex;justify-content:space-between;padding:.5rem 0"><span class="text-muted text-sm">2FA Status</span><span><?= $u['totp_setup_done']??0 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Pending</span>' ?></span></div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><span class="card-title">Employee Details</span></div>
    <div class="card-body">
      <?php if ($emp): ?>
      <div class="form-row">
        <div><div class="section-title">Employee Code</div><div class="fw-600"><?= e($emp['employee_code']) ?></div></div>
        <div><div class="section-title">Department</div><div class="fw-600"><?= e($emp['department']??'—') ?></div></div>
        <div><div class="section-title">Designation</div><div class="fw-600"><?= e($emp['designation']??'—') ?></div></div>
        <div><div class="section-title">Phone</div><div class="fw-600"><?= e($emp['phone']??'—') ?></div></div>
        <div><div class="section-title">Date of Joining</div><div class="fw-600"><?= fmt_date($emp['date_of_joining']) ?></div></div>
        <div><div class="section-title">Date of Birth</div><div class="fw-600"><?= fmt_date($emp['date_of_birth']??null) ?></div></div>
      </div>
      <?php if ($emp['address']): ?>
        <div class="mt-2"><div class="section-title">Address</div><div class="text-sm" style="color:var(--gray-600)"><?= nl2br(e($emp['address'])) ?></div></div>
      <?php endif; ?>
      <?php else: ?>
        <div class="empty-state">No employee record linked to this account.</div>
      <?php endif; ?>
    </div>
  </div>
</div>
