<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mentor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['teacher_id', 'region_id'];

    public function Teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function Region(){
        return $this->belongsTo(Region::class);
    }

    public function StudentMentor(){
        return $this->hasMany(StudentMentor::class);
    }
}
