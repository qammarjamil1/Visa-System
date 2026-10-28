@extends('layouts.app')
@section('title', 'Track My Application')

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 100%);
        padding: 60px 48px; text-align: center; position: relative; overflow: hidden;
        min-height: 220px; display: flex; align-items: center; justify-content: center;
    }
    .page-hero::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(201,168,76,0.12) 0%, transparent 65%);
        animation: heroPulse 4s ease-in-out infinite;
    }
    @keyframes heroPulse { 0%,100% { transform:scale(1); opacity:0.8; } 50% { transform:scale(1.1); opacity:1; } }
    .page-hero-inner { position: relative; z-index: 2; }
    .page-hero h1 { font-family: 'Playfair Display', serif; font-size: 2.6rem; color: #fff; margin-bottom: 10px; }
    .page-hero h1 span { color: #c9a84c; }
    .page-hero p { color: rgba(255,255,255,0.65); font-size: 0.98rem; }

    .dash-section {
        background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%);
        padding: 60px 48px 90px; position: relative; overflow: hidden;
    }
    .dash-inner { max-width: 800px; margin: 0 auto; position: relative; z-index: 2; }

    .section-title-bar {
        display: flex; align-items: center; gap: 10px; margin: 36px 0 18px;
    }
    .section-title-bar h2 {
        font-family: 'Playfair Display', serif; color: #fff; font-size: 1.25rem;
    }
    .section-title-bar h2 span { color: #c9a84c; }
    .section-title-bar .line { flex: 1; height: 1px; background: rgba(255,255,255,0.12); }

    .status-card {
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);
        border-radius: 20px; padding: 36px; margin-bottom: 12px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    }
    .status-card h2 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.4rem; margin-bottom: 20px; }

    .status-badge-big {
        display: inline-flex; align-items: center; gap: 10px;
        padding: 12px 24px; border-radius: 100px; font-weight: 800; font-size: 1rem;
        margin-bottom: 24px;
    }
    .status-pending      { background: rgba(255,191,0,0.15); color: #ffbf00; border: 1.5px solid rgba(255,191,0,0.4); }
    .status-under_review { background: rgba(96,165,250,0.15); color: #60a5fa; border: 1.5px solid rgba(96,165,250,0.4); }
    .status-approved     { background: rgba(74,222,128,0.15); color: #4ade80; border: 1.5px solid rgba(74,222,128,0.4); }
    .status-rejected     { background: rgba(255,107,107,0.15); color: #ff6b6b; border: 1.5px solid rgba(255,107,107,0.4); }

    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
    .detail-item {
        background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px; padding: 16px 20px; transition: background 0.2s, transform 0.2s, border-color 0.2s;
    }
    .detail-item:hover { background: rgba(201,168,76,0.08); border-color: rgba(201,168,76,0.25); transform: translateY(-2px); }
    .detail-label { font-size: 0.72rem; color: rgba(255,255,255,0.45); letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 6px; }
    .detail-value { font-size: 0.95rem; font-weight: 700; color: #fff; }

    .admin-notes-box {
        background: rgba(255,255,255,0.04); border-left: 3px solid #c9a84c;
        border-radius: 8px; padding: 16px 20px; margin-bottom: 24px;
    }
    .admin-notes-box h4 { color: #c9a84c; font-size: 0.85rem; margin-bottom: 6px; }
    .admin-notes-box p { color: rgba(255,255,255,0.65); font-size: 0.88rem; margin: 0; }

    .docs-list { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 8px; }
    .doc-chip {
        background: rgba(74,222,128,0.1); border: 1px solid rgba(74,222,128,0.3);
        color: #4ade80; padding: 6px 14px; border-radius: 100px; font-size: 0.8rem; font-weight: 600;
    }

    .payment-status-chip {
        display: inline-block; padding: 5px 14px; border-radius: 100px; font-size: 0.78rem; font-weight: 700;
    }
    .pay-pending   { background: rgba(255,191,0,0.15); color: #ffbf00; }
    .pay-completed { background: rgba(74,222,128,0.15); color: #4ade80; }

    .empty-state {
        text-align: center; padding: 60px 20px;
        background: rgba(255,255,255,0.05); border-radius: 20px; border: 1px dashed rgba(255,255,255,0.15);
    }
    .empty-state span { font-size: 3rem; display: block; margin-bottom: 16px; }
    .empty-state h3 { color: #fff; font-family: 'Playfair Display', serif; font-size: 1.3rem; margin-bottom: 10px; }
    .empty-state p { color: rgba(255,255,255,0.5); font-size: 0.9rem; margin-bottom: 24px; }

    .btn-gold-action {
        display: inline-block; background: linear-gradient(135deg, #c9a84c, #e2c06a);
        color: #0a1628; padding: 14px 32px; border-radius: 12px; font-weight: 800;
        text-decoration: none; transition: transform 0.25s, box-shadow 0.25s;
        box-shadow: 0 6px 20px rgba(201,168,76,0.3);
    }
    .btn-gold-action:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(201,168,76,0.45); color: #0a1628; }

    /* MESSAGES SECTION */
    .msg-card {
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);
        border-radius: 16px; padding: 22px 24px; margin-bottom: 14px;
        transition: border-color 0.25s, transform 0.25s, box-shadow 0.25s;
    }
    .msg-card:hover { border-color: rgba(201,168,76,0.3); transform: translateY(-2px); box-shadow: 0 12px 32px rgba(0,0,0,0.25); }
    .msg-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; gap: 10px; flex-wrap: wrap; }
    .msg-subject { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.05rem; }
    .msg-date { color: rgba(255,255,255,0.45); font-size: 0.78rem; white-space: nowrap; }
    .msg-status-chip { padding: 4px 12px; border-radius: 100px; font-size: 0.72rem; font-weight: 700; }
    .msg-unread { background: rgba(255,191,0,0.15); color: #ffbf00; }
    .msg-read   { background: rgba(96,165,250,0.15); color: #60a5fa; }
    .msg-body-text {
        background: rgba(255,255,255,0.04); border-radius: 10px; padding: 14px 16px;
        color: rgba(255,255,255,0.75); font-size: 0.88rem; line-height: 1.6;
        white-space: pre-line; margin-bottom: 10px;
    }
    .msg-reply-box {
        background: rgba(74,222,128,0.08); border-left: 3px solid #4ade80;
        border-radius: 8px; padding: 14px 16px; margin-top: 10px;
    }
    .msg-reply-box .reply-label { color: #4ade80; font-size: 0.75rem; font-weight: 700; margin-bottom: 6px; display: block; }
    .msg-reply-box p { color: rgba(255,255,255,0.8); font-size: 0.88rem; line-height: 1.6; margin: 0; white-space: pre-line; }
    .msg-awaiting { color: rgba(255,255,255,0.4); font-size: 0.82rem; font-style: italic; }

    .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    @media(max-width: 600px) {
        .dash-section { padding: 40px 20px 60px; }
        .detail-grid { grid-template-columns: 1fr; }
        .status-card { padding: 24px; }
        .page-hero h1 { font-size: 2rem; }
        .msg-top { flex-direction: column; align-items: flex-start; }
    }
</style>
@endsection

@section('content')

<div class="page-hero">
    <div class="page-hero-inner">
        <h1>Track My <span>Application</span></h1>
        <p>Live status of your visa application with VisaGo.</p>
    </div>
</div>

<div class="dash-section">
    <div class="dash-inner">

        <!-- ====================== APPLICATION STATUS ====================== -->
        @if($application)
            <div class="status-card reveal">
                <h2>👤 {{ Auth::user()->name }}'s Application</h2>

                @php
                    $statusLabels = [
                        'pending'       => '⏳ Pending Review',
                        'under_review'  => '👨‍💼 Under Review',
                        'approved'      => '✅ Approved',
                        'rejected'      => '❌ Rejected',
                    ];
                    $statusClass = 'status-' . $application->status;
                @endphp

                <span class="status-badge-big {{ $statusClass }}">
                    {{ $statusLabels[$application->status] ?? ucfirst($application->status) }}
                </span>

                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Visa Type</div>
                        <div class="detail-value">{{ ucfirst($application->visa_type) }} Visa</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Destination Country</div>
                        <div class="detail-value">{{ $application->country }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Travel Date</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($application->travel_date)->format('d M, Y') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Duration</div>
                        <div class="detail-value">{{ $application->duration_days }} Days</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Submitted On</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($application->created_at)->format('d M, Y') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Payment Status</div>
                        <div class="detail-value">
                            @if($payment)
                                <span class="payment-status-chip {{ $payment->status == 'completed' ? 'pay-completed' : 'pay-pending' }}">
                                    {{ $payment->status == 'completed' ? '✅ Verified' : '⏳ Pending Verification' }}
                                </span>
                            @else
                                <span class="payment-status-chip pay-pending">Not Submitted</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($application->admin_notes)
                <div class="admin-notes-box">
                    <h4>📝 Note from VisaGo Team</h4>
                    <p>{{ $application->admin_notes }}</p>
                </div>
                @endif

                <div class="detail-label" style="margin-bottom:10px;">Uploaded Documents ({{ $documents->count() }})</div>
                <div class="docs-list">
                    @forelse($documents as $doc)
                        <span class="doc-chip">📄 {{ ucfirst(str_replace('_',' ', $doc->document_type)) }}</span>
                    @empty
                        <span style="color:rgba(255,255,255,0.4); font-size:0.85rem;">No documents uploaded yet.</span>
                    @endforelse
                </div>
            </div>
        @else
            <div class="empty-state reveal">
                <span>📋</span>
                <h3>No Application Found</h3>
                <p>You haven't submitted any visa application yet. Start your journey today!</p>
                <a href="{{ url('/visa-types') }}" class="btn-gold-action">✈️ Apply for Visa Now</a>
            </div>
        @endif

        <!-- ====================== MY MESSAGES ====================== -->
        <div class="section-title-bar reveal">
            <h2>💬 My <span>Messages</span></h2>
            <div class="line"></div>
        </div>

        @forelse($messages as $msg)
            <div class="msg-card reveal">
                <div class="msg-top">
                    <div class="msg-subject">{{ $msg->subject }}</div>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <span class="msg-status-chip {{ $msg->status === 'unread' ? 'msg-unread' : 'msg-read' }}">
                            {{ $msg->status === 'unread' ? '⏳ Awaiting Response' : '👀 Seen by Team' }}
                        </span>
                        <span class="msg-date">{{ \Carbon\Carbon::parse($msg->created_at)->format('d M Y, h:i A') }}</span>
                    </div>
                </div>

                <div class="msg-body-text">{{ $msg->message }}</div>

                @if($msg->reply)
                    <div class="msg-reply-box">
                        <span class="reply-label">✅ Reply from VisaGo Team</span>
                        <p>{{ $msg->reply }}</p>
                    </div>
                @else
                    <span class="msg-awaiting">Our team hasn't replied yet — we'll respond soon.</span>
                @endif
            </div>
        @empty
            <div class="empty-state reveal">
                <span>📭</span>
                <h3>No Messages Yet</h3>
                <p>You haven't contacted us yet. Have a question? We're here to help.</p>
                <a href="{{ url('/contact') }}" class="btn-gold-action">📩 Contact Us</a>
            </div>
        @endforelse

    </div>
</div>

@endsection

@section('scripts')
<script>
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endsection