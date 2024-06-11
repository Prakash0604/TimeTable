<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class timetable extends Model
{
    use HasFactory;
    protected $fillable=['teacher_id','starting_date','ending_date','starting_time','ending_time','day_of_week'];
    public function teacher(){
        return $this->belongsTo(teacher::class,'teacher_id','id');
    }
    public function subject(){
        return $this->belongsTo(subject::class);
    }
}
