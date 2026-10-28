@extends('layouts.app')
@section('title', 'Contact Us')

@section('styles')
<style>
    /* ── HERO ── */
    .contact-hero {
        background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 100%);
        min-height: 280px; display: flex; align-items: center;
        justify-content: center; text-align: center;
        position: relative; overflow: hidden;
    }
    .contact-hero::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(201,168,76,0.12) 0%, transparent 65%);
        animation: pulse 4s ease-in-out infinite;
    }
    @keyframes pulse { 0%,100% { transform: scale(1); opacity:0.8; } 50% { transform: scale(1.1); opacity:1; } }
    .hero-particles span {
        position: absolute; border-radius: 50%;
        background: rgba(201,168,76,0.15); animation: floatDot linear infinite;
    }
    @keyframes floatDot { 0%{transform:translateY(0) scale(1);opacity:0.7;} 100%{transform:translateY(-100px) scale(0.5);opacity:0;} }
    .contact-hero-content { position: relative; z-index: 2; animation: fadeUp 0.9s ease both; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(24px);} to{opacity:1;transform:translateY(0);} }
    .contact-hero h1 { font-family: 'Playfair Display', serif; font-size: 3rem; color: #fff; margin-bottom: 12px; }
    .contact-hero h1 span { color: #c9a84c; }
    .contact-hero p { color: rgba(255,255,255,0.65); font-size: 1rem; }

    /* ── SECTION WRAPPER ── */
    .contact-section {
        background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%);
        padding: 70px 38px 90px; position: relative; overflow: hidden;
    }
    .contact-section::before {
        content: ''; position: absolute;
        width: 500px; height: 500px; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 70%);
        top: -150px; right: -100px; pointer-events: none;
        animation: floatOrb 8s ease-in-out infinite alternate;
    }
    @keyframes floatOrb { 0%{transform:translateY(0);} 100%{transform:translateY(40px);} }
    .section-inner { max-width: 1100px; margin: 0 auto; position: relative; z-index: 2; }
    .contact-grid { display: grid; grid-template-columns: 1fr 1.4fr; gap: 40px; align-items: start; }

    /* ── LEFT INFO ── */
    .contact-info h2 {
        font-family: 'Playfair Display', serif; font-size: 1.7rem; color: #fff; margin-bottom: 24px;
    }
    .contact-info h2 span { color: #c9a84c; }
    .info-item {
        display: flex; gap: 14px; align-items: flex-start;
        margin-bottom: 14px; padding: 14px 16px; border-radius: 14px;
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
        transition: background 0.25s, transform 0.25s, border-color 0.25s, box-shadow 0.25s;
    }
    .info-item:hover {
        background: rgba(201,168,76,0.1); transform: translateX(6px);
        border-color: rgba(201,168,76,0.35); box-shadow: 0 10px 28px rgba(0,0,0,0.25);
    }
    .info-icon {
        width: 38px; height: 38px; background: linear-gradient(135deg, #c9a84c, #e2c06a);
        border-radius: 12px; display: flex; align-items: center;
        justify-content: center; font-size: 1.1rem; flex-shrink: 0; color: #0a1628;
        transition: transform 0.3s;
    }
    .info-item:hover .info-icon { transform: scale(1.15) rotate(-6deg); }
    .info-item h4 { font-weight: 700; color: #fff; margin-bottom: 4px; font-size: 0.9rem; }
    .info-item p { color: rgba(255,255,255,0.6); font-size: 0.85rem; line-height: 1.6; margin: 0; }
    .info-item a { color: #c9a84c; text-decoration: none; font-weight: 600; }
    .info-item a:hover { text-decoration: underline; }

    /* MAP */
    .map-wrap {
        border-radius: 16px; overflow: hidden;
        border: 1.5px solid rgba(201,168,76,0.25); margin-top: 18px;
        box-shadow: 0 12px 32px rgba(0,0,0,0.3);
        filter: grayscale(0.15) contrast(1.05);
    }

    /* ── FORM CARD ── */
    .contact-form {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 22px; padding: 40px;
        box-shadow: 0 24px 60px rgba(0,0,0,0.3);
        transition: box-shadow 0.3s;
    }
    .contact-form:hover { box-shadow: 0 32px 72px rgba(0,0,0,0.4); }
    .contact-form h3 {
        font-family: 'Playfair Display', serif; font-size: 1.35rem; color: #fff;
        margin-bottom: 24px; padding-bottom: 14px;
        border-bottom: 1px solid rgba(201,168,76,0.2);
        display: flex; align-items: center; gap: 8px;
    }

    .form-group { margin-bottom: 18px; }
    .form-group label {
        display: block; font-size: 0.78rem; color: rgba(255,255,255,0.6);
        letter-spacing: 1.2px; text-transform: uppercase; margin-bottom: 9px; font-weight: 600;
    }
    .form-group input, .form-group select {
        width: 100%; padding: 0 16px; height: 50px;
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);
        border-radius: 12px; color: #fff; font-size: 0.92rem;
        outline: none; transition: border-color 0.3s, background 0.3s, box-shadow 0.3s;
        box-sizing: border-box;
    }
    .form-group input::placeholder { color: rgba(255,255,255,0.3); }
    .form-group input:hover, .form-group select:hover, .form-group textarea:hover {
        border-color: rgba(201,168,76,0.4); background: rgba(255,255,255,0.09);
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
        border-color: #c9a84c; background: rgba(255,255,255,0.1);
        box-shadow: 0 0 0 3px rgba(201,168,76,0.15);
    }
    .form-group select { appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23c9a84c' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 16px center;
    }
    .form-group select option { background: #1d2e49; color: #fff; }
    .form-group textarea {
        width: 100%; padding: 14px 16px; height: 120px;
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);
        border-radius: 12px; color: #fff; font-size: 0.92rem;
        outline: none; transition: border-color 0.3s, background 0.3s, box-shadow 0.3s;
        resize: vertical; box-sizing: border-box; font-family: 'Inter', sans-serif;
    }
    .form-group textarea::placeholder { color: rgba(255,255,255,0.3); }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    /* ── ERROR MESSAGES (animated) ── */
    .error-msg {
        color: #ff6b6b; font-size: 0.78rem; margin-top: 8px;
        display: flex; align-items: center; gap: 6px;
        animation: shakeIn 0.4s ease;
    }
    .error-msg::before { content: '⚠️'; font-size: 0.85rem; }
    @keyframes shakeIn {
        0% { opacity: 0; transform: translateX(-6px); }
        30% { transform: translateX(4px); }
        60% { transform: translateX(-3px); }
        100% { opacity: 1; transform: translateX(0); }
    }
    .form-group.has-error input,
    .form-group.has-error textarea {
        border-color: #ff6b6b !important;
        box-shadow: 0 0 0 3px rgba(255,107,107,0.15) !important;
    }

    .btn-submit {
        width: 100%; padding: 16px; margin-top: 6px;
        background: linear-gradient(135deg, #c9a84c, #e2c06a);
        color: #0a1628; border: none; border-radius: 12px;
        font-size: 1rem; font-weight: 800; cursor: pointer;
        letter-spacing: 0.5px; text-transform: uppercase;
        transition: transform 0.25s, box-shadow 0.25s;
        box-shadow: 0 6px 20px rgba(201,168,76,0.3);
    }
    .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(201,168,76,0.45); }
    .btn-submit:active { transform: translateY(-1px); }

    /* ── WHATSAPP FIXED BUTTON ── */
    .wa-fixed {
        position: fixed; bottom: 28px; right: 28px; z-index: 9999;
        width: 52px; height: 52px; border-radius: 50%;
        background: #25d366;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 8px 24px rgba(37,211,102,0.45);
        text-decoration: none;
        animation: waBounce 2.5s ease-in-out infinite;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .wa-fixed:hover { transform: scale(1.12) !important; box-shadow: 0 12px 32px rgba(37,211,102,0.55); animation: none; }
    .wa-fixed svg { width: 30px; height: 30px; }
    @keyframes waBounce {
        0%,100% { transform: translateY(0); }
        50%      { transform: translateY(-8px); }
    }
    .wa-tooltip {
        position: fixed; bottom: 92px; right: 20px; z-index: 9998;
        background: #0a1628; color: #fff; padding: 6px 14px;
        border-radius: 8px; font-size: 0.78rem; font-weight: 600;
        white-space: nowrap; opacity: 0; pointer-events: none;
        border: 1px solid rgba(201,168,76,0.3);
        transition: opacity 0.2s;
    }
    .wa-fixed:hover + .wa-tooltip { opacity: 1; }

    /* ── POPUP ── */
    #contactPopup { position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 99999; display: none; align-items: center; justify-content: center; }
    #contactPopup.show { display: flex; }
    .popup-inner {
        background: linear-gradient(135deg, #1d2e49, #1f3353);
        border: 1px solid rgba(201,168,76,0.3);
        border-radius: 22px; padding: 44px 36px; max-width: 440px; width: 90%;
        text-align: center; animation: popIn 0.4s ease;
        box-shadow: 0 24px 60px rgba(0,0,0,0.5);
    }
    @keyframes popIn { from { opacity:0; transform:scale(0.85); } to { opacity:1; transform:scale(1); } }
    .popup-icon-circle {
        width: 76px; height: 76px; border-radius: 50%;
        background: linear-gradient(135deg, #c9a84c, #e2c06a);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px; font-size: 2.2rem;
        box-shadow: 0 8px 24px rgba(201,168,76,0.4);
        animation: bounceIn 0.6s ease;
    }
    @keyframes bounceIn { 0%{transform:scale(0);} 60%{transform:scale(1.2);} 100%{transform:scale(1);} }
    .popup-inner h3 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.5rem; margin-bottom: 10px; }
    .popup-inner p { color: rgba(255,255,255,0.65); font-size: 0.9rem; line-height: 1.7; margin-bottom: 26px; }
    .popup-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
    .popup-wa-btn {
        background: #25d366; color: #fff; padding: 12px 24px; border-radius: 12px;
        text-decoration: none; font-weight: 700; font-size: 0.88rem;
        display: inline-flex; align-items: center; gap: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .popup-wa-btn:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 8px 24px rgba(37,211,102,0.4); }
    .popup-close-btn {
        background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2);
        color: #fff; padding: 11px 24px; border-radius: 12px; font-weight: 600; cursor: pointer;
        font-size: 0.88rem; transition: background 0.2s, border-color 0.2s;
    }
    .popup-close-btn:hover { background: rgba(201,168,76,0.15); border-color: rgba(201,168,76,0.4); color: #c9a84c; }

    /* REVEAL */
    .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    .reveal-left { opacity:0; transform:translateX(-40px); transition:opacity 0.8s ease,transform 0.8s ease; }
    .reveal-left.visible { opacity:1; transform:translateX(0); }
    .reveal-right { opacity:0; transform:translateX(40px); transition:opacity 0.8s ease,transform 0.8s ease; }
    .reveal-right.visible { opacity:1; transform:translateX(0); }

    @media(max-width: 900px) {
        .contact-grid { grid-template-columns: 1fr; }
        .contact-section { padding: 50px 24px 60px; }
        .contact-form { padding: 28px; }
        .form-row { grid-template-columns: 1fr; }
        .contact-hero h1 { font-size: 2.2rem; }
        .contact-hero { padding: 50px 24px; min-height: 220px; }
    }
</style>
@endsection

@section('content')

@if(session('contact_submitted'))
<div id="contactPopup" class="show">
    <div class="popup-inner">
        <div class="popup-icon-circle">📨</div>
        <h3>Message Sent!</h3>
        <p>Thank you for contacting VisaGo! Our team will respond within 24 hours. Chat on WhatsApp for faster response.</p>
        <div class="popup-btns">
            @if(session('whatsapp_url'))
            <a href="{{ session('whatsapp_url') }}" target="_blank" class="popup-wa-btn">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.11 1.522 5.836L.057 23.25a.75.75 0 00.916.948l5.62-1.476A11.953 11.953 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.907 0-3.686-.516-5.21-1.414l-.374-.22-3.884 1.02 1.04-3.792-.242-.389A9.956 9.956 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                Chat on WhatsApp
            </a>
            @endif
            <button class="popup-close-btn" onclick="document.getElementById('contactPopup').classList.remove('show')">Close</button>
        </div>
    </div>
</div>
@endif

<!-- HERO -->
<div class="contact-hero">
    <div class="hero-particles" aria-hidden="true">
        <span style="width:8px;height:8px;top:20%;left:15%;animation-duration:7s;"></span>
        <span style="width:5px;height:5px;top:60%;left:80%;animation-duration:9s;animation-delay:2s;"></span>
        <span style="width:10px;height:10px;top:40%;left:60%;animation-duration:8s;animation-delay:1s;"></span>
        <span style="width:6px;height:6px;top:75%;left:30%;animation-duration:6s;animation-delay:3s;"></span>
    </div>
    <div class="contact-hero-content">
        <h1>Contact <span>Us</span></h1>
        <p>We're here to help. Reach out anytime — 24/7 support available.</p>
    </div>
</div>

<!-- MAIN -->
<div class="contact-section">
    <div class="section-inner">
        <div class="contact-grid">

            <!-- LEFT -->
            <div class="contact-info reveal-left">
                <h2>Get In <span>Touch</span></h2>

                <div class="info-item">
                    <div class="info-icon">📍</div>
                    <div>
                        <h4>Address</h4>
                        <p>Commercial Market, Saidpur Road,<br>Near Askari Bank, Rawalpindi, Pakistan</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">📞</div>
                    <div>
                        <h4>Phone</h4>
                        <p><a href="tel:+923428480072">+92 342 8480072</a></p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">📧</div>
                    <div>
                        <h4>Email</h4>
                        <p><a href="mailto:qammarjamil1@gmail.com">qammarjamil1@gmail.com</a></p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">⏰</div>
                    <div>
                        <h4>Office Hours</h4>
                        <p>Monday – Saturday: 9:00 AM – 6:00 PM PKT</p>
                    </div>
                </div>

                <!-- MAP - Saidpur Road Rawalpindi -->
                <div class="map-wrap">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3323.45!2d73.0651!3d33.6007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dfed28b8e0b4c1%3A0x6e7c2a3b5d8e9f0a!2sSaidpur%20Rd%2C%20Rawalpindi%2C%20Punjab%2C%20Pakistan!5e0!3m2!1sen!2s!4v1620000000000"
                        width="100%" height="180" style="border:0; display:block;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>

            <!-- RIGHT FORM -->
            <div class="contact-form reveal-right">
                <h3>📩 Send Us a Message</h3>
                <form method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group @error('name') has-error @enderror">
                            <label>Your Name</label>
                            <input type="text" name="name" placeholder="Full name" value="{{ old('name') }}" required/>
                            @error('name') <div class="error-msg">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group @error('father_name') has-error @enderror">
                            <label>Father's Name</label>
                            <input type="text" name="father_name" placeholder="Father's name" value="{{ old('father_name') }}" required/>
                            @error('father_name') <div class="error-msg">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group @error('email') has-error @enderror">
                            <label>Email Address</label>
                            <input type="email" name="email" placeholder="Your email" value="{{ old('email') }}" required/>
                            @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group @error('phone') has-error @enderror">
                            <label>Phone Number</label>
                            <input type="text" name="phone" placeholder="Your phone number" value="{{ old('phone') }}" required/>
                            @error('phone') <div class="error-msg">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <select name="subject">
                            <option>Tourist Visa Query</option>
                            <option>Work Visa Query</option>
                            <option>Study Visa Query</option>
                            <option>Business Visa Query</option>
                            <option>Fee Related Query</option>
                            <option>Document Query</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="form-group @error('message') has-error @enderror">
                        <label>Message</label>
                        <textarea name="message" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                        @error('message') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn-submit">Send Message 📨</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- WHATSAPP FIXED BUTTON -->
<a href="https://wa.me/923428480072" target="_blank" class="wa-fixed">
    <svg viewBox="0 0 24 24" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.11 1.522 5.836L.057 23.25a.75.75 0 00.916.948l5.62-1.476A11.953 11.953 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.907 0-3.686-.516-5.21-1.414l-.374-.22-3.884 1.02 1.04-3.792-.242-.389A9.956 9.956 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
</a>
<div class="wa-tooltip">Chat on WhatsApp</div>

@endsection

@section('scripts')
<script>
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => observer.observe(el));
</script>
@endsection