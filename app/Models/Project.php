<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    const STATUS = [
        'Inactive' => 0,
        'Active'   => 1,
    ];

    public function user_project()
    {
        return $this->hasMany(UserProject::class, 'project_id', 'id');
    }
    public function task()
    {
        return $this->hasMany(Task::class, 'project_id', 'id');
    }
}
