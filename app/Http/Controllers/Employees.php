<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmployeesModel;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\TraitSettings;
use App\Http\Requests\ValidateRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportEmployee;
use DB;
use App\User;
use App;
use Auth;
use Session;


class Employees extends Controller
{
    use TraitSettings;

    public function __construct() {

		$data = $this->getapplications();
		// $lang = $data->language;
		// App::setLocale($lang);
        $this->middleware('auth');
    }

    //return page view
    public function index() {
        $business_data = DB::table('business_models')->select(['business_models.*'])->where('status','!=', "Deleted")->get();
		return view( 'employee.index' )->with(['business_data'=>$business_data]);
    }

    public function emp_verify() {
        $business_data = DB::table('business_models')->select(['business_models.*'])->where('status','!=', "Deleted")->get();
		return view( 'employee.employee_verification' )->with(['business_data'=>$business_data]);
    }

    public function returned_asset() {
        $business_data = DB::table('business_models')->select(['business_models.*'])->where('status','!=', "Deleted")->get();
        $users = DB::table('users')->select('*')->where('status','!=', "Deleted")->where('role','=', "4")->get();
		return view( 'employee.returned_assets' )->with(['business_data'=>$business_data,'users'=>$users]);
    }

    public function verified_employee() {
        $business_data = DB::table('business_models')->select(['business_models.*'])->where('status','!=', "Deleted")->get();
        $users = DB::table('users')->select('*')->where('status','!=', "Deleted")->where('role','=', "4")->get();

		return view( 'employee.verified_employee' )->with(['business_data'=>$business_data,'users'=>$users]);
    }

    public function holdemployee() {
        // $business_data = DB::table('business_models')->select(['business_models.*'])->where('status','!=', "Deleted")->get();
        $users = DB::table('users')->select('*')->where('status','!=', "Deleted")->where('role','=', "4")->get();
		return view( 'employee.hold_employees' )->with(['users'=>$users]);
    }

    /**
	 * get data from database
	 * @return object
	 */
    public function getdata(){

        if(Auth::user()->role == "5" || Auth::user()->role == "7"){
            $busii = auth()->user()->domain ;
            $busiii = explode(",",$busii);
            $busii_id = DB::table('business_models')->select('*')->whereIn('name', $busiii)->where('status','Active')->get();

            foreach($busii_id as $val){
                $bus[] = $val->id;
            }

            $ids = join("','",$bus);

            $data = DB::select("select employees.*,
            department.name as department ,business_models.name as businessid
            from employees
            left join department on employees.departmentid = department.id
            left join business_models on employees.business = business_models.id
            where employees.status!='Deleted' and employees.business In ('$ids') order by employees.id desc ");

        }else{
            $data = DB::select("select employees.*,
            department.name as department ,business_models.name as businessid
            from employees
            left join department on employees.departmentid = department.id
            left join business_models on employees.business = business_models.id
            where employees.status!='Deleted' order by employees.id desc ");
        }

        return Datatables::of($data)

		->addColumn( 'action', function ( $accountsingle ) {
            return '<a href="#" id="btnedit" customdata='.$accountsingle->id.' class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit"><i class="fa fa-pencil"></i> '. trans('lang.edit').'</a>
                    <a href="#" id="btndelete" customdata='.$accountsingle->id.' class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete"><i class="fa fa-trash"></i> '. trans('lang.delete').'</a>';
        } )->rawColumns(['gender','picture', 'action'])
        ->make(true);
    }

    public function get_emp_data(){

        if(Auth::user()->user_id =="INFRA-005"){
            $data = DB::table('employee_verification_models')
            ->where('emp_status','=','Active')
            ->Where(function ($query) {
                $query->orwhere('band','=','Band 3')
                      ->orwhere('band','=','Band 4')
                      ->orwhere('band','=','Band 5');
            })->get();
        }
        elseif(Auth::user()->role =="itinfra_audit"){
            $data = DB::table('employee_verification_models')
            ->where('employee_verification_models.emp_status','=','Active')
            ->get();
        }
        else{
            $data = DB::table('employee_verification_models')
            ->where('band','!=','Band 1')
            ->where('band','!=','Band 2')
            ->where('band','!=','Band 3')
            ->where('band','!=','Band 4')
            ->where('band','!=','Band 5')
            ->where('emp_status','=','Active');
        }

        return Datatables::of($data)
		->addColumn( 'action', function ( $accountsingle ) {
            return '<a href="#" id="btnedit" customdata='.$accountsingle->id.' onclick="asset_table('."'".$accountsingle->emp_id."'".','."'".$accountsingle->id."'".','."'".$accountsingle->fullname."'".')" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit"><i class="fa fa-pencil"></i>Edit</a>';
        } )->rawColumns(['gender','picture', 'action'])
        ->make(true);
    }

    public function get_verified_data(Request $request){

        if(Auth::user()->user_id =="INFRA-005"){
            $data = DB::table('employee_verification_models')
            ->where('emp_status','=','Verified')
            ->where('verified_by','=',Auth::user()->user_id)
            ->Where(function ($query) {
                $query->orwhere('band','=','Band 3')
                      ->orwhere('band','=','Band 4')
                      ->orwhere('band','=','Band 5');
            })->get();
        }elseif(Auth::user()->role =="itinfra_audit"){
            if($request->id){
                if($request->id=="0"){
                    $data = DB::table('employee_verification_asset_models')
                   ->select('employee_verification_asset_models.*','employee_verification_models.*','employee_verification_asset_models.id as asset_verify_id')
                    ->leftjoin('employee_verification_models', 'employee_verification_models.emp_id' , '=', 'employee_verification_asset_models.emp_id')
                    ->where('employee_verification_models.emp_status','=','Verified')
                    ->where('employee_verification_asset_models.returned_status','!=',"Returned")
                    ->get();
                }else{
                    $data = DB::table('employee_verification_asset_models')
                    ->select('employee_verification_asset_models.*','employee_verification_models.*','employee_verification_asset_models.id as asset_verify_id')
                    ->leftjoin('employee_verification_models', 'employee_verification_models.emp_id' , '=', 'employee_verification_asset_models.emp_id')
                    ->where('employee_verification_models.emp_status','=','Verified')
                    ->where('employee_verification_models.verified_by','=',$request->id)
                    ->where('employee_verification_asset_models.returned_status','!=',"Returned")
                    ->get();
                }
            }else{
            $data = DB::table('employee_verification_asset_models')
            ->select('employee_verification_asset_models.*','employee_verification_models.*','employee_verification_asset_models.id as asset_verify_id')
            ->join('employee_verification_models','employee_verification_models.emp_id' , '=', 'employee_verification_asset_models.emp_id')
            ->where('employee_verification_asset_models.returned_status','!=',"Returned")
            ->where('employee_verification_models.emp_status','=',"Verified")
            ->get();
            }
        }
        else{
            $data = DB::table('employee_verification_models')
            ->where('verified_by','=',Auth::user()->user_id)
            ->where('band','!=','Band 1')
            ->where('band','!=','Band 2')
            ->where('band','!=','Band 3')
            ->where('band','!=','Band 4')
            ->where('band','!=','Band 5')
            ->where('emp_status','=','Verified');
        }
        return Datatables::of($data)

        ->addColumn('have_asset', function($row){
            if(Auth::user()->role =="itinfra_audit"){
                if($row->asset_type =="" && $row->a_brand =="" && $row->a_model =="" && $row->serial_no =="" && $row->assetid =="" && $row->category =="" && $row->dongle =="" && $row->spec_ram =="" && $row->storage ==""){
                    $have_asset="No";
                }else{
                    $have_asset="Yes";
                }
                return $have_asset;
            }
        })
        ->addColumn( 'returned', function ( $row ) {
            if(Auth::user()->role =="itinfra_audit"){
                if($row->asset_type =="" && $row->a_brand =="" && $row->a_model =="" && $row->serial_no =="" && $row->assetid =="" && $row->category =="" && $row->dongle =="" && $row->spec_ram =="" && $row->storage ==""){
                    return '<a href="#" title="This Employee have not Asset"  class="btn btn-sm btn-secondary">No Asset</a>';
                }else{
                    return '<a href="#"  customdata='.$row->id.' class="btn btn-sm btn-primary" onclick="get_asset_details('."'".$row->emp_id."'".','."'".$row->asset_verify_id."'".','."'".$row->fullname."'".','."'".$row->email."'".','."'".$row->assetid."'".','."'".$row->asset_type."'".','."'".$row->category."'".','."'".$row->mobile."'".','."'".$row->role."'".','."'".$row->a_brand."'".','."'".$row->a_model."'".','."'".$row->serial_no."'".','."'".$row->category."'".','."'".$row->dongle."'".','."'".$row->band."'".','."'".$row->grade."'".','."'".$row->division."'".','."'".$row->spec_ram."'".','."'".$row->storage."'".','."'".$row->work_from_home."'".','."'".$row->city."'".','."'".$row->office_city."'".')" data-toggle="modal" data-target="#returned_status">Return</a>';
                }
            }
        } )
		->addColumn( 'action', function ( $accountsingle ) {
            return '<a href="#" id="btnedit" customdata='.$accountsingle->id.' class="btn btn-sm btn-primary" onclick="asset_table('."'".$accountsingle->emp_id."'".','."'".$accountsingle->id."'".','."'".$accountsingle->fullname."'".')" data-toggle="modal" data-target="#edit"><i class="fa fa-pencil"></i> Update</a>';
        } )->rawColumns(['action','returned'])
        ->make(true);
    }



    public function get_returned_assets(Request $request){

            if($request->id){
                if($request->id=="0"){
                    $data = DB::table('employee_verification_asset_models')
                    ->leftjoin('employee_verification_models', 'employee_verification_models.emp_id' , '=', 'employee_verification_asset_models.emp_id')
                    ->where('employee_verification_models.emp_status','=','Verified')
                    ->where('employee_verification_asset_models.returned_status','Returned')
                    ->get();
                }else{
                    $data = DB::table('employee_verification_asset_models')
                    ->leftjoin('employee_verification_models', 'employee_verification_models.emp_id' , '=', 'employee_verification_asset_models.emp_id')
                    ->where('employee_verification_models.emp_status','=','Verified')
                    ->where('employee_verification_models.verified_by','=',$request->id)
                    ->where('employee_verification_asset_models.returned_status','Returned')
                    ->get();
                }
            }else{
                $data = DB::table('employee_verification_asset_models')
                ->leftjoin('employee_verification_models', 'employee_verification_models.emp_id' , '=', 'employee_verification_asset_models.emp_id')
                ->where('employee_verification_models.emp_status','=','Verified')
                ->where('employee_verification_asset_models.returned_status','Returned')
                ->get();
            }
        return Datatables::of($data)
        ->addColumn('have_asset', function($row){
            if(Auth::user()->role =="itinfra_audit"){
                if($row->asset_type =="" && $row->a_brand =="" && $row->a_model =="" && $row->serial_no =="" && $row->assetid =="" && $row->category =="" && $row->dongle =="" && $row->spec_ram =="" && $row->storage ==""){
                    $have_asset="No";
                }else{
                    $have_asset="Yes";
                }
                return $have_asset;
            }
        })
        ->addColumn( 'returned', function ( $accountsingle ) {
            return '<a href="#" id="btnedit" customdata='.$accountsingle->id.' class="btn btn-sm btn-primary" onclick="get_asset_details('."'".$accountsingle->emp_id."'".','."'".$accountsingle->id."'".','."'".$accountsingle->fullname."'".')" data-toggle="modal" data-target="#returned_status">Returned</a>';
        } )->rawColumns(['action','returned'])
        ->make(true);
    }
    /**
	 * get all  from database
	 * @return object
	 */
    public function getrows(){
        $data = DB::table('employees')->where('status','!=', "Deleted")->get();
        if ( $data ) {
			$res['success'] = true;
			$res['message']= $data;
        }
        return response( $res );
    }

    /**
	 * get all  from database
	 * @return object
	 */
    public function get_sup_rows_d_dept(Request $request ){
        $business            = $request->input( 'business' );
        $department            = $request->input( 'department' );

        // $head_data = DB::table('employees')->where("business",$business)->where("departmentid",$department)->where("specialrole","Supervisor")->get();

        $head_data = DB::table('employees')->where('status','!=', "Deleted")->where("specialrole","Supervisor")->get();

        $sup_div='<option value="">Supervisor</option>';
        foreach ($head_data as $key => $head_data) {
                $sup_div.='<option value="'.$head_data->emp_id.'">'.$head_data->fullname.' / '.$head_data->emp_id.' </option>';
        }

        if ( $head_data ) {
			$res['success'] = true;
			$res['sup_div']= $sup_div;
        }

        return response( $res );
    }

    /**
	 * get single data
	 * @param integer $id
	 * @return object
	 */

    public function byid( Request $request ) {
        $id  = $request->input( 'id' );

        $data = DB::table('employees')->where('id', $id)->first();


        $business_data = DB::table('business_models')->where("status","Active")->get();

        // $business_div='<option value="">Business</option>';
        $business_div='';
        foreach ($business_data as $key => $business) {
            if ($business->id==$data->business)
            {
                $business_div.='<option value="'.$business->id.'" selected>'.$business->name.' </option>';
            }
            else{
                $business_div.='<option value="'.$business->id.'">'.$business->name.' </option>';
            }
        }

        $department_data = DB::table('department')->where("status","Active")->where('b_id',$data->business)->get();

        // $dept_div='<option value="">Department</option>';
        $dept_div='';
        foreach ($department_data as $key => $dept) {
            if ($dept->id==$data->departmentid)
            {
                $dept_div.='<option value="'.$dept->id.'" selected>'.$dept->name.' </option>';
            }
            else{
                $dept_div.='<option value="'.$dept->id.'">'.$dept->name.' </option>';
            }
        }

        $head_data = DB::table('employees')
        // ->where("departmentid",$data->departmentid)
        ->where('id','!=', $id)
        ->where("specialrole","Supervisor")
        ->where("status","Active")
        ->get();

        $superior_div='<option value="">Supervisor</option>';
        foreach ($head_data as $key => $head) {
            if ($head->emp_id==$data->supervisor)
            {
                $superior_div.='<option value="'.$head->emp_id.'" selected>'.$head->fullname.' / '.$head->emp_id.' </option>';
            }
            else{
                $superior_div.='<option value="'.$head->emp_id.'">'.$head->fullname.' / '.$head->emp_id.' </option>';
            }
        }

        // special role or not
        $spec_role_arr=array("No","Supervisor");
        $spe_role_div='<option value="">Choose Special Role</option>';
        $i=0;
        foreach ($spec_role_arr as $key => $spec_role) {
            if ($spec_role==$data->specialrole)
            {
                $spe_role_div.='<option value="'.$spec_role_arr[$i].'" selected>'.$spec_role_arr[$i].'</option>';
            }
            else{
                $spe_role_div.='<option value="'.$spec_role_arr[$i].'">'.$spec_role_arr[$i].' </option>';
            }
            $i++;
        }

        if ( $data ) {
			$res['success'] = 'success';
			$res['message']= $data;
        } else{
            $res['success'] = 'failed';
        }

        $res['dept_div']= $dept_div;
        $res['business_div']= $business_div;
        $res['superior_div']= $superior_div;
        $res['spe_role_div']= $spe_role_div;
        $res['check_special_role']=  $data->specialrole;

        return response( $res );

    }


    public function employees_byid( Request $request ) {
        $id            = $request->input( 'id' );

        $d = DB::table('employee_verification_asset_models')->where('id', $id)->first();

        if($d ==""){
            $data = DB::table('employee_verification_models')->where('id', $id)->first();
        }
        if ( $data ) {
			$res['success'] = 'success';
			$res['message']= $data;
        } else{
            $res['success'] = 'failed';
        }


        $res['data']=  $data;

        return response( $res );

    }

    public function employees_by_id( Request $request ) {
        $id            = $request->input( 'id' );

        $data = DB::table('employee_verification_asset_models')->where('id', $id)->first();

        if ( $data ) {
			$res['success'] = 'success';
			$res['message']= $data;
        } else{
            $res['success'] = 'failed';
        }


        $res['data']=  $data;

        return response( $res );

    }


    /**
	 * insert data  to database
	 *
	 * @param string  $fullname
	 * @param string  $email
     * @param string  $jobrole
     * @param string  $address
     * @param string  $city
     * @param string  $country
     * @param int     $department
     * @return object
	 */
    public function save(Request $request){
        $emp_id       = $request->input( 'emp_id' );
        $fullname       = $request->input( 'fullname' );
        $email          = $request->input( 'email' );
        $business     = $request->input( 'business' );
        $department     = $request->input( 'department' );
        $jobrole        = $request->input( 'jobrole' );
        $city           = "";
        $country        = "";
        $address        = "";
        $cost_center        = $request->input( 'cost_center' );
        $spe_role     = $request->input( 'spe_role' );
        $supervisor     = $request->input( 'supervisor' );
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");
        $created_by     = Auth::user()->email;



        $emailcheck = DB::table('employees')
		    ->where('email', '=', $email)
            ->first();

        if($emailcheck){
            $res['message'] = 'exist';
        }
        else{


                $data       = array(
                            'emp_id'=>$emp_id,
                            'fullname'=>$fullname,
                            'email'=>$email,
                            'jobrole'=>$jobrole,
                            'business'=>$business,
                            'departmentid'=>$department,
                            'country'=>$country,
                            'city'=>$city,
                            'address'=>$address,
                            'cost_center'=>$cost_center,
                            'specialrole'=>$spe_role,
                            'supervisor'=>$supervisor,
                            'status'=>"Active",
                            'created_at'=>$created_at,
                            'created_by'=>$created_by,
                            'updated_at'=>$updated_at);

                $insert     = DB::table( 'employees' )->insert( $data );

            if ( $insert ) {
                $res['message'] = 'success';

            } else{
                $res['message'] = 'failed';
            }
        }
        return response( $res );
    }

    /**
	 * update data  to database
	 *
	 * @param string  $fullname
	 * @param string  $email
     * @param string  $jobrole
     * @param string  $address
     * @param string  $city
     * @param string  $country
     * @param int     $department
	 * @return object
	 */
    public function update(Request $request){
        $id             = $request->input( 'id' );
        $fullname       = $request->input( 'fullname' );
        $email          = $request->input( 'email' );
        $department     = $request->input( 'department' );
        $jobrole        = $request->input( 'jobrole' );
        $city           = $request->input( 'city' );
        $country        = $request->input( 'country' );
        $address        = $request->input( 'address' );

        $specialrole        = $request->input( 'spe_role' );
        $supervisor        = $request->input( 'supervisor' );

        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");

        // echo $specialrole;
        // exit();

        if($specialrole=="No"){
            if($supervisor==""){
                $res['message'] = 'need_all_field';
                return response( $res );
            }

        }
        // else{
        //     $supervisor="";
        // }


        $emailcheck = DB::table('employees')
        ->where('email', '=', $email)
        ->where('id', '!=', $id)
        ->first();

        if($emailcheck){
                $res['message'] = 'exist';
        }
        else{

            $update = DB::table( 'employees' )->where( 'id', $id )
            ->update(
                [
                'fullname'          => $fullname,
                'email'             => $email,
                'departmentid'      => $department,
                'jobrole'           => $jobrole,
                'city'              => $city,
                'country'           => $country,
                'address'           => $address,
                'specialrole'           => $specialrole,
                'supervisor'           => $supervisor,
                'updated_at'        => $updated_at
                ]
            );

            if ( $update ) {
                $res['message'] = 'success';

            } else{
                $res['message'] = 'failed';
            }
        }
        return response( $res );
    }




    public function emp_update(Request $request){
        if($request->radio1 == "yes"){
            if($request->input( 'asset_type' )=="" &&  $request->input( 'storage' )=="" && $request->input( 'spec_ram' )=="" && $request->input( 'brand' )=="" && $request->input( 'dongle' )=="" && $request->input( 'serial_no' )=="" && $request->input( 'category' )=="" && $request->input( 'model' )=="" && $request->input( 'asset_id' ) ==""){
                    $res['message'] = 'failed';
                    return response( $res );
            }
            else{
               $d_check = DB::table('employee_verification_asset_models')
                ->where('emp_id',$request->emp_id)
                ->where('asset_type',$request->asset_type)
                ->where('a_brand',$request->brand)
                ->where('a_model',$request->model)
                ->where('serial_no',$request->serial_no)
                ->where('assetid',$request->asset_id)
                ->where('category',$request->category)
                ->where('dongle',$request->dongle)
                ->where('remark',$request->remark)
                ->where('spec_ram',$request->spec_ram)
                ->where('storage',$request->storage)
                ->where('created_by',Auth::user()->user_id)
                ->get()->toArray();
                if($d_check != Array ()){
                    exit;
                }else{
                    $data['emp_id'] = $request->emp_id;
                    $data['asset_type'] = $request->asset_type;
                    $data['a_brand'] = $request->brand;
                    $data['a_model'] = $request->model;
                    $data['serial_no'] = $request->serial_no;
                    $data['assetid'] = $request->asset_id;
                    $data['category'] = $request->category;
                    $data['dongle'] = $request->dongle;
                    $data['remark'] = $request->remark;
                    $data['spec_ram'] = $request->spec_ram;
                    $data['storage'] = $request->storage;
                    $data['created_by'] = Auth::user()->user_id;
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $data['updated_at'] = date("Y-m-d H:i:s");

                    $data2['emp_status'] ="Verified";
                    $data2['verified_by'] =Auth::user()->user_id;
                    $data2['updated_at'] = date("Y-m-d H:i:s");

                    $update = DB::table('employee_verification_models')->where('emp_id', $request->emp_id)->update($data2);
                    $insert = DB::table( 'employee_verification_asset_models' )->insert($data);
                    $res['message'] = 'success';
                    return response( $res );
                }

            }

        }elseif($request->radio1 == "no"){
            $request->validate([
                'remark' => 'required',
            ]);
            $data['remark'] = $request->remark;
            $data['emp_id'] = $request->emp_id;
            $data['created_by'] = Auth::user()->user_id;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['updated_at'] = date("Y-m-d H:i:s");
            $insert = DB::table( 'employee_verification_asset_models' )->insert($data);
            $data1['emp_status'] = "Verified";
            $data1['verified_by'] = Auth::user()->user_id;
            $data1['updated_at'] = date("Y-m-d H:i:s");
            DB::table( 'employee_verification_models' )->where('emp_id',$request->emp_id)->update($data1);
            $res['message'] = 'success';
            return response( $res );
        }else{

            if($request->input( 'asset_type' )=="" && $request->input( 'remark' )=="" &&  $request->input( 'storage' )=="" && $request->input( 'spec_ram' )=="" && $request->input( 'brand' )=="" && $request->input( 'dongle' )=="" && $request->input( 'serial_no' )=="" && $request->input( 'category' )=="" && $request->input( 'model' )=="" && $request->input( 'asset_id' ) ==""){
                $res['message'] = 'failed';
                return response( $res );
            }
            else{
                $data['emp_id'] = $request->emp_id;
                $data['asset_type'] = $request->asset_type;
                $data['a_brand'] = $request->brand;
                $data['a_model'] = $request->model;
                $data['serial_no'] = $request->serial_no;
                $data['assetid'] = $request->asset_id;
                $data['category'] = $request->category;
                $data['dongle'] = $request->dongle;
                $data['remark'] = $request->remark;
                $data['spec_ram'] = $request->spec_ram;
                $data['storage'] = $request->storage;
                $data['created_by'] = Auth::user()->user_id;
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['updated_at'] = date("Y-m-d H:i:s");

                $data1['emp_status'] = "Hold";
                $data1['verified_by'] = Auth::user()->user_id;
                $data1['updated_at'] = date("Y-m-d H:i:s");

                $update = DB::table('employee_verification_models')->where('emp_id', $request->emp_id)->update($data1);
                $insert = DB::table( 'employee_verification_asset_models' )->insert($data);
                $res['message'] = 'success';
                return response( $res );
            }
        }
    }

    public function save_and_addmore(Request $request){
        if($request->input( 'asset_type' )!="" ||  $request->input( 'storage' )!="" || $request->input( 'spec_ram' )!="" || $request->input( 'brand' )!="" || $request->input( 'dongle' )!="" || $request->input( 'serial_no' )!="" || $request->input( 'category' )!=""){

            $d_check = DB::table('employee_verification_asset_models')
                ->where('emp_id',$request->emp_id)
                ->where('asset_type',$request->asset_type)
                ->where('a_brand',$request->brand)
                ->where('a_model',$request->model)
                ->where('serial_no',$request->serial_no)
                ->where('assetid',$request->asset_id)
                ->where('category',$request->category)
                ->where('dongle',$request->dongle)
                ->where('remark',$request->remark)
                ->where('spec_ram',$request->spec_ram)
                ->where('storage',$request->storage)
                ->where('created_by',Auth::user()->user_id)
                ->get()->toArray();
                if($d_check != Array ()){
                    exit;
                }else{
                $data['emp_id'] = $request->emp_id;
                $data['asset_type'] = $request->asset_type;
                $data['a_brand'] = $request->brand;
                $data['a_model'] = $request->model;
                $data['serial_no'] = $request->serial_no;
                $data['assetid'] = $request->asset_id;
                $data['category'] = $request->category;
                $data['dongle'] = $request->dongle;
                $data['remark'] = $request->remark;
                $data['spec_ram'] = $request->spec_ram;
                $data['storage'] = $request->storage;
                $data['created_by'] = Auth::user()->user_id;
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['updated_at'] = date("Y-m-d H:i:s");

                $data2['emp_status'] ="Verified";
                $data2['verified_by'] =Auth::user()->user_id;
                $data2['updated_at'] = date("Y-m-d H:i:s");

                $update= DB::table('employee_verification_models')->where('emp_id', $request->emp_id)->update($data2);

                $insert = DB::table( 'employee_verification_asset_models' )->insert($data);
                if($insert){
                    echo json_encode(array('sts'=>'success','emp_id'=>$request->emp_id));
                }
            }
        }else{
            echo json_encode(array('message'=>'failed'));
        }
    }

    public function verified_emp_update(Request $request){

        if($request->input( 'asset_type' )=="" &&  $request->input( 'storage' )=="" && $request->input( 'spec_ram' )=="" && $request->input( 'brand' )=="" && $request->input( 'dongle' )=="" && $request->input( 'serial_no' )=="" && $request->input( 'category' )=="" && $request->input( 'model' )=="" && $request->input( 'asset_id' ) ==""){
            $res['message'] = 'failed';
            return response( $res );
        }else{
            $d_check = DB::table('employee_verification_asset_models')
            ->where('emp_id',$request->emp_id)
            ->where('asset_type',$request->asset_type)
            ->where('a_brand',$request->brand)
            ->where('a_model',$request->model)
            ->where('serial_no',$request->serial_no)
            ->where('assetid',$request->asset_id)
            ->where('category',$request->category)
            ->where('dongle',$request->dongle)
            ->where('remark',$request->remark)
            ->where('spec_ram',$request->spec_ram)
            ->where('storage',$request->storage)
            ->where('created_by',Auth::user()->user_id)
            ->get()->toArray();
            if($d_check != Array ()){
                exit;
            }else{
            $data['emp_id'] = $request->emp_id;
            $data['asset_type'] = $request->asset_type;
            $data['a_brand'] = $request->brand;
            $data['a_model'] = $request->model;
            $data['serial_no'] = $request->serial_no;
            $data['assetid'] = $request->asset_id;
            $data['category'] = $request->category;
            $data['dongle'] = $request->dongle;
            $data['remark'] = $request->remark;
            $data['spec_ram'] = $request->spec_ram;
            $data['storage'] = $request->storage;
            $data['created_by'] = Auth::user()->user_id;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['updated_at'] = date("Y-m-d H:i:s");

            $data2['emp_status'] ="Verified";
            $data2['verified_by'] =Auth::user()->user_id;
            $data2['updated_at'] = date("Y-m-d H:i:s");

            $update= DB::table('employee_verification_models')->where('emp_id', $request->emp_id)->update($data2);
            $insert = DB::table( 'employee_verification_asset_models' )->insert($data);

            if( $insert){
                $res['message'] = 'success';
            } else{
                $res['message'] = 'failed';
            }

            return response( $res );
        }
        }
    }


     /**
	 * delete to database
	 *
	 * @param integer $id
	 * @return object
	 */

	public function delete( Request $request ) {


        //set delete if no assets to this user

        $id = $request->input( 'id' );

        $delete = DB::table( 'employees' )->where( 'id', $id )
            ->update(
                [
                'status'          => "Deleted",
                ]
            );

        if ( $delete ) {
            $res['success'] = 'success';
        } else{
            $res['success'] = 'failed';
        }
            return response( $res );

	}

    public function Fetch(Request $request)
    {
        if(request()->ajax()) {
            $data = DB::table('employee_verification_asset_models')->where('emp_id',$request->id)->get();

            return datatables()->of($data)
            ->addColumn('action', function($row){
                if($row->asset_type !="" || $row->category !="" || $row->a_brand !=""){
                    $button ='<button value='.$row->id.' onclick="fetch_verify_edit('.$row->id.')" class="btn btn-sm btn-primary"  id="edit_v_asset"><i class="fa fa-pencil"></i>Edit</button>';
                }else{
                    $button ='';
                }
                return $button;
            })
            ->addColumn('more_detail', function($row){
                $more='Serial.No: '.$row->serial_no.' / Storage: '.$row->storage.' / RAM: '.$row->spec_ram.' / Dongle: '.$row->dongle;
                return $more;
            })
            ->addIndexColumn()
            ->make(true);
        }
    }

    public function Get_verify_Edit(Request $request){
       $id  = $request->id;
       $res = DB::table('employee_verification_asset_models')->where('id',$id)->get();
       echo json_encode(array('res' =>$res ));
    }

    public function Update_Verify_Asset(Request $request){

        $id  = $request->asset_edit_id;
        $data['emp_id'] = $request->emp_id1;
        $data['asset_type'] = $request->asset_type;
        $data['a_brand'] = $request->brand;
        $data['a_model'] = $request->model;
        $data['serial_no'] = $request->serial_no;
        $data['assetid'] = $request->asset_id;
        $data['category'] = $request->category;
        $data['dongle'] = $request->dongle;
        $data['remark'] = $request->remark;
        $data['spec_ram'] = $request->spec_ram;
        $data['storage'] = $request->storage;
        $data['created_by'] = Auth::user()->user_id;
        $data['updated_at'] = date("Y-m-d H:i:s");

        $data2['emp_status'] ="Verified";
        $data2['verified_by'] =Auth::user()->user_id;
        $data2['updated_at'] = date("Y-m-d H:i:s");
        DB::table('employee_verification_models')->where('emp_id', $request->emp_id1)->update($data2);

        DB::table( 'employee_verification_asset_models' )->where('id',$id)->update($data);


        echo json_encode(array('res' =>'success','emp_id'=>$request->emp_id1 ));

    }

    public function fetchHoldEmployee(Request $request)
    {
        if(Auth::user()->user_id =="INFRA-005"){
            $data = DB::table('employee_verification_models')
            ->where('emp_status','=','Hold')
            ->where('verified_by','=',Auth::user()->user_id)
            ->Where(function ($query) {
                $query->orwhere('band','=','Band 3')
                      ->orwhere('band','=','Band 4')
                      ->orwhere('band','=','Band 5');
            })->get();
        }
        elseif(Auth::user()->role =="itinfra_audit"){
            if($request->id){
                if($request->id=="0"){
                    $data = DB::table('employee_verification_asset_models')
                    ->leftjoin('employee_verification_models', 'employee_verification_models.emp_id' , '=', 'employee_verification_asset_models.emp_id')
                    ->where('employee_verification_models.emp_status','=','Hold')
                    ->get();
                }else{
                    $data = DB::table('employee_verification_asset_models')
                    ->leftjoin('employee_verification_models', 'employee_verification_models.emp_id' , '=', 'employee_verification_asset_models.emp_id')
                    ->where('employee_verification_models.emp_status','=','Hold')
                    ->where('employee_verification_models.verified_by','=',$request->id)
                    ->get();
                }
            }else{
                $data = DB::table('employee_verification_asset_models')
                ->leftjoin('employee_verification_models', 'employee_verification_models.emp_id' , '=', 'employee_verification_asset_models.emp_id')
                ->where('employee_verification_models.emp_status','=','Hold')
                ->get();
            }
        }else{
            $data = DB::table('employee_verification_models')
            ->where('verified_by','=',Auth::user()->user_id)
            ->where('band','!=','Band 1')
            ->where('band','!=','Band 2')
            ->where('band','!=','Band 3')
            ->where('band','!=','Band 4')
            ->where('band','!=','Band 5')
            ->where('emp_status','=','Hold');
        }

        return Datatables::of($data)
        ->addColumn('have_asset', function($row){
            if(Auth::user()->role =="itinfra_audit"){
                if($row->asset_type =="" && $row->a_brand =="" && $row->a_model =="" && $row->serial_no =="" && $row->assetid =="" && $row->category =="" && $row->dongle =="" && $row->spec_ram =="" && $row->storage ==""){
                    $have_asset="No";
                }else{
                    $have_asset="Yes";
                }
                return $have_asset;
            }
        })

		->addColumn( 'action', function ( $accountsingle ) {
            return '<a href="#" id="btnedit" customdata='.$accountsingle->id.' onclick="asset_table('."'".$accountsingle->emp_id."'".','."'".$accountsingle->id."'".','."'".$accountsingle->fullname."'".')" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit"><i class="fa fa-pencil"></i>Edit</a>';
        } )->rawColumns(['gender','picture', 'action'])
        ->make(true);
    }

    public function returned_confirm(Request $request){
        $id = $request->update_id;
        $data['returned_status'] = "Returned";
        DB::table('employee_verification_asset_models')->where( 'id', $id )->update($data);
        echo json_encode(array('res' =>'success'));
    }

    public function update_asset(Request $request){
        $id = $request->update_id;
        $data['serial_no'] = $request->s_no1;
        $data['assetid'] = $request->asset_id1;
        $data['asset_type'] = $request->asset_type1;
        $data['category'] = $request->category1;
        $data['a_brand'] = $request->brand1;
        $data['a_model'] = $request->model1;
        $data['spec_ram'] = $request->spec_ram1;
        $data['storage'] = $request->storage1;
        $data['dongle'] = $request->dongle1;
        DB::table('employee_verification_asset_models')->where( 'id', $id )->update($data);
        echo json_encode(array('res' =>'success','id'=>$id,'s_no'=>$request->s_no1,'asset_id'=>$request->asset_id1,'asset_type'=>$request->asset_type1,'category'=>$request->category1,'brand'=>$request->brand1,'model'=>$request->model1,'spec_ram'=>$request->spec_ram1,'storage'=>$request->storage1,'emp_id'=>$request->emp_id3,'fullname'=>$request->fullname3,'email'=>$request->email3,'mobile'=>$request->mobile3,'role'=>$request->role3,'band'=>$request->band3,'grade'=>$request->grade3,'division'=>$request->division3,'wfh'=>$request->wfh3,'city'=>$request->city3,'office_city'=>$request->office_city3,'dongle'=>$request->dongle1));
    }


    public function employee_bulk_upload(Request $request){

        if($request->repeat !=""){
            if( $request->file('file_upload') ) {
                $path1 = $request->file('file_upload')->store('temp');
                $path=storage_path('app').'/'.$path1;
            } else {
                $path ="";
            }

        }else{

            if( $request->file('file_upload') ) {
                $path1 = $request->file('file_upload')->store('temp');
                $path=storage_path('app').'/'.$path1;
            } else {
                $path ="";
            }

            $data = Excel::toArray(new ImportEmployee(), $path);

            if (count($data[0]) == 0) {
                return response()->json([ 'response'=> 'error' ]);
            }

            foreach($data as $values => $value){
                foreach($value as $val){
                    $arrays[]= $val;

                    $emp_words          = $val['employee_id'];
                    $emp_id = trim($emp_words);
                    $dep_id           = $val['department'];
                    $business         = $val['payroll_status'];

                    if($business !=""){
                        $business_get = DB::table('business_models')->where("name",$business)->where('status','Active')->get();
                        if(!isset($business_get[0])){
                            return response()->json([ 'response'=> "business_mismatch",'business'=>$val['payroll_status'] ]);
                        }
                    }else{
                        return response()->json([ 'response'=> 'business_missing_error']);
                    }

                    if($dep_id !=""){
                        $business_id = DB::table('business_models')->where("name",$business)->where('status','Active')->get();

                        $dep_id_check = DB::table('department')
                        ->where('b_id', $business_id[0]->id )
                        ->where('name', $dep_id)
                        ->where('status','Active')
                        ->get();
                        if(!isset($dep_id_check[0])){
                            return response()->json([ 'response'=> "department_missing",'dep_id'=>$dep_id]);
                        }
                    }else{
                        return response()->json([ 'response'=> 'dep_id_missing_error']);
                    }
                }
            }

            $du = array();
            foreach ($arrays as $current_key => $current_array) {
                foreach ($arrays as $search_key => $search_array) {
                    if ($search_array['employee_id'] == $current_array['employee_id']) {
                        if ($search_key != $current_key) {
                            // echo "duplicate found: $search_key\n";
                            $dupe[] = $search_key;
                            $du[] = $current_array['employee_id'];
                        }
                    }
                }
            }
            $arr = $du;
            $unique_arr = array_unique($arr);
            $dup_arr = implode(' , ', $unique_arr);

            if($dup_arr != ""){
                return response()->json([ 'response'=> 'xlrpt_error','name'=> $dup_arr ]);
            }


            foreach($data as $values => $value){
                foreach($value as $val){

                    if($emp_id !=""){
                        $avai_emp_check = DB::table('employees')->where('emp_id',$emp_id)->get();

                        if(isset($avai_emp_check[0])){
                            $available_emp_id = $avai_emp_check[0]->emp_id;
                            return response()->json([ 'response'=> 'repeat_emp']);
                        }
                    }else{
                        return response()->json([ 'response'=> 'emp_id_missing_error']);
                    }
                }
            }
        }

        $upload = Excel::import(new ImportEmployee(), $path);

        return response()->json([ 'response'=> 'success']);

    }


}
