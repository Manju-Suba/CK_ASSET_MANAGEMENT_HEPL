<?php

namespace App\Imports;

use App\Temp_asset_qr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Milon\Barcode\DNS2D;


class Asset_Qr_Import implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //
        // echo $asset_code = $row['asset_code'];

        return Temp_asset_qr::updateOrCreate([
                'asset_code'     => $row['asset_code'],
                'asset_name'    => $row['name_of_asset'], 
        ]);

        
    }
}
