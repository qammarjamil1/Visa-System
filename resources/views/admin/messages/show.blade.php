<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Message Detail – Admin</title>
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
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px}
.topbar h1{font-size:1.3rem;font-weight:700}
.card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:28px;margin-bottom:20px}
.info-row{display:flex;gap:16px;padding:14px 0;border-bottom:1px solid rgba(201,168,76,0.07)}
.info-row:last-child{border-bottom:none;padding-bottom:0}
.info-label{font-size:.72rem;color:var(--text2);text-transform:uppercase;letter-spacing:1px;min-width:90px;padding-top:2px;font-weight:600}
.info-val{color:var(--text);font-size:.9rem;line-height:1.6}
.msg-box{background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:10px;padding:18px;line-height:1.8;color:var(--text);font-size:.9rem;white-space:pre-line}
.reply-box{background:rgba(201,168,76,0.05);border:1px solid rgba(201,168,76,0.2);border-radius:10px;padding:18px;line-height:1.8;color:var(--text);font-size:.9rem;white-space:pre-line}
.form-group{margin-bottom:16px}
.form-group label{display:block;font-size:.72rem;font-weight:700;color:var(--text2);margin-bottom:8px;text-transform:uppercase;letter-spacing:1px}
.form-control{width:100%;padding:12px 14px;background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:10px;color:var(--text);font-family:'Outfit',sans-serif;font-size:.9rem;outline:none;transition:border-color .3s;resize:vertical}
.form-control:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(201,168,76,0.08)}
.btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:8px;font-size:.85rem;font-weight:600;cursor:pointer;border:none;font-family:'Outfit',sans-serif;transition:all .2s;text-decoration:none}
.btn-gold{background:var(--gold);color:#000}
.btn-gold:hover{background:#f0c96e;transform:translateY(-1px)}
.btn-outline{background:transparent;color:var(--text2);border:1px solid var(--border)}
.btn-outline:hover{border-color:var(--gold);color:var(--gold)}
.btn-danger{background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.2)}
.btn-danger:hover{background:rgba(239,68,68,0.25)}
.alert{padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:.88rem;display:flex;align-items:center;gap:8px}
.alert-success{background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);color:#22c55e}
.section-title{font-size:.88rem;font-weight:700;color:var(--gold);margin-bottom:16px;display:flex;align-items:center;gap:8px}
.replied-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);color:#22c55e;font-size:.72rem;font-weight:700;padding:4px 12px;border-radius:100px}
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
  <a href="{{ route('myadmin.messages') }}" class="nav-item active"><i class="fas fa-envelope"></i> Messages</a>
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
    <h1><i class="fas fa-envelope" style="color:var(--gold);margin-right:8px"></i>Message Detail</h1>
    <a href="{{ route('myadmin.messages') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
  @endif

  <!-- MESSAGE INFO -->
  <div class="card">
    <div class="section-title"><i class="fas fa-user"></i> Message Info
      @if($msg->reply)
        <span class="replied-badge"><i class="fas fa-check"></i> Replied</span>
      @endif
    </div>
    <div class="info-row">
      <span class="info-label">From</span>
      <span class="info-val" style="font-weight:600">{{ $msg->name }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Email</span>
      <span class="info-val"><a href="mailto:{{ $msg->email }}" style="color:var(--gold)">{{ $msg->email }}</a></span>
    </div>
    <div class="info-row">
      <span class="info-label">Subject</span>
      <span class="info-val">{{ $msg->subject }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Date</span>
      <span class="info-val" style="color:var(--text2)">{{ \Carbon\Carbon::parse($msg->created_at)->format('d M Y, h:i A') }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Message</span>
      <div class="msg-box">{{ $msg->message }}</div>
    </div>

    @if($msg->reply)
    <div class="info-row">
      <span class="info-label">Your Reply</span>
      <div class="reply-box">
        <div style="font-size:.75rem;color:var(--gold);margin-bottom:8px;font-weight:700">
          ✅ Reply sent
        </div>
        {{ $msg->reply }}
      </div>
    </div>
    @endif
  </div>

  <!-- REPLY FORM -->
  <div class="card">
    <div class="section-title"><i class="fas fa-reply"></i> {{ $msg->reply ? 'Update Reply' : 'Write Reply' }}</div>
    <form method="POST" action="{{ route('myadmin.messages.reply', $msg->id) }}">
      @csrf
      <div class="form-group">
        <label>Reply to {{ $msg->name }}</label>
        <textarea name="reply" class="form-control" rows="5" placeholder="Write your reply here...">{{ old('reply', $msg->reply) }}</textarea>
        @error('reply')<div style="color:#ef4444;font-size:.78rem;margin-top:4px">{{ $message }}</div>@enderror
      </div>
      <button type="submit" class="btn btn-gold">
        <i class="fas fa-paper-plane"></i> {{ $msg->reply ? 'Update Reply' : 'Send Reply' }}
      </button>
    </form>
  </div>

  <!-- DELETE FORM (separate, not nested inside reply form) -->
  <div class="card">
    <div class="section-title" style="color:#ef4444"><i class="fas fa-trash"></i> Delete Message</div>
    <p style="color:var(--text2);font-size:.85rem;margin-bottom:16px">This will permanently delete this message. This action cannot be undone.</p>
    <form method="POST" action="{{ route('myadmin.messages.destroy', $msg->id) }}" onsubmit="return confirm('Delete this message permanently?')">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete Message</button>
    </form>
  </div>

</div>
</body>
</html>