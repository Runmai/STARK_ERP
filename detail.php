<?php /* views/projects/detail.php */ ?>
<script>window.PID = <?= (int)$project['id'] ?>;</script>

<div class="page-header">
  <div style="display:flex;align-items:center;gap:.875rem">
    <div style="width:42px;height:42px;border-radius:12px;background:<?= e($project['color_label']??'#6366f1') ?>;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:1.125rem;flex-shrink:0">
      <?= strtoupper(mb_substr($project['name'],0,1)) ?>
    </div>
    <div>
      <div class="page-heading"><?= e($project['name']) ?></div>
      <div class="page-sub" style="display:flex;align-items:center;gap:.5rem">
        <span class="text-xs fw-600 text-muted"><?= e($project['project_code']) ?></span>
        <?= status_badge($project['status']) ?>
        <?= priority_badge($project['priority']) ?>
        <?= status_badge($project['project_type']) ?>
      </div>
    </div>
  </div>
  <div class="flex gap-1">
    <button onclick="openModal('editProjectModal')" class="btn btn-secondary">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
      Edit
    </button>
    <a href="/projects" class="btn btn-secondary">← Back</a>
  </div>
</div>

<!-- Quick Stats -->
<div class="grid-4 mb-2">
  <div class="stat-card">
    <div class="stat-icon" style="background:#eff6ff"><svg viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
    <div><div class="stat-val"><?= count($members) ?></div><div class="stat-lbl">Team Members</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#fef3c7"><svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg></div>
    <div><div class="stat-val"><?= array_sum($todoStatMap) ?></div><div class="stat-lbl">Total Tasks</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#fee2e2"><svg viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg></div>
    <div><div class="stat-val"><?= $openTickets ?></div><div class="stat-lbl">Open Tickets</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#f0fdf4"><svg viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
    <div><div class="stat-val">₹<?= number_format($totalExpenses/1000,1) ?>K</div><div class="stat-lbl">Total Expenses</div></div>
  </div>
</div>

<!-- Tabs -->
<div class="tabs mb-2" id="projectTabs">
  <?php
  $tabs = [
    ['overview',     'Overview',      'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
    ['todos',        'To-Do Board',   'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
    ['calendar',     'Calendar',      'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
    ['chat',         'Chat',          'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
    ['messages',     'Message Board', 'M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z'],
    ['locations',    'Locations',     'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
    ['cameras',      'Cameras',       'M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
    ['updates',      'Daily Updates', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
    ['team',         'Team',          'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
    ['documents',    'Documents',     'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
    ['billing',      'Billing',       'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    ['maintenance',  'Maintenance',   'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
    ['reports',      'Reports',       'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
  ];
  foreach ($tabs as [$tid, $tlbl, $ticon]):
  ?>
  <button class="tab-btn <?= $activeTab===$tid?'active':'' ?>" data-tab="<?= $tid ?>"
          onclick="loadTab('<?= $tid ?>',<?= (int)$project['id'] ?>)">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="<?= $ticon ?>"/></svg>
    <?= $tlbl ?>
  </button>
  <?php endforeach; ?>
</div>

<!-- Tab Content -->
<div id="tabContent">
  <?php
  $pid = $project['id'];
  ob_start();
  include ROOT . "/views/projects/tabs/{$activeTab}.php";
  echo ob_get_clean();
  ?>
</div>

<!-- Edit Project Modal -->
<div class="modal-overlay" id="editProjectModal">
  <div class="modal modal-lg">
    <div class="modal-header">
      <span class="modal-title">Edit Project — <?= e($project['name']) ?></span>
      <button class="modal-close" onclick="closeModal('editProjectModal')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <form method="POST" action="/projects/<?= (int)$project['id'] ?>/update">
      <?= csrf_field() ?>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Project Name</label>
            <input type="text" name="name" class="form-control" value="<?= e($project['name']) ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label">Project Type</label>
            <select name="project_type" class="form-control">
              <?php foreach (PROJECT_TYPES as $k => $v): ?>
                <option value="<?= e($k) ?>" <?= $project['project_type']===$k?'selected':'' ?>><?= e($v) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Client Name</label>
            <input type="text" name="client_name" class="form-control" value="<?= e($project['client_name']??'') ?>">
          </div>
          <div class="form-group">
            <label class="form-label">Government Authority</label>
            <input type="text" name="government_authority" class="form-control" value="<?= e($project['government_authority']??'') ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
              <?php foreach (PROJECT_STATUSES as $k => $v): ?>
                <option value="<?= e($k) ?>" <?= $project['status']===$k?'selected':'' ?>><?= e($v) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Priority</label>
            <select name="priority" class="form-control">
              <?php foreach (PRIORITIES as $k => $v): ?>
                <option value="<?= e($k) ?>" <?= $project['priority']===$k?'selected':'' ?>><?= e($v) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="<?= e($project['start_date']??'') ?>">
          </div>
          <div class="form-group">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" value="<?= e($project['end_date']??'') ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Budget (₹)</label>
            <input type="number" name="budget" class="form-control" value="<?= e($project['budget']??0) ?>" min="0" step="0.01">
          </div>
          <div class="form-group">
            <label class="form-label">Completion %</label>
            <input type="number" name="completion_percent" class="form-control" value="<?= (int)($project['completion_percent']??0) ?>" min="0" max="100">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Project Manager</label>
            <select name="project_manager" class="form-control">
              <option value="">— None —</option>
              <?php foreach ($employees as $emp): ?>
                <option value="<?= (int)$emp['id'] ?>" <?= $project['project_manager']==$emp['id']?'selected':'' ?>><?= e($emp['first_name'].' '.$emp['last_name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Color Label</label>
            <input type="color" name="color_label" class="form-control" value="<?= e($project['color_label']??'#6366f1') ?>" style="height:42px;padding:.25rem">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control auto-resize" rows="3"><?= e($project['description']??'') ?></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="closeModal('editProjectModal')" class="btn btn-secondary">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
    </form>
  </div>
</div>
