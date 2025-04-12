<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecoverPasswordModel extends Model
{
    protected $table = 'recover_password';

    public $timestamps = false;

    protected $fillable = [
        'token',
        'email',
        'created_at',
        'expire_at',
        'status',
        'user_id',
    ];
}
