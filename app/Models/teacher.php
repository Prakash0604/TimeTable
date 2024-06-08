<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class teacher extends Model
{
    use HasFactory;
    protected $fillable=['teacher_name','subject_id','grade_id','image','status'];
    public function subject(){
        return $this->belongsTo(subject::class,'subject_id','id');
    } public function grade(){
        return $this->belongsTo(grade::class,'grade_id','id');
    }
}
