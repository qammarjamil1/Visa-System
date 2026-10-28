<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Application Detail – Admin</title>
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
.main{margin-left:240px;flex:1;padding:28px;max-width:900px}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px}
.topbar h1{font-size:1.3rem;font-weight:700}
.back-link{color:var(--text2);font-size:.85rem;margin-bottom:16px;display:inline-flex;align-items:center;gap:6px}
.back-link:hover{color:var(--gold)}
.detail-card{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:28px;margin-bottom:20px}
.detail-card h3{font-size:.95rem;color:var(--gold);margin-bottom:18px;padding-bottom:12px;border-bottom:1px solid var(--border)}
.detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.detail-item label{font-size:.68rem;color:var(--text2);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:4px}
.detail-item div{font-size:.92rem;font-weight:600}
.badge{display:inline-flex;padding:4px 14px;border-radius:100px;font-size:.75rem;font-weight:700}
.badge-pending{background:rgba(245,158,11,0.15);color:#f59e0b}
.badge-approved{background:rgba(34,197,94,0.15);color:#22c55e}
.badge-rejected{background:rgba(239,68,68,0.15);color:#ef4444}
.badge-review{background:rgba(59,130,246,0.15);color:#3b82f6}
.btn{display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:8px;font-size:.85rem;font-weight:600;cursor:pointer;border:none;font-family:'Outfit',sans-serif;transition:all .2s;text-decoration:none}
.btn-gold{background:var(--gold);color:#000}
.btn-gold:hover{background:#f0c96e}
.doc-list{display:flex;flex-direction:column;gap:10px}
.doc-row{display:flex;align-items:center;gap:12px;padding:12px 16px;background:rgba(255,255,255,0.03);border-radius:10px;border:1px solid var(--border)}
.doc-row a{color:var(--gold);font-size:.85rem;margin-left:auto}
.empty-msg{color:var(--text2);font-size:.85rem;text-align:center;padding:20px}
</style>
</head>
<body>

<div class="sidebar">
  <div class="sidebar-logo">✈️ Visa<span>Go</span><span style="font-size:.65rem;display:block;color:var(--text2);font-weight:400;letter-spacing:2px">ADMIN PANEL</span></div>
  <div class="nav-label">Main</div>
  <a href="{{ route('myadmin') }}" class="nav-item"><i class="fas fa-chart-pie"></i> Dashboard</a>
  <div class="nav-label">Management</div>
  <a href="{{ route('myadmin.applications') }}" class="nav-item active"><i class="fas fa-file-alt"></i> Applications</a>
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
  <a href="{{ route('myadmin.applications') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Applications</a>
  <div class="topbar">
    <h1>Application #{{ $app->id }}</h1>
    <a href="{{ route('myadmin.applications.edit', $app->id) }}" class="btn btn-gold"><i class="fas fa-edit"></i> Update Status</a>
  </div>

  <div class="detail-card">
    <h3>👤 Applicant Info</h3>
    <div class="detail-grid">
      <div class="detail-item"><label>Full Name</label><div>{{ $app->full_name ?? $app->user_name }}</div></div>
      <div class="detail-item"><label>Email</label><div>{{ $app->email ?? $app->user_email }}</div></div>
      <div class="detail-item"><label>Phone</label><div>{{ $app->phone ?? '—' }}</div></div>
      <div class="detail-item"><label>Passport Number</label><div>{{ $app->passport_number ?? '—' }}</div></div>
      <div class="detail-item"><label>Nationality</label><div>{{ $app->nationality ?? '—' }}</div></div>
    </div>
  </div>

  <div class="detail-card">
    <h3>✈️ Visa Details</h3>
    <div class="detail-grid">
      <div class="detail-item"><label>Visa Type</label><div>{{ ucfirst($app->visa_type ?? '—') }}</div></div>
      <div class="detail-item"><label>Country</label><div>{{ $app->country ?? '—' }}</div></div>
      <div class="detail-item"><label>Travel Date</label><div>{{ $app->travel_date ?? '—' }}</div></div>
      <div class="detail-item"><label>Duration</label><div>{{ $app->duration_days ?? '—' }} days</div></div>
      <div class="detail-item">
        <label>Status</label>
        <div>
          @php $s = $app->status ?? 'pending'; @endphp
          <span class="badge badge-{{ $s==='under_review'?'review':$s }}">{{ ucfirst(str_replace('_',' ',$s)) }}</span>
        </div>
      </div>
      <div class="detail-item"><label>Submitted On</label><div>{{ \Carbon\Carbon::parse($app->created_at)->format('d M Y, h:i A') }}</div></div>
    </div>
    @if($app->purpose)
    <div style="margin-top:18px">
      <label style="font-size:.68rem;color:var(--text2);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:6px">Purpose of Travel</label>
      <div style="font-size:.88rem;color:var(--text)">{{ $app->purpose }}</div>
    </div>
    @endif
    @if(!empty($app->admin_notes))
    <div style="margin-top:18px">
      <label style="font-size:.68rem;color:var(--text2);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:6px">Admin Notes</label>
      <div style="font-size:.88rem;color:var(--gold)">{{ $app->admin_notes }}</div>
    </div>
    @endif
  </div>

  <div class="detail-card">
    <h3>📁 Uploaded Documents</h3>
    @if($documents->count() > 0)
      <div class="doc-list">
        @foreach($documents as $doc)
        <div class="doc-row">
          <i class="fas fa-file-alt" style="color:var(--gold)"></i>
          <span>{{ ucfirst(str_replace('_',' ', $doc->document_type)) }}</span>
          <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"><i class="fas fa-eye"></i> View File</a>
        </div>
        @endforeach
      </div>
    @else
      <div class="empty-msg">No documents uploaded yet.</div>
    @endif
  </div>

</div>
</body>
</html>