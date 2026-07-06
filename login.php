<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Sign In — <?= APP_NAME ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',system-ui,sans-serif;background:linear-gradient(135deg,#f0f4ff 0%,#e8f4fd 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1rem}
.wrap{width:100%;max-width:420px}
.card{background:#fff;border-radius:20px;box-shadow:0 8px 40px rgba(59,130,246,.12);padding:2.5rem}
.logo{display:flex;align-items:center;gap:.875rem;justify-content:center;margin-bottom:2rem}
.logo-icon{width:48px;height:48px;background:linear-gradient(135deg,#1e40af,#3b82f6);border-radius:14px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(59,130,246,.4)}
.logo-icon svg{width:26px;height:26px;color:#fff}
.logo-text{font-size:1.625rem;font-weight:800;color:#0f172a;letter-spacing:-.5px}
.logo-text span{color:#3b82f6}
.logo-sub{font-size:.65rem;color:#94a3b8;text-transform:uppercase;letter-spacing:.12em;margin-top:-2px}
h2{font-size:1.125rem;font-weight:700;color:#1e293b;text-align:center;margin-bottom:.375rem}
.subtitle{text-align:center;font-size:.8125rem;color:#64748b;margin-bottom:1.75rem}
.form-group{margin-bottom:1.125rem}
.form-label{display:block;font-size:.8125rem;font-weight:600;color:#374151;margin-bottom:.375rem}
.form-control{width:100%;padding:.625rem .875rem;border:1.5px solid #e2e8f0;border-radius:10px;font-size:.9375rem;color:#1e293b;font-family:inherit;transition:border-color .15s,box-shadow .15s;background:#fff}
.form-control:focus{outline:none;border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.12)}
.pw-wrap{position:relative}
.pw-wrap .form-control{padding-right:2.75rem}
.pw-toggle{position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;padding:0;display:flex}
.btn{display:flex;align-items:center;justify-content:center;gap:.5rem;width:100%;padding:.75rem;border:none;border-radius:10px;font-size:.9375rem;font-weight:700;cursor:pointer;transition:opacity .15s;font-family:inherit}
.btn-primary{background:linear-gradient(135deg,#1e40af,#3b82f6);color:#fff;box-shadow:0 4px 12px rgba(59,130,246,.35)}
.btn-primary:hover{opacity:.92}
.btn-primary:disabled{opacity:.6;cursor:not-allowed}
.alert{padding:.75rem 1rem;border-radius:10px;font-size:.875rem;margin-bottom:1.25rem;display:flex;align-items:flex-start;gap:.5rem}
.alert-danger{background:#fef2f2;color:#b91c1c;border:1px solid #fecaca}
.alert-success{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
.security-note{display:flex;align-items:center;gap:.5rem;margin-top:1.25rem;padding:.625rem .875rem;background:#f8fafc;border-radius:10px;font-size:.75rem;color:#64748b}
.security-note svg{flex-shrink:0;color:#3b82f6}
.footer{text-align:center;margin-top:1.5rem;font-size:.75rem;color:#94a3b8}
</style>
</head>
<body>
<div class="wrap">
  <div class="card">
    <div class="logo">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
        </svg>
      </div>
      <div>
        <div class="logo-text">STARK <span>ERP</span></div>
        <div class="logo-sub">Enterprise Platform</div>
      </div>
    </div>

    <h2>Welcome back</h2>
    <p class="subtitle">Sign in to your workspace</p>

    <?php if ($error = flash('error')): ?>
      <div class="alert alert-danger">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <?= e($error) ?>
      </div>
    <?php endif; ?>
    <?php if ($success = flash('success')): ?>
      <div class="alert alert-success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <?= e($success) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="/login" id="loginForm">
      <?= csrf_field() ?>
      <div class="form-group">
        <label class="form-label" for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-control"
               placeholder="you@starkcommun.in" required autocomplete="email"
               value="<?= e($_POST['email'] ?? '') ?>">
      </div>
      <div class="form-group" style="margin-bottom:1.5rem">
        <label class="form-label" for="password">Password</label>
        <div class="pw-wrap">
          <input type="password" id="password" name="password" class="form-control"
                 placeholder="••••••••" required autocomplete="current-password">
          <button type="button" class="pw-toggle" onclick="togglePwd(this)" tabindex="-1">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" id="submitBtn">
        Sign In
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
      </button>
    </form>

    <div class="security-note">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
      </svg>
      Microsoft Authenticator 2FA required on first sign-in
    </div>
  </div>
  <p class="footer">&copy; <?= date('Y') ?> Stark Communication Pvt Ltd &nbsp;·&nbsp; v<?= APP_VERSION ?></p>
</div>
<script>
function togglePwd(btn){
  const p=document.getElementById('password');
  p.type=p.type==='password'?'text':'password';
}
document.getElementById('loginForm').addEventListener('submit',function(){
  document.getElementById('submitBtn').disabled=true;
  document.getElementById('submitBtn').innerHTML='Signing in…';
});
</script>
</body>
</html>
