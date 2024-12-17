<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'contant',
        'status',
        'rating',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
