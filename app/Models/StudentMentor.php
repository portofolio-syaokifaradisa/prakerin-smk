<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentMentor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'mentor_id'
    ];

    public function Student(){
        return $this->belongsTo(Student::class);
    }

    public function Mentor(){
        return $this->belongsTo(Mentor::class);
    }

    public function Journal(){
        return $this->hasMany(Journal::class);
    }
}
