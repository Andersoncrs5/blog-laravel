<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $table = 'user'; 

    protected $fillable = ['name', 'email', 'password', 'is_adm']; 

    protected $guarded = []; 

    public $timestamps = true; 

    public function posts()
    {
        return $this->hasMany(PostModel::class, 'user_id', 'id');
    }

}
