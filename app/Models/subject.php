<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class subject extends Model
{
    use HasFactory;
    protected $fillable=['subject_name','description','status'];
}
