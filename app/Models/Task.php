<?php

namespace App\Models;

use App\Models\Tag;
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
        'completed',
        'completed_at',
    ];

    protected $guarded = false;

    public function todolist()
    {
        return $this->belongsTo( TodoList::class, 'todolist_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany( Tag::class, 'task_tags', 'task_id', 'tag_id');
    }
}
