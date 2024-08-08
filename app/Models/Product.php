<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Veritabanı bağlantı adı.
     *
     * @var string
     */
    protected $connection = 'mysqlSource';

    public function getBrand()
    {
        return $this->belongsTo(Brand::class, 'Brand', 'BrandID');
    }


}
