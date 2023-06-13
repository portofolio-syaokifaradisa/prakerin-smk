<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agency extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'region_id',
        'leader',
        'nip',
        'characteristic',
        'limit'
    ];

    public function Region(){
        return $this->belongsTo(Region::class);
    }

    protected $appends = [
        'current_limit',
    ];

    public function getCurrentLimitAttribute()
    {
        $applicationLetters = ApplicationLetter::where('agency_id', $this->id)->get();
        
        $currentLimit = 0;
        $letters_number = [];
        foreach($applicationLetters as $applicationLetter){
            if(!in_array($applicationLetter->letter_number, $letters_number)){
                $letters_number[] = $letters_number;
                $students_application_letter = ApplicationLetter::where('letter_number', $applicationLetter->letter_number)->get();
                foreach($students_application_letter as $student_application_letter){
                    if(Evaluation::where('student_id', $student_application_letter->student_id)->count() == 0){
                        $currentLimit++;
                    }
                }
            }
        }

        return $currentLimit;
    }
}
