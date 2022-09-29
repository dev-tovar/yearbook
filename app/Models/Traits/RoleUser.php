<?php

namespace App\Models\Traits;

trait RoleUser
{
    public function hasRole($roleName)
    {
        if (gettype($roleName) == 'string') {
            return $this->roles->where('key', $roleName)->first() !== null;
        } elseif (gettype($roleName) == 'array') {
            return $this->roles->whereIn('key', $roleName)->first() !== null;
        } else {
            return false;
        }
    }
}