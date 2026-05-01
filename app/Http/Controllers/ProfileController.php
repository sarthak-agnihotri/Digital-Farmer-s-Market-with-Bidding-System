<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Bid;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $data = [
            'user' => $user,
            'memberSince' => $user->created_at?->format('F j, Y'),
        ];

        if ($user->isFarmer()) {
            $data['productCount'] = Product::where('user_id', $user->id)->count();
        }

        if ($user->isConsumer()) {
            $data['bidCount'] = Bid::where('user_id', $user->id)->count();
        }

        if ($user->isAdmin()) {
            $data['pendingProducts'] = Product::where('status', 'pending')->count();
        }

        return view('profile.edit', $data);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());
        $user->subscribed_to_product_alerts = $request->boolean('subscribed_to_product_alerts');
        $user->preferred_product_categories = $request->input('preferred_product_categories', []);
        $user->preferred_language = $request->input('preferred_language', $user->preferred_language ?? 'en');

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
