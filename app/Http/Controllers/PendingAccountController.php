<?php

namespace App\Http\Controllers;

use App\Services\Access\AuthenticationDestination;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PendingAccountController extends Controller
{
    public function __invoke(Request $request, AuthenticationDestination $destination): View|RedirectResponse
    {
        if ($destination->routeName($request->user()) !== 'account.pending') {
            return redirect()->to($destination->url($request->user()));
        }

        return view('auth.pending-access');
    }
}
