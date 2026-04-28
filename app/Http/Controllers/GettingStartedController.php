<?php

namespace App\Http\Controllers;

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
        return view('getting-started.index');
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
