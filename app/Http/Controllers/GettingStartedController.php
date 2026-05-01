<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GettingStartedController extends Controller
{
    /**
     * Show the getting started page.
     */
    public function index(): View
    {
        $user = auth()->user();

        $steps = [
            [
                'title' => __('ui.verify_email'),
                'description' => __('Verify your email address for full access.'),
                'complete' => (bool) $user->email_verified_at,
            ],
            [
                'title' => __('ui.complete_profile'),
                'description' => __('Complete your profile and alert preferences.'),
                'complete' => (bool) ($user->preferred_language || $user->preferred_product_categories),
            ],
        ];

        if ($user->isFarmer()) {
            $steps[] = [
                'title' => __('ui.first_action'),
                'description' => __('Add your first product to start selling.'),
                'complete' => Product::where('user_id', $user->id)->exists(),
            ];
        } elseif ($user->isConsumer()) {
            $steps[] = [
                'title' => __('ui.first_action'),
                'description' => __('Place your first bid or buy now order.'),
                'complete' => Bid::where('user_id', $user->id)->exists(),
            ];
        } elseif ($user->isAdmin()) {
            $steps[] = [
                'title' => __('ui.first_action'),
                'description' => __('Review the pending marketplace requests.'),
                'complete' => Product::where('status', 'pending')->exists(),
            ];
        }

        $completed = collect($steps)->where('complete', true)->count();
        $progress = intval(($completed / count($steps)) * 100);

        return view('getting-started.index', compact('steps', 'progress', 'completed'));
    }

    /**
     * Complete the getting started process.
     */
    public function complete(): RedirectResponse
    {
        auth()->user()->update(['getting_started_completed' => true]);

        // Redirect based on user role
        if (auth()->user()->isFarmer()) {
            return redirect()->route('products.create')->with('success', 'Welcome! Start by adding your first product.');
        } elseif (auth()->user()->isConsumer()) {
            return redirect()->route('consumer.dashboard')->with('success', 'Welcome! Explore fresh produce from local farmers.');
        } elseif (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome! Manage the farmer market platform.');
        }

        return redirect('/')->with('success', 'Getting started completed!');
    }
}
