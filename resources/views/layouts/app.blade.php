<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>VisaGo - @yield('title', 'Home')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
        <style>
        @keyframes shimmer { 0% { background-position:200% 0; } 100% { background-position:-200% 0; } }
        @keyframes pulse { 0%,100% { transform:scale(1); opacity:0.8; } 50% { transform:scale(1.1); opacity:1; } }
        @keyframes footerFadeUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
        @keyframes footerFloat { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-6px); } }

        /* GLOBAL FOOTER CSS */
        .g-footer { background: #060d1a; color: rgba(255,255,255,0.65); padding: 0; position: relative; overflow: hidden; }
        .g-footer::before {
            content: ''; position: absolute; width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,191,0,0.05) 0%, transparent 70%);
            top: -150px; right: -100px; pointer-events: none; animation: footerFloat 8s ease-in-out infinite;
        }
        .g-footer-topbar { height:3px; background:linear-gradient(90deg,#ffbf00,#ffd700,#ffbf00); background-size:200% 100%; animation:shimmer 3s linear infinite; }
        .g-footer-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:48px; max-width:1200px; margin:0 auto; padding:60px 48px 40px; position: relative; z-index: 2; }

        .g-footer-brand { opacity:0; animation: footerFadeUp 0.7s ease forwards; animation-delay: 0.1s; }
        .g-footer-brand h3 { font-family:'Playfair Display',serif; font-size:1.6rem; color:#ffbf00; margin-bottom:14px; transition:color 0.3s, transform 0.3s; display:inline-block; }
        .g-footer-brand h3:hover { color:#ffd740; transform: translateY(-2px); }
        .g-footer-brand p { font-size:0.88rem; line-height:1.8; color:rgba(255,255,255,0.45); margin-bottom:20px; }
        .g-footer-socials { display:flex; gap:10px; margin-bottom:20px; }
        .g-social-btn { width:38px; height:38px; border-radius:10px; border:1px solid rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.5); text-decoration:none; transition:border-color 0.25s,color 0.25s,transform 0.3s,box-shadow 0.3s,background 0.25s; }
        .g-social-btn:hover { border-color:#ffbf00; color:#ffbf00; transform:translateY(-6px) rotate(8deg) scale(1.08); background:rgba(255,191,0,0.12); box-shadow: 0 10px 24px rgba(255,191,0,0.25); }
        .g-footer-contact { display:flex; flex-direction:column; gap:8px; }
        .g-footer-contact-item { display:flex; align-items:center; gap:8px; font-size:0.83rem; color:rgba(255,255,255,0.45); transition:color 0.25s, transform 0.25s; }
        .g-footer-contact-item:hover { color:#ffbf00; transform: translateX(4px); }
        .g-footer-contact-item a { color:inherit; text-decoration:none; }

        .g-footer-col { opacity:0; animation: footerFadeUp 0.7s ease forwards; }
        .g-footer-col:nth-of-type(2) { animation-delay: 0.2s; }
        .g-footer-col:nth-of-type(3) { animation-delay: 0.3s; }
        .g-footer-col:nth-of-type(4) { animation-delay: 0.4s; }
        .g-footer-col h4 { color:#fff; font-size:0.9rem; font-weight:700; margin-bottom:18px; padding-bottom:10px; border-bottom:1px solid rgba(255,255,255,0.08); position: relative; }
        .g-footer-col h4::after {
            content:''; position:absolute; bottom:-1px; left:0; width:30px; height:2px;
            background:#ffbf00; transition: width 0.3s ease;
        }
        .g-footer-col:hover h4::after { width: 60px; }
        .g-footer-col a { display:flex; align-items:center; gap:8px; color:rgba(255,255,255,0.45); text-decoration:none; font-size:0.85rem; margin-bottom:12px; transition:color 0.25s,padding-left 0.25s,transform 0.25s; }
        .g-footer-col a::before { content:'›'; color:#ffbf00; opacity:0; transition:opacity 0.25s; }
        .g-footer-col a:hover { color:#ffbf00; padding-left:8px; transform: translateX(2px); }
        .g-footer-col a:hover::before { opacity:1; }

        .g-footer-bottom { max-width:1200px; margin:0 auto; border-top:1px solid rgba(255,255,255,0.06); padding:24px 48px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; position: relative; z-index: 2; }
        .g-footer-bottom p { font-size:0.82rem; color:rgba(255,255,255,0.3); margin:0; }
        .g-footer-badges { display:flex; gap:10px; }
        .g-badge { padding:5px 14px; border-radius:100px; border:1px solid rgba(255,255,255,0.1); font-size:0.75rem; color:rgba(255,255,255,0.35); transition:border-color 0.25s,color 0.25s,transform 0.25s,background 0.25s; cursor:default; }
        .g-badge:hover { border-color:#ffbf00; color:#ffbf00; transform:translateY(-3px); background: rgba(255,191,0,0.06); }

        .g-footer-yellowbar {
            background: #ffbf00;
            padding: 18px 48px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .g-footer-yellowbar::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,0.25) 50%, transparent 70%);
            transform: translateX(-100%); animation: yellowShine 5s ease-in-out infinite;
        }
        @keyframes yellowShine { 0% { transform: translateX(-100%); } 50%,100% { transform: translateX(100%); } }
        .g-footer-yellowbar p {
            margin: 0;
            color: #000000;
            font-size: 0.92rem;
            font-weight: 600;
            position: relative; z-index: 2;
        }
        .g-footer-yellowbar a {
            color: #000000;
            font-weight: 800;
            text-decoration: underline;
            transition: opacity 0.25s, letter-spacing 0.25s;
        }
        .g-footer-yellowbar a:hover { opacity: 0.65; letter-spacing: 0.5px; }

        @media(max-width:900px) { .g-footer-grid { grid-template-columns:1fr 1fr; padding:40px 24px; } }
        @media(max-width:600px) { .g-footer-grid { grid-template-columns:1fr; } .g-footer-bottom { padding:20px 24px; flex-direction:column; text-align:center; } }
        </style>
        @yield('styles')
    </head>

    <body style="margin:0; padding:0; font-family:'Inter',sans-serif;">

        @include('layouts.navigation')

        <main>
            @yield('content')
        </main>

        <!-- GLOBAL FOOTER -->
        <footer class="g-footer">
            <div class="g-footer-topbar"></div>
            <div class="g-footer-grid">

                <!-- BRAND -->
                <div class="g-footer-brand">
                    <h3>✈️ VisaGo</h3>
                    <p>Your trusted partner for global visa services. We simplify the complex visa process so you can focus on your journey.</p>
                    <div class="g-footer-socials">
                        <a href="https://www.facebook.com/share/1bvzj7HkUi/" target="_blank" class="g-social-btn" title="Facebook">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                        </a>
                        <a href="https://www.linkedin.com/in/qammar-jamil-7993a4397" target="_blank" class="g-social-btn" title="LinkedIn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                        </a>
                        <a href="https://tiktok.com/@qammarjamil0" target="_blank" class="g-social-btn" title="TikTok">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.75a4.85 4.85 0 01-1.01-.06z"/></svg>
                        </a>
                        <a href="https://www.youtube.com/@QammarJamil-g1q6b" target="_blank" class="g-social-btn" title="YouTube">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"/></svg>
                        </a>
                    </div>
                </div>

                               <!-- SERVICES -->
                <div class="g-footer-col">
                    <h4>🛫 Services</h4>
                    <a href="{{ url('/choose-visa-type?type=tourist') }}">Tourist Visa</a>
                    <a href="{{ url('/choose-visa-type?type=work') }}">Work Visa</a>
                    <a href="{{ url('/choose-visa-type?type=study') }}">Study Visa</a>
                    <a href="{{ url('/choose-visa-type?type=business') }}">Business Visa</a>
                    <a href="{{ url('/choose-visa-type?type=family') }}">Family Visa</a>
                </div>

                <!-- COMPANY -->
                <div class="g-footer-col">
                    <h4>🏢 Company</h4>
                    <a href="{{ url('/about') }}">About Us</a>
                    <a href="{{ url('/contact') }}">Contact</a>
                    <a href="{{ url('/countries') }}">Countries</a>
                    <a href="{{ url('/visa-types') }}">Visa Types</a>
                    <a href="{{ url('/blog') }}">Blog</a>
                </div>

                <!-- SUPPORT -->
                <div class="g-footer-col">
                    <h4>🆘 Support</h4>
                    <a href="{{ url('/dashboard') }}">Track Application</a>
                    <a href="{{ url('/visa-fees') }}">Visa Fees</a>
                    <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="{{ url('/contact') }}">Help Center</a>
                </div>
            </div>
        </footer>

        <!-- YELLOW BOTTOM BAR -->
        <div class="g-footer-yellowbar">
            <p>Copyright © {{ date('Y') }} | Powered by
                <a href="https://www.linkedin.com/in/qammar-jamil-7993a4397" target="_blank">Qammar Jamil</a>
            </p>
        </div>

        @yield('scripts')

        @if(session('step_popup'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Almost there!',
                text: @json(session('step_popup')),
                confirmButtonColor: '#c9a84c',
                background: '#0a1628',
                color: '#ffffff',
                confirmButtonText: 'Got it'
            });
        </script>
        @endif

    </body>
</html>