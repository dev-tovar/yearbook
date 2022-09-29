<?php

namespace App\Providers;


use App\Models\Admin;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class CustomAdminProvider implements UserProvider
{
    private $admin = null;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function retrieveById($identifier)
    {
        return $this->admin;
    }

    public function retrieveByToken($identifier, $token)
    {
        return $this->admin;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        return $this->admin;
    }

    public function retrieveByCredentials(array $credentials)
    {
        return $this->admin;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return $this->admin;
    }
}