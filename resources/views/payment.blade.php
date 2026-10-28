@extends('layouts.app')
@section('title', 'Payment')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* ── PAGE HERO ── */
    .page-hero {
        background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 100%);
        padding: 60px 48px; text-align: center; position: relative; overflow: hidden;
        min-height: 240px; display: flex; align-items: center; justify-content: center;
    }
    .page-hero::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(201,168,76,0.12) 0%, transparent 65%);
        animation: heroPulse 4s ease-in-out infinite;
    }
    @keyframes heroPulse { 0%,100% { transform:scale(1); opacity:0.8; } 50% { transform:scale(1.1); opacity:1; } }
    .page-hero-inner { position: relative; z-index: 2; animation: fadeUp 0.9s ease both; }
    .page-hero h1 { font-family: 'Playfair Display', serif; font-size: 2.6rem; color: #fff; margin-bottom: 10px; }
    .page-hero h1 span { color: #c9a84c; }
    .page-hero p { color: rgba(255,255,255,0.65); font-size: 0.98rem; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }
    .hero-particles span {
        position: absolute; border-radius: 50%;
        background: rgba(201,168,76,0.15); animation: floatDot linear infinite;
    }
    @keyframes floatDot { 0% { transform:translateY(0) scale(1); opacity:0.7; } 100% { transform:translateY(-100px) scale(0.5); opacity:0; } }

    /* ── MAIN SECTION ── */
    .payment-section {
        background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%);
        padding: 60px 48px 90px; position: relative; overflow: hidden;
    }
    .payment-section::before {
        content: ''; position: absolute;
        width: 500px; height: 500px; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 70%);
        top: -150px; right: -100px; pointer-events: none;
        animation: floatOrb 8s ease-in-out infinite alternate;
    }
    @keyframes floatOrb { 0% { transform:translateY(0); } 100% { transform:translateY(40px); } }

    /* PROGRESS BAR */
    .progress-wrap { max-width: 680px; margin: 0 auto 40px; position: relative; z-index: 2; }
    .progress-track { display: flex; justify-content: space-between; position: relative; }
    .progress-line-bg { position: absolute; top: 21px; left: 0; right: 0; height: 3px; background: rgba(255,255,255,0.12); z-index: 0; }
    .progress-line-fill { position: absolute; top: 21px; left: 0; height: 3px; background: linear-gradient(90deg, #c9a84c, #e2c06a); z-index: 1; width: 100%; }
    .progress-step { text-align: center; position: relative; z-index: 2; }
    .progress-circle {
        width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-weight: 800; margin: 0 auto 8px; border: 3px solid; transition: transform 0.3s;
    }
    .progress-circle.done { background: #c9a84c; border-color: #c9a84c; color: #0a1628; }
    .progress-circle.current { background: #0a1628; border-color: #c9a84c; color: #c9a84c; }
    .progress-label { font-size: 0.75rem; color: rgba(255,255,255,0.7); font-weight: 600; }

    /* ── PAYMENT CARD ── */
    .payment-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 24px; overflow: hidden;
        max-width: 680px; margin: 0 auto;
        box-shadow: 0 24px 60px rgba(0,0,0,0.3);
        transition: box-shadow 0.3s; position: relative; z-index: 2;
    }
    .payment-card:hover { box-shadow: 0 32px 72px rgba(0,0,0,0.4); }

    .payment-header {
        background: linear-gradient(135deg, rgba(201,168,76,0.15), rgba(201,168,76,0.05));
        border-bottom: 1px solid rgba(201,168,76,0.2);
        padding: 28px 36px;
    }
    .payment-header h2 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.4rem; margin-bottom: 4px; }
    .payment-header p { color: rgba(255,255,255,0.6); font-size: 0.88rem; }

    .payment-body { padding: 36px; }

    /* ORDER SUMMARY */
    .order-summary {
        background: rgba(201,168,76,0.08); border: 1.5px solid rgba(201,168,76,0.3);
        border-radius: 14px; padding: 20px 24px; margin-bottom: 28px;
    }
    .order-summary h4 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1rem; margin-bottom: 14px; }
    .order-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 0.88rem; }
    .order-row:last-child { border-bottom: none; }
    .order-row .olabel { color: rgba(255,255,255,0.6); }
    .order-row .ovalue { color: #fff; font-weight: 600; }
    .order-row.total .olabel { color: #fff; font-weight: 700; font-size: 0.95rem; }
    .order-row.total .ovalue { color: #c9a84c; font-size: 1.15rem; font-weight: 800; }

    /* PAYMENT METHODS */
    .payment-methods { margin-bottom: 24px; }
    .payment-methods h4 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1rem; margin-bottom: 14px; }
    .method-options { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .method-btn {
        border: 1.5px solid rgba(255,255,255,0.15); border-radius: 14px;
        padding: 20px 14px; text-align: center; cursor: pointer;
        transition: border-color 0.25s, background 0.25s, transform 0.25s, box-shadow 0.25s;
        font-size: 0.9rem; color: #fff; font-weight: 700;
        background: rgba(255,255,255,0.04);
    }
    .method-btn .method-icon { font-size: 2rem; display: block; margin-bottom: 8px; transition: transform 0.3s; }
    .method-btn:hover { border-color: #c9a84c; background: rgba(201,168,76,0.1); transform: translateY(-3px); }
    .method-btn:hover .method-icon { transform: scale(1.15) rotate(-6deg); }
    .method-btn.active { border-color: #c9a84c; background: rgba(201,168,76,0.15); box-shadow: 0 8px 24px rgba(201,168,76,0.25); }

    /* NUMBER DISPLAY BOX */
    .send-to-box {
        background: rgba(255,255,255,0.05); border: 1.5px dashed rgba(201,168,76,0.4);
        border-radius: 14px; padding: 20px 24px; margin-bottom: 24px; text-align: center;
        animation: fadeUp 0.4s ease;
    }
    .send-to-box .stb-label { font-size: 0.75rem; color: rgba(255,255,255,0.55); letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 8px; }
    .send-to-box .stb-number { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: #c9a84c; font-weight: 800; letter-spacing: 1px; }
    .send-to-box .stb-note { font-size: 0.8rem; color: rgba(255,255,255,0.5); margin-top: 8px; }
    .copy-btn {
        display: inline-flex; align-items: center; gap: 6px; margin-top: 10px;
        background: rgba(201,168,76,0.12); border: 1px solid rgba(201,168,76,0.35);
        color: #c9a84c; padding: 6px 16px; border-radius: 100px; font-size: 0.78rem;
        font-weight: 700; cursor: pointer; transition: background 0.2s, transform 0.2s;
    }
    .copy-btn:hover { background: rgba(201,168,76,0.22); transform: translateY(-1px); }

    /* FORM */
    .form-group { margin-bottom: 20px; transition: transform 0.2s; }
    .form-group label {
        display: block; font-size: 0.78rem; color: rgba(255,255,255,0.6);
        letter-spacing: 1.2px; text-transform: uppercase; margin-bottom: 9px; font-weight: 600;
        transition: color 0.3s;
    }
    .form-group input {
        width: 100%; padding: 14px 16px; height: 50px;
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);
        border-radius: 12px; color: #fff; font-size: 0.92rem;
        outline: none; transition: border-color 0.3s, background 0.3s, box-shadow 0.3s;
        box-sizing: border-box;
    }
    .form-group input::placeholder { color: rgba(255,255,255,0.3); }
    .form-group input:hover { border-color: rgba(201,168,76,0.4); background: rgba(255,255,255,0.09); }
    .form-group input:focus { border-color: #c9a84c; background: rgba(255,255,255,0.1); box-shadow: 0 0 0 3px rgba(201,168,76,0.15); }

    /* ✅ FILLED STATE */
    .form-group.is-filled label { color: #4ade80; }
    .form-group.is-filled input {
        border-color: #4ade80 !important;
        background: rgba(74, 222, 128, 0.08) !important;
        box-shadow: 0 0 0 3px rgba(74, 222, 128, 0.12) !important;
    }

    .error-msg { color: #ff6b6b; font-size: 0.78rem; margin-top: 6px; }

    .secure-badge {
        display: flex; align-items: center; gap: 10px;
        background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px; padding: 12px 16px;
        margin-bottom: 22px; font-size: 0.82rem; color: rgba(255,255,255,0.6);
    }

    .pay-btn {
        width: 100%; padding: 17px;
        background: linear-gradient(135deg, #c9a84c, #e2c06a);
        color: #0a1628; border: none; border-radius: 12px;
        font-size: 1.05rem; font-weight: 800; cursor: pointer;
        letter-spacing: 0.5px; text-transform: uppercase;
        transition: transform 0.25s, box-shadow 0.25s;
        box-shadow: 0 6px 20px rgba(201,168,76,0.3);
        display: block; text-align: center; text-decoration: none;
    }
    .pay-btn:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(201,168,76,0.45); color: #0a1628; }
    .pay-btn:active { transform: translateY(-1px); }

    .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    @media(max-width: 600px) {
        .payment-section { padding: 40px 20px 60px; }
        .payment-body { padding: 24px; }
        .method-options { grid-template-columns: 1fr; }
        .page-hero { padding: 40px 24px; min-height: 200px; }
        .page-hero h1 { font-size: 2rem; }
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
    </div>
    <div class="page-hero-inner">
        <h1>Secure <span>Payment</span></h1>
        <p>Complete your payment to finalize your visa application.</p>
    </div>
</div>

<div class="payment-section">

    <!-- PROGRESS BAR -->
    <div class="progress-wrap reveal">
        <div class="progress-track">
            <div class="progress-line-bg"></div>
            <div class="progress-line-fill"></div>
            <div class="progress-step">
                <div class="progress-circle done">✓</div>
                <span class="progress-label">Choose Visa</span>
            </div>
            <div class="progress-step">
                <div class="progress-circle done">✓</div>
                <span class="progress-label">Fill Form</span>
            </div>
            <div class="progress-step">
                <div class="progress-circle done">✓</div>
                <span class="progress-label">Upload Docs</span>
            </div>
            <div class="progress-step">
                <div class="progress-circle current">4</div>
                <span class="progress-label">Payment</span>
            </div>
        </div>
    </div>

    <div class="payment-card reveal">
        <div class="payment-header">
            <h2>💳 Complete Payment</h2>
            <p>Your application is ready. Complete payment to submit for processing.</p>
        </div>
        <div class="payment-body">

            <!-- ORDER SUMMARY -->
            <div class="order-summary">
                <h4>📋 Order Summary</h4>
                <div class="order-row">
                    <span class="olabel">Visa Application Fee</span>
                    <span class="ovalue">PKR 15,000</span>
                </div>
                <div class="order-row">
                    <span class="olabel">VisaGo Service Fee</span>
                    <span class="ovalue">PKR 2,500</span>
                </div>
                <div class="order-row">
                    <span class="olabel">Processing Fee</span>
                    <span class="ovalue">PKR 500</span>
                </div>
                <div class="order-row total">
                    <span class="olabel">💰 Total Amount</span>
                    <span class="ovalue">PKR 18,000</span>
                </div>
            </div>

            <form method="POST" action="{{ route('payment.submit') }}" id="paymentForm">
                @csrf

                <!-- PAYMENT METHODS -->
                <div class="payment-methods">
                    <h4>💳 Select Payment Method</h4>
                    <div class="method-options">
                        <div class="method-btn" id="btn-easypaisa" onclick="selectMethod('easypaisa')">
                            <span class="method-icon">📱</span>
                            EasyPaisa
                        </div>
                        <div class="method-btn" id="btn-jazzcash" onclick="selectMethod('jazzcash')">
                            <span class="method-icon">🏦</span>
                            JazzCash
                        </div>
                    </div>
                    <input type="hidden" name="method" id="methodInput" value="{{ old('method') }}">
                    @error('method') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <!-- SEND TO NUMBER -->
                <div class="send-to-box" id="sendToBox" style="display:none;">
                    <div class="stb-label">Send Payment To This Number</div>
                    <div class="stb-number" id="sendToNumber">+92 342 8480072</div>
                    <div class="stb-note" id="sendToMethodName">via EasyPaisa</div>
                    <button type="button" class="copy-btn" onclick="copyNumber()">📋 Copy Number</button>
                </div>

                <div class="secure-badge">
                    <span>🔒</span>
                    <span>Send the exact amount (PKR 18,000) using the app above, then enter your transaction details below to confirm.</span>
                </div>

                <div class="form-group">
                    <label>Your Sender Number</label>
                    <input type="text" name="sender_number" id="senderNumber" placeholder="03XX XXXXXXX" value="{{ old('sender_number') }}"/>
                    @error('sender_number') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Transaction ID</label>
                    <input type="text" name="transaction_id" id="transactionId" placeholder="e.g. TXN123456789" value="{{ old('transaction_id') }}"/>
                    @error('transaction_id') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="pay-btn">🔒 SUBMIT PAYMENT PROOF & CONTINUE</button>
            </form>

        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
let selectedMethod = '{{ old('method') }}';
const numbers = {
    easypaisa: { number: '+92 342 8480072', label: 'via EasyPaisa' },
    jazzcash:  { number: '+92 342 8480072', label: 'via JazzCash' },
};

function selectMethod(method) {
    selectedMethod = method;
    document.getElementById('methodInput').value = method;
    document.querySelectorAll('.method-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('btn-' + method).classList.add('active');

    document.getElementById('sendToNumber').textContent = numbers[method].number;
    document.getElementById('sendToMethodName').textContent = numbers[method].label;
    document.getElementById('sendToBox').style.display = 'block';
}

// Restore old selection after validation error
if (selectedMethod) selectMethod(selectedMethod);

function copyNumber() {
    const number = document.getElementById('sendToNumber').textContent;
    navigator.clipboard.writeText(number.replace(/\s/g, ''));
    if (typeof Swal !== 'undefined') {
        Swal.fire({ toast:true, position:'top', icon:'success', title:'Number copied!', showConfirmButton:false, timer:1500, background:'#1d2e49', color:'#fff' });
    }
}

// FILLED STATE for inputs
document.querySelectorAll('#paymentForm input[type="text"]').forEach(el => {
    function refresh() {
        const group = el.closest('.form-group');
        if (!group) return;
        if (el.value && el.value.trim() !== '') group.classList.add('is-filled');
        else group.classList.remove('is-filled');
    }
    refresh();
    el.addEventListener('input', refresh);
    el.addEventListener('focus', function() { this.closest('.form-group').style.transform = 'scale(1.01)'; });
    el.addEventListener('blur', function() { this.closest('.form-group').style.transform = 'scale(1)'; });
});

// VALIDATE BEFORE SUBMIT — agar payment na kiya ho to popup
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    const method = document.getElementById('methodInput').value;
    const sender = document.getElementById('senderNumber').value.trim();
    const txn    = document.getElementById('transactionId').value.trim();

    if (!method || !sender || !txn) {
        e.preventDefault();
        const message = 'Please select a payment method and enter your sender number and transaction ID before submitting.';
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Payment Not Completed!',
                text: message,
                icon: 'warning',
                confirmButtonText: 'OK, I\'ll complete it',
                confirmButtonColor: '#c9a84c',
                background: '#1d2e49',
                color: '#fff'
            });
        } else {
            alert(message);
        }
    }
});

// REVEAL
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endsection