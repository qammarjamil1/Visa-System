@extends('layouts.app')
@section('title', 'Visa Fee Calculator')

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
        background: radial-gradient(circle at 50% 50%, rgba(255,191,0,0.12) 0%, transparent 65%);
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
        background: radial-gradient(circle, rgba(255,191,0,0.06) 0%, transparent 70%);
        top: -150px; right: -100px; pointer-events: none;
        animation: floatOrb 8s ease-in-out infinite alternate;
    }
    .fee-section::after {
        content: ''; position: absolute;
        width: 300px; height: 300px; border-radius: 50%;
        background: radial-gradient(circle, rgba(255,191,0,0.04) 0%, transparent 70%);
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
        background: linear-gradient(135deg, rgba(255,191,0,0.15), rgba(255,191,0,0.05));
        border-bottom: 1px solid rgba(255,191,0,0.2);
        padding: 32px 40px; text-align: center;
    }
    .calc-header h2 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.6rem; margin-bottom: 8px; }
    .calc-header p { color: rgba(255,255,255,0.6); font-size: 0.9rem; }
    .calc-header-icon { font-size: 2.5rem; margin-bottom: 12px; display: block; animation: iconFloat 3s ease-in-out infinite; }
    @keyframes iconFloat { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-8px); } }

    .calc-body { padding: 40px; }

    /* FORM GROUPS */
    .calc-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    .calc-form-group { margin-bottom: 0; transition: transform 0.2s; }
    .calc-form-group.full { grid-column: 1 / -1; }
    .calc-label {
        display: block; font-size: 0.78rem; color: rgba(255,255,255,0.6);
        letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 10px; font-weight: 600;
        transition: color 0.3s;
    }
    .calc-select {
        width: 100%; padding: 14px 18px;
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);
        border-radius: 12px; color: #fff; font-size: 0.95rem;
        outline: none; transition: border-color 0.3s, background 0.3s, box-shadow 0.3s, transform 0.2s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23c9a84c' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 16px center;
        cursor: pointer;
    }
    /* HOVER EFFECT */
    .calc-select:hover { border-color: rgba(255,191,0,0.45); background-color: rgba(255,255,255,0.09); }
    .calc-select:focus { border-color: #ffbf00; background-color: rgba(255,255,255,0.1); box-shadow: 0 0 0 3px rgba(255,191,0,0.15); }
    .calc-select option { background: #1d2e49; color: #fff; }

    /* ✅ FILLED STATE — jab field select ho jaye */
    .calc-form-group.is-filled .calc-label { color: #4ade80; }
    .calc-form-group.is-filled .calc-select {
        border-color: #4ade80 !important;
        background-color: rgba(74, 222, 128, 0.08) !important;
        box-shadow: 0 0 0 3px rgba(74, 222, 128, 0.12) !important;
    }

    /* CALC BUTTON */
    .btn-calc {
        width: 100%; padding: 16px; margin-top: 8px;
        background: linear-gradient(135deg, #ffbf00, #ffd700);
        color: #0a1628; border: none; border-radius: 12px;
        font-size: 1rem; font-weight: 800; cursor: pointer;
        letter-spacing: 0.5px; text-transform: uppercase;
        transition: transform 0.25s, box-shadow 0.25s, background 0.25s;
        box-shadow: 0 6px 20px rgba(255,191,0,0.3);
    }
    .btn-calc:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(255,191,0,0.45); background: linear-gradient(135deg, #ffcc33, #ffe580); }
    .btn-calc:active { transform: translateY(-1px); }

    /* PLACEHOLDER */
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

    /* TIER BADGE */
    .tier-badge {
        display: inline-block; padding: 5px 16px; border-radius: 100px;
        font-size: 0.75rem; font-weight: 700; margin-bottom: 18px;
        letter-spacing: 0.5px;
    }
    .tier-far    { background: rgba(255,107,107,0.15); color: #ff6b6b; border: 1px solid rgba(255,107,107,0.35); }
    .tier-mid    { background: rgba(255,191,0,0.15);   color: #ffbf00; border: 1px solid rgba(255,191,0,0.35); }
    .tier-near   { background: rgba(74,222,128,0.15);  color: #4ade80; border: 1px solid rgba(74,222,128,0.35); }

    /* FEE DISPLAY */
    .result-fee-wrap { text-align: center; margin-bottom: 24px; }
    .result-fee-label { font-size: 0.78rem; color: rgba(255,255,255,0.5); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px; }
    .result-fee {
        font-family: 'Playfair Display', serif; font-size: 3.5rem;
        font-weight: 900; color: #ffbf00;
        animation: countUp 0.6s ease;
    }
    @keyframes countUp { from { opacity:0; transform:scale(0.8); } to { opacity:1; transform:scale(1); } }

    /* RESULT DETAILS */
    .result-details { display: grid; grid-template-columns: repeat(2,1fr); gap: 16px; margin-bottom: 24px; }
    .result-detail-item {
        background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px; padding: 16px 20px;
        transition: background 0.2s, border-color 0.2s, transform 0.2s;
    }
    .result-detail-item:hover { background: rgba(255,191,0,0.08); border-color: rgba(255,191,0,0.2); transform: translateY(-2px); }
    .result-detail-label { font-size: 0.72rem; color: rgba(255,255,255,0.45); letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 6px; }
    .result-detail-value { font-size: 0.95rem; font-weight: 700; color: #fff; }

    /* BREAKDOWN */
    .result-breakdown { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; }
    .result-breakdown h4 { font-family: 'Playfair Display', serif; color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-bottom: 14px; }
    .breakdown-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 0.85rem; }
    .breakdown-row:last-child { border-bottom: none; font-weight: 700; }
    .breakdown-row .b-label { color: rgba(255,255,255,0.55); }
    .breakdown-row .b-value { color: #fff; }
    .breakdown-row.total-row .b-label { color: #fff; }
    .breakdown-row.total-row .b-value { color: #ffbf00; font-size: 1rem; }

    /* APPLY BTN IN RESULT */
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
        background: linear-gradient(45deg, transparent 30%, rgba(201,168,76,0.07) 50%, transparent 70%);
        transform: translateX(-100%); transition: transform 0.5s ease;
    }
    .info-box:hover { background: rgba(201,168,76,0.1); transform: translateY(-8px); border-color: rgba(201,168,76,0.35); box-shadow: 0 16px 40px rgba(0,0,0,0.25); }
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
    @media(max-width:480px) {
        .info-grid { grid-template-columns: 1fr; }
    }
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
        <h1>Visa Fee <span>Calculator</span></h1>
        <p>Get an instant fee estimate before submitting your visa application.</p>
    </div>
</div>

<!-- CALCULATOR SECTION -->
<div class="fee-section">

    <!-- CALC CARD -->
    <div class="calc-card reveal">
        <div class="calc-header">
            <span class="calc-header-icon">💳</span>
            <h2>Visa Fee Calculation</h2>
            <p>Select your visa details below to get an instant fee estimate.</p>
        </div>
        <div class="calc-body">
            <p style="text-align:center; color:rgba(255,255,255,0.5); font-size:0.85rem; margin-bottom:28px; padding-bottom:20px; border-bottom:1px solid rgba(255,255,255,0.08); letter-spacing:1px; text-transform:uppercase;">
                Select your required visa details from below
            </p>

            <div class="calc-form-grid">
                <div class="calc-form-group" data-field="visaCategory">
                    <label class="calc-label">Visa Category</label>
                    <select class="calc-select" id="visaCategory">
                        <option value="">What is your required Visa Category?</option>
                        <option value="tourist">🏖️ Tourist Visa</option>
                        <option value="work">💼 Work Visa</option>
                        <option value="study">🎓 Study Visa</option>
                        <option value="business">🤝 Business Visa</option>
                        <option value="family">👨‍👩‍👧 Family Visa</option>
                    </select>
                </div>
                <div class="calc-form-group" data-field="destinationCountry">
                    <label class="calc-label">Destination Country</label>
                    <select class="calc-select" id="destinationCountry">
                        <option value="">Where do you want to travel?</option>
                        <optgroup label="🔴 Far / Developed Countries">
                            <option value="USA">🇺🇸 USA</option>
                            <option value="United Kingdom">🇬🇧 United Kingdom</option>
                            <option value="Canada">🇨🇦 Canada</option>
                            <option value="Australia">🇦🇺 Australia</option>
                            <option value="Germany">🇩🇪 Germany</option>
                            <option value="France">🇫🇷 France</option>
                            <option value="Italy">🇮🇹 Italy</option>
                            <option value="Spain">🇪🇸 Spain</option>
                            <option value="Switzerland">🇨🇭 Switzerland</option>
                            <option value="Netherlands">🇳🇱 Netherlands</option>
                            <option value="Belgium">🇧🇪 Belgium</option>
                            <option value="Austria">🇦🇹 Austria</option>
                            <option value="Sweden">🇸🇪 Sweden</option>
                            <option value="Norway">🇳🇴 Norway</option>
                            <option value="Denmark">🇩🇰 Denmark</option>
                            <option value="Finland">🇫🇮 Finland</option>
                            <option value="Ireland">🇮🇪 Ireland</option>
                            <option value="Japan">🇯🇵 Japan</option>
                            <option value="South Korea">🇰🇷 South Korea</option>
                            <option value="New Zealand">🇳🇿 New Zealand</option>
                            <option value="China">🇨🇳 China</option>
                        </optgroup>
                        <optgroup label="🟡 Mid-range Countries">
                            <option value="Portugal">🇵🇹 Portugal</option>
                            <option value="Greece">🇬🇷 Greece</option>
                            <option value="Poland">🇵🇱 Poland</option>
                            <option value="Czech Republic">🇨🇿 Czech Republic</option>
                            <option value="Hungary">🇭🇺 Hungary</option>
                            <option value="Romania">🇷🇴 Romania</option>
                            <option value="Brazil">🇧🇷 Brazil</option>
                            <option value="Mexico">🇲🇽 Mexico</option>
                            <option value="South Africa">🇿🇦 South Africa</option>
                            <option value="Singapore">🇸🇬 Singapore</option>
                        </optgroup>
                        <optgroup label="🟢 Near / Gulf / Budget Countries">
                            <option value="UAE">🇦🇪 UAE</option>
                            <option value="Saudi Arabia">🇸🇦 Saudi Arabia</option>
                            <option value="Qatar">🇶🇦 Qatar</option>
                            <option value="Kuwait">🇰🇼 Kuwait</option>
                            <option value="Bahrain">🇧🇭 Bahrain</option>
                            <option value="Oman">🇴🇲 Oman</option>
                            <option value="Turkey">🇹🇷 Turkey</option>
                            <option value="Malaysia">🇲🇾 Malaysia</option>
                            <option value="Thailand">🇹🇭 Thailand</option>
                            <option value="Indonesia">🇮🇩 Indonesia</option>
                            <option value="Philippines">🇵🇭 Philippines</option>
                            <option value="Vietnam">🇻🇳 Vietnam</option>
                            <option value="Sri Lanka">🇱🇰 Sri Lanka</option>
                            <option value="Nepal">🇳🇵 Nepal</option>
                            <option value="Egypt">🇪🇬 Egypt</option>
                            <option value="Morocco">🇲🇦 Morocco</option>
                        </optgroup>
                    </select>
                </div>
                <div class="calc-form-group" data-field="entryType">
                    <label class="calc-label">Entry Type</label>
                    <select class="calc-select" id="entryType">
                        <option value="">Please select entry type</option>
                        <option value="single">Single Entry</option>
                        <option value="multiple">Multiple Entry</option>
                    </select>
                </div>
                <div class="calc-form-group" data-field="applicationType">
                    <label class="calc-label">Application Type</label>
                    <select class="calc-select" id="applicationType">
                        <option value="">Please select application type</option>
                        <option value="normal">Normal Processing (5-7 days)</option>
                        <option value="express">Express Processing (2-3 days)</option>
                        <option value="urgent">Urgent Processing (24 hours)</option>
                    </select>
                </div>
            </div>

            <button class="btn-calc" onclick="calculateFee()">💰 CALCULATE YOUR FEE</button>

            <div class="calc-placeholder" id="calcPlaceholder">
                <span>👆</span>
                Select all fields above to calculate your visa fee instantly
            </div>
        </div>
    </div>

    <!-- RESULT CARD -->
    <div class="result-card" id="resultCard">
        <div class="result-header">
            <h3>📋 Applicable Fees</h3>
            <p>Based on your selected criteria</p>
        </div>
        <div class="result-body">

            <div style="text-align:center;">
                <span class="tier-badge" id="r-tier-badge">—</span>
            </div>

            <!-- BIG FEE -->
            <div class="result-fee-wrap">
                <div class="result-fee-label">Total Estimated Fee</div>
                <div class="result-fee" id="resultFee">PKR 0</div>
            </div>

            <!-- DETAILS GRID -->
            <div class="result-details">
                <div class="result-detail-item">
                    <div class="result-detail-label">Visa Category</div>
                    <div class="result-detail-value" id="r-category">—</div>
                </div>
                <div class="result-detail-item">
                    <div class="result-detail-label">Destination</div>
                    <div class="result-detail-value" id="r-destination">—</div>
                </div>
                <div class="result-detail-item">
                    <div class="result-detail-label">Entry Type</div>
                    <div class="result-detail-value" id="r-entry">—</div>
                </div>
                <div class="result-detail-item">
                    <div class="result-detail-label">Processing Type</div>
                    <div class="result-detail-value" id="r-apptype">—</div>
                </div>
            </div>

            <!-- BREAKDOWN -->
            <div class="result-breakdown">
                <h4>💰 Fee Breakdown</h4>
                <div class="breakdown-row">
                    <span class="b-label">Embassy / Government Fee</span>
                    <span class="b-value" id="r-embassy">PKR 0</span>
                </div>
                <div class="breakdown-row">
                    <span class="b-label">VisaGo Service Fee</span>
                    <span class="b-value" id="r-service">PKR 2,500</span>
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

            <a href="{{ url('/booking') }}" class="result-apply-btn">✈️ APPLY NOW WITH THESE DETAILS</a>
        </div>
    </div>

</div>

<!-- INFO SECTION -->
<div class="info-section">
    <div class="info-inner">
        <div class="info-title reveal">
            <h2>📌 Important <span>Information</span></h2>
            <p>Things to know about visa fees and processing.</p>
            <div class="title-line"></div>
        </div>
        <div class="info-grid">
            <div class="info-box reveal-left" style="transition-delay:0.1s">
                <span class="info-icon">⏱</span>
                <h4>Processing Time</h4>
                <p>Normal: 5-7 days. Express: 2-3 days. Urgent: 24 hours. Times may vary by embassy workload.</p>
            </div>
            <div class="info-box reveal" style="transition-delay:0.2s">
                <span class="info-icon">📋</span>
                <h4>Required Documents</h4>
                <p>Valid passport, photographs, bank statement, travel itinerary, and accommodation proof required.</p>
            </div>
            <div class="info-box reveal" style="transition-delay:0.3s">
                <span class="info-icon">💳</span>
                <h4>Payment Methods</h4>
                <p>Pay securely via credit card, debit card, EasyPaisa, or JazzCash through our encrypted portal.</p>
            </div>
            <div class="info-box reveal-right" style="transition-delay:0.4s">
                <span class="info-icon">📞</span>
                <h4>Need Help?</h4>
                <p>Our visa experts are available 24/7. Contact us via WhatsApp or email for personalized assistance.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// BASE FEE TABLE — PKR (before destination-country tier multiplier)
const feeTable = {
    tourist:  { single: { normal: 14000, express: 22000, urgent: 34000 }, multiple: { normal: 25000, express: 36000, urgent: 50000 } },
    work:     { single: { normal: 42000, express: 56000, urgent: 78000 }, multiple: { normal: 70000, express: 90000, urgent: 118000 } },
    study:    { single: { normal: 28000, express: 42000, urgent: 56000 }, multiple: { normal: 50000, express: 67000, urgent: 84000 } },
    business: { single: { normal: 34000, express: 48000, urgent: 64000 }, multiple: { normal: 56000, express: 76000, urgent: 101000 } },
    family:   { single: { normal: 20000, express: 31000, urgent: 45000 }, multiple: { normal: 36000, express: 50000, urgent: 67000 } },
};

// DESTINATION COUNTRY TIERS — door mulk = zyada fee, qareeb mulk = kam fee
const farCountries = ['USA','United Kingdom','Canada','Australia','Germany','France','Italy','Spain','Switzerland','Netherlands','Belgium','Austria','Sweden','Norway','Denmark','Finland','Ireland','Japan','South Korea','New Zealand','China'];
const midCountries = ['Portugal','Greece','Poland','Czech Republic','Hungary','Romania','Brazil','Mexico','South Africa','Singapore'];
const nearCountries = ['UAE','Saudi Arabia','Qatar','Kuwait','Bahrain','Oman','Turkey','Malaysia','Thailand','Indonesia','Philippines','Vietnam','Sri Lanka','Nepal','Egypt','Morocco'];

function getCountryTier(country) {
    if (farCountries.includes(country))  return { mult: 1.5, label: '🔴 Far / Developed Country', css: 'tier-far' };
    if (midCountries.includes(country))  return { mult: 1.1, label: '🟡 Mid-range Country',        css: 'tier-mid' };
    if (nearCountries.includes(country)) return { mult: 0.75,label: '🟢 Near / Budget Country',     css: 'tier-near' };
    return { mult: 1, label: '—', css: 'tier-mid' };
}

const SERVICE_FEE    = 2500;
const PROCESSING_FEE = { normal: 500, express: 1500, urgent: 3000 };

const labels = {
    category: { tourist:'🏖️ Tourist Visa', work:'💼 Work Visa', study:'🎓 Study Visa', business:'🤝 Business Visa', family:'👨‍👩‍👧 Family Visa' },
    entry:    { single:'Single Entry', multiple:'Multiple Entry' },
    apptype:  { normal:'Normal Processing (5-7 days)', express:'Express Processing (2-3 days)', urgent:'Urgent Processing (24 hours)' },
};

function fmt(n) { return 'PKR ' + Math.round(n).toLocaleString(); }

// ✅ FILLED-STATE HIGHLIGHT (jab select ho jaye to green glow)
document.querySelectorAll('.calc-form-group .calc-select').forEach(sel => {
    function refresh() {
        const group = sel.closest('.calc-form-group');
        if (sel.value) group.classList.add('is-filled'); else group.classList.remove('is-filled');
    }
    sel.addEventListener('change', refresh);
    sel.addEventListener('focus', function () { this.closest('.calc-form-group').style.transform = 'scale(1.01)'; });
    sel.addEventListener('blur', function () { this.closest('.calc-form-group').style.transform = 'scale(1)'; });
});

function calculateFee() {
    const cat         = document.getElementById('visaCategory').value;
    const destination = document.getElementById('destinationCountry').value;
    const entry       = document.getElementById('entryType').value;
    const apptype     = document.getElementById('applicationType').value;

    if (!cat || !destination || !entry || !apptype) {
        alert('Please select all fields to calculate your fee!');
        return;
    }

    const base       = feeTable[cat][entry][apptype];
    const tier       = getCountryTier(destination);
    const embassy    = Math.round(base * tier.mult);
    const processing = PROCESSING_FEE[apptype];
    const total      = embassy + SERVICE_FEE + processing;

    // Update result
    document.getElementById('resultFee').textContent    = fmt(total);
    document.getElementById('r-category').textContent   = labels.category[cat];
    document.getElementById('r-destination').textContent = destination;
    document.getElementById('r-entry').textContent      = labels.entry[entry];
    document.getElementById('r-apptype').textContent    = labels.apptype[apptype];
    document.getElementById('r-embassy').textContent    = fmt(embassy);
    document.getElementById('r-service').textContent    = fmt(SERVICE_FEE);
    document.getElementById('r-processing').textContent = fmt(processing);
    document.getElementById('r-total').textContent      = fmt(total);

    const badge = document.getElementById('r-tier-badge');
    badge.textContent = tier.label;
    badge.className = 'tier-badge ' + tier.css;

    // Show result
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