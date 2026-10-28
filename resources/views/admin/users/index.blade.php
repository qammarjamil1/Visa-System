<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Users – Admin</title>
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
.main{margin-left:240px;flex:1;padding:28px}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px}
.topbar h1{font-size:1.3rem;font-weight:700}
.table-card{background:var(--card);border:1px solid var(--border);border-radius:12px;overflow:hidden}
.table-head{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px}
.table-head h3{font-size:.95rem;font-weight:600}
.filter-bar{display:flex;gap:10px;align-items:center}
.search-wrap{position:relative}
.search-wrap i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text2);font-size:.8rem}
.search-input{padding:8px 12px 8px 32px;background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:8px;color:var(--text);font-family:'Outfit',sans-serif;font-size:.83rem;outline:none;min-width:200px}
.search-input:focus{border-color:var(--gold)}
table{width:100%;border-collapse:collapse}
thead th{padding:12px 16px;text-align:left;font-size:.7rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--text2);border-bottom:1px solid var(--border);background:rgba(255,255,255,0.02)}
tbody td{padding:12px 16px;font-size:.85rem;border-bottom:1px solid rgba(201,168,76,0.05);vertical-align:middle}
tbody tr:last-child td{border-bottom:none}
tbody tr:hover{background:rgba(201,168,76,0.02)}
.badge{display:inline-flex;padding:3px 10px;border-radius:100px;font-size:.7rem;font-weight:700}
.badge-blue{background:rgba(59,130,246,0.15);color:#3b82f6}
.btn{display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border-radius:7px;font-size:.78rem;font-weight:600;cursor:pointer;border:none;font-family:'Outfit',sans-serif;transition:all .2s}
.btn-gold{background:var(--gold);color:#000}
.btn-gold:hover{background:#f0c96e}
.btn-danger{background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.2)}
.empty-msg{text-align:center;color:var(--text2);padding:32px}
.pagination-wrap{padding:14px 20px;border-top:1px solid var(--border);display:flex;justify-content:flex-end}
.alert{padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:.88rem;display:flex;align-items:center;gap:8px}
.alert-success{background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);color:#22c55e}
.avatar{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--gold),#f0c96e);display:flex;align-items:center;justify-content:center;font-weight:700;color:#000;font-size:.85rem}
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
  <a href="{{ route('myadmin.users') }}" class="nav-item active"><i class="fas fa-users"></i> Users</a>
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
  <div class="topbar">
    <h1><i class="fas fa-users" style="color:var(--gold);margin-right:8px"></i>Users</h1>
  </div>

  @if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
  @endif

  <div class="table-card">
    <div class="table-head">
      <h3>All Users</h3>
      <form method="GET" class="filter-bar">
        <div class="search-wrap">
          <i class="fas fa-search"></i>
          <input type="text" name="search" class="search-input" placeholder="Search name or email..." value="{{ request('search') }}">
        </div>
        <button class="btn btn-gold" type="submit"><i class="fas fa-search"></i></button>
      </form>
    </div>
    <div style="overflow-x:auto">
      <table>
        <thead>
          <tr><th>#</th><th>Name</th><th>Email</th><th>Applications</th><th>Joined</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @forelse($users as $user)
          <tr>
            <td style="color:var(--text2)">{{ $user->id }}</td>
            <td>
              <div style="display:flex;align-items:center;gap:10px">
                <div class="avatar">{{ strtoupper(substr($user->name,0,1)) }}</div>
                <span style="font-weight:600">{{ $user->name }}</span>
              </div>
            </td>
            <td style="color:var(--text2);font-size:.85rem">{{ $user->email }}</td>
            <td><span class="badge badge-blue">{{ $user->applications_count }} apps</span></td>
            <td style="color:var(--text2);font-size:.82rem">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
            <td style="display:flex;gap:6px">
              <span style="color:var(--text2);font-size:.78rem">—</span>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="empty-msg">No users found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="pagination-wrap">{{ $users->links('vendor.pagination.simple-clean') }}</div>
  </div>
</div>
</body>
</html>