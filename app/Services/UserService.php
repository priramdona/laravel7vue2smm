<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class UserService
{
    public function getUser()
    {
        return Auth::user();
    }
}