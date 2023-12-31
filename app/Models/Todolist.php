<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
    ];

    protected $guarded = false;

    public function user()
    {
        return $this->belongsTo( User::class, 'user_id', 'id');
    }
}
