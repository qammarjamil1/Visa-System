@extends('layouts.app')
@section('title', 'Countries')

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

    /* ── FEATURED SECTION ── */
    .featured-section {
        background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%);
        padding: 80px 48px; position: relative; overflow: hidden;
    }
    .featured-section::before {
        content: ''; position: absolute;
        width: 500px; height: 500px; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 70%);
        top: -150px; right: -100px; pointer-events: none;
        animation: floatOrb 8s ease-in-out infinite alternate;
    }
    @keyframes floatOrb { 0%{transform:translateY(0);} 100%{transform:translateY(40px);} }
    .section-inner { max-width: 1200px; margin: 0 auto; position: relative; z-index: 2; }

    .section-title { text-align: center; margin-bottom: 48px; }
    .section-title h2 { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: #fff; margin-bottom: 10px; }
    .section-title h2 span { color: #c9a84c; }
    .section-title p { color: rgba(255,255,255,0.55); font-size: 0.95rem; }
    .section-title .title-line { width: 60px; height: 3px; background: #c9a84c; margin: 14px auto 0; border-radius: 2px; }

    /* FEATURED CARDS */
    .featured-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 24px; }
    .featured-card {
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);
        border-radius: 20px; overflow: hidden; text-decoration: none;
        transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
        position: relative;
    }
    .featured-card::before {
        content: ''; position: absolute; top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(201,168,76,0.07) 50%, transparent 70%);
        transform: translateX(-100%); transition: transform 0.6s ease;
    }
    .featured-card:hover { transform: translateY(-8px); box-shadow: 0 24px 56px rgba(0,0,0,0.35); border-color: rgba(201,168,76,0.4); }
    .featured-card:hover::before { transform: translateX(100%); }

    .featured-img {
        width: 100%; height: 180px; object-fit: cover;
        transition: transform 0.5s ease;
    }
    .featured-card:hover .featured-img { transform: scale(1.08); }
    .featured-img-wrap { overflow: hidden; height: 180px; position: relative; }
    .featured-img-wrap::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(10,22,40,0.6) 0%, transparent 60%);
    }

    .featured-body { padding: 20px; }
    .featured-flag { font-size: 1.8rem; margin-bottom: 8px; display: block; transition: transform 0.3s; }
    .featured-card:hover .featured-flag { transform: scale(1.2) rotate(-5deg); }
    .featured-body h3 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.1rem; margin-bottom: 6px; transition: color 0.2s; }
    .featured-card:hover .featured-body h3 { color: #c9a84c; }
    .featured-body p { color: rgba(255,255,255,0.5); font-size: 0.82rem; line-height: 1.5; margin-bottom: 14px; }
    .featured-badge {
        display: inline-block; background: rgba(201,168,76,0.12); color: #c9a84c;
        padding: 4px 12px; border-radius: 100px; font-size: 0.75rem; font-weight: 600;
        border: 1px solid rgba(201,168,76,0.25); transition: background 0.2s, color 0.2s;
    }
    .featured-card:hover .featured-badge { background: #c9a84c; color: #0a1628; }

    /* ── POPULAR DESTINATIONS ── */
    .destinations-section {
        background: linear-gradient(135deg, #0d1f3c 0%, #0a1628 100%);
        padding: 80px 48px; position: relative; overflow: hidden;
    }
    .destinations-section::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 20% 80%, rgba(201,168,76,0.05) 0%, transparent 50%);
    }
    .dest-tags { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; max-width: 1000px; margin: 0 auto; position: relative; z-index: 2; }
    .dest-tag {
        background: rgba(255,255,255,0.06); border: 1.5px solid rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.75); padding: 10px 22px; border-radius: 100px;
        font-size: 0.88rem; font-weight: 600; text-decoration: none;
        display: inline-flex; align-items: center; gap: 8px;
        transition: background 0.25s, color 0.25s, border-color 0.25s, transform 0.25s, box-shadow 0.25s;
        opacity: 0; transform: translateY(16px); animation: tagIn 0.5s ease forwards;
    }
    @keyframes tagIn { to { opacity:1; transform:translateY(0); } }
    .dest-tag:hover {
        background: #c9a84c; color: #0a1628; border-color: #c9a84c;
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 10px 28px rgba(201,168,76,0.35);
    }
    .dest-tag.hidden-tag { display: none; }

    .show-more-wrap { text-align: center; margin-top: 36px; position: relative; z-index: 2; }
    .btn-show-more {
        background: rgba(201,168,76,0.1); color: #c9a84c;
        border: 1.5px solid rgba(201,168,76,0.3); padding: 12px 32px;
        border-radius: 100px; font-size: 0.9rem; font-weight: 700;
        cursor: pointer; transition: background 0.25s, color 0.25s, transform 0.25s, box-shadow 0.25s;
    }
    .btn-show-more:hover { background: #c9a84c; color: #0a1628; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(201,168,76,0.3); }

    /* ── WHY CHOOSE ── */
    .why-section {
        background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%);
        padding: 80px 48px;
    }
    .why-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 24px; max-width: 1200px; margin: 0 auto; }
    .why-card {
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
        border-radius: 18px; padding: 32px 20px; text-align: center;
        transition: background 0.3s, transform 0.3s, border-color 0.3s, box-shadow 0.3s;
        position: relative; overflow: hidden;
    }
    .why-card::before {
        content: ''; position: absolute; top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(201,168,76,0.07) 50%, transparent 70%);
        transform: translateX(-100%); transition: transform 0.5s ease;
    }
    .why-card:hover { background: rgba(201,168,76,0.1); transform: translateY(-8px); border-color: rgba(201,168,76,0.4); box-shadow: 0 16px 40px rgba(0,0,0,0.25); }
    .why-card:hover::before { transform: translateX(100%); }
    .why-icon { font-size: 2.2rem; margin-bottom: 14px; display: block; transition: transform 0.3s; }
    .why-card:hover .why-icon { transform: scale(1.2) rotate(-8deg); }
    .why-card h4 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1rem; margin-bottom: 8px; transition: color 0.2s; }
    .why-card:hover h4 { color: #c9a84c; }
    .why-card p { color: rgba(255,255,255,0.5); font-size: 0.83rem; line-height: 1.6; }

    /* REVEAL */
    .reveal { opacity:0; transform:translateY(40px); transition:opacity 0.7s ease,transform 0.7s ease; }
    .reveal.visible { opacity:1; transform:translateY(0); }
    .reveal-left { opacity:0; transform:translateX(-50px); transition:opacity 0.8s ease,transform 0.8s ease; }
    .reveal-left.visible { opacity:1; transform:translateX(0); }
    .reveal-right { opacity:0; transform:translateX(50px); transition:opacity 0.8s ease,transform 0.8s ease; }
    .reveal-right.visible { opacity:1; transform:translateX(0); }

    @media(max-width:900px) {
        .featured-grid { grid-template-columns: repeat(2,1fr); }
        .why-grid { grid-template-columns: repeat(2,1fr); }
        .featured-section, .destinations-section, .why-section { padding: 60px 24px; }
    }
    @media(max-width:600px) {
        .featured-grid { grid-template-columns: 1fr; }
        .why-grid { grid-template-columns: 1fr; }
        .page-hero h1 { font-size: 2rem; }
        .page-hero { padding: 50px 24px; min-height: 220px; }
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
        <h1>Our <span>Countries</span></h1>
        <p>We process visas for 120+ countries worldwide. Find yours below.</p>
    </div>
</div>

<!-- FEATURED SECTION -->
<div class="featured-section">
    <div class="section-inner">
        <div class="section-title reveal">
            <h2>✈️ Popular <span>Fast-Track</span> Visas</h2>
            <p>Our most requested destinations with fast online processing.</p>
            <div class="title-line"></div>
        </div>
        <div class="featured-grid">
            <a href="{{ url('/visaa/canada-eta') }}" class="featured-card reveal-left" style="transition-delay:0.1s">
                <div class="featured-img-wrap">
                    <img src="https://images.unsplash.com/photo-1517935706615-2717063c2225?w=400&q=80" alt="Canada" class="featured-img"/>
                </div>
                <div class="featured-body">
                    <span class="featured-flag">🇨🇦</span>
                    <h3>Canada eTA</h3>
                    <p>Electronic Travel Authorization for visa-exempt foreign nationals.</p>
                    <span class="featured-badge">⚡ Fast Processing</span>
                </div>
            </a>
            <a href="{{ url('/visaa/uk-eta') }}" class="featured-card reveal-left" style="transition-delay:0.2s">
                <div class="featured-img-wrap">
                    <img src="https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=400&q=80" alt="UK" class="featured-img"/>
                </div>
                <div class="featured-body">
                    <span class="featured-flag">🇬🇧</span>
                    <h3>UK eTA</h3>
                    <p>UK Electronic Travel Authorization — Simple Online Application.</p>
                    <span class="featured-badge">🔒 Secure</span>
                </div>
            </a>
            <a href="{{ url('/visaa/esta-usa') }}" class="featured-card reveal-right" style="transition-delay:0.3s">
                <div class="featured-img-wrap">
                    <img src="https://images.unsplash.com/photo-1485738422979-f5c462d49f74?w=400&q=80" alt="USA" class="featured-img"/>
                </div>
                <div class="featured-body">
                    <span class="featured-flag">🇺🇸</span>
                    <h3>ESTA USA</h3>
                    <p>Electronic System for Travel Authorization — Visit America Easily.</p>
                    <span class="featured-badge">🌍 Popular</span>
                </div>
            </a>
            <a href="{{ url('/visaa/uae-visa') }}" class="featured-card reveal-right" style="transition-delay:0.4s">
                <div class="featured-img-wrap">
                    <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=400&q=80" alt="UAE" class="featured-img"/>
                </div>
                <div class="featured-body">
                    <span class="featured-flag">🇦🇪</span>
                    <h3>UAE Online Visa</h3>
                    <p>Visit Dubai, Abu Dhabi & More — Online Visa Application.</p>
                    <span class="featured-badge">✅ Easy Apply</span>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- POPULAR DESTINATIONS -->
<div class="destinations-section">
    <div class="section-inner">
        <div class="section-title reveal">
            <h2>🌍 Popular <span>Destinations</span></h2>
            <p>Click any country to start your visa application.</p>
            <div class="title-line"></div>
        </div>

        <div class="dest-tags" id="destTags">
            <a href="{{ url('/choose-visa-type?type=tourist&country=USA') }}" class="dest-tag">🇺🇸 USA</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=United Kingdom') }}" class="dest-tag">🇬🇧 United Kingdom</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Canada') }}" class="dest-tag">🇨🇦 Canada</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Australia') }}" class="dest-tag">🇦🇺 Australia</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Germany') }}" class="dest-tag">🇩🇪 Germany</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=France') }}" class="dest-tag">🇫🇷 France</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=UAE') }}" class="dest-tag">🇦🇪 UAE</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Saudi Arabia') }}" class="dest-tag">🇸🇦 Saudi Arabia</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Italy') }}" class="dest-tag">🇮🇹 Italy</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Turkey') }}" class="dest-tag">🇹🇷 Turkey</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=China') }}" class="dest-tag">🇨🇳 China</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Japan') }}" class="dest-tag">🇯🇵 Japan</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Malaysia') }}" class="dest-tag">🇲🇾 Malaysia</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Thailand') }}" class="dest-tag">🇹🇭 Thailand</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=New Zealand') }}" class="dest-tag">🇳🇿 New Zealand</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Spain') }}" class="dest-tag">🇪🇸 Spain</a>

            <a href="{{ url('/choose-visa-type?type=tourist&country=Portugal') }}" class="dest-tag hidden-tag">🇵🇹 Portugal</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Netherlands') }}" class="dest-tag hidden-tag">🇳🇱 Netherlands</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Belgium') }}" class="dest-tag hidden-tag">🇧🇪 Belgium</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Switzerland') }}" class="dest-tag hidden-tag">🇨🇭 Switzerland</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Austria') }}" class="dest-tag hidden-tag">🇦🇹 Austria</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Sweden') }}" class="dest-tag hidden-tag">🇸🇪 Sweden</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Norway') }}" class="dest-tag hidden-tag">🇳🇴 Norway</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Denmark') }}" class="dest-tag hidden-tag">🇩🇰 Denmark</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Qatar') }}" class="dest-tag hidden-tag">🇶🇦 Qatar</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Kuwait') }}" class="dest-tag hidden-tag">🇰🇼 Kuwait</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Bahrain') }}" class="dest-tag hidden-tag">🇧🇭 Bahrain</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Oman') }}" class="dest-tag hidden-tag">🇴🇲 Oman</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Singapore') }}" class="dest-tag hidden-tag">🇸🇬 Singapore</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=South Korea') }}" class="dest-tag hidden-tag">🇰🇷 South Korea</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Indonesia') }}" class="dest-tag hidden-tag">🇮🇩 Indonesia</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Philippines') }}" class="dest-tag hidden-tag">🇵🇭 Philippines</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Vietnam') }}" class="dest-tag hidden-tag">🇻🇳 Vietnam</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Sri Lanka') }}" class="dest-tag hidden-tag">🇱🇰 Sri Lanka</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Nepal') }}" class="dest-tag hidden-tag">🇳🇵 Nepal</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=South Africa') }}" class="dest-tag hidden-tag">🇿🇦 South Africa</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Egypt') }}" class="dest-tag hidden-tag">🇪🇬 Egypt</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Morocco') }}" class="dest-tag hidden-tag">🇲🇦 Morocco</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Brazil') }}" class="dest-tag hidden-tag">🇧🇷 Brazil</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Mexico') }}" class="dest-tag hidden-tag">🇲🇽 Mexico</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Greece') }}" class="dest-tag hidden-tag">🇬🇷 Greece</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Poland') }}" class="dest-tag hidden-tag">🇵🇱 Poland</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Czech Republic') }}" class="dest-tag hidden-tag">🇨🇿 Czech Republic</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Hungary') }}" class="dest-tag hidden-tag">🇭🇺 Hungary</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Romania') }}" class="dest-tag hidden-tag">🇷🇴 Romania</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Finland') }}" class="dest-tag hidden-tag">🇫🇮 Finland</a>
            <a href="{{ url('/choose-visa-type?type=tourist&country=Ireland') }}" class="dest-tag hidden-tag">🇮🇪 Ireland</a>
        </div>

        <div class="show-more-wrap">
            <button class="btn-show-more" id="showMoreBtn" onclick="toggleDestinations()">
                Show All Countries ▼
            </button>
        </div>
    </div>
</div>

<!-- WHY CHOOSE VISAGO -->
<div class="why-section">
    <div class="section-inner">
        <div class="section-title reveal">
            <h2>Why Choose <span>VisaGo</span></h2>
            <p>Trusted by thousands of travelers across Pakistan.</p>
            <div class="title-line"></div>
        </div>
        <div class="why-grid">
            <div class="why-card reveal-left" style="transition-delay:0.1s">
                <span class="why-icon">⭐</span>
                <h4>Expert Team</h4>
                <p>Our visa specialists have years of experience with all major embassies and immigration offices.</p>
            </div>
            <div class="why-card reveal" style="transition-delay:0.2s">
                <span class="why-icon">⚡</span>
                <h4>Fast Processing</h4>
                <p>We process your visa application quickly so you never miss your travel dates.</p>
            </div>
            <div class="why-card reveal" style="transition-delay:0.3s">
                <span class="why-icon">🔒</span>
                <h4>100% Secure</h4>
                <p>Your documents and personal data are always protected with bank-level security.</p>
            </div>
            <div class="why-card reveal-right" style="transition-delay:0.4s">
                <span class="why-icon">📞</span>
                <h4>24/7 Support</h4>
                <p>Our team is always available via WhatsApp, email, and phone to assist you anytime.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// STAGGERED FADE-IN FOR TAGS
document.querySelectorAll('.dest-tag').forEach((tag, i) => {
    tag.style.animationDelay = (i * 0.03) + 's';
});

// SHOW ALL / SHOW LESS TOGGLE
// Hidden tags ki list ek hi baar, page load par, save kar lo
const hiddenDestTags = document.querySelectorAll('.dest-tag.hidden-tag');
let showingAllDest = false;

function toggleDestinations() {
    const btn = document.getElementById('showMoreBtn');
    if (!showingAllDest) {
        hiddenDestTags.forEach(t => t.classList.remove('hidden-tag'));
        btn.textContent = 'Show Less ▲';
        showingAllDest = true;
    } else {
        hiddenDestTags.forEach(t => t.classList.add('hidden-tag'));
        btn.textContent = 'Show All Countries ▼';
        showingAllDest = false;
        document.querySelector('.destinations-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// SCROLL REVEAL
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => observer.observe(el));
</script>
@endsection