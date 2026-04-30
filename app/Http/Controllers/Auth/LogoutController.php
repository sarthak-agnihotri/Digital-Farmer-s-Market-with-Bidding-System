<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogoutController extends Controller
{
    /**
     * Display the logout confirmation view.
     */
    public function show(): View
    {
        return view('auth.logout');
    }
}
