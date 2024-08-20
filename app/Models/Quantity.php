<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{
    use HasFactory;

    //table
    protected $table = 'quantities';
    //fillable
    protected $fillable = ['ItemNo','unit','file_id'];
}
