<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetHistory extends Model
{
    use HasFactory;

    protected $table = 'asset_history';
    protected $fillable = [
        'assetid',
        'status',
        'employeeid',
        'type',
        'allocated_date',
        'reason',
        'remark',
        'get_back_date',
        'retiraldate',
        'location',
        'created_at',
        'updated_at'

    ];
}
