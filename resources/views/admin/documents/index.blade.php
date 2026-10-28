<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Documents – Admin</title>
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
.group-card{background:var(--card);border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:16px;transition:border-color .3s}
.group-card:hover{border-color:rgba(201,168,76,0.3)}
.group-header{padding:16px 20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;cursor:pointer}
.group-user{display:flex;align-items:center;gap:12px}
.avatar{width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,var(--gold),#f0c96e);display:flex;align-items:center;justify-content:center;font-weight:700;color:#000;font-size:.9rem;flex-shrink:0}
.group-user-name{font-weight:600;font-size:.92rem}
.group-user-email{color:var(--text2);font-size:.78rem}
.app-id-chip{background:rgba(59,130,246,0.15);color:#3b82f6;padding:3px 12px;border-radius:100px;font-size:.72rem;font-weight:700;margin-right:8px}
.no-app-chip{color:var(--text2);font-size:.78rem;margin-right:8px}
.doc-count-chip{background:rgba(34,197,94,0.15);color:#22c55e;padding:3px 12px;border-radius:100px;font-size:.72rem;font-weight:700}
.toggle-btn{background:var(--gold);color:#000;border:none;padding:8px 18px;border-radius:8px;font-size:.8rem;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;transition:all .2s;font-family:'Outfit',sans-serif}
.toggle-btn:hover{background:#f0c96e;transform:translateY(-1px)}
.toggle-btn i{transition:transform .3s}
.toggle-btn.open i{transform:rotate(180deg)}
.doc-body{max-height:0;overflow:hidden;transition:max-height .35s ease;border-top:1px solid transparent}
.doc-body.open{max-height:1000px;border-top:1px solid var(--border)}
.doc-row{display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid rgba(201,168,76,0.05)}
.doc-row:last-child{border-bottom:none}
.doc-row:hover{background:rgba(201,168,76,0.03)}
.doc-name{font-size:.85rem;flex:1}
.doc-date{color:var(--text2);font-size:.75rem;min-width:140px}
.btn{display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border-radius:7px;font-size:.78rem;font-weight:600;cursor:pointer;border:none;font-family:'Outfit',sans-serif;transition:all .2s}
.btn-info{background:rgba(59,130,246,0.15);color:#3b82f6;border:1px solid rgba(59,130,246,0.2)}
.btn-info:hover{background:rgba(59,130,246,0.25)}
.btn-danger{background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.2)}
.btn-danger:hover{background:rgba(239,68,68,0.25)}
.empty-msg{text-align:center;color:var(--text2);padding:60px}
.alert{padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:.88rem;display:flex;align-items:center;gap:8px}
.alert-success{background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);color:#22c55e}
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
  <a href="{{ route('myadmin.documents') }}" class="nav-item active"><i class="fas fa-folder-open"></i> Documents</a>
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
    <h1><i class="fas fa-folder-open" style="color:var(--gold);margin-right:8px"></i>Documents</h1>
  </div>

  @if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
  @endif

  @forelse($grouped as $appId => $docs)
    @php $first = $docs->first(); @endphp
    <div class="group-card">
      <div class="group-header" onclick="toggleGroup('grp-{{ $appId }}', this)">
        <div class="group-user">
          <div class="avatar">{{ strtoupper(substr($first->user_name,0,1)) }}</div>
          <div>
            <div class="group-user-name">{{ $first->user_name }}</div>
            <div class="group-user-email">{{ $first->user_email }}</div>
          </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
          @if($appId !== 'unlinked')
            <span class="app-id-chip">Application #{{ $appId }}</span>
            @if($first->app_visa_type)
              <span style="color:var(--text2);font-size:.78rem">{{ ucfirst($first->app_visa_type) }} - {{ $first->app_country }}</span>
            @endif
          @else
            <span class="no-app-chip">No application linked</span>
          @endif
          <span class="doc-count-chip">{{ $docs->count() }} document{{ $docs->count() > 1 ? 's' : '' }}</span>
          <button type="button" class="toggle-btn" id="btn-grp-{{ $appId }}">
            <span>View Documents</span> <i class="fas fa-chevron-down"></i>
          </button>
        </div>
      </div>
      <div class="doc-body" id="grp-{{ $appId }}">
        @foreach($docs as $doc)
        <div class="doc-row">
          <i class="fas fa-file-alt" style="color:var(--gold)"></i>
          <span class="doc-name">{{ ucfirst(str_replace('_',' ', $doc->document_type)) }}</span>
          <span class="doc-date">{{ \Carbon\Carbon::parse($doc->created_at)->format('d M Y, h:i A') }}</span>
          <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
          <form method="POST" action="{{ route('myadmin.documents.destroy', $doc->id) }}" onsubmit="return confirm('Delete this document permanently?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
          </form>
        </div>
        @endforeach
      </div>
    </div>
  @empty
    <div class="group-card"><div class="empty-msg">No documents uploaded yet.</div></div>
  @endforelse

</div>

<script>
function toggleGroup(id, headerEl) {
    // Prevent toggling twice if button itself was clicked inside header (event bubbles fine, single toggle)
    const body = document.getElementById(id);
    const btn = document.getElementById('btn-' + id);
    const isOpen = body.classList.contains('open');

    if (isOpen) {
        body.classList.remove('open');
        btn.classList.remove('open');
        btn.querySelector('span').textContent = 'View Documents';
    } else {
        body.classList.add('open');
        btn.classList.add('open');
        btn.querySelector('span').textContent = 'Hide Documents';
    }
}
</script>
</body>
</html>