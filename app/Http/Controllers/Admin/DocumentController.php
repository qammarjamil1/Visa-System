<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with('user', 'visaApplication')->latest();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $documents = $query->paginate(12);
        return view('admin.documents.index', compact('documents'));
    }

    public function verify(Document $document)
    {
        $document->update(['status' => 'verified']);
        return back()->with('success', 'Document verified.');
    }

    public function reject(Document $document)
    {
        $document->update(['status' => 'rejected']);
        return back()->with('success', 'Document rejected.');
    }
}