<?php

namespace App\Http\Responses;

use Laravel\Fortify\Http\Responses\RegisterResponse as FortifyRegisterResponse;

class RegisterResponse extends FortifyRegisterResponse
{
    use RedirectsToPendingAccess;
}
