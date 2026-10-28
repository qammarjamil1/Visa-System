<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Login - VisaGo</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
html, body { height:100%; font-family:'Inter',sans-serif; overflow:hidden; }

body {
    background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 55%, #1a3a5c 100%);
    position: relative;
    display: flex; align-items: center; justify-content: center;
    min-height: 100vh;
}
body::before {
    content:''; position:absolute; inset:0;
    background: radial-gradient(circle at 20% 20%, rgba(201,168,76,0.1) 0%, transparent 50%),
                radial-gradient(circle at 85% 80%, rgba(201,168,76,0.08) 0%, transparent 50%);
    animation: heroGlow 6s ease-in-out infinite alternate;
}
@keyframes heroGlow { 0%{opacity:.6;transform:scale(1);} 100%{opacity:1;transform:scale(1.06);} }

.particles span {
    position:absolute; border-radius:50%; background:rgba(201,168,76,0.18);
    animation: floatDot linear infinite;
}
@keyframes floatDot { 0%{transform:translateY(0) scale(1);opacity:.7;} 100%{transform:translateY(-100px) scale(.5);opacity:0;} }

/* ── MAIN CENTERED BLOCK ── */
.center-block {
    position: relative; z-index: 2;
    display: flex; flex-direction: column; align-items: center;
    animation: fadeUp .8s ease both;
}
@keyframes fadeUp { from{opacity:0;transform:translateY(20px);} to{opacity:1;transform:translateY(0);} }

.brand-logo {
    display:flex; align-items:center; gap:8px;
    font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700; color:#fff;
    margin-bottom: 18px;
}
.brand-logo span { color:#c9a84c; }

/* ROW: TICKER + FORM CARD */
.content-row {
    display: flex; align-items: center; gap: 24px;
}

/* VERTICAL TICKER — NO BACKGROUND */
.vticker-wrap {
    width: 150px; height: 340px;
    overflow: hidden;
    -webkit-mask-image: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.15) 15%, #000 42%, #000 58%, rgba(0,0,0,0.15) 85%, transparent 100%);
    mask-image: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.15) 15%, #000 42%, #000 58%, rgba(0,0,0,0.15) 85%, transparent 100%);
}
.vticker-track {
    display: flex; flex-direction: column; align-items: center;
    animation: vScroll 12s linear infinite;
}
.vticker-item {
    padding: 16px 0; text-align: center;
    font-family:'Playfair Display',serif; font-size: 1rem; font-weight: 700;
    color: #fff; white-space: nowrap;
}
.vticker-item .icon { margin-right: 6px; }
@keyframes vScroll { 0%{transform:translateY(0);} 100%{transform:translateY(-50%);} }

/* FORM CARD */
.form-card {
    background: #f4f6fa; border-radius: 18px;
    padding: 28px 30px; width: 340px;
    box-shadow: 0 24px 60px rgba(0,0,0,0.4);
}
.form-card h2 { font-family:'Playfair Display',serif; font-size:1.35rem; color:#0a1628; margin-bottom:18px; text-align:center; }

.alert-box { padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:.8rem; }
.alert-error { background:#fee2e2; color:#dc2626; border:1px solid #fecaca; }
.alert-status { background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0; }

.form-group { margin-bottom:14px; }
.form-group label {
    display:block; font-size:.7rem; font-weight:700; color:#0a1628;
    text-transform:uppercase; letter-spacing:1px; margin-bottom:6px;
}
.form-group input {
    width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px;
    font-size:.88rem; font-family:'Inter',sans-serif; outline:none;
    transition: border-color .25s, box-shadow .25s, transform .15s;
}
.form-group input:focus { border-color:#c9a84c; box-shadow:0 0 0 3px rgba(201,168,76,0.15); transform: translateY(-1px); }
.error-msg { color:#dc2626; font-size:.72rem; margin-top:4px; }

.form-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
.remember-label { display:flex; align-items:center; gap:6px; font-size:.78rem; color:#4b5568; cursor:pointer; }
.remember-label input { width:14px; height:14px; accent-color:#c9a84c; cursor:pointer; }
.forgot-link { font-size:.78rem; color:#6b7a99; text-decoration:none; transition:color .2s; }
.forgot-link:hover { color:#c9a84c; }

.btn-login {
    width:100%; padding:11px; background:linear-gradient(135deg,#0a1628,#1a3a5c);
    color:#c9a84c; border:none; border-radius:8px; font-size:.9rem; font-weight:700;
    letter-spacing:.5px; text-transform:uppercase; cursor:pointer;
    transition: transform .25s, box-shadow .25s;
}
.btn-login:hover { transform:translateY(-2px); box-shadow:0 10px 24px rgba(10,22,40,0.3); }
.btn-login:active { transform:translateY(0); }

.divider { display:flex; align-items:center; gap:10px; margin:16px 0; }
.divider .line { flex:1; height:1px; background:#e2e8f0; }
.divider span { color:#9aa5b8; font-size:.72rem; font-weight:600; }

.btn-google {
    width:100%; display:flex; align-items:center; justify-content:center; gap:8px;
    padding:10px; background:#fff; border:1.5px solid #e2e8f0; border-radius:8px;
    text-decoration:none; font-weight:600; font-size:.82rem; color:#374151;
    transition: border-color .25s, box-shadow .25s, transform .2s;
}
.btn-google:hover { border-color:#c9a84c; box-shadow:0 8px 18px rgba(0,0,0,0.06); transform:translateY(-2px); }

.register-btn {
    display:block; text-align:center; margin-top:16px;
    padding: 10px; border-radius:8px;
    background: rgba(201,168,76,0.12); border:1.5px solid rgba(201,168,76,0.4);
    color:#a8842f; font-weight:700; font-size:.82rem; text-decoration:none;
    transition: background .25s, color .25s, transform .2s;
}
.register-btn:hover { background:#c9a84c; color:#fff; transform:translateY(-2px); }

@media(max-width: 700px) {
    .content-row { flex-direction: column; }
    .vticker-wrap { display:none; }
    body { overflow-y: auto; }
}
</style>
</head>
<body>

<div class="particles" aria-hidden="true">
    <span style="width:7px;height:7px;top:15%;left:15%;animation-duration:7s;"></span>
    <span style="width:5px;height:5px;top:70%;left:80%;animation-duration:9s;animation-delay:2s;"></span>
    <span style="width:9px;height:9px;top:40%;left:85%;animation-duration:8s;animation-delay:1s;"></span>
    <span style="width:6px;height:6px;top:80%;left:10%;animation-duration:6s;animation-delay:3s;"></span>
</div>

<div class="center-block">
    <div class="brand-logo">✈️ Visa<span>Go</span></div>

    <div class="content-row">

        <!-- VERTICAL SCROLLING VISA TYPES — NO BACKGROUND -->
        <div class="vticker-wrap">
            <div class="vticker-track">
                <div class="vticker-item"><span class="icon">🏖️</span>Tourist Visa</div>
                <div class="vticker-item"><span class="icon">💼</span>Work Visa</div>
                <div class="vticker-item"><span class="icon">🎓</span>Study Visa</div>
                <div class="vticker-item"><span class="icon">🤝</span>Business Visa</div>
                <div class="vticker-item"><span class="icon">👨‍👩‍👧</span>Family Visa</div>
                <!-- duplicate for seamless loop -->
                <div class="vticker-item"><span class="icon">🏖️</span>Tourist Visa</div>
                <div class="vticker-item"><span class="icon">💼</span>Work Visa</div>
                <div class="vticker-item"><span class="icon">🎓</span>Study Visa</div>
                <div class="vticker-item"><span class="icon">🤝</span>Business Visa</div>
                <div class="vticker-item"><span class="icon">👨‍👩‍👧</span>Family Visa</div>
            </div>
        </div>

        <!-- LOGIN FORM CARD -->
        <div class="form-card">
            <h2>Login to VisaGo</h2>

            @if(session('status'))
                <div class="alert-box alert-status">{{ session('status') }}</div>
            @endif

            @if(session('error'))
                <div class="alert-box alert-error">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com"/>
                    @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"/>
                    @error('password') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">Log In</button>
            </form>

            <div class="divider"><div class="line"></div><span>OR</span><div class="line"></div></div>

            <a href="{{ route('google.login') }}" class="btn-google">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="18" height="18">
                    <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.3 36 24 36c-6.6 0-12-5.4-12-12S17.4 12 24 12c3 0 5.8 1.1 7.9 3l5.7-5.7C34.1 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.3-.4-3.5z"/>
                    <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.4 19 12 24 12c3 0 5.8 1.1 7.9 3l5.7-5.7C34.1 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                    <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.6-5.2l-6.3-5.2C29.2 35.1 26.7 36 24 36c-5.3 0-9.7-3.3-11.3-8l-6.6 5.1C9.5 39.6 16.2 44 24 44z"/>
                    <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-1.1 3.1-3.4 5.6-6.3 7.2l6.3 5.2C39.5 36.6 44 31 44 24c0-1.3-.1-2.3-.4-3.5z"/>
                </svg>
                Continue with Google
            </a>

            <a href="{{ route('register') }}" class="register-btn">Don't have an account? Register Here →</a>
        </div>

    </div>
</div>

</body>
</html>