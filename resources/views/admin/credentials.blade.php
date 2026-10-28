<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Change Credentials – Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root{--gold:#C9A84C;--bg:#07070f;--sidebar:#0d0d1a;--card:#111120;--border:rgba(201,168,76,0.15);--text:#eeeef5;--text2:#8888aa;}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Outfit',sans-serif;background:var(--bg);color:var(--text);display:flex;min-height:100vh}
a{text-decoration:none;color:inherit}
.sidebar{width:240px;min-height:100vh;background:var(--sidebar);border-right:1px solid var(--border);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0}
.sidebar-logo{padding:20px;border-bottom:1px solid var(--border);font-size:1.2rem;font-weight:700}
.sidebar-logo span{color:var(--gold)}
.nav-label{font-size:.65rem;letter-spacing:2px;text-transform:uppercase;color:var(--text2);padding:16px 16px 6px}
.nav-item{display:flex;align-items:center;gap:10px;padding:10px 16px;font-size:.88rem;color:var(--text2);transition:all .2s}
.nav-item:hover,.nav-item.active{background:rgba(201,168,76,0.1);color:var(--gold);border-left:3px solid var(--gold)}
.nav-item i{width:16px}
.sidebar-footer{margin-top:auto;padding:16px;border-top:1px solid var(--border)}
.logout-btn{display:flex;align-items:center;gap:8px;width:100%;padding:10px;border-radius:8px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#ef4444;font-size:.85rem;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif}
.main{margin-left:240px;flex:1;padding:28px;max-width:600px}
.topbar h1{font-size:1.3rem;font-weight:700;margin-bottom:24px}
.form-card{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:28px;transition:border-color .3s}
.form-card:hover{border-color:rgba(201,168,76,0.3)}
.form-group{margin-bottom:18px}
.form-group label{display:block;font-size:.75rem;color:var(--text2);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;font-weight:600}
.form-group input{width:100%;padding:12px 14px;background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:8px;color:var(--text);font-family:'Outfit',sans-serif;font-size:.9rem;outline:none;transition:border-color .3s,background .3s}
.form-group input:focus{border-color:var(--gold);background:rgba(255,255,255,0.06)}
.form-hint{font-size:.75rem;color:var(--text2);margin-top:6px}
.btn{display:inline-flex;align-items:center;gap:6px;padding:12px 24px;border-radius:8px;font-size:.9rem;font-weight:700;cursor:pointer;border:none;font-family:'Outfit',sans-serif;transition:all .2s}
.btn-gold{background:var(--gold);color:#000}
.btn-gold:hover{background:#f0c96e;transform:translateY(-2px);box-shadow:0 6px 18px rgba(201,168,76,0.3)}
.alert{padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:.88rem;display:flex;align-items:center;gap:8px;animation:slideIn .3s ease}
.alert-success{background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);color:#22c55e}
@keyframes slideIn{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
.error-msg{color:#ef4444;font-size:.78rem;margin-top:6px}
.password-wrap{position:relative}
.password-wrap input{padding-right:42px}
.toggle-eye{position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--text2);transition:color .2s}
.toggle-eye:hover{color:var(--gold)}
</style>
</head>
<body>

<div class="sidebar">
  <div class="sidebar-logo">✈️ Visa<span>Go</span><span style="font-size:.65rem;display:block;color:var(--text2);font-weight:400;letter-spacing:2px">ADMIN PANEL</span></div>
  <div class="nav-label">Main</div>
  <a href="{{ route('myadmin') }}" class="nav-item"><i class="fas fa-chart-pie"></i> Dashboard</a>
  <div class="nav-label">Management</div>
  <a href="{{ route('myadmin.applications') }}" class="nav-item"><i class="fas fa-file-alt"></i> Applications</a>
  <a href="{{ route('myadmin.payments') }}" class="nav-item"><i class="fas fa-credit-card"></i> Payments</a>
  <a href="{{ route('myadmin.documents') }}" class="nav-item"><i class="fas fa-folder-open"></i> Documents</a>
  <a href="{{ route('myadmin.leads') }}" class="nav-item"><i class="fas fa-bullseye"></i> Leads</a>
  <a href="{{ route('myadmin.users') }}" class="nav-item"><i class="fas fa-users"></i> Users</a>
  <a href="{{ route('myadmin.messages') }}" class="nav-item"><i class="fas fa-envelope"></i> Messages</a>
  <div class="nav-label">Settings</div>
  <a href="{{ route('myadmin.credentials') }}" class="nav-item active"><i class="fas fa-key"></i> Change Credentials</a>
  <a href="{{ url('/') }}" class="nav-item" target="_blank"><i class="fas fa-globe"></i> View Website</a>
  <div class="sidebar-footer">
    <form method="POST" action="{{ route('logout') }}">@csrf
      <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
  </div>
</div>

<div class="main">
  <div class="topbar"><h1><i class="fas fa-key" style="color:var(--gold);margin-right:8px"></i>Change Credentials</h1></div>

  @if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
  @endif

  <div class="form-card">
    <form method="POST" action="{{ route('myadmin.credentials.update') }}">
      @csrf
      <div class="form-group">
        <label>Admin Email</label>
        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
        @error('email') <div class="error-msg">{{ $message }}</div> @enderror
      </div>
      <div class="form-group">
        <label>New Password (leave blank to keep current)</label>
        <div class="password-wrap">
          <input type="password" name="password" id="passwordField" placeholder="••••••••">
          <i class="fas fa-eye toggle-eye" id="toggleIcon1" onclick="togglePassword('passwordField','toggleIcon1')"></i>
        </div>
        <div class="form-hint">Minimum 6 characters</div>
        @error('password') <div class="error-msg">{{ $message }}</div> @enderror
      </div>
      <div class="form-group">
        <label>Confirm New Password</label>
        <div class="password-wrap">
          <input type="password" name="password_confirmation" id="passwordConfirmField" placeholder="••••••••">
          <i class="fas fa-eye toggle-eye" id="toggleIcon2" onclick="togglePassword('passwordConfirmField','toggleIcon2')"></i>
        </div>
      </div>
      <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> Update Credentials</button>
    </form>
  </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
</body>
</html>