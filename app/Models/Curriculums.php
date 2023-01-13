<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curriculums extends Model
{
    use HasFactory, SoftDeletes;

    public function status()
    {
        return $this->hasOneThrough(Status::class, CurriculumsStatus::class, 'curriculum_id', 'id', 'id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function role()
    {
        return $this->hasOne(Roles::class, 'id', 'role_id');
    }
}
