<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Status – Admin</title>
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
.back-link{color:var(--text2);font-size:.85rem;margin-bottom:16px;display:inline-flex;align-items:center;gap:6px}
.back-link:hover{color:var(--gold)}
.form-card{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:28px}
.form-card h1{font-size:1.2rem;margin-bottom:24px}
.form-group{margin-bottom:18px}
.form-group label{display:block;font-size:.75rem;color:var(--text2);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;font-weight:600}
.form-group select,.form-group textarea{width:100%;padding:12px 14px;background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:8px;color:var(--text);font-family:'Outfit',sans-serif;font-size:.9rem;outline:none}
.form-group select:focus,.form-group textarea:focus{border-color:var(--gold)}
.form-group select option{background:#111120}
.form-group textarea{min-height:100px;resize:vertical}
.btn{display:inline-flex;align-items:center;gap:6px;padding:12px 24px;border-radius:8px;font-size:.9rem;font-weight:700;cursor:pointer;border:none;font-family:'Outfit',sans-serif}
.btn-gold{background:var(--gold);color:#000}
.btn-gold:hover{background:#f0c96e}
</style>
</head>
<body>

<div class="sidebar">
  <div class="sidebar-logo">✈️ Visa<span>Go</span><span style="font-size:.65rem;display:block;color:var(--text2);font-weight:400;letter-spacing:2px">ADMIN PANEL</span></div>
  <div class="nav-label">Main</div>
  <a href="{{ route('myadmin') }}" class="nav-item"><i class="fas fa-chart-pie"></i> Dashboard</a>
  <div class="nav-label">Management</div>
  <a href="{{ route('myadmin.applications') }}" class="nav-item active"><i class="fas fa-file-alt"></i> Applications</a>
  <a href="{{ route('myadmin.payments') }}" class="nav-item"><i class="fas fa-credit-card"></i> Payments</a>
  <a href="{{ route('myadmin.leads') }}" class="nav-item"><i class="fas fa-bullseye"></i> Leads</a>
  <a href="{{ route('myadmin.users') }}" class="nav-item"><i class="fas fa-users"></i> Users</a>
  <a href="{{ route('myadmin.messages') }}" class="nav-item"><i class="fas fa-envelope"></i> Messages</a>
  <div class="nav-label">Settings</div>
  <a href="{{ route('myadmin.credentials') }}" class="nav-item"><i class="fas fa-key"></i> Change Credentials</a>
  <a href="{{ url('/') }}" class="nav-item" target="_blank"><i class="fas fa-globe"></i> View Website</a>
  <div class="sidebar-footer">
    <form method="POST" action="{{ route('logout') }}">@csrf
      <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
  </div>
</div>

<div class="main">
  <a href="{{ route('myadmin.applications.show', $app->id) }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Application</a>

  <div class="form-card">
    <h1>Update Application #{{ $app->id }}</h1>
    <form method="POST" action="{{ route('myadmin.applications.update', $app->id) }}">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label>Status</label>
        <select name="status">
          <option value="pending" {{ $app->status=='pending'?'selected':'' }}>Pending</option>
          <option value="under_review" {{ $app->status=='under_review'?'selected':'' }}>Under Review</option>
          <option value="approved" {{ $app->status=='approved'?'selected':'' }}>Approved</option>
          <option value="rejected" {{ $app->status=='rejected'?'selected':'' }}>Rejected</option>
        </select>
      </div>

      <div class="form-group">
        <label>Admin Notes (Optional)</label>
        <textarea name="admin_notes" placeholder="Add any internal notes about this application...">{{ $app->admin_notes ?? '' }}</textarea>
      </div>

      <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> Save Changes</button>
    </form>
  </div>
</div>
</body>
</html>