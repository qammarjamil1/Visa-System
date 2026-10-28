@extends('layouts.app')
@section('title', 'Upload Documents')

@section('styles')
<style>
    /* ── PAGE HERO ── */
    .page-hero {
        background: linear-gradient(135deg, #0a1628 0%, #0d1f3c 100%);
        padding: 60px 48px; text-align: center; position: relative; overflow: hidden;
        min-height: 240px; display: flex; flex-direction: column; align-items: center; justify-content: center;
    }
    .page-hero::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(201,168,76,0.12) 0%, transparent 65%);
        animation: heroPulse 4s ease-in-out infinite;
    }
    @keyframes heroPulse { 0%,100% { transform: scale(1); opacity:0.8; } 50% { transform: scale(1.1); opacity:1; } }
    .page-hero h1 { font-family: 'Playfair Display', serif; font-size: 2.6rem; color: #fff; position: relative; z-index: 2; }
    .page-hero h1 span { color: #c9a84c; }
    .page-hero p { color: rgba(255,255,255,0.6); margin-top: 12px; position: relative; z-index: 2; font-size: 1rem; }

    /* ── MAIN SECTION ── */
    .docs-section {
        background: linear-gradient(135deg, #1d2e49 0%, #1f3353 60%, #2d4066 100%);
        padding: 60px 48px 80px; position: relative; overflow: hidden;
    }
    .docs-section::before {
        content: ''; position: absolute;
        width: 500px; height: 500px; border-radius: 50%;
        background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 70%);
        top: -150px; right: -100px; pointer-events: none;
        animation: floatOrb 8s ease-in-out infinite alternate;
    }
    @keyframes floatOrb { 0% { transform:translateY(0); } 100% { transform:translateY(40px); } }

    /* PROGRESS BAR (STEPS) */
    .progress-wrap { max-width: 700px; margin: 0 auto 48px; position: relative; z-index: 2; }
    .progress-steps { display: flex; justify-content: space-between; position: relative; }
    .progress-steps::before {
        content: ''; position: absolute; top: 20px; left: 0; right: 0;
        height: 3px; background: rgba(255,255,255,0.12); z-index: 0;
    }
    .progress-line {
        position: absolute; top: 20px; left: 0;
        height: 3px; background: #c9a84c; z-index: 1;
        width: 66%; transition: width 0.4s ease;
    }
    .p-step { text-align: center; position: relative; z-index: 2; }
    .p-step-circle {
        width: 42px; height: 42px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.9rem; margin: 0 auto 8px;
        border: 3px solid rgba(255,255,255,0.15); background: #1d2e49; color: rgba(255,255,255,0.5);
        transition: all 0.3s;
    }
    .p-step.done .p-step-circle { background: #c9a84c; border-color: #c9a84c; color: #0a1628; }
    .p-step.active .p-step-circle { background: #fff; border-color: #c9a84c; color: #0a1628; box-shadow: 0 0 0 6px rgba(201,168,76,0.15); }
    .p-step span { font-size: 0.78rem; color: rgba(255,255,255,0.5); font-weight: 600; }
    .p-step.done span, .p-step.active span { color: #fff; }

    /* MAIN CARD */
    .docs-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 24px; overflow: hidden;
        max-width: 780px; margin: 0 auto;
        box-shadow: 0 24px 60px rgba(0,0,0,0.3);
        position: relative; z-index: 2;
        animation: cardIn 0.6s ease both;
        transition: box-shadow 0.3s;
    }
    .docs-card:hover { box-shadow: 0 32px 72px rgba(0,0,0,0.4); }
    @keyframes cardIn { from { opacity:0; transform: translateY(30px); } to { opacity:1; transform: translateY(0); } }

    .docs-header {
        background: linear-gradient(135deg, rgba(201,168,76,0.15), rgba(201,168,76,0.05));
        border-bottom: 1px solid rgba(201,168,76,0.2);
        padding: 28px 40px; position: relative; overflow: hidden;
    }
    .docs-header h2 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.4rem; margin-bottom: 6px; position: relative; z-index: 2; }
    .docs-header p { color: rgba(255,255,255,0.55); font-size: 0.88rem; position: relative; z-index: 2; }

    /* LIVE UPLOAD PROGRESS */
    .upload-progress-wrap { margin-top: 18px; position: relative; z-index: 2; }
    .upload-progress-bar {
        width: 100%; height: 8px; background: rgba(255,255,255,0.1);
        border-radius: 100px; overflow: hidden;
    }
    .upload-progress-fill {
        height: 100%; width: 0%; background: linear-gradient(90deg, #c9a84c, #e2c06a);
        border-radius: 100px; transition: width 0.4s ease;
        box-shadow: 0 0 12px rgba(201,168,76,0.6);
    }
    .upload-progress-text { color: rgba(255,255,255,0.6); font-size: 0.8rem; margin-top: 8px; font-weight: 600; }
    .upload-progress-text strong { color: #c9a84c; }

    .docs-body { padding: 40px; }

    /* DOCUMENT ITEMS */
    .doc-item {
        border: 1.5px solid rgba(255,255,255,0.12); border-radius: 14px;
        padding: 20px 24px; margin-bottom: 16px;
        background: rgba(255,255,255,0.03);
        transition: border-color 0.25s, box-shadow 0.25s, background 0.25s, transform 0.2s;
        display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
        position: relative; overflow: hidden;
        opacity: 0; transform: translateY(20px);
        animation: itemIn 0.5s ease forwards;
    }
    @keyframes itemIn { to { opacity: 1; transform: translateY(0); } }
    .doc-item:nth-child(1){ animation-delay: 0.05s; }
    .doc-item:nth-child(2){ animation-delay: 0.1s; }
    .doc-item:nth-child(3){ animation-delay: 0.15s; }
    .doc-item:nth-child(4){ animation-delay: 0.2s; }
    .doc-item:nth-child(5){ animation-delay: 0.25s; }
    .doc-item:nth-child(6){ animation-delay: 0.3s; }
    .doc-item:nth-child(7){ animation-delay: 0.35s; }
    .doc-item:nth-child(8){ animation-delay: 0.4s; }

    .doc-item:hover { border-color: rgba(201,168,76,0.4); box-shadow: 0 6px 20px rgba(201,168,76,0.12); transform: translateY(-2px); background: rgba(255,255,255,0.06); }

    .doc-item.uploaded { border-color: rgba(34,197,94,0.5); background: rgba(34,197,94,0.08); }
    .doc-item.uploaded:hover { box-shadow: 0 6px 20px rgba(34,197,94,0.15); }
    .doc-item.missing { border-color: #ff6b6b !important; background: rgba(255,107,107,0.08); }

    @keyframes shake {
        10%, 90% { transform: translateX(-3px); }
        20%, 80% { transform: translateX(5px); }
        30%, 50%, 70% { transform: translateX(-9px); }
        40%, 60% { transform: translateX(9px); }
    }
    .doc-item.shake { animation: shake 0.5s; }

    .doc-icon { font-size: 1.8rem; flex-shrink: 0; transition: transform 0.3s; }
    .doc-item:hover .doc-icon { transform: scale(1.15) rotate(-6deg); }
    .doc-info { flex: 1; min-width: 200px; }
    .doc-info h4 { color: #fff; font-size: 0.95rem; font-weight: 700; margin-bottom: 4px; }
    .doc-info p { color: rgba(255,255,255,0.5); font-size: 0.82rem; margin: 0; }
    .doc-filename {
        font-size: 0.78rem; color: #4ade80; font-weight: 700; margin-top: 6px;
        display: flex; align-items: center; gap: 6px; animation: fadeUp 0.3s ease;
    }
    @keyframes fadeUp { from { opacity:0; transform: translateY(6px);} to { opacity:1; transform: translateY(0);} }
    .doc-filename .file-size { color: rgba(255,255,255,0.4); font-weight: 500; }

    .doc-right { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; margin-left: auto; }

    .doc-badge {
        font-size: 0.72rem; font-weight: 700; padding: 3px 10px;
        border-radius: 100px; flex-shrink: 0;
    }
    .required { background: rgba(255,107,107,0.15); color: #ff8787; border: 1px solid rgba(255,107,107,0.3); }
    .optional { background: rgba(34,197,94,0.15); color: #4ade80; border: 1px solid rgba(34,197,94,0.3); }
    .doc-item.uploaded .required { background: rgba(34,197,94,0.15); color: #4ade80; border-color: rgba(34,197,94,0.3); }

    /* PER-FIELD UPLOAD BUTTON */
    .doc-upload-btn {
        position: relative; overflow: hidden;
        background: rgba(201,168,76,0.12); color: #c9a84c;
        border: 1.5px solid rgba(201,168,76,0.4);
        padding: 8px 18px; border-radius: 100px;
        font-size: 0.8rem; font-weight: 700; cursor: pointer;
        transition: background 0.25s, color 0.25s, transform 0.2s, box-shadow 0.25s;
        display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;
    }
    .doc-upload-btn:hover { background: #c9a84c; color: #0a1628; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(201,168,76,0.35); }
    .doc-item.uploaded .doc-upload-btn { background: #4ade80; color: #0a1628; border-color: #4ade80; }
    .doc-upload-btn input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }

    /* UPLOAD AREA (bottom, general) */
    .upload-area {
        border: 2px dashed rgba(201,168,76,0.5); border-radius: 14px;
        padding: 32px; text-align: center;
        background: rgba(201,168,76,0.04); margin: 24px 0;
        transition: background 0.2s, border-color 0.2s, transform 0.2s;
        cursor: pointer;
    }
    .upload-area:hover { background: rgba(201,168,76,0.08); border-color: #c9a84c; transform: translateY(-2px); }
    .upload-area p { color: rgba(255,255,255,0.5); font-size: 0.88rem; margin: 8px 0 0; }
    .upload-icon { font-size: 2.5rem; margin-bottom: 8px; display: inline-block; transition: transform 0.3s; }
    .upload-area:hover .upload-icon { transform: translateY(-4px) scale(1.1); }
    .upload-area strong { color: #fff; }

    #fileList > div {
        background: rgba(255,255,255,0.06) !important; color: #fff !important;
        border: 1px solid rgba(255,255,255,0.1);
    }
    #fileList > div span:last-child { color: rgba(255,255,255,0.5) !important; }

    .submit-btn {
        width: 100%; padding: 17px; margin-top: 8px;
        background: linear-gradient(135deg, #c9a84c, #e2c06a);
        color: #0a1628; border: none; border-radius: 12px;
        font-size: 1.05rem; font-weight: 800; cursor: pointer;
        letter-spacing: 0.5px; text-transform: uppercase;
        transition: transform 0.25s, box-shadow 0.25s;
        box-shadow: 0 6px 20px rgba(201,168,76,0.3);
    }
    .submit-btn:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(201,168,76,0.45); }
    .submit-btn:active { transform: translateY(-1px); }

    /* INFO BOXES */
    .info-boxes { max-width: 780px; margin: 28px auto 0; display: grid; grid-template-columns: 1fr 1fr; gap: 16px; position: relative; z-index: 2; }
    .info-box {
        background: rgba(255,255,255,0.05); border-radius: 14px; padding: 20px;
        border: 1.5px solid rgba(255,255,255,0.1);
        transition: transform 0.25s, border-color 0.25s, box-shadow 0.25s;
    }
    .info-box:hover { transform: translateY(-4px); border-color: rgba(201,168,76,0.4); box-shadow: 0 10px 24px rgba(0,0,0,0.25); }
    .info-box h4 { font-family: 'Playfair Display', serif; color: #c9a84c; font-size: 0.95rem; margin-bottom: 6px; }
    .info-box p { color: rgba(255,255,255,0.55); font-size: 0.83rem; line-height: 1.6; margin: 0; }

    .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* ── MOBILE RESPONSIVE ── */
    @media(max-width: 768px) {
        .docs-section { padding: 40px 20px; }
        .docs-body { padding: 22px; }
        .docs-header { padding: 24px 22px; }
        .info-boxes { grid-template-columns: 1fr; }
        .page-hero { padding: 50px 24px; }
        .page-hero h1 { font-size: 2.1rem; }
    }
    @media(max-width: 600px) {
        .doc-item { flex-direction: column; align-items: flex-start; padding: 18px; }
        .doc-right { flex-direction: row; width: 100%; justify-content: space-between; align-items: center; margin-left: 0; margin-top: 8px; }
        .doc-upload-btn { width: auto; }
        .progress-steps { flex-wrap: wrap; gap: 12px; }
        .progress-steps::before, .progress-line { display: none; }
    }
</style>
@endsection

@section('content')

<div class="page-hero">
    <h1>📁 Upload <span>Documents</span></h1>
    <p>Step 3 of 4 — Submit your required documents securely</p>
</div>

<div class="docs-section">

    <!-- PROGRESS -->
    <div class="progress-wrap reveal">
        <div class="progress-steps">
            <div class="progress-line"></div>
            <div class="p-step done">
                <div class="p-step-circle">✓</div>
                <span>Choose Visa</span>
            </div>
            <div class="p-step done">
                <div class="p-step-circle">✓</div>
                <span>Fill Form</span>
            </div>
            <div class="p-step active">
                <div class="p-step-circle">3</div>
                <span>Upload Docs</span>
            </div>
            <div class="p-step">
                <div class="p-step-circle">4</div>
                <span>Get Approved</span>
            </div>
        </div>
    </div>

    <!-- DOCS CARD -->
    <div class="docs-card reveal">
        <div class="docs-header">
            <h2>📋 Required Documents</h2>
            <p>Please upload clear, readable copies of the following documents.</p>

            <div class="upload-progress-wrap">
                <div class="upload-progress-bar">
                    <div class="upload-progress-fill" id="progressFill"></div>
                </div>
                <div class="upload-progress-text" id="progressText">
                    <strong>0</strong> of <strong>6</strong> required documents uploaded
                </div>
            </div>
        </div>
        <div class="docs-body">

            <form method="POST" action="{{ route('upload-documents.submit') }}" enctype="multipart/form-data" id="docsForm">
                @csrf

                <!-- PASSPORT COPY -->
                <div class="doc-item required-item">
                    <div class="doc-icon">🛂</div>
                    <div class="doc-info">
                        <h4>Passport Copy</h4>
                        <p>Clear copy of passport bio-data page. Minimum 6 months validity required.</p>
                        <div class="doc-filename" id="filename-passport_copy"></div>
                    </div>
                    <div class="doc-right">
                        <span class="doc-badge required">Required</span>
                        <label class="doc-upload-btn">
                            📤 Upload
                            <input type="file" name="documents[passport_copy]" class="doc-input" data-label="passport_copy" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileSelect(this)"/>
                        </label>
                    </div>
                </div>

                <!-- PASSPORT PHOTO -->
                <div class="doc-item required-item">
                    <div class="doc-icon">📸</div>
                    <div class="doc-info">
                        <h4>Passport Size Photograph</h4>
                        <p>Recent photo with white background. Size: 35mm x 45mm.</p>
                        <div class="doc-filename" id="filename-photo"></div>
                    </div>
                    <div class="doc-right">
                        <span class="doc-badge required">Required</span>
                        <label class="doc-upload-btn">
                            📤 Upload
                            <input type="file" name="documents[photo]" class="doc-input" data-label="photo" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileSelect(this)"/>
                        </label>
                    </div>
                </div>

                <!-- CNIC -->
                <div class="doc-item required-item">
                    <div class="doc-icon">💳</div>
                    <div class="doc-info">
                        <h4>National ID Card (CNIC)</h4>
                        <p>Front and back copy of your CNIC.</p>
                        <div class="doc-filename" id="filename-cnic"></div>
                    </div>
                    <div class="doc-right">
                        <span class="doc-badge required">Required</span>
                        <label class="doc-upload-btn">
                            📤 Upload
                            <input type="file" name="documents[cnic]" class="doc-input" data-label="cnic" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileSelect(this)"/>
                        </label>
                    </div>
                </div>

                <!-- BANK STATEMENT -->
                <div class="doc-item required-item">
                    <div class="doc-icon">🏦</div>
                    <div class="doc-info">
                        <h4>Bank Statement</h4>
                        <p>Last 3 months bank statement showing sufficient funds for travel.</p>
                        <div class="doc-filename" id="filename-bank_statement"></div>
                    </div>
                    <div class="doc-right">
                        <span class="doc-badge required">Required</span>
                        <label class="doc-upload-btn">
                            📤 Upload
                            <input type="file" name="documents[bank_statement]" class="doc-input" data-label="bank_statement" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileSelect(this)"/>
                        </label>
                    </div>
                </div>

                <!-- FLIGHT TICKET -->
                <div class="doc-item required-item">
                    <div class="doc-icon">✈️</div>
                    <div class="doc-info">
                        <h4>Flight Ticket / Itinerary</h4>
                        <p>Confirmed or dummy flight ticket for your travel dates.</p>
                        <div class="doc-filename" id="filename-flight_ticket"></div>
                    </div>
                    <div class="doc-right">
                        <span class="doc-badge required">Required</span>
                        <label class="doc-upload-btn">
                            📤 Upload
                            <input type="file" name="documents[flight_ticket]" class="doc-input" data-label="flight_ticket" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileSelect(this)"/>
                        </label>
                    </div>
                </div>

                <!-- HOTEL BOOKING -->
                <div class="doc-item required-item">
                    <div class="doc-icon">🏨</div>
                    <div class="doc-info">
                        <h4>Hotel Booking / Accommodation Proof</h4>
                        <p>Confirmed hotel reservation or invitation letter from host.</p>
                        <div class="doc-filename" id="filename-hotel_booking"></div>
                    </div>
                    <div class="doc-right">
                        <span class="doc-badge required">Required</span>
                        <label class="doc-upload-btn">
                            📤 Upload
                            <input type="file" name="documents[hotel_booking]" class="doc-input" data-label="hotel_booking" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileSelect(this)"/>
                        </label>
                    </div>
                </div>

                <!-- EMPLOYMENT LETTER (OPTIONAL) -->
                <div class="doc-item">
                    <div class="doc-icon">💼</div>
                    <div class="doc-info">
                        <h4>Employment Letter / Business Proof</h4>
                        <p>Letter from employer or proof of business ownership.</p>
                        <div class="doc-filename" id="filename-employment_letter"></div>
                    </div>
                    <div class="doc-right">
                        <span class="doc-badge optional">Optional</span>
                        <label class="doc-upload-btn">
                            📤 Upload
                            <input type="file" name="documents[employment_letter]" class="doc-input" data-label="employment_letter" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileSelect(this)"/>
                        </label>
                    </div>
                </div>

                <!-- TRAVEL INSURANCE (OPTIONAL) -->
                <div class="doc-item">
                    <div class="doc-icon">🏥</div>
                    <div class="doc-info">
                        <h4>Travel Insurance</h4>
                        <p>Travel insurance covering the entire duration of your trip.</p>
                        <div class="doc-filename" id="filename-travel_insurance"></div>
                    </div>
                    <div class="doc-right">
                        <span class="doc-badge optional">Optional</span>
                        <label class="doc-upload-btn">
                            📤 Upload
                            <input type="file" name="documents[travel_insurance]" class="doc-input" data-label="travel_insurance" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileSelect(this)"/>
                        </label>
                    </div>
                </div>

                <!-- GENERAL EXTRA UPLOAD (agar koi aur file add karni ho) -->
                <div class="upload-area" onclick="document.getElementById('fileUpload').click()">
                    <div class="upload-icon">📤</div>
                    <strong style="font-size:0.95rem;">Any Extra Documents? Click to Upload</strong>
                    <p>Supported formats: PDF, JPG, PNG (Max 5MB per file)</p>
                    <input type="file" id="fileUpload" name="extra_documents[]" multiple accept=".pdf,.jpg,.jpeg,.png" style="display:none" onchange="showFiles(this)"/>
                </div>
                <div id="fileList" style="margin-bottom:16px;"></div>

                <button type="submit" class="submit-btn">
                    Documents Uploaded — Next Step: Payment →
                </button>
            </form>

        </div>
    </div>

    <!-- INFO BOXES -->
    <div class="info-boxes reveal">
        <div class="info-box">
            <h4>🔒 Secure Upload</h4>
            <p>All documents are uploaded through 256-bit SSL encrypted connection. Your data is completely safe.</p>
        </div>
        <div class="info-box">
            <h4>📋 Document Format</h4>
            <p>Please ensure all documents are clear, readable, and not expired. Blurry documents may delay your application.</p>
        </div>
        <div class="info-box">
            <h4>⏱ Processing Time</h4>
            <p>After document submission, our team reviews within 24 hours and proceeds with your visa application.</p>
        </div>
        <div class="info-box">
            <h4>📞 Need Help?</h4>
            <p>If you have questions about required documents, contact our support team anytime — we are available 24/7.</p>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const TOTAL_REQUIRED = 6;

function handleFileSelect(input) {
    const item = input.closest('.doc-item');
    const label = input.getAttribute('data-label');
    const filenameDiv = document.getElementById('filename-' + label);

    if (input.files.length > 0) {
        const file = input.files[0];
        filenameDiv.innerHTML = `✅ ${file.name} <span class="file-size">(${(file.size/1024).toFixed(1)} KB)</span>`;
        item.classList.add('uploaded');
        item.classList.remove('missing');
    } else {
        filenameDiv.innerHTML = '';
        item.classList.remove('uploaded');
    }

    updateProgress();
}

function updateProgress() {
    const requiredInputs = document.querySelectorAll('.required-item .doc-input');
    let uploadedCount = 0;
    requiredInputs.forEach(inp => { if (inp.files.length > 0) uploadedCount++; });

    const percent = Math.round((uploadedCount / TOTAL_REQUIRED) * 100);
    document.getElementById('progressFill').style.width = percent + '%';
    document.getElementById('progressText').innerHTML =
        `<strong>${uploadedCount}</strong> of <strong>${TOTAL_REQUIRED}</strong> required documents uploaded`;
}

function showFiles(input) {
    const list = document.getElementById('fileList');
    list.innerHTML = '';
    Array.from(input.files).forEach(file => {
        list.innerHTML += `
            <div style="display:flex; align-items:center; gap:10px; padding:8px 12px; border-radius:8px; margin-bottom:6px; font-size:0.85rem;">
                <span>📄</span> <span>${file.name}</span>
                <span style="margin-left:auto;">${(file.size/1024).toFixed(1)} KB</span>
            </div>`;
    });
}

document.getElementById('docsForm').addEventListener('submit', function(e) {
    const requiredInputs = document.querySelectorAll('.required-item .doc-input');
    let missingItems = [];

    requiredInputs.forEach(inp => {
        const item = inp.closest('.doc-item');
        if (inp.files.length === 0) {
            missingItems.push(item);
            item.classList.add('missing', 'shake');
            setTimeout(() => item.classList.remove('shake'), 600);
        } else {
            item.classList.remove('missing');
        }
    });

    if (missingItems.length > 0) {
        e.preventDefault();
        missingItems[0].scrollIntoView({ behavior: 'smooth', block: 'center' });

        Swal.fire({
            icon: 'warning',
            title: 'Documents Missing!',
            text: `Please upload all required documents first. ${missingItems.length} document(s) still missing.`,
            confirmButtonColor: '#c9a84c',
            background: '#0a1628',
            color: '#ffffff',
            confirmButtonText: 'Got it'
        });
    }
});

const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endsection