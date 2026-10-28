<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

      ContactMessage::create([
    'user_id' => Auth::check() ? Auth::id() : null,
    'name'    => $request->name,
    'email'   => $request->email,
    'subject' => $request->subject,
    'message' => $request->message,
]);
        return redirect()->back()->with('success', '✅ Message sent! We will contact you soon.');
    }

    public function countries()
    {
        return view('countries');
    }

    public function visaTypes()
    {
        return view('visa-types');
    }

public function dashboard()
{
    $applications = VisaApplication::where('user_id', Auth::id())
                    ->latest()->take(5)->get();

    $total    = VisaApplication::where('user_id', Auth::id())->count();
    $pending  = VisaApplication::where('user_id', Auth::id())->where('status', 'pending')->count();
    $approved = VisaApplication::where('user_id', Auth::id())->where('status', 'approved')->count();
    $rejected = VisaApplication::where('user_id', Auth::id())->where('status', 'rejected')->count();

    // user_id se messages lao — email se nahi
    $myMessages = \App\Models\ContactMessage::where('user_id', Auth::id())
                    ->latest()->get();

    return view('dashboard', compact('applications', 'total', 'pending', 'approved', 'rejected', 'myMessages'));
}
}