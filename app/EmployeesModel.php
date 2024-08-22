<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeesModel extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'emp_id',
        'business',
        'departmentid',
        'fullname',
        'email',
        'jobrole',
        'city',
        'country',
        'address',
        'cost_center',
        'specialrole',
        'supervisor',
        'status',
        'created_at',
        'updated_at'

    ];

}
