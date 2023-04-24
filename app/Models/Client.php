<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable =[
            'first_name',
            'last_name',
            'username' ,
            'email',
            'password',
            'phone',
            'company_name',
            'position',
            'photo'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
