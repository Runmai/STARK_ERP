<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Verify Identity — <?= APP_NAME ?></title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',system-ui,sans-serif;background:linear-gradient(135deg,#f0f4ff,#e8f4fd);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1rem}
.wrap{width:100%;max-width:420px}
.card{background:#fff;border-radius:20px;box-shadow:0 8px 40px rgba(59,130,246,.12);padding:2.5rem;text-align:center}
.shield{width:72px;height:72px;background:linear-gradient(135deg,#eff6ff,#dbeafe);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem}
.shield svg{width:36px;height:36px;color:#1e40af}
h2{font-size:1.125rem;font-weight:800;color:#1e293b;margin-bottom:.5rem}
.subtitle{font-size:.875rem;color:#64748b;line-height:1.6;margin-bottom:1.75rem}
.code-inputs{display:flex;gap:.5rem;justify-content:center;margin-bottom:1.5rem}
.ci{width:52px;height:60px;border:2px solid #e2e8f0;border-radius:10px;text-align:center;font-size:1.5rem;font-weight:700;color:#1e293b;-moz-appearance:textfield;transition:border-color .15s}
.ci:focus{outline:none;border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.12)}
.ci::-webkit-outer-spin-button,.ci::-webkit-inner-spin-button{-webkit-appearance:none}
.btn{display:flex;align-items:center;justify-content:center;gap:.5rem;width:100%;padding:.75rem;border:none;border-radius:10px;font-size:.9375rem;font-weight:700;cursor:pointer;transition:opacity .15s;font-family:inherit}
.btn-primary{background:linear-gradient(135deg,#1e40af,#3b82f6);color:#fff;box-shadow:0 4px 12px rgba(59,130,246,.35)}
.btn-primary:hover:not(:disabled){opacity:.92}
.btn-primary:disabled{opacity:.55;cursor:not-allowed}
.alert-danger{padding:.75rem 1rem;border-radius:10px;font-size:.875rem;margin-bottom:1.25rem;background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;text-align:left}
.help{font-size:.8125rem;color:#94a3b8;margin-top:1.25rem;line-height:1.6}
.back{display:inline-block;margin-top:1rem;font-size:.8125rem;color:#3b82f6;text-decoration:none;font-weight:500}
.timer{font-size:.75rem;color:#94a3b8;margin-top:.75rem}
.timer span{color:#3b82f6;font-weight:600}
</style>
</head>
<body>
<div class="wrap">
  <div class="card">
    <div class="shield">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
      </svg>
    </div>

    <h2>Two-Factor Verification</h2>
    <p class="subtitle">
      Open <strong>Microsoft Authenticator</strong> and enter the 6-digit code for<br>
      <strong><?= e($email) ?></strong>
    </p>

    <?php if ($error = flash('error')): ?>
      <div class="alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="/auth/totp-verify" id="verifyForm">
      <?= csrf_field() ?>
      <div class="code-inputs">
        <?php for ($i = 0; $i < 6; $i++): ?>
          <input type="number" class="ci" maxlength="1" min="0" max="9"
                 data-idx="<?= $i ?>" tabindex="<?= $i + 1 ?>" autocomplete="off">
        <?php endfor; ?>
      </div>
      <input type="hidden" name="code" id="codeHidden">
      <button type="submit" class="btn btn-primary" id="verifyBtn" disabled>Verify</button>
    </form>

    <div class="timer">Code refreshes in <span id="countdown">30</span>s</div>
    <p class="help">Make sure your phone clock is correctly synced.<br>Codes refresh every 30 seconds.</p>
    <a href="/login" class="back">← Use a different account</a>
  </div>
</div>
<script>
const inputs = [...document.querySelectorAll('.ci')];
const hidden = document.getElementById('codeHidden');
const btn    = document.getElementById('verifyBtn');

function sync() {
  const code = inputs.map(i => i.value).join('');
  hidden.value = code;
  btn.disabled = code.length < 6;
  if (code.length === 6) setTimeout(() => document.getElementById('verifyForm').submit(), 150);
}

inputs.forEach((inp, i) => {
  inp.addEventListener('input', () => {
    inp.value = inp.value.slice(-1);
    if (inp.value && i < 5) inputs[i + 1].focus();
    sync();
  });
  inp.addEventListener('keydown', e => {
    if (e.key === 'Backspace' && !inp.value && i > 0) inputs[i - 1].focus();
  });
  inp.addEventListener('paste', e => {
    e.preventDefault();
    const v = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
    [...v].forEach((c, j) => { if (inputs[j]) inputs[j].value = c; });
    inputs[Math.min(v.length, 5)].focus();
    sync();
  });
});

document.getElementById('verifyForm').addEventListener('submit', () => {
  btn.disabled = true; btn.textContent = 'Verifying…';
});

// 30-second countdown
(function tick() {
  const secs = 30 - (Math.floor(Date.now() / 1000) % 30);
  document.getElementById('countdown').textContent = secs;
  setTimeout(tick, 1000);
})();

inputs[0].focus();
</script>
</body>
</html>
