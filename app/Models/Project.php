<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function teams(){
        return $this->belongsToMany(Team::class, 'team_project', 'project_id', 'team_id');
    }

    public function sprints(){
        return $this->hasMany(Sprint::class, 'project_id');
    }
}
