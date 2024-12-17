<?php

namespace App\Models;
use App\Models\TeacherDirection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = 'record';

    protected $fillable = [
        'id_user',
        'id_td',
        'date_record',
        'time_record',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function td()
    {
        return $this->belongsTo(TeacherDirection::class, 'id_td');
    }
}
