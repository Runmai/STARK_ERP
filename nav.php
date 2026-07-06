<?php
use Core\Auth;
$role = Auth::role();
$uri  = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

function navLink(string $href, string $label, string $icon, string $uri, string $badge = ''): void {
    $a = str_starts_with($uri, $href) ? ' active' : '';
    echo '<a href="' . $href . '" class="nav-link' . $a . '">';
    echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="' . $icon . '"/></svg>';
    echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
    if ($badge) echo '<span class="nav-badge">' . $badge . '</span>';
    echo '</a>';
}

function navGroup(string $id, string $title, string $icon, array $links, string $uri): void {
    $active = array_filter($links, fn($l) => str_starts_with($uri, $l[0]));
    $open   = !empty($active);
    echo '<div class="nav-group">';
    echo '<div class="nav-group-title' . ($open ? '' : ' collapsed') . '" onclick="toggleNavGroup(\'' . $id . '\')">';
    echo '<span style="display:flex;align-items:center;gap:.375rem">';
    echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="' . $icon . '"/></svg>';
    echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    echo '</span>';
    echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 9l-7 7-7-7"/></svg>';
    echo '</div>';
    echo '<div id="' . $id . '" class="nav-links" style="' . ($open ? '' : 'display:none') . '">';
    foreach ($links as [$href, $label, $badge]) {
        navLink($href, $label, 'M0 0', $uri, $badge ?? '');
    }
    echo '</div></div>';
}
?>

<!-- Dashboard -->
<a href="/dashboard" class="nav-single <?= $uri === '/dashboard' ? 'active' : '' ?>">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
    <path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/>
  </svg>
  Dashboard
</a>

<!-- Projects section -->
<div class="nav-group">
  <div class="nav-group-title <?= str_starts_with($uri,'/projects') ? '' : 'collapsed' ?>"
       onclick="toggleNavGroup('ng_projects')">
    <span style="display:flex;align-items:center;gap:.375rem">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
      </svg>
      Projects
    </span>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 9l-7 7-7-7"/></svg>
  </div>
  <div id="ng_projects" class="nav-links" style="<?= str_starts_with($uri,'/projects') ? '' : 'display:none' ?>">
    <?php
    $pLinks = [
      ['/projects',        'All Projects',   ''],
      ['/projects/create', 'Create Project', ''],
    ];
    foreach ($pLinks as [$href, $lbl]) {
        $a = str_starts_with($uri, $href) && ($href !== '/projects' || $uri === '/projects') ? ' active' : '';
        echo '<a href="' . $href . '" class="nav-link' . $a . '">';
        echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>';
        echo $lbl . '</a>';
    }
    ?>
  </div>
</div>

<?php if (in_array($role, ['super_admin','project_manager','management'])): ?>
<!-- Employees -->
<a href="/employees" class="nav-single <?= str_starts_with($uri,'/employees') ? 'active' : '' ?>">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
    <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
    <circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
  </svg>
  Employees
</a>
<?php endif; ?>

<!-- Notifications -->
<a href="/notifications" class="nav-single <?= str_starts_with($uri,'/notifications') ? 'active' : '' ?>">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
    <path stroke-linecap="round" stroke-linejoin="round" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
    <path stroke-linecap="round" stroke-linejoin="round" d="M13.73 21a2 2 0 01-3.46 0"/>
  </svg>
  Notifications
</a>

<!-- Profile -->
<a href="/profile" class="nav-single <?= str_starts_with($uri,'/profile') ? 'active' : '' ?>">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
    <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
    <circle cx="12" cy="7" r="4"/>
  </svg>
  My Profile
</a>

<?php if ($role === 'super_admin'): ?>
<!-- Admin section -->
<div class="nav-group">
  <div class="nav-group-title <?= str_starts_with($uri,'/users') || str_starts_with($uri,'/audit') ? '' : 'collapsed' ?>"
       onclick="toggleNavGroup('ng_admin')">
    <span style="display:flex;align-items:center;gap:.375rem">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>
      </svg>
      Administration
    </span>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 9l-7 7-7-7"/></svg>
  </div>
  <div id="ng_admin" class="nav-links" style="<?= str_starts_with($uri,'/users') || str_starts_with($uri,'/audit') ? '' : 'display:none' ?>">
    <a href="/users" class="nav-link <?= str_starts_with($uri,'/users') ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg>
      User Management
    </a>
    <a href="/audit-logs" class="nav-link <?= str_starts_with($uri,'/audit') ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
      Audit Logs
    </a>
  </div>
</div>
<?php endif; ?>
