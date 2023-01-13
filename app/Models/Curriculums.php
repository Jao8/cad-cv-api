<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curriculums extends Model
{
    use HasFactory, SoftDeletes;

    //Status Table relationship
    public function status()
    {
        return $this->hasOneThrough(Status::class, CurriculumsStatus::class, 'curriculum_id', 'id', 'id', 'id');
    }

    //User Table relationship
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    //Role Table relationship
    public function role()
    {
        return $this->hasOne(Roles::class, 'id', 'role_id');
    }
}
