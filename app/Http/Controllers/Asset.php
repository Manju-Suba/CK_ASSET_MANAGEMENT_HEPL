<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetModel;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\TraitSettings;
use DB;
use App\User;
use App\AssetHistory;
use App;
use Auth;
use Milon\Barcode\DNS2D;
use App\Imports\Asset_Qr_Import;
use App\Imports\ImportAsset;
use Session;
use Dompdf\Dompdf;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;


class Asset extends Controller
{
    use TraitSettings;

    public function __construct() {

		$data = $this->getapplications();
		// $lang = $data->language;
		// App::setLocale($lang);
        $this->middleware('auth');
    }

    //return page
    public function index() {

        if(auth()->user()->role =="5" || auth()->user()->role =="7"){

            $busi = auth()->user()->domain ;
            $busiii = explode(",",$busi);

            $busi_id = DB::table('business_models')->select('*')->whereIn('name', $busiii)->where('status','Active')->get();

            $a_c_data = DB::table('asset_category_models')->select(['asset_category_models.*'])->where('status','!=', "Deleted")->get();
            $emp_data = DB::table('employees')
            ->select(['employees.*'])
            ->where('business', $busi_id[0]->id)
            ->where('status','!=', "Deleted")
            ->get();
            $business = DB::table('business_models')->select('*')->where('status','Active')->get();
            return view( 'asset.index' )->with(['a_c_data'=>$a_c_data,'emp_data'=>$emp_data,'business'=>$business]);

        }else{
            if(Auth::user()->user_id == "L1-L2-HD-001" || Auth::user()->user_id == "900300"){
                $a_c_data = DB::table('asset_category_models')->select(['asset_category_models.*'])->where('id','=','1')->where('status','!=', "Deleted")->get();

            }else{
                $a_c_data = DB::table('asset_category_models')->select(['asset_category_models.*'])->where('status','!=', "Deleted")->get();
            }
            // $a_c_data = DB::table('asset_category_models')->select(['asset_category_models.*'])->where('status','!=', "Deleted")->get();
            $emp_data = DB::table('employees')->select(['employees.*'])->where('status','!=', "Deleted")->get();
            $business = DB::table('business_models')->select('*')->where('status','Active')->get();
            return view( 'asset.index' )->with(['a_c_data'=>$a_c_data,'emp_data'=>$emp_data,'business'=>$business]);

        }

    }


    /**
	 * get  detail page
	 * @return object
	 */
    public function detail($id){
        $asset_data = DB::table('assets')->where("assetid",$id)->where('status','Active')->first();
        $a_type_id = $asset_data->a_type_id;
        return view('asset.detail', compact('id','a_type_id'));
    }

    public function qr_upload(Request $request){

        $dompdf = new Dompdf();
        $dompdf->loadHtml('
        <table border=1 align=center width=400>
        <tr><td>Name : </td><td>Narayanan</td></tr>
        <tr><td>Country : </td><td>1234567899</td></tr>
        </table>
        ');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("",array("Attachment" => false));

        exit(0);

    }

    public function download_all_qr_get(Request $request){

        $data = DB::table('temp_asset_qrs')->select(['temp_asset_qrs.*'])->get();

        $image=array();
        foreach($data as $s_data){
            $image[]='<img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($s_data->asset_code, 'QRCODE') . '" alt="barcode" style="width:100%;" />';

           

        }

        $f_data=[
            'data'=>$data,
            'image'=>$image,
        ];

        echo json_encode($f_data);

    }


    public function get_temp_asset_qr_data(){
        $data = DB::table('temp_asset_qrs')->select(['temp_asset_qrs.*']);
		return Datatables::of($data)
        ->addColumn( 'qr', function ( $single ) {

            return '
            <div id="qr_div'.$single->asset_code.'">
                <div class="col-md-12" >
                    <div class="row ">
                        <div class="col-md-4" id="qr_div_img_clone'.$single->asset_code.'">
                                <div class="assetbarcode" id="qr_div_img'.$single->asset_code.'"><img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($single->asset_code, 'QRCODE') . '" alt="barcode" style="width:100%;"  /></div>
                        </div>
                        <div class="col-md-12" style="text-align: left;">
                            <h6 id="qr_div_name'.$single->asset_code.'">'.$single->asset_name.'</h6><br>
                            <h6 id="qr_div_code'.$single->asset_code.'">'.$single->asset_code.'</h6>
                        </div>

                    </div>
                </div>
            </div>

            ';

        })
        ->addColumn( 'action', function ( $single ) {

            $action = '<a class="btn btn-sm btn-fill btn-primary" href="#" id="btncheckin" onclick=download_row_qr('."'".$single->asset_code."'".')  data-toggle="modal" data-target="#checkin"><i class="fa fa-print"></i> Print</a>';

            $action.= '<a class="btn btn-sm btn-fill btn-primary btn-Convert-Html2Image"" href="#" style="margin: 5px 5px 5px 5px;" id="btn-Convert-Html2Image"" onclick=download_row_qr_img('."'".$single->asset_code."'".')  data-toggle="modal" data-target="#checkin"><i class="fa fa-check"></i> Download</a>';

            return $action;

        }
         )->rawColumns(['qr','action'])
		->make( true );
    }

    public function get_allocated_qr_generate(){
        $data = DB::table('assets');
        $data =$data->leftJoin('brand', 'assets.brandid', '=', 'brand.id');
        $data =$data->leftjoin('asset_type', 'assets.a_type_id', '=', 'asset_type.id');
        $data =$data->leftJoin('location', 'assets.locationid', '=', 'location.id');
        $data =$data->leftJoin('employees', 'assets.emp_id', '=', 'employees.emp_id');
        $data =$data->leftJoin('business_models', 'assets.business_id', '=', 'business_models.id');
        $data =$data->where('assets.available_status', '=', 'Allocated');
        $data =$data->where('assets.status', '!=', 'Deleted');

        if(Auth::user()->role == "5" || Auth::user()->role == "7"){
            $busii = auth()->user()->domain ;
            $busiii = explode(",",$busii);
            $busii_id = DB::table('business_models')->select('*')->whereIn('name', $busiii)->where('status','Active')->get();
            foreach($busii_id as $val){
                $bus_id[] = $val->id;
            }
            $data =$data->whereIn('assets.business_id', $bus_id );
        }

        if(Auth::user()->role == "6"){
            $data =$data->where('assets.a_c_id', '!=', '1');
            $data =$data->where('assets.a_c_id', '!=', '5');
        }

        if(Auth::user()->user_id == "L1-L2-HD-001" || Auth::user()->user_id == "900300"){
            // $data =$data->whereIn('a_type_id',[9,10]);
            $data =$data->where('a_c_id',1);
        }
        $data = $data->select(['assets.*', 'asset_type.name as atype', 'business_models.name as businessid','employees.fullname as emp_name' ,'employees.emp_id as emp_id']);

        return Datatables::of($data)
        
        ->addColumn('asset_detail',function($single){
            $asset_detail='Name: <h6>'.$single->name.'</h6>';
            $asset_detail.='AID: <h6>'.$single->assetid.'</h6>';
			return $asset_detail;
        })
        ->addColumn( 'qr', function ( $single ) {
            if($single->barcode !=""){
            return '<div id="qr_div'.$single->barcode.'">
                <div class="col-md-12" >
                    <div class="row ">
                        <div class="col-md-4 pl-0 pr-2" id="qr_div_img_clone'.$single->barcode.'">
                            <div class="assetbarcode" ><img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="height:29px; width:30px"  /></div>
                            <div class="assetbarcode d-none" id="qr_div_img'.$single->barcode.'"><img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="height:50px; width:50px"  /></div>
                        </div>
                        <div class="col-md-12 qr_txt pt-2" style="padding-left: 1px !important;padding-right: 1px;">
                            <h6 style="white-space:nowrap;width:100px;overflow:hidden;text-overflow:ellipsis;" id="qr_div_name'.$single->barcode.'">'.$single->atype.'</h6>
                            <h6 style="white-space:nowrap;width:100px;overflow:hidden;text-overflow:ellipsis;" id="qr_div_code'.$single->barcode.'">'.$single->barcode.'</h6>
                            <h6 class="d-none" id="asset_id'.$single->barcode.'">'.$single->assetid.'</h6>
                            <h6 class="d-none" id="qr_entity_name'.$single->barcode.'">'.$single->businessid.'</h6>
                            <h6 class="d-none" id="qr_emp_id'.$single->barcode.'">'.$single->emp_id.'</h6>
                            <h6 class="d-none" id="qr_emp_name'.$single->barcode.'">'.$single->emp_name.'</h6>
                            <h6 class="d-none" id="qr_sn'.$single->barcode.'">'.$single->cpu_si.'</h6>
                            <h6 class="d-none" id="qr_support_no'.$single->barcode.'">'.$single->support_no.'</h6>
                            <h6 class="d-none" id="qr_support_email'.$single->barcode.'">'.$single->support_email.'</h6>
                        </div>

                    </div>
                </div>
            </div>';
            }else{
                return '<div></div>';
            }
        })
        ->addColumn('emp_detail',function($single){
            $emp_detail=$single->emp_name.'<br>'.$single->emp_id;
			return $emp_detail;
        })
        ->addColumn( 'action', function ( $single ) {

            $action = '<a class="btn btn-sm btn-fill btn-primary row-action" href="#" id="btncheckin" onclick=download_row_qr('."'".$single->barcode."'".')  data-toggle="modal" data-target="#checkin"  data-row-id="' . $single->id . '"><i class="fa fa-print"></i> Print</a>';

            $action.= '<a class="btn btn-sm btn-fill btn-primary btn-Convert-Html2Image row-action" href="#" style="margin: 5px 5px 5px 5px;" id="btn-Convert-Html2Image" onclick=download_row_qr_img('."'".$single->barcode."'".')  data-toggle="modal" data-target="#checkin" data-row-id="' . $single->id . '" ><i class="fa fa-check"></i> Download</a>';

            return $action;

        })
        ->addColumn('checkbox', function ($single) {
            return '<input type="checkbox" id="check'.$single->id.'" data-id="'.$single->id.'" name="selectedCheckbox[]" class="select-checkbox" />';
        })
        ->rawColumns(['asset_detail','qr','emp_detail','action','checkbox'])
		->make( true );
    }


    /**
     * get print label page
     * @return object
     */
    public function generatelabel($id){
        return view('asset.generate')->with('id', $id);
    }

    public function asset_qr_generate_land(){
        return view('asset.qr_generate_land');
    }

    public function qr_bulk_generate(Request $request){
        if( $request->file('upload_file') ) {
            $path1 = $request->file('upload_file')->store('temp');
            $path=storage_path('app').'/'.$path1;
            // $path = $request->file('upload_file')->getRealPath();
        } else {
            $path ="";
        }

        // Excel::import(new UsersImport(),$path);
        // $path=storage_path('app').'/'.$path1;
        $data = \Excel::import(new Asset_Qr_Import,$path);

        $resp="Success";
        return response()->json(['response'=>$resp]);
    }

    /**
	 * get data from database
	 * @return object
	 */
    public function getdata(Request $request){
        // $req = Session::get('email');
        // if(auth()->user()->role =="sub_admin"){

        //     $data = DB::table('assets')->where('created_by','=',$req);

        // }else{
            $data = DB::table('assets');
        // }
        $data =$data->leftJoin('brand', 'assets.brandid', '=', 'brand.id');
        $data =$data->leftjoin('asset_type', 'assets.a_type_id', '=', 'asset_type.id');
        $data =$data->leftJoin('location', 'assets.locationid', '=', 'location.id');
        $data =$data->leftJoin('business_models', 'assets.business_id', '=', 'business_models.id');
        $data =$data->where('assets.available_status', '=', 'Stock');
        $data =$data->where('assets.status', '!=', 'Deleted');
        $data =$data->where('brand.status', '!=', 'Deleted');
        $data =$data->where('asset_type.status', '!=', 'Deleted');
        $data =$data->where('location.status', '!=', 'Deleted');
        // if(auth()->user()->role =="sub_admin"){
        // $data =$data->where('created_by','=',$rec);
        // }



        if(Auth::user()->role == "5" || Auth::user()->role == "7"){
            $busii = auth()->user()->domain ;
            $busiii = explode(",",$busii);
            $busii_id = DB::table('business_models')->select('*')->whereIn('name', $busiii)->where('status','Active')->get();

            foreach($busii_id as $val){
                $bus_id[] = $val->id;
            }
            $data =$data->whereIn('assets.business_id', $bus_id );
        }

        if(Auth::user()->role == "6"){
            $data =$data->where('assets.a_c_id', '!=', '1');
            $data =$data->where('assets.a_c_id', '!=', '5');
        }

        if(Auth::user()->user_id == "L1-L2-HD-001" || Auth::user()->user_id == "900300"){
            $data =$data->where('a_c_id',1);
            // $data =$data->whereIn('a_type_id',[9,10]);
        }

        if ($request->assettype !="") {
            $data =$data->where('assets.a_type_id', '=', $request->assettype);
        }else{
            $data =$data->where('assets.a_type_id', 'like', "%{$request->get('assettype')}%");
        }

        if ($request->cat_id !="") {
            $data =$data->where('assets.a_c_id', '=', $request->cat_id);
        }else{
            $data =$data->where('assets.a_c_id', 'like', "%{$request->get('cat_id')}%");
        }

        if ($request->sel_id !="" && $request->sel_id != null) {
            $data =$data->where('assets.created_by', '=', $request->sel_id);
        }

        $data =$data->select(['assets.*','brand.name as brand','brand.id as brandid', 'asset_type.name as atype' , 'location.name as location' , 'business_models.name as businessid']);

        return Datatables::of($data)
        ->addColumn('pictures',function($single){
            if($single->picture !=""){
                return '<img class="yoyo" src="'.url('/').'/../upload/assets/'.$single->picture.'" style="width:50px"/>';
            }else{
                return '<img class="yoyo" src="'.url('/').'/../upload/assets/pic.png" style="width:50px"/>';
            }
        })
        ->addColumn('asset_detail',function($single){

            $ahis = DB::table('asset_history')->where('assetid',$single->assetid)->orderBy('id', 'desc')->first();
            
            if(isset($ahis)){
                if($ahis->employeeid != 'No user'){
                    $emp_det = DB::table('employees')->where('emp_id',$ahis->employeeid)->get();

                    $dept = '';
                    if(isset($emp_det[0])){
                        $dep = $emp_det[0]->departmentid;
                        $gdep = DB::table('department')->where('id',$dep)->get();
                        if(isset($gdep[0])){
                            $dept = $gdep[0]->name;
                        }
                        
                    }
                    $asset_detail='Name: <h6>'.$single->name.'</h6>';
                    $asset_detail.='AID: <h6>'.$single->assetid.'</h6>';
                    $asset_detail.='Dep: <b style="font-size: 11px;">'.$dept.'</b>';
                }else{
                    $asset_detail='Name: <h6>'.$single->name.'</h6>';
                    $asset_detail.='AID: <h6>'.$single->assetid.'</h6>';
                }
               
                
            }else{
                $asset_detail='Name: <h6>'.$single->name.'</h6>';
                $asset_detail.='AID: <h6>'.$single->assetid.'</h6>';
            }
			return $asset_detail;
        })

        ->addColumn('emp_detail',function($single){
            $emp_detail="";

            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->where('status', '!=', 'Deleted')->get();
                if(isset($emp_data[0]) && isset($emp_data[0]->fullname)){
                    $emp_detail=$emp_data[0]->fullname.'<br>'.$emp_data[0]->emp_id;
                }
            }
			return $emp_detail;
        })
        ->addColumn('emp_name',function($single){
            $emp_name="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->where('status', '!=', 'Deleted')->get();
                if(isset($emp_data[0]) && isset($emp_data[0]->fullname)){
                    $emp_name=$emp_data[0]->fullname;
                }
                else{
                    $emp_name="";
                }
            }
			return $emp_name;
        })
        ->addColumn('user_domain',function($single){
            $user_domain="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->where('status', '!=', 'Deleted')->get();
                if(isset($emp_data[0]) && isset($emp_data[0]->business)){
                    $businame=$emp_data[0]->business;
                    $get_business = DB::table('business_models')->where("id",$businame)->where('status', '!=', 'Deleted')->get();
                    $user_domain = $get_business[0]->name;
                }
                else{
                    $user_domain="";
                }
            }
			return $user_domain;
        })

        ->addColumn('asset_domain',function($single){
            $asset_domain="";
            if($single->business_id!=""){
                $get_businame = DB::table('business_models')->where("id",$single->business_id)->where('status', '!=', 'Deleted')->get();
                // print_r($get_businame[0]);
                if(isset($get_businame[0]) && isset($get_businame[0]->name)){
                    $asset_domain=$get_businame[0]->name;
                }
                else{
                    $asset_domain="";
                }
            }
			return $asset_domain;
        })

        ->addColumn('dep_idd',function($single){
            $dep_idd="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->where('status', '!=', 'Deleted')->get();
                if(isset($emp_data[0]) && isset($emp_data[0]->departmentid)){
                    $dep_id=$emp_data[0]->departmentid;
                    $get_dep = DB::table('department')->where("id",$dep_id)->where('status', '!=', 'Deleted')->get();

                    if(isset($get_dep[0])){
                        $dep_idd = $get_dep[0]->name;
                    }
                    else{
                        $dep_idd="";
                    }
                }
                
            }
			return $dep_idd ;
        })
        ->addColumn( 'qr', function ( $single ) {
            $emp_name = '';
            $emp_id = '';

            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->where('status', '!=', 'Deleted')->get();
                if(isset($emp_data[0]) && isset($emp_data[0]->fullname)){
                    $emp_name = $emp_data[0]->fullname;
                    $emp_id = $single->emp_id;
                }
            }

            $asset_domain = "";
            if($single->business_id!=""){
                $get_businame = DB::table('business_models')->where("id",$single->business_id)->where('status', '!=', 'Deleted')->get();
                if(isset($get_businame[0]) && isset($get_businame[0]->name)){
                    $asset_domain = $get_businame[0]->name;
                }
            }

            return '
            <div id="qr_div'.$single->barcode.'">
                <div class="col-md-12" >
                    <div class="row ">
                        <div class="col-md-4 pl-0 pr-2" id="qr_div_img_clone'.$single->barcode.'">
                                <div class="assetbarcode" ><img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="height:29px; width:30px"  /></div>
                            <div class="assetbarcode d-none" id="qr_div_img'.$single->barcode.'"><img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="height:50px; width:50px"  /></div>
                        </div>
                        <div class="col-md-12 qr_txt pt-2" style="padding-left: 1px !important;padding-right: 1px;">
                            <h6 id="qr_div_name'.$single->barcode.'">'.$single->atype.'</h6>
                            <h6 id="qr_div_code'.$single->barcode.'">'.$single->barcode.'</h6>
                            <h6 class="d-none" id="asset_id'.$single->barcode.'">'.$single->assetid.'</h6>
                            <h6 class="d-none" id="qr_entity_name'.$single->barcode.'">'.$asset_domain.'</h6>
                            <h6 class="d-none" id="qr_emp_id'.$single->barcode.'">'.$emp_id.'</h6>
                            <h6 class="d-none" id="qr_emp_name'.$single->barcode.'">'.$emp_name.'</h6>
                            <h6 class="d-none" id="qr_sn'.$single->barcode.'">'.$single->cpu_si.'</h6>
                            <h6 class="d-none" id="qr_support_no'.$single->barcode.'">'.$single->support_no.'</h6>
                            <h6 class="d-none" id="qr_support_email'.$single->barcode.'">'.$single->support_email.'</h6>
                        </div>

                    </div>
                </div>
            </div>

            ';

        })
        ->addColumn( 'action', function ( $accountsingle ) {
            //for checkout 2 button, checkin or checkout depand the record
            //$checkout = '  <a class="dropdown-item" href="#" id="btncheckout" customdata='.$accountsingle->id.'  data-toggle="modal" data-target="#checkout"><i class="fa fa-check"></i> '. trans('lang.checkout').'</a>';

            $action = '<a class="btn btn-sm btn-fill btn-primary" href="#" id="btncheckin" onclick=download_row_qr('."'".$accountsingle->barcode."'".')  style="margin-left: 10px;"><i class="fa fa-print"></i></a>';

            if(Auth::user()->role != "6" && Auth::user()->role != "7"){

                if($accountsingle->available_status=="Stock"){
                    $checkout = '<a class="dropdown-item" href="#" id="btncheckin" customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal" data-target="#checkin"><i class="fa fa-check"></i> Allocate</a>';
                }
                else if($accountsingle->available_status=="Allocated"){
                    $checkout = '<a class="dropdown-item" href="#" id="btncheckout" customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal" data-target="#checkout"><i class="fa fa-check"></i> Get Back</a>';
                }
                else if($accountsingle->available_status=="Retiral"){
                        $checkout = '';
                }
                if($accountsingle->a_type_id=="9" || $accountsingle->a_type_id=="10"){
                    $history = '<span class="dropdown-item"   onClick="history('."'".$accountsingle->assetid."'".')"><i class="fa fa-list-alt"></i>Asset History</span>';
                }else{
                    $history ="";
                }
                return '
                    <div class="btn-group">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu actionmenu">
                    '.$checkout.'
                    <div class="dropdown-divider"></div>
                    '.$history.'
                    <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                    <a class="dropdown-item" href="#" id="btnretiral"  customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal" data-target="#retiral"><i class="fa fa-bed"></i>Move to Retiral</a>
                    <a class="dropdown-item" href="#" id="btnedit" customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal"  data-target="#edit"><i class="fa fa-pencil"></i> '. trans('lang.edit').'</a>
                    <a class="dropdown-item" href="#" id="btnedit" customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal" data-target="#delete2"><i class="fa fa-trash"></i> '. trans('lang.delete').'</a>
                    </div>
                </div>'.$action.'';

            }elseif(Auth::user()->role == "7"){

                if($accountsingle->a_type_id=="9" || $accountsingle->a_type_id=="10"){
                    $history = '<span class="dropdown-item"   onClick="history('."'".$accountsingle->assetid."'".')"><i class="fa fa-list-alt"></i>Asset History</span>';
                }else{
                    $history ="";
                }
                return '
                    <div class="btn-group">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu actionmenu">
                    '.$history.'
                    <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                    </div>
                </div>';
    
            }else{
                return '
                    <div class="btn-group">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu actionmenu">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                        <a class="dropdown-item" href="#" id="btnedit" customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal"  data-target="#edit"><i class="fa fa-pencil"></i> '. trans('lang.edit').'</a>
                        <a class="dropdown-item" href="#" id="btnedit" customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal" data-target="#delete2"><i class="fa fa-trash"></i> '. trans('lang.delete').'</a>
                    </div>
                </div>'.$action.'';
            }

        } )
        ->rawColumns(['asset_detail','qr','pictures','emp_detail','emp_name','user_domain','asset_domain','dep_idd','action'])
        ->make(true);
    }

    public function get_asset_info(Request $request)
    {
        $id=$request->id;
        $final_data=DB::table('assets')->where('status', '!=', 'Deleted')->where("id",$id)->first();
        echo json_encode($final_data);
    }

    // get allocated asset data
    public function get_allocated_asset_data(Request $request){
        // $req = Session::get('email');
        $req = Auth::user()->email;
        // if(auth()->user()->role =="sub_admin"){

        //     $data = DB::table('assets')->where('created_by','=',$req);

        // }else{
        //     $data = DB::table('assets');
        // }
        $data = DB::table('assets');
        $data =$data->leftJoin('brand', 'assets.brandid', '=', 'brand.id');
        $data =$data->leftjoin('asset_type', 'assets.a_type_id', '=', 'asset_type.id');
        $data =$data->leftJoin('location', 'assets.locationid', '=', 'location.id');
        $data =$data->leftJoin('employees', 'assets.emp_id', '=', 'employees.emp_id');
        $data =$data->leftJoin('business_models', 'assets.business_id', '=', 'business_models.id');
        $data =$data->where('assets.available_status', '=', 'Allocated');
        $data =$data->where('assets.status', '!=', 'Deleted');
        $data =$data->where('assets.temp_date', '=', NULL);

        if(Auth::user()->role == "5" || Auth::user()->role == "7"){
            $busii = auth()->user()->domain ;
            $busiii = explode(",",$busii);
            $busii_id = DB::table('business_models')->select('*')->whereIn('name', $busiii)->where('status','Active')->get();
            foreach($busii_id as $val){
                $bus_id[] = $val->id;
            }
            $data =$data->whereIn('assets.business_id', $bus_id );
        }

        if(Auth::user()->role == "6"){
            $data =$data->where('assets.a_c_id', '!=', '1');
            $data =$data->where('assets.a_c_id', '!=', '5');
        }

        if(Auth::user()->user_id == "L1-L2-HD-001" || Auth::user()->user_id == "900300"){
            // $data =$data->whereIn('a_type_id',[9,10]);
            $data =$data->where('a_c_id',1);
        }

        if ($request->assettype !="") {
            $data =$data->where('assets.a_type_id', '=', $request->assettype);
        }else{
            $data =$data->where('assets.a_type_id', 'like', "%{$request->get('assettype')}%");
        }

        if ($request->cat_id !="") {
            $data =$data->where('assets.a_c_id', '=', $request->cat_id);
        }else{
            $data =$data->where('assets.a_c_id', 'like', "%{$request->get('cat_id')}%");
        }
        if ($request->sel_id !="" && $request->sel_id != null) {
            $data =$data->where('assets.created_by', '=', $request->sel_id);
        }
        $data = $data->select(['assets.*','brand.name as brand','brand.id as brandid', 'asset_type.name as atype' , 'location.name as location' ,'business_models.name as businessid']);
        // $data = DB::select("select assets.*, brand.name as brand, asset_type.name as type , location.name as location
        // from assets
        // left join brand
        // on assets.brandid = brand.id
        // left join asset_type
        // on assets.a_type_id = asset_type.id
        // left join location
        // on assets.locationid = location.id
        // where assets.available_status = 'Allocated'
        // and assets.status != 'Deleted'
        // order by assets.created_at desc");

        return Datatables::of($data)
        ->addColumn('pictures',function($single){
            if($single->picture !=""){
                return '<img src="'.url('/').'/../upload/assets/'.$single->picture.'" style="width:50px"/>';
            }else{
                return '<img src="'.url('/').'/../upload/assets/pic.png" style="width:50px"/>';
            }
        })
        ->addColumn('asset_detail',function($single){
            $asset_detail='Name: <h6>'.$single->name.'</h6>';
            $asset_detail.='AID: <h6>'.$single->assetid.'</h6>';
			return $asset_detail;
        })
        ->addColumn( 'qr', function ( $single ) {
            $emp_name = '';
            $emp_id = '';

            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->where('status', '!=', 'Deleted')->get();
                if(isset($emp_data[0]) && isset($emp_data[0]->fullname)){
                    $emp_name = $emp_data[0]->fullname;
                    $emp_id = $single->emp_id;
                }
            }

            $asset_domain = "";
            if($single->business_id!=""){
                $get_businame = DB::table('business_models')->where("id",$single->business_id)->where('status', '!=', 'Deleted')->get();
                if(isset($get_businame[0]) && isset($get_businame[0]->name)){
                    $asset_domain = $get_businame[0]->name;
                }
            }

            if($single->barcode !=""){
            return '<div id="qr_div'.$single->barcode.'">
                <div class="col-md-12" >
                    <div class="row ">
                        <div class="col-md-4 pl-0 pr-2" id="qr_div_img_clone'.$single->barcode.'">
                            <div class="assetbarcode" ><img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="height:29px; width:30px"  /></div>
                            <div class="assetbarcode d-none" id="qr_div_img'.$single->barcode.'"><img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="height:50px; width:50px"  /></div>
                        </div>
                        <div class="col-md-12 qr_txt pt-2" style="padding-left: 1px !important;padding-right: 1px;">
                            <h6 style="white-space:nowrap;width:100px;overflow:hidden;text-overflow:ellipsis;" id="qr_div_name'.$single->barcode.'">'.$single->atype.'</h6>
                            <h6 style="white-space:nowrap;width:100px;overflow:hidden;text-overflow:ellipsis;" id="qr_div_code'.$single->barcode.'">'.$single->barcode.'</h6>
                            <h6 class="d-none" id="asset_id'.$single->barcode.'">'.$single->assetid.'</h6>
                            <h6 class="d-none" id="qr_entity_name'.$single->barcode.'">'.$asset_domain.'</h6>
                            <h6 class="d-none" id="qr_emp_id'.$single->barcode.'">'.$emp_id.'</h6>
                            <h6 class="d-none" id="qr_emp_name'.$single->barcode.'">'.$emp_name.'</h6>
                            <h6 class="d-none" id="qr_sn'.$single->barcode.'">'.$single->cpu_si.'</h6>
                            <h6 class="d-none" id="qr_support_no'.$single->barcode.'">'.$single->support_no.'</h6>
                            <h6 class="d-none" id="qr_support_email'.$single->barcode.'">'.$single->support_email.'</h6>
                        </div>

                    </div>
                </div>
            </div>';
        }else{
             return '<div></div>';
        }
        })
        ->addColumn('emp_detail',function($single){
            $emp_detail="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->get();
                $emp_detail=$emp_data[0]->fullname.'<br>'.$emp_data[0]->emp_id;
            }
			return $emp_detail;
        })

        ->addColumn('emp_name',function($single){
            $emp_name="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->get();
                if(isset($emp_data[0]->fullname)){
                    $emp_name=$emp_data[0]->fullname;
                }
            }
			return $emp_name;
        })

        ->addColumn('user_domain',function($single){
            $user_domain="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->get();
                if(isset($emp_data[0]->business)){
                    $get_business = DB::table('business_models')->where("id",$emp_data[0]->business)->get();
                    if(isset($get_business[0]->name )){
                        $user_domain = $get_business[0]->name;
                    }
                }
            }
			return $user_domain;
        })

        ->addColumn('asset_domain',function($single){
            $asset_domain="";
            if($single->business_id!=""){
                $get_businame = DB::table('business_models')->where("id",$single->business_id)->where('status', '!=', 'Deleted')->get();
                if(isset($get_businame[0]->name)){
                    $asset_domain=$get_businame[0]->name;
                }
            }
			return $asset_domain;
        })

        ->addColumn('dep_idd',function($single){
            $dep_idd="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->where('status', '!=', 'Deleted')->get();

                if(isset($emp_data[0]->departmentid)){
                    $get_dep = DB::table('department')->where("id", $emp_data[0]->departmentid)->where('status', '!=', 'Deleted')->get();

                    if(isset( $get_dep[0]->name )){
                        $dep_idd = $get_dep[0]->name;
                    }
                }
            }
			return $dep_idd ;
        })
        ->addColumn( 'action', function ( $accountsingle ) {
            //for checkout 2 button, checkin or checkout depand the record
            //$checkout = '  <a class="dropdown-item" href="#" id="btncheckout" customdata='.$accountsingle->id.'  data-toggle="modal" data-target="#checkout"><i class="fa fa-check"></i> '. trans('lang.checkout').'</a>';

            if(Auth::user()->role != "7"){
                if($accountsingle->available_status=="Stock"){
                    $checkout = '<a class="dropdown-item" href="#" id="btncheckin" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#checkin"><i class="fa fa-check"></i> Allocate</a>';
                }
                else if($accountsingle->available_status=="Allocated"){
                    $checkout = '<a class="dropdown-item" href="#" id="btncheckout" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#checkout"><i class="fa fa-check"></i>Get Back</a>';
                }
                else if($accountsingle->available_status=="Retiral"){
                        $checkout = '';
                }
                if($accountsingle->a_type_id=="9" || $accountsingle->a_type_id=="10"){
                    $history = '<span class="dropdown-item"   onClick="history('."'".$accountsingle->assetid."'".')"><i class="fa fa-list-alt"></i>Asset History</span>';
                }else{
                    $history ="";
                }
                $action = '<a class="btn btn-sm btn-fill btn-primary" href="#" id="btncheckin" onclick=download_row_qr('."'".$accountsingle->barcode."'".')  style="margin-left: 10px;"><i class="fa fa-print"></i></a>';

                return '
                    <div class="btn-group">
                    <button class="btn btn-sm btn-primary dropdown-toggle mb-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu actionmenu">
                    '.$checkout.'
                    <div class="dropdown-divider"></div>
                    '.$history.'
                    <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                    <a class="dropdown-item" href="#" id="btnedit" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#edit"><i class="fa fa-pencil"></i> '. trans('lang.edit').'</a>
                    <a class="dropdown-item" href="#" id="btnedit" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#delete2"><i class="fa fa-trash"></i> '. trans('lang.delete').'</a>
                    </div>
                </div>'.$action.'';

            }elseif(Auth::user()->role == "7"){
               
                if($accountsingle->a_type_id=="9" || $accountsingle->a_type_id=="10"){
                    $history = '<span class="dropdown-item"   onClick="history('."'".$accountsingle->assetid."'".')"><i class="fa fa-list-alt"></i>Asset History</span>';
                }else{
                    $history ="";
                }

                return '
                    <div class="btn-group">
                    <button class="btn btn-sm btn-primary dropdown-toggle mb-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu actionmenu">
                    '.$history.'
                    <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                    </div>
                </div>';
            }

        } )
        ->rawColumns(['asset_detail','qr','pictures','emp_detail','user_domain','asset_domain','emp_name','dep_idd','action'])
        // ->rawColumns(['asset_detail','qr','pictures','emp_detail', 'action'])
        ->make(true);
    }




     // get allocated asset data
     public function get_temp_allocated_asset_data(Request $request){
        // $req = Session::get('email');
        $req = Auth::user()->email;
        // if(auth()->user()->role =="sub_admin"){  

        //     $data = DB::table('assets')->where('created_by','=',$req);

        // }else{
        //     $data = DB::table('assets');
        // }
        $data = DB::table('assets');
        $data =$data->leftJoin('brand', 'assets.brandid', '=', 'brand.id');
        $data =$data->leftjoin('asset_type', 'assets.a_type_id', '=', 'asset_type.id');
        $data =$data->leftJoin('location', 'assets.locationid', '=', 'location.id');
        $data =$data->leftJoin('employees', 'assets.emp_id', '=', 'employees.emp_id');
        $data =$data->leftJoin('business_models', 'assets.business_id', '=', 'business_models.id');
        $data =$data->where('assets.available_status', '=', 'Allocated');
        $data =$data->where('assets.status', '!=', 'Deleted');
        $data =$data->where('assets.temp_date', '!=', NULL);

        if(Auth::user()->role == "5" || Auth::user()->role == "7"){
            $busii = auth()->user()->domain ;
            $busiii = explode(",",$busii);
            $busii_id = DB::table('business_models')->select('*')->whereIn('name', $busiii)->where('status','Active')->get();
            foreach($busii_id as $val){
                $bus_id[] = $val->id;
            }
            $data =$data->whereIn('assets.business_id', $bus_id );
        }

        if(Auth::user()->role == "6"){
            $data =$data->where('assets.a_c_id', '!=', '1');
            $data =$data->where('assets.a_c_id', '!=', '5');
        }

        if(Auth::user()->user_id == "L1-L2-HD-001" || Auth::user()->user_id == "900300"){
            // $data =$data->whereIn('a_type_id',[9,10]);
            $data =$data->where('a_c_id',1);
        }

        if ($request->assettype !="") {
            $data =$data->where('assets.a_type_id', '=', $request->assettype);
        }else{
            $data =$data->where('assets.a_type_id', 'like', "%{$request->get('assettype')}%");
        }

        if ($request->cat_id !="") {
            $data =$data->where('assets.a_c_id', '=', $request->cat_id);
        }else{
            $data =$data->where('assets.a_c_id', 'like', "%{$request->get('cat_id')}%");
        }
        if ($request->sel_id !="" && $request->sel_id != null) {
            $data =$data->where('assets.created_by', '=', $request->sel_id);
        }

        $data = $data->select(['assets.*','brand.name as brand','brand.id as brandid', 'asset_type.name as atype' , 'location.name as location' ,'business_models.name as businessid']);

        return Datatables::of($data)
        ->addColumn('pictures',function($single){
            if($single->picture !=""){
                return '<img src="'.url('/').'/../upload/assets/'.$single->picture.'" style="width:50px"/>';
            }else{
                return '<img src="'.url('/').'/../upload/assets/pic.png" style="width:50px"/>';
            }
        })
        ->addColumn('asset_detail',function($single){
            $asset_detail='Name: <h6>'.$single->name.'</h6>';
            $asset_detail.='AID: <h6>'.$single->assetid.'</h6>';
			return $asset_detail;
        })
        ->addColumn( 'qr', function ( $single ) {
            $emp_name = '';
            $emp_id = '';

            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->where('status', '!=', 'Deleted')->get();
                if(isset($emp_data[0]) && isset($emp_data[0]->fullname)){
                    $emp_name = $emp_data[0]->fullname;
                    $emp_id = $single->emp_id;
                }
            }

            $asset_domain = "";
            if($single->business_id!=""){
                $get_businame = DB::table('business_models')->where("id",$single->business_id)->where('status', '!=', 'Deleted')->get();
                if(isset($get_businame[0]) && isset($get_businame[0]->name)){
                    $asset_domain = $get_businame[0]->name;
                }
            }

            if($single->barcode !=""){
            return '<div id="qr_div'.$single->barcode.'">
                <div class="col-md-12" >
                    <div class="row ">
                        <div class="col-md-4 pl-0 pr-2" id="qr_div_img_clone'.$single->barcode.'">
                                <div class="assetbarcode" ><img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="height:29px; width:30px"  /></div>
                            <div class="assetbarcode d-none" id="qr_div_img'.$single->barcode.'"><img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="height:50px; width:50px"  /></div>
                        </div>
                        <div class=" col-md-12 qr_txt pt-2" style="padding-left: 1px !important;padding-right: 1px;">
                            <h6 style="white-space:nowrap;width:100px;overflow:hidden;text-overflow:ellipsis;" id="qr_div_name'.$single->barcode.'">'.$single->atype.'</h6>
                            <h6 style="white-space:nowrap;width:100px;overflow:hidden;text-overflow:ellipsis;" id="qr_div_code'.$single->barcode.'">'.$single->barcode.'</h6>
                            <h6 class="d-none" id="asset_id'.$single->barcode.'">'.$single->assetid.'</h6>
                            <h6 class="d-none" id="qr_entity_name'.$single->barcode.'">'.$asset_domain.'</h6>
                            <h6 class="d-none" id="qr_emp_id'.$single->barcode.'">'.$emp_id.'</h6>
                            <h6 class="d-none" id="qr_emp_name'.$single->barcode.'">'.$emp_name.'</h6>
                            <h6 class="d-none" id="qr_sn'.$single->barcode.'">'.$single->cpu_si.'</h6>
                            <h6 class="d-none" id="qr_support_no'.$single->barcode.'">'.$single->support_no.'</h6>
                            <h6 class="d-none" id="qr_support_email'.$single->barcode.'">'.$single->support_email.'</h6>
                        </div>

                    </div>
                </div>
            </div>';
        }else{
             return '<div></div>';
        }
        })
        ->addColumn('emp_detail',function($single){
            $emp_detail="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->get();
                $emp_detail=$emp_data[0]->fullname.'<br>'.$emp_data[0]->emp_id;
            }
			return $emp_detail;
        })

        ->addColumn('emp_name',function($single){
            $emp_name="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->get();
                if(isset($emp_data[0]->fullname)){
                    $emp_name=$emp_data[0]->fullname;
                }
            }
			return $emp_name;
        })

        ->addColumn('user_domain',function($single){
            $user_domain="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->get();
                if(isset($emp_data[0]->business)){
                    $get_business = DB::table('business_models')->where("id",$emp_data[0]->business)->get();
                    if(isset($get_business[0]->name )){
                        $user_domain = $get_business[0]->name;
                    }
                }
            }
			return $user_domain;
        })

        ->addColumn('asset_domain',function($single){
            $asset_domain="";
            if($single->business_id!=""){
                $get_businame = DB::table('business_models')->where("id",$single->business_id)->where('status', '!=', 'Deleted')->get();
                if(isset($get_businame[0]->name)){
                    $asset_domain=$get_businame[0]->name;
                }
            }
			return $asset_domain;
        })

        ->addColumn('dep_idd',function($single){
            $dep_idd="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->where('status', '!=', 'Deleted')->get();

                if(isset($emp_data[0]->departmentid)){
                    $get_dep = DB::table('department')->where("id", $emp_data[0]->departmentid)->where('status', '!=', 'Deleted')->get();

                    if(isset( $get_dep[0]->name )){
                        $dep_idd = $get_dep[0]->name;
                    }
                }
            }
			return $dep_idd ;
        })
        ->addColumn( 'action', function ( $accountsingle ) {
            if(Auth::user()->role != "7"){
                if($accountsingle->available_status=="Stock"){
                    $checkout = '<a class="dropdown-item" href="#" id="btncheckin" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#checkin"><i class="fa fa-check"></i> Allocate</a>';
                }
                else if($accountsingle->available_status=="Allocated"){
                    $checkout = '<a class="dropdown-item" href="#" id="btncheckout" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#checkout"><i class="fa fa-check"></i>Get Back</a>';
                }
                else if($accountsingle->available_status=="Retiral"){
                        $checkout = '';
                }
                if($accountsingle->a_type_id=="9" || $accountsingle->a_type_id=="10"){
                    $history = '<span class="dropdown-item"   onClick="history('."'".$accountsingle->assetid."'".')"><i class="fa fa-list-alt"></i>Asset History</span>';
                }else{
                    $history ="";
                }

                $action = '<a class="btn btn-sm btn-fill btn-primary" href="#" id="btncheckin" onclick=download_row_qr('."'".$accountsingle->barcode."'".')  style="margin-left: 10px;"><i class="fa fa-print"></i></a>';

                return '
                    <div class="btn-group">
                    <button class="btn btn-sm btn-primary dropdown-toggle mb-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu actionmenu">
                    '.$checkout.'
                    <div class="dropdown-divider"></div>
                    '.$history.'
                    <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                    <a class="dropdown-item" href="#" id="btnedit" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#edit"><i class="fa fa-pencil"></i> '. trans('lang.edit').'</a>
                    <a class="dropdown-item" href="#" id="btnedit" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#delete2"><i class="fa fa-trash"></i> '. trans('lang.delete').'</a>
                    </div>
                </div>'.$action.'';

            }elseif(Auth::user()->role == "7"){
                
                if($accountsingle->a_type_id=="9" || $accountsingle->a_type_id=="10"){
                    $history = '<span class="dropdown-item"   onClick="history('."'".$accountsingle->assetid."'".')"><i class="fa fa-list-alt"></i>Asset History</span>';
                }else{
                    $history ="";
                }

                return '
                    <div class="btn-group">
                    <button class="btn btn-sm btn-primary dropdown-toggle mb-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu actionmenu">
                    '.$history.'
                    <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                    </div>
                </div>';
            }

        } )
        ->rawColumns(['asset_detail','qr','pictures','emp_detail','user_domain','asset_domain','emp_name','dep_idd','action'])
        ->make(true);
    }


    // retiral asset data
    public function get_retiral_asset_data(Request $request){
        // $req = Session::get('email');
        $req = Auth::user()->email;
        // if(auth()->user()->role =="sub_admin"){

        //     $data = DB::table('assets')->where('created_by','=',$req);

        // }else{
        //     $data = DB::table('assets');
        // }
        $data = DB::table('assets');
        $data =$data->leftJoin('brand', 'assets.brandid', '=', 'brand.id');
        $data =$data->leftjoin('asset_type', 'assets.a_type_id', '=', 'asset_type.id');
        $data =$data->leftJoin('location', 'assets.locationid', '=', 'location.id');
        $data =$data->where('assets.available_status', '=', 'Retiral');
        $data =$data->where('assets.status', '!=', 'Deleted');

        if(Auth::user()->role == "5" || Auth::user()->role == "7"){
            $busii = auth()->user()->domain ;
            $busiii = explode(",",$busii);
            $busii_id = DB::table('business_models')->select('*')->whereIn('name', $busiii)->where('status','Active')->get();

            foreach($busii_id as $val){
                $bus_id[] = $val->id;
            }
            $data =$data->whereIn('assets.business_id', $bus_id );
        }
        
        if(Auth::user()->role == "6"){
            $data =$data->where('assets.a_c_id', '!=', '1');
            $data =$data->where('assets.a_c_id', '!=', '5');
        }

        if(Auth::user()->user_id == "L1-L2-HD-001" || Auth::user()->user_id == "900300"){
            // $data =$data->whereIn('a_type_id',[9,10]);
            $data =$data->where('a_c_id',1);
        }

        if ($request->assettype !="") {
            $data =$data->where('assets.a_type_id', '=', $request->assettype);
        }else{
            $data =$data->where('assets.a_type_id', 'like', "%{$request->get('assettype')}%");
        }

        if ($request->cat_id !="") {
            $data =$data->where('assets.a_c_id', '=', $request->cat_id);
        }else{
            $data =$data->where('assets.a_c_id', 'like', "%{$request->get('cat_id')}%");
        }
        if ($request->sel_id !="" && $request->sel_id != null) {
            $data =$data->where('assets.created_by', '=', $request->sel_id);
        }

        $data =$data->select(['assets.*','brand.name as brand','brand.id as brandid', 'asset_type.name as type' , 'location.name as location']);

        // $data = DB::select("select assets.*, brand.name as brand, asset_type.name as type , location.name as location
        // from assets
        // left join brand
        // on assets.brandid = brand.id
        // left join asset_type
        // on assets.a_type_id = asset_type.id
        // left join location
        // on assets.locationid = location.id
        // where assets.available_status = 'Retiral'
        // and assets.status != 'Deleted'
        // order by assets.created_at desc");

        return Datatables::of($data)
        ->addColumn('pictures',function($single){
            if($single->picture !=""){
                return '<img src="'.url('/').'/../upload/assets/'.$single->picture.'" style="width:50px"/>';
            }else{
                return '<img src="'.url('/').'/../upload/assets/pic.png" style="width:50px"/>';
            }
        })
        ->addColumn('asset_detail',function($single){

            $asset_detail='Name: <h6>'.$single->name.'</h6>';
            $asset_detail.='AID: <h6>'.$single->assetid.'</h6>';

			return $asset_detail;
        })
        ->addColumn( 'qr', function ( $single ) {
            $emp_name = '';
            $emp_id = '';

            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->where('status', '!=', 'Deleted')->get();
                if(isset($emp_data[0]) && isset($emp_data[0]->fullname)){
                    $emp_name = $emp_data[0]->fullname;
                    $emp_id = $single->emp_id;
                }
            }

            $asset_domain = "";
            if($single->business_id!=""){
                $get_businame = DB::table('business_models')->where("id",$single->business_id)->where('status', '!=', 'Deleted')->get();
                if(isset($get_businame[0]) && isset($get_businame[0]->name)){
                    $asset_domain = $get_businame[0]->name;
                }
            }

            return '
            <div id="qr_div'.$single->barcode.'">
                <div class="col-md-12" >
                    <div class="row ">
                        <div class="col-md-4 pl-0 pr-2" id="qr_div_img_clone'.$single->barcode.'">
                            <div class="assetbarcode" ><img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="height:29px; width:30px"  /></div>
                            <div class="assetbarcode d-none" id="qr_div_img'.$single->barcode.'"><img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="height:50px; width:50px"  /></div>
                        </div>
                        <div class="col-md-12 qr_txt pt-2" style="padding-left: 1px !important;padding-right: 1px;">
                            <h6 id="qr_div_name'.$single->barcode.'">'.$single->type.'</h6>
                            <h6 id="qr_div_code'.$single->barcode.'">'.$single->barcode.'</h6>
                            <h6 class="d-none" id="asset_id'.$single->barcode.'">'.$single->assetid.'</h6>
                            <h6 class="d-none" id="qr_entity_name'.$single->barcode.'">'.$asset_domain.'</h6>
                            <h6 class="d-none" id="qr_emp_id'.$single->barcode.'">'.$emp_id.'</h6>
                            <h6 class="d-none" id="qr_emp_name'.$single->barcode.'">'.$emp_name.'</h6>
                            <h6 class="d-none" id="qr_sn'.$single->barcode.'">'.$single->cpu_si.'</h6>
                            <h6 class="d-none" id="qr_support_no'.$single->barcode.'">'.$single->support_no.'</h6>
                            <h6 class="d-none" id="qr_support_email'.$single->barcode.'">'.$single->support_email.'</h6>
                        </div>

                    </div>
                </div>
            </div>
            ';
        })

        ->addColumn('emp_detail',function($single){

            $emp_detail="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->get();
                $emp_detail=$emp_data[0]->fullname.'<br>'.$emp_data[0]->emp_id;
            }
			return $emp_detail;
        })
        ->addColumn( 'action', function ( $accountsingle ) {
            //for checkout 2 button, checkin or checkout depand the record
            //$checkout = '  <a class="dropdown-item" href="#" id="btncheckout" customdata='.$accountsingle->id.'  data-toggle="modal" data-target="#checkout"><i class="fa fa-check"></i> '. trans('lang.checkout').'</a>';

            if(Auth::user()->role != "7"){

                if($accountsingle->available_status=="Stock"){
                    $checkout = '<a class="dropdown-item" href="#" id="btncheckin" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#checkin"><i class="fa fa-check"></i> Allocate</a>';
                }
                else if($accountsingle->available_status=="Allocated"){
                    $checkout = '<a class="dropdown-item" href="#" id="btncheckout" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#checkout"><i class="fa fa-check"></i> Get Back</a>';
                }
                else if($accountsingle->available_status=="Retiral"){
                    $checkout = '';
                }
                if($accountsingle->a_type_id=="9" || $accountsingle->a_type_id=="10"){
                    $history = '<span class="dropdown-item"   onClick="history('."'".$accountsingle->assetid."'".')"><i class="fa fa-list-alt"></i>Asset History</span>';
                }else{
                    $history ="";
                }
                $action = '<a class="btn btn-sm btn-fill btn-primary" href="#" id="btncheckin" onclick=download_row_qr('."'".$accountsingle->barcode."'".')  style="margin-left: 10px;"><i class="fa fa-print"></i></a>';

                return '
                    <div class="btn-group">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu actionmenu">
                    '.$checkout.'
                    <div class="dropdown-divider"></div>
                    '.$history.'
                    <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                    <a class="dropdown-item" href="#" id="btnedit" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#delete2"><i class="fa fa-trash"></i> '. trans('lang.delete').'</a>
                    </div>
                </div>'.$action.'';

            }elseif(Auth::user()->role == "7"){
               
                if($accountsingle->a_type_id=="9" || $accountsingle->a_type_id=="10"){
                    $history = '<span class="dropdown-item"   onClick="history('."'".$accountsingle->assetid."'".')"><i class="fa fa-list-alt"></i>Asset History</span>';
                }else{
                    $history ="";
                }

                return '
                    <div class="btn-group">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu actionmenu">
                    '.$history.'
                    <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                    </div>
                </div>';
            }

        } )
        ->rawColumns(['asset_detail','qr','pictures','emp_detail', 'action'])
        // ->rawColumns(['asset_detail','qr','pictures','emp_detail','emp_name','user_domain','asset_domain','dep_idd', 'action'])
        ->make(true);
    }

    /**
     * get single data by assets id for history
     * @param integer $id
     * @return object
     */

    public function historyassetbyid( Request $request ) {
        $id            = $request->input( 'assetid' );

        $data = DB::select("select asset_history.*, assets.name as assetname,  IFNULL(employees.fullname, '-') as employeename

        from asset_history left join assets
        on asset_history.assetid = assets.assetid
        left join employees
        on asset_history.employeeid = employees.emp_id
        where asset_history.assetid = '$id'
        order by asset_history.created_at desc");
        return Datatables::of($data)

        ->addColumn('date_div',function($single){

            $setting = DB::table('settings')->where('id', '1')->first();

            $date_div="";
            if($single->type=="Allocation"){
                $date_div.="Allocated Date : ";
                if($single->allocated_date!=null && $single->allocated_date!="0000-00-00"){
                    $date_div.=date($setting->formatdate, strtotime($single->allocated_date));
                }
                $date_div.="<br>";
                $date_div.="Get Back Date : ";

                if($single->get_back_date!=null && $single->get_back_date!= "0000-00-00"){
                    $date_div.=date($setting->formatdate, strtotime($single->get_back_date));
                }
            }
            else if($single->type=="Replacement & Retiral" || $single->type=="Retiral"){
                $date_div.="Retiral Date : ";
                if($single->retiraldate!=null && $single->retiraldate!= "0000-00-00"){
                    $date_div.=date($setting->formatdate, strtotime($single->retiraldate));
                }
            }

            return $date_div;
        })

        ->rawColumns(['date_div'])
        ->make(true);
    }

    /**
	 * get single data
	 * @param integer $id
	 * @return object
	 */

    public function by_id( Request $request ) {
        $id   = $request->input( 'id' );

        $data = DB::table('assets')->select('assets.*','assets.name as assetname',
         'assets.description as assetdescription',
         'assets.created_at as assetcreated_at',
         'assets.updated_at as assetupdated_at',
         'assets.description as description',
         'location.name as location',
         'assets.type as asset_type')
        ->join('brand', 'brand.id', '=', 'assets.brandid')
        ->join('asset_type', 'asset_type.id', '=', 'assets.a_type_id')
        // ->join('supplier', 'supplier.id', '=', 'assets.supplierid')
        ->join('location', 'location.id', '=', 'assets.locationid')
        // ->join('sof_history', 'sof_history.id', '=', 'assets.assetid')
        ->where('assets.assetid',$id)
        ->first();

        if ( $data ) {
            //get date format setting
            $setting = DB::table('settings')->where('id', '1')->first();
            $all_emp_data = DB::table('employees')->where('status', '!=', 'Deleted')->get();
            $emp_div='<option value="">Choose Employee</option>';
            foreach ($all_emp_data as $key => $emp) {
                if ($emp->emp_id==$data->emp_id)
                {
                    $emp_div.='<option value="'.$emp->emp_id.'" selected>'.$emp->fullname.' / '.$emp->emp_id.' </option>';
                }
                else{
                    $emp_div.='<option value="'.$emp->emp_id.'">'.$emp->fullname.' / '.$emp->emp_id.' </option>';
                }
            }

            $sof_cost = DB::table('sof_history')->where('assetid',$data->assetid)->get();

            if($sof_cost == '[]' & $data->cost ==""){
                $sof_cost ="-";
            }else{
                if($sof_cost != "" || $sof_cost != '[]'){
                    foreach($sof_cost as $sof_cost){
                        $sof_cost1 = $sof_cost->sof_cost;
                     }
                     $sof_cost1 = "";
                     // exit();

                     if($sof_cost1 =="" & $data->cost !=""){
                         $sof_cost = $data->cost;

                     }elseif(($sof_cost1 !="" & $data->cost =="") || ($sof_cost1 !="" & $data->cost !="") ){
                         $sof_cost = $sof_cost1;

                     }
                     else{
                         $sof_cost ="-";
                     }
                }else{
                    $sof_cost ="-";
                }
            }

            $sing_emp_data = DB::table('employees')->where('emp_id', $data->emp_id)->get();
            if(isset($sing_emp_data[0])){
                $s_emp_detail['name']=$sing_emp_data[0]->fullname;
                $s_emp_detail['id']=$sing_emp_data[0]->emp_id;
            }
            else{
                $s_emp_detail['name']="";
                $s_emp_detail['id']="";
            }
            //for warranty
            $prchasedate = strtotime($data->date);
            $nextexpired = date($setting->formatdate, strtotime($data->warranty.' month', $prchasedate));

			$res['success'] = 'success';
            $res['message']= $data;
            $res['sof_cost']= $sof_cost;
            $res['emp_div']= $emp_div;
            $res['assetcreated_at']= date($setting->formatdate, strtotime($data->assetcreated_at));
            $res['assetupdated_at']= date($setting->formatdate, strtotime($data->assetupdated_at));
            $res['assetdate']= date($setting->formatdate, strtotime($data->date));
            $res['assetcost']= $setting->currency.$data->cost;
            $res['assetwarranty']= $data->warranty.' '.trans('lang.month').' - ('.$nextexpired.')';
            // $res['assetstatus']= $status;
            $res['assetbarcode'] = '<img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($data->barcode, 'QRCODE') . '" alt="barcode" width="70"  />';
            $res['assetimage']  = url('/').'/../upload/assets/'.$data->picture;
        } else{
            $res['success'] = 'failed';
        }
        echo json_encode($res);

    }

    public function byid( Request $request ) {
        $id            = $request->input( 'id' );

        $data = DB::table('assets')->select('assets.*','assets.name as assetname',
         'assets.description as assetdescription',
         'assets.created_at as assetcreated_at',
         'assets.updated_at as assetupdated_at',
         'assets.description as description',
         'brand.*', 'brand.name as brand',
         'asset_type.name as type',
         'business_models.name as business',
         'asset_type.field_id as field_id',
         'location.name as location',
         'assets.type as asset_type')
        ->join('brand', 'brand.id', '=', 'assets.brandid')
        ->join('asset_type', 'asset_type.id', '=', 'assets.a_type_id')
        // ->join('supplier', 'supplier.id', '=', 'assets.supplierid')
        ->join('location', 'location.id', '=', 'assets.locationid')
        ->join('business_models', 'business_models.id', '=', 'assets.business_id')
        ->where('assets.assetid',$id)
        ->first();

        if ( $data ) {
            //get date format setting
            $setting = DB::table('settings')->where('id', '1')->first();
            $all_emp_data = DB::table('employees')->where('status', '!=', 'Deleted')->get();
            $emp_div='<option value="">Choose Employee</option>';
            foreach ($all_emp_data as $key => $emp) {
                if ($emp->emp_id==$data->emp_id)
                {
                    $emp_div.='<option value="'.$emp->emp_id.'" selected>'.$emp->fullname.' / '.$emp->emp_id.' </option>';
                }
                else{
                    $emp_div.='<option value="'.$emp->emp_id.'">'.$emp->fullname.' / '.$emp->emp_id.' </option>';
                }
            }

            $spoc_emp_div='<option value="">Choose SPOC</option>';
            foreach ($all_emp_data as $key => $emp) {
                if ($emp->emp_id==$data->spoc_emp_id)
                {
                    $spoc_emp_div.='<option value="'.$emp->emp_id.'" selected>'.$emp->fullname.' / '.$emp->emp_id.' </option>';
                }
                else{
                    $spoc_emp_div.='<option value="'.$emp->emp_id.'">'.$emp->fullname.' / '.$emp->emp_id.' </option>';
                }
            }

            // $all_cat_data = DB::table('asset_category_models')->where('status', '!=', 'Deleted')->get();
            if(Auth::user()->user_id == "L1-L2-HD-001" || Auth::user()->user_id == "900300"){
                // $a_c_data = DB::table('asset_category_models')->select(['asset_category_models.*'])->where('id','=','1')->where('status','!=', "Deleted")->get();
                $all_cat_data = DB::table('asset_category_models')->where('id','=','1')->where('status', '!=', 'Deleted')->get();

            }else{
                $all_cat_data = DB::table('asset_category_models')->where('status', '!=', 'Deleted')->get();
            }
            $category_div='<option value="">Choose Asset Category</option>';
            foreach ($all_cat_data as $key => $as_cat) {
                if ($as_cat->id==$data->a_c_id)
                {
                    $category_div.='<option value="'.$as_cat->id.'" selected>'.$as_cat->name.' </option>';
                }
                else{
                    $category_div.='<option value="'.$as_cat->id.'">'.$as_cat->name.' </option>';
                }
            }

            $all_cat_type_data = DB::table('asset_type')->where('c_id',$data->a_c_id)->where('status','Active')->get();

            $category_type_div='<option value="">Choose Asset Type</option>';
                foreach ($all_cat_type_data as $key => $as_cat_t) {
                    if ($as_cat_t->id == $data->a_type_id)
                    {
                        $category_type_div.='<option value="'.$as_cat_t->id.'" selected>'.$as_cat_t->name.' </option>';
                        $category_type_field_id =$as_cat_t->field_id;
                    }
                    else{
                        $category_type_div.='<option value="'.$as_cat_t->id.'">'.$as_cat_t->name.' </option>';
                    }
                }

            $all_location_data = DB::table('location')->where('status','Active')->get();

            $location_div='<option value="">Choose Location</option>';
            foreach ($all_location_data as $key => $location) {
                if ($location->id==$data->locationid)
                {
                    $location_div.='<option value="'.$location->id.'" selected>'.$location->name.' </option>';
                }
                else{
                    $location_div.='<option value="'.$location->id.'">'.$location->name.' </option>';
                }
            }

            // brand
            $all_brand_data = DB::table('brand')->get();

            $brand_div='<option value="">Choose Brand</option>';
            foreach ($all_brand_data as $key => $brand) {
                if ($brand->id==$data->brandid)
                {
                    $brand_div.='<option value="'.$brand->id.'" selected>'.$brand->name.' </option>';
                }
                else{
                    $brand_div.='<option value="'.$brand->id.'">'.$brand->name.' </option>';
                }
            }

            $type_ar= array('OWN','Rental','BYOD','Office Property');
            $type_div='<option value="">Choose Type</option>';

            foreach($type_ar as $type_val){
                if ($type_val==$data->asset_type)
                {
                    $type_div.='<option value="'.$type_val.'" selected>'.$type_val.' </option>';
                }
                else{
                    $type_div.='<option value="'.$type_val.'">'.$type_val.' </option>';
                }
            }
            $allo_check_div='<option value="">Choose Type</option>';
            if ($data->emp_id!="")
            {
                $allo_check_div.='<option value="No">No</option>';
                $allo_check_div.='<option value="Yes" selected>Yes</option>';
            }
            else{
                $allo_check_div.='<option value="No" selected>No</option>';
                $allo_check_div.='<option value="Yes" >Yes</option>';
            }
            $sing_emp_data = DB::table('employees')->where('emp_id', $data->emp_id)->get();
            if(isset($sing_emp_data[0])){
                $s_emp_detail['name']=$sing_emp_data[0]->fullname;
                $s_emp_detail['id']=$sing_emp_data[0]->emp_id;
            }
            else{
                $s_emp_detail['name']="";
                $s_emp_detail['id']="";
            }
            //for warranty
            $prchasedate = strtotime($data->date);
            $nextexpired = date($setting->formatdate, strtotime($data->warranty.' month', $prchasedate));

			$res['success'] = 'success';
            $res['message']= $data;
            $res['spoc_emp_div']= $spoc_emp_div;
            $res['emp_div']= $emp_div;
            $res['type_div']= $type_div;
            $res['category_div']= $category_div;
            $res['category_type_div']= $category_type_div;
            $res['location_div']= $location_div;
            $res['brand_div']= $brand_div;
            $res['allo_check_div']= $allo_check_div;
            if(isset($category_type_field_id)){
                $res['category_type_field_id']=$category_type_field_id;
            }

            $res['emp_detail']= $s_emp_detail;
            $res['assetcreated_at']= date($setting->formatdate, strtotime($data->assetcreated_at));
            $res['assetupdated_at']= date($setting->formatdate, strtotime($data->assetupdated_at));
            $res['assetdate']= date($setting->formatdate, strtotime($data->date));
            $res['assetcost']= $setting->currency.$data->cost;
            $res['assetwarranty']= $data->warranty.' '.trans('lang.month').' - ('.$nextexpired.')';
            // $res['assetstatus']= $status;
            $res['assetbarcode'] = '<img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($data->barcode, 'QRCODE') . '" alt="barcode" width="60"  />';
            $res['assetimage']  = url('/').'/../upload/assets/'.$data->picture;
        } else{
            $res['success'] = 'failed';
        }
        echo json_encode($res);
        // return response( $res );
    }

    /**
	 * insert data  to database
	 *
	 * @param integer  $supplierid
     * @param integer  $typeid
     * @param integer  $brandid
	 * @param string  $assetid
     * @param string  $name
     * @param string  $serial
     * @param string  $quantity
     * @param string  $date
     * @param string  $cost
     * @param string  $warranty
     * @param string  $status
     * @param string  $picture
     * @param string  $description
     * @return object
	 */

    public function save(Request $request){

        request()->validate(['type' => 'required',
                             'a_c_id' => 'required',
                             'a_type_id' => 'required',
                             'assetid' => 'required',
                             'date' => 'required',
                             'name' => 'required',
                             'business_id' => 'required',
                            //  'host_name'=>'unique:assets,host_name,NULL|not_in:""'
                            'host_name'=> [
                                Rule::unique('assets', 'host_name')
                                    ->where(function ($query) {
                                        $query->whereNotNull('host_name')->where('host_name', '!=', '');
                                    }),
                            ],
                            ]);

        $data['business_id'] = $request->business_id;
        $data['assetid'] = $request->assetid;
        $data['type'] = $request->type;
        $data['a_c_id'] = $request->a_c_id;
        $data['a_type_id'] = $request->a_type_id;
        $data['locationid'] = $request->locationid;
        $data['brandid'] = $request->brandid;
        $data['cost'] = $request->cost;
        $data['barcode'] = $request->barcode;
        $data['cost_center'] = $request->cost_center;
        $data['ip_address'] = $request->ip_address;
        $data['name'] = $request->name;
        $data['port_no'] = $request->port_no;
        $data['quantity'] = $request->quantity;
        $data['date'] = $request->date;
        $data['emp_id'] = $request->employeeid;
        $data['temp_date'] = $request->temp_date;
        $data['spoc_emp_id'] = $request->spoc_employeeid;
        $data['warranty'] = "";
        $data['r_asset_id'] = "";
        $data['status'] = "Active";
        $data['description'] = $request->description;
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] =  date("Y-m-d H:i:s");
        $data['Asset_Domain'] = $request->asset_domain;
        $data['CPU_Model']=$request->cpu_model;
        $data['CPU_Configuration']=$request->cpu_configuration;
        $data['cpu_si']=$request->cpu_si;
        $data['host_name']=$request->host_name;
        $data['RAM']=$request->ram;
        $data['HDD']=$request->hdd;
        $data['MOUSE']=$request->mouse;
        $data['OS']=$request->os;
        $data['Keyboard']=$request->keyboard;
        $data['charger']=$request->asset_charger;
        $data['bag']=$request->asset_bag;
        $data['mon_size']=$request->mon_size;
        $data['mon_serial']=$request->mon_serial;
        $data['cam_pix']=$request->cam_pix;
        $data['cam_model']=$request->cam_model;
        $data['cam_serial_no']=$request->cam_serial_no;
        $data['sof_ver']=$request->sof_ver;
        $data['sof_qty']=$request->sof_qty;
        $data['sof_user_list']=$request->sof_user_list;
        $data['sof_vendor']=$request->sof_vendor;
        $data['sof_license_key']=$request->sof_license_key;
        $data['sof_expiry_date']=$request->sof_expiry_date;
        // $data['created_by']=Session::get('email');
        $data['created_by'] = Auth::user()->email;

        if($request->allocate_check == "Yes"){
            $data['available_status'] = "Allocated";

            $hassetid            = $request->assetid;
            $hemployeeid         = $request->employeeid;
            $hallocated_date     = date("Y-m-d");
            $hstatus             = 'Active'; //checkout = 1
            $havailable_status   = 'Allocated';
            $hcreated_at         = date("Y-m-d H:i:s");
            $hupdated_at         = date("Y-m-d H:i:s");

            $newUser = AssetHistory::updateOrCreate([
                'assetid'   => $hassetid,
            ],[
                'status'     => $hstatus,
                'employeeid' => $hemployeeid,
                'allocated_date'    => $hallocated_date,
                'type'=>"Allocated",
                'reason'=>"",
                'remark'=>"",
                'get_back_date'=>"",
                'retiraldate'=>"",
                'location'=>"",
                'created_at'=>$hcreated_at,
                'updated_at'=>$hupdated_at
            ]);
        }else{
            $data['available_status'] = "Stock";
        }

        if(!empty($request->file('picture'))){
            $picturename  = date('mdYHis').uniqid().$request->file('picture')->getClientOriginalName();
            $request->file('picture')->move(public_path("/upload/assets"), $picturename);
            $data['picture'] = $picturename;
        }

        $insert = DB::table('assets')->insert( $data );

        if ( $insert ) {
            $res['message'] = 'success';
        } else{
            $res['message'] = 'failed';
        }

        echo json_encode($res);
    }


    /**
	 * update data  to database
	 *
	 * @param string  $fullname
	 * @param string  $email
     * @param string  $picture
     * @param string  $gender
     * @param string  $city
     * @param string  $country
     * @param string  $phone
	 * @return object
	 */
    public function update(Request $request){
        request()->validate([
            'host_name'=> [
                Rule::unique('assets', 'host_name')
                    ->where(function ($query) {
                        $query->whereNotNull('host_name')->where('host_name', '!=', '');
                    }),
                ],
            ]);

        $assetid = $request->assetid;

        $data['locationid'] = $request->locationid;
        $data['business_id'] = $request->edit_business_id;
        $data['brandid'] = $request->brandid;
        $data['cost'] = $request->cost;
        $data['barcode'] = $request->edit_barcode;
        $data['cost_center'] = $request->edit_cost_center;
        $data['ip_address'] = $request->edit_ip_address;
        $data['name'] = $request->name;
        $data['port_no'] = $request->port_no;
        $data['quantity'] = $request->edit_quantity;
        $data['date'] = $request->date;
        $data['type'] = $request->edit_type;
        $data['a_c_id'] = $request->edit_a_c_id;
        $data['a_type_id'] = $request->edit_a_type_id;
        $data['available_status'] = $request->edit_allocate_check;
        $data['emp_id'] = $request->edit_employeeid;
        $data['temp_date'] = $request->edit_temp_date;
        $data['spoc_emp_id'] = $request->edit_spoc_employeeid;
        $data['description'] = $request->description;
        $data['updated_at'] = date("Y-m-d H:i:s");
        $data['Asset_Domain'] = $request->editasset_domain;
        $data['CPU_Model']=$request->edit_cpu_model;
        $data['CPU_Configuration']=$request->edit_cpu_configuration;
        $data['cpu_si']=$request->edit_cpu_si;
        $data['host_name']=$request->edit_host_name;
        $data['RAM']=$request->edit_ram;
        $data['HDD']=$request->edit_hdd;
        $data['MOUSE']=$request->edit_mouse;
        $data['OS']=$request->edit_os;
        $data['Keyboard']=$request->edit_Keyboard;
        $data['charger']=$request->editasset_charger;
        $data['bag']=$request->editasset_bag;
        $data['mon_size']=$request->edit_mon_size;
        $data['mon_serial']=$request->edit_mon_serial;
        $data['cam_pix']=$request->edit_cam_pix;
        $data['cam_model']=$request->edit_cam_model;
        $data['cam_serial_no']=$request->edit_cam_serial_no;
        $data['sof_ver']=$request->edit_sof_ver;
        $data['sof_qty']=$request->edit_sof_qty;
        $data['sof_user_list']=$request->edit_sof_user_list;
        $data['sof_vendor']=$request->edit_sof_vendor;
        $data['sof_license_key']=$request->edit_sof_license_key;
        $data['sof_expiry_date']=$request->edit_sof_expiry_date;

        // $message = ['picture.mimes'=>trans('lang.upload_error')];

        // $this->validate($request, ['picture' => 'mimes:jpeg,png,jpg|max:2048'],$message);
        // $picturename  = date('mdYHis').uniqid().$request->file('picture')->getClientOriginalName();
        // $request->file('picture')->move(public_path("/upload/assets"), $picturename);

        if(!empty($request->file('picture'))){
            $picturename  = date('mdYHis').uniqid().$request->file('picture')->getClientOriginalName();
            $request->file('picture')->move(public_path("/upload/assets"), $picturename);
            $data['picture'] = $picturename;
        }

        if($request->edit_allocate_check == "Yes"){
            $data['available_status'] = "Allocated";

            $hassetid            = $request->assetid;
            $hemployeeid         = $request->edit_employeeid;
            $hallocated_date     = date("Y-m-d");
            $hstatus             = 'Active'; //checkout = 1
            $hcreated_at         = date("Y-m-d H:i:s");
            $hupdated_at         = date("Y-m-d H:i:s");

            $newUser = AssetHistory::updateOrCreate([
                'assetid'   => $hassetid,
            ],[
                'status'     => $hstatus,
                'employeeid' => $hemployeeid,
                'allocated_date'    => $hallocated_date,
                'type'=>"Allocated",
                'reason'=>"",
                'remark'=>"",
                'get_back_date'=>"",
                'retiraldate'=>"",
                'location'=>"",
                'created_at'=>$hcreated_at,
                'updated_at'=>$hupdated_at
            ]);


        }else{
            $data['available_status'] = "Stock";
        }

        $update = DB::table( 'assets' )->where( 'assetid', $assetid )->update($data);
        if ( $update ) {
            $res['message'] = 'success';
        } else{
            $res['message'] = 'failed';
        }
        echo json_encode($res);

    }

    /**
	 * insert checkout data  to database
	 *
	 * @param integer  $assetid
     * @param integer  $employeeid
     * @param string  $date
     * @param integer  $status
	 * @return object
	 */

    public function savecheckout(Request $request){

        $form_filled_id=$request->id;
        if($form_filled_id=='Laptop Field')
        {
            if(isset($_POST['disallocate_charger']))
            {
                $charger=1;
            }
            else{
                $charger=0;
            }
            if(isset($_POST['disallocate_bag'])){
                  $bag=1;
            }
            else{
                $bag=0;
            }
        }
        else{
            $charger=0;
            $bag=0;
        }


        $location        = $request->input( 'locationid' );
        $assetid        = $request->input( 'assetid' );
        $get_back_date      = $request->input( 'get_back_date' );

        $available_status    = 'Stock';
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");

        $get_asid = DB::table( 'assets' )->where( 'assetid', $assetid )->select('*')->get();

        // $get_only_date = $get_asid[0]->created_at;
        $getOnlyDate = date('Y-m-d',strtotime($get_asid[0]->created_at));
        $update = AssetHistory::updateOrCreate([
            'assetid'   => $assetid,
        ],[
            'status'     => 'Active',
            'employeeid' => $get_asid[0]->emp_id,
            'allocated_date'    => $getOnlyDate,
            'type'=>"Allocated",
            'reason'=>"",
            'remark'=>"",
            'get_back_date'=>$get_back_date,
            'retiraldate'=>"",
            'location'=>$location,
            'created_at'=>$updated_at,
            'updated_at'=>$updated_at
        ]);

        // $update = DB::table( 'asset_history' )->where( 'assetid', $assetid )
        //     ->update(
        //         [
        //             'location'  =>  $location,
        //             'get_back_date'  =>  $get_back_date,
        //             'updated_at' => $updated_at,
        //         ]
        //     );

		if ( $update ) {
            //set status in table asset
            $update = DB::table( 'assets' )->where( 'assetid', $assetid )
            ->update(
                [
                    'emp_id'         => "",
                    'available_status'         => $available_status,
                    'updated_at'          => $updated_at,
                    'charger'=>$charger,
                    'bag'=>$bag
                ]
            );

			$res['success'] = 'success';
        } else{
            $res['success'] = 'failed';
        }

        return response( $res );
    }

    /**
     * insert checkin data  to database
     *
     * @param integer  $assetid
     * @param integer  $employeeid
     * @param string  $date
     * @param integer  $status
     * @return object
     */

    public function savecheckin(Request $request){

        $form_filled_id=$request->id;

        if($form_filled_id=='Laptop Field')
        {
            if(isset($_POST['allocate_charger']))
            {
                $charger=1;
            }
            else{
                $charger=0;
            }
            if(isset($_POST['allocate_bag'])){
                  $bag=1;
            }
            else{
                $bag=0;
            }
        }
        else{
            $charger=0;
            $bag=0;
        }
        $assetid        = $request->input( 'assetid' );
        $employeeid     = $request->input( 'ch_in_employeeid' );
        $allocated_date    = $request->input( 'allocated_date' );
        $status         = 'Active'; //checkout = 1
        $available_status    = 'Allocated';
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");
        $data           = array('assetid'=>$assetid, 'status'=>$status,'employeeid'=>$employeeid,'allocated_date'=>$allocated_date,'type'=>"Allocation",'reason'=>"",'remark'=>"",'get_back_date'=>"",'retiraldate'=>"",'location'=>"",'created_at'=>$created_at, 'updated_at'=>$updated_at);
        $insert         = DB::table( 'asset_history' )->insert( $data );

        if ( $insert ) {
            //set status in table asset
            $update = DB::table( 'assets' )->where( 'assetid', $assetid )
            ->update(
                [
                    'emp_id'         => $employeeid,
                    'available_status'         => $available_status,
                    'updated_at'          => $updated_at,
                    'charger'=>$charger,
                    'bag'=>$bag
                ]
            );
            $res['success'] = 'success';
        } else{
            $res['success'] = 'failed';
        }

        return response( $res );
    }

    /**
	 * get all  from database
	 * @return object
	 */
    public function getrows(){
        $data = DB::table('assets')->where('status','!=','Deleted')->get();
        if ( $data ) {
			$res['success'] = true;
			$res['message']= $data;
        }
        return response( $res );
    }


     /**
	 * delete to database
	 *
	 * @param integer $id
	 * @return object
	 */

	public function delete( Request $request ) {

        $id = $request->input( 'id' );
        $getfilename = DB::table('assets')
        ->where('assetid', '=', $id)
        ->first();

        $delete = DB::table( 'assets' )->where( 'assetid', $id )
		->update(
			[
			'status'          => 'Deleted',
			]
		);

        if ( $delete ) {
            $res['success'] = 'success';
        } else{
            $res['success'] = 'failed';
        }
        return response( $res );
    }

    // retiral
    public function retiral( Request $request ) {
        $id = $request->input( 'id' );
        $retiral_type = $request->input( 'retiral_type' );

        $r_asset_id="";
        if($retiral_type=="Replacement & Retiral"){
            $r_asset_id=$request->input( 'r_assetid' );
        }
        else{
            $r_asset_id="";
        }
        $getfilename = DB::table('assets')
        ->where('assetid', '=', $id)
        ->first();

        $delete = DB::table( 'assets' )->where( 'assetid', $id )
		->update(
			[
			'r_asset_id'          => $r_asset_id,
			'available_status'          => 'Retiral',
			]
		);

        $assetid        = $id;
        $employeeid     = "";
        $location    = $request->input( 'locationid' );
        $retiraldate    = $request->input( 'retiraldate' );
        $retiral_reason    = $request->input( 'retiral_reason' );
        $remark    = $request->input( 'remark' );
        $status         = 'Active'; //checkout = 1
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");
        $data           = array('assetid'=>$assetid, 'status'=>$status,'employeeid'=>$employeeid,'allocated_date'=>"",'get_back_date'=>"",'retiraldate'=>$retiraldate,'type'=>$retiral_type,'reason'=>$retiral_reason,'location'=>$location,'remark'=>$remark,'created_at'=>$created_at, 'updated_at'=>$updated_at);
        $insert         = DB::table( 'asset_history' )->insert( $data );

        if ( $delete ) {
            $res['success'] = 'success';
        } else{
            $res['success'] = 'failed';
        }
        return response( $res );
    }

    public function sofhistoryassetbyid( Request $request ) {
        $id    = $request->input( 'assetid' );

        $data = DB::table('assets');
        $data =$data->leftJoin('sof_history', 'assets.assetid', '=', 'sof_history.id');
        $data =$data->where('assets.assetid', '=', $id);

        $data =$data->select(['assets.*','sof_history.id as sof_history']);

        return Datatables::of($data)
        ->addColumn('date',function($single){
            $date = $single->date;
            return $date;
        })
        ->addColumn('sof_cost',function($single){

            $sof_cost="";
            if($single->assetid!=""){
                $sof_cost = DB::table('sof_history')->where("assetid",$single->assetid)->get();

                if($sof_cost == '[]' & $single->cost ==""){
                    $sof_cost ="-";
                }else{
                    if($sof_cost != "" || $sof_cost != '[]'){
                        foreach($sof_cost as $sof_cost){
                            $sof_cost1 = $sof_cost->sof_cost;
                        }
                        $sof_cost1 = $sof_cost1;

                        if($sof_cost1 =="" & $single->cost !=""){
                            $sof_cost = $single->cost;

                        }elseif(($sof_cost1 !="" & $single->cost =="") || ($sof_cost1 !="" & $single->cost !="") ){
                            $sof_cost = $sof_cost1;

                        }
                        else{
                            $sof_cost ="-";
                        }
                    }else{
                        $sof_cost ="-";
                    }
                }
            }
            return $sof_cost;

        })
        ->addColumn('expiry_date',function($single){

            $expiry_date=date("d-m-Y", strtotime($single->sof_expiry_date));

            return $expiry_date;
        })
        ->addColumn('action',function($single){
            $action= '<a href="#" id="btndocin" customdata='."'".$single->assetid."'".' class="btn btn-sm btn-primary" data-toggle="modal" data-target="#docin">View</a>';
            return $action;
        })
        ->rawColumns(['date','sof_cost','expiry_date','action'])
        ->make(true);
    }


    /**
	 * Generate Product Code
	 *
	 * @return object
	 */

	public function generateproductcode() {
        $lastid = DB::table('assets')->orderBy('id', 'desc')->first();

        if ( $lastid ) {
			$res['success'] = 'success';
			$res['message']=  'AST'.date('ymd').$lastid->id;
        } else{
            $res['message']=  'AST'.date('ymd').'1';
        }
        return response( $res );
    }

    public function listasset_active(Request $request) {
        $edit_asset_id=$request->input('edit_asset_id');

        $all_asset_data = DB::table('assets')->where('assetid','!=',$edit_asset_id)->where('available_status','=','Stock')->where('status', '!=', 'Deleted')->get();

        $asset_div='<option value="">Choose Asset ID</option>';
        foreach ($all_asset_data as $key => $as_data) {
           $asset_div.='<option value="'.$as_data->assetid.'">'.$as_data->assetid.' </option>';
        }

        $resp="Success";
        return response()->json(['response'=>$resp,'asset_div'=>$asset_div]);
    }


    public function asset_bulk_upload(Request $request){
        $expectedColumns = [
            'sno', 'port_no', 'user_name', 'employee_id', 'dept', 'user_domain', 'asset_type_locate', 'access_type',
            'location', 'asset_id', 'asset_domain', 'system_names', 'cpu_slservice_tag', 'host_name', 'cpu_configuration',
            'ram', 'hdd', 'monitor_service_tag', 'keyboard', 'mouse', 'os', 'brand'
        ];

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

            $data = Excel::toArray(new ImportAsset(), $path);

            if (count($data[0]) == 0) {
                return response()->json([ 'response'=> 'error' ]);
            }
            $columns = array_keys($data[0][0]);
            $missingColumns = array_diff($expectedColumns, $columns);
            $extraColumns = array_diff($columns, $expectedColumns);

            if (!empty($missingColumns)) {
                return response()->json(['response' => 'missing_columns', 'columns' => $missingColumns]);
            }

            foreach($data as $values => $value){
                foreach($value as $val){

                    $arrays[]= $val;

                    $location          = $val['location'];
                    $asset_type          = $val['access_type'];
                    $asset_type_locate          = $val['asset_type_locate'];
                    $emp_words          = $val['employee_id'];
                    $empp_id = trim($emp_words);

                    if($location !=""){
                        $location_check = DB::table('location')->where('name',$location  )->where('status','Active')->get();
                        if(!isset($location_check[0])){
                            return response()->json([ 'response'=> "location_mismatch",'location'=>$location ]);
                        }
                    }else{
                        return response()->json([ 'response'=> "location_missing"]);
                    }

                    ////////////business model////

                    if($val['asset_domain'] !=""){
                        $business = DB::table('business_models')->where("name",$val['asset_domain'])->where('status','Active')->get();
                        if(!isset($business[0])){
                            return response()->json([ 'response'=> "business_mismatch",'business'=>$val['asset_domain'] ]);
                        }
                    }

                    // if($val['category_id'] !=""){
                    //     $category = DB::table('asset_category_models')->where("name",$val['category_id'])->where('status','Active')->get();
                    //     if(!isset($category[0])){
                    //         return response()->json([ 'response'=> "category_mismatch",'category'=>$val['category_id'] ]);
                    //     }
                    // }
                    // print_r($val['employee_id']  );
                    if($asset_type != ""){
                        $asset_type = DB::table('asset_type')->where("name",$val['access_type'])->where('status','Active')->get();
                        if(!isset($asset_type[0])){
                            return response()->json([ 'response'=> "access_type_mismatch",'access_type'=>$val['access_type'] ]);
                        }
                    }else{
                        return response()->json([ 'response'=> "access_type_missing" ]);
                    }

                    if($val['brand'] !=''){
                        $brand = DB::table('brand')->where("name",$val['brand'])->where('status','Active')->get();
                        if(!isset($brand[0])){
                            return response()->json([ 'response'=> "brand_mismatch",'brand'=>$val['brand'] ]);
                        }
                    }else{
                        return response()->json([ 'response'=> "brand_missing" ]);
                    }

                    if( $val['user_name'] !="" && $val['user_name'] !="Damage"){
                        if($val['employee_id'] =="" ){
                            return response()->json([ 'response'=> "emp_id_missing",'employee_id'=>$val['user_name'] ]);
                        }
                    }

                    //check employee
                    if($val['employee_id'] !='' && $val['employee_id'] !='No User'){
                        $check_employee = DB::table('employees')->where("emp_id", $empp_id )->where('status','Active')->get();
                        if(!isset($check_employee[0])){

                            if($val['dept'] !=""){
                                if($val['user_domain'] !=""){
                                    $check_busine = DB::table('business_models')->where("name",$val['user_domain'])->where('status','Active')->get();

                                    if(!isset($check_busine[0])){
                                        return response()->json([ 'response'=> "user_business_mismatch",'business'=>$val['user_domain'] ]);
                                    }else{
                                        $get_busid = $check_busine[0]->id;
                                    }

                                }else{
                                    $get_busid ="3";
                                }
                                $check_dept = DB::table('department')->where("name",$val['dept'])->where('b_id',$get_busid )->where('status','Active')->get();

                                if(!isset($check_dept[0])){
                                    return response()->json([ 'response'=> "dep_mismatch",'dept'=>$val['dept'] ]);
                                }else{
                                    $dep_iddd = $check_dept[0]->id;
                                }
                            }else{
                                $dep_iddd = "143";
                                $get_busid ="3";
                            }
                            $dataa['emp_id'] = $empp_id;
                            $dataa['fullname'] = $val['user_name'];
                            $dataa['departmentid'] = $dep_iddd;
                            $dataa['business'] = $get_busid ;
                            $dataa['email'] = $empp_id;
                            $dataa['status'] = 'Active';

                            $emp_insert = DB::table('employees')->insert( $dataa );

                            // return response()->json([ 'response'=> "employee_mismatch",'employee'=>$val['employee_id'] ]);
                        }
                    }
                }
            }

            $du = array();
            foreach ($arrays as $current_key => $current_array) {
                foreach ($arrays as $search_key => $search_array) {
                    if ($search_array['asset_id'] == $current_array['asset_id']) {
                        if ($search_key != $current_key) {
                            // echo "duplicate found: $search_key\n";
                            $dupe[] = $search_key;
                            $du[] = $current_array['asset_id'];
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

                    $asset_words = $val['asset_id'] ;
                    $assetid = trim($asset_words);
                    // print_r($assetid);

                    // $assetid           = $val['asset_id'];
                    if($assetid !="" && $assetid != NULL){
                        $avai_ass_check = DB::table('assets')->where('assetid',$assetid )->get();

                        if(isset($avai_ass_check[0])){
                            $available_ass_id = $avai_ass_check[0]->assetid;
                            return response()->json([ 'response'=> 'repeat_asset']);
                        }
                    }else{
                        return response()->json([ 'response'=> 'asset_id_missing_error']);
                    }
                }
            }
        }

        $upload = Excel::import(new ImportAsset(), $path);

        return response()->json([ 'response'=> 'success']);

    }
    public function asset_history(Request $request){
        $asset_id = $request->input('asset_id');
        $history = DB::table('asset_history')->where('assetid','=',$asset_id)->get();
        // dd($history);
        return response()->json([
            'history'=>$history,
        ]);

    }


    // bulk_qrcode_download
    public function bulk_qrcode_generate(){
        return view('asset.bulk_qr_generate');
    }

    public function bulk_qr_generate(Request $request){
        try {
            $fromAssetId = $request->from_assetid;
            $toAssetId = $request->to_assetid;
    
            $fromAsset = DB::table('assets')->where('assetid', $fromAssetId)->value('id');
            $toAsset = DB::table('assets')->where('assetid', $toAssetId)->value('id');
    
            if(!empty($fromAsset) && !empty($toAsset)){
                $data = DB::table('assets')
                    ->leftJoin('brand', 'assets.brandid', '=', 'brand.id')
                    ->leftJoin('asset_type', 'assets.a_type_id', '=', 'asset_type.id')
                    ->leftJoin('location', 'assets.locationid', '=', 'location.id')
                    ->leftJoin('employees', 'assets.emp_id', '=', 'employees.emp_id')
                    ->leftJoin('business_models', 'assets.business_id', '=', 'business_models.id')
                    ->where('assets.available_status', '=', 'Allocated')
                    ->where('assets.status', '!=', 'Deleted')
                    ->where('assets.id', '>=', $fromAsset)
                    ->where('assets.id', '<=', $toAsset);
    
                if(Auth::user()->role == "5" || Auth::user()->role == "7"){
                    $busii = auth()->user()->domain ;
                    $busiii = explode(",", $busii);
                    $busii_id = DB::table('business_models')->select('*')->whereIn('name', $busiii)->where('status', 'Active')->get();
                    foreach($busii_id as $val){
                        $bus_id[] = $val->id;
                    }
                    $data = $data->whereIn('assets.business_id', $bus_id);
                }
    
                if(Auth::user()->role == "6"){
                    $data = $data->where('assets.a_c_id', '!=', '1');
                    $data = $data->where('assets.a_c_id', '!=', '5');
                }
    
                if(Auth::user()->user_id == "L1-L2-HD-001" || Auth::user()->user_id == "900300"){
                    $data = $data->where('a_c_id', 1);
                }
    
                $data = $data->select(['assets.*', 'asset_type.name as atype', 'business_models.name as businessid', 'employees.fullname as emp_name', 'employees.emp_id as emp_id']);
                $data = $data->get();
    
                // Transform the collection to the desired structure
                $transformedData = $data->map(function ($item) {
                    return [
                        'assetid' => $item->assetid,
                        'entityname' => $item->businessid,
                        'emp_id' => $item->emp_id,
                        'emp_name' => $item->emp_name,
                        'sn' => $item->cpu_si,
                        'support_no' => $item->support_no,
                        'support_email' => $item->support_email,
                        'img' => '<img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($item->barcode, 'QRCODE') . '" alt="barcode" style="height:50px; width:50px"  />',
                    ];
                });
    
                // Convert to JSON
                $jsonData = $transformedData->toJson();
    
                $resp = "Success";
                return response()->json(['response' => $resp, 'data' => $jsonData]);
            } else {
                return response()->json(['response' => 'error', 'data' => '']);
            }
        } catch (Exception $e) {
            // Handle any errors that may have occurred
            return response()->json(['response' => 'error', 'message' => $e->getMessage()]);
        }
    }
    
    public function selected_row_qr_generate(Request $request){
        try {
            $rowIds = $request->ids;
            $data = DB::table('assets')
                ->leftJoin('brand', 'assets.brandid', '=', 'brand.id')
                ->leftJoin('asset_type', 'assets.a_type_id', '=', 'asset_type.id')
                ->leftJoin('location', 'assets.locationid', '=', 'location.id')
                ->leftJoin('employees', 'assets.emp_id', '=', 'employees.emp_id')
                ->leftJoin('business_models', 'assets.business_id', '=', 'business_models.id')
                ->where('assets.available_status', '=', 'Allocated')
                ->where('assets.status', '!=', 'Deleted')
                ->whereIn('assets.id', $rowIds);

            if(Auth::user()->role == "5" || Auth::user()->role == "7"){
                $busii = auth()->user()->domain ;
                $busiii = explode(",", $busii);
                $busii_id = DB::table('business_models')->select('*')->whereIn('name', $busiii)->where('status', 'Active')->get();
                foreach($busii_id as $val){
                    $bus_id[] = $val->id;
                }
                $data = $data->whereIn('assets.business_id', $bus_id);
            }

            if(Auth::user()->role == "6"){
                $data = $data->where('assets.a_c_id', '!=', '1');
                $data = $data->where('assets.a_c_id', '!=', '5');
            }

            if(Auth::user()->user_id == "L1-L2-HD-001" || Auth::user()->user_id == "900300"){
                $data = $data->where('a_c_id', 1);
            }

            $data = $data->select(['assets.*', 'asset_type.name as atype', 'business_models.name as businessid', 'employees.fullname as emp_name', 'employees.emp_id as emp_id']);
            $data = $data->get();

            // Transform the collection to the desired structure
            $transformedData = $data->map(function ($item) {
                return [
                    'assetid' => $item->assetid,
                    'entityname' => $item->businessid,
                    'emp_id' => $item->emp_id,
                    'emp_name' => $item->emp_name,
                    'sn' => $item->cpu_si,
                    'support_no' => $item->support_no,
                    'support_email' => $item->support_email,
                    'img' => '<img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($item->barcode, 'QRCODE') . '" alt="barcode" style="height:50px; width:50px"  />',
                ];
            });

            // Convert to JSON
            $jsonData = $transformedData->toJson();

            $resp = "Success";
            return response()->json(['response' => $resp, 'data' => $jsonData]);
       
        } catch (Exception $e) {
            // Handle any errors that may have occurred
            return response()->json(['response' => 'error', 'message' => $e->getMessage()]);
        }
    }

}
