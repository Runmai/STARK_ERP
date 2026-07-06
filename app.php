<?php
use Core\Auth;
use Core\Database;

$u         = Auth::user();
$initials  = strtoupper(
    mb_substr($u['name'] ?? 'U', 0, 1) .
    (str_contains($u['name'] ?? '', ' ')
        ? mb_substr(strrchr($u['name'], ' '), 1, 1)
        : '')
);
$roleLabel = role_label($u['role'] ?? '');
$unread    = (int) Database::fetchValue(
    'SELECT COUNT(*) FROM notifications WHERE user_id=? AND is_read=0',
    [$u['id']]
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf" content="<?= e(csrf_token()) ?>">
<title><?= e($pageTitle ?? 'Dashboard') ?> — <?= APP_NAME ?></title>
<link rel="stylesheet" href="/assets/css/app.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js" defer></script>
<script src="/assets/js/app.js" defer></script>
</head>
<body>
<div class="app-wrapper">

<!-- ═══ SIDEBAR ═══════════════════════════════════════════ -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <div class="brand-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
      </svg>
    </div>
    <div>
      <div class="brand-name">STARK <span>ERP</span></div>
      <div class="brand-sub">Enterprise Platform</div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <?php include ROOT . '/views/layouts/nav.php'; ?>
  </nav>

  <div class="sidebar-user">
    <div class="s-avatar"><?= e($initials) ?></div>
    <div style="flex:1;min-width:0">
      <div class="s-name"><?= e($u['name']) ?></div>
      <div class="s-role"><?= e($roleLabel) ?></div>
    </div>
    <form method="POST" action="/logout">
      <?= csrf_field() ?>
      <button type="submit" class="s-logout" title="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
        </svg>
      </button>
    </form>
  </div>
</aside>

<!-- ═══ MAIN ═══════════════════════════════════════════════ -->
<div class="main-content">

  <!-- Topbar -->
  <header class="topbar">
    <div class="topbar-left">
      <button class="topbar-btn" id="sidebarToggle" style="display:none" aria-label="Menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
      </button>
      <div>
        <div class="topbar-title"><?= e($pageTitle ?? 'Dashboard') ?></div>
        <?php if (!empty($breadcrumbs)): ?>
        <nav class="breadcrumb" aria-label="breadcrumb">
          <?php foreach ($breadcrumbs as $i => [$lbl, $url]): ?>
            <?php if ($i): ?>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            <?php endif; ?>
            <?php if ($url): ?><a href="<?= e($url) ?>"><?= e($lbl) ?></a>
            <?php else: ?><span><?= e($lbl) ?></span>
            <?php endif; ?>
          <?php endforeach; ?>
        </nav>
        <?php endif; ?>
      </div>
    </div>

    <div class="topbar-right">
      <!-- Notifications -->
      <div style="position:relative" id="notifWrapper">
        <button class="topbar-btn" id="notifBtn" aria-label="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>
          </svg>
          <?php if ($unread > 0): ?><span class="notif-dot"></span><?php endif; ?>
        </button>
        <div class="notif-dropdown" id="notifDropdown">
          <div class="notif-hdr">
            <span class="notif-hdr-title">
              Notifications
              <?php if ($unread): ?>
                <span class="badge badge-danger" style="margin-left:.375rem"><?= $unread ?></span>
              <?php endif; ?>
            </span>
            <a href="#" onclick="markAllRead(event)" style="font-size:.75rem;color:var(--blue);font-weight:600">Mark all read</a>
          </div>
          <div class="notif-list" id="notifList">
            <div class="notif-empty"><span class="spinner" style="display:block;margin:0 auto"></span></div>
          </div>
          <div class="notif-footer"><a href="/notifications">View all</a></div>
        </div>
      </div>

      <!-- User chip -->
      <div class="t-user" onclick="window.location='/profile'" role="button">
        <div class="t-avatar"><?= e($initials) ?></div>
        <div>
          <div class="t-name"><?= e(explode(' ', $u['name'])[0]) ?></div>
          <div class="t-role"><?= e($roleLabel) ?></div>
        </div>
      </div>
    </div>
  </header>

  <!-- Flash messages -->
  <?php $fe = flash('error'); $fs = flash('success'); ?>
  <?php if ($fe || $fs): ?>
  <div style="padding:.75rem 1.5rem 0">
    <?php if ($fs): ?>
      <div class="alert alert-success">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <?= e($fs) ?>
      </div>
    <?php endif; ?>
    <?php if ($fe): ?>
      <div class="alert alert-danger">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <?= e($fe) ?>
      </div>
    <?php endif; ?>
  </div>
  <?php endif; ?>

  <!-- Page content -->
  <main class="page-body">
    <?= $content ?? '' ?>
  </main>

</div><!-- /main-content -->
</div><!-- /app-wrapper -->
</body>
</html>
