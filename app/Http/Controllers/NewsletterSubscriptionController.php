<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterSubscriptionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => strtolower(trim((string) $request->input('email'))),
        ]);

        $validated = $request->validateWithBag('newsletter', [
            'email' => ['required', 'string', 'email', 'max:254'],
        ]);

        NewsletterSubscription::firstOrCreate(['email' => $validated['email']]);

        return back()->with('newsletter_success', 'Cảm ơn bạn đã đăng ký nhận bản tin.');
    }
}
