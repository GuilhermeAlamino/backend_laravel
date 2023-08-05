<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'tb_departments';

    protected $fillable = ['name'];

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->orWhere('name', 'like', "%$searchTerm%");
        });
    }
}
