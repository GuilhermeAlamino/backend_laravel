<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'tb_employees';

    protected $fillable = ['firstName', 'lastName', 'email', 'phone', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->orWhereHas('department', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%");
            });

            $columns = ['firstName', 'lastName', 'email', 'phone'];

            foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%$searchTerm%");
            }
        });
    }
}
