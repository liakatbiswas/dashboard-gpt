<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PendingAccountController extends Controller
{
    public function __invoke(Request $request): View|RedirectResponse
    {
        if ($request->user()->can('dashboard.view')) {
            return redirect()->route('dashboard');
        }

        return view('auth.pending-access');
    }
}
