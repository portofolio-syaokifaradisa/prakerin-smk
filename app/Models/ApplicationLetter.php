<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationLetter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'agency_id',
        'student_id',
        'status',
        'start_date',
        'end_date',
        'letter_number'
    ];

    public function Student(){
        return $this->BelongsTo(Student::class);
    }

    public function Agency(){
        return $this->belongsTo(Agency::class);
    }
}
