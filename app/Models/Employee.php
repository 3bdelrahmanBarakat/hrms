<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function schedules()
    {
        return $this->belongsToMany('App\Models\Schedule', 'schedule_employees', 'employee_id', 'schedule_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withTimestamps();
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class)->withTimestamps();
    }
}
