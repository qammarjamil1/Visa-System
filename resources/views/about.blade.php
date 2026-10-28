@extends('layouts.app')
@section('title', 'About Us')

@section('styles')
<style>
    /* ── PAGE HERO ── */
    .page-hero {
        background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 100%);
        padding: 10px 8px; text-align: center; position: relative; overflow: hidden;
        min-height: 280px; display: flex; align-items: center; justify-content: center;
    }
    .page-hero::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(255,191,0,0.12) 0%, transparent 65%);
        animation: heroPulse 4s ease-in-out infinite;
    }
    @keyframes heroPulse { 0%,100% { transform: scale(1); opacity:0.8; } 50% { transform: scale(1.1); opacity:1; } }
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

    /* ── ABOUT SECTION ── */
    .about-section {
        background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%);
        padding: 80px 48px; position: relative; overflow: hidden;
    }
    .about-section::before {
        content: ''; position: absolute;
        width: 500px; height: 500px; border-radius: 50%;
        background: radial-gradient(circle, rgba(255,191,0,0.07) 0%, transparent 70%);
        top: -150px; right: -100px; pointer-events: none;
        animation: floatOrb 8s ease-in-out infinite alternate;
    }
    @keyframes floatOrb { 0% { transform: translateY(0); } 100% { transform: translateY(40px); } }
    .section { max-width: 1100px; margin: 0 auto; position: relative; z-index: 2; }
    .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 72px; align-items: center; }
    .about-text h2 { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: #fff; margin-bottom: 20px; line-height: 1.3; }
    .about-text h2 span { color: #ffbf00; }
    .about-text p { color: rgba(255,255,255,0.65); line-height: 1.9; margin-bottom: 16px; font-size: 0.95rem; }
    .about-badges { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 24px; }
    .about-badge {
        background: rgba(255,191,0,0.1); border: 1px solid rgba(255,191,0,0.25);
        color: #ffbf00; padding: 7px 16px; border-radius: 100px;
        font-size: 0.8rem; font-weight: 600;
        transition: background 0.25s, transform 0.25s, box-shadow 0.25s;
    }
    .about-badge:hover { background: rgba(255,191,0,0.25); transform: translateY(-3px); box-shadow: 0 6px 16px rgba(255,191,0,0.2); }
    .about-img-wrap {
        border-radius: 20px; overflow: hidden; height: 400px; position: relative;
        box-shadow: 0 24px 60px rgba(0,0,0,0.4); border: 2px solid rgba(255,191,0,0.2);
        transition: box-shadow 0.4s, transform 0.4s;
    }
    .about-img-wrap:hover { transform: translateY(-6px); box-shadow: 0 32px 72px rgba(0,0,0,0.5); }
    .about-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .about-img-wrap:hover img { transform: scale(1.06); }
    .about-img-wrap::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(10,22,40,0.5) 0%, transparent 60%);
    }

    /* ── STATS BAR ── */
    .stats-bar {
        background: linear-gradient(90deg, #ffbf00 0%, #ffd700 50%, #ffbf00 100%);
        background-size: 200% 100%; animation: shimmer 4s linear infinite;
        display: flex; justify-content: center; gap: 64px; padding: 26px; flex-wrap: wrap;
    }
    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    .stat-item { text-align: center; transition: transform 0.25s; cursor: default; }
    .stat-item:hover { transform: scale(1.12); }
    .stat-num { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 900; color: #0a1628; display: block; }
    .stat-lbl { font-size: 0.78rem; font-weight: 700; color: rgba(10,22,40,0.65); text-transform: uppercase; letter-spacing: 1px; }

       /* ── TEAM SECTION ── */
    .team-section { background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%); padding: 90px 48px; }
    .team-section-title { text-align: center; margin-bottom: 52px; }
    .team-section-title h2 { font-family: 'Playfair Display', serif; font-size: 2.4rem; color: #fff; margin-bottom: 10px; }
    .team-section-title p { color: rgba(255,255,255,0.6); margin-top: 8px; }
    .team-section-title .title-line { width: 60px; height: 3px; background: #ffbf00; margin: 14px auto 0; border-radius: 2px; }

    .team-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 28px; max-width: 1100px; margin: 0 auto; }

    .team-card {
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
        text-align: center; padding: 35px 25px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        overflow: hidden; position: relative;
    }
    .team-card:hover {
        transform: translateY(-10px) rotate(0.5deg) scale(1.02);
        box-shadow: 0 24px 56px rgba(0,0,0,0.35);
        border-color: rgba(255,191,0,0.4);
        background: rgba(255,255,255,0.1);
    }

    /* DIAGONAL SHINE */
    .team-card::before {
        content: ''; position: absolute; top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(255,191,0,0.07) 50%, transparent 70%);
        transform: translateX(-100%); transition: transform 0.6s ease;
    }
    .team-card:hover::before { transform: translateX(100%); }

    /* TEAM PIC */
    .team-pic-wrapper {
        position: relative; width: 200px; height: 200px;
        margin: 0 auto 18px; border-radius: 50%; overflow: hidden;
        border: 4px solid #ffbf00;
        box-shadow: 0 5px 20px rgba(255,191,0,0.3);
        cursor: pointer; transition: box-shadow 0.3s;
    }
    .team-card:hover .team-pic-wrapper { box-shadow: 0 10px 32px rgba(255,191,0,0.5); }
    .team-pic-wrapper img {
        width: 100%; height: 100%; object-fit: cover;
        object-position: top center;
        transition: transform 0.4s ease;
    }
    .team-pic-wrapper:hover img { transform: scale(1.12); }

    /* NAME OVERLAY */
    .team-name-overlay {
        position: absolute; top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 140px; height: 28px;
        display: flex; justify-content: center; align-items: center;
        margin-top: 50px;
        background: #0a1628; border: 1px solid #ffbf00;
        border-radius: 30px; opacity: 0; transition: opacity 0.3s;
    }
    .team-pic-wrapper:hover .team-name-overlay { opacity: 1; }
    .team-name-overlay span { color: #ffbf00; font-size: 0.88rem; font-weight: 700; text-align: center; }

    /* CARD BODY */
    .team-card .team-role {
        background: rgba(255,191,0,0.15); color: #ffbf00;
        padding: 5px 16px; border-radius: 20px;
        font-size: 0.8rem; font-weight: 600;
        display: inline-block; margin: 8px 0 12px;
        border: 1px solid rgba(255,191,0,0.3);
        transition: background 0.3s, color 0.3s;
    }
    .team-card:hover .team-role { background: #ffbf00; color: #0a1628; }
    .team-card h3 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.1rem; font-weight: 800; margin-bottom: 8px; }
    .team-card p { color: rgba(255,255,255,0.55); font-size: 0.85rem; line-height: 1.6; }

    /* ── VALUES SECTION ── */
    .values-section {
        background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%);
        padding: 80px 48px;
    }
    .section-title { text-align: center; margin-bottom: 48px; }
    .section-title h2 { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: #fff; }
    .section-title h2 span { color: #ffbf00; }
    .section-title p { color: rgba(255,255,255,0.55); margin-top: 8px; }
    .values-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 24px; max-width: 1100px; margin: 0 auto; }
    .value-card {
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
        border-radius: 18px; padding: 32px 20px; text-align: center;
        transition: background 0.3s, transform 0.3s, border-color 0.3s, box-shadow 0.3s;
        position: relative; overflow: hidden;
    }
    .value-card::before {
        content: ''; position: absolute; top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(255,191,0,0.06) 50%, transparent 70%);
        transform: translateX(-100%); transition: transform 0.5s ease;
    }
    .value-card:hover { background: rgba(255,191,0,0.1); transform: translateY(-8px); border-color: rgba(255,191,0,0.4); box-shadow: 0 16px 40px rgba(0,0,0,0.25); }
    .value-card:hover::before { transform: translateX(100%); }
    .value-icon { font-size: 2.4rem; margin-bottom: 16px; display: block; transition: transform 0.3s; }
    .value-card:hover .value-icon { transform: scale(1.2) rotate(-8deg); }
    .value-card h3 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1rem; margin-bottom: 8px; }
    .value-card p { color: rgba(255,255,255,0.5); font-size: 0.83rem; line-height: 1.6; }


    /* ── REVEAL ── */
    .reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    .reveal-left { opacity: 0; transform: translateX(-60px); transition: opacity 0.8s ease, transform 0.8s ease; }
    .reveal-left.visible { opacity: 1; transform: translateX(0); }
    .reveal-right { opacity: 0; transform: translateX(60px); transition: opacity 0.8s ease, transform 0.8s ease; }
    .reveal-right.visible { opacity: 1; transform: translateX(0); }
    .reveal-up { opacity: 0; transform: translateY(60px); transition: opacity 0.8s ease, transform 0.8s ease; }
    .reveal-up.visible { opacity: 1; transform: translateY(0); }

    @media(max-width: 900px) {
        .about-grid { grid-template-columns: 1fr; gap: 40px; }
        .team-grid { grid-template-columns: repeat(2,1fr) !important; }
        .values-grid { grid-template-columns: repeat(2,1fr); }
        .footer-grid { grid-template-columns: 1fr 1fr; padding: 40px 24px; }
    }
    @media(max-width: 600px) {
        .page-hero h1 { font-size: 2rem; }
        .about-section, .team-section, .values-section { padding: 60px 20px; }
        .team-grid { grid-template-columns: 1fr !important; }
        .values-grid { grid-template-columns: 1fr; }
        .footer-grid { grid-template-columns: 1fr; }
        .footer-bottom { padding: 20px 24px; flex-direction: column; text-align: center; }
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
        <h1>About <span>VisaGo</span></h1>
        <p>We have been helping people travel the world since 2010.</p>
    </div>
</div>

<!-- ABOUT SECTION -->
<div class="about-section">
    <div class="section">
        <div class="about-grid">
            <div class="about-text reveal-left">
                <h2>Who <span>We Are</span></h2>
                <p>VisaGo is a leading visa consultancy service helping thousands of people every year to get their visas approved quickly and easily.</p>
                <p>With over 15 years of experience and a 98% success rate, we handle Tourist, Work, Study, and Business visas for 100+ countries.</p>
                <p>Our expert team guides you through every step — from document preparation to final approval.</p>
                <div class="about-badges">
                    <span class="about-badge">✅ 98% Success Rate</span>
                    <span class="about-badge">🌍 120+ Countries</span>
                    <span class="about-badge">⚡ Fast Processing</span>
                    <span class="about-badge">🔒 100% Secure</span>
                </div>
            </div>
            <div class="about-img-wrap reveal-right">
                <img src="/images/about-main.jpg" alt="About VisaGo"/>
            </div>
        </div>
    </div>
</div>

<!-- STATS BAR -->
<div class="stats-bar">
    <div class="stat-item"><span class="stat-num" data-target="15" data-suffix="+">0</span><span class="stat-lbl">Years Experience</span></div>
    <div class="stat-item"><span class="stat-num" data-target="7500" data-suffix="+">0</span><span class="stat-lbl">Visas Approved</span></div>
    <div class="stat-item"><span class="stat-num" data-target="120" data-suffix="+">0</span><span class="stat-lbl">Countries</span></div>
    <div class="stat-item"><span class="stat-num" data-target="98" data-suffix="%">0</span><span class="stat-lbl">Success Rate</span></div>
</div>

<!-- TEAM SECTION -->
<div class="team-section">
    <div class="team-section-title reveal">
        <h2>👨‍💻 Our Team</h2>
        <p>Expert visa consultants ready to help you.</p>
        <div class="title-line"></div>
    </div>
    <div class="team-grid">

        <div class="team-card reveal" style="transition-delay:0.1s">
            <div class="team-pic-wrapper">
                <img src="{{ asset('images/team1.jpg') }}" alt="Aamir Jamil"/>
                <div class="team-name-overlay"><span>Aamir Jamil</span></div>
            </div>
            <span class="team-role">Lead Developer</span>
            <p>Lead Developer | I build Laravel backends that scale from 0 to millions of users.</p>
        </div>

        <div class="team-card reveal" style="transition-delay:0.2s">
            <div class="team-pic-wrapper">
                <img src="{{ asset('images/team2.jpg') }}" alt="Raja Saeed"/>
                <div class="team-name-overlay"><span>Raja Saeed</span></div>
            </div>
            <span class="team-role">Content Manager</span>
            <p>Content Manager | Creating content that engages audiences and drives real growth.</p>
        </div>

        <div class="team-card reveal" style="transition-delay:0.3s">
            <div class="team-pic-wrapper">
                <img src="{{ asset('images/team3.jpg') }}" alt="Qammar Jamil"/>
                <div class="team-name-overlay"><span>Qammar Jamil</span></div>
            </div>
            <span class="team-role">UI/UX Designer</span>
            <p>UI/UX Designer | Designing interfaces that look stunning and feel effortless.</p>
        </div>

    </div>
</div>

<!-- VALUES SECTION -->
<div class="values-section">
    <div class="section-title reveal">
        <h2>💎 Our <span>Values</span></h2>
        <p>What drives us every single day.</p>
    </div>
    <div class="values-grid">
        <div class="value-card reveal-left" style="transition-delay:0.1s">
            <span class="value-icon">🎯</span>
            <h3>Accuracy</h3>
            <p>Every application is handled with precision and attention to detail.</p>
        </div>
        <div class="value-card reveal-up" style="transition-delay:0.2s">
            <span class="value-icon">⚡</span>
            <h3>Speed</h3>
            <p>We process your visa application as fast as possible without errors.</p>
        </div>
        <div class="value-card reveal-up" style="transition-delay:0.3s">
            <span class="value-icon">🔒</span>
            <h3>Trust</h3>
            <p>Your documents and personal data are always safe with us.</p>
        </div>
        <div class="value-card reveal-right" style="transition-delay:0.4s">
            <span class="value-icon">🌍</span>
            <h3>Global Reach</h3>
            <p>We cover 120+ countries with expert knowledge of each region.</p>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
// SCROLL REVEAL
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-up').forEach(el => observer.observe(el));

// COUNTER ANIMATION
function animateCounter(el, target, suffix) {
    let start = 0;
    const step = target / 80;
    const timer = setInterval(() => {
        start += step;
        if (start >= target) { start = target; clearInterval(timer); }
        el.textContent = Math.floor(start).toLocaleString() + suffix;
    }, 16);
}
const statsObs = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting) {
        document.querySelectorAll('.stat-num').forEach(el => {
            const target = parseInt(el.dataset.target);
            const suffix = el.dataset.suffix;
            animateCounter(el, target, suffix);
        });
        statsObs.disconnect();
    }
}, { threshold: 0.5 });
const statsEl = document.querySelector('.stats-bar');
if (statsEl) statsObs.observe(statsEl);
</script>
@endsection