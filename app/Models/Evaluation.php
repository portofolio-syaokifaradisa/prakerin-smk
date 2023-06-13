<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'teori',
        'keterampilan',
        'keselamatan',
        'disiplin',
        'sikap'
    ];

    protected $appends = [
        'mean_score',
        'final_score'
    ];

    public function getMeanScoreAttribute()
    {
        return ($this->teori + $this->keterampilan + $this->keselamatan + $this->disiplin + $this->sikap)/5;
    }

    public function getFinalScoreAttribute()
    {
        $mean = $this->mean_score;
        if($mean >= 90 && $mean <= 100){
            return "A (Sangat Baik)";
        }else if($mean >= 80 && $mean < 90){
            return "B (Baik)";
        }else if($mean >= 70 && $mean < 80){
            return "C (Cukup)";
        }else{
            return "D (Kurang)";
        }
    }
}
