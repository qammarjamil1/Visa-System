@extends('layouts.app')
@section('title', 'Home')

@section('styles')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    /* ── HERO ── */
.hero {
    background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 60%, #111e38 100%);
    padding: 60px 48px 70px;
    text-align: center;
    position: relative;
    overflow: hidden;
    min-height: 92vh;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
}
    .hero-person {
        position: absolute; right: -180px; bottom: 100px;
        z-index: 2; transition: transform 0.3s ease-out; will-change: transform;
    }
    .hero-person img { width: 700px; height: 400px; display: block; }

    .hero::before {
        content: ''; position: absolute; inset: 0;
        background-image:
            radial-gradient(circle at 20% 30%, rgba(201,168,76,0.08) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(201,168,76,0.06) 0%, transparent 50%);
        animation: heroGlow 6s ease-in-out infinite alternate;
    }
    @keyframes heroGlow {
        0%   { opacity: 0.6; transform: scale(1); }
        100% { opacity: 1;   transform: scale(1.08); }
    }
    .hero-particles span {
        position: absolute; border-radius: 50%;
        background: rgba(201,168,76,0.18);
        animation: floatDot linear infinite;
    }
    @keyframes floatDot {
        0%   { transform: translateY(0) scale(1); opacity: 0.7; }
        50%  { opacity: 0.3; }
        100% { transform: translateY(-120px) scale(0.6); opacity: 0; }
    }
    .hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3.8rem; color: #fff;
        margin-bottom: 18px; line-height: 1.18;
        position: relative; z-index: 2;
        animation: fadeUp 0.9s ease both;
    }
    .hero h1 span { color: #ffbf00; }
    .hero p {
        color: rgba(255,255,255,0.62); font-size: 1.08rem;
        max-width: 500px; margin: 0 auto 36px;
        position: relative; z-index: 2;
        animation: fadeUp 1.1s ease both;
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .hero-btns {
        display: flex; gap: 16px; justify-content: center;
        margin-bottom: 44px; position: relative; z-index: 2;
        animation: fadeUp 1.3s ease both;
    }
    .btn-gold {
        background: #ffbf00; color: #0a1628;
        padding: 14px 36px; border-radius: 10px;
        font-weight: 700; text-decoration: none; font-size: 0.97rem;
        transition: transform 0.2s, box-shadow 0.2s, background 0.2s;
        box-shadow: 0 4px 20px rgba(201,168,76,0.3);
    }
    .btn-gold:hover { transform: translateY(-3px) scale(1.04); box-shadow: 0 10px 32px rgba(201,168,76,0.5); background: #d4b05a; }
    .btn-ghost {
        border: 1.5px solid rgba(255,255,255,0.35); color: #fff;
        padding: 14px 36px; border-radius: 10px;
        text-decoration: none; font-size: 0.97rem;
        transition: transform 0.2s, border-color 0.2s, background 0.2s;
    }
    .btn-ghost:hover { transform: translateY(-3px); border-color: #ffbf00; background: rgba(201,168,76,0.08); }

    /* SEARCH */
    .search-wrapper {
        max-width: 560px; margin: 0 auto;
        position: relative; z-index: 10;
        animation: fadeUp 1.5s ease both;
    }
    .search-wrapper input {
        width: 100%; padding: 16px 56px 16px 20px;
        border-radius: 12px; border: none; outline: none;
        font-size: 1rem; box-shadow: 0 8px 32px rgba(0,0,0,0.35);
        transition: box-shadow 0.2s;
    }
    .search-wrapper input:focus { box-shadow: 0 8px 40px rgba(201,168,76,0.3); }
    .search-wrapper button {
        position: absolute; right: 4px; top: 50%; height: 40px; width: 40px;
        align-items: center; justify-content: center; display: flex;
        transform: translateY(-50%);
        background: #ffbf00; border: none; border-radius: 8px;
        cursor: pointer; font-size: 1.1rem; transition: background 0.2s;
    }
    .search-wrapper button:hover { background: #a57d21; }
   .search-results {
    position: fixed;
    background: #fff; border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    max-height: 260px; overflow-y: auto; z-index: 9999; display: none;
}
    .search-results.show { display: block; }
    .search-item {
        padding: 12px 20px; cursor: pointer; font-size: 0.92rem;
        color: #1a2340; border-bottom: 1px solid #f0f0f0;
        display: flex; align-items: center; gap: 12px; text-decoration: none;
        transition: background 0.15s;
    }
    .search-item:hover { background: #faf8f3; }
    .search-item .flag { font-size: 1.3rem; }
    .no-result { padding: 16px 20px; color: #6b7a99; font-size: 0.9rem; }

    /* ── STATS ── */
    .stats {
        background: #ffbf00;
        background-size: 200% 100%;
        animation: shimmer 4s linear infinite;
        display: flex; justify-content: center; gap: 64px;
        padding: 22px; flex-wrap: wrap;
        margin-bottom: 0; margin-top: 0;
    }
    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    .stat-item { text-align: center; transition: transform 0.25s; cursor: default; }
    .stat-item:hover { transform: scale(1.12); }
    .stat-num { font-family: 'Playfair Display', serif; font-size: 1.7rem; font-weight: 900; color: #0a1628; display: block; }
    .stat-lbl { font-size: 0.78rem; font-weight: 600; color: rgba(10,22,40,0.65); text-transform: uppercase; }

    /* ── SECTION BASE ── */
    .section { padding: 80px 48px; max-width: 1200px; margin: 0 auto; }
    .section-title { text-align: center; margin-bottom: 48px; }
    .section-title h2 { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: #9c6767; }
    .section-title p { color: #f5f4e9; margin-top: 8px; }
    .section-wrap { position: relative; overflow: hidden; }

    /* ── VISA PACKAGES ── */
    .visa-section-bg { background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%); }
    .visa-section-bg .section-title h2 { color: #ffffff; }
    .visa-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
    .visa-card {
        background: #ffffff46; border-radius: 16px; padding: 32px 24px;
        border: 1.5px solid #eee; text-decoration: none; display: block;
        transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
        position: relative; overflow: hidden;
    }
    .visa-card::before {
        content: ''; position: absolute; top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(201,168,76,0.08) 50%, transparent 70%);
        transform: translateX(-100%); transition: transform 0.5s ease;
    }
    .visa-card:hover { transform: translateY(-8px) rotate(0.5deg); box-shadow: 0 20px 48px rgba(0,0,0,0.2); border-color: #ffbf00; }
    .visa-card:hover::before { transform: translateX(100%); }
    .visa-icon { font-size: 2rem; margin-bottom: 16px; display: block; transition: transform 0.3s; }
    .visa-card:hover .visa-icon { transform: scale(1.2) rotate(-5deg); }
    .visa-card h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; color: #000000; margin-bottom: 8px; }
    .visa-card p { color: #000000; font-size: 0.88rem; line-height: 1.6; }
    .visa-badge {
        display: inline-block; background: #faf8f3; color: #401a1a;
        padding: 4px 12px; border-radius: 100px; font-size: 0.78rem;
        font-weight: 600; margin-top: 16px; transition: background 0.2s, color 0.2s;
    }
    .visa-card:hover .visa-badge { background: #c9a84c; color: #0a1628; }

    /* ── COUNTRIES ── */
    .countries-section-bg { background: #f0f4f8; }
    .countries-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 16px; }
    .country-card {
        background: rgba(255,255,255,0.08) !important;
        border-color: rgba(255,255,255,0.15) !important;
        border-radius: 12px; padding: 20px 16px;
        text-align: center; text-decoration: none; display: block;
        transition: transform 0.25s, border-color 0.25s, box-shadow 0.25s, background 0.25s;
        position: relative; overflow: hidden;
    }
    .country-card::after {
        content: ''; position: absolute; bottom: 0; left: 0; right: 0;
        height: 3px; background: #ffbf00;
        transform: scaleX(0); transform-origin: left; transition: transform 0.3s ease;
    }
    .country-card:hover {
        background: rgba(201,168,76,0.15) !important;
        border-color: #ffbf00 !important;
        box-shadow: 0 8px 24px rgba(201,168,76,0.2);
        transform: translateY(-5px) skewY(-0.5deg);
    }
    .country-card:hover::after { transform: scaleX(1); }
    .country-flag { font-size: 2.2rem; margin-bottom: 8px; display: block; transition: transform 0.25s; color: #ffbf00; }
    .country-card:hover .country-flag { transform: scale(1.2); }
    .country-name { font-weight: 600; font-size: 0.88rem; color: #fff !important; }
    .country-count { font-size: 0.75rem; color: rgba(255,255,255,0.6) !important; margin-top: 2px; }

    /* VIDEO BG */
    .countries-video-bg {
        position: absolute; top: 0; left: 0;
        width: 100%; height: 100%; object-fit: cover; z-index: 0; opacity: 0.6;
    }
    .countries-video-overlay { position: absolute; inset: 0; background: rgba(10,22,40,0.72); z-index: 1; }

    /* SECTION TAG / H2 */
    section { padding: 80px 60px; }
    .section-tag { font-size: 11px; letter-spacing: 3px; color: white; text-transform: uppercase; margin-bottom: 12px; }
    h2 { color: white; font-family: 'Playfair Display', serif; font-size: clamp(28px,4vw,48px); font-weight: 700; margin-bottom: 14px; }
    .section-sub { font-size: 15px; color: var(--gray); line-height: 1.7; max-width: 550px; margin-bottom: 40px; }

    /* ── VISA FEE CALCULATOR ── */
    .calculator-section { background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%); border-top: 1px solid rgba(201,168,76,0.1); border-bottom: 1px solid rgba(201,168,76,0.1); }
    .calc-box {
        max-width: 700px; margin: 0 auto;
        background: linear-gradient(135deg, #7388aa 0%, #3f6bb1 60%, #4d6188 100%);
        border: 1px solid rgba(201,168,76,0.2); border-radius: 20px; padding: 36px;
        transition: box-shadow 0.3s, transform 0.3s;
    }
    .calc-box:hover { box-shadow: 0 20px 50px rgba(0,0,0,0.3); transform: translateY(-4px); }
    .calc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
    .calc-label { font-size: 11px; color: rgba(255,255,255,0.6); letter-spacing: 1px; text-transform: uppercase; margin-bottom: 8px; }
    .calc-select {
        width: 100%; padding: 12px 16px;
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px; color: #fff; font-size: 14px; outline: none;
        transition: border-color 0.3s, background 0.3s;
    }
    .calc-select:focus { border-color: #ffbf00; background: rgba(255,255,255,0.1); }
    .calc-select option { background: #1d2e49; }
    .calc-result {
        background: rgba(201,168,76,0.08); border: 1px solid rgba(201,168,76,0.2);
        border-radius: 12px; padding: 24px; text-align: center; margin-top: 16px;
        animation: fadeUp 0.4s ease;
    }
    .calc-fee { font-family: 'Playfair Display', serif; font-size: 48px; font-weight: 700; color: #ffbf00; margin-bottom: 8px; }
    .calc-details { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; margin-top: 16px; }
    .calc-detail-item { text-align: center; }
    .calc-detail-label { font-size: 10px; color: rgba(255,255,255,0.5); letter-spacing: 1px; text-transform: uppercase; margin-bottom: 4px; }
    .calc-detail-value { font-size: 14px; font-weight: 600; color: #fff; }
    .btn-calc {
        width: 100%; padding: 14px; background: #ffbf00; color: #0a1628;
        border: none; border-radius: 10px; font-size: 15px; font-weight: 700;
        cursor: pointer; transition: all 0.3s; margin-top: 16px;
    }
    .btn-calc:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(201,168,76,0.4); background: #ffd740; }

    /* ── HOW IT WORKS ── */
    .steps-bg {
        background-image: url('/images/steps-bg.jpg');
        background-attachment: fixed; background-size: cover; background-position: center;
        position: relative;
    }
    .steps-bg::before { content: ''; position: absolute; inset: 0; background: rgba(10,22,40,0.82); }
    .steps-bg .section { position: relative; z-index: 2; }
    .steps-bg .section-title h2 { color: #fff; }
    .steps-bg .section-title p { color: rgba(255,255,255,0.7); }
    .steps-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
    .step-card {
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);
        border-radius: 14px; padding: 28px 20px; text-align: center;
        transition: background 0.3s, transform 0.3s, border-color 0.3s, box-shadow 0.3s;
        position: relative; overflow: hidden; text-decoration: none; display: block;
    }
    .step-card::before {
        content: ''; position: absolute; top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(201,168,76,0.07) 50%, transparent 70%);
        transform: translateX(-100%); transition: transform 0.5s ease;
    }
    .step-card:hover { background: rgba(201,168,76,0.12); border-color: rgba(201,168,76,0.5); transform: translateY(-8px); box-shadow: 0 16px 40px rgba(0,0,0,0.3); }
    .step-card:hover::before { transform: translateX(100%); }
    .step-img-wrap { width: 100%; height: 160px; overflow: hidden; border-radius: 10px; margin-bottom: 16px; }
    .step-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .step-card:hover .step-img { transform: scale(1.1); }
    .step-num {
        width: 48px; height: 48px; border-radius: 50%;
        background: #ffbf00; color: #014fc5;
        font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 900;
        display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .step-card:hover .step-num { transform: scale(1.15) rotate(10deg); box-shadow: 0 0 20px rgba(255,191,0,0.6); }
    .step-card h3 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.05rem; margin-bottom: 8px; }
    .step-card p { color: rgba(255,255,255,0.6); font-size: 0.85rem; line-height: 1.6; }

    /* ── TESTIMONIALS ── */
    .testimonials-bg { position: relative; background: url('images/testimonials-bg.jpg') center center/cover no-repeat; }
    .testimonials-bg .section-title h2 { color: #0a1628; }
    .testimonials-bg .section-title p { color: #ffffff; }
    .testimonials-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; }
    .testi-card {
        background: #fff; border-radius: 16px; padding: 28px 24px;
        border: 1.5px solid #f0ead8;
        transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
        position: relative; overflow: hidden;
    }
    .testi-card::before {
        content: '"'; font-family: 'Playfair Display', serif;
        font-size: 5rem; color: #c94c4c; opacity: 0.15;
        position: absolute; top: 8px; left: 16px; line-height: 1;
    }
    .testi-card::after {
        content: ''; position: absolute; bottom: 0; left: 0; right: 0;
        height: 3px; background: #ffbf00;
        transform: scaleX(0); transform-origin: left; transition: transform 0.3s;
    }
    .testi-card:hover { transform: translateY(-8px) rotate(-0.3deg); box-shadow: 0 20px 48px rgba(0,0,0,0.1); border-color: #ffbf00; }
    .testi-card:hover::after { transform: scaleX(1); }
    .testi-text { color: #684a4a; font-size: 0.92rem; line-height: 1.7; margin-bottom: 20px; position: relative; z-index: 1; }
    .testi-author { display: flex; align-items: center; gap: 12px; }
    .testi-avatar {
        width: 42px; height: 42px; border-radius: 50%;
        background: linear-gradient(135deg, #ffbf00, #0a1628);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-weight: 700; font-size: 1rem;
        transition: transform 0.3s;
    }
    .testi-card:hover .testi-avatar { transform: scale(1.1) rotate(5deg); }
    .testi-name { font-weight: 600; color: #0a1628; font-size: 0.9rem; }
    .testi-country { font-size: 0.78rem; color: #6b7a99; }
    .testi-stars { color: #ffbf00; font-size: 0.85rem; margin-bottom: 2px; }

    /* ── CTA BAND ── */
    .cta-band {
        background: linear-gradient(135deg, #0a1628 0%, #1a2f52 100%);
        padding: 70px 48px; text-align: center; position: relative; overflow: hidden;
    }
    .cta-band::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(201,168,76,0.1) 0%, transparent 65%);
        animation: pulse 4s ease-in-out infinite;
    }
    @keyframes pulse { 0%,100% { transform: scale(1); opacity: 0.8; } 50% { transform: scale(1.1); opacity: 1; } }
    .cta-band h2 { font-family: 'Playfair Display', serif; font-size: 2.4rem; color: #fff; margin-bottom: 14px; position: relative; z-index: 2; }
    .cta-band p { color: #fff; margin-bottom: 32px; position: relative; z-index: 2; font-size: 1rem; }
    .cta-band .btn-gold { position: relative; z-index: 2; display: inline-block; font-size: 1rem; padding: 16px 44px; }


    /* ── REVEAL ANIMATIONS ── */
    .reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    .reveal-left { opacity: 0; transform: translateX(-50px); transition: opacity 0.8s ease, transform 0.8s ease; }
    .reveal-left.visible { opacity: 1; transform: translateX(0); }
    .reveal-right { opacity: 0; transform: translateX(50px); transition: opacity 0.8s ease, transform 0.8s ease; }
    .reveal-right.visible { opacity: 1; transform: translateX(0); }

    @media(max-width: 900px) {
        .visa-grid, .steps-grid, .testimonials-grid { grid-template-columns: repeat(2,1fr); }
        .footer-grid { grid-template-columns: 1fr 1fr; }
    }
    @media(max-width: 600px) {
        .hero h1 { font-size: 2.2rem; }
        .section { padding: 48px 20px; }
        .stats { gap: 28px; }
        .visa-grid, .steps-grid, .testimonials-grid { grid-template-columns: 1fr; }
        .footer-grid { grid-template-columns: 1fr; }
    }

/* ── CTA BAND UPDATED ── */
.cta-band{
    background:linear-gradient(135deg,#0a1628 0%,#1a2f52 100%);
    padding:80px 48px;
    position:relative;
    overflow:hidden;
}

.cta-band::before{
    content:'';
    position:absolute;
    inset:0;
    background:radial-gradient(circle at 30% 50%,rgba(201,168,76,.12) 0%,transparent 60%);
    animation:pulse 4s ease-in-out infinite;
}

.cta-inner{
    max-width:900px;
    margin:0 auto;
    position:relative;
    z-index:2;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-align:center;
}

.cta-text{
    margin-bottom:35px;
}

.cta-text h2{
    font-family:'Playfair Display',serif;
    font-size:2.6rem;
    color:#fff;
    margin-bottom:15px;
    line-height:1.2;
}

.cta-text h2 span{
    color:#ffbf00;
}

.cta-text p{
    color:rgba(255,255,255,.70);
    font-size:1.05rem;
    line-height:1.8;
    max-width:620px;
    margin:0 auto;
}

.cta-action{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:16px;
}

.cta-btn{
    font-size:1rem;
    padding:16px 38px;
    white-space:nowrap;
    animation:ctaPulse 2.5s ease-in-out infinite;
}

@keyframes ctaPulse{
    0%,100%{
        box-shadow:0 4px 20px rgba(201,168,76,.30);
    }
    50%{
        box-shadow:0 8px 36px rgba(201,168,76,.60);
        transform:translateY(-2px);
    }
}

.cta-contact-btn{
    color:rgba(255,255,255,.70);
    text-decoration:none;
    font-size:.95rem;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    gap:6px;
    transition:.3s;
}

.cta-contact-btn:hover{
    color:#c9a84c;
    transform:translateX(4px);
}

/* Mobile */

@media(max-width:768px){

    .cta-band{
        padding:60px 25px;
    }

    .cta-text h2{
        font-size:2rem;
    }

    .cta-btn{
        width:100%;
        max-width:320px;
    }
}

</style>
@endsection

@section('content')

<!-- HERO -->
<section class="hero">
    <div class="hero-person">
        <img src="{{ asset('build/assets/images/hero-visa.png') }}" alt="Visa Hero">
    </div>
    <div class="hero-particles" aria-hidden="true">
        <span style="width:8px;height:8px;top:20%;left:15%;animation-duration:7s;animation-delay:0s;"></span>
        <span style="width:5px;height:5px;top:60%;left:80%;animation-duration:9s;animation-delay:2s;"></span>
        <span style="width:10px;height:10px;top:40%;left:60%;animation-duration:8s;animation-delay:1s;"></span>
        <span style="width:6px;height:6px;top:75%;left:30%;animation-duration:6s;animation-delay:3s;"></span>
        <span style="width:7px;height:7px;top:15%;left:70%;animation-duration:10s;animation-delay:0.5s;"></span>
        <span style="width:4px;height:4px;top:50%;left:10%;animation-duration:7.5s;animation-delay:1.5s;"></span>
    </div>
    <h1>Your <span>Global Visa</span><br/>Journey Starts Here</h1>
    <p>Tourist, Work, Study, Business — we handle all visas with expert guidance and 98% approval rate.</p>
    <div class="hero-btns">
        <a href="{{ url('/booking') }}" class="btn-gold">Apply Now</a>
        <a href="{{ url('/countries') }}" class="btn-ghost">Explore Countries</a>
    </div>
    <div class="search-wrapper">
        <input type="text" id="countrySearch" placeholder="🔍  Search a country... e.g. Canada, UK, UAE" autocomplete="off"/>
        <button>🔍</button>
        <div class="search-results" id="searchResults"></div>
    </div>
</section>

<!-- STATS -->
<div class="stats">
    <div class="stat-item"><span class="stat-num">3,200+</span><span class="stat-lbl">Visas Approved</span></div>
    <div class="stat-item"><span class="stat-num">60+</span><span class="stat-lbl">Countries</span></div>
    <div class="stat-item"><span class="stat-num">94%</span><span class="stat-lbl">Success Rate</span></div>
    <div class="stat-item"><span class="stat-num">24/7</span><span class="stat-lbl">Support</span></div>
</div>

<!-- VISA PACKAGES -->
<div class="visa-section-bg section-wrap">
    <div class="section reveal">
        <div class="section-title">
            <h2>✈️ Visa Packages</h2>
            <p>Choose the visa type that matches your travel purpose.</p>
        </div>
        <div class="visa-grid">
            <a href="{{ url('/choose-visa-type?type=tourist') }}" class="visa-card reveal-left" style="transition-delay:0.1s">
    <span class="visa-icon">🏖️</span>
    <h3>Tourist Visa</h3>
                <p>Short travel for vacations and sightseeing trips abroad.</p>
                <span class="visa-badge">⏱ 15–90 Days</span>
            </a>
            <a href="{{ url('/choose-visa-type?type=work') }}" class="visa-card reveal-left" style="transition-delay:0.2s">
    <span class="visa-icon">💼</span>
    <h3>Work Visa</h3>
                <p>International career opportunities and job placements.</p>
                <span class="visa-badge">⏱ 1–3 Years</span>
            </a>
            <a href="{{ url('/choose-visa-type?type=study') }}" class="visa-card reveal-right" style="transition-delay:0.3s">
    <span class="visa-icon">🎓</span>
    <h3>Study Visa</h3>
                <p>Study at top universities with full document support.</p>
                <span class="visa-badge">⏱ 1–4 Years</span>
            </a>
            <a href="{{ url('/choose-visa-type?type=business') }}" class="visa-card reveal-right" style="transition-delay:0.4s">
    <span class="visa-icon">🤝</span>
    <h3>Business Visa</h3>
                <p>Attend meetings and conferences internationally.</p>
                <span class="visa-badge">⏱ 30–180 Days</span>
            </a>
        </div>
    </div>
</div>

<!-- POPULAR COUNTRIES -->
<div class="countries-section-bg" style="position:relative; overflow:hidden;">
    <video autoplay muted loop playsinline class="countries-video-bg">
        <source src="/videos/countries-bg.mp4" type="video/mp4"/>
    </video>
    <div class="countries-video-overlay"></div>
    <div class="section reveal" style="position:relative; z-index:2;">
        <div class="section-title">
            <h2 style="color:#fff;">🌍 Popular Countries</h2>
            <p style="color:rgba(255,255,255,0.6);">We process visas for 120+ countries worldwide.</p>
        </div>
        <div class="countries-grid">
            <a href="{{ url('/countries') }}" class="country-card reveal" style="transition-delay:0.05s"><span class="country-flag">🇺🇸</span><div class="country-name">USA</div><div class="country-count">4 visa types</div></a>
            <a href="{{ url('/countries') }}" class="country-card reveal" style="transition-delay:0.1s"><span class="country-flag">🇬🇧</span><div class="country-name">UK</div><div class="country-count">5 visa types</div></a>
            <a href="{{ url('/countries') }}" class="country-card reveal" style="transition-delay:0.15s"><span class="country-flag">🇨🇦</span><div class="country-name">Canada</div><div class="country-count">4 visa types</div></a>
            <a href="{{ url('/countries') }}" class="country-card reveal" style="transition-delay:0.2s"><span class="country-flag">🇦🇺</span><div class="country-name">Australia</div><div class="country-count">6 visa types</div></a>
            <a href="{{ url('/countries') }}" class="country-card reveal" style="transition-delay:0.25s"><span class="country-flag">🇩🇪</span><div class="country-name">Germany</div><div class="country-count">3 visa types</div></a>
            <a href="{{ url('/countries') }}" class="country-card reveal" style="transition-delay:0.3s"><span class="country-flag">🇫🇷</span><div class="country-name">France</div><div class="country-count">3 visa types</div></a>
            <a href="{{ url('/countries') }}" class="country-card reveal" style="transition-delay:0.35s"><span class="country-flag">🇦🇪</span><div class="country-name">UAE</div><div class="country-count">4 visa types</div></a>
            <a href="{{ url('/countries') }}" class="country-card reveal" style="transition-delay:0.4s"><span class="country-flag">🇸🇦</span><div class="country-name">Saudi Arabia</div><div class="country-count">3 visa types</div></a>
            <a href="{{ url('/countries') }}" class="country-card reveal" style="transition-delay:0.45s"><span class="country-flag">🇮🇹</span><div class="country-name">Italy</div><div class="country-count">3 visa types</div></a>
            <a href="{{ url('/countries') }}" class="country-card reveal" style="transition-delay:0.5s"><span class="country-flag">🇹🇷</span><div class="country-name">Turkey</div><div class="country-count">3 visa types</div></a>
            <a href="{{ url('/countries') }}" class="country-card reveal" style="transition-delay:0.55s"><span class="country-flag">🇨🇳</span><div class="country-name">China</div><div class="country-count">4 visa types</div></a>
            <a href="{{ url('/countries') }}" class="country-card reveal" style="transition-delay:0.6s"><span class="country-flag">🇯🇵</span><div class="country-name">Japan</div><div class="country-count">3 visa types</div></a>
        </div>
    </div>
</div>

<!-- VISA FEE CALCULATOR -->
<section class="calculator-section">
    <div style="text-align:center; margin-bottom:36px;" class="reveal">
        <div class="section-tag" style="justify-content:center; display:flex;">💰 Unique Feature</div>
        <h2>Visa Fee <span style="color:#ffbf00;">Calculator</span></h2>
        <p style="color:white; font-size:15px; margin-top:8px;">Get instant fee estimate before applying</p>
    </div>
    <div class="calc-box reveal">
      <div>
                <div class="calc-label">Select Country</div>
                <select class="calc-select" id="calcCountry" onchange="calculateFee()">
                    <option value="">Choose Country</option>
                    <optgroup label="🔴 Far / Developed">
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
                    <optgroup label="🟡 Mid-range">
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
                    <optgroup label="🟢 Near / Budget">
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
            <div>
                <div class="calc-label">Visa Type</div>
                <select class="calc-select" id="calcType" onchange="calculateFee()">
                    <option value="">Choose Type</option>
                    <option value="tourist">🏖️ Tourist Visa</option>
                    <option value="work">💼 Work Visa</option>
                    <option value="study">🎓 Study Visa</option>
                    <option value="business">🤝 Business Visa</option>
                    <option value="family">👨‍👩‍👧 Family Visa</option>
                </select>
            </div>
        <div class="calc-result" id="calcResult" style="display:none;">
            <div style="font-size:13px; color:rgba(255,255,255,0.6); margin-bottom:8px; letter-spacing:1px; text-transform:uppercase;">Estimated Fee</div>
            <div class="calc-fee" id="calcFee">$0</div>
            <div class="calc-details">
                <div class="calc-detail-item">
                    <div class="calc-detail-label">Processing Time</div>
                    <div class="calc-detail-value" id="calcTime">—</div>
                </div>
                <div class="calc-detail-item">
                    <div class="calc-detail-label">Validity</div>
                    <div class="calc-detail-value" id="calcValidity">—</div>
                </div>
                <div class="calc-detail-item">
                    <div class="calc-detail-label">Entry Type</div>
                    <div class="calc-detail-value" id="calcEntry">—</div>
                </div>
            </div>
            <a href="{{ auth()->check() ? url('/booking') : route('register') }}" class="btn-calc" style="display:block; text-decoration:none; text-align:center;">Apply Now →</a>
        </div>
        <div id="calcPlaceholder" style="text-align:center; padding:24px; color:rgb(255, 255, 255); font-size:14px;">
            👆 Select country and visa type to see fee estimate
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<div class="steps-bg">
    <div class="section">
        <div class="section-title reveal">
            <h2>📋 How It Works</h2>
            <p>Our 4-step process makes visa applications simple and stress-free.</p>
        </div>
        <div class="steps-grid">
            <a href="{{ url('/visa-types') }}" class="step-card reveal" style="transition-delay:0.1s;">
    <div class="step-img-wrap"><img src="/images/step1.jpg" alt="Choose Visa" class="step-img"/></div>
    <div class="step-num">1</div>
    <h3>Choose Visa</h3>
    <p>Select the visa category that matches your travel purpose.</p>
</a>
            <a href="{{ url('/booking') }}" class="step-card reveal" style="transition-delay:0.2s;">
                <div class="step-img-wrap"><img src="/images/step2.jpg" alt="Fill Form" class="step-img"/></div>
                <div class="step-num">2</div>
                <h3>Fill Form</h3>
                <p>Complete your application with accurate personal details.</p>
            </a>
            <a href="{{ url('/upload-documents') }}" class="step-card reveal" style="transition-delay:0.3s;">
                <div class="step-img-wrap"><img src="/images/step3.jpg" alt="Upload Docs" class="step-img"/></div>
                <div class="step-num">3</div>
                <h3>Upload Docs</h3>
                <p>Submit required documents securely through our portal.</p>
            </a>
            <a href="{{ url('/get-approved') }}" class="step-card reveal" style="transition-delay:0.4s;">
                <div class="step-img-wrap"><img src="/images/step4.jpg" alt="Get Approved" class="step-img"/></div>
                <div class="step-num">4</div>
                <h3>Get Approved</h3>
                <p>Track your status and receive your visa by email.</p>
            </a>
        </div>
    </div>
</div>

<!-- TESTIMONIALS -->
<div class="testimonials-bg section-wrap">
    <div class="section">
        <div class="section-title reveal">
            <h2>💬 What Our Clients Say</h2>
            <p>Thousands of satisfied travelers trust VisaGo every year.</p>
        </div>
        <div class="testimonials-grid">
            <div class="testi-card reveal" style="transition-delay:0.1s">
                <p class="testi-text">VisaGo made my Canada student visa process incredibly smooth. Got approved in 3 weeks — faster than I expected!</p>
                <div class="testi-author">
                    <div class="testi-avatar">AK</div>
                    <div>
                        <div class="testi-stars">★★★★★</div>
                        <div class="testi-name">Ahmed Khan</div>
                        <div class="testi-country">🇵🇰 Pakistan → 🇨🇦 Canada</div>
                    </div>
                </div>
            </div>
            <div class="testi-card reveal" style="transition-delay:0.2s">
                <p class="testi-text">Applied for UK work visa through VisaGo. The team guided me at every step. Professional and reliable service!</p>
                <div class="testi-author">
                    <div class="testi-avatar">SR</div>
                    <div>
                        <div class="testi-stars">★★★★★</div>
                        <div class="testi-name">Sara Raza</div>
                        <div class="testi-country">🇵🇰 Pakistan → 🇬🇧 UK</div>
                    </div>
                </div>
            </div>
            <div class="testi-card reveal" style="transition-delay:0.3s">
                <p class="testi-text">Got my Schengen tourist visa in just 2 weeks. The online tracking feature is excellent. Highly recommended!</p>
                <div class="testi-author">
                    <div class="testi-avatar">MJ</div>
                    <div>
                        <div class="testi-stars">★★★★★</div>
                        <div class="testi-name">Muhammad Jameel</div>
                        <div class="testi-country">🇵🇰 Pakistan → 🇩🇪 Germany</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA BAND -->
<div class="cta-band">
    <div class="cta-inner">

        <div class="cta-text reveal-left">
            <h2>Ready to Start Your <span>Journey?</span></h2>

            <p>
                Join 7,500+ travelers who got their visa approved with VisaGo.
                Fast, secure, and reliable service.
            </p>
        </div>

        <div class="cta-action reveal-right">

            <a href="{{ url('/booking') }}" class="btn-gold cta-btn">
                Apply Now — It's Fast &amp; Easy ✈️
            </a>

            <a href="{{ url('/contact') }}" class="cta-contact-btn">
                Talk to an Expert →
            </a>

        </div>

    </div>
</div>


@if(session('show_steps_popup'))
<div id="stepsPopup" style="position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:9999; display:flex; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:20px; padding:40px; max-width:480px; width:90%; text-align:center; animation:fadeUp 0.4s ease;">
        <div style="font-size:3rem; margin-bottom:16px;">⚠️</div>
        <h2 style="font-family:'Playfair Display',serif; color:#0a1628; font-size:1.5rem; margin-bottom:12px;">Pehle Yeh Steps Complete Karo!</h2>
        <p style="color:#6b7a99; font-size:0.93rem; line-height:1.7; margin-bottom:24px;">Get Approved page access karne ke liye pehle yeh 3 steps complete karna zaroori hai:</p>
        <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:28px; text-align:left;">
            <div style="background:#faf8f2; border:1.5px solid #c9a84c; border-radius:10px; padding:14px 18px; display:flex; align-items:center; gap:12px;">
                <span style="background:#c9a84c; color:#0a1628; width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:0.85rem; flex-shrink:0;">1</span>
                <div><strong style="color:#0a1628; font-size:0.9rem;">Visa Choose Karo</strong><p style="color:#6b7a99; font-size:0.8rem; margin:0;">Countries page se apna visa select karo</p></div>
            </div>
            <div style="background:#faf8f2; border:1.5px solid #c9a84c; border-radius:10px; padding:14px 18px; display:flex; align-items:center; gap:12px;">
                <span style="background:#c9a84c; color:#0a1628; width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:0.85rem; flex-shrink:0;">2</span>
                <div><strong style="color:#0a1628; font-size:0.9rem;">Form Fill Karo</strong><p style="color:#6b7a99; font-size:0.8rem; margin:0;">Apni personal details aur visa information bharein</p></div>
            </div>
            <div style="background:#faf8f2; border:1.5px solid #c9a84c; border-radius:10px; padding:14px 18px; display:flex; align-items:center; gap:12px;">
                <span style="background:#c9a84c; color:#0a1628; width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:0.85rem; flex-shrink:0;">3</span>
                <div><strong style="color:#0a1628; font-size:0.9rem;">Documents Upload Karo</strong><p style="color:#6b7a99; font-size:0.8rem; margin:0;">Required documents securely submit karein</p></div>
            </div>
        </div>
        <div style="display:flex; gap:12px; justify-content:center;">
            <a href="{{ url('/countries') }}" style="background:#c9a84c; color:#0a1628; padding:12px 28px; border-radius:10px; text-decoration:none; font-weight:700; font-size:0.9rem;">Start Now →</a>
            <button onclick="document.getElementById('stepsPopup').style.display='none'" style="background:transparent; border:2px solid #0a1628; color:#0a1628; padding:12px 28px; border-radius:10px; cursor:pointer; font-weight:700; font-size:0.9rem;">Close</button>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
// HERO PARALLAX
const heroPerson = document.querySelector('.hero-person');
if (heroPerson) {
    document.querySelector('.hero').addEventListener('mousemove', function(e) {
        const rect = this.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width  - 0.5;
        const y = (e.clientY - rect.top)  / rect.height - 0.5;
        heroPerson.style.transform = `translate(${x * 15}px, ${y * 10}px)`;
    });
    document.querySelector('.hero').addEventListener('mouseleave', function() {
        heroPerson.style.transform = 'translate(0, 0)';
    });
}

// SCROLL REVEAL
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => observer.observe(el));

// SEARCH
const countries = [
    {name:'USA',flag:'🇺🇸',url:'/countries'},{name:'United Kingdom',flag:'🇬🇧',url:'/countries'},
    {name:'Canada',flag:'🇨🇦',url:'/countries'},{name:'Australia',flag:'🇦🇺',url:'/countries'},
    {name:'Germany',flag:'🇩🇪',url:'/countries'},{name:'France',flag:'🇫🇷',url:'/countries'},
    {name:'UAE',flag:'🇦🇪',url:'/countries'},{name:'Saudi Arabia',flag:'🇸🇦',url:'/countries'},
    {name:'Italy',flag:'🇮🇹',url:'/countries'},{name:'Turkey',flag:'🇹🇷',url:'/countries'},
    {name:'China',flag:'🇨🇳',url:'/countries'},{name:'Japan',flag:'🇯🇵',url:'/countries'},
    {name:'Malaysia',flag:'🇲🇾',url:'/countries'},{name:'Thailand',flag:'🇹🇭',url:'/countries'},
    {name:'New Zealand',flag:'🇳🇿',url:'/countries'},{name:'Spain',flag:'🇪🇸',url:'/countries'},
    {name:'Portugal',flag:'🇵🇹',url:'/countries'},{name:'Netherlands',flag:'🇳🇱',url:'/countries'},
];
const input = document.getElementById('countrySearch');
const results = document.getElementById('searchResults');
document.body.appendChild(results);

function positionSearchResults() {
    const rect = input.getBoundingClientRect();
    results.style.top   = (rect.bottom + 8) + 'px';
    results.style.left  = rect.left + 'px';
    results.style.width = rect.width + 'px';
}

input.addEventListener('input', function() {
    const q = this.value.toLowerCase().trim();
    results.innerHTML = '';
    if (!q) { results.classList.remove('show'); return; }
    const filtered = countries.filter(c => c.name.toLowerCase().includes(q));
    if (filtered.length === 0) { results.innerHTML = '<div class="no-result">No country found 😕</div>'; }
    else { filtered.forEach(c => { results.innerHTML += `<a class="search-item" href="${c.url}"><span class="flag">${c.flag}</span><span>${c.name}</span></a>`; }); }
    positionSearchResults();
    results.classList.add('show');
});

window.addEventListener('resize', positionSearchResults);
window.addEventListener('scroll', positionSearchResults, true);
document.addEventListener('click', e => { if (!input.contains(e.target)) results.classList.remove('show'); });

// Search button & Enter
document.querySelector('.search-wrapper button').addEventListener('click', function() {
    const q = input.value.toLowerCase().trim();
    if (!q) return;
    const filtered = countries.filter(c => c.name.toLowerCase().includes(q));
    if (filtered.length > 0) window.location.href = filtered[0].url;
});
input.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        const q = this.value.toLowerCase().trim();
        const filtered = countries.filter(c => c.name.toLowerCase().includes(q));
        if (filtered.length > 0) window.location.href = filtered[0].url;
    }
});

// BASE FEE PER VISA TYPE (in USD) — destination-tier multiplier laga kar final fee banti hai
const baseFee = {
    tourist:  { fee: 90,  time: '5-7 days',   validity: '90 days',  entry: 'Single/Multiple' },
    work:     { fee: 220, time: '20-30 days', validity: '1-3 years',entry: 'Multiple' },
    study:    { fee: 150, time: '15-20 days', validity: 'Course duration', entry: 'Multiple' },
    business: { fee: 170, time: '5-7 days',   validity: '90-180 days', entry: 'Multiple' },
    family:   { fee: 190, time: '15-20 days', validity: '90 days-2.5 years', entry: 'Multiple' },
};

// DESTINATION COUNTRY TIERS — door mulk = zyada fee, qareeb mulk = kam fee
const farCountries  = ['USA','United Kingdom','Canada','Australia','Germany','France','Italy','Spain','Switzerland','Netherlands','Belgium','Austria','Sweden','Norway','Denmark','Finland','Ireland','Japan','South Korea','New Zealand','China'];
const midCountries  = ['Portugal','Greece','Poland','Czech Republic','Hungary','Romania','Brazil','Mexico','South Africa','Singapore'];
const nearCountries = ['UAE','Saudi Arabia','Qatar','Kuwait','Bahrain','Oman','Turkey','Malaysia','Thailand','Indonesia','Philippines','Vietnam','Sri Lanka','Nepal','Egypt','Morocco'];

function getTierMultiplier(country) {
    if (farCountries.includes(country))  return 1.5;
    if (midCountries.includes(country))  return 1.1;
    if (nearCountries.includes(country)) return 0.75;
    return 1;
}

function calculateFee() {
    const country = document.getElementById('calcCountry').value;
    const type    = document.getElementById('calcType').value;
    if (!country || !type) { document.getElementById('calcResult').style.display='none'; document.getElementById('calcPlaceholder').style.display='block'; return; }

    const data = baseFee[type];
    const mult = getTierMultiplier(country);
    const finalFee = Math.round(data.fee * mult);

    document.getElementById('calcFee').textContent      = '$' + finalFee;
    document.getElementById('calcTime').textContent     = data.time;
    document.getElementById('calcValidity').textContent = data.validity;
    document.getElementById('calcEntry').textContent    = data.entry;
    document.getElementById('calcResult').style.display = 'block';
    document.getElementById('calcPlaceholder').style.display = 'none';
}
</script>
@endsection