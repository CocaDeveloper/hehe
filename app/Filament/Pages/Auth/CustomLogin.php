<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CustomLogin extends BaseLogin
{
    public function authenticate(): LoginResponse
    {
        $credentials = $this->form->getState();

        $user = User::where('email', $credentials['email'])
            ->where('user_pass', $credentials['password'])
            ->first();

        if (!$user) {
            $this->addError('email', __('Credenciais inválidas.'));
            return app(LoginResponse::class); // Volta para a tela de login
        }

        Auth::login($user);

        return app(LoginResponse::class);
    }
}