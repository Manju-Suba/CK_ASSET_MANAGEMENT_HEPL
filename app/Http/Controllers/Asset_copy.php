<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetModel;
use Illuminate\Support\Facades\File; 
use Yajra\Datatables\Datatables;
use App\Http\Controllers\TraitSettings;
use DB;
use App\User;
use App;
use Auth;
use Milon\Barcode\DNS2D;
use App\Imports\Asset_Qr_Import;

use Dompdf\Dompdf;

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
        $a_c_data = DB::table('asset_category_models')->select(['asset_category_models.*'])->where('status','!=', "Deleted")->get();
        $emp_data = DB::table('employees')->select(['employees.*'])->where('status','!=', "Deleted")->get();
		return view( 'asset.index' )->with(['a_c_data'=>$a_c_data,'emp_data'=>$emp_data]);
    } 

    
    /**
	 * get  detail page
	 * @return object
	 */
    public function detail($id){
        return view('asset.detail', compact('id'));
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
            $image[]='<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($s_data->asset_code, 'QRCODE') . '" alt="barcode" style="width:100%;"  />';

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
                                <div class="assetbarcode" id="qr_div_img'.$single->asset_code.'"><img src="data:image/png;base64,' . DNS2D::getBarcodePNG($single->asset_code, 'QRCODE') . '" alt="barcode" style="width:100%;"  /></div>
                        </div>
                        <div class="" style="text-align: left;">
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


        $data = DB::table('assets');
        $data =$data->leftJoin('brand', 'assets.brandid', '=', 'brand.id');
        $data =$data->leftjoin('asset_type', 'assets.a_type_id', '=', 'asset_type.id');
        $data =$data->leftJoin('location', 'assets.locationid', '=', 'location.id');
        $data =$data->where('assets.available_status', '=', 'Stock');
        $data =$data->where('assets.status', '!=', 'Deleted');

        if ($request->has('assettype')) {
        $data =$data->where('assets.a_type_id', 'like', "%{$request->get('assettype')}%");
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
        // where assets.available_status = 'Stock'
        // and assets.status != 'Deleted'
        // order by assets.created_at desc"); 

        return Datatables::of($data)
        ->addColumn('pictures',function($single){
			return '<img class="yoyo" src="'.url('/').'/../upload/assets/'.$single->picture.'" style="width:50px"/>';
        })
        ->addColumn('asset_detail',function($single){

            $asset_detail='Name: <h6>'.$single->name.'</h6>';
            $asset_detail.='AID: <h6>'.$single->assetid.'</h6>';
            
			return $asset_detail;
        })
        ->addColumn('emp_detail',function($single){

            $emp_detail="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->get();

                $emp_detail=$emp_data[0]->fullname.'<br>'.$emp_data[0]->emp_id;
            }
            
			return $emp_detail;
        })
        ->addColumn( 'qr', function ( $single ) {
            
            return '
            <div id="qr_div'.$single->barcode.'">
                <div class="col-md-12" >
                    <div class="row ">
                        <div class="col-md-4" id="qr_div_img_clone'.$single->barcode.'">
                                <div class="assetbarcode" id="qr_div_img'.$single->barcode.'"><img src="data:image/png;base64,' . DNS2D::getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="width:100%;"  /></div>
                        </div>
                        <div class="qr_txt" style="text-align: left;">
                            <h6 id="qr_div_name'.$single->barcode.'">'.$single->type.'</h6><br>
                            <h6 id="qr_div_code'.$single->barcode.'">'.$single->barcode.'</h6>
                        </div>

                    </div>
                </div>
            </div>

            ';
           
        })
        ->addColumn( 'action', function ( $accountsingle ) {
            //for checkout 2 button, checkin or checkout depand the record
            //$checkout = '  <a class="dropdown-item" href="#" id="btncheckout" customdata='.$accountsingle->id.'  data-toggle="modal" data-target="#checkout"><i class="fa fa-check"></i> '. trans('lang.checkout').'</a>';

            if($accountsingle->available_status=="Stock"){
                $checkout = '<a class="dropdown-item" href="#" id="btncheckin" customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal" data-target="#checkin"><i class="fa fa-check"></i> Allocate</a>';
            }
            else if($accountsingle->available_status=="Allocated"){
                $checkout = '<a class="dropdown-item" href="#" id="btncheckout" customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal" data-target="#checkout"><i class="fa fa-check"></i> Get Back</a>';
            }
            else if($accountsingle->available_status=="Retiral"){
                    $checkout = '';
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
                <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                <a class="dropdown-item" href="#" id="btnretiral"  customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal" data-target="#retiral"><i class="fa fa-bed"></i>Move to Retiral</a>
                <a class="dropdown-item" href="#" id="btnedit" customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal"  data-target="#edit"><i class="fa fa-pencil"></i> '. trans('lang.edit').'</a>
                <a class="dropdown-item" href="#" id="btnedit" customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal" data-target="#delete"><i class="fa fa-trash"></i> '. trans('lang.delete').'</a>
                </div>
            </div>'.$action.'';
           
        } )
        ->rawColumns(['asset_detail','qr','pictures','emp_detail', 'action'])
        ->make(true);		
    }
    public function get_asset_info(Request $request)
    {
        $id=$request->id;
        $final_data=DB::table('assets')->where("id",$id)->first();
        
         echo json_encode($final_data);
    }

    // get allocated asset data
    public function get_allocated_asset_data(Request $request){


        $data = DB::table('assets');
        $data =$data->leftJoin('brand', 'assets.brandid', '=', 'brand.id');
        $data =$data->leftjoin('asset_type', 'assets.a_type_id', '=', 'asset_type.id');
        $data =$data->leftJoin('location', 'assets.locationid', '=', 'location.id');
        $data =$data->where('assets.available_status', '=', 'Allocated');
        $data =$data->where('assets.status', '!=', 'Deleted');

        if ($request->has('assettype')) {
        $data =$data->where('assets.a_type_id', 'like', "%{$request->get('assettype')}%");
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
        // where assets.available_status = 'Allocated'
        // and assets.status != 'Deleted'
        // order by assets.created_at desc"); 

        return Datatables::of($data)
        ->addColumn('pictures',function($single){
			return '<img src="'.url('/').'/../upload/assets/'.$single->picture.'" style="width:50px"/>';
        })
        ->addColumn('asset_detail',function($single){

            $asset_detail='Name: <h6>'.$single->name.'</h6>';
            $asset_detail.='AID: <h6>'.$single->assetid.'</h6>';
            
			return $asset_detail;
        })
        ->addColumn( 'qr', function ( $single ) {
            
            return '
            <div id="qr_div'.$single->barcode.'">
                <div class="col-md-12" >
                    <div class="row ">
                        <div class="col-md-4" id="qr_div_img_clone'.$single->barcode.'">
                                <div class="assetbarcode" id="qr_div_img'.$single->barcode.'"><img src="data:image/png;base64,' . DNS2D::getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="width:100%;"  /></div>
                        </div>
                        <div class="qr_txt" style="text-align: left;">
                            <h6 id="qr_div_name'.$single->barcode.'">'.$single->type.'</h6><br>
                            <h6 id="qr_div_code'.$single->barcode.'">'.$single->barcode.'</h6>
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

            if($accountsingle->available_status=="Stock"){
                $checkout = '<a class="dropdown-item" href="#" id="btncheckin" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#checkin"><i class="fa fa-check"></i> Allocate</a>';
            }
            else if($accountsingle->available_status=="Allocated"){
                $checkout = '<a class="dropdown-item" href="#" id="btncheckout" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#checkout"><i class="fa fa-check"></i>Get Back</a>';
            }
            else if($accountsingle->available_status=="Retiral"){
                    $checkout = '';
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
                <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                <a class="dropdown-item" href="#" id="btnedit" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#edit"><i class="fa fa-pencil"></i> '. trans('lang.edit').'</a>
                <a class="dropdown-item" href="#" id="btnedit" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#delete"><i class="fa fa-trash"></i> '. trans('lang.delete').'</a>
                </div>
            </div>'.$action.'';
           
        } )
        ->rawColumns(['asset_detail','qr','pictures','emp_detail', 'action'])
        ->make(true);		
    }

    // retiral asset data
    public function get_retiral_asset_data(Request $request){


        $data = DB::table('assets');
        $data =$data->leftJoin('brand', 'assets.brandid', '=', 'brand.id');
        $data =$data->leftjoin('asset_type', 'assets.a_type_id', '=', 'asset_type.id');
        $data =$data->leftJoin('location', 'assets.locationid', '=', 'location.id');
        $data =$data->where('assets.available_status', '=', 'Retiral');
        $data =$data->where('assets.status', '!=', 'Deleted');

        if ($request->has('assettype')) {
        $data =$data->where('assets.a_type_id', 'like', "%{$request->get('assettype')}%");
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
			return '<img src="'.url('/').'/../upload/assets/'.$single->picture.'" style="width:50px"/>';
        })
        ->addColumn('asset_detail',function($single){

            $asset_detail='Name: <h6>'.$single->name.'</h6>';
            $asset_detail.='AID: <h6>'.$single->assetid.'</h6>';
            
			return $asset_detail;
        })
        ->addColumn( 'qr', function ( $single ) {
            
            return '
            <div id="qr_div'.$single->barcode.'">
                <div class="col-md-12" >
                    <div class="row ">
                        <div class="col-md-4" id="qr_div_img_clone'.$single->barcode.'">
                                <div class="assetbarcode" id="qr_div_img'.$single->barcode.'"><img src="data:image/png;base64,' . DNS2D::getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="width:100%;"  /></div>
                        </div>
                        <div class="qr_txt" style="text-align: left;">
                            <h6 id="qr_div_name'.$single->barcode.'">'.$single->type.'</h6><br>
                            <h6 id="qr_div_code'.$single->barcode.'">'.$single->barcode.'</h6>
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

            if($accountsingle->available_status=="Stock"){
                    $checkout = '<a class="dropdown-item" href="#" id="btncheckin" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#checkin"><i class="fa fa-check"></i> Allocate</a>';
            }
            else if($accountsingle->available_status=="Allocated"){
                $checkout = '<a class="dropdown-item" href="#" id="btncheckout" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#checkout"><i class="fa fa-check"></i> Get Back</a>';
            }
            else if($accountsingle->available_status=="Retiral"){
                    $checkout = '';
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
                <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                <a class="dropdown-item" href="#" id="btnedit" customdata='.$accountsingle->assetid.'  data-toggle="modal" data-target="#delete"><i class="fa fa-trash"></i> '. trans('lang.delete').'</a>
                </div>
            </div>'.$action.'';
           
        } )
        ->rawColumns(['asset_detail','qr','pictures','emp_detail', 'action'])
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

    public function byid( Request $request ) {
        $id            = $request->input( 'id' );

        $data = DB::table('assets')->select('assets.*','assets.name as assetname',
         'assets.description as assetdescription', 
         'assets.created_at as assetcreated_at',
         'assets.updated_at as assetupdated_at', 
         'assets.description as description', 
         'brand.*', 'brand.name as brand',
         'asset_type.name as type',
         'asset_type.field_id as field_id',
         'location.name as location',
         'assets.type as asset_type')
        ->join('brand', 'brand.id', '=', 'assets.brandid')
        ->join('asset_type', 'asset_type.id', '=', 'assets.a_type_id')
        // ->join('supplier', 'supplier.id', '=', 'assets.supplierid')
        ->join('location', 'location.id', '=', 'assets.locationid')
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

            $all_cat_data = DB::table('asset_category_models')->where('status', '!=', 'Deleted')->get();

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

            $all_cat_type_data = DB::table('asset_type')->get();

            $category_type_div='<option value="">Choose Asset Category</option>'; 
            foreach ($all_cat_type_data as $key => $as_cat_t) {
                if ($as_cat_t->id==$data->a_type_id) 
                {
                 
                    $category_type_div.='<option value="'.$as_cat_t->id.'" selected>'.$as_cat_t->name.' </option>';
                    $category_type_field_id=$as_cat_t->field_id;
                }
                else{
                    $category_type_div.='<option value="'.$as_cat_t->id.'">'.$as_cat_t->name.' </option>';
                }
            }

            $all_location_data = DB::table('location')->get();

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


            $type_ar= array('OWN','Rental','BYOD');
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
            $res['category_type_field_id']=$category_type_field_id;
            
            $res['emp_detail']= $s_emp_detail;
            $res['assetcreated_at']= date($setting->formatdate, strtotime($data->assetcreated_at));
            $res['assetupdated_at']= date($setting->formatdate, strtotime($data->assetupdated_at));
            $res['assetdate']= date($setting->formatdate, strtotime($data->date));
            $res['assetcost']= $setting->currency.$data->cost;
            $res['assetwarranty']= $data->warranty.' '.trans('lang.month').' - ('.$nextexpired.')';
            // $res['assetstatus']= $status;
            $res['assetbarcode'] = '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($data->barcode, 'QRCODE') . '" alt="barcode" width="70"  />';
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

        $emp_id   ="";
        $available_status   = "Stock";
        if($request->input( 'allocate_check' )=="Yes"){
            $emp_id     = $request->input( 'emp_id' );
            $available_status    = 'Allocated'; 
 
        }
        $type         = $request->input( 'type' );
        $a_c_id       = $request->input( 'a_c_id' );
        $a_type_id    = $request->input( 'a_type_id' );
        $locationid   = $request->input( 'locationid' );
        $brandid      = $request->input( 'brandid' );
        $assetid      = $request->input( 'assetid' );
        $name         = $request->input( 'name' );
        $quantity     = $request->input( 'quantity' );
        $date         = $request->input( 'date' );
        $barcode      = $request->input( 'barcode' );
        $cost_center      = $request->input( 'cost_center' );
        $cost         = $request->input( 'cost' );
        $ip_address         = $request->input( 'ip_address' );
        $warranty           = "";
        $available_status   = $available_status;
        $emp_id             = $emp_id;
        $spoc_emp_id        = $request->input( 'spoc_emp_id' );
        $r_asset_id             = "";
        $status             = "Active";
        $picture            = $request->file( 'picture' );
        $description        = $request->input( 'description' );
        $defaultimage       = 'pic.png';
        $created_at         = date("Y-m-d H:i:s");
        $updated_at         = date("Y-m-d H:i:s");
        $message = ['picture.mimes'=>trans('lang.upload_error')];

        $emailcheck = DB::table('assets')
        ->where('assetid', '=', $assetid)
        ->first();
        if($emailcheck){
            $res['message'] = 'exist';  
        }
        else{ 
            if($request->input( 'allocate_check' )=="Yes"){
                // insert history
                $assetid        = $request->input( 'assetid' );
                $employeeid     = $request->input( 'emp_id' );
                $allocated_date    = $request->input( 'date' );
                $status         = 'Active'; //checkout = 1
                $available_status    = 'Allocated'; 
                $created_at     = date("Y-m-d H:i:s");
                $updated_at     = date("Y-m-d H:i:s");
                $data           = array('assetid'=>$assetid, 'status'=>$status,'employeeid'=>$employeeid,'allocated_date'=>$allocated_date,'type'=>"Allocation",'reason'=>"",'remark'=>"",'get_back_date'=>"",'location'=>"",'retiraldate'=>"",'created_at'=>$created_at, 'updated_at'=>$updated_at);
                $insert         = DB::table( 'asset_history' )->insert( $data );   
            }
            if($request->hasFile('picture')) {
                $this->validate($request, ['picture' => 'mimes:jpeg,png,jpg|max:2048'],$message);
                $picturename  = date('mdYHis').uniqid().$request->file('picture')->getClientOriginalName();
                $request->file('picture')->move(public_path("/upload/assets"), $picturename);
                $data     = array('name'=>$name, 
                'type'=>$type, 
                'a_c_id'=>$a_c_id,
                'a_type_id'=>$a_type_id,
                'locationid'=>$locationid,
                'brandid'=>$brandid,
                'assetid'=>$assetid,
                'quantity'=>$quantity,
                'date'=>$date,
                'barcode'=>$barcode,
                'cost_center'=>$cost_center,
                'ip_address'=>$ip_address,
                'cost'=>$cost,
                'warranty'=>$warranty,
                'available_status'=>$available_status,
                'emp_id'=>$emp_id, 
                'spoc_emp_id'=>$spoc_emp_id, 
                'r_asset_id'=>$r_asset_id, 
                'status'=>$status,
                'picture'=>$picturename,
                'description'=>$description,
                'created_at'=>$created_at,
                'updated_at'=>$updated_at);    

                    if($request->showable_type==1)
                    {
                       $data     = array('name'=>$name, 
                            'type'=>$type, 
                            'a_c_id'=>$a_c_id,
                            'a_type_id'=>$a_type_id,
                            'locationid'=>$locationid,
                            'brandid'=>$brandid,
                            'assetid'=>$assetid,
                            'quantity'=>$quantity,
                            'date'=>$date,
                            'barcode'=>$barcode,
                            'cost_center'=>$cost_center,
                            'cost'=>$cost,
                            'warranty'=>$warranty,
                            'available_status'=>$available_status,
                            'emp_id'=>$emp_id, 
                            'spoc_emp_id'=>$spoc_emp_id, 
                            'r_asset_id'=>$r_asset_id, 
                            'status'=>$status,
                            'picture'=>$picturename,
                            'description'=>$description,
                            'created_at'=>$created_at,
                            'updated_at'=>$updated_at);         
                    }
                        else if($request->showable_type==2){
                            $data['Asset_Domain']=$request->asset_domain;
                            $data['CPU_Model']=$request->cpu_model;                        
                            $data['CPU_Configuration']=$request->cpu_configuration;                        
                            $data['CPU_Sl']=$request->cpu_si;                        
                            $data['RAM']=$request->ram;                        
                            $data['HDD']=$request->hdd;                        
                            $data['MOUSE']=$request->mouse;                        
                            $data['OS']=$request->os;    
                            $data['Keyboard']=$request->keyboard;  
                            $data['charger']=$request->charger;
                            $data['bag']=$request->bag;                      
                        }
                        else if($request->showable_type==3)
                        {
                            $data['Asset_Domain']=$request->asset_domain;
                            $data['CPU_Model']=$request->cpu_model;                        
                            $data['CPU_Configuration']=$request->cpu_configuration;                        
                            $data['CPU_Sl']=$request->cpu_si;                        
                            $data['RAM']=$request->ram;                        
                            $data['HDD']=$request->hdd;                        
                            $data['MOUSE']=$request->mouse;                        
                            $data['OS']=$request->os;    
                            $data['Keyboard']=$request->keyboard;  
                            $data['mon_size']=$request->mon_size;  
                            $data['mon_serial']=$request->mon_serial;  
                        }
                        else if($request->showable_type==4)
                        {
                            $data['Asset_Domain']=$request->asset_domain;
                            $data['cam_pix']=$request->cam_pix;                        
                            $data['cam_model']=$request->cam_model;                        
                            $data['cam_serial_no']=$request->cam_serial_no;                        
                        }
                        else if($request->showable_type==5)
                        {
                            $data['sof_ver']=$request->sof_ver;
                            $data['sof_qty']=$request->sof_qty;                        
                            $data['sof_user_list']=$request->sof_user_list;                        
                            $data['sof_vendor']=$request->sof_vendor;                        
                            $data['sof_license_key']=$request->sof_license_key;                        
                            $data['sof_expiry_date']=$request->sof_expiry_date;                        
                        }
        

                $insert     = DB::table( 'assets' )->insert( $data ); 

            }else{
                $data     = array('name'=>$name, 
                'type'=>$type, 
                'a_c_id'=>$a_c_id,
                'a_type_id'=>$a_type_id,
                'locationid'=>$locationid,
                'brandid'=>$brandid,
                'assetid'=>$assetid,
                'quantity'=>$quantity,
                'date'=>$date,
                'barcode'=>$barcode,
                'cost_center'=>$cost_center,
                'ip_address'=>$ip_address,
                'cost'=>$cost,
                'warranty'=>$warranty,
                'available_status'=>$available_status,
                'emp_id'=>$emp_id, 
                'spoc_emp_id'=>$spoc_emp_id, 
                'r_asset_id'=>$r_asset_id, 
                'status'=>$status,
                'picture'=>$defaultimage,
                'description'=>$description,
                'created_at'=>$created_at,
                'updated_at'=>$updated_at);    

                if($request->showable_type==1)
                    {
                $data       = array('name'=>$name, 
                                'type'=>$type,
                                'a_c_id'=>$a_c_id,
                                'a_type_id'=>$a_type_id,
                                'locationid'=>$locationid,
                                'brandid'=>$brandid,
                                'assetid'=>$assetid,
                                'quantity'=>$quantity,
                                'date'=>$date,
                                'barcode'=>$barcode,
                                'cost'=>$cost,
                                'warranty'=>$warranty,
                                'available_status'=>$available_status,
                                'emp_id'=>$emp_id, 
                                'spoc_emp_id'=>$spoc_emp_id, 
                                'r_asset_id'=>$r_asset_id, 
                                'status'=>$status,
                                'picture'=>$defaultimage,
                                'description'=>$description,
                                'created_at'=>$created_at,
                                'updated_at'=>$updated_at);
                            }
                            else if($request->showable_type==2){
                                $data['Asset_Domain']=$request->asset_domain;
                                $data['CPU_Model']=$request->cpu_model;                        
                                $data['CPU_Configuration']=$request->cpu_configuration;                        
                                $data['CPU_Sl']=$request->cpu_si;                        
                                $data['RAM']=$request->ram;                        
                                $data['HDD']=$request->hdd;                        
                                $data['MOUSE']=$request->mouse;                        
                                $data['OS']=$request->os;    
                                $data['Keyboard']=$request->keyboard;  
                                $data['charger']=$request->charger;
                                $data['bag']=$request->bag;                      
                            }
                            else if($request->showable_type==3)
                            {
                                $data['Asset_Domain']=$request->asset_domain;
                                $data['CPU_Model']=$request->cpu_model;                        
                                $data['CPU_Configuration']=$request->cpu_configuration;                        
                                $data['CPU_Sl']=$request->cpu_si;                        
                                $data['RAM']=$request->ram;                        
                                $data['HDD']=$request->hdd;                        
                                $data['MOUSE']=$request->mouse;                        
                                $data['OS']=$request->os;    
                                $data['Keyboard']=$request->keyboard;  
                                $data['mon_size']=$request->mon_size;  
                                $data['mon_serial']=$request->mon_serial; 
                            }
                            else if($request->showable_type==4)
                            {
                                $data['Asset_Domain']=$request->asset_domain;
                                $data['cam_pix']=$request->cam_pix;                        
                                $data['cam_model']=$request->cam_model;                        
                                $data['cam_serial_no']=$request->cam_serial_no;                        
                            }
                            else if($request->showable_type==5)
                            {
                                $data['sof_ver']=$request->sof_ver;
                                $data['sof_qty']=$request->sof_qty;                        
                                $data['sof_user_list']=$request->sof_user_list;                        
                                $data['sof_vendor']=$request->sof_vendor;                        
                                $data['sof_license_key']=$request->sof_license_key;                        
                                $data['sof_expiry_date']=$request->sof_expiry_date;                        
                            }
            
                $insert     = DB::table( 'assets' )->insert( $data );

            }

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
     * @param string  $picture
     * @param string  $gender
     * @param string  $city
     * @param string  $country
     * @param string  $phone
	 * @return object
	 */
    public function update(Request $request){
        $id             = $request->input( 'id' );
        $type             = $request->input( 'type' );
        $category_id     = $request->input( 'category_id' );
        $category_type_id     = $request->input( 'category_type_id' );
        $name         = $request->input( 'name' );
        $assetid        = $request->input( 'assetid' );
        $barcode       = $request->input( 'barcode' );
        $cost_center       = $request->input( 'cost_center' );
        $locationid           = $request->input( 'locationid' );
        $brandid         = $request->input( 'brandid' );
        $cost       = $request->input( 'cost' );
        $date   = $request->input( 'date' );
        $spoc_employeeid           = $request->input( 'spoc_employeeid' );
        $allocate_check       = $request->input( 'allocate_check' );
        $employeeid             = $request->input( 'employeeid' );
        $description         = $request->input( 'description' );
        $picture        = $request->file( 'picture' );
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");
        $message = ['picture.mimes'=>trans('lang.upload_error')];



                $data=array('type'=>$type,
                'a_c_id'=>$category_id,
                'a_type_id'=>$category_type_id,
                'locationid'=>$locationid,
                'name'=>$name,
                'brandid'=>$brandid,
                'assetid'=>$assetid,
                'date'=>$date,
                'barcode'=>$barcode,
                'cost_center'=>$cost_center,
                'cost'=>$cost,
                'emp_id'=>$employeeid, 
                'spoc_emp_id'=>$spoc_employeeid, 
                'description'=>$description,
                'updated_at' => $updated_at);



        if($request->hasFile('picture')) {
            $this->validate($request, ['picture' => 'mimes:jpeg,png,jpg|max:2048'],$message);
            $picturename  = date('mdYHis').uniqid().$request->file('picture')->getClientOriginalName();
            $request->file('picture')->move(public_path("/upload/assets"), $picturename);

            if($request->showable_type==2)
            {
               $data['picture']=$picturename;
               $data['Asset_Domain']=$request->asset_domain;
               $data['CPU_Model']=$request->cpu_model;
               $data['CPU_Configuration']=$request->cpu_configuration;
               $data['CPU_Sl']=$request->cpu_si;
               $data['RAM']=$request->ram;
               $data['HDD']=$request->hdd;
               $data['MOUSE']=$request->mouse;
               $data['Keyboard']=$request->Keyboard;
               $data['OS']=$request->os;
               $data['charger']=$request->charger;
               $data['bag']=$request->bag;
               $update = DB::table( 'assets' )->where( 'assetid', $assetid )
                ->update($data);
            }
            else if($request->showable_type==3)
            {
               $data['picture']=$picturename;
               $data['Asset_Domain']=$request->asset_domain;
               $data['CPU_Model']=$request->cpu_model;
               $data['CPU_Configuration']=$request->cpu_configuration;
               $data['CPU_Sl']=$request->cpu_si;
               $data['RAM']=$request->ram;
               $data['HDD']=$request->hdd;
               $data['MOUSE']=$request->mouse;
               $data['Keyboard']=$request->Keyboard;
               $data['OS']=$request->os; 

               $data['mon_size']=$request->mon_size;  
                $data['mon_serial']=$request->mon_serial;  

               $update = DB::table( 'assets' )->where( 'assetid', $assetid )
                ->update($data);
            }
            else if($request->showable_type==4)
            {
               $data['picture']=$picturename;
               $data['Asset_Domain']=$request->asset_domain;
               $data['cam_pix']=$request->cam_pix;
               $data['cam_model']=$request->cam_model;
               $data['cam_serial_no']=$request->cam_serial_no;

               $update = DB::table( 'assets' )->where( 'assetid', $assetid )
                ->update($data);
            }
            else{
                $data['picture']=$picturename;
                $update = DB::table( 'assets' )->where( 'assetid', $assetid )
                ->update($data);
            }
            // $update = DB::table( 'assets' )->where( 'assetid', $assetid )
            // ->update(
            //     [
            //         'type'=>$type,
            //         'a_c_id'=>$category_id,
            //         'a_type_id'=>$category_type_id,
            //         'locationid'=>$locationid,
            //         'name'=>$name,
            //         'brandid'=>$brandid,
            //         'assetid'=>$assetid,
            //         'date'=>$date,
            //         'barcode'=>$barcode,
            //         'cost'=>$cost,
            //         'emp_id'=>$employeeid, 
            //         'spoc_emp_id'=>$spoc_employeeid, 
            //         'description'=>$description,
            //     'picture'             => $picturename,
            //     'updated_at'          => $updated_at
            //     ]
            // );
        }else{
            if($request->showable_type==2)
            {
               $data['Asset_Domain']=$request->asset_domain;
               $data['CPU_Model']=$request->cpu_model;
               $data['CPU_Configuration']=$request->cpu_configuration;
               $data['CPU_Sl']=$request->cpu_si;
               $data['RAM']=$request->ram;
               $data['HDD']=$request->hdd;
               $data['MOUSE']=$request->mouse;
               $data['Keyboard']=$request->Keyboard;
               $data['OS']=$request->os;
               $data['charger']=$request->charger;
               $data['bag']=$request->bag;
               $update = DB::table( 'assets' )->where( 'assetid', $assetid )
                ->update($data);
            }
            else  if($request->showable_type==3)
            {
               $data['Asset_Domain']=$request->asset_domain;
               $data['CPU_Model']=$request->cpu_model;
               $data['CPU_Configuration']=$request->cpu_configuration;
               $data['CPU_Sl']=$request->cpu_si;
               $data['RAM']=$request->ram;
               $data['HDD']=$request->hdd;
               $data['MOUSE']=$request->mouse;
               $data['Keyboard']=$request->Keyboard;
               $data['OS']=$request->os;

               $data['mon_size']=$request->mon_size;  
               $data['mon_serial']=$request->mon_serial; 
          
               $update = DB::table( 'assets' )->where( 'assetid', $assetid )
                ->update($data);
            }
            else if($request->showable_type==4)
            {
                $data['Asset_Domain']=$request->asset_domain;
                $data['cam_pix']=$request->cam_pix;
                $data['cam_model']=$request->cam_model;
                $data['cam_serial_no']=$request->cam_serial_no;

                $update = DB::table( 'assets' )->where( 'assetid', $assetid )
                ->update($data);
            }
            else if($request->showable_type==5)
            {
                $data['sof_ver']=$request->sof_ver;
                $data['sof_qty']=$request->sof_qty;                        
                $data['sof_user_list']=$request->sof_user_list;                        
                $data['sof_vendor']=$request->sof_vendor;                        
                $data['sof_license_key']=$request->sof_license_key;                        
                $data['sof_expiry_date']=$request->sof_expiry_date;                        
            }
            else{
                $update = DB::table( 'assets' )->where( 'assetid', $assetid )
                ->update($data);
            }
            // $update = DB::table( 'assets' )->where( 'assetid', $assetid )
            // ->update(
            //     [
            //         'type'=>$type,
            //         'a_c_id'=>$category_id,
            //         'a_type_id'=>$category_type_id,
            //         'locationid'=>$locationid,
            //         'name'=>$name,
            //         'brandid'=>$brandid,
            //         'assetid'=>$assetid,
            //         'date'=>$date,
            //         'barcode'=>$barcode,
            //         'cost'=>$cost,
            //         'emp_id'=>$employeeid, 
            //         'spoc_emp_id'=>$spoc_employeeid, 
            //         'description'=>$description,
            //         'updated_at'          => $updated_at
            //     ]
            // );
        }

            if ( $update ) {
                $res['message'] = 'success';
                
            } else{
                $res['message'] = 'failed';
            }
        // }
        return response( $res );
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
        if($form_filled_id==2)
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

        $update = DB::table( 'asset_history' )->where( 'assetid', $assetid )
            ->update(
                [
                    'location'  =>  $location,
                    'get_back_date'  =>  $get_back_date,
                    'updated_at' => $updated_at,           
                ]
            );

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
        if($form_filled_id==2)
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
        $data = DB::table('assets')->where('status','Active')->get();
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

        // $delete = DB::table( 'assets' )->where( 'id', $id )->delete();
        // $notdefaultimage = 'pic.png';
        // $filename = $getfilename->picture;

        // if($filename != $notdefaultimage){
        //     $deleteimage = File::delete('upload/assets/'.$getfilename->picture);
        // }

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


}
