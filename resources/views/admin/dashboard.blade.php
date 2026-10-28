<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
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
.nav-item{display:flex;align-items:center;gap:10px;padding:10px 16px;font-size:.88rem;color:var(--text2);transition:all .2s;cursor:pointer}
.nav-item:hover,.nav-item.active{background:rgba(201,168,76,0.1);color:var(--gold);border-left:3px solid var(--gold)}
.nav-item i{width:16px}
.msg-badge{margin-left:auto;background:#ef4444;color:#fff;font-size:.65rem;font-weight:700;padding:2px 7px;border-radius:100px}
.sidebar-footer{margin-top:auto;padding:16px;border-top:1px solid var(--border)}
.logout-btn{display:flex;align-items:center;gap:8px;width:100%;padding:10px;border-radius:8px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#ef4444;font-size:.85rem;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif}
.main{margin-left:240px;flex:1;padding:28px}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px}
.topbar h1{font-size:1.3rem;font-weight:700}
.topbar span{color:var(--text2);font-size:.88rem}
.stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px}
.stat-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:20px;display:flex;align-items:center;gap:14px;transition:all .3s}
.stat-card:hover{transform:translateY(-3px);border-color:rgba(201,168,76,0.3)}
.stat-icon{width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0}
.gold-bg{background:rgba(201,168,76,0.15);color:var(--gold)}
.green-bg{background:rgba(34,197,94,0.15);color:#22c55e}
.red-bg{background:rgba(239,68,68,0.15);color:#ef4444}
.blue-bg{background:rgba(59,130,246,0.15);color:#3b82f6}
.yellow-bg{background:rgba(245,158,11,0.15);color:#f59e0b}
.purple-bg{background:rgba(168,85,247,0.15);color:#a855f7}
.stat-num{font-size:1.7rem;font-weight:700;line-height:1}
.stat-label{font-size:.72rem;color:var(--text2);margin-top:3px;text-transform:uppercase;letter-spacing:1px}
.table-card{background:var(--card);border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:24px}
.table-head{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center}
.table-head h3{font-size:.95rem;font-weight:600}
table{width:100%;border-collapse:collapse}
thead th{padding:12px 16px;text-align:left;font-size:.7rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--text2);border-bottom:1px solid var(--border);background:rgba(255,255,255,0.02)}
tbody td{padding:12px 16px;font-size:.85rem;border-bottom:1px solid rgba(201,168,76,0.05)}
tbody tr:last-child td{border-bottom:none}
tbody tr:hover{background:rgba(201,168,76,0.02)}
.badge{display:inline-flex;padding:3px 10px;border-radius:100px;font-size:.7rem;font-weight:700}
.badge-pending{background:rgba(245,158,11,0.15);color:#f59e0b}
.badge-approved{background:rgba(34,197,94,0.15);color:#22c55e}
.badge-rejected{background:rgba(239,68,68,0.15);color:#ef4444}
.badge-review{background:rgba(59,130,246,0.15);color:#3b82f6}
.btn{display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border-radius:7px;font-size:.78rem;font-weight:600;cursor:pointer;border:none;font-family:'Outfit',sans-serif;transition:all .2s}
.btn-gold{background:var(--gold);color:#000}
.btn-gold:hover{background:#f0c96e}
.btn-info{background:rgba(59,130,246,0.15);color:#3b82f6;border:1px solid rgba(59,130,246,0.2)}
.empty-msg{text-align:center;color:var(--text2);padding:32px}
.replied-badge{display:inline-flex;align-items:center;gap:4px;background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);color:#22c55e;font-size:.68rem;font-weight:700;padding:2px 8px;border-radius:100px}
</style>
</head>
<body>

<div class="sidebar">
  <div class="sidebar-logo">✈️ Visa<span>Go</span> <span style="font-size:.65rem;display:block;color:var(--text2);font-weight:400;letter-spacing:2px">ADMIN PANEL</span></div>

  <div class="nav-label">Main</div>
  <a href="{{ route('myadmin') }}" class="nav-item active"><i class="fas fa-chart-pie"></i> Dashboard</a>

  <div class="nav-label">Management</div>
  <a href="{{ route('myadmin.applications') }}" class="nav-item"><i class="fas fa-file-alt"></i> Applications</a>
  <a href="{{ route('myadmin.payments') }}" class="nav-item"><i class="fas fa-credit-card"></i> Payments</a>
  <a href="{{ route('myadmin.documents') }}" class="nav-item"><i class="fas fa-folder-open"></i> Documents</a>
  <a href="{{ route('myadmin.leads') }}" class="nav-item"><i class="fas fa-bullseye"></i> Leads</a>
  <a href="{{ route('myadmin.users') }}" class="nav-item"><i class="fas fa-users"></i> Users</a>
  <a href="{{ route('myadmin.messages') }}" class="nav-item">
    <i class="fas fa-envelope"></i> Messages
    @php $unread = \DB::table('contact_messages')->where('status','unread')->count(); @endphp
    @if($unread > 0)
      <span class="msg-badge">{{ $unread }}</span>
    @endif
  </a>

  <div class="nav-label">Settings</div>
<a href="{{ route('myadmin.credentials') }}" class="nav-item"><i class="fas fa-key"></i> Change Credentials</a>
<a href="{{ url('/') }}" class="nav-item" target="_blank"><i class="fas fa-globe"></i> View Website</a>

  <div class="sidebar-footer">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
  </div>
</div>

<div class="main">
  <div class="topbar">
    <div>
      <h1>Dashboard</h1>
      <span>Welcome back, {{ auth()->user()->name }}</span>
    </div>
    <span style="color:var(--text2);font-size:.85rem">{{ now()->format('d M Y') }}</span>
  </div>

  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-icon gold-bg"><i class="fas fa-file-alt"></i></div>
      <div><div class="stat-num">{{ $stats['total_applications'] }}</div><div class="stat-label">Total Applications</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon yellow-bg"><i class="fas fa-hourglass-half"></i></div>
      <div><div class="stat-num">{{ $stats['pending'] }}</div><div class="stat-label">Pending</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon green-bg"><i class="fas fa-check-circle"></i></div>
      <div><div class="stat-num">{{ $stats['approved'] }}</div><div class="stat-label">Approved</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon red-bg"><i class="fas fa-times-circle"></i></div>
      <div><div class="stat-num">{{ $stats['rejected'] }}</div><div class="stat-label">Rejected</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon blue-bg"><i class="fas fa-users"></i></div>
      <div><div class="stat-num">{{ $stats['total_users'] }}</div><div class="stat-label">Total Users</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon purple-bg"><i class="fas fa-envelope"></i></div>
      <div><div class="stat-num">{{ \DB::table('contact_messages')->where('status','unread')->count() }}</div><div class="stat-label">Unread Messages</div></div>
    </div>
  </div>

  <!-- RECENT APPLICATIONS -->
  <div class="table-card">
    <div class="table-head">
      <h3><i class="fas fa-file-alt" style="color:var(--gold);margin-right:8px"></i>Recent Applications</h3>
      <a href="{{ route('myadmin.applications') }}" class="btn btn-gold">View All</a>
    </div>
    <div style="overflow-x:auto">
      <table>
        <thead>
          <tr><th>#</th><th>Applicant</th><th>Email</th><th>Visa Type</th><th>Country</th><th>Status</th><th>Date</th><th>Action</th></tr>
        </thead>
        <tbody>
          @forelse($recent_applications as $app)
          <tr>
            <td style="color:var(--text2)">{{ $app->id }}</td>
            <td style="font-weight:600">{{ $app->user_name ?? '—' }}</td>
            <td style="color:var(--text2)">{{ $app->user_email ?? '—' }}</td>
            <td>{{ $app->visa_type ?? '—' }}</td>
            <td>{{ $app->country ?? '—' }}</td>
            <td>
              @php $s = $app->status ?? 'pending'; @endphp
              <span class="badge badge-{{ $s === 'under_review' ? 'review' : $s }}">{{ ucfirst(str_replace('_',' ',$s)) }}</span>
            </td>
            <td style="color:var(--text2)">{{ \Carbon\Carbon::parse($app->created_at)->format('d M Y') }}</td>
            <td><a href="/myadmin/applications/{{ $app->id }}" class="btn btn-info"><i class="fas fa-eye"></i></a></td>
          </tr>
          @empty
          <tr><td colspan="8" class="empty-msg">No applications yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- RECENT MESSAGES -->
  <div class="table-card">
    <div class="table-head">
      <h3><i class="fas fa-envelope" style="color:var(--gold);margin-right:8px"></i>Recent Messages</h3>
      <a href="{{ route('myadmin.messages') }}" class="btn btn-gold">View All</a>
    </div>
    <div style="overflow-x:auto">
      <table>
        <thead>
          <tr><th>#</th><th>Name</th><th>Email</th><th>Subject</th><th>Reply</th><th>Status</th><th>Date</th><th>Action</th></tr>
        </thead>
        <tbody>
          @forelse(\DB::table('contact_messages')->orderBy('created_at','desc')->take(5)->get() as $msg)
          <tr>
            <td style="color:var(--text2)">{{ $msg->id }}</td>
            <td style="font-weight:600">{{ $msg->name }}</td>
            <td style="color:var(--text2);font-size:.82rem">{{ $msg->email }}</td>
            <td>{{ Str::limit($msg->subject, 30) }}</td>
            <td>
              @if($msg->reply)
                <span class="replied-badge"><i class="fas fa-check"></i> Replied</span>
              @else
                <span style="color:var(--text2);font-size:.78rem">— Pending</span>
              @endif
            </td>
            <td>
              <span class="badge" style="{{ $msg->status==='unread' ? 'background:rgba(239,68,68,0.15);color:#ef4444' : 'background:rgba(34,197,94,0.15);color:#22c55e' }}">
                {{ ucfirst($msg->status) }}
              </span>
            </td>
            <td style="color:var(--text2);font-size:.82rem">{{ \Carbon\Carbon::parse($msg->created_at)->format('d M Y') }}</td>
            <td><a href="/myadmin/messages/{{ $msg->id }}" class="btn btn-info"><i class="fas fa-eye"></i></a></td>
          </tr>
          @empty
          <tr><td colspan="8" class="empty-msg">No messages yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
</body>
</html>