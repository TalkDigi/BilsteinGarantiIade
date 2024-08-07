<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $table = 'complaints';

    protected $fillable = [

        'status',
        'title',

    ];

    public function types()
    {
        return $this->belongsToMany(Type::class, 'complaint_type');
    }

}
