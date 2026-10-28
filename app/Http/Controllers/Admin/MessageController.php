<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        $message->update(['status' => 'read']);
        return view('admin.messages.show', compact('message'));
    }

    public function reply(Request $request, ContactMessage $message)
    {
        $request->validate([
            'reply' => 'required|string|max:2000',
        ]);

        $message->update([
            'reply'      => $request->reply,
            'replied_at' => now(),
        ]);

        return back()->with('success', '✅ Reply saved! User will see it in their dashboard.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'Message deleted.');
    }
}