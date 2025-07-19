<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_cpf
 * @property string $user_email
 * @property \DateTime $user_email_verified_at
 * @property string $user_password
 * @property string $user_telephone
 * @property \DateTime $user_date_birth
 * @property \DateTime $user_register_last_update
 * @property bool $user_register_active
 * @property int $user_userole_id
 * @property string $remember_token
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    /**
     * Specifies the name of the column that stores the password.
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->user_password;
    }
}
