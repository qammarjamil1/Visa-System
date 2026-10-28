<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureFormFilled
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('form_filled')) {
            return redirect()->route('booking')
                ->with('step_popup', 'Please complete Step 1 (Choose Visa) and Step 2 (Fill Form) before uploading documents.');
        }

        return $next($request);
    }
}