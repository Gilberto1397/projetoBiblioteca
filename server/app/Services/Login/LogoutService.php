<?php

namespace App\Services\Login;

use Illuminate\Support\Facades\Auth;

class LogoutService
{
    /**
     * @return object
     */
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return (object)[
            'message' => 'Logout efetuado com sucesso!',
            'statusCode' => 200,
            'error' => false
        ];
    }
}
