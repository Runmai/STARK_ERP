<?php /* views/users/index.php */ ?>
<div class="page-header">
  <div><div class="page-heading">User Management</div><div class="page-sub"><?= count($users) ?> users</div></div>
  <button onclick="openModal('addUserModal')" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4v16m8-8H4"/></svg>
    Add User
  </button>
</div>

<div class="card">
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Department</th><th>Status</th><th>Last Login</th><th>2FA</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:.625rem">
              <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#1e40af,#3b82f6);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;flex-shrink:0">
                <?= strtoupper(mb_substr($u['name'],0,1)) ?>
              </div>
              <span class="fw-600"><?= e($u['name']) ?></span>
            </div>
          </td>
          <td class="text-muted"><?= e($u['email']) ?></td>
          <td><?= status_badge($u['role']) ?></td>
          <td class="text-muted"><?= e($u['department']??'—') ?></td>
          <td><?= $u['is_active'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?></td>
          <td class="text-muted text-xs"><?= $u['last_login_at'] ? fmt_date($u['last_login_at'],'d M Y H:i') : 'Never' ?></td>
          <td><?= $u['totp_setup_done'] ? '<span class="badge badge-success">✓ Set</span>' : '<span class="badge badge-warning">Pending</span>' ?></td>
          <td>
            <div class="table-actions">
              <form method="POST" action="/users/<?= (int)$u['id'] ?>/toggle" style="display:inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-sm <?= $u['is_active']?'btn-warning':'btn-success' ?>"><?= $u['is_active']?'Disable':'Enable' ?></button>
              </form>
              <form method="POST" action="/users/<?= (int)$u['id'] ?>/reset-totp" style="display:inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Reset 2FA for this user?')">Reset 2FA</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal-overlay" id="addUserModal">
  <div class="modal modal-md">
    <div class="modal-header">
      <span class="modal-title">Add New User</span>
      <button class="modal-close" onclick="closeModal('addUserModal')"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    <form method="POST" action="/users/store">
      <?= csrf_field() ?>
      <div class="modal-body">
        <div class="form-group"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-control" required placeholder="John Doe"></div>
        <div class="form-group"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" required placeholder="user@starkcommun.in"></div>
        <div class="form-group"><label class="form-label">Password *</label><input type="password" name="password" class="form-control" required minlength="8" placeholder="Min 8 characters"></div>
        <div class="form-group">
          <label class="form-label">Role *</label>
          <select name="role" class="form-control" required>
            <option value="engineer">Engineer</option>
            <option value="project_manager">Project Manager</option>
            <option value="management">Management</option>
            <option value="accounts">Accounts</option>
            <option value="super_admin">Super Admin</option>
          </select>
        </div>
        <div class="alert alert-info"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>User will set up Microsoft Authenticator on first login.</div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="closeModal('addUserModal')" class="btn btn-secondary">Cancel</button>
        <button type="submit" class="btn btn-primary">Create User</button>
      </div>
    </form>
  </div>
</div>
