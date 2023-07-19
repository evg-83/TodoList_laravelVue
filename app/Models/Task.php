<?php

namespace App\Models;

use App\Models\TodoList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'todolist_id',
        'title',
        'imageTask',
    ];

    protected $guarded = false;

    public function todolist()
    {
        return $this->belongsTo( TodoList::class, 'todolist_id', 'id');
    }
}
