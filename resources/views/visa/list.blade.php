@extends('layouts.app')
@section('title', 'My Applications')

@section('styles')
<style>
    .page-hero { background: #0a1628; padding: 60px 48px; text-align: center; }
    .page-hero h1 { font-family: 'Playfair Display', serif; font-size: 2.8rem; color: #fff; }
    .page-hero h1 span { color: #c9a84c; }
    .section { padding: 60px 48px; max-width: 1200px; margin: 0 auto; }
    .alert-success { background: #e8f5e9; border: 1px solid #a5d6a7; color: #2e7d32; padding: 14px 20px; border-radius: 10px; margin-bottom: 24px; font-weight: 500; }
    .empty-state { text-align: center; padding: 80px 20px; color: #6b7a99; }
    .empty-state div { font-size: 4rem; margin-bottom: 16px; }
    .empty-state h3 { font-family: 'Playfair Display', serif; font-size: 1.5rem; color: #0a1628; margin-bottom: 8px; }
    .btn-apply-now { display: inline-block; margin-top: 20px; background: #0a1628; color: #fff; padding: 12px 28px; border-radius: 10px; text-decoration: none; font-weight: 600; }
    table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
    thead { background: #0a1628; }
    thead th { color: rgba(255,255,255,0.8); padding: 16px 20px; text-align: left; font-size: 0.85rem; font-weight: 600; letter-spacing: 0.5px; }
    tbody td { padding: 16px 20px; border-bottom: 1px solid #f0f0f0; color: #1a2340; font-size: 0.9rem; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: #faf8f3; }
    .badge { display: inline-block; padding: 4px 14px; border-radius: 100px; font-size: 0.78rem; font-weight: 700; }
    .badge-pending  { background: #fff3e0; color: #e65100; }
    .badge-approved { background: #e8f5e9; color: #2e7d32; }
    .badge-rejected { background: #fce4ec; color: #c62828; }
    .badge-under_review { background: #e3f2fd; color: #1565c0; }
    .admin-note { background: #fff8e1; border-left: 3px solid #c9a84c; padding: 8px 12px; border-radius: 6px; font-size: 0.82rem; color: #5d4037; margin-top: 4px; }
    @media(max-width: 768px) { .section { padding: 40px 20px; } table { font-size: 0.8rem; } thead th, tbody td { padding: 12px; } }
</style>
@endsection

@section('content')

<div class="page-hero">
    <h1>My <span>Applications</span></h1>
</div>

<div class="section">

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($applications->isEmpty())
        <div class="empty-state">
            <div>📋</div>
            <h3>No Applications Yet</h3>
            <p>You haven't applied for any visa yet.</p>
            <a href="{{ url('/booking') }}" class="btn-apply-now">Apply Now ✈️</a>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Visa Type</th>
                    <th>Country</th>
                    <th>Travel Date</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Admin Note</th>
                    <th>Applied On</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $i => $app)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        @if($app->visa_type == 'tourist') 🏖️ Tourist
                        @elseif($app->visa_type == 'work') 💼 Work
                        @elseif($app->visa_type == 'study') 🎓 Study
                        @else 🤝 Business @endif
                    </td>
                    <td>{{ $app->country }}</td>
                    <td>{{ \Carbon\Carbon::parse($app->travel_date)->format('d M Y') }}</td>
                    <td>{{ $app->duration_days ?? '—' }} days</td>
                    <td>
                        <span class="badge badge-{{ $app->status }}">
                            @if($app->status == 'pending') ⏳ Pending
                            @elseif($app->status == 'approved') ✅ Approved
                            @elseif($app->status == 'under_review') 🔍 Under Review
                            @else ❌ Rejected @endif
                        </span>
                    </td>
                    <td>
                        @if($app->admin_notes)
                            <div class="admin-note">💬 {{ $app->admin_notes }}</div>
                        @else
                            <span style="color:#aaa;font-size:.82rem">—</span>
                        @endif
                    </td>
                    <td>{{ $app->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection