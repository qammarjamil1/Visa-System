@extends('layouts.app')
@section('title', 'Blog')

@section('styles')
<style>
    /* ── PAGE HERO ── */
    .page-hero {
        background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 100%);
        padding: 70px 48px; text-align: center; position: relative; overflow: hidden;
        min-height: 280px; display: flex; align-items: center; justify-content: center;
    }
    .page-hero::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(201,168,76,0.12) 0%, transparent 65%);
        animation: heroPulse 4s ease-in-out infinite;
    }
    @keyframes heroPulse { 0%,100% { transform:scale(1); opacity:0.8; } 50% { transform:scale(1.1); opacity:1; } }
    .hero-particles span {
        position: absolute; border-radius: 50%;
        background: rgba(201,168,76,0.15); animation: floatDot linear infinite;
    }
    @keyframes floatDot { 0%{transform:translateY(0) scale(1);opacity:0.7;} 100%{transform:translateY(-100px) scale(0.5);opacity:0;} }
    .page-hero-inner { position: relative; z-index: 2; animation: fadeUp 0.9s ease both; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(24px);} to{opacity:1;transform:translateY(0);} }
    .page-hero .eyebrow {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(201,168,76,0.1); border: 1px solid rgba(201,168,76,0.3);
        color: #c9a84c; padding: 6px 18px; border-radius: 100px;
        font-size: 0.78rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
        margin-bottom: 20px;
    }
    .page-hero h1 { font-family: 'Playfair Display', serif; font-size: 2.9rem; color: #fff; margin-bottom: 14px; }
    .page-hero h1 span { color: #c9a84c; }
    .page-hero p { color: rgba(255,255,255,0.6); font-size: 1.05rem; max-width: 560px; margin: 0 auto; }

    /* ── SECTION WRAP ── */
    .blog-section {
        background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%);
        padding: 70px 48px 40px; position: relative; overflow: hidden;
    }
    .blog-section::before {
        content: ''; position: absolute;
        width: 500px; height: 500px; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 70%);
        top: -150px; right: -100px; pointer-events: none;
        animation: floatOrb 8s ease-in-out infinite alternate;
    }
    @keyframes floatOrb { 0%{transform:translateY(0);} 100%{transform:translateY(40px);} }
    .blog-inner { max-width: 1180px; margin: 0 auto; position: relative; z-index: 2; }

    /* ── FEATURED POST ── */
    .featured-post {
        display: grid; grid-template-columns: 1.1fr 1fr; gap: 0;
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);
        border-radius: 24px; overflow: hidden; margin-bottom: 56px;
        box-shadow: 0 24px 60px rgba(0,0,0,0.3);
        transition: box-shadow 0.3s, transform 0.3s; text-decoration: none; display: grid;
    }
    .featured-post:hover { box-shadow: 0 32px 72px rgba(0,0,0,0.4); transform: translateY(-4px); }
    .featured-img-wrap { position: relative; overflow: hidden; min-height: 320px; }
    .featured-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; position: absolute; inset: 0; }
    .featured-post:hover .featured-img { transform: scale(1.06); }
    .featured-img-wrap::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(to right, transparent 60%, rgba(29,46,73,0.3) 100%);
    }
    .featured-content { padding: 44px 44px 44px 40px; display: flex; flex-direction: column; justify-content: center; }
    .featured-badge {
        display: inline-flex; align-items: center; gap: 6px; width: fit-content;
        background: linear-gradient(135deg, #c9a84c, #e2c06a); color: #0a1628;
        padding: 6px 16px; border-radius: 100px; font-size: 0.72rem; font-weight: 800;
        letter-spacing: 1px; text-transform: uppercase; margin-bottom: 18px;
    }
    .featured-content h2 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.7rem; line-height: 1.3; margin-bottom: 14px; transition: color 0.25s; }
    .featured-post:hover .featured-content h2 { color: #e2c06a; }
    .featured-content p { color: rgba(255,255,255,0.6); font-size: 0.93rem; line-height: 1.7; margin-bottom: 22px; }
    .featured-meta { display: flex; align-items: center; gap: 14px; margin-bottom: 22px; }
    .author-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, #c9a84c, #e2c06a);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: #0a1628; font-size: 0.85rem; flex-shrink: 0;
    }
    .meta-text { font-size: 0.8rem; }
    .meta-text .author-name { color: #fff; font-weight: 600; display: block; }
    .meta-text .meta-sub { color: rgba(255,255,255,0.45); }
    .featured-readmore {
        display: inline-flex; align-items: center; gap: 8px; width: fit-content;
        color: #c9a84c; font-weight: 700; font-size: 0.9rem; transition: gap 0.25s;
    }
    .featured-post:hover .featured-readmore { gap: 12px; }

    /* ── CATEGORY FILTER ── */
    .cat-filter { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 36px; }
    .cat-chip {
        background: rgba(255,255,255,0.05); border: 1.5px solid rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.7); padding: 9px 20px; border-radius: 100px;
        font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.25s;
    }
    .cat-chip:hover { border-color: rgba(201,168,76,0.5); color: #c9a84c; transform: translateY(-2px); }
    .cat-chip.active { background: #c9a84c; border-color: #c9a84c; color: #0a1628; }

    /* ── BLOG GRID ── */
    .blog-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; margin-bottom: 20px; }
    .blog-card {
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);
        border-radius: 20px; overflow: hidden; text-decoration: none; display: block;
        transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
        position: relative;
    }
    .blog-card::before {
        content: ''; position: absolute; top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(201,168,76,0.07) 50%, transparent 70%);
        transform: translateX(-100%); transition: transform 0.6s ease;
    }
    .blog-card:hover { transform: translateY(-8px); box-shadow: 0 24px 56px rgba(0,0,0,0.35); border-color: rgba(201,168,76,0.4); }
    .blog-card:hover::before { transform: translateX(100%); }

    .blog-img-wrap { height: 190px; overflow: hidden; position: relative; }
    .blog-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .blog-card:hover .blog-img { transform: scale(1.08); }
    .blog-img-wrap::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(10,22,40,0.55) 0%, transparent 60%);
    }

    .blog-body { padding: 24px; }
    .blog-tag {
        display: inline-block; background: rgba(201,168,76,0.12); color: #c9a84c;
        padding: 4px 12px; border-radius: 100px; font-size: 0.72rem; font-weight: 700;
        margin-bottom: 12px; border: 1px solid rgba(201,168,76,0.25);
    }
    .blog-body h3 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.15rem; margin-bottom: 10px; line-height: 1.4; transition: color 0.2s; }
    .blog-card:hover .blog-body h3 { color: #c9a84c; }
    .blog-body p { color: rgba(255,255,255,0.55); font-size: 0.85rem; line-height: 1.6; margin-bottom: 18px; }

    .blog-divider { height: 1px; background: rgba(255,255,255,0.08); margin-bottom: 14px; }
    .blog-meta-row { display: flex; justify-content: space-between; align-items: center; }
    .blog-author-mini { display: flex; align-items: center; gap: 8px; }
    .mini-avatar {
        width: 26px; height: 26px; border-radius: 50%;
        background: linear-gradient(135deg, #c9a84c, #e2c06a);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: #0a1628; font-size: 0.68rem; flex-shrink: 0;
    }
    .blog-author-mini span { font-size: 0.75rem; color: rgba(255,255,255,0.5); }
    .blog-readmore { color: #c9a84c; font-weight: 700; font-size: 0.78rem; display: flex; align-items: center; gap: 4px; transition: gap 0.2s; }
    .blog-card:hover .blog-readmore { gap: 8px; }

    /* ── NEWSLETTER ── */
    .newsletter-box {
        background: linear-gradient(135deg, rgba(201,168,76,0.12), rgba(201,168,76,0.04));
        border: 1px solid rgba(201,168,76,0.3); border-radius: 24px;
        padding: 48px; text-align: center; margin: 56px 0 10px;
        position: relative; overflow: hidden;
    }
    .newsletter-box::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 0%, rgba(201,168,76,0.1) 0%, transparent 60%);
    }
    .newsletter-content { position: relative; z-index: 2; max-width: 520px; margin: 0 auto; }
    .newsletter-content span.icon { font-size: 2.2rem; display: block; margin-bottom: 14px; }
    .newsletter-content h3 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.5rem; margin-bottom: 10px; }
    .newsletter-content p { color: rgba(255,255,255,0.6); font-size: 0.9rem; margin-bottom: 26px; }
    .newsletter-form { display: flex; gap: 12px; max-width: 420px; margin: 0 auto; }
    .newsletter-form input {
        flex: 1; padding: 14px 18px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.15);
        background: rgba(255,255,255,0.08); color: #fff; font-size: 0.9rem; outline: none;
        transition: border-color 0.25s, background 0.25s;
    }
    .newsletter-form input::placeholder { color: rgba(255,255,255,0.35); }
    .newsletter-form input:focus { border-color: #c9a84c; background: rgba(255,255,255,0.12); }
    .newsletter-form button {
        background: linear-gradient(135deg, #c9a84c, #e2c06a); color: #0a1628; border: none;
        padding: 14px 28px; border-radius: 12px; font-weight: 800; font-size: 0.88rem; cursor: pointer;
        transition: transform 0.25s, box-shadow 0.25s; white-space: nowrap;
    }
    .newsletter-form button:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(201,168,76,0.4); }

    /* REVEAL */
    .reveal { opacity:0; transform:translateY(40px); transition:opacity 0.7s ease,transform 0.7s ease; }
    .reveal.visible { opacity:1; transform:translateY(0); }

    @media(max-width:950px) {
        .featured-post { grid-template-columns: 1fr; }
        .featured-img-wrap { min-height: 240px; }
        .featured-content { padding: 32px 28px; }
        .blog-grid { grid-template-columns: repeat(2,1fr); }
        .blog-section { padding: 50px 24px 30px; }
    }
    @media(max-width:600px) {
        .blog-grid { grid-template-columns: 1fr; }
        .page-hero h1 { font-size: 2rem; }
        .page-hero { padding: 50px 24px; min-height: 240px; }
        .newsletter-form { flex-direction: column; }
        .newsletter-box { padding: 32px 24px; }
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
        <span class="eyebrow">📰 VisaGo Insights</span>
        <h1>The VisaGo <span>Blog</span></h1>
        <p>Expert visa guides, travel tips, and the latest immigration updates — written by our consultants, for your journey.</p>
    </div>
</div>

<!-- BLOG SECTION -->
<div class="blog-section">
    <div class="blog-inner">

        <!-- FEATURED POST -->
        <a href="#" class="featured-post reveal">
            <div class="featured-img-wrap">
                <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=800&q=80" alt="Featured" class="featured-img"/>
            </div>
            <div class="featured-content">
                <span class="featured-badge">⭐ Featured Article</span>
                <h2>The Complete 2026 Guide to Tourist Visas: Everything You Need Before You Apply</h2>
                <p>From document checklists to embassy timelines — our in-depth guide walks you through every stage of a successful tourist visa application, with insider tips from our consultants.</p>
                <div class="featured-meta">
                    <div class="author-avatar">VG</div>
                    <div class="meta-text">
                        <span class="author-name">VisaGo Editorial Team</span>
                        <span class="meta-sub">Oct 18, 2026 · 9 min read</span>
                    </div>
                </div>
                <span class="featured-readmore">Read Full Article →</span>
            </div>
        </a>

        <!-- CATEGORY FILTER -->
        <div class="cat-filter reveal">
            <span class="cat-chip active">All Posts</span>
            <span class="cat-chip">🏖️ Tourist Visa</span>
            <span class="cat-chip">💼 Work Visa</span>
            <span class="cat-chip">🎓 Study Visa</span>
            <span class="cat-chip">🤝 Business Visa</span>
            <span class="cat-chip">👨‍👩‍👧 Family Visa</span>
        </div>

        <!-- BLOG GRID -->
        <div class="blog-grid">

            <a href="#" class="blog-card reveal">
                <div class="blog-img-wrap">
                    <img src="https://images.unsplash.com/photo-1600195077909-46e573870d99?w=500&q=80" alt="Work Visa" class="blog-img"/>
                </div>
                <div class="blog-body">
                    <span class="blog-tag">💼 Work Visa</span>
                    <h3>How to Prepare for Your Work Visa Interview</h3>
                    <p>Practical tips from our consultants to help you confidently face your visa interview.</p>
                    <div class="blog-divider"></div>
                    <div class="blog-meta-row">
                        <div class="blog-author-mini">
                            <div class="mini-avatar">SA</div>
                            <span>Sara Ahmed</span>
                        </div>
                        <span class="blog-readmore">Read →</span>
                    </div>
                </div>
            </a>

            <a href="#" class="blog-card reveal" style="transition-delay:0.1s">
                <div class="blog-img-wrap">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=500&q=80" alt="Study Visa" class="blog-img"/>
                </div>
                <div class="blog-body">
                    <span class="blog-tag">🎓 Study Visa</span>
                    <h3>Studying Abroad: A Step-by-Step Visa Guide for 2026</h3>
                    <p>Everything international students need to know before applying for a study visa.</p>
                    <div class="blog-divider"></div>
                    <div class="blog-meta-row">
                        <div class="blog-author-mini">
                            <div class="mini-avatar">MK</div>
                            <span>M. Khan</span>
                        </div>
                        <span class="blog-readmore">Read →</span>
                    </div>
                </div>
            </a>

            <a href="#" class="blog-card reveal" style="transition-delay:0.2s">
                <div class="blog-img-wrap">
                    <img src="https://images.unsplash.com/photo-1540339832862-474599807836?w=500&q=80" alt="Business Visa" class="blog-img"/>
                </div>
                <div class="blog-body">
                    <span class="blog-tag">🤝 Business Visa</span>
                    <h3>Business Travel Made Easy: Visa Tips for Entrepreneurs</h3>
                    <p>Save time and avoid common mistakes when applying for a business visa.</p>
                    <div class="blog-divider"></div>
                    <div class="blog-meta-row">
                        <div class="blog-author-mini">
                            <div class="mini-avatar">HR</div>
                            <span>H. Raza</span>
                        </div>
                        <span class="blog-readmore">Read →</span>
                    </div>
                </div>
            </a>

            <a href="#" class="blog-card reveal" style="transition-delay:0.3s">
                <div class="blog-img-wrap">
                    <img src="https://images.unsplash.com/photo-1488085061387-422e29b40080?w=500&q=80" alt="Family Visa" class="blog-img"/>
                </div>
                <div class="blog-body">
                    <span class="blog-tag">👨‍👩‍👧 Family Visa</span>
                    <h3>Reuniting with Family Abroad: What You Need to Know</h3>
                    <p>A guide to family visa requirements, processing times, and documentation.</p>
                    <div class="blog-divider"></div>
                    <div class="blog-meta-row">
                        <div class="blog-author-mini">
                            <div class="mini-avatar">AF</div>
                            <span>A. Fatima</span>
                        </div>
                        <span class="blog-readmore">Read →</span>
                    </div>
                </div>
            </a>

            <a href="#" class="blog-card reveal" style="transition-delay:0.4s">
                <div class="blog-img-wrap">
                    <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=500&q=80" alt="Travel Tips" class="blog-img"/>
                </div>
                <div class="blog-body">
                    <span class="blog-tag">🌍 Travel Tips</span>
                    <h3>5 Common Visa Mistakes That Could Get Your Application Rejected</h3>
                    <p>Avoid these common pitfalls to improve your chances of a smooth approval.</p>
                    <div class="blog-divider"></div>
                    <div class="blog-meta-row">
                        <div class="blog-author-mini">
                            <div class="mini-avatar">VG</div>
                            <span>VisaGo Team</span>
                        </div>
                        <span class="blog-readmore">Read →</span>
                    </div>
                </div>
            </a>

            <a href="#" class="blog-card reveal" style="transition-delay:0.5s">
                <div class="blog-img-wrap">
                    <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=500&q=80" alt="Tourist Visa" class="blog-img"/>
                </div>
                <div class="blog-body">
                    <span class="blog-tag">🏖️ Tourist Visa</span>
                    <h3>Schengen vs. UK Visa: Which One Do You Actually Need?</h3>
                    <p>A clear comparison to help you choose the right visa for your next European trip.</p>
                    <div class="blog-divider"></div>
                    <div class="blog-meta-row">
                        <div class="blog-author-mini">
                            <div class="mini-avatar">QJ</div>
                            <span>Q. Jamil</span>
                        </div>
                        <span class="blog-readmore">Read →</span>
                    </div>
                </div>
            </a>

        </div>

        <!-- NEWSLETTER -->
        <div class="newsletter-box reveal">
            <div class="newsletter-content">
                <span class="icon">📩</span>
                <h3>Never Miss a Visa Update</h3>
                <p>Subscribe to get the latest visa news, travel guides, and exclusive tips delivered straight to your inbox.</p>
                <form class="newsletter-form" onsubmit="event.preventDefault(); this.querySelector('button').textContent='✓ Subscribed!';">
                    <input type="email" placeholder="Enter your email address" required/>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>

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

// CATEGORY FILTER (visual toggle only — articles not yet filterable by category)
document.querySelectorAll('.cat-chip').forEach(chip => {
    chip.addEventListener('click', function () {
        document.querySelectorAll('.cat-chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>
@endsection