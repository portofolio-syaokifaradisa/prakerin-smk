<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GradeClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'grade',
        'department_id'
    ];

    public function Department(){
        return $this->belongsTo(Department::class);
    }
}
