@extends('layouts.app')
@section('title', 'Canada eTA - Electronic Travel Authorization')

@section('styles')
<style>
    .visa-hero {
        background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 100%);
        padding: 29px 27px; text-align: center; position: relative; overflow: hidden;
        color: rgb(255, 255, 255);
    }
    .visa-hero::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(201,168,76,0.1) 0%, transparent 65%);
        animation: pulse 4s ease-in-out infinite;
    }
    @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.1); } }
    .visa-hero h1 { font-family: 'Playfair Display', serif; font-size: 2.8rem; color: #fff; position: relative; z-index: 2; }
    .visa-hero h1 span { color: #c9a84c; }
    .visa-hero p { color: rgb(255, 255, 255); margin-top: 12px; position: relative; z-index: 2; }
    .visa-hero .flag { font-size: 4rem; position: relative; z-index: 2; margin-bottom: 16px; display: block; }

    .visa-section { background: #23344b; padding: 60px 35px 80px; }

    /* INFO GRID */
    .info-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 32px; max-width: 1100px; margin: 0 auto; }

    /* MAIN CONTENT */
    .visa-main { background: #385685; border-radius: 20px; padding: 40px; box-shadow: 0 8px 40px rgba(0,0,0,0.08); }
    .visa-main h2 { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: #ffffff; margin-bottom: 16px; }
    .visa-main h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; color: #ffffff; margin: 28px 0 12px; }
    .visa-main p { color: #ffffff; line-height: 1.8; margin-bottom: 14px; font-size: 0.93rem; }
    .visa-main ul { list-style: none; padding: 0; }
    .visa-main ul li { color: #ffffff; font-size: 0.93rem; padding: 8px 0 8px 24px; position: relative; border-bottom: 1px solid #f8f8f8; }
    .visa-main ul li::before { content: '✓'; position: absolute; left: 0; color: #c9a84c; font-weight: 700; }

    /* SIDEBAR */
    .visa-sidebar { display: flex; flex-direction: column; gap: 20px; }
    .sidebar-card { background: #375683; border-radius: 16px; padding: 24px; box-shadow: 0 8px 24px rgba(0,0,0,0.07); border: 1.5px solid #e2e8f0; }
    .sidebar-card h4 { font-family: 'Playfair Display', serif; color: #ffffff; font-size: 1rem; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #c9a84c; }
    .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0; font-size: 0.85rem; }
    .info-row:last-child { border-bottom: none; }
    .info-row .ilabel { color: #ffffff; }
    .info-row .ivalue { color: #ffffff; font-weight: 600; }

    .apply-btn {
        display: block; background: linear-gradient(135deg, #1abc9c, #16a085);
        color: #fff; padding: 14px 20px; border-radius: 12px;
        font-weight: 700; font-size: 1rem; text-decoration: none;
        text-align: center; margin-top: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 14px rgba(26,188,156,0.3);
    }
    .apply-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(26,188,156,0.4); color: #fff; }

    .highlight-box {
        background: linear-gradient(135deg, #684e00, #070604);
        border: 1.5px solid #c9a84c; border-radius: 12px; padding: 20px;
        margin: 20px 0;
    }
    .highlight-box h4 { color: #ffffff; font-size: 0.95rem; font-weight: 700; margin-bottom: 8px; }
    .highlight-box p { color: #ffffff; font-size: 0.88rem; margin: 0; }

    .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    @media(max-width: 900px) {
        .info-grid { grid-template-columns: 1fr; }
        .visa-section { padding: 40px 20px; }
        .visa-main { padding: 24px; }
    }
</style>
@endsection

@section('content')

<div class="visa-hero">
    <span class="flag">🇨🇦</span>
    <h1>Canada <span>eTA</span></h1>
    <p>Electronic Travel Authorization — Fast, Simple, Online</p>
</div>

<div class="visa-section">
    <div class="info-grid">

        <!-- MAIN CONTENT -->
        <div class="visa-main reveal">
            <h2>What is Canada eTA?</h2>
            <p>The Canada Electronic Travel Authorization (eTA) is an entry requirement for visa-exempt foreign nationals travelling to Canada by air. It is electronically linked to your passport and is valid for up to 5 years or until your passport expires.</p>
            <p>The eTA does not guarantee entry to Canada. A border services officer may still ask you questions when you arrive at the airport.</p>

            <div class="highlight-box">
                <h4>✈️ Important Note</h4>
                <p>The eTA is only required for air travel to Canada. If you are travelling by land or sea, you do not need an eTA but may need a visa depending on your nationality.</p>
            </div>

            <h3>Who Needs Canada eTA?</h3>
            <ul>
                <li>Citizens of visa-exempt countries travelling to Canada by air</li>
                <li>Permanent residents of the United States travelling to Canada</li>
                <li>People transiting through a Canadian airport</li>
                <li>British citizens and British overseas territories citizens</li>
            </ul>

            <h3>Required Documents</h3>
            <ul>
                <li>Valid passport (must be valid for at least 6 months)</li>
                <li>Valid email address to receive your eTA confirmation</li>
                <li>Credit or debit card for payment</li>
                <li>Personal and travel information</li>
            </ul>

            <h3>Application Process</h3>
            <ul>
                <li>Fill out the online application form with your personal details</li>
                <li>Upload required documents and photographs</li>
                <li>Pay the application fee securely online</li>
                <li>Receive eTA confirmation via email (usually within minutes)</li>
                <li>Travel to Canada — eTA is automatically linked to your passport</li>
            </ul>

            <h3>Eligibility Requirements</h3>
            <ul>
                <li>Valid passport from a visa-exempt country</li>
                <li>No criminal record or immigration violations</li>
                <li>Sufficient funds to support your stay in Canada</li>
                <li>Genuine intention to leave Canada before your eTA expires</li>
                <li>Good health — no serious medical conditions</li>
            </ul>
        </div>

        <!-- SIDEBAR -->
        <div class="visa-sidebar reveal">

            <div class="sidebar-card">
                <h4>📋 Quick Info</h4>
                <div class="info-row"><span class="ilabel">Visa Type</span><span class="ivalue">eTA</span></div>
                <div class="info-row"><span class="ilabel">Validity</span><span class="ivalue">5 Years</span></div>
                <div class="info-row"><span class="ilabel">Stay Duration</span><span class="ivalue">Up to 6 Months</span></div>
                <div class="info-row"><span class="ilabel">Processing</span><span class="ivalue">1-3 Days</span></div>
                <div class="info-row"><span class="ilabel">Entry Type</span><span class="ivalue">Multiple Entry</span></div>
                <div class="info-row"><span class="ilabel">Travel Mode</span><span class="ivalue">Air Only</span></div>
            </div>

            <div class="sidebar-card">
                <h4>💰 Fee Structure</h4>
                <div class="info-row"><span class="ilabel">eTA Fee</span><span class="ivalue">PKR 1,680</span></div>
                <div class="info-row"><span class="ilabel">Service Fee</span><span class="ivalue">PKR 2,500</span></div>
                <div class="info-row"><span class="ilabel">Express Fee</span><span class="ivalue">PKR 4,200</span></div>
                <div class="info-row"><span class="ilabel">Total (Normal)</span><span class="ivalue">PKR 4,180</span></div>
                <a href="{{ url('/booking') }}" class="apply-btn">Apply Now →</a>
            </div>

            <div class="sidebar-card">
                <h4>⏱ Processing Times</h4>
                <div class="info-row"><span class="ilabel">Normal</span><span class="ivalue">1-3 Days</span></div>
                <div class="info-row"><span class="ilabel">Express</span><span class="ivalue">24 Hours</span></div>
                <div class="info-row"><span class="ilabel">Urgent</span><span class="ivalue">4-6 Hours</span></div>
            </div>

            <div class="sidebar-card">
                <h4>📞 Need Help?</h4>
                <p style="color:white; font-size:0.85rem; margin-bottom:12px;">Our visa experts are available 24/7 to assist you with your Canada eTA application.</p>
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