<?php

namespace App\Http\Middleware;

use App\Services\Access\AccessSettingsService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentRegistrationOpen
{
    public function __construct(private AccessSettingsService $settings) {}

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('register', 'register.store') && ! $this->settings->registrationIsOpen()) {
            if ($request->isMethod('GET') && ! $request->expectsJson()) {
                return response()->view('auth.registration-closed', [], 403);
            }

            abort(403, 'Student registration is currently closed.');
        }

        return $next($request);
    }
}
