<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StudentReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'status',
        'student_id'
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    protected $append = [
        'is_guidance'
    ];

    public function getIsGuidanceAttribute(){
        $student = $this->student;
        return $student->mentor ? $student->mentor->mentor->teacher_id == Auth::user()->information->id : false;
    }
}
