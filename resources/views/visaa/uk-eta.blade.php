@extends('layouts.app')
@section('title', 'UK eTA - United Kingdom Electronic Travel Authorization')

@section('styles')
<style>
    .visa-hero { background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 100%); padding: 29px 27px; text-align: center; position: relative; overflow: hidden; color:white; }
    .visa-hero::before { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at 50% 50%, rgba(201,168,76,0.1) 0%, transparent 65%); animation: pulse 4s ease-in-out infinite; }
    @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.1); } }
    .visa-hero h1 { font-family: 'Playfair Display', serif; font-size: 2.8rem; color: #fff; position: relative; z-index: 2; }
    .visa-hero h1 span { color: #c9a84c; }
    .visa-hero p { color: rgb(255, 255, 255); margin-top: 12px; position: relative; z-index: 2; }
    .visa-hero .flag { font-size: 4rem; position: relative; z-index: 2; margin-bottom: 16px; display: block; }
    .visa-section { background: #23344b; padding: 60px 48px 80px; }
    .info-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 32px; max-width: 1100px; margin: 0 auto; }
    .visa-main { background: #385685; border-radius: 20px; padding: 40px; box-shadow: 0 8px 40px rgba(0,0,0,0.08); }
    .visa-main h2 { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: #ffffff; margin-bottom: 16px; }
    .visa-main h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; color: #ffffff; margin: 28px 0 12px; }
    .visa-main p { color: #ffffff; line-height: 1.8; margin-bottom: 14px; font-size: 0.93rem; }
    .visa-main ul { list-style: none; padding: 0; }
    .visa-main ul li { color: #ffffff; font-size: 0.93rem; padding: 8px 0 8px 24px; position: relative; border-bottom: 1px solid #f8f8f8; }
    .visa-main ul li::before { content: '✓'; position: absolute; left: 0; color: #c9a84c; font-weight: 700; }
    .visa-sidebar { display: flex; flex-direction: column; gap: 20px; }
    .sidebar-card {background: #375683; border-radius: 16px; padding: 24px; box-shadow: 0 8px 24px rgba(0,0,0,0.07); border: 1.5px solid #e2e8f0; }
    .sidebar-card h4 { font-family: 'Playfair Display', serif; color: #ffffff; font-size: 1rem; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #c9a84c; }
    .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0; font-size: 0.85rem; }
    .info-row:last-child { border-bottom: none; }
    .info-row .ilabel { color: #ffffff; }
    .info-row .ivalue { color: #ffffff; font-weight: 600; }
    .apply-btn { display: block; background: linear-gradient(135deg, #1abc9c, #16a085); color: #fff; padding: 14px 20px; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; text-align: center; margin-top: 8px; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 14px rgba(26,188,156,0.3); }
    .apply-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(26,188,156,0.4); color: #fff; }
    .highlight-box { background: linear-gradient(135deg, #684e00, #070604); border: 1.5px solid #c9a84c; border-radius: 12px; padding: 20px; margin: 20px 0; }
    .highlight-box h4 { color: #ffffff; font-size: 0.95rem; font-weight: 700; margin-bottom: 8px; }
    .highlight-box p { color: #fefeff; font-size: 0.88rem; margin: 0; }
    .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    @media(max-width: 900px) { .info-grid { grid-template-columns: 1fr; } .visa-section { padding: 40px 20px; } .visa-main { padding: 24px; } }
</style>
@endsection

@section('content')
<div class="visa-hero">
    <span class="flag">🇬🇧</span>
    <h1>United Kingdom <span>eTA</span></h1>
    <p>UK Electronic Travel Authorization — Simple Online Application</p>
</div>

<div class="visa-section">
    <div class="info-grid">
        <div class="visa-main reveal">
            <h2>What is UK eTA?</h2>
            <p>The UK Electronic Travel Authorization (eTA) is a new entry requirement introduced by the United Kingdom for visa-exempt nationals. It allows eligible travelers to visit the UK for tourism, business, or transit without a full visa.</p>
            <p>The UK eTA is electronically linked to your passport and allows multiple trips to the UK within its validity period.</p>

            <div class="highlight-box">
                <h4>🇬🇧 New Requirement</h4>
                <p>The UK eTA is a relatively new system. Make sure to apply well in advance of your travel date to avoid any delays.</p>
            </div>

            <h3>Who Needs UK eTA?</h3>
            <ul>
                <li>Nationals of visa-exempt countries visiting UK by air, sea, or land</li>
                <li>People transiting through UK airports or seaports</li>
                <li>Visitors staying for up to 6 months for tourism or business</li>
            </ul>

            <h3>Required Documents</h3>
            <ul>
                <li>Valid passport with at least 6 months validity</li>
                <li>Valid email address for confirmation</li>
                <li>Travel itinerary and accommodation details</li>
                <li>Credit or debit card for payment</li>
                <li>Passport-size photograph</li>
            </ul>

            <h3>Application Steps</h3>
            <ul>
                <li>Complete the online application form with accurate personal information</li>
                <li>Upload your passport photograph and required documents</li>
                <li>Pay the UK eTA fee securely through our platform</li>
                <li>Receive your eTA decision by email</li>
                <li>Travel to UK — eTA is linked to your passport automatically</li>
            </ul>

            <h3>Important Conditions</h3>
            <ul>
                <li>eTA does not allow you to work or study in the UK</li>
                <li>Maximum stay is 6 months per visit</li>
                <li>You must have sufficient funds for your stay</li>
                <li>Return or onward ticket may be required at the border</li>
            </ul>
        </div>

        <div class="visa-sidebar reveal">
            <div class="sidebar-card">
                <h4>📋 Quick Info</h4>
                <div class="info-row"><span class="ilabel">Visa Type</span><span class="ivalue">eTA</span></div>
                <div class="info-row"><span class="ilabel">Validity</span><span class="ivalue">2 Years</span></div>
                <div class="info-row"><span class="ilabel">Stay Duration</span><span class="ivalue">Up to 6 Months</span></div>
                <div class="info-row"><span class="ilabel">Processing</span><span class="ivalue">3-5 Days</span></div>
                <div class="info-row"><span class="ilabel">Entry Type</span><span class="ivalue">Multiple Entry</span></div>
            </div>
            <div class="sidebar-card">
                <h4>💰 Fee Structure</h4>
                <div class="info-row"><span class="ilabel">eTA Fee</span><span class="ivalue">PKR 2,800</span></div>
                <div class="info-row"><span class="ilabel">Service Fee</span><span class="ivalue">PKR 2,500</span></div>
                <div class="info-row"><span class="ilabel">Express Fee</span><span class="ivalue">PKR 5,600</span></div>
                <div class="info-row"><span class="ilabel">Total (Normal)</span><span class="ivalue">PKR 5,300</span></div>
                <a href="{{ url('/booking') }}" class="apply-btn">Apply Now →</a>
            </div>
            <div class="sidebar-card">
                <h4>⏱ Processing Times</h4>
                <div class="info-row"><span class="ilabel">Normal</span><span class="ivalue">3-5 Days</span></div>
                <div class="info-row"><span class="ilabel">Express</span><span class="ivalue">24-48 Hours</span></div>
                <div class="info-row"><span class="ilabel">Urgent</span><span class="ivalue">12 Hours</span></div>
            </div>
            <div class="sidebar-card">
                <h4>📞 Need Help?</h4>
                <p style="color:white; font-size:0.85rem; margin-bottom:12px;">Contact our UK visa specialists for personalized assistance.</p>
                <a href="{{ url('/contact') }}" style="display:block; background:#0a1628; color:#c9a84c; padding:10px; border-radius:8px; text-align:center; text-decoration:none; font-weight:600; font-size:0.88rem;">Contact Support</a>
            </div>
        </div>
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