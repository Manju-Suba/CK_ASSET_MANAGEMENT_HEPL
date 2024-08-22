<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Session;
use Auth;
use App\AssetsModel;
use DB;

class ImportAsset implements ToModel, WithHeadingRow,SkipsEmptyRows
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
            if($row['asset_domain'] !=""){
                $business = DB::table('business_models')->where("name",$row['asset_domain'])->where('status','Active')->get();
                $business_id = $business[0]->id;
            }else{
                $business_id = $row['asset_domain'] ;
            }

            $location = DB::table('location')->where("name",$row['location'])->where('status','Active')->get();

            // if($row['category_id'] !=""){
            //     $category = DB::table('asset_category_models')->where("name",$row['category_id'])->where('status','Active')->get();
            //     $category_id = $category[0]->id;
            // }else{
            //     $category_id = $row['category_id'] ;
            // }

            if($row['access_type'] !=''){
                $asset_type = DB::table('asset_type')->where("name",$row['access_type'])->where('status','Active')->get();
                $asset_type_id = $asset_type[0]->id;
            }else{
                $asset_type_id = $row['access_type'] ;
            }

            if($row['brand'] !=''){
                $brand = DB::table('brand')->where("name",$row['brand'])->where('status','Active')->get();
                $brand_id = $brand[0]->id;
            }else{
                $brand_id = $row['brand'] ;
            }

            $category_id = '1';

            if($row['employee_id'] !="" && $row['employee_id'] !="Nil" && $row['employee_id'] !="No User" && $row['user_name'] !="Damage"){
                $emp_words = $row['employee_id'];
                $emppp = trim($emp_words);
                $available_status = 'Allocated';
            }
            else if($row['user_name'] =="Damage"){
                $emppp ="";
                $available_status = 'Retiral';
            }
            else{
                $emppp ="";
                $available_status = 'Stock';
            }

            $asset_words = $row['asset_id'] ;
            $assetid = trim($asset_words);

            return AssetsModel::updateOrCreate(
                [
                    'assetid' => $assetid,
                ],
                [
                    'business_id' => $business_id,
                    'type'        => $row['asset_type_locate'],
                    'a_c_id' => $category_id,
                    'a_type_id' => $asset_type_id,
                    'port_no' => $row['port_no'],
                    'locationid' => $location[0]->id,
                    'brandid' => $brand_id,
                    'barcode' => $assetid,
                    'cost_center' => '',
                    'ip_address' => '',
                    'name' => $row['access_type'],
                    'quantity' => '',
                    'cost' => '',
                    'warranty' => '',
                    'emp_id' => $emppp,
                    'available_status' => $available_status,
                    'status' => 'Active',
                    'description' => '',
                    'Asset_Domain' => $row['asset_domain'],
                    'CPU_Model' => $row['system_names'],
                    'CPU_Configuration' => $row['cpu_configuration'],
                    'cpu_si' => $row['cpu_slservice_tag'],
                    'host_name' => $row['host_name'],
                    'RAM' => $row['ram'],
                    'HDD' => $row['hdd'],
                    'Keyboard' => $row['keyboard'],
                    'MOUSE' => $row['mouse'],
                    'OS' => $row['os'],
                    'mon_serial' => $row['monitor_service_tag'],
                    'created_by' => Auth::user()->email,
                ]
            );


    }


}
