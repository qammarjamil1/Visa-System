<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

// Public Routes
Route::get('/', function () { return view('home'); })->name('home');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/countries', function () { return view('countries'); })->name('countries');
Route::get('/visa-types', function () { return view('visa-types'); })->name('visa-types');
Route::get('/services', function () { return view('services'); })->name('services');
Route::get('/visaa/canada-eta', function () { return view('visaa.canada-eta'); })->name('visaa.canada-eta');
Route::get('/visaa/uk-eta', function () { return view('visaa.uk-eta'); })->name('visaa.uk-eta');
Route::get('/visaa/esta-usa', function () { return view('visaa.esta-usa'); })->name('visaa.esta-usa');
Route::get('/visaa/uae-visa', function () { return view('visaa.uae-visa'); })->name('visaa.uae-visa');

Route::get('/privacy-policy', function () { return view('privacy-policy');})->name('privacy-policy');

// Fee Pages
Route::get('/visa-fees', function () { return view('visa-fees'); })->name('visa-fees');
Route::get('/exit-permit-fee', function () { return view('exit-permit-fee'); })->name('exit-permit-fee');

// ===================================================================
// STEP 1: BOOKING (Choose Visa + Fill Form)
// ===================================================================
Route::get('/booking', function (\Illuminate\Http\Request $request) {

    if ($request->filled('visa_type')) {
        session([
            'visa_chosen'      => true,
            'chosen_visa_type' => $request->visa_type,
            'chosen_country'   => $request->filled('country') ? $request->country : session('chosen_country'),
        ]);
    }

    if (!session('visa_chosen')) {
        return redirect()->route('visa-types')
            ->with('step_popup', "Please choose your visa type first — that's Step 1 of the process!");
    }

    return view('booking', [
        'prefill_country'   => session('chosen_country'),
        'prefill_visa_type' => session('chosen_visa_type'),
    ]);
})->middleware('auth')->name('booking');

Route::post('/booking', function (\Illuminate\Http\Request $request) {

    $validated = $request->validate([
        'full_name'        => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s\.\']+$/'],
        'email'            => ['required', 'email', 'max:150'],
        'phone'            => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
        'passport_number'  => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z0-9]+$/'],
        'nationality'      => ['required', 'string', 'max:50'],
        'visa_type'        => ['required', 'in:tourist,work,study,business,family'],
        'country'          => ['required', 'string', 'max:100'],
        'travel_date'      => ['required', 'date', 'after_or_equal:today'],
        'duration_days'    => ['required', 'integer', 'min:1', 'max:365'],
        'purpose'          => ['nullable', 'string', 'max:1000'],
    ], [
        'full_name.regex'       => 'Full name can only contain letters and spaces.',
        'phone.regex'           => 'Phone number can only contain numbers, +, - and spaces.',
        'passport_number.regex' => 'Passport number can only contain letters and numbers.',
        'visa_type.in'          => 'Please select a valid visa type.',
        'travel_date.after_or_equal' => 'Travel date cannot be in the past.',
    ]);

    \DB::table('visa_applications')->insert([
        'user_id'          => auth()->id(),
        'full_name'        => $validated['full_name'],
        'email'            => $validated['email'],
        'phone'            => $validated['phone'],
        'passport_number'  => $validated['passport_number'],
        'nationality'      => $validated['nationality'] ?? 'Pakistani',
        'country_to_visit' => $validated['country'],
        'travel_date'      => $validated['travel_date'],
        'duration_days'    => $validated['duration_days'],
        'purpose'          => $validated['purpose'] ?? null,
        'visa_type'        => $validated['visa_type'],
        'country'          => $validated['country'],
        'status'           => 'pending',
        'created_at'       => now(),
        'updated_at'       => now(),
    ]);

    try {
        \Mail::raw(
            "New Visa Application\n\n"
            . "Name: " . $validated['full_name'] . "\n"
            . "Email: " . $validated['email'] . "\n"
            . "Phone: " . $validated['phone'] . "\n"
            . "Passport: " . $validated['passport_number'] . "\n"
            . "Country: " . $validated['country'] . "\n"
            . "Visa Type: " . $validated['visa_type'] . "\n"
            . "Travel Date: " . $validated['travel_date'] . "\n"
            . "Duration: " . $validated['duration_days'] . " days\n"
            . "Purpose: " . ($validated['purpose'] ?? '-'),
            function($message) {
                $message->to('qammarjamil1@gmail.com')
                        ->subject('🆕 New VisaGo Application Received');
            }
        );
    } catch (\Exception $e) {
        // Email fail ho to bhi application save reh jayegi
    }

    $msg = "🆕 *New Visa Application*%0A"
         . "👤 Name: " . $validated['full_name'] . "%0A"
         . "📧 Email: " . $validated['email'] . "%0A"
         . "📱 Phone: " . $validated['phone'] . "%0A"
         . "🛂 Passport: " . $validated['passport_number'] . "%0A"
         . "🌍 Country: " . $validated['country'] . "%0A"
         . "✈️ Visa Type: " . $validated['visa_type'] . "%0A"
         . "📅 Travel Date: " . $validated['travel_date'] . "%0A"
         . "⏱ Duration: " . $validated['duration_days'] . " days%0A"
         . "📝 Purpose: " . ($validated['purpose'] ?? '-');

    $whatsappUrl = "https://wa.me/923428480072?text=" . $msg;

    session(['form_filled' => true]);

    return redirect('/booking')
        ->with('application_submitted', true)
        ->with('whatsapp_url', $whatsappUrl);
})->middleware('auth')->name('booking.submit');


// Visa Type + Country choose karne ka route (Lead capture ke sath)
Route::get('/choose-visa-type', function (\Illuminate\Http\Request $request) {
    $type    = $request->query('type');
    $country = $request->query('country');

    if ($type) {
        session(['chosen_visa_type' => $type]);
    }

    if ($country) {
        session(['chosen_country' => $country]);
    }

    if ($type || $country) {
        \DB::table('visa_leads')->updateOrInsert(
            ['user_id' => auth()->id()],
            [
                'visa_type'  => $type ?? session('chosen_visa_type'),
                'country'    => $country ?? session('chosen_country'),
                'status'     => 'interested',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }

    return redirect()->route('booking', [
        'visa_type' => $type,
        'country'   => $country,
    ]);
})->middleware('auth')->name('choose-visa-type');


// ===================================================================
// STEP 3: UPLOAD DOCUMENTS
// ===================================================================
Route::get('/upload-documents', function () {
    if (!session('form_filled')) {
        return redirect()->route('booking')
            ->with('step_popup', 'Please complete Step 1 (Choose Visa) and Step 2 (Fill Form) before uploading documents.');
    }
    return view('upload-documents');
})->middleware('auth')->name('upload-documents');

Route::post('/upload-documents', function (\Illuminate\Http\Request $request) {

    $latestApplication = \DB::table('visa_applications')
        ->where('user_id', auth()->id())
        ->latest('created_at')
        ->first();

    $applicationId = $latestApplication->id ?? null;

    // "documents" array mein jitni bhi files aayi hain, unhein save karo
    if ($request->hasFile('documents')) {
        foreach ($request->file('documents') as $type => $file) {
            if ($file) {
                $path = $file->store('visa_documents', 'public');
                \DB::table('visa_documents')->insert([
                    'user_id'        => auth()->id(),
                    'application_id' => $applicationId,
                    'document_type'  => $type,
                    'file_path'      => $path,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }
    }

    // Agar "extra_documents" bhi bheji hon
    if ($request->hasFile('extra_documents')) {
        foreach ($request->file('extra_documents') as $file) {
            $path = $file->store('visa_documents', 'public');
            \DB::table('visa_documents')->insert([
                'user_id'        => auth()->id(),
                'application_id' => $applicationId,
                'document_type'  => 'extra',
                'file_path'      => $path,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }

    // Lead ko "completed" mark kar do (ab ye sirf 'interested' nahi raha)
    \DB::table('visa_leads')
        ->where('user_id', auth()->id())
        ->update(['status' => 'completed', 'updated_at' => now()]);

    session(['documents_uploaded' => true]);

    return redirect()->route('payment')
        ->with('success', 'Documents uploaded successfully! Next step: Payment.');
})->middleware('auth')->name('upload-documents.submit');

// ===================================================================
// STEP 4: PAYMENT
// ===================================================================
Route::get('/payment', function () {
    if (!session('documents_uploaded')) {
        return redirect()->route('upload-documents')
            ->with('step_popup', 'Please upload your documents first before proceeding to payment.');
    }
    return view('payment');
})->middleware('auth')->name('payment');

Route::post('/payment', function (\Illuminate\Http\Request $request) {

    if (!session('documents_uploaded')) {
        return redirect()->route('upload-documents')
            ->with('step_popup', 'Please upload your documents first before proceeding to payment.');
    }

    $validated = $request->validate([
        'method'         => ['required', 'in:easypaisa,jazzcash'],
        'sender_number'  => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
        'transaction_id' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z0-9]+$/'],
    ], [
        'method.required'         => 'Please select a payment method.',
        'sender_number.regex'     => 'Sender number can only contain numbers, +, - and spaces.',
        'transaction_id.regex'    => 'Transaction ID can only contain letters and numbers.',
    ]);

    $application = \DB::table('visa_applications')
        ->where('user_id', auth()->id())
        ->latest('created_at')
        ->first();

    $amount = 18000;

    \DB::table('payments')->insert([
        'user_id'             => auth()->id(),
        'visa_application_id' => $application->id ?? null,
        'amount'              => $amount,
        'method'              => $validated['method'],
        'status'              => 'pending',
        'transaction_id'      => $validated['transaction_id'],
        'sender_number'       => $validated['sender_number'],
        'created_at'          => now(),
        'updated_at'          => now(),
    ]);

    try {
        \Mail::raw(
            "New Payment Submitted\n\n"
            . "User: " . auth()->user()->name . " (" . auth()->user()->email . ")\n"
            . "Method: " . strtoupper($validated['method']) . "\n"
            . "Sender Number: " . $validated['sender_number'] . "\n"
            . "Transaction ID: " . $validated['transaction_id'] . "\n"
            . "Amount: PKR " . number_format($amount),
            function($message) {
                $message->to('qammarjamil1@gmail.com')
                        ->subject('💳 New VisaGo Payment Submitted — Verify Now');
            }
        );
    } catch (\Exception $e) {}

    session(['payment_completed' => true]);

    return redirect()->route('get-approved')
        ->with('payment_submitted', true);
})->middleware('auth')->name('payment.submit');


Route::get('/documents', function (\Illuminate\Http\Request $request) {
        $allDocs = \DB::table('visa_documents')
            ->join('users', 'visa_documents.user_id', '=', 'users.id')
            ->leftJoin('visa_applications', 'visa_documents.application_id', '=', 'visa_applications.id')
            ->select('visa_documents.*', 'users.name as user_name', 'users.email as user_email',
                      'visa_applications.country as app_country', 'visa_applications.visa_type as app_visa_type',
                      'visa_applications.created_at as app_created_at')
            ->orderBy('visa_documents.created_at', 'desc')
            ->get();

        // Group documents by application_id (documents without application go under 'unlinked')
        $grouped = $allDocs->groupBy(function ($doc) {
            return $doc->application_id ?? 'unlinked';
        });

        return view('admin.documents.index', compact('grouped'));
    })->name('myadmin.documents');

    Route::delete('/documents/{id}', function ($id) {
        $doc = \DB::table('visa_documents')->where('id', $id)->first();
        if ($doc && \Storage::disk('public')->exists($doc->file_path)) {
            \Storage::disk('public')->delete($doc->file_path);
        }
        \DB::table('visa_documents')->where('id', $id)->delete();
        return redirect()->route('myadmin.documents')->with('success', 'Document deleted successfully!');
    })->name('myadmin.documents.destroy');


// ===================================================================
// STEP 5: GET APPROVED
// ===================================================================
Route::get('/get-approved', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $hasApplication = \DB::table('visa_applications')
        ->where('user_id', auth()->id())
        ->exists();

    if (!$hasApplication || !session('documents_uploaded')) {
        return redirect()->route('booking')
            ->with('step_popup', 'Please complete all previous steps (Choose Visa, Fill Form, Upload Documents) before viewing this page.');
    }

    if (!session('payment_completed')) {
        return redirect()->route('payment')
            ->with('step_popup', 'Please complete your payment first before viewing this page.');
    }

    return view('get-approved');
})->middleware('auth')->name('get-approved');

// Dashboard — Track Application
Route::get('/dashboard', function () {
    $application = \DB::table('visa_applications')
        ->where('user_id', auth()->id())
        ->latest('created_at')
        ->first();

    $payment = null;
    if ($application) {
        $payment = \DB::table('payments')
            ->where('user_id', auth()->id())
            ->latest('created_at')
            ->first();
    }

    $documents = \DB::table('visa_documents')
        ->where('user_id', auth()->id())
        ->where('application_id', $application->id ?? 0)
        ->get();

    $messages = \DB::table('contact_messages')
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->take(1)
        ->get();

    return view('dashboard', compact('application', 'payment', 'documents', 'messages'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/contact', function (\Illuminate\Http\Request $request) {

    $validated = $request->validate([
        'name'        => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s\.\']+$/'],
        'father_name' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s\.\']+$/'],
        'email'       => ['required', 'email', 'max:150'],
        'phone'       => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
        'subject'     => ['required', 'string', 'max:150'],
        'message'     => ['required', 'string', 'max:2000'],
    ], [
        'name.regex'        => 'Name can only contain letters and spaces.',
        'father_name.regex' => "Father's name can only contain letters and spaces.",
        'phone.regex'       => 'Phone number can only contain numbers, +, - and spaces.',
    ]);

    // Message ke sath father's name aur phone bhi shamil kar dete hain (table mein alag column nahi hai)
    $fullMessage = "Father's Name: " . $validated['father_name'] . "\n"
                 . "Phone: " . $validated['phone'] . "\n\n"
                 . $validated['message'];

    // 1) DATABASE MEIN SAVE — taake admin panel Messages page pe dikhe
    \DB::table('contact_messages')->insert([
        'user_id'    => auth()->id(),
        'name'       => $validated['name'],
        'email'      => $validated['email'],
        'subject'    => $validated['subject'],
        'message'    => $fullMessage,
        'reply'      => null,
        'status'     => 'unread',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // 2) EMAIL BHEJNA — booking form jaisa reliable tarika
    try {
        \Mail::raw(
            "New Contact Message\n\n"
            . "Name: " . $validated['name'] . "\n"
            . "Father's Name: " . $validated['father_name'] . "\n"
            . "Email: " . $validated['email'] . "\n"
            . "Phone: " . $validated['phone'] . "\n"
            . "Subject: " . $validated['subject'] . "\n"
            . "Message: " . $validated['message'],
            function($message) {
                $message->to('qammarjamil1@gmail.com')
                        ->subject('📩 New VisaGo Contact Message');
            }
        );
    } catch (\Exception $e) {
        // Email fail ho to bhi message database mein save reh jayega
    }

    $msg = "📩 *New Contact Message - VisaGo*%0A"
         . "👤 Name: " . $validated['name'] . "%0A"
         . "👨 Father's Name: " . $validated['father_name'] . "%0A"
         . "📧 Email: " . $validated['email'] . "%0A"
         . "📱 Phone: " . $validated['phone'] . "%0A"
         . "📌 Subject: " . $validated['subject'] . "%0A"
         . "💬 Message: " . $validated['message'];

    $whatsappUrl = "https://wa.me/923428480072?text=" . $msg;

    return redirect('/contact')
        ->with('contact_submitted', true)
        ->with('whatsapp_url', $whatsappUrl);
})->name('contact.submit');

Route::get('/blog', function () { return view('blog'); })->name('blog');

Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('myadmin')->group(function () {
    Route::get('/', function () {
    $stats = [
        'total_applications' => \DB::table('visa_applications')->count(),
        'pending'             => \DB::table('visa_applications')->where('status', 'pending')->count(),
        'approved'            => \DB::table('visa_applications')->where('status', 'approved')->count(),
        'rejected'            => \DB::table('visa_applications')->where('status', 'rejected')->count(),
        'total_users'         => \DB::table('users')->count(),
    ];

    $recent_applications = \DB::table('visa_applications')
        ->join('users', 'visa_applications.user_id', '=', 'users.id')
        ->select('visa_applications.*', 'users.name as user_name', 'users.email as user_email')
        ->orderBy('visa_applications.created_at', 'desc')
        ->take(5)
        ->get();

    return view('admin.dashboard', compact('stats', 'recent_applications'));
})->name('myadmin');

  Route::get('/applications', function (\Illuminate\Http\Request $request) {
    $query = \DB::table('visa_applications')
        ->join('users', 'visa_applications.user_id', '=', 'users.id')
        ->select('visa_applications.*', 'users.name as user_name', 'users.email as user_email')
        ->orderBy('visa_applications.created_at', 'desc');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('users.name', 'like', "%{$search}%")
              ->orWhere('users.email', 'like', "%{$search}%");
        });
    }

    if ($request->filled('status') && $request->status !== 'all') {
        $query->where('visa_applications.status', $request->status);
    }

    $applications = $query->paginate(10)->withQueryString();

    return view('admin.applications.index', compact('applications'));
})->name('myadmin.applications');

    Route::get('/leads', function () {
        $leads = \DB::table('visa_leads')
            ->join('users', 'visa_leads.user_id', '=', 'users.id')
            ->select('visa_leads.*', 'users.name as user_name', 'users.email as user_email')
            ->orderBy('visa_leads.updated_at', 'desc')
            ->get();
        return view('admin.leads.index', compact('leads'));
    })->name('myadmin.leads');


    Route::get('/payments', function (\Illuminate\Http\Request $request) {
        $query = \DB::table('payments')
            ->join('users', 'payments.user_id', '=', 'users.id')
            ->leftJoin('visa_applications', 'payments.visa_application_id', '=', 'visa_applications.id')
            ->select('payments.*', 'users.name as user_name', 'users.email as user_email',
                      'visa_applications.country as app_country', 'visa_applications.visa_type as app_visa_type')
            ->orderBy('payments.created_at', 'desc');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('payments.status', $request->status);
        }

        $payments = $query->paginate(10)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    })->name('myadmin.payments');

    Route::put('/payments/{id}/verify', function ($id) {
        \DB::table('payments')->where('id', $id)->update([
            'status'     => 'completed',
            'updated_at' => now(),
        ]);
        return redirect()->route('myadmin.payments')->with('success', 'Payment marked as verified!');
    })->name('myadmin.payments.verify');


// Application View (Detail Page)
    Route::get('/applications/{id}', function ($id) {
        $app = \DB::table('visa_applications')
            ->join('users', 'visa_applications.user_id', '=', 'users.id')
            ->select('visa_applications.*', 'users.name as user_name', 'users.email as user_email')
            ->where('visa_applications.id', $id)
            ->first();

        if (!$app) abort(404);

        $documents = \DB::table('visa_documents')
            ->where('user_id', $app->user_id)
            ->where('application_id', $app->id)
            ->get();

        return view('admin.applications.show', compact('app', 'documents'));
    })->name('myadmin.applications.show');

    // Application Edit (Change Status)
    Route::get('/applications/{id}/edit', function ($id) {
        $app = \DB::table('visa_applications')->where('id', $id)->first();
        if (!$app) abort(404);
        return view('admin.applications.edit', compact('app'));
    })->name('myadmin.applications.edit');

    Route::put('/applications/{id}', function (\Illuminate\Http\Request $request, $id) {
        \DB::table('visa_applications')->where('id', $id)->update([
            'status'       => $request->status,
            'admin_notes'  => $request->admin_notes,
            'updated_at'   => now(),
        ]);
        return redirect()->route('myadmin.applications')->with('success', 'Application status updated successfully!');
    })->name('myadmin.applications.update');

    // Application Delete
    Route::delete('/applications/{id}', function ($id) {
        \DB::table('visa_applications')->where('id', $id)->delete();
        return redirect()->route('myadmin.applications')->with('success', 'Application deleted successfully!');
    })->name('myadmin.applications.destroy');

    // Change Credentials
    Route::get('/credentials', function () {
        return view('admin.credentials');
    })->name('myadmin.credentials');

    Route::post('/credentials', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = auth()->user();
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('myadmin.credentials')->with('success', 'Credentials updated successfully! Please login again with new details next time.');
    })->name('myadmin.credentials.update');


    Route::get('/users', function (\Illuminate\Http\Request $request) {
    $query = \DB::table('users')
        ->selectRaw('users.*, (select count(*) from visa_applications where visa_applications.user_id = users.id) as applications_count');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

    return view('admin.users.index', compact('users'));
})->name('myadmin.users');

Route::get('/messages', function () {
        $messages = \DB::table('contact_messages')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.messages.index', compact('messages'));
    })->name('myadmin.messages');

    Route::get('/messages/{id}', function ($id) {
        $msg = \DB::table('contact_messages')->where('id', $id)->first();
        if (!$msg) abort(404);

        // Message ko "read" mark kar do jab admin khole
        if ($msg->status === 'unread') {
            \DB::table('contact_messages')->where('id', $id)->update(['status' => 'read']);
            $msg->status = 'read';
        }

        return view('admin.messages.show', compact('msg'));
    })->name('myadmin.messages.show');

    Route::post('/messages/{id}/reply', function (\Illuminate\Http\Request $request, $id) {
        $validated = $request->validate([
            'reply' => ['required', 'string', 'max:2000'],
        ]);

        $msg = \DB::table('contact_messages')->where('id', $id)->first();
        if (!$msg) abort(404);

        \DB::table('contact_messages')->where('id', $id)->update([
            'reply'      => $validated['reply'],
            'status'     => 'read',
            'updated_at' => now(),
        ]);

        try {
            \Mail::raw(
                "Hi " . $msg->name . ",\n\n"
                . "Thank you for contacting VisaGo. Here is our reply to your message:\n\n"
                . $validated['reply'] . "\n\n"
                . "---\nYour original message:\n" . $msg->message . "\n\n"
                . "Best regards,\nVisaGo Team",
                function($message) use ($msg) {
                    $message->to($msg->email)
                            ->subject('Re: ' . $msg->subject . ' — VisaGo Support');
                }
            );
        } catch (\Exception $e) {}

        return redirect()->route('myadmin.messages.show', $id)->with('success', 'Reply sent successfully to ' . $msg->email . '!');
    })->name('myadmin.messages.reply');

    Route::delete('/messages/{id}', function ($id) {
        \DB::table('contact_messages')->where('id', $id)->delete();
        return redirect()->route('myadmin.messages')->with('success', 'Message deleted successfully!');
    })->name('myadmin.messages.destroy');
});

require __DIR__.'/auth.php';