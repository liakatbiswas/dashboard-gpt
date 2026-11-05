<?php

namespace App\Http\Responses;

use App\Services\Access\AuthenticationDestination;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

trait RedirectsToPendingAccess
{
    /**
     * @param  Request  $request
     */
    public function toResponse($request): Response
    {
        if (! $request->wantsJson() && ! $request->user()->isSuperAdmin()) {
            $request->session()->forget('url.intended');

            return redirect()->to(app(AuthenticationDestination::class)->url($request->user()));
        }

        return parent::toResponse($request);
    }
}
