<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idUser';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'user_id', 'idUser');
    }

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'idUser';
    }
}
