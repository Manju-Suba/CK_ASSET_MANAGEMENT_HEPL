<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetsModel extends Model
{
	protected $table = 'assets';


    protected $fillable = [
        'assetid',
        'business_id',
        'a_c_id',
        'type',
        'a_type_id',
        'port_no',
        'locationid',
        'brandid',
        'barcode',
        'cost_center',
        'ip_address',
        'name',
        'quantity',
        'cost',
        'warranty',
        'available_status',
        'emp_id',
        'status',
        'description',
        'Asset_Domain',
        'CPU_Model',
        'CPU_Configuration',
        'cpu_si',
        'host_name',
        'cpu_sservice_tag',
        'RAM',
        'HDD',
        'Keyboard',
        'MOUSE',
        'OS',
        'created_at',
        'updated_at',
        'created_by'

    ];

	 public function getStatusAttribute($value)
    {
        return  [$value];
    }

}
