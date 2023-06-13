<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'date',
        'in',
        'out',
        'isPermit',
        'isAlpha',
        'isSick',
        'description',
        'application_letter_id'
    ];

    public function Student(){
        return $this->belongsTo(Student::class);
    }

    public function application_letter(){
        return $this->belongsTo(ApplicationLetter::class);
    }
}
