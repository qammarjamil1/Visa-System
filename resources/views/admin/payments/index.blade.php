<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payments – Admin</title>
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
.table-card{background:var(--card);border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:24px;transition:border-color .3s}
.table-card:hover{border-color:rgba(201,168,76,0.3)}
.table-head{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px}
.table-head h3{font-size:.95rem;font-weight:600}
.filter-select{padding:8px 12px;background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:8px;color:var(--text);font-family:'Outfit',sans-serif;font-size:.83rem;outline:none;cursor:pointer;transition:border-color .2s}
.filter-select:focus{border-color:var(--gold)}
.filter-select option{background:#111120}
table{width:100%;border-collapse:collapse}
thead th{padding:12px 16px;text-align:left;font-size:.7rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--text2);border-bottom:1px solid var(--border);background:rgba(255,255,255,0.02)}
tbody td{padding:12px 16px;font-size:.85rem;border-bottom:1px solid rgba(201,168,76,0.05);vertical-align:middle}
tbody tr:last-child td{border-bottom:none}
tbody tr{transition:background .2s}
tbody tr:hover{background:rgba(201,168,76,0.05)}
.badge{display:inline-flex;padding:3px 10px;border-radius:100px;font-size:.7rem;font-weight:700}
.badge-pending{background:rgba(245,158,11,0.15);color:#f59e0b}
.badge-completed{background:rgba(34,197,94,0.15);color:#22c55e}
.method-chip{display:inline-flex;align-items:center;gap:4px;font-size:.8rem;font-weight:600}
.btn{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:7px;font-size:.78rem;font-weight:600;cursor:pointer;border:none;font-family:'Outfit',sans-serif;transition:all .2s}
.btn-gold{background:var(--gold);color:#000}
.btn-gold:hover{background:#f0c96e;transform:translateY(-1px)}
.empty-msg{text-align:center;color:var(--text2);padding:32px}
.pagination-wrap{padding:14px 20px;border-top:1px solid var(--border)}
.alert{padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:.88rem;display:flex;align-items:center;gap:8px;animation:slideIn .3s ease}
.alert-success{background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);color:#22c55e}
@keyframes slideIn{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
</style>
</head>
<body>

<div class="sidebar">
  <div class="sidebar-logo">✈️ Visa<span>Go</span><span style="font-size:.65rem;display:block;color:var(--text2);font-weight:400;letter-spacing:2px">ADMIN PANEL</span></div>
  <div class="nav-label">Main</div>
  <a href="{{ route('myadmin') }}" class="nav-item"><i class="fas fa-chart-pie"></i> Dashboard</a>
  <div class="nav-label">Management</div>
  <a href="{{ route('myadmin.applications') }}" class="nav-item"><i class="fas fa-file-alt"></i> Applications</a>
  <a href="{{ route('myadmin.payments') }}" class="nav-item active"><i class="fas fa-credit-card"></i> Payments</a>
  <a href="{{ route('myadmin.documents') }}" class="nav-item"><i class="fas fa-folder-open"></i> Documents</a>
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
  <div class="topbar">
    <h1><i class="fas fa-credit-card" style="color:var(--gold);margin-right:8px"></i>Payments</h1>
  </div>

  @if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
  @endif

  <div class="table-card">
    <div class="table-head">
      <h3>All Payment Submissions</h3>
      <form method="GET">
        <select name="status" class="filter-select" onchange="this.form.submit()">
          <option value="all">All Status</option>
          <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending Verification</option>
          <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
        </select>
      </form>
    </div>
    <div style="overflow-x:auto">
      <table>
        <thead>
          <tr><th>#</th><th>User</th><th>Method</th><th>Sender Number</th><th>Transaction ID</th><th>Amount</th><th>Visa</th><th>Status</th><th>Date</th><th>Action</th></tr>
        </thead>
        <tbody>
          @forelse($payments as $p)
          <tr>
            <td style="color:var(--text2)">{{ $p->id }}</td>
            <td>
              <div style="font-weight:600">{{ $p->user_name }}</div>
              <div style="color:var(--text2);font-size:.78rem">{{ $p->user_email }}</div>
            </td>
            <td>
              <span class="method-chip">
                {{ $p->method === 'easypaisa' ? '📱 EasyPaisa' : '🏦 JazzCash' }}
              </span>
            </td>
            <td>{{ $p->sender_number }}</td>
            <td style="font-family:monospace">{{ $p->transaction_id }}</td>
            <td>PKR {{ number_format($p->amount) }}</td>
            <td>{{ $p->app_visa_type ? ucfirst($p->app_visa_type).' - '.$p->app_country : '—' }}</td>
            <td>
              <span class="badge badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span>
            </td>
            <td style="color:var(--text2);font-size:.8rem">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y, h:i A') }}</td>
            <td>
              @if($p->status !== 'completed')
              <form method="POST" action="{{ route('myadmin.payments.verify', $p->id) }}" onsubmit="return confirm('Mark this payment as verified?')">
                @csrf @method('PUT')
                <button class="btn btn-gold"><i class="fas fa-check"></i> Verify</button>
              </form>
              @else
              <span style="color:#22c55e;font-size:.8rem"><i class="fas fa-check-circle"></i> Verified</span>
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="10" class="empty-msg">No payments submitted yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="pagination-wrap">{{ $payments->withQueryString()->links('vendor.pagination.simple-clean') }}</div>
  </div>
</div>
</body>
</html>