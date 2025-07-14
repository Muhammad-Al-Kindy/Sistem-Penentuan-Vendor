<?php

namespace App\Models\Traits;

trait HasRoles
{
    /**
     * Check if user has admin role
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has vendor role
     */
    public function isVendor()
    {
        return $this->role === 'vendor';
    }
}
