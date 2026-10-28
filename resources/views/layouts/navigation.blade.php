<style>
@keyframes navFadeDown {
    from { opacity: 0; transform: translateY(-15px); }
    to { opacity: 1; transform: translateY(0); }
}
.nav-wrap { animation: navFadeDown 0.6s ease both; }

.nav-logo { transition: transform 0.3s ease, filter 0.3s ease; display: inline-block; }
.nav-logo:hover { transform: scale(1.05); filter: drop-shadow(0 0 8px rgba(255,191,0,0.4)); }

.nav-link {
    position: relative;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.25s ease;
    padding-bottom: 4px;
}
.nav-link::after {
    content: '';
    position: absolute;
    left: 0; bottom: 0;
    width: 0; height: 2px;
    background: #ffbf00;
    transition: width 0.3s ease;
}
.nav-link:hover { color: #ffbf00; }
.nav-link:hover::after { width: 100%; }

.nav-dashboard-link {
    color: #ffbf00; text-decoration: none; font-size: 0.9rem; font-weight: 600;
    display: flex; align-items: center; gap: 5px; transition: color 0.25s ease, transform 0.25s ease;
}
.nav-dashboard-link:hover { color: #ffd740; transform: translateY(-2px); }

.nav-user-name {
    color: rgba(255,255,255,0.7); font-size: 0.9rem; transition: color 0.25s ease;
}

.nav-logout-btn {
    background: transparent; border: 1.5px solid rgba(255,255,255,0.3); color: #fff;
    padding: 8px 20px; border-radius: 8px; cursor: pointer; font-size: 0.9rem;
    transition: background 0.25s ease, border-color 0.25s ease, transform 0.25s ease, box-shadow 0.25s ease;
}
.nav-logout-btn:hover {
    background: rgba(239,68,68,0.15); border-color: #ef4444; color: #ff8787;
    transform: translateY(-2px); box-shadow: 0 6px 18px rgba(239,68,68,0.2);
}

.nav-login-link {
    color: rgba(255,255,255,0.8); text-decoration: none; font-size: 0.9rem;
    transition: color 0.25s ease;
}
.nav-login-link:hover { color: #ffbf00; }

.nav-register-btn {
    background: #ffbf00; color: #0a1628; padding: 8px 20px; border-radius: 8px;
    text-decoration: none; font-weight: 700; font-size: 0.9rem;
    transition: background 0.25s ease, transform 0.25s ease, box-shadow 0.25s ease;
    display: inline-block;
}
.nav-register-btn:hover {
    background: #ffd740; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255,191,0,0.35);
}

.nav-fee-menu-item {
    display:block; padding:12px 18px; color:#0a1628; text-decoration:none; font-size:0.88rem;
    transition: background 0.2s ease, padding-left 0.2s ease;
}
.nav-fee-menu-item:hover { background:#faf8f3; padding-left: 22px; }

/* HOVER-BASED DROPDOWNS (Fee & Pages) */
.nav-dropdown-wrap { position: relative; }
.nav-dropdown-wrap .nav-menu-box {
    display: none;
    position: absolute; top: calc(100% + 10px); left: 0;
    background: #fff; border-radius: 10px; min-width: 200px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15); overflow: hidden; z-index: 999;
    animation: navFadeDown 0.25s ease both;
}
.nav-dropdown-wrap:hover .nav-menu-box { display: block; }
.nav-dropdown-wrap::after {
    content: ''; position: absolute; top: 100%; left: 0; right: 0; height: 10px;
}
</style>

<nav class="nav-wrap" style="background:#0a1628; padding:0 48px; display:flex; align-items:center; justify-content:space-between; height:82px; position:sticky; top:0; z-index:1000;">

    <!-- Logo -->
    <a href="{{ url('/') }}" class="nav-logo" style="font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:900; color:#ffbf00; text-decoration:none;">
        ✈️ VisaGo
    </a>

    <!-- Nav Links -->
    <div style="display:flex; gap:32px; align-items:center;">
        <a href="{{ url('/') }}" class="nav-link">Home</a>
        <a href="{{ url('/about') }}" class="nav-link">About</a>
        <a href="{{ url('/countries') }}" class="nav-link">Countries</a>
        <a href="{{ url('/visa-types') }}" class="nav-link">Visa Types</a>

        <!-- FEE DROPDOWN (hover based) -->
        <div class="nav-dropdown-wrap">
            <a href="{{ url('/visa-fees') }}" class="nav-link"
               style="display:flex; align-items:center; gap:4px;">
                Fee <span style="font-size:0.7rem;">▾</span>
            </a>
            <div class="nav-menu-box">
                <a href="{{ url('/visa-fees') }}" class="nav-fee-menu-item" style="border-bottom:1px solid #f0f0f0;">
                    💳 Visa Fees
                </a>
                <a href="{{ url('/exit-permit-fee') }}" class="nav-fee-menu-item">
                    🚪 Exit Permit Fee
                </a>
            </div>
        </div>

        <!-- PAGES DROPDOWN (hover based) — Privacy + Blog -->
        <div class="nav-dropdown-wrap">
            <a href="#" class="nav-link" onclick="return false;"
               style="display:flex; align-items:center; gap:4px;">
                Pages <span style="font-size:0.7rem;">▾</span>
            </a>
            <div class="nav-menu-box">
                <a href="{{ url('/privacy-policy') }}" class="nav-fee-menu-item" style="border-bottom:1px solid #f0f0f0;">
                    🔒 Privacy Policy
                </a>
                <a href="{{ url('/blog') }}" class="nav-fee-menu-item">
                    📰 Blog
                </a>
            </div>
        </div>

        <a href="{{ url('/contact') }}" class="nav-link">Contact Us</a>

        @auth
        <a href="{{ url('/dashboard') }}" class="nav-dashboard-link">
            📊 Dashboard
        </a>
        @endauth
    </div>

    <!-- Auth Buttons -->
    <div style="display:flex; gap:12px; align-items:center;">
        @auth
            <span class="nav-user-name">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav-logout-btn">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="nav-login-link">Login</a>
            <a href="{{ route('register') }}" class="nav-register-btn">Register</a>
        @endauth
    </div>
</nav>