<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temp_asset_qr extends Model
{
    //
    protected $fillable = [ 
        'asset_code', 
        'asset_name', 
    ];
}
