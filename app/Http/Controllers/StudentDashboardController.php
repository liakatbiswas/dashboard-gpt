<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        abort_unless($request->user()->hasRole(config('access.student_role'), 'web'), 403);

        return view('student.dashboard');
    }
}
