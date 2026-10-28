@extends('layouts.app')
@section('title', 'Admin - All Applications')

@section('styles')
<style>
    .page-hero { background: #0a1628; padding: 48px; }
    .page-hero h1 { font-family: 'Playfair Display', serif; font-size: 2rem; color: #fff; }
    .page-hero h1 span { color: #c9a84c; }

    .section { padding: 48px; max-width: 1200px; margin: 0 auto; }

    table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
    thead { background: #0a1628; }
    thead th { color: rgba(255,255,255,0.8); padding: 14px 16px; text-align: left; font-size: 0.82rem; font-weight: 600; }
    tbody td { padding: 14px 16px; border-bottom: 1px solid #f0f0f0; color: #1a2340; font-size: 0.88rem; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: #faf8f3; }

    .badge { display: inline-block; padding: 4px 12px; border-radius: 100px; font-size: 0.75rem; font-weight: 700; }
    .badge-pending  { background: #fff3e0; color: #e65100; }
    .badge-approved { background: #e8f5e9; color: #2e7d32; }
    .badge-rejected { background: #fce4ec; color: #c62828; }

    .status-form select { padding: 6px 10px; border-radius: 8px; border: 1.5px solid #ddd; font-family: 'DM Sans', sans-serif; font-size: 0.82rem; cursor: pointer; }
    .status-form button { padding: 6px 14px; background: #0a1628; color: #fff; border: none; border-radius: 8px; font-size: 0.82rem; cursor: pointer; margin-left: 6px; }
    .status-form button:hover { background: #c9a84c; color: #0a1628; }

    @media(max-width: 768px) { .section { padding: 24px 16px; } }
</style>
@endsection

@section('content')

<div class="page-hero">
    <h1>Admin — <span>All Applications</span></h1>
</div>

<div class="section">

    @if(session('success'))
        <div style="background:#e8f5e9;border:1px solid #a5d6a7;color:#2e7d32;padding:14px 20px;border-radius:10px;margin-bottom:24px;font-weight:500;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Applicant</th>
                <th>Visa Type</th>
                <th>Country</th>
                <th>Travel Date</th>
                <th>Passport</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $i => $app)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    <strong>{{ $app->full_name }}</strong><br>
                    <small style="color:#6b7a99;">{{ $app->email }}</small>
                </td>
                <td>
                    @if($app->visa_type == 'tourist')  🏖️ Tourist
                    @elseif($app->visa_type == 'work')  💼 Work
                    @elseif($app->visa_type == 'study') 🎓 Study
                    @else 🤝 Business @endif
                </td>
                <td>{{ $app->country }}</td>
                <td>{{ \Carbon\Carbon::parse($app->travel_date)->format('d M Y') }}</td>
                <td>{{ $app->passport_number }}</td>
                <td><span class="badge badge-{{ $app->status }}">{{ ucfirst($app->status) }}</span></td>
                <td>
                    <form class="status-form" method="POST" action="{{ route('admin.status', $app->id) }}">
                        @csrf
                        <select name="status">
                            <option value="pending"  {{ $app->status=='pending'  ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="approved" {{ $app->status=='approved' ? 'selected' : '' }}>✅ Approved</option>
                            <option value="rejected" {{ $app->status=='rejected' ? 'selected' : '' }}>❌ Rejected</option>
                        </select>
                        <button type="submit">Save</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection