<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

use App\EmployeesModel;
use DB;


class ImportEmployee implements ToModel, WithHeadingRow,SkipsEmptyRows
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        // return new EmployeesModel([

        // if($row['status'] == "0"){
        //     $status = "Deleted";
        // }else{
        //     $status = "Active";
        // }

        // $avai_emp_check = DB::table('employees')->where('emp_id',$row['emp_id'] )->get();

        // if(isset($avai_emp_check[0])){
        //     $available_emp_id = $avai_emp_check[0]->emp_id;
        // }else{


            if($row['payroll_status'] !=""){
                $business = DB::table('business_models')->where("name",$row['payroll_status'])->where('status','Active')->get();
                $business_id = $business[0]->id;

                $dep = DB::table('department')->where("name",$row['department'])->where('b_id',$business_id )->where('status','Active')->get();
            }else{
                $business_id = $row['payroll_status'] ;
            }

            if($row['designation'] == ""){
                $jobrole = "";
            }else{
                $jobrole = $row['designation'] ;
            }

            if($row['employee_status'] !=""){
                $status = $row['employee_status'];
            }else{
                $status = "Active";
            }

            $emp_words          = $row['employee_id'];
            $emp_id = trim($emp_words);

            return EmployeesModel::updateOrCreate(
                [
                    'emp_id' => $emp_id,
                ],
                [
                    'business' => $business_id,
                    'departmentid' => $dep[0]->id,
                    'fullname' => $row['first_name'],
                    'email' => $row['official_email'],
                    'jobrole' => $jobrole,
                    'city' => '',
                    'country' => '',
                    'address' => '',
                    'cost_center' => '',
                    'specialrole' => '',
                    'supervisor' => '',
                    'status' => $status

                ]
            );

        // }
    }




}
