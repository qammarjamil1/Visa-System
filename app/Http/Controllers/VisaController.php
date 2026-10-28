<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisaApplication;
use Illuminate\Support\Facades\Auth;

class VisaController extends Controller
{
    public function create()
    {
        return view('booking');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'       => 'required|string|max:255',
            'email'           => 'required|email',
            'phone'           => 'required|string|max:20',
            'passport_number' => 'required|string|max:50',
            'visa_type'       => 'required|string',
            'country'         => 'required|string',
            'travel_date'     => 'required|date|after:today',
            'duration_days'   => 'required|integer|min:1',
            'purpose'         => 'nullable|string|max:1000',
        ]);

        VisaApplication::create([
            'user_id'         => Auth::id(),
            'full_name'       => $request->full_name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'passport_number' => $request->passport_number,
            'visa_type'       => $request->visa_type,
            'country'         => $request->country,
            'travel_date'     => $request->travel_date,
            'duration_days'   => $request->duration_days,
            'purpose'         => $request->purpose,
            'status'          => 'pending',
        ]);

        return redirect()->route('my-applications')
               ->with('success', '✅ Visa application submitted successfully!');
    }

    public function myList()
    {
        $applications = VisaApplication::where('user_id', Auth::id())
                        ->latest()->get();
        return view('visa.list', compact('applications'));
    }

    public function adminList()
    {
        $applications = VisaApplication::with('user')->latest()->get();
        return view('admin.visas', compact('applications'));
    }

    public function updateStatus(Request $request, $id)
    {
        $application = VisaApplication::findOrFail($id);
        $application->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status updated!');
    }
}