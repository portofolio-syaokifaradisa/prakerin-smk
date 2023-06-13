<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'activity',
        'application_letter_id',
        'student_id'
    ];

    public function Student(){
        return $this->belongsTo(Student::class);
    }

    public function application_letter(){
        return $this->belongsTo(ApplicationLetter::class);
    }
}
