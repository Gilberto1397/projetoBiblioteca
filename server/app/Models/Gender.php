<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $gender_id
 * @property string $gender_name
 */
class Gender extends Model
{
    protected $table = 'genres';
    protected $primaryKey = 'gender_id';
    public $timestamps = false;

    use HasFactory;
}
