<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Closure extends Model
{
    use HasFactory;

    protected $table = 'closures';

    protected $fillable = [
        'uuid',
        'month',
        'year',
        'CustNo',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CustNo', 'No');
    }

}
