@extends('layouts.app')
@section('title', 'UAE Online Visa - United Arab Emirates')

@section('styles')
<style>
    .visa-hero { background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 100%); padding: 29px 27px; text-align: center; position: relative; overflow: hidden; color: rgb(255, 255, 255); }
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
    .sidebar-card { background: #375683; border-radius: 16px; padding: 24px; box-shadow: 0 8px 24px rgba(0,0,0,0.07); border: 1.5px solid #e2e8f0; }
    .sidebar-card h4 { font-family: 'Playfair Display', serif; color: #ffffff; font-size: 1rem; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #c9a84c; }
    .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0; font-size: 0.85rem; }
    .info-row:last-child { border-bottom: none; }
    .info-row .ilabel { color: #ffffff; }
    .info-row .ivalue { color: #ffffff; font-weight: 600; }
    .apply-btn { display: block; background: linear-gradient(135deg, #1abc9c, #16a085); color: #fff; padding: 14px 20px; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; text-align: center; margin-top: 8px; transition: transform 0.2s; }
    .apply-btn:hover { transform: translateY(-2px); color: #fff; }
    .highlight-box { background: linear-gradient(135deg, #684e00, #070604); border: 1.5px solid #c9a84c; border-radius: 12px; padding: 20px; margin: 20px 0; }
    .highlight-box h4 { color: #ffffff; font-size: 0.95rem; font-weight: 700; margin-bottom: 8px; }
    .highlight-box p { color: #ffffff; font-size: 0.88rem; margin: 0; }
    .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    @media(max-width: 900px) { .info-grid { grid-template-columns: 1fr; } .visa-section { padding: 40px 20px; } .visa-main { padding: 24px; } }
</style>
@endsection

@section('content')
<div class="visa-hero">
    <span class="flag">🇦🇪</span>
    <h1>UAE <span>Online Visa</span></h1>
    <p>United Arab Emirates — Visit Dubai, Abu Dhabi & More</p>
</div>

<div class="visa-section">
    <div class="info-grid">
        <div class="visa-main reveal">
            <h2>What is UAE Online Visa?</h2>
            <p>The UAE Online Visa allows eligible travelers to visit the United Arab Emirates including Dubai, Abu Dhabi, Sharjah, and other emirates for tourism, business, or family visits. Pakistani passport holders are eligible to apply for a UAE visa online.</p>
            <p>The UAE is one of the most popular travel destinations for Pakistani travelers due to its world-class infrastructure, shopping, and tourism opportunities.</p>

            <div class="highlight-box">
                <h4>🌟 Good News for Pakistanis!</h4>
                <p>Pakistani citizens can apply for UAE visa online through VisaGo. We handle the entire process from document preparation to visa delivery, making your UAE travel dream a reality.</p>
            </div>

            <h3>Types of UAE Visa</h3>
            <ul>
                <li>Tourist Visa — 30 days, extendable</li>
                <li>Tourist Visa — 60 days, extendable</li>
                <li>Tourist Visa — 90 days, extendable</li>
                <li>Visit Visa — 30/60/90 days for family visits</li>
                <li>Transit Visa — 48/96 hours for transit passengers</li>
                <li>Multiple Entry Visa — valid for 5 years</li>
            </ul>

            <h3>Required Documents</h3>
            <ul>
                <li>Valid Pakistani passport (minimum 6 months validity)</li>
                <li>Recent passport-size photograph (white background)</li>
                <li>Return flight ticket (or proof of onward travel)</li>
                <li>Bank statement showing sufficient funds</li>
                <li>Hotel booking or invitation letter from UAE resident</li>
                <li>Travel insurance (recommended)</li>
            </ul>

            <h3>Application Process</h3>
            <ul>
                <li>Submit your application through VisaGo online portal</li>
                <li>Upload all required documents in the specified format</li>
                <li>Pay the visa fee and VisaGo service fee</li>
                <li>Our team reviews and submits your application to UAE authorities</li>
                <li>Receive your UAE visa via email within processing time</li>
                <li>Print your visa and travel to UAE</li>
            </ul>

            <h3>UAE Travel Tips</h3>
            <ul>
                <li>Respect local laws and customs — dress modestly in public</li>
                <li>Alcohol is only permitted in licensed venues</li>
                <li>Photography of government buildings is prohibited</li>
                <li>Currency is UAE Dirham (AED) — widely accepted cards</li>
                <li>Best time to visit — October to April for pleasant weather</li>
            </ul>
        </div>

        <div class="visa-sidebar reveal">
            <div class="sidebar-card">
                <h4>📋 Quick Info</h4>
                <div class="info-row"><span class="ilabel">Visa Type</span><span class="ivalue">Tourist/Visit</span></div>
                <div class="info-row"><span class="ilabel">Options</span><span class="ivalue">30/60/90 Days</span></div>
                <div class="info-row"><span class="ilabel">Processing</span><span class="ivalue">3-5 Days</span></div>
                <div class="info-row"><span class="ilabel">Entry</span><span class="ivalue">Single/Multiple</span></div>
                <div class="info-row"><span class="ilabel">Extendable</span><span class="ivalue">Yes</span></div>
            </div>
            <div class="sidebar-card">
                <h4>💰 Fee Structure</h4>
                <div class="info-row"><span class="ilabel">30 Days</span><span class="ivalue">PKR 18,000</span></div>
                <div class="info-row"><span class="ilabel">60 Days</span><span class="ivalue">PKR 28,000</span></div>
                <div class="info-row"><span class="ilabel">90 Days</span><span class="ivalue">PKR 38,000</span></div>
                <div class="info-row"><span class="ilabel">Service Fee</span><span class="ivalue">PKR 3,500</span></div>
                <a href="{{ url('/booking') }}" class="apply-btn">Apply Now →</a>
            </div>
            <div class="sidebar-card">
                <h4>⏱ Processing Times</h4>
                <div class="info-row"><span class="ilabel">Normal</span><span class="ivalue">3-5 Days</span></div>
                <div class="info-row"><span class="ilabel">Express</span><span class="ivalue">24-48 Hours</span></div>
                <div class="info-row"><span class="ilabel">Urgent</span><span class="ivalue">12-24 Hours</span></div>
            </div>
            <div class="sidebar-card">
                <h4>📞 Need Help?</h4>
                <p style="color:white; font-size:0.85rem; margin-bottom:12px;">Our UAE visa specialists are ready to help you 24/7.</p>
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