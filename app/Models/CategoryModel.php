<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $table = 'categories'; 

    protected $fillable = ['name', 'is_active', 'user_id']; 

    protected $guarded = []; 

    public $timestamps = true; 

    public function posts()
    {
        return $this->hasMany(PostModel::class);
    }

}
