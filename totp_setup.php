<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Set Up Authenticator — <?= APP_NAME ?></title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',system-ui,sans-serif;background:linear-gradient(135deg,#f0f4ff,#e8f4fd);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1rem}
.wrap{width:100%;max-width:520px}
.card{background:#fff;border-radius:20px;box-shadow:0 8px 40px rgba(59,130,246,.12);padding:2.5rem}
.badge-step{display:inline-flex;align-items:center;gap:.375rem;background:#eff6ff;color:#1e40af;font-size:.7rem;font-weight:700;padding:.3rem .75rem;border-radius:99px;text-transform:uppercase;letter-spacing:.06em;margin-bottom:1.25rem}
h2{font-size:1.125rem;font-weight:800;color:#1e293b;margin-bottom:.5rem}
.subtitle{color:#64748b;font-size:.875rem;line-height:1.6;margin-bottom:1.5rem}
.steps{list-style:none;counter-reset:step;display:flex;flex-direction:column;gap:.5rem;margin-bottom:1.75rem}
.steps li{display:flex;align-items:flex-start;gap:.875rem;padding:.75rem 1rem;background:#f8fafc;border-radius:10px;font-size:.875rem;color:#374151;counter-increment:step}
.steps li::before{content:counter(step);width:24px;height:24px;background:linear-gradient(135deg,#1e40af,#3b82f6);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:800;flex-shrink:0;margin-top:.125rem}
.qr-box{text-align:center;margin:1.5rem 0}
.qr-box img{border-radius:12px;border:3px solid #e2e8f0;padding:6px}
.secret-box{background:#f8fafc;border:1px dashed #cbd5e1;border-radius:10px;padding:.75rem 1rem;text-align:center;margin:.875rem auto 0;max-width:340px}
.secret-label{font-size:.7rem;color:#94a3b8;display:block;margin-bottom:.25rem}
.secret-val{font-family:monospace;font-size:.875rem;color:#1e40af;font-weight:600;letter-spacing:.1em;word-break:break-all}
.copy-btn{background:none;border:none;color:#3b82f6;font-size:.75rem;font-weight:600;cursor:pointer;margin-top:.375rem;font-family:inherit}
.code-inputs{display:flex;gap:.5rem;justify-content:center;margin:1.5rem 0 .25rem}
.ci{width:52px;height:60px;border:2px solid #e2e8f0;border-radius:10px;text-align:center;font-size:1.5rem;font-weight:700;color:#1e293b;-moz-appearance:textfield;transition:border-color .15s}
.ci:focus{outline:none;border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.12)}
.ci::-webkit-outer-spin-button,.ci::-webkit-inner-spin-button{-webkit-appearance:none}
.hint{text-align:center;font-size:.8125rem;color:#64748b;margin-bottom:1.25rem;font-weight:600}
.btn{display:flex;align-items:center;justify-content:center;gap:.5rem;width:100%;padding:.75rem;border:none;border-radius:10px;font-size:.9375rem;font-weight:700;cursor:pointer;transition:opacity .15s;font-family:inherit}
.btn-primary{background:linear-gradient(135deg,#1e40af,#3b82f6);color:#fff;box-shadow:0 4px 12px rgba(59,130,246,.35)}
.btn-primary:hover:not(:disabled){opacity:.92}
.btn-primary:disabled{opacity:.55;cursor:not-allowed}
.alert-danger{padding:.75rem 1rem;border-radius:10px;font-size:.875rem;margin-bottom:1.25rem;background:#fef2f2;color:#b91c1c;border:1px solid #fecaca}
.back{display:block;text-align:center;margin-top:1rem;font-size:.8125rem;color:#3b82f6;text-decoration:none;font-weight:500}
</style>
</head>
<body>
<div class="wrap">
  <div class="card">
    <div class="badge-step">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
      </svg>
      First-Time Security Setup
    </div>

    <h2>Set Up Microsoft Authenticator</h2>
    <p class="subtitle">
      Your account requires two-factor authentication. Follow the steps below to link your Microsoft Authenticator app.
    </p>

    <?php if ($error = flash('error')): ?>
      <div class="alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <ol class="steps">
      <li>Install <strong>Microsoft Authenticator</strong> from the App Store or Google Play</li>
      <li>Tap <strong>"+"</strong> → <strong>"Work or school account"</strong> → <strong>"Scan QR code"</strong></li>
      <li>Scan the QR code below with your phone camera</li>
      <li>Enter the 6-digit code shown in the app to confirm</li>
    </ol>

    <div class="qr-box">
      <img src="<?= e($qrUrl) ?>" width="220" height="220" alt="Authenticator QR Code">
      <div class="secret-box">
        <span class="secret-label">Manual entry key (if QR scan fails)</span>
        <div class="secret-val"><?= e($secret) ?></div>
        <button type="button" class="copy-btn" onclick="copySecret()">📋 Copy key</button>
      </div>
    </div>

    <form method="POST" action="/auth/totp-setup" id="setupForm">
      <?= csrf_field() ?>
      <p class="hint">Enter the 6-digit code from Microsoft Authenticator</p>
      <div class="code-inputs" id="codeInputs">
        <?php for ($i = 0; $i < 6; $i++): ?>
          <input type="number" class="ci" maxlength="1" min="0" max="9"
                 data-idx="<?= $i ?>" tabindex="<?= $i + 1 ?>" autocomplete="off">
        <?php endfor; ?>
      </div>
      <input type="hidden" name="code" id="codeHidden">
      <button type="submit" class="btn btn-primary" id="verifyBtn" disabled>
        Verify &amp; Activate 2FA
      </button>
    </form>

    <a href="/login" class="back">← Back to Login</a>
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

function copySecret() {
  navigator.clipboard.writeText('<?= addslashes(e($secret)) ?>').then(() => alert('Key copied!'));
}

document.getElementById('setupForm').addEventListener('submit', () => {
  btn.disabled = true; btn.textContent = 'Verifying…';
});

inputs[0].focus();
</script>
</body>
</html>
