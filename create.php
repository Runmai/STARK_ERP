<?php /* views/projects/create.php */ ?>
<div class="page-header">
  <div>
    <div class="page-heading">Create Project</div>
    <div class="page-sub">Fill in the details to create a new project</div>
  </div>
  <a href="/projects" class="btn btn-secondary">← Back to Projects</a>
</div>

<form method="POST" action="/projects/store">
  <?= csrf_field() ?>
  <div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:start">

    <!-- Left Column -->
    <div style="display:flex;flex-direction:column;gap:1rem">
      <div class="card">
        <div class="card-header"><span class="card-title">Project Information</span></div>
        <div class="card-body">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Project Name <span class="req">*</span></label>
              <input type="text" name="name" class="form-control" required placeholder="e.g. City CCTV Phase 2">
            </div>
            <div class="form-group">
              <label class="form-label">Project Type <span class="req">*</span></label>
              <select name="project_type" class="form-control" required>
                <?php foreach (PROJECT_TYPES as $k => $v): ?>
                  <option value="<?= e($k) ?>"><?= e($v) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Client Name</label>
              <input type="text" name="client_name" class="form-control" placeholder="Client / Organisation">
            </div>
            <div class="form-group">
              <label class="form-label">Government Authority</label>
              <input type="text" name="government_authority" class="form-control" placeholder="e.g. Municipal Corporation">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control auto-resize" rows="3" placeholder="Project scope and objectives…"></textarea>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header"><span class="card-title">Schedule & Budget</span></div>
        <div class="card-body">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Start Date <span class="req">*</span></label>
              <input type="date" name="start_date" class="form-control" required value="<?= date('Y-m-d') ?>">
            </div>
            <div class="form-group">
              <label class="form-label">End Date</label>
              <input type="date" name="end_date" class="form-control">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Budget (₹)</label>
              <div class="input-group">
                <span class="input-prefix">₹</span>
                <input type="number" name="budget" class="form-control" min="0" step="0.01" placeholder="0.00">
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Color Label</label>
              <input type="color" name="color_label" class="form-control" value="#6366f1" style="height:42px;padding:.25rem">
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header"><span class="card-title">Team Members</span></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Select Team Members</label>
            <select name="members[]" class="form-control" multiple style="height:140px">
              <?php foreach ($employees as $emp): ?>
                <option value="<?= (int)$emp['id'] ?>"><?= e($emp['first_name'].' '.$emp['last_name']) ?> — <?= e($emp['designation'] ?? '') ?></option>
              <?php endforeach; ?>
            </select>
            <div class="form-hint">Hold Ctrl/Cmd to select multiple</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div style="display:flex;flex-direction:column;gap:1rem">
      <div class="card">
        <div class="card-header"><span class="card-title">Settings</span></div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
              <?php foreach (PROJECT_STATUSES as $k => $v): ?>
                <option value="<?= e($k) ?>" <?= $k==='planning'?'selected':'' ?>><?= e($v) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Priority</label>
            <select name="priority" class="form-control">
              <?php foreach (PRIORITIES as $k => $v): ?>
                <option value="<?= e($k) ?>" <?= $k==='medium'?'selected':'' ?>><?= e($v) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Project Manager</label>
            <select name="project_manager" class="form-control">
              <option value="">— Select Manager —</option>
              <?php foreach ($employees as $emp): ?>
                <option value="<?= (int)$emp['id'] ?>"><?= e($emp['first_name'].' '.$emp['last_name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4v16m8-8H4"/></svg>
            Create Project
          </button>
          <a href="/projects" class="btn btn-secondary mt-1" style="width:100%;justify-content:center">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</form>
