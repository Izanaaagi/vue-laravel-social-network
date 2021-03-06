<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y.m.d H:i',
        'updated_at' => 'datetime:Y.m.d H:i'
    ];

    public function from()
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
