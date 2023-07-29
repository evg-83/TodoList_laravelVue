<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
    ];

    protected $guarded = false;

    // public function todolists()
    // {
    //     return $this->belongsToMany( Task::class, 'task_tags', );
    // }
}
