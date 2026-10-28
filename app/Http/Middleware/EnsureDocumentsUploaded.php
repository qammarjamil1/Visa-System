<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureDocumentsUploaded
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('documents_uploaded')) {
            return redirect()->route('booking')
                ->with('step_popup', 'Please complete the previous steps (Choose Visa, Fill Form, Upload Documents) before this page.');
        }

        return $next($request);
    }
}