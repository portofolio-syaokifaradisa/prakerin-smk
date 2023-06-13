<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'nip', 'position', 'user_id', 'grade_class_id'];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function grade_class(){
        return $this->belongsTo(GradeClass::class);
    }
}
