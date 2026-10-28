@extends('layouts.app')
@section('title', 'Get Approved - Congratulations!')

@section('styles')
<style>
    /* ── HERO ── */
    .approved-hero {
        background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 100%);
        padding: 80px 48px; text-align: center; position: relative; overflow: hidden;
    }
    .approved-hero::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(201,168,76,0.15) 0%, transparent 65%);
        animation: pulse 3s ease-in-out infinite;
    }
    @keyframes pulse { 0%,100% { transform: scale(1); opacity:0.8; } 50% { transform: scale(1.1); opacity:1; } }
    .checkmark-wrap { position: relative; z-index: 2; margin-bottom: 28px; }
    .checkmark-circle {
        width: 100px; height: 100px; border-radius: 50%;
        background: linear-gradient(135deg, #c9a84c, #e2c06a);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto; font-size: 3rem;
        box-shadow: 0 0 40px rgba(201,168,76,0.4);
        animation: bounceIn 0.8s ease both;
    }
    @keyframes bounceIn {
        0% { transform: scale(0); opacity: 0; }
        60% { transform: scale(1.2); }
        100% { transform: scale(1); opacity: 1; }
    }
    .approved-hero h1 { font-family: 'Playfair Display', serif; font-size: 3rem; color: #fff; position: relative; z-index: 2; margin-bottom: 12px; }
    .approved-hero h1 span { color: #c9a84c; }
    .approved-hero p { color: rgba(255,255,255,0.7); position: relative; z-index: 2; font-size: 1.05rem; }

    /* CONFETTI PARTICLES */
    .confetti { position: absolute; width: 10px; height: 10px; border-radius: 2px; animation: confettiFall linear infinite; }
    @keyframes confettiFall {
        0% { transform: translateY(-20px) rotate(0deg); opacity: 1; }
        100% { transform: translateY(400px) rotate(360deg); opacity: 0; }
    }

    /* ── MAIN SECTION ── */
    .approved-section {
        background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%);
        padding: 60px 48px 90px; position: relative; overflow: hidden;
    }
    .approved-section::before {
        content: ''; position: absolute;
        width: 500px; height: 500px; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 70%);
        top: -150px; right: -100px; pointer-events: none;
        animation: floatOrb 8s ease-in-out infinite alternate;
    }
    @keyframes floatOrb { 0% { transform:translateY(0); } 100% { transform:translateY(40px); } }

    /* USER WELCOME CARD */
    .user-welcome-card {
        background: rgba(255,255,255,0.06); border: 1px solid rgba(201,168,76,0.25);
        border-radius: 20px; padding: 32px 40px;
        max-width: 800px; margin: 0 auto 32px; position: relative; z-index: 2;
        display: flex; align-items: center; gap: 24px;
        box-shadow: 0 8px 40px rgba(0,0,0,0.25);
        transition: box-shadow 0.3s, transform 0.3s;
    }
    .user-welcome-card:hover { box-shadow: 0 16px 48px rgba(0,0,0,0.35); transform: translateY(-3px); }
    .user-avatar {
        width: 70px; height: 70px; border-radius: 50%;
        background: linear-gradient(135deg, #c9a84c, #e2c06a);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; font-weight: 900; color: #0a1628;
        flex-shrink: 0; transition: transform 0.3s;
    }
    .user-welcome-card:hover .user-avatar { transform: scale(1.1) rotate(-6deg); }
    .user-welcome-card h3 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.4rem; margin-bottom: 4px; }
    .user-welcome-card p { color: rgba(255,255,255,0.6); font-size: 0.9rem; margin: 0; }
    .user-welcome-card .status-badge {
        background: rgba(201,168,76,0.15); border: 1px solid #c9a84c;
        color: #c9a84c; padding: 6px 16px; border-radius: 100px;
        font-size: 0.78rem; font-weight: 700; margin-top: 8px;
        display: inline-block;
    }

    /* STEPS COMPLETED */
    .steps-completed { max-width: 800px; margin: 0 auto 32px; position: relative; z-index: 2; }
    .steps-completed h3 { font-family: 'Playfair Display', serif; font-size: 1.3rem; color: #fff; margin-bottom: 20px; text-align: center; }
    .completed-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; }
    .completed-step {
        background: rgba(255,255,255,0.05); border-radius: 14px; padding: 20px 16px;
        text-align: center; border: 1.5px solid rgba(255,255,255,0.1);
        transition: transform 0.25s, border-color 0.25s, background 0.25s, box-shadow 0.25s;
        position: relative; overflow: hidden;
    }
    .completed-step::before {
        content: ''; position: absolute; top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(201,168,76,0.07) 50%, transparent 70%);
        transform: translateX(-100%); transition: transform 0.5s ease;
    }
    .completed-step:hover { transform: translateY(-6px); border-color: rgba(201,168,76,0.4); box-shadow: 0 12px 32px rgba(0,0,0,0.25); }
    .completed-step:hover::before { transform: translateX(100%); }
    .completed-step.done { border-color: rgba(201,168,76,0.35); background: linear-gradient(135deg, rgba(201,168,76,0.08), rgba(255,255,255,0.04)); }
    .c-icon { font-size: 1.6rem; margin-bottom: 8px; display: block; transition: transform 0.3s; }
    .completed-step:hover .c-icon { transform: scale(1.2) rotate(-6deg); }
    .c-num {
        width: 28px; height: 28px; border-radius: 50%;
        background: #c9a84c; color: #0a1628;
        font-size: 0.82rem; font-weight: 900;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 8px;
    }
    .completed-step h4 { font-size: 0.88rem; color: #fff; font-weight: 700; margin-bottom: 4px; }
    .completed-step p { font-size: 0.75rem; color: rgba(255,255,255,0.5); margin: 0; }
    .check-mark { color: #4ade80; font-size: 0.85rem; margin-top: 6px; display: block; font-weight: 600; }
    .check-mark.progress { color: #ffbf00; }

    /* MAIN APPROVED CARD */
    .approved-card {
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);
        border-radius: 20px;
        box-shadow: 0 24px 60px rgba(0,0,0,0.3);
        max-width: 800px; margin: 0 auto 32px; position: relative; z-index: 2;
        overflow: hidden; transition: box-shadow 0.3s;
    }
    .approved-card:hover { box-shadow: 0 32px 72px rgba(0,0,0,0.4); }
    .approved-card-header {
        background: linear-gradient(135deg, #c9a84c, #e2c06a);
        padding: 28px 40px; text-align: center;
    }
    .approved-card-header h2 { font-family: 'Playfair Display', serif; color: #0a1628; font-size: 1.8rem; margin-bottom: 6px; }
    .approved-card-header p { color: rgba(10,22,40,0.7); font-size: 0.9rem; }

    .approved-card-body { padding: 40px; }
    .approved-card-body h3 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.2rem; margin: 0 0 16px; }
    .approved-card-body p { color: rgba(255,255,255,0.6); line-height: 1.8; font-size: 0.93rem; margin-bottom: 16px; }

    .next-steps { list-style: none; padding: 0; }
    .next-steps li {
        display: flex; align-items: flex-start; gap: 14px;
        padding: 14px 12px; border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 0.92rem;
        border-radius: 10px; transition: background 0.2s, transform 0.2s;
    }
    .next-steps li:hover { background: rgba(201,168,76,0.08); transform: translateX(4px); }
    .next-steps li:last-child { border-bottom: none; }
    .ns-icon { font-size: 1.2rem; flex-shrink: 0; margin-top: 2px; }
    .ns-text strong { color: #fff; display: block; font-size: 0.92rem; margin-bottom: 2px; }
    .ns-text span { color: rgba(255,255,255,0.55); font-size: 0.85rem; }

    /* ACTION BUTTONS */
    .action-btns { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 28px; }
    .action-btn {
        padding: 14px 20px; border-radius: 12px;
        font-weight: 700; font-size: 0.92rem; text-decoration: none;
        text-align: center; transition: transform 0.25s, box-shadow 0.25s;
        display: block;
    }
    .btn-primary-gold { background: linear-gradient(135deg, #c9a84c, #e2c06a); color: #0a1628; box-shadow: 0 6px 20px rgba(201,168,76,0.3); }
    .btn-primary-gold:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(201,168,76,0.45); color: #0a1628; }
    .btn-outline-dark { background: rgba(255,255,255,0.05); color: #fff; border: 2px solid rgba(255,255,255,0.2); }
    .btn-outline-dark:hover { background: rgba(201,168,76,0.12); border-color: #c9a84c; color: #c9a84c; transform: translateY(-3px); }

    /* TIMELINE */
    .timeline { max-width: 800px; margin: 0 auto; position: relative; z-index: 2; }
    .timeline h3 { font-family: 'Playfair Display', serif; font-size: 1.3rem; color: #fff; margin-bottom: 20px; text-align: center; }
    .timeline-item { display: flex; gap: 20px; margin-bottom: 20px; }
    .timeline-dot {
        width: 14px; height: 14px; border-radius: 50%;
        background: #c9a84c; flex-shrink: 0; margin-top: 4px;
        position: relative; box-shadow: 0 0 12px rgba(201,168,76,0.5);
    }
    .timeline-dot::after {
        content: ''; position: absolute; top: 14px; left: 50%;
        transform: translateX(-50%); width: 2px; height: calc(100% + 20px);
        background: rgba(255,255,255,0.15);
    }
    .timeline-item:last-child .timeline-dot::after { display: none; }
    .timeline-content {
        background: rgba(255,255,255,0.05); border-radius: 12px; padding: 16px 20px; flex: 1;
        border: 1.5px solid rgba(255,255,255,0.1);
        transition: background 0.25s, border-color 0.25s, transform 0.25s;
    }
    .timeline-content:hover { background: rgba(201,168,76,0.08); border-color: rgba(201,168,76,0.35); transform: translateX(4px); }
    .timeline-content h4 { color: #fff; font-size: 0.92rem; font-weight: 700; margin-bottom: 4px; }
    .timeline-content p { color: rgba(255,255,255,0.55); font-size: 0.83rem; margin: 0; }
    .timeline-content .time-badge { font-size: 0.72rem; color: #c9a84c; font-weight: 700; }

    .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    @media(max-width: 768px) {
        .approved-section { padding: 40px 20px 60px; }
        .completed-grid { grid-template-columns: repeat(2,1fr); }
        .action-btns { grid-template-columns: 1fr; }
        .user-welcome-card { flex-direction: column; text-align: center; padding: 24px; }
        .approved-card-body { padding: 24px; }
        .approved-hero h1 { font-size: 2.2rem; }
    }
</style>
@endsection

@section('content')

<!-- HERO -->
<div class="approved-hero">
    <!-- Confetti -->
    <div class="confetti" style="left:10%; background:#c9a84c; animation-duration:3s; animation-delay:0s;"></div>
    <div class="confetti" style="left:25%; background:#fff; animation-duration:2.5s; animation-delay:0.5s;"></div>
    <div class="confetti" style="left:50%; background:#c9a84c; animation-duration:3.5s; animation-delay:1s;"></div>
    <div class="confetti" style="left:75%; background:#fff; animation-duration:2s; animation-delay:0.3s;"></div>
    <div class="confetti" style="left:90%; background:#c9a84c; animation-duration:3s; animation-delay:0.8s;"></div>

    <div class="checkmark-wrap">
        <div class="checkmark-circle">✓</div>
    </div>
    <h1>🎉 <span>Congratulations!</span></h1>
    <p>Your visa application has been successfully submitted to VisaGo!</p>
</div>

<div class="approved-section">

    <!-- USER WELCOME -->
    <div class="user-welcome-card reveal">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div>
            <h3>Welcome, {{ Auth::user()->name }}! 🌟</h3>
            <p>Your application is now under review by our expert visa consultants.</p>
            <span class="status-badge">✅ Application Submitted Successfully</span>
        </div>
    </div>

    <!-- STEPS COMPLETED -->
    <div class="steps-completed reveal">
        <h3>Your Application Journey</h3>
        <div class="completed-grid">
            <div class="completed-step done">
                <div class="c-num">1</div>
                <span class="c-icon">🌍</span>
                <h4>Choose Visa</h4>
                <p>Visa type selected</p>
                <span class="check-mark">✓ Completed</span>
            </div>
            <div class="completed-step done">
                <div class="c-num">2</div>
                <span class="c-icon">📝</span>
                <h4>Fill Form</h4>
                <p>Application submitted</p>
                <span class="check-mark">✓ Completed</span>
            </div>
            <div class="completed-step done">
                <div class="c-num">3</div>
                <span class="c-icon">📁</span>
                <h4>Upload Docs</h4>
                <p>Documents received</p>
                <span class="check-mark">✓ Completed</span>
            </div>
            <div class="completed-step done">
                <div class="c-num">4</div>
                <span class="c-icon">🎉</span>
                <h4>Get Approved</h4>
                <p>Under processing</p>
                <span class="check-mark progress">⏳ In Progress</span>
            </div>
        </div>
    </div>

    <!-- MAIN CARD -->
    <div class="approved-card reveal">
        <div class="approved-card-header">
            <h2>🎊 Application Successfully Received!</h2>
            <p>Our team is now working on your visa application</p>
        </div>
        <div class="approved-card-body">
            <h3>What Happens Next?</h3>
            <p>Congratulations on completing your visa application with VisaGo! Your application has been received and is now being reviewed by our expert visa consultants. Here is what you can expect:</p>

            <ul class="next-steps">
                <li>
                    <span class="ns-icon">📧</span>
                    <div class="ns-text">
                        <strong>Confirmation Email Sent</strong>
                        <span>A confirmation email has been sent to {{ Auth::user()->email }} with your application reference number.</span>
                    </div>
                </li>
                <li>
                    <span class="ns-icon">👨‍💼</span>
                    <div class="ns-text">
                        <strong>Expert Review</strong>
                        <span>Our visa experts will review your application and documents within 24 hours.</span>
                    </div>
                </li>
                <li>
                    <span class="ns-icon">📋</span>
                    <div class="ns-text">
                        <strong>Embassy Submission</strong>
                        <span>Once verified, your application will be submitted to the relevant embassy or consulate.</span>
                    </div>
                </li>
                <li>
                    <span class="ns-icon">📱</span>
                    <div class="ns-text">
                        <strong>Status Updates</strong>
                        <span>You will receive regular SMS and email updates about your application status.</span>
                    </div>
                </li>
                <li>
                    <span class="ns-icon">✈️</span>
                    <div class="ns-text">
                        <strong>Visa Delivery</strong>
                        <span>Upon approval, your visa will be sent directly to your email address. Get ready to travel!</span>
                    </div>
                </li>
            </ul>

            <div class="action-btns">
                <a href="{{ url('/dashboard') }}" class="action-btn btn-primary-gold">📊 Track Application</a>
                <a href="{{ url('/') }}" class="action-btn btn-outline-dark">🏠 Go to Home</a>
            </div>
        </div>
    </div>

    <!-- TIMELINE -->
    <div class="timeline reveal">
        <h3>⏱ Expected Processing Timeline</h3>
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <span class="time-badge">Day 1</span>
                <h4>Application Received ✓</h4>
                <p>Your application and documents have been successfully received by VisaGo.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <span class="time-badge">Day 1-2</span>
                <h4>Expert Review</h4>
                <p>Our visa consultants review your application for completeness and accuracy.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <span class="time-badge">Day 2-3</span>
                <h4>Embassy Submission</h4>
                <p>Your application is submitted to the relevant embassy or visa authority.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <span class="time-badge">Day 3-15</span>
                <h4>Embassy Processing</h4>
                <p>Embassy reviews your application. Processing time varies by country and visa type.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <span class="time-badge">Final Day</span>
                <h4>🎉 Visa Approved & Delivered</h4>
                <p>Your approved visa is sent to your registered email. Time to pack your bags!</p>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endsection