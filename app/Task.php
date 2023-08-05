<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tb_tasks';

    protected $fillable = ['title', 'description', 'assignee_id', 'due_date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'assignee_id');
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->orWhereHas('employee', function ($query) use ($searchTerm) {
                $query->where('email', 'like', "%$searchTerm%");
            });

            $columns = ['title', 'description'];

            foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%$searchTerm%");
            }
        });
    }
}
