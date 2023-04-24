<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function teamLeader()
    {
        return $this->belongsTo(Employee::class, 'team_leader_id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class)->withTimestamps();
    }

    public function clients()
    {
        return $this->belongsTo(Client::class);
    }
}
