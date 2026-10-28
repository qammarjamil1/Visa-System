@extends('layouts.app')
@section('title', 'Privacy Policy')

@section('styles')
<style>
    /* PAGE HERO */
    .page-hero {
        background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 100%);
        padding: 48px 28px; text-align: center; position: relative; overflow: hidden;
    }
    .page-hero::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(255,191,0,0.1) 0%, transparent 65%);
        animation: pulse 4s ease-in-out infinite;
    }
    @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.1); } }
    .page-hero h1 { font-family: 'Playfair Display', serif; font-size: 2.8rem; color: #fff; position: relative; z-index: 2; }
    .page-hero h1 span { color: #ffbf00; }
    .page-hero p { color: rgb(255, 255, 255); margin-top: 12px; position: relative; z-index: 2; font-size: 0.95rem; }
    .page-hero .last-updated { color: rgb(255, 255, 255); font-size: 0.82rem; margin-top: 8px; position: relative; z-index: 2; }

    /* MAIN */
    .policy-section { background: #2b405e; padding: 60px 38px 80px; }

    /* TRUST BADGES */
    .trust-bar {
        display: flex; justify-content: center; gap: 24px; flex-wrap: wrap;
        max-width: 900px; margin: 0 auto 48px;
    }
    .trust-badge {
        background: #1b234e; border-radius: 12px; padding: 16px 24px;
        display: flex; align-items: center; gap: 10px;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        transition: transform 0.2s, border-color 0.2s;
    }
    .trust-badge:hover { transform: translateY(-3px); border-color: #ffbf00; }
    .trust-badge span { font-size: 1.4rem; }
    .trust-badge div p { font-size: 0.78rem; color: #ffffff; margin: 0; }
    .trust-badge div strong { font-size: 0.88rem; color: #ffffff; }

    /* POLICY CARD */
    .policy-card {  
        background: #49548f;
         border-radius: 20px;
        box-shadow: 0 8px 40px rgba(0,0,0,0.08);
        max-width: 900px; margin: 0 auto;
        overflow: hidden;
    }
    .policy-nav {
        background: linear-gradient(135deg, #0a1628, #1a3a5c);
        padding: 24px 36px;
        display: flex; gap: 12px; flex-wrap: wrap;
    }
    .policy-nav a {
        color: rgb(255, 255, 255); text-decoration: none;
        font-size: 0.82rem; padding: 6px 14px;
        border-radius: 100px; border: 1px solid rgba(255,255,255,0.15);
        transition: all 0.2s;
    }
    .policy-nav a:hover { color: #ffbf00; border-color: #ffbf00; background: rgba(255,191,0,0.1); }

    .policy-body { padding: 48px; }

    /* SECTIONS */
    .policy-block { margin-bottom: 48px; padding-bottom: 48px; border-bottom: 1px solid #f0f0f0; }
    .policy-block:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }

    .policy-block h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem; color: #ffbf00;
        margin-bottom: 16px;
        display: flex; align-items: center; gap: 10px;
    }
    .policy-block h2 span { font-size: 1.3rem; }
    .policy-block p { color: #ffffff; line-height: 1.8; margin-bottom: 14px; font-size: 0.93rem; }
    .policy-block ul { padding-left: 0; list-style: none; }
    .policy-block ul li {
        color: #ffffff; font-size: 0.93rem; line-height: 1.7;
        padding: 8px 0 8px 24px; position: relative;
        border-bottom: 1px solid #f8f8f8;
    }
    .policy-block ul li::before {
        content: '✓'; position: absolute; left: 0;
        color: #c9a84c; font-weight: 700;
    }

    /* HIGHLIGHT BOX */
    .highlight-box {
        background: linear-gradient(135deg, #684e00, #070604);
        border: 1.5px solid #ffbf00;
        border-radius: 12px; padding: 20px 24px;
        margin: 20px 0;
    }
    .highlight-box h4 { color: #ffde83; font-size: 0.95rem; font-weight: 700; margin-bottom: 8px; }
    .highlight-box p { color: #ffffff; font-size: 0.88rem; margin: 0; line-height: 1.6; }

    /* ANTI-FRAUD BOX */
    .fraud-box {
        background: linear-gradient(135deg, #0a1628, #1a3a5c);
        border-radius: 16px; padding: 32px;
        margin: 24px 0; text-align: center;
    }
    .fraud-box h3 { font-family: 'Playfair Display', serif; color: #ffbf00; font-size: 1.4rem; margin-bottom: 12px; }
    .fraud-box p { color: rgb(255, 255, 255); font-size: 0.9rem; line-height: 1.7; margin-bottom: 0; }
    .fraud-box .fraud-points {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 12px; margin-top: 20px; text-align: left;
    }
    .fraud-point {
        background: rgba(255,255,255,0.07);
        border-radius: 10px; padding: 14px 16px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .fraud-point strong { color: #ffbf00; font-size: 0.88rem; display: block; margin-bottom: 4px; }
    .fraud-point span { color: rgba(255,255,255,0.6); font-size: 0.82rem; line-height: 1.5; }

    /* CONTACT BOX */
    .contact-policy-box {
        background: linear-gradient(135deg, #684e00, #070604); border-radius: 14px;
        padding: 28px; text-align: center; margin-top: 20px;
    }
    .contact-policy-box h4 { font-family: 'Playfair Display', serif; color: #ffbf00; margin-bottom: 8px; }
    .contact-policy-box p { color: #ffffff; font-size: 0.88rem; margin-bottom: 16px; }
    .contact-policy-box a {
        background: #0a1628; color: #ffbf00;
        padding: 10px 28px; border-radius: 100px;
        text-decoration: none; font-weight: 600; font-size: 0.88rem;
        transition: background 0.2s, transform 0.2s;
        display: inline-block;
    }
    .contact-policy-box a:hover { background: #ffbf00; color: #0a1628; transform: translateY(-2px); }

   .reveal {
    opacity: 1;
    transform: none;
}

    @media(max-width: 768px) {
        .policy-section { padding: 40px 20px; }
        .policy-body { padding: 28px 20px; }
        .fraud-box .fraud-points { grid-template-columns: 1fr; }
        .trust-bar { gap: 12px; }
    }
</style>
@endsection

@section('content')

<!-- PAGE HERO -->
<div class="page-hero">
    <h1>🔒 Privacy <span>Policy</span></h1>
    <p>Your privacy and security are our top priority at VisaGo.</p>
    <p class="last-updated">Last Updated: June 2026</p>
</div>

<div class="policy-section">

    <!-- TRUST BADGES -->
    <div class="trust-bar reveal">
        <div class="trust-badge">
            <span>🔒</span>
            <div><strong>SSL Secured</strong><p>256-bit encryption</p></div>
        </div>
        <div class="trust-badge">
            <span>✅</span>
            <div><strong>Verified Agency</strong><p>Officially registered</p></div>
        </div>
        <div class="trust-badge">
            <span>🛡️</span>
            <div><strong>No Fraud</strong><p>100% legitimate service</p></div>
        </div>
        <div class="trust-badge">
            <span>🌍</span>
            <div><strong>120+ Countries</strong><p>Trusted worldwide</p></div>
        </div>
        <div class="trust-badge">
            <span>💳</span>
            <div><strong>Secure Payments</strong><p>Bank-level security</p></div>
        </div>
    </div>

    <div class="policy-card reveal">

        <!-- NAV -->
        <div class="policy-nav">
            <a href="#info">Information We Collect</a>
            <a href="#use">How We Use It</a>
            <a href="#security">Data Security</a>
            <a href="#antifraud">Anti-Fraud Policy</a>
            <a href="#rights">Your Rights</a>
            <a href="#cookies">Cookies</a>
            <a href="#contact">Contact Us</a>
        </div>

        <div class="policy-body">

            <!-- INTRO -->
            <div class="policy-block reveal" id="intro">
                <h2><span>📋</span> Introduction</h2>
                <p>Welcome to VisaGo ("we", "our", "us"). We are a fully registered and legitimate visa consultancy service operating since 2010. This Privacy Policy explains how we collect, use, protect, and handle your personal information when you use our visa application services.</p>
                <p>By using VisaGo, you agree to the collection and use of information in accordance with this policy. We are committed to protecting your privacy and ensuring complete transparency in how we handle your data.</p>
                <div class="highlight-box">
                    <h4>🌟 Our Promise to You</h4>
                    <p>VisaGo is a 100% legitimate, fraud-free visa consultancy. We have successfully processed over 7,500 visa applications with a 98% approval rate. Your trust is our most valuable asset and we will never compromise it.</p>
                </div>
            </div>

            <!-- ANTI-FRAUD SECTION -->
            <div class="policy-block reveal" id="antifraud">
                <h2><span>🛡️</span> Anti-Fraud & Scam Protection Policy</h2>
                <p>We understand that the visa industry has many fraudulent actors. VisaGo is committed to being completely transparent and legitimate in all our operations.</p>

                <div class="fraud-box">
                    <h3>🚫 VisaGo is 100% Scam-Free</h3>
                    <p>We guarantee that VisaGo is a completely legitimate visa consultancy service. We have zero tolerance for fraud and operate with full transparency.</p>
                    <div class="fraud-points">
                        <div class="fraud-point">
                            <strong>✅ No Hidden Fees</strong>
                            <span>All fees are clearly shown upfront before you apply. No surprise charges ever.</span>
                        </div>
                        <div class="fraud-point">
                            <strong>✅ No Fake Guarantees</strong>
                            <span>We never guarantee 100% visa approval as decisions are made by embassies.</span>
                        </div>
                        <div class="fraud-point">
                            <strong>✅ Real Documents Only</strong>
                            <span>We only process genuine visa applications. We never provide fake documents.</span>
                        </div>
                        <div class="fraud-point">
                            <strong>✅ Verified Consultants</strong>
                            <span>All our visa consultants are trained, certified, and officially registered.</span>
                        </div>
                        <div class="fraud-point">
                            <strong>✅ Secure Payments</strong>
                            <span>All payments go through secure, verified channels. No cash transfers to individuals.</span>
                        </div>
                        <div class="fraud-point">
                            <strong>✅ Refund Policy</strong>
                            <span>Clear refund policy in case of visa rejection or service issues.</span>
                        </div>
                    </div>
                </div>

                <p style="margin-top:20px;">If you ever receive a call, message, or email claiming to be from VisaGo asking for unofficial payments or offering guaranteed visas, please report it immediately to <strong>support@visago.com</strong> — it is NOT from us.</p>

                <ul>
                    <li>VisaGo will NEVER ask for cash payments to personal accounts</li>
                    <li>VisaGo will NEVER guarantee visa approval — that is the embassy's decision</li>
                    <li>VisaGo will NEVER ask for your passwords or banking PINs</li>
                    <li>VisaGo will NEVER contact you through unofficial WhatsApp numbers</li>
                    <li>VisaGo will NEVER charge you without providing an official receipt</li>
                </ul>
            </div>

            <!-- INFORMATION WE COLLECT -->
            <div class="policy-block reveal" id="info">
                <h2><span>📝</span> Information We Collect</h2>
                <p>To process your visa application, we collect the following information:</p>
                <ul>
                    <li>Full name, date of birth, and nationality</li>
                    <li>Passport number, issue date, and expiry date</li>
                    <li>Contact information (email address and phone number)</li>
                    <li>Travel history and destination country details</li>
                    <li>Employment information and financial documents (where required)</li>
                    <li>Photographs meeting visa application requirements</li>
                    <li>Payment information (processed securely — we do not store card details)</li>
                </ul>
                <div class="highlight-box">
                    <h4>🔒 Minimum Data Collection</h4>
                    <p>We only collect information that is strictly necessary for processing your visa application. We never collect unnecessary personal data.</p>
                </div>
            </div>

            <!-- HOW WE USE IT -->
            <div class="policy-block reveal" id="use">
                <h2><span>⚙️</span> How We Use Your Information</h2>
                <p>Your information is used exclusively for the following purposes:</p>
                <ul>
                    <li>Processing and submitting your visa application to the relevant embassy or consulate</li>
                    <li>Communicating with you about your application status and updates</li>
                    <li>Verifying your identity and preventing fraudulent applications</li>
                    <li>Providing customer support and resolving application issues</li>
                    <li>Sending important notifications about your visa timeline and deadlines</li>
                    <li>Improving our services based on application outcomes</li>
                </ul>
                <p>We will NEVER sell, rent, or share your personal information with third parties for marketing purposes without your explicit consent.</p>
            </div>

            <!-- DATA SECURITY -->
            <div class="policy-block reveal" id="security">
                <h2><span>🔐</span> Data Security</h2>
                <p>We implement industry-standard security measures to protect your personal information:</p>
                <ul>
                    <li>256-bit SSL encryption for all data transmission</li>
                    <li>Secure servers with regular security audits and updates</li>
                    <li>Restricted access — only authorized staff can view your application data</li>
                    <li>Payment processing through certified, PCI-DSS compliant payment gateways</li>
                    <li>Regular data backups to prevent information loss</li>
                    <li>Automatic deletion of sensitive data after application completion</li>
                    <li>Two-factor authentication for all staff accounts accessing your data</li>
                </ul>
                <div class="highlight-box">
                    <h4>💳 Payment Security</h4>
                    <p>We never store your full card details on our servers. All payments are processed through internationally certified payment gateways. You will always receive an official receipt for every payment made to VisaGo.</p>
                </div>
            </div>

            <!-- DATA SHARING -->
            <div class="policy-block reveal">
                <h2><span>🤝</span> Data Sharing</h2>
                <p>Your personal data is shared only in the following limited circumstances:</p>
                <ul>
                    <li>With the relevant embassy or consulate to process your visa application</li>
                    <li>With official government immigration authorities as required by law</li>
                    <li>With our verified document verification partners (under strict confidentiality agreements)</li>
                    <li>With law enforcement agencies if required by legal obligation</li>
                </ul>
                <p>We never share your data with advertisers, marketing companies, or any unauthorized third parties. All our partners are bound by strict confidentiality agreements.</p>
            </div>

            <!-- DATA RETENTION -->
            <div class="policy-block reveal">
                <h2><span>🗂️</span> Data Retention</h2>
                <p>We retain your personal information for the following periods:</p>
                <ul>
                    <li>Active application data: Retained until your visa is approved or rejected</li>
                    <li>Application records: Kept for 2 years for reference and re-application purposes</li>
                    <li>Payment records: Kept for 7 years as required by financial regulations</li>
                    <li>Communication records: Kept for 1 year for customer service purposes</li>
                </ul>
                <p>After these periods, your data is securely and permanently deleted from our systems.</p>
            </div>

            <!-- YOUR RIGHTS -->
            <div class="policy-block reveal" id="rights">
                <h2><span>⚖️</span> Your Rights</h2>
                <p>You have the following rights regarding your personal data:</p>
                <ul>
                    <li><strong>Right to Access:</strong> Request a copy of all personal data we hold about you</li>
                    <li><strong>Right to Correction:</strong> Request correction of any inaccurate information</li>
                    <li><strong>Right to Deletion:</strong> Request deletion of your data (subject to legal obligations)</li>
                    <li><strong>Right to Portability:</strong> Request your data in a portable electronic format</li>
                    <li><strong>Right to Object:</strong> Object to how we process your personal data</li>
                    <li><strong>Right to Withdraw Consent:</strong> Withdraw consent for data processing at any time</li>
                </ul>
                <p>To exercise any of these rights, contact us at <strong>privacy@visago.com</strong> and we will respond within 30 days.</p>
            </div>

            <!-- COOKIES -->
            <div class="policy-block reveal" id="cookies">
                <h2><span>🍪</span> Cookies Policy</h2>
                <p>We use cookies to improve your experience on our website:</p>
                <ul>
                    <li><strong>Essential Cookies:</strong> Required for the website to function properly</li>
                    <li><strong>Session Cookies:</strong> Remember your login status during your visit</li>
                    <li><strong>Preference Cookies:</strong> Remember your language and display preferences</li>
                    <li><strong>Analytics Cookies:</strong> Help us understand how visitors use our website</li>
                </ul>
                <p>You can control cookie settings through your browser. Disabling essential cookies may affect website functionality.</p>
            </div>

            <!-- VISA APPLICATION TERMS -->
            <div class="policy-block reveal">
                <h2><span>📌</span> Visa Application Terms</h2>
                <p>Important terms regarding your visa application:</p>
                <ul>
                    <li>Visa approval is solely the decision of the relevant embassy or consulate — VisaGo cannot guarantee approval</li>
                    <li>You must provide accurate and truthful information — false information may result in rejection or ban</li>
                    <li>Application fees are generally non-refundable once submitted to the embassy</li>
                    <li>VisaGo service fees may be refundable if we are unable to submit your application</li>
                    <li>Processing times are estimates — actual times depend on embassy workload</li>
                    <li>You are responsible for ensuring your documents meet embassy requirements</li>
                    <li>VisaGo is not liable for visa rejections due to incomplete or incorrect information provided by the applicant</li>
                </ul>
            </div>

            <!-- REFUND POLICY -->
            <div class="policy-block reveal">
                <h2><span>💰</span> Refund Policy</h2>
                <ul>
                    <li>VisaGo service fee is refundable if we are unable to submit your application</li>
                    <li>Embassy/government fees are non-refundable once paid to the embassy</li>
                    <li>Refund requests must be submitted within 7 days of application cancellation</li>
                    <li>Refunds are processed within 7-14 working days to your original payment method</li>
                    <li>In case of visa rejection, VisaGo service fee may be partially refunded per our support team's assessment</li>
                </ul>
                <div class="highlight-box">
                    <h4>📞 Refund Requests</h4>
                    <p>To request a refund, email us at refunds@visago.com with your application reference number. Our team will review and respond within 3 working days.</p>
                </div>
            </div>

            <!-- CHANGES TO POLICY -->
            <div class="policy-block reveal">
                <h2><span>🔄</span> Changes to This Policy</h2>
                <p>We may update this Privacy Policy from time to time. We will notify you of any significant changes by:</p>
                <ul>
                    <li>Sending an email notification to your registered email address</li>
                    <li>Displaying a prominent notice on our website</li>
                    <li>Updating the "Last Updated" date at the top of this policy</li>
                </ul>
                <p>Continued use of VisaGo after policy changes constitutes your acceptance of the updated policy.</p>
            </div>

            <!-- CONTACT -->
            <div class="policy-block reveal" id="contact">
                <h2><span>📞</span> Contact Us</h2>
                <p>If you have any questions, concerns, or requests regarding this Privacy Policy or your personal data, please contact us:</p>
                <ul>
                    <li><strong>Email:</strong> privacy@visago.com</li>
                    <li><strong>Support:</strong> support@visago.com</li>
                    <li><strong>Refunds:</strong> refunds@visago.com</li>
                    <li><strong>Report Fraud:</strong> fraud@visago.com</li>
                    <li><strong>Phone:</strong> +92 300 0000000</li>
                    <li><strong>Office Hours:</strong> Monday - Saturday, 9:00 AM - 6:00 PM PKT</li>
                </ul>

                <div class="contact-policy-box">
                    <h4>Need Help or Have a Concern?</h4>
                    <p>Our support team is available 24/7 to answer your questions about privacy, security, or your visa application.</p>
                    <a href="{{ url('/contact') }}">Contact Our Team</a>
                </div>
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