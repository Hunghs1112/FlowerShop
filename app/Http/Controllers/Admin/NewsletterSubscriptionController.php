<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class NewsletterSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscription::latest();

        if ($request->filled('search')) {
            $query->where('email', 'like', '%'.$request->string('search').'%');
        }

        return view('admin.newsletter-subscriptions.index', [
            'subscriptions' => $query->paginate(50)->withQueryString(),
        ]);
    }
}
