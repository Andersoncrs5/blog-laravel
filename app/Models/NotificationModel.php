<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class NotificationModel extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    public $timestamps = false;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['user_id', 'sender_id', 'reason', 'message', 'is_read'];

    protected $casts = [
        'id' => 'string'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($notification) 
        {
            do 
            {
                $uuid = Str::uuid()->toString();
            } 
            while (self::where('id', $uuid)->exists());

            $notification->id = $uuid;
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'sender_id');
    }
}
