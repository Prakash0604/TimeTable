<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class grade extends Model
{
    use HasFactory;
    protected $fillable=['grade_name','description','status'];
    public function teacher(){
        return $this->hasMany(teacher::class,'grade_id','id');
    }
    public function subject(){
        return $this->belongsTo(subject::class);
    }
}
