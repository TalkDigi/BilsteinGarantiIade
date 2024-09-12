<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'types';


    public function complaints()
    {
        return $this->belongsToMany(Complaint::class, 'complaint_type');
    }


    public function applications()
    {
        if (auth()->user()->hasRole('Yönetici')) {
            return $this->hasMany(Application::class, 'type');
        } else {
            return $this->hasMany(Application::class, 'type')->where('user_id', auth()->id());
        }
    }

    public function application_counts()
    {
        if (auth()->user()->hasRole('Yönetici')) {
            return $this->applications()->count();
        } else {
            return $this->applications()->where('user_id', auth()->id())->count();
        }
    }

    public function non_viewed_counts()
    {
        if (auth()->user()->hasRole('Yönetici')) {
            return $this->applications()->whereNull('viewed_by')->count();
        } else {
            return $this->applications()->where('user_id', auth()->id())->whereNull('viewed_by')->count();
        }
    }

}
