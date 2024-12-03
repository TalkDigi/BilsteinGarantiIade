<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $connection = 'mysqlSource';

    public function branches()
{
    return $this->hasMany(Branch::class, 'CustNo', 'No');
}
}
