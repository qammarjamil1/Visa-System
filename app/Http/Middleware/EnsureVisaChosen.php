<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureVisaChosen
{
    public function handle(Request $request, Closure $next)
    {
        // Agar country/visa_type query mein aya hai (calculator/countries page se), to save kar lo
        if ($request->filled('country') && $request->filled('visa_type')) {
            session([
                'visa_chosen'      => true,
                'chosen_country'   => $request->country,
                'chosen_visa_type' => $request->visa_type,
            ]);
        }

        // Agar ab bhi visa choose nahi hua, to wapis bhej do
        if (!session('visa_chosen')) {
            return redirect()->route('countries')
                ->with('step_popup', 'Please choose your visa type first. That\'s Step 1 of the process!');
        }

        return $next($request);
    }
}