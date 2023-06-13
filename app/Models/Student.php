<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'nisn', 'grade_class_id', 'user_id'];

    public function grade_class(){
        return $this->belongsTo(GradeClass::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Evaluation(){
        return $this->hasOne(Evaluation::class);
    }
    
    public function Journal(){
        return $this->hasMany(Journal::class);
    }

    public function student_report(){
        return $this->hasMany(StudentReport::class);
    }

    public function application_letter(){
        return $this->hasMany(ApplicationLetter::class);
    }

    protected $appends = [
        'mentor',
    ];

    public function getMentorAttribute()
    {
        $studentMentor = StudentMentor::where('student_id', $this->id)->get()->first();
        return $studentMentor;
    }
}
