@extends('layouts.app')
@section('title', 'Exit Permit Fee Calculator')

@section('styles')
<style>
    /* ── PAGE HERO ── */
    .page-hero {
        background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 100%);
        padding: 60px 48px; text-align: center; position: relative; overflow: hidden;
        min-height: 280px; display: flex; align-items: center; justify-content: center;
    }
    .page-hero::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(201,168,76,0.12) 0%, transparent 65%);
        animation: heroPulse 4s ease-in-out infinite;
    }
    @keyframes heroPulse { 0%,100% { transform:scale(1); opacity:0.8; } 50% { transform:scale(1.1); opacity:1; } }
    .page-hero-inner { position: relative; z-index: 2; animation: fadeUp 0.9s ease both; }
    .page-hero h1 { font-family: 'Playfair Display', serif; font-size: 2.8rem; color: #fff; margin-bottom: 12px; }
    .page-hero h1 span { color: #ffbf00; }
    .page-hero p { color: rgba(255,255,255,0.65); font-size: 1rem; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }
    .hero-particles span {
        position: absolute; border-radius: 50%;
        background: rgba(255,191,0,0.15); animation: floatDot linear infinite;
    }
    @keyframes floatDot { 0% { transform:translateY(0) scale(1); opacity:0.7; } 100% { transform:translateY(-100px) scale(0.5); opacity:0; } }

    /* ── MAIN SECTION ── */
    .fee-section {
        background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%);
        padding: 80px 48px; position: relative; overflow: hidden; min-height: 60vh;
    }
    .fee-section::before {
        content: ''; position: absolute;
        width: 500px; height: 500px; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 70%);
        top: -150px; right: -100px; pointer-events: none;
        animation: floatOrb 8s ease-in-out infinite alternate;
    }
    .fee-section::after {
        content: ''; position: absolute;
        width: 300px; height: 300px; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,168,76,0.04) 0%, transparent 70%);
        bottom: -80px; left: -60px; pointer-events: none;
    }
    @keyframes floatOrb { 0% { transform:translateY(0); } 100% { transform:translateY(40px); } }

    /* ── CALC CARD ── */
    .calc-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 24px; overflow: hidden;
        max-width: 720px; margin: 0 auto;
        box-shadow: 0 24px 60px rgba(0,0,0,0.3);
        transition: box-shadow 0.3s, transform 0.3s;
        position: relative; z-index: 2;
    }
    .calc-card:hover { box-shadow: 0 32px 72px rgba(0,0,0,0.4); transform: translateY(-4px); }

    .calc-header {
        background: linear-gradient(135deg, rgba(201,168,76,0.15), rgba(201,168,76,0.05));
        border-bottom: 1px solid rgba(201,168,76,0.2);
        padding: 32px 40px; text-align: center;
    }
    .calc-header h2 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.6rem; margin-bottom: 8px; }
    .calc-header p { color: rgba(255,255,255,0.6); font-size: 0.9rem; }
    .calc-header-icon { font-size: 2.5rem; margin-bottom: 12px; display: block; animation: iconFloat 3s ease-in-out infinite; }
    @keyframes iconFloat { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-8px); } }

    .calc-body { padding: 40px; }

    /* FORM */
    .calc-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    .calc-form-group { margin-bottom: 0; }
    .calc-label {
        display: block; font-size: 0.78rem; color: rgba(255,255,255,0.6);
        letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 10px; font-weight: 600;
    }
    .calc-select {
        width: 100%; padding: 14px 18px;
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);
        border-radius: 12px; color: #fff; font-size: 0.95rem;
        outline: none; transition: border-color 0.3s, background 0.3s, box-shadow 0.3s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23c9a84c' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 16px center;
        cursor: pointer;
    }
    .calc-select:focus { border-color: #ffbf00; background: rgba(255,255,255,0.1); box-shadow: 0 0 0 3px rgba(255,191,0,0.15); }
    .calc-select option { background: #1d2e49; color: #fff; }

    .btn-calc {
        width: 100%; padding: 16px; margin-top: 8px;
        background: linear-gradient(135deg, #ffbf00, #ffd700);
        color: #0a1628; border: none; border-radius: 12px;
        font-size: 1rem; font-weight: 800; cursor: pointer;
        letter-spacing: 0.5px; text-transform: uppercase;
        transition: transform 0.25s, box-shadow 0.25s;
        box-shadow: 0 6px 20px rgba(255,191,0,0.3);
    }
    .btn-calc:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(255,191,0,0.45); }
    .btn-calc:active { transform: translateY(-1px); }

    .calc-placeholder {
        text-align: center; padding: 32px 20px;
        color: rgba(255,255,255,0.4); font-size: 0.9rem;
        border: 1px dashed rgba(255,255,255,0.15); border-radius: 12px;
        margin-top: 20px; transition: border-color 0.3s;
    }
    .calc-placeholder:hover { border-color: rgba(255,191,0,0.3); }
    .calc-placeholder span { font-size: 2rem; display: block; margin-bottom: 8px; }

    /* ── RESULT CARD ── */
    .result-card {
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,191,0,0.3);
        border-radius: 20px; overflow: hidden;
        max-width: 720px; margin: 28px auto 0;
        box-shadow: 0 16px 48px rgba(0,0,0,0.25);
        animation: slideDown 0.5s ease;
        display: none; position: relative; z-index: 2;
    }
    @keyframes slideDown { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }

    .result-header {
        background: linear-gradient(135deg, rgba(255,191,0,0.2), rgba(255,191,0,0.08));
        border-bottom: 1px solid rgba(255,191,0,0.2);
        padding: 24px 36px; text-align: center;
    }
    .result-header h3 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.2rem; margin-bottom: 4px; }
    .result-header p { color: rgba(255,255,255,0.5); font-size: 0.82rem; }

    .result-body { padding: 32px 36px; }

    .result-fee-wrap { text-align: center; margin-bottom: 28px; }
    .result-fee-label { font-size: 0.78rem; color: rgba(255,255,255,0.5); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px; }
    .result-fee { font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 900; color: #ffbf00; animation: countUp 0.6s ease; }
    @keyframes countUp { from { opacity:0; transform:scale(0.8); } to { opacity:1; transform:scale(1); } }

    .result-details { display: grid; grid-template-columns: repeat(2,1fr); gap: 16px; margin-bottom: 24px; }
    .result-detail-item {
        background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px; padding: 16px 20px;
        transition: background 0.2s, border-color 0.2s, transform 0.2s;
    }
    .result-detail-item:hover { background: rgba(255,191,0,0.08); border-color: rgba(255,191,0,0.2); transform: translateY(-2px); }
    .result-detail-label { font-size: 0.72rem; color: rgba(255,255,255,0.45); letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 6px; }
    .result-detail-value { font-size: 0.95rem; font-weight: 700; color: #fff; }

    .result-breakdown { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; }
    .result-breakdown h4 { font-family: 'Playfair Display', serif; color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-bottom: 14px; }
    .breakdown-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 0.85rem; }
    .breakdown-row:last-child { border-bottom: none; }
    .breakdown-row .b-label { color: rgba(255,255,255,0.55); }
    .breakdown-row .b-value { color: #fff; }
    .breakdown-row.total-row .b-label { color: #fff; font-weight: 700; }
    .breakdown-row.total-row .b-value { color: #ffbf00; font-size: 1rem; font-weight: 800; }

    .result-apply-btn {
        display: block; width: 100%; padding: 15px;
        background: linear-gradient(135deg, #ffbf00, #ffd700);
        color: #0a1628; border: none; border-radius: 12px;
        font-size: 1rem; font-weight: 800; cursor: pointer;
        text-align: center; text-decoration: none;
        transition: transform 0.25s, box-shadow 0.25s;
        box-shadow: 0 6px 20px rgba(255,191,0,0.3);
        letter-spacing: 0.5px;
    }
    .result-apply-btn:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(255,191,0,0.45); color: #0a1628; }

    /* ── INFO BOXES ── */
    .info-section {
        background: linear-gradient(135deg, #0d1f3c 0%, #0a1628 100%);
        padding: 80px 48px; position: relative; overflow: hidden;
    }
    .info-section::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 80% 20%, rgba(255,191,0,0.05) 0%, transparent 50%);
    }
    .info-inner { max-width: 1100px; margin: 0 auto; position: relative; z-index: 2; }
    .info-title { text-align: center; margin-bottom: 48px; }
    .info-title h2 { font-family: 'Playfair Display', serif; font-size: 2rem; color: #fff; margin-bottom: 8px; }
    .info-title h2 span { color: #ffbf00; }
    .info-title p { color: rgba(255,255,255,0.55); }
    .info-title .title-line { width: 60px; height: 3px; background: #ffbf00; margin: 14px auto 0; border-radius: 2px; }

    .info-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; }
    .info-box {
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px; padding: 28px 20px; text-align: center;
        position: relative; overflow: hidden;
        transition: background 0.3s, transform 0.3s, border-color 0.3s, box-shadow 0.3s;
    }
    .info-box::before {
        content: ''; position: absolute; top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(255,191,0,0.07) 50%, transparent 70%);
        transform: translateX(-100%); transition: transform 0.5s ease;
    }
    .info-box:hover { background: rgba(255,191,0,0.1); transform: translateY(-8px); border-color: rgba(255,191,0,0.35); box-shadow: 0 16px 40px rgba(0,0,0,0.25); }
    .info-box:hover::before { transform: translateX(100%); }
    .info-icon { font-size: 2.2rem; margin-bottom: 14px; display: block; transition: transform 0.3s; }
    .info-box:hover .info-icon { transform: scale(1.2) rotate(-8deg); }
    .info-box h4 { font-family: 'Playfair Display', serif; color: #fff; font-size: 0.95rem; margin-bottom: 8px; transition: color 0.2s; }
    .info-box:hover h4 { color: #ffbf00; }
    .info-box p { color: rgba(255,255,255,0.5); font-size: 0.82rem; line-height: 1.6; }

    /* ── REVEAL ── */
    .reveal { opacity:0; transform:translateY(40px); transition:opacity 0.7s ease,transform 0.7s ease; }
    .reveal.visible { opacity:1; transform:translateY(0); }
    .reveal-left { opacity:0; transform:translateX(-50px); transition:opacity 0.8s ease,transform 0.8s ease; }
    .reveal-left.visible { opacity:1; transform:translateX(0); }
    .reveal-right { opacity:0; transform:translateX(50px); transition:opacity 0.8s ease,transform 0.8s ease; }
    .reveal-right.visible { opacity:1; transform:translateX(0); }

    @media(max-width:768px) {
        .fee-section, .info-section { padding: 60px 20px; }
        .calc-body { padding: 24px 20px; }
        .calc-form-grid { grid-template-columns: 1fr; }
        .result-details { grid-template-columns: 1fr; }
        .info-grid { grid-template-columns: repeat(2,1fr); }
        .page-hero h1 { font-size: 2rem; }
    }
    @media(max-width:480px) { .info-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')

<!-- PAGE HERO -->
<div class="page-hero">
    <div class="hero-particles" aria-hidden="true">
        <span style="width:8px;height:8px;top:20%;left:15%;animation-duration:7s;"></span>
        <span style="width:5px;height:5px;top:60%;left:80%;animation-duration:9s;animation-delay:2s;"></span>
        <span style="width:10px;height:10px;top:40%;left:60%;animation-duration:8s;animation-delay:1s;"></span>
        <span style="width:6px;height:6px;top:75%;left:30%;animation-duration:6s;animation-delay:3s;"></span>
    </div>
    <div class="page-hero-inner">
        <h1>Exit Permit <span>Fee Calculator</span></h1>
        <p>Calculate the exit permit fee required for your travel departure.</p>
    </div>
</div>

<!-- CALCULATOR SECTION -->
<div class="fee-section">

    <div class="calc-card reveal">
        <div class="calc-header">
            <span class="calc-header-icon">🚪</span>
            <h2>Exit Permit Fee Calculation</h2>
            <p>Select your permit details below to get an instant fee estimate.</p>
        </div>
        <div class="calc-body">
            <p style="text-align:center; color:rgba(255,255,255,0.5); font-size:0.85rem; margin-bottom:28px; padding-bottom:20px; border-bottom:1px solid rgba(255,255,255,0.08); letter-spacing:1px; text-transform:uppercase;">
                Select your exit permit details from below
            </p>

            <div class="calc-form-grid">
                <div class="calc-form-group">
                    <label class="calc-label">Permit Type</label>
                    <select class="calc-select" id="permitType">
                        <option value="">Please select permit type</option>
                        <option value="standard">📋 Standard Exit Permit</option>
                        <option value="emergency">🚨 Emergency Exit Permit</option>
                        <option value="transit">🛂 Transit Exit Permit</option>
                        <option value="business">💼 Business Exit Permit</option>
                    </select>
                </div>
                <div class="calc-form-group">
                    <label class="calc-label">Duration of Stay</label>
                    <select class="calc-select" id="duration">
                        <option value="">Please select duration</option>
                        <option value="30">Up to 30 Days</option>
                        <option value="60">31 – 60 Days</option>
                        <option value="90">61 – 90 Days</option>
                        <option value="180">91 – 180 Days</option>
                        <option value="365">More than 180 Days</option>
                    </select>
                </div>
                <div class="calc-form-group">
                    <label class="calc-label">Applicant Nationality</label>
                    <select class="calc-select" id="nationality">
                        <option value="">Please select nationality</option>
                        <option value="pk">🇵🇰 Pakistani</option>
                        <option value="in">🇮🇳 Indian</option>
                        <option value="bd">🇧🇩 Bangladeshi</option>
                        <option value="ae">🇦🇪 UAE National</option>
                        <option value="sa">🇸🇦 Saudi National</option>
                        <option value="other">🌍 Other</option>
                    </select>
                </div>
                <div class="calc-form-group">
                    <label class="calc-label">Processing Speed</label>
                    <select class="calc-select" id="speed">
                        <option value="">Please select processing speed</option>
                        <option value="normal">Normal (3-5 working days)</option>
                        <option value="express">Express (24-48 hours)</option>
                        <option value="urgent">Urgent (Same day)</option>
                    </select>
                </div>
            </div>

            <button class="btn-calc" onclick="calculateExitFee()">🚪 CALCULATE EXIT PERMIT FEE</button>

            <div class="calc-placeholder" id="calcPlaceholder">
                <span>👆</span>
                Select all fields above to calculate your exit permit fee instantly
            </div>
        </div>
    </div>

    <!-- RESULT CARD -->
    <div class="result-card" id="resultCard">
        <div class="result-header">
            <h3>📋 Applicable Exit Permit Fees</h3>
            <p>Based on your selected criteria</p>
        </div>
        <div class="result-body">

            <div class="result-fee-wrap">
                <div class="result-fee-label">Total Estimated Fee</div>
                <div class="result-fee" id="resultFee">PKR 0</div>
            </div>

            <div class="result-details">
                <div class="result-detail-item">
                    <div class="result-detail-label">Permit Type</div>
                    <div class="result-detail-value" id="r-permit">—</div>
                </div>
                <div class="result-detail-item">
                    <div class="result-detail-label">Duration of Stay</div>
                    <div class="result-detail-value" id="r-duration">—</div>
                </div>
                <div class="result-detail-item">
                    <div class="result-detail-label">Nationality</div>
                    <div class="result-detail-value" id="r-nationality">—</div>
                </div>
                <div class="result-detail-item">
                    <div class="result-detail-label">Processing Speed</div>
                    <div class="result-detail-value" id="r-speed">—</div>
                </div>
            </div>

            <div class="result-breakdown">
                <h4>💰 Fee Breakdown</h4>
                <div class="breakdown-row">
                    <span class="b-label">Government / Authority Fee</span>
                    <span class="b-value" id="r-gov">PKR 0</span>
                </div>
                <div class="breakdown-row">
                    <span class="b-label">VisaGo Service Fee</span>
                    <span class="b-value" id="r-service">PKR 2,000</span>
                </div>
                <div class="breakdown-row">
                    <span class="b-label">Processing Charges</span>
                    <span class="b-value" id="r-processing">PKR 0</span>
                </div>
                <div class="breakdown-row total-row">
                    <span class="b-label">Total Amount</span>
                    <span class="b-value" id="r-total">PKR 0</span>
                </div>
            </div>

            <a href="{{ url('/contact') }}" class="result-apply-btn">📞 CONTACT US TO APPLY</a>
        </div>
    </div>

</div>

<!-- INFO SECTION -->
<div class="info-section">
    <div class="info-inner">
        <div class="info-title reveal">
            <h2>📌 Important <span>Information</span></h2>
            <p>Things to know about exit permits and processing.</p>
            <div class="title-line"></div>
        </div>
        <div class="info-grid">
            <div class="info-box reveal-left" style="transition-delay:0.1s">
                <span class="info-icon">⏱</span>
                <h4>Processing Time</h4>
                <p>Standard: 3-5 working days. Express: 24-48 hours. Urgent/Same day processing available.</p>
            </div>
            <div class="info-box reveal" style="transition-delay:0.2s">
                <span class="info-icon">📋</span>
                <h4>Required Documents</h4>
                <p>Valid passport, visa copy, accommodation proof, return ticket, and employer NOC if applicable.</p>
            </div>
            <div class="info-box reveal" style="transition-delay:0.3s">
                <span class="info-icon">💳</span>
                <h4>Payment Methods</h4>
                <p>Pay securely via credit card, debit card, EasyPaisa, or JazzCash through our encrypted portal.</p>
            </div>
            <div class="info-box reveal-right" style="transition-delay:0.4s">
                <span class="info-icon">📞</span>
                <h4>Need Help?</h4>
                <p>Our exit permit experts are available 24/7. Contact us via WhatsApp or email anytime.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// EXIT PERMIT FEE TABLE — PKR
const exitFeeTable = {
    standard:  { 30: 7000,  60: 11000, 90: 17000, 180: 25000, 365: 42000 },
    emergency: { 30: 22000, 60: 28000, 90: 36000, 180: 48000, 365: 70000 },
    transit:   { 30: 4200,  60: 7000,  90: 9800,  180: 14000, 365: 22000 },
    business:  { 30: 9000,  60: 15000, 90: 22000, 180: 32000, 365: 50000 },
};

const natMultiplier = { pk: 1, in: 1.1, bd: 1, ae: 0.9, sa: 0.9, other: 1.15 };
const speedCharges  = { normal: 500, express: 2000, urgent: 4500 };
const SERVICE_FEE   = 2000;

const labels = {
    permit:   { standard:'📋 Standard Exit Permit', emergency:'🚨 Emergency Exit Permit', transit:'🛂 Transit Exit Permit', business:'💼 Business Exit Permit' },
    duration: { 30:'Up to 30 Days', 60:'31–60 Days', 90:'61–90 Days', 180:'91–180 Days', 365:'More than 180 Days' },
    nat:      { pk:'🇵🇰 Pakistani', in:'🇮🇳 Indian', bd:'🇧🇩 Bangladeshi', ae:'🇦🇪 UAE National', sa:'🇸🇦 Saudi National', other:'🌍 Other' },
    speed:    { normal:'Normal (3-5 days)', express:'Express (24-48 hrs)', urgent:'Urgent (Same day)' },
};

function fmt(n) { return 'PKR ' + Math.round(n).toLocaleString(); }

function calculateExitFee() {
    const permit = document.getElementById('permitType').value;
    const dur    = document.getElementById('duration').value;
    const nat    = document.getElementById('nationality').value;
    const speed  = document.getElementById('speed').value;

    if (!permit || !dur || !nat || !speed) {
        alert('Please select all fields to calculate your exit permit fee!');
        return;
    }

    const base       = exitFeeTable[permit][dur];
    const mult       = natMultiplier[nat];
    const govFee     = Math.round(base * mult);
    const processing = speedCharges[speed];
    const total      = govFee + SERVICE_FEE + processing;

    document.getElementById('resultFee').textContent    = fmt(total);
    document.getElementById('r-permit').textContent     = labels.permit[permit];
    document.getElementById('r-duration').textContent   = labels.duration[dur];
    document.getElementById('r-nationality').textContent= labels.nat[nat];
    document.getElementById('r-speed').textContent      = labels.speed[speed];
    document.getElementById('r-gov').textContent        = fmt(govFee);
    document.getElementById('r-service').textContent    = fmt(SERVICE_FEE);
    document.getElementById('r-processing').textContent = fmt(processing);
    document.getElementById('r-total').textContent      = fmt(total);

    const resultCard = document.getElementById('resultCard');
    resultCard.style.display = 'block';
    document.getElementById('calcPlaceholder').style.display = 'none';
    setTimeout(() => resultCard.scrollIntoView({ behavior:'smooth', block:'start' }), 100);
}

// SCROLL REVEAL
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => observer.observe(el));
</script>
@endsection