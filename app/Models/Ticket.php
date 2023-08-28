<?php

namespace App\Models;

use App\Scopes\OrderByOrderScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'estimation',
        'status',
        'order',
        'sprint_id',
        'assignee_user_id',
        'assigned_user_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new OrderByOrderScope());
    }
}
