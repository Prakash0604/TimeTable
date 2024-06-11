<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class subject extends Model
{
    use HasFactory;
    protected $fillable=['subject_name','description','status'];
    public function teacher(){
        return $this->hasMany(teacher::class);
    }

    public function timetable(){
        return $this->hasMany(timetable::class);
    }
}
