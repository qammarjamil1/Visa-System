<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisaApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = VisaApplication::with('user')->latest();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->whereHas('user', fn($q) =>
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%')
            );
        }

        $applications = $query->paginate(12);
        return view('admin.applications.index', compact('applications'));
    }

    public function show(VisaApplication $application)
    {
        $application->load('user', 'documents', 'payments');
        return view('admin.applications.show', compact('application'));
    }

    public function edit(VisaApplication $application)
    {
        return view('admin.applications.edit', compact('application'));
    }

    public function update(Request $request, VisaApplication $application)
    {
        $request->validate([
            'status'      => 'required|in:pending,under_review,approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $application->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.applications.index')
            ->with('success', 'Application updated successfully!');
    }

    public function destroy(VisaApplication $application)
    {
        $application->delete();
        return back()->with('success', 'Application deleted.');
    }
}