<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'priority',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'category_task');
    }
    public function favoraiteByUser(){
        return $this->belongsToMany(User::class, 'favorites');
    }
}
