<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function projects(){
        return $this->belongsToMany(Project::class, 'team_project', 'team_id', 'project_id');
    }
    public function users(){
        return $this->hasMany(User::class, 'team_id');
    }
}
