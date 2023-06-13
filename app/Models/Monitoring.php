<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'description',
        'application_letter_id',
        'teacher_id'
    ];

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function application_letter(){
        return $this->belongsTo(ApplicationLetter::class);
    }
}
