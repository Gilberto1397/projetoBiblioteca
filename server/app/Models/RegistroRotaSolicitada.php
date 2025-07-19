<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_request
 * @property string $route
 * @property string $method
 * @property int $user_requesting
 * @property string $host_request
 * @property string $user_agent
 * @property \DateTime $date_request
 */
class RegistroRotaSolicitada extends Model
{
    use HasFactory;

    protected $table = 'registerrequestedroutes';
    protected $primaryKey = 'id_request';
    public $timestamps = false;
}
