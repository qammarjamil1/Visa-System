@extends('layouts.app')
@section('title', 'Visa Types')

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
        background: rgba(201,168,76,0.15); animation: floatDot linear infinite;
    }
    @keyframes floatDot { 0% { transform:translateY(0) scale(1); opacity:0.7; } 100% { transform:translateY(-100px) scale(0.5); opacity:0; } }

    /* ── MAIN SECTION ── */
    .visa-types-section {
        background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%);
        padding: 80px 48px; position: relative; overflow: hidden;
    }
    .visa-types-section::before {
        content: ''; position: absolute;
        width: 500px; height: 500px; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 70%);
        top: -150px; right: -100px; pointer-events: none;
        animation: floatOrb 8s ease-in-out infinite alternate;
    }
    @keyframes floatOrb { 0% { transform:translateY(0); } 100% { transform:translateY(40px); } }
    .visa-types-inner { max-width: 1100px; margin: 0 auto; position: relative; z-index: 2; }

    /* ── VISA CARD ── */
    .visa-type-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 20px; padding: 36px 40px;
        margin-bottom: 28px;
        display: grid; grid-template-columns: auto 1fr auto; gap: 32px; align-items: center;
        position: relative; overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s, background 0.3s;
    }
    .visa-type-card::before {
        content: ''; position: absolute; top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(201,168,76,0.06) 50%, transparent 70%);
        transform: translateX(-100%); transition: transform 0.6s ease;
    }
    .visa-type-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,0,0,0.3); border-color: rgba(201,168,76,0.4); background: rgba(255,255,255,0.1); }
    .visa-type-card:hover::before { transform: translateX(100%); }

    /* LEFT ICON */
    .visa-big-icon {
        width: 90px; height: 90px; border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.6rem; flex-shrink: 0;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .visa-type-card:hover .visa-big-icon { transform: scale(1.1) rotate(-5deg); box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
    .bg-tourist  { background: rgba(255,183,77,0.15);  border: 1px solid rgba(255,183,77,0.25); }
    .bg-work     { background: rgba(76,175,80,0.15);   border: 1px solid rgba(76,175,80,0.25); }
    .bg-study    { background: rgba(33,150,243,0.15);  border: 1px solid rgba(33,150,243,0.25); }
    .bg-business { background: rgba(244,67,54,0.15);   border: 1px solid rgba(244,67,54,0.25); }
    .bg-family   { background: rgba(156,39,176,0.15);  border: 1px solid rgba(156,39,176,0.25); }

    /* INFO */
    .visa-info h2 { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: #fff; margin-bottom: 8px; transition: color 0.2s; }
    .visa-type-card:hover .visa-info h2 { color: #ffbf00; }
    .visa-info p { color: rgba(255,255,255,0.6); line-height: 1.7; margin-bottom: 16px; font-size: 0.95rem; }
    .tags { display: flex; gap: 10px; flex-wrap: wrap; }
    .tag {
        background: rgba(255,191,0,0.1); color: #ffbf00;
        padding: 5px 14px; border-radius: 100px;
        font-size: 0.78rem; font-weight: 600;
        border: 1px solid rgba(255,191,0,0.2);
        transition: background 0.2s, transform 0.2s;
    }
    .tag:hover { background: rgba(201,168,76,0.2); transform: translateY(-2px); }

    /* ACTION */
    .visa-action { text-align: center; flex-shrink: 0; }
    .visa-action .price {
        font-family: 'Playfair Display', serif; font-size: 1.5rem;
        font-weight: 900; color: #ffbf00; display: block; margin-bottom: 14px;
    }
    .visa-action .price span { font-size: 0.8rem; color: rgba(255,255,255,0.5); font-weight: 400; }
    .btn-apply {
        background: rgba(255,191,0,0.15); color: #ffbf00;
        padding: 12px 28px; border-radius: 10px;
        text-decoration: none; font-weight: 700; font-size: 0.9rem;
        display: inline-block; border: 1.5px solid rgba(255,191,0,0.4);
        transition: background 0.25s, color 0.25s, transform 0.25s, box-shadow 0.25s;
    }
    .btn-apply:hover { background: #ffbf00; color: #0a1628; transform: translateY(-3px); box-shadow: 0 8px 24px rgba(255,191,0,0.35); }

    /* DIVIDER */
    .card-divider {
        width: 100%; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,191,0,0.3), transparent);
        margin: 4px 0;
    }

    /* ── WHY CHOOSE ── */
    .why-section {
        background: linear-gradient(135deg, #0d1f3c 0%, #0a1628 100%);
        padding: 80px 48px; position: relative; overflow: hidden;
    }
    .why-section::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 20% 80%, rgba(201,168,76,0.05) 0%, transparent 50%);
    }
    .why-inner { max-width: 1100px; margin: 0 auto; position: relative; z-index: 2; }
    .why-title { text-align: center; margin-bottom: 52px; }
    .why-title h2 { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: #fff; margin-bottom: 10px; }
    .why-title h2 span { color: #ffbf00; }
    .why-title p { color: rgba(255,255,255,0.55); font-size: 0.95rem; max-width: 600px; margin: 0 auto; line-height: 1.7; }
    .why-title .title-line { width: 60px; height: 3px; background: #ffbf00; margin: 16px auto 0; border-radius: 2px; }

    .why-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 24px; }
    .why-card {
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
        border-radius: 18px; padding: 32px 20px; text-align: center;
        position: relative; overflow: hidden;
        transition: background 0.3s, transform 0.3s, border-color 0.3s, box-shadow 0.3s;
    }
    .why-card::before {
        content: ''; position: absolute; top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(201,168,76,0.07) 50%, transparent 70%);
        transform: translateX(-100%); transition: transform 0.5s ease;
    }
    .why-card:hover { background: rgba(201,168,76,0.1); transform: translateY(-8px); border-color: rgba(201,168,76,0.4); box-shadow: 0 16px 40px rgba(0,0,0,0.25); }
    .why-card:hover::before { transform: translateX(100%); }
    .why-icon { font-size: 2.4rem; margin-bottom: 16px; display: block; transition: transform 0.3s; }
    .why-card:hover .why-icon { transform: scale(1.2) rotate(-8deg); }
    .why-card h4 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1rem; margin-bottom: 8px; transition: color 0.2s; }
    .why-card:hover h4 { color: #c9a84c; }
    .why-card p { color: rgba(255,255,255,0.5); font-size: 0.83rem; line-height: 1.6; }

    /* ── REVEAL ── */
    .reveal { opacity:0; transform:translateY(40px); transition:opacity 0.7s ease,transform 0.7s ease; }
    .reveal.visible { opacity:1; transform:translateY(0); }
    .reveal-left { opacity:0; transform:translateX(-50px); transition:opacity 0.8s ease,transform 0.8s ease; }
    .reveal-left.visible { opacity:1; transform:translateX(0); }
    .reveal-right { opacity:0; transform:translateX(50px); transition:opacity 0.8s ease,transform 0.8s ease; }
    .reveal-right.visible { opacity:1; transform:translateX(0); }

    @media(max-width:900px) {
        .visa-type-card { grid-template-columns:1fr; text-align:center; }
        .tags { justify-content:center; }
        .visa-action { margin-top:8px; }
        .why-grid { grid-template-columns:repeat(2,1fr); }
        .visa-types-section, .why-section { padding:60px 24px; }
    }
    @media(max-width:600px) {
        .page-hero h1 { font-size:2rem; }
        .why-grid { grid-template-columns:1fr; }
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
        <h1>Visa <span>Types</span></h1>
        <p>Choose the right visa category for your travel purpose.</p>
    </div>
</div>

<!-- VISA TYPES SECTION -->
<div class="visa-types-section">
    <div class="visa-types-inner">

        <!-- TOURIST -->
        <div class="visa-type-card reveal-left">
            <div class="visa-big-icon bg-tourist">🏖️</div>
            <div class="visa-info">
                <h2>Tourist Visa</h2>
                <p>Perfect for short vacations, sightseeing, and visiting family or friends abroad. Valid for multiple entries in most countries with fast processing.</p>
                <div class="tags">
                    <span class="tag">⏱ 15–90 Days</span>
                    <span class="tag">✈️ Single/Multiple Entry</span>
                    <span class="tag">🌍 120+ Countries</span>
                    <span class="tag">⚡ Fast Processing</span>
                </div>
            </div>
            <div class="visa-action">
                <span class="price">PKR 15,000 <span>/person</span></span>
                <a href="{{ url('/choose-visa-type?type=tourist') }}" class="btn-apply">Apply Now →</a>
            </div>
        </div>

        <div class="card-divider reveal"></div>

        <!-- WORK -->
        <div class="visa-type-card reveal-right">
            <div class="visa-big-icon bg-work">💼</div>
            <div class="visa-info">
                <h2>Work Visa</h2>
                <p>For professionals seeking employment abroad. We handle all documentation including job offer letters, NOC, and embassy appointments for a smooth process.</p>
                <div class="tags">
                    <span class="tag">⏱ 1–3 Years</span>
                    <span class="tag">💼 Employment Based</span>
                    <span class="tag">🌍 60+ Countries</span>
                    <span class="tag">📋 Full Support</span>
                </div>
            </div>
            <div class="visa-action">
                <span class="price">PKR 35,000 <span>/person</span></span>
                <a href="{{ url('/choose-visa-type?type=work') }}" class="btn-apply">Apply Now →</a>
            </div>
        </div>

        <div class="card-divider reveal"></div>

        <!-- STUDY -->
        <div class="visa-type-card reveal-left">
            <div class="visa-big-icon bg-study">🎓</div>
            <div class="visa-info">
                <h2>Study Visa</h2>
                <p>Planning to study at a foreign university? We guide you through admission, IELTS requirements, financial documents, and visa interview preparation.</p>
                <div class="tags">
                    <span class="tag">⏱ 1–4 Years</span>
                    <span class="tag">🎓 University Based</span>
                    <span class="tag">🌍 50+ Countries</span>
                    <span class="tag">📝 Interview Prep</span>
                </div>
            </div>
            <div class="visa-action">
                <span class="price">PKR 45,000 <span>/person</span></span>
                <a href="{{ url('/choose-visa-type?type=study') }}" class="btn-apply">Apply Now →</a>
            </div>
        </div>

        <div class="card-divider reveal"></div>

        <!-- BUSINESS -->
        <div class="visa-type-card reveal-right">
            <div class="visa-big-icon bg-business">🤝</div>
            <div class="visa-info">
                <h2>Business Visa</h2>
                <p>For business meetings, trade conferences, and corporate events abroad. Quick processing with invitation letter support and complete document guidance included.</p>
                <div class="tags">
                    <span class="tag">⏱ 30–180 Days</span>
                    <span class="tag">🏢 Corporate Travel</span>
                    <span class="tag">🌍 80+ Countries</span>
                    <span class="tag">🚀 Express Option</span>
                </div>
            </div>
            <div class="visa-action">
                <span class="price">PKR 25,000 <span>/person</span></span>
                <a href="{{ url('/choose-visa-type?type=business') }}" class="btn-apply">Apply Now →</a>
            </div>
        </div>

        <div class="card-divider reveal"></div>

        <!-- FAMILY -->
        <div class="visa-type-card reveal-left">
            <div class="visa-big-icon bg-family">👨‍👩‍👧‍👦</div>
            <div class="visa-info">
                <h2>Family Visa</h2>
                <p>Reunite with your loved ones abroad. We handle family reunion visas, spouse visas, and dependent visas with complete document support and embassy guidance.</p>
                <div class="tags">
                    <span class="tag">⏱ 90 Days–2 Years</span>
                    <span class="tag">👨‍👩‍👧 Family Reunion</span>
                    <span class="tag">🌍 70+ Countries</span>
                    <span class="tag">💝 Full Guidance</span>
                </div>
            </div>
            <div class="visa-action">
                <span class="price">PKR 20,000 <span>/person</span></span>
                <a href="{{ url('/choose-visa-type?type=family') }}" class="btn-apply">Apply Now →</a>
            </div>
        </div>

    </div>
</div>

<!-- WHY CHOOSE US -->
<div class="why-section">
    <div class="why-inner">
        <div class="why-title reveal">
            <h2>Why Choose <span>VisaGo</span></h2>
            <p>VisaGo offers a reliable, transparent, and secure visa application service. Here's what makes us a trusted choice for international travelers.</p>
            <div class="title-line"></div>
        </div>
        <div class="why-grid">
            <div class="why-card reveal-left" style="transition-delay:0.1s">
                <span class="why-icon">⭐</span>
                <h4>Expert Review</h4>
                <p>Every application is carefully reviewed by our visa experts before submission to the embassy.</p>
            </div>
            <div class="why-card reveal" style="transition-delay:0.2s">
                <span class="why-icon">💳</span>
                <h4>Secure Payment</h4>
                <p>Your payment and personal data are protected with bank-level 256-bit SSL encryption.</p>
            </div>
            <div class="why-card reveal" style="transition-delay:0.3s">
                <span class="why-icon">⚡</span>
                <h4>Fast Processing</h4>
                <p>We process your application as quickly as possible so you can travel on time without delays.</p>
            </div>
            <div class="why-card reveal-right" style="transition-delay:0.4s">
                <span class="why-icon">🌍</span>
                <h4>120+ Countries</h4>
                <p>We cover visa services for over 120 countries around the world with local embassy expertise.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => observer.observe(el));
</script>
@endsection