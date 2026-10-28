@extends('layouts.app')
@section('title', 'Apply for Visa')
@section('styles')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    @keyframes heroPulse { 0%,100%{transform:scale(1);opacity:0.8;} 50%{transform:scale(1.1);opacity:1;} }
    .page-hero-inner { position: relative; z-index: 2; animation: fadeUp 0.9s ease both; }
    .page-hero h1 { font-family: 'Playfair Display', serif; font-size: 2.8rem; color: #fff; margin-bottom: 12px; }
    .page-hero h1 span { color: #c9a84c; }
    .page-hero p { color: rgba(255,255,255,0.65); font-size: 1rem; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(24px);} to{opacity:1;transform:translateY(0);} }
    .hero-particles span {
        position: absolute; border-radius: 50%;
        background: rgba(201,168,76,0.15); animation: floatDot linear infinite;
    }
    @keyframes floatDot { 0%{transform:translateY(0) scale(1);opacity:0.7;} 100%{transform:translateY(-100px) scale(0.5);opacity:0;} }

    /* ── MAIN SECTION ── */
    .booking-section {
        background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%);
        padding: 70px 48px 80px; position: relative; overflow: hidden;
    }
    .booking-section::before {
        content: ''; position: absolute;
        width: 500px; height: 500px; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 70%);
        top: -150px; right: -100px; pointer-events: none;
        animation: floatOrb 8s ease-in-out infinite alternate;
    }
    .booking-section::after {
        content: ''; position: absolute;
        width: 300px; height: 300px; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,168,76,0.04) 0%, transparent 70%);
        bottom: -80px; left: -60px; pointer-events: none;
    }
    @keyframes floatOrb { 0%{transform:translateY(0);} 100%{transform:translateY(40px);} }

    /* AUTO-SAVE BANNER */
    .autosave-banner {
        max-width: 860px; margin: 0 auto 24px;
        background: rgba(46, 204, 113, 0.1);
        border: 1px solid rgba(46, 204, 113, 0.35);
        border-radius: 14px; padding: 16px 24px;
        display: flex; align-items: center; gap: 12px;
        color: #4ade80; font-size: 0.9rem; font-weight: 600;
        position: relative; z-index: 2;
        animation: fadeUp 0.5s ease both;
    }
    .autosave-banner .icon { font-size: 1.3rem; flex-shrink: 0; }

    /* ── FORM CARD ── */
    .form-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 24px; overflow: hidden;
        max-width: 860px; margin: 0 auto;
        box-shadow: 0 24px 60px rgba(0,0,0,0.3);
        transition: box-shadow 0.3s; position: relative; z-index: 2;
    }
    .form-card:hover { box-shadow: 0 32px 72px rgba(0,0,0,0.4); }

    .form-card-header {
        background: linear-gradient(135deg, rgba(201,168,76,0.15), rgba(201,168,76,0.05));
        border-bottom: 1px solid rgba(201,168,76,0.2);
        padding: 28px 40px;
    }
    .form-card-header h2 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.4rem; margin-bottom: 4px; }
    .form-card-header p { color: rgba(255,255,255,0.55); font-size: 0.88rem; }

    .form-body { padding: 40px; }

    /* SECTION LABELS */
    .section-label {
        font-family: 'Playfair Display', serif;
        font-size: 1.05rem; color: #c9a84c;
        margin-bottom: 20px; padding-bottom: 12px;
        border-bottom: 1px solid rgba(201,168,76,0.2);
        display: flex; align-items: center; gap: 8px;
    }

    /* FORM GRID */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    .form-group { margin-bottom: 0; transition: transform 0.2s; }
    .form-group.full { grid-column: 1 / -1; }

    .form-group label {
        display: block; font-size: 0.78rem; color: rgba(255,255,255,0.6);
        letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 10px; font-weight: 600;
        transition: color 0.3s;
    }

    .form-group input,
    .form-group select {
        width: 100%; padding: 14px 18px; height: 52px;
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);
        border-radius: 12px; color: #fff; font-size: 0.95rem;
        outline: none; transition: border-color 0.3s, background 0.3s, box-shadow 0.3s, transform 0.2s;
        box-sizing: border-box;
    }
    .form-group input::placeholder { color: rgba(255,255,255,0.3); }

    /* HOVER EFFECT — jab tak field khaali ho */
    .form-group input:hover,
    .form-group select:hover,
    .form-group textarea:hover {
        border-color: rgba(201,168,76,0.4);
        background: rgba(255,255,255,0.09);
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #c9a84c; background: rgba(255,255,255,0.1);
        box-shadow: 0 0 0 3px rgba(201,168,76,0.15);
    }
    .form-group select { appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23c9a84c' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 16px center;
        background-color: rgba(255,255,255,0.06);
    }
    .form-group select option { background: #1d2e49; color: #fff; }

    .form-group textarea {
        width: 100%; padding: 14px 18px;
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);
        border-radius: 12px; color: #fff; font-size: 0.95rem;
        outline: none; transition: border-color 0.3s, background 0.3s, box-shadow 0.3s;
        resize: vertical; min-height: 110px; box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }
    .form-group textarea::placeholder { color: rgba(255,255,255,0.3); }
    .form-group textarea:focus { border-color: #c9a84c; background: rgba(255,255,255,0.1); box-shadow: 0 0 0 3px rgba(201,168,76,0.15); }

    /* ✅ FILLED STATE — jab field successfully bhar jaye */
    .form-group.is-filled label { color: #4ade80; }
    .form-group.is-filled input,
    .form-group.is-filled select,
    .form-group.is-filled textarea {
        border-color: #4ade80 !important;
        background: rgba(74, 222, 128, 0.08) !important;
        box-shadow: 0 0 0 3px rgba(74, 222, 128, 0.12) !important;
    }
    .form-group.is-filled::after {
        content: '✓';
        color: #4ade80;
    }

    .error-msg { color: #ff6b6b; font-size: 0.78rem; margin-top: 6px; }

    /* DIVIDER */
    .form-divider { height: 1px; background: linear-gradient(90deg, transparent, rgba(201,168,76,0.2), transparent); margin: 28px 0; }

    /* SUBMIT BTN */
    .btn-submit {
        width: 100%; padding: 17px; margin-top: 8px;
        background: linear-gradient(135deg, #c9a84c, #e2c06a);
        color: #0a1628; border: none; border-radius: 12px;
        font-size: 1.05rem; font-weight: 800; cursor: pointer;
        letter-spacing: 0.5px; text-transform: uppercase;
        transition: transform 0.25s, box-shadow 0.25s;
        box-shadow: 0 6px 20px rgba(201,168,76,0.3);
    }
    .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(201,168,76,0.45); }
    .btn-submit:active { transform: translateY(-1px); }

    /* TRUST BADGES */
    .trust-bar {
        display: flex; justify-content: center; gap: 24px; flex-wrap: wrap;
        margin-top: 28px; position: relative; z-index: 2;
    }
    .trust-item {
        display: flex; align-items: center; gap: 8px;
        color: rgba(255,255,255,0.5); font-size: 0.82rem;
        background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1);
        padding: 8px 16px; border-radius: 100px;
        transition: border-color 0.2s, color 0.2s, transform 0.2s;
    }
    .trust-item:hover { border-color: rgba(201,168,76,0.3); color: #c9a84c; transform: translateY(-2px); }
    .trust-item span { font-size: 1rem; }

    /* SUCCESS POPUP */
    #submitPopup {
        position: fixed; inset: 0; background: rgba(0,0,0,0.8);
        z-index: 9999; display: none; align-items: center; justify-content: center;
    }
    #submitPopup.show { display: flex; }
    .popup-box {
        background: linear-gradient(135deg, #1d2e49, #1f3353);
        border: 1px solid rgba(201,168,76,0.3);
        border-radius: 24px; padding: 48px 40px;
        max-width: 480px; width: 90%; text-align: center;
        animation: popIn 0.4s ease; box-shadow: 0 24px 60px rgba(0,0,0,0.5);
    }
    @keyframes popIn { from{opacity:0;transform:scale(0.85);} to{opacity:1;transform:scale(1);} }
    .popup-check {
        width: 80px; height: 80px; border-radius: 50%;
        background: linear-gradient(135deg, #c9a84c, #e2c06a);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 24px; font-size: 2.5rem;
        box-shadow: 0 8px 24px rgba(201,168,76,0.4);
        animation: bounceIn 0.6s ease;
    }
    @keyframes bounceIn { 0%{transform:scale(0);} 60%{transform:scale(1.2);} 100%{transform:scale(1);} }
    .popup-box h3 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.8rem; margin-bottom: 12px; }
    .popup-box p { color: rgba(255,255,255,0.65); font-size: 0.92rem; line-height: 1.7; margin-bottom: 28px; }
    .popup-btns { display: flex; flex-direction: column; gap: 12px; }
    .popup-btn-primary {
        background: linear-gradient(135deg, #c9a84c, #e2c06a);
        color: #0a1628; padding: 14px 28px; border-radius: 12px;
        text-decoration: none; font-weight: 800; font-size: 0.95rem;
        transition: transform 0.2s, box-shadow 0.2s; display: block;
    }
    .popup-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(201,168,76,0.4); color: #0a1628; }
    .popup-btn-secondary {
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.7); padding: 12px 28px; border-radius: 12px;
        text-decoration: none; font-weight: 600; font-size: 0.9rem;
        transition: background 0.2s, color 0.2s; display: block;
    }
    .popup-btn-secondary:hover { background: rgba(255,255,255,0.12); color: #fff; }

    /* REVEAL */
    .reveal { opacity:0; transform:translateY(40px); transition:opacity 0.7s ease,transform 0.7s ease; }
    .reveal.visible { opacity:1; transform:translateY(0); }

    /* ── RESPONSIVE ── */
    @media(max-width:768px) {
        .booking-section { padding: 50px 20px 60px; }
        .form-body { padding: 24px 20px; }
        .form-card-header { padding: 24px 20px; }
        .form-grid { grid-template-columns: 1fr; }
        .page-hero h1 { font-size: 2rem; }
        .page-hero { padding: 50px 24px; min-height: 220px; }
        .trust-bar { gap: 12px; }
        .popup-box { padding: 36px 24px; }
    }
    @media(max-width:480px) {
        .page-hero h1 { font-size: 1.7rem; }
        .trust-bar { flex-direction: column; align-items: center; }
    }
</style>
@endsection

@section('content')

<!-- SUCCESS POPUP -->
@if(session('application_submitted'))
<div id="submitPopup" class="show">
    <div class="popup-box">
        <div class="popup-check">✅</div>
        <h3>Application Submitted!</h3>
        <p>Your visa application has been successfully submitted to VisaGo. Next step is to upload your required documents to complete the process.</p>
        <div class="popup-btns">
            <a href="{{ url('/upload-documents') }}" class="popup-btn-primary">
                📁 Next Step: Upload Documents →
            </a>
            <a href="{{ url('/') }}" class="popup-btn-secondary">
                🏠 Go to Home
            </a>
        </div>
    </div>
</div>
@endif

<!-- PAGE HERO -->
<div class="page-hero">
    <div class="hero-particles" aria-hidden="true">
        <span style="width:8px;height:8px;top:20%;left:15%;animation-duration:7s;"></span>
        <span style="width:5px;height:5px;top:60%;left:80%;animation-duration:9s;animation-delay:2s;"></span>
        <span style="width:10px;height:10px;top:40%;left:60%;animation-duration:8s;animation-delay:1s;"></span>
        <span style="width:6px;height:6px;top:75%;left:30%;animation-duration:6s;animation-delay:3s;"></span>
    </div>
    <div class="page-hero-inner">
        <h1>Apply for <span>Visa</span></h1>
        <p>Fill the form below and we will process your application with expert guidance.</p>
    </div>
</div>

<!-- BOOKING SECTION -->
<div class="booking-section">

    <!-- AUTO-SAVE CONFIRMATION BANNER -->
    @if(!empty($prefill_country) && !empty($prefill_visa_type))
    <div class="autosave-banner reveal">
        <span class="icon">✅</span>
        <span>Your visa selection has been auto-saved — <strong>{{ $prefill_country }}</strong> ({{ ucfirst($prefill_visa_type) }} Visa). Just complete the form below to continue.</span>
    </div>
    @elseif(!empty($prefill_visa_type))
    <div class="autosave-banner reveal">
        <span class="icon">✅</span>
        <span>Your visa type has been auto-saved — <strong>{{ ucfirst($prefill_visa_type) }} Visa</strong>. Please select your destination country below.</span>
    </div>
    @elseif(!empty($prefill_country))
    <div class="autosave-banner reveal">
        <span class="icon">✅</span>
        <span>Your destination has been auto-saved — <strong>{{ $prefill_country }}</strong>. Please select your visa type below.</span>
    </div>
    @endif

    <div class="form-card reveal">
        <div class="form-card-header">
            <h2>✈️ Visa Application Form</h2>
            <p>Please fill all fields accurately. Incorrect information may delay your application.</p>
        </div>
        <div class="form-body">
            <form method="POST" action="{{ route('booking.submit') }}" id="visaForm">
                @csrf

                <!-- PERSONAL INFO -->
                <div class="section-label">👤 Personal Information</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name"
                            value="{{ old('full_name', Auth::user()->name) }}"
                            placeholder="Enter your full name" required/>
                        @error('full_name') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email"
                            value="{{ old('email', Auth::user()->email) }}"
                            placeholder="Enter your email" required/>
                        @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" id="phoneInput"
                            value="{{ old('phone') }}"
                            placeholder="+92 300 1234567"
                            inputmode="tel"
                            pattern="^[0-9+\-\s]+$"
                            required/>
                        <div class="error-msg" id="phoneError" style="display:none;">Only numbers, +, - and spaces are allowed.</div>
                        @error('phone') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Nationality</label>
                        <select name="nationality" required>
                            <option value="">-- Select Nationality --</option>
                            <option value="Pakistani" {{ old('nationality')=='Pakistani'?'selected':'' }}>🇵🇰 Pakistani</option>
                            <option value="Indian"    {{ old('nationality')=='Indian'?'selected':'' }}>🇮🇳 Indian</option>
                            <option value="Bangladeshi" {{ old('nationality')=='Bangladeshi'?'selected':'' }}>🇧🇩 Bangladeshi</option>
                            <option value="British"   {{ old('nationality')=='British'?'selected':'' }}>🇬🇧 British</option>
                            <option value="American"  {{ old('nationality')=='American'?'selected':'' }}>🇺🇸 American</option>
                            <option value="Canadian"  {{ old('nationality')=='Canadian'?'selected':'' }}>🇨🇦 Canadian</option>
                            <option value="Australian" {{ old('nationality')=='Australian'?'selected':'' }}>🇦🇺 Australian</option>
                            <option value="German"    {{ old('nationality')=='German'?'selected':'' }}>🇩🇪 German</option>
                            <option value="Emirati"   {{ old('nationality')=='Emirati'?'selected':'' }}>🇦🇪 Emirati</option>
                            <option value="Saudi"     {{ old('nationality')=='Saudi'?'selected':'' }}>🇸🇦 Saudi</option>
                            <option value="Other"     {{ old('nationality')=='Other'?'selected':'' }}>🌍 Other</option>
                        </select>
                        @error('nationality') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Passport Number</label>
                        <input type="text" name="passport_number"
                            value="{{ old('passport_number') }}"
                            placeholder="e.g. AB1234567" required/>
                        @error('passport_number') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-divider"></div>

                <!-- VISA DETAILS -->
                <div class="section-label">✈️ Visa Details</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Visa Type</label>
                        <select name="visa_type" id="visaTypeSelect" required>
                            <option value="">-- Select Visa Type --</option>
                            <option value="tourist"  {{ (old('visa_type') ?: $prefill_visa_type) == 'tourist'  ? 'selected' : '' }}>🏖️ Tourist Visa</option>
                            <option value="work"     {{ (old('visa_type') ?: $prefill_visa_type) == 'work'     ? 'selected' : '' }}>💼 Work Visa</option>
                            <option value="study"    {{ (old('visa_type') ?: $prefill_visa_type) == 'study'    ? 'selected' : '' }}>🎓 Study Visa</option>
                            <option value="business" {{ (old('visa_type') ?: $prefill_visa_type) == 'business' ? 'selected' : '' }}>🤝 Business Visa</option>
                            <option value="family"   {{ (old('visa_type') ?: $prefill_visa_type) == 'family'   ? 'selected' : '' }}>👨‍👩‍👧 Family Visa</option>
                        </select>
                        @error('visa_type') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Destination Country</label>
                        <select name="country" id="countrySelect" required>
                            <option value="">-- Select Country --</option>
                            <option value="USA" {{ (old('country') ?: $prefill_country) == 'USA' ? 'selected' : '' }}>🇺🇸 USA</option>
                            <option value="United Kingdom" {{ (old('country') ?: $prefill_country) == 'United Kingdom' ? 'selected' : '' }}>🇬🇧 United Kingdom</option>
                            <option value="Canada" {{ (old('country') ?: $prefill_country) == 'Canada' ? 'selected' : '' }}>🇨🇦 Canada</option>
                            <option value="Australia" {{ (old('country') ?: $prefill_country) == 'Australia' ? 'selected' : '' }}>🇦🇺 Australia</option>
                            <option value="Germany" {{ (old('country') ?: $prefill_country) == 'Germany' ? 'selected' : '' }}>🇩🇪 Germany</option>
                            <option value="France" {{ (old('country') ?: $prefill_country) == 'France' ? 'selected' : '' }}>🇫🇷 France</option>
                            <option value="UAE" {{ (old('country') ?: $prefill_country) == 'UAE' ? 'selected' : '' }}>🇦🇪 UAE</option>
                            <option value="Saudi Arabia" {{ (old('country') ?: $prefill_country) == 'Saudi Arabia' ? 'selected' : '' }}>🇸🇦 Saudi Arabia</option>
                            <option value="Italy" {{ (old('country') ?: $prefill_country) == 'Italy' ? 'selected' : '' }}>🇮🇹 Italy</option>
                            <option value="Turkey" {{ (old('country') ?: $prefill_country) == 'Turkey' ? 'selected' : '' }}>🇹🇷 Turkey</option>
                            <option value="China" {{ (old('country') ?: $prefill_country) == 'China' ? 'selected' : '' }}>🇨🇳 China</option>
                            <option value="Japan" {{ (old('country') ?: $prefill_country) == 'Japan' ? 'selected' : '' }}>🇯🇵 Japan</option>
                            <option value="Malaysia" {{ (old('country') ?: $prefill_country) == 'Malaysia' ? 'selected' : '' }}>🇲🇾 Malaysia</option>
                            <option value="Thailand" {{ (old('country') ?: $prefill_country) == 'Thailand' ? 'selected' : '' }}>🇹🇭 Thailand</option>
                            <option value="New Zealand" {{ (old('country') ?: $prefill_country) == 'New Zealand' ? 'selected' : '' }}>🇳🇿 New Zealand</option>
                            <option value="Spain" {{ (old('country') ?: $prefill_country) == 'Spain' ? 'selected' : '' }}>🇪🇸 Spain</option>
                            <option value="Portugal" {{ (old('country') ?: $prefill_country) == 'Portugal' ? 'selected' : '' }}>🇵🇹 Portugal</option>
                            <option value="Netherlands" {{ (old('country') ?: $prefill_country) == 'Netherlands' ? 'selected' : '' }}>🇳🇱 Netherlands</option>
                            <option value="Belgium" {{ (old('country') ?: $prefill_country) == 'Belgium' ? 'selected' : '' }}>🇧🇪 Belgium</option>
                            <option value="Switzerland" {{ (old('country') ?: $prefill_country) == 'Switzerland' ? 'selected' : '' }}>🇨🇭 Switzerland</option>
                            <option value="Austria" {{ (old('country') ?: $prefill_country) == 'Austria' ? 'selected' : '' }}>🇦🇹 Austria</option>
                            <option value="Sweden" {{ (old('country') ?: $prefill_country) == 'Sweden' ? 'selected' : '' }}>🇸🇪 Sweden</option>
                            <option value="Norway" {{ (old('country') ?: $prefill_country) == 'Norway' ? 'selected' : '' }}>🇳🇴 Norway</option>
                            <option value="Denmark" {{ (old('country') ?: $prefill_country) == 'Denmark' ? 'selected' : '' }}>🇩🇰 Denmark</option>
                            <option value="Qatar" {{ (old('country') ?: $prefill_country) == 'Qatar' ? 'selected' : '' }}>🇶🇦 Qatar</option>
                            <option value="Kuwait" {{ (old('country') ?: $prefill_country) == 'Kuwait' ? 'selected' : '' }}>🇰🇼 Kuwait</option>
                            <option value="Bahrain" {{ (old('country') ?: $prefill_country) == 'Bahrain' ? 'selected' : '' }}>🇧🇭 Bahrain</option>
                            <option value="Oman" {{ (old('country') ?: $prefill_country) == 'Oman' ? 'selected' : '' }}>🇴🇲 Oman</option>
                            <option value="Singapore" {{ (old('country') ?: $prefill_country) == 'Singapore' ? 'selected' : '' }}>🇸🇬 Singapore</option>
                            <option value="South Korea" {{ (old('country') ?: $prefill_country) == 'South Korea' ? 'selected' : '' }}>🇰🇷 South Korea</option>
                            <option value="Indonesia" {{ (old('country') ?: $prefill_country) == 'Indonesia' ? 'selected' : '' }}>🇮🇩 Indonesia</option>
                            <option value="Philippines" {{ (old('country') ?: $prefill_country) == 'Philippines' ? 'selected' : '' }}>🇵🇭 Philippines</option>
                            <option value="Vietnam" {{ (old('country') ?: $prefill_country) == 'Vietnam' ? 'selected' : '' }}>🇻🇳 Vietnam</option>
                            <option value="Sri Lanka" {{ (old('country') ?: $prefill_country) == 'Sri Lanka' ? 'selected' : '' }}>🇱🇰 Sri Lanka</option>
                            <option value="Nepal" {{ (old('country') ?: $prefill_country) == 'Nepal' ? 'selected' : '' }}>🇳🇵 Nepal</option>
                            <option value="South Africa" {{ (old('country') ?: $prefill_country) == 'South Africa' ? 'selected' : '' }}>🇿🇦 South Africa</option>
                            <option value="Egypt" {{ (old('country') ?: $prefill_country) == 'Egypt' ? 'selected' : '' }}>🇪🇬 Egypt</option>
                            <option value="Morocco" {{ (old('country') ?: $prefill_country) == 'Morocco' ? 'selected' : '' }}>🇲🇦 Morocco</option>
                            <option value="Brazil" {{ (old('country') ?: $prefill_country) == 'Brazil' ? 'selected' : '' }}>🇧🇷 Brazil</option>
                            <option value="Mexico" {{ (old('country') ?: $prefill_country) == 'Mexico' ? 'selected' : '' }}>🇲🇽 Mexico</option>
                            <option value="Greece" {{ (old('country') ?: $prefill_country) == 'Greece' ? 'selected' : '' }}>🇬🇷 Greece</option>
                            <option value="Poland" {{ (old('country') ?: $prefill_country) == 'Poland' ? 'selected' : '' }}>🇵🇱 Poland</option>
                            <option value="Czech Republic" {{ (old('country') ?: $prefill_country) == 'Czech Republic' ? 'selected' : '' }}>🇨🇿 Czech Republic</option>
                            <option value="Hungary" {{ (old('country') ?: $prefill_country) == 'Hungary' ? 'selected' : '' }}>🇭🇺 Hungary</option>
                            <option value="Romania" {{ (old('country') ?: $prefill_country) == 'Romania' ? 'selected' : '' }}>🇷🇴 Romania</option>
                            <option value="Finland" {{ (old('country') ?: $prefill_country) == 'Finland' ? 'selected' : '' }}>🇫🇮 Finland</option>
                            <option value="Ireland" {{ (old('country') ?: $prefill_country) == 'Ireland' ? 'selected' : '' }}>🇮🇪 Ireland</option>
                        </select>
                        @error('country') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Travel Date</label>
                        <input type="date" name="travel_date"
                            value="{{ old('travel_date') }}" required/>
                        @error('travel_date') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Duration (Days)</label>
                        <input type="number" name="duration_days"
                            value="{{ old('duration_days') }}"
                            placeholder="e.g. 30" min="1" required/>
                        @error('duration_days') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group full">
                        <label>Purpose of Travel</label>
                        <textarea name="purpose" placeholder="Briefly describe your purpose of travel...">{{ old('purpose') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Submit Application ✈️</button>
            </form>
        </div>
    </div>

    <!-- TRUST BADGES -->
    <div class="trust-bar reveal">
        <div class="trust-item"><span>🔒</span> SSL Secured</div>
        <div class="trust-item"><span>✅</span> Verified Agency</div>
        <div class="trust-item"><span>⚡</span> Fast Processing</div>
        <div class="trust-item"><span>🌍</span> 120+ Countries</div>
        <div class="trust-item"><span>📞</span> 24/7 Support</div>
    </div>

</div>

@endsection

@section('scripts')
<script>
// SCROLL REVEAL
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
// PHONE NUMBER VALIDATION — sirf numbers, +, -, space allowed
const phoneInput = document.getElementById('phoneInput');
const phoneError = document.getElementById('phoneError');
const phonePattern = /^[0-9+\-\s]*$/;

if (phoneInput) {
    phoneInput.addEventListener('input', function () {
        if (!phonePattern.test(this.value)) {
            // Galat characters turant hata do
            this.value = this.value.replace(/[^0-9+\-\s]/g, '');
            phoneError.style.display = 'block';
            this.style.borderColor = '#ff6b6b';
        } else {
            phoneError.style.display = 'none';
        }
    });

    phoneInput.addEventListener('blur', function () {
        phoneError.style.display = 'none';
        this.style.borderColor = '';
    });
}

// INPUT FOCUS + FILLED-STATE ANIMATION (applies to ALL fields in the form)
document.querySelectorAll('#visaForm input, #visaForm select, #visaForm textarea').forEach(el => {

    function refreshFilledState() {
        const group = el.closest('.form-group');
        if (!group) return;
        if (el.value && el.value.trim() !== '') {
            group.classList.add('is-filled');
        } else {
            group.classList.remove('is-filled');
        }
    }

    // Page load par bhi check karo (auto-filled values ke liye)
    refreshFilledState();

    el.addEventListener('input', refreshFilledState);
    el.addEventListener('change', refreshFilledState);

    el.addEventListener('focus', function() {
        this.closest('.form-group').style.transform = 'scale(1.01)';
    });
    el.addEventListener('blur', function() {
        this.closest('.form-group').style.transform = 'scale(1)';
    });
});

// ── LOCKED CHOICE CONFIRMATION (Visa Type & Country) ──
function setupChoiceLock(selectEl, lockedValue, labelText) {
    if (!selectEl || !lockedValue) return;

    let currentValue = selectEl.value;
    let isLocked = true;

    selectEl.addEventListener('change', function () {
        const newValue = this.value;

        if (isLocked && newValue !== currentValue) {
            const previousValue = currentValue;
            this.value = previousValue; // pehle purani value par wapis rakho jab tak confirm na ho

            const askConfirmation = (onYes, onNo) => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Change ' + labelText + '?',
                        html: 'You already chose <b>' + previousValue + '</b> as your ' + labelText + '. Do you want to change it?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, change it',
                        cancelButtonText: 'No, keep it',
                        confirmButtonColor: '#c9a84c',
                        cancelButtonColor: '#3a3a3a',
                        background: '#1d2e49',
                        color: '#fff'
                    }).then((result) => {
                        if (result.isConfirmed) onYes(); else onNo();
                    });
                } else {
                    // Fallback agar SweetAlert2 kisi wajah se load na ho
                    const ok = window.confirm('You already chose "' + previousValue + '" as your ' + labelText + '. Do you want to change it?');
                    if (ok) onYes(); else onNo();
                }
            };

            askConfirmation(
                function () {
                    currentValue = newValue;
                    isLocked = false;
                    selectEl.value = newValue;
                    selectEl.dispatchEvent(new Event('change', { bubbles: false }));
                },
                function () {
                    selectEl.value = previousValue;
                }
            );
        } else {
            currentValue = newValue;
        }
    });
}

setupChoiceLock(
    document.getElementById('visaTypeSelect'),
    @json($prefill_visa_type),
    'Visa Type'
);

setupChoiceLock(
    document.getElementById('countrySelect'),
    @json($prefill_country),
    'Destination Country'
);
</script>
@endsection