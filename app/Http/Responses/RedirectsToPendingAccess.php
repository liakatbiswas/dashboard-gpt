<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

trait RedirectsToPendingAccess
{
    /**
     * @param  Request  $request
     */
    public function toResponse($request): Response
    {
        if (! $request->wantsJson() && $request->user()->cannot('dashboard.view')) {
            $request->session()->forget('url.intended');

            return redirect()->route('account.pending');
        }

        return parent::toResponse($request);
    }
}
