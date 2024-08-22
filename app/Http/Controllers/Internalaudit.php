<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

class Internalaudit extends Controller
{
    //
    public function __construct() {

		// $data = $this->getapplications();
		// $lang = $data->language;
		// App::setLocale($lang);
        $this->middleware('auth');
    }

    //return view
    public function index() {
		return view( 'internalaudit.index' );
    }

    /**
	 * get data from database
	 * @return object
	 */
    public function getdata(Request $request){

        $asset_type=$request->input('asset_type');
        $filter_location=$request->input('filter_location');
        $type=$request->input('filter_type');


        $today=date('Y-m-d');
        $minus_date=date('Y-m-d', strtotime("-7 day", strtotime($today)));

        if($type=="All"){
            if($filter_location!="" && $asset_type!=""){

                // echo "1";
                // exit();

                $data = DB::select("select assets.*, brand.name as brand, asset_type.name as asset_type , location.name as location
                from assets
                left join brand
                on assets.brandid = brand.id
                left join asset_type
                on assets.a_type_id = asset_type.id
                left join location
                on assets.locationid = location.id
                where assets.a_type_id = $asset_type
                and assets.locationid = $filter_location
                and assets.status != 'Deleted'
                order by assets.created_at desc");
            }
            if($filter_location!="" && $asset_type ==""){
                // echo "2";
                // exit();

                $data = DB::select("select assets.*, brand.name as brand, asset_type.name as asset_type , location.name as location
                from assets
                left join brand
                on assets.brandid = brand.id
                left join asset_type
                on assets.a_type_id = asset_type.id
                left join location
                on assets.locationid = location.id
                where assets.locationid = $filter_location
                and assets.status != 'Deleted'
                order by assets.created_at desc");
            }
            if($filter_location=="" && $asset_type!=""){
                // echo "3";
                // exit();

                $data = DB::select("select assets.*, brand.name as brand, asset_type.name as asset_type , location.name as location
                from assets
                left join brand
                on assets.brandid = brand.id
                left join asset_type
                on assets.a_type_id = asset_type.id
                left join location
                on assets.locationid = location.id
                where assets.a_type_id = $asset_type
                and assets.status != 'Deleted'
                order by assets.created_at desc");
            }
            if($filter_location=="" && $asset_type==""){

                // echo "4";
                // exit();

                $data = DB::select("select assets.*, brand.name as brand, asset_type.name as asset_type , location.name as location
                from assets
                left join brand
                on assets.brandid = brand.id
                left join asset_type
                on assets.a_type_id = asset_type.id
                left join location
                on assets.locationid = location.id
                where assets.status != 'Deleted'
                order by assets.created_at desc");
            }

        }
        elseif ($type=="Audited") {
            // echo "5";
            // exit();

            if($filter_location!="" && $asset_type!=""){
                $record = DB::table('assets');
                $record = $record->join('brand', 'assets.brandid','=','brand.id');
                $record = $record->join('asset_type', 'assets.a_type_id','=','asset_type.id');
                $record = $record->join('internal_audit_models', 'assets.barcode','=','internal_audit_models.assetid');
                $record = $record->join('location', 'assets.locationid','=','location.id');
                $record = $record->where('assets.status','!=','Deleted');
                $record = $record->where('assets.a_type_id','=',$asset_type);
                $record = $record->where('assets.locationid','=',$filter_location);
                $record = $record->whereDate('internal_audit_models.created_at', '>=', $minus_date);
                $record = $record->whereDate('internal_audit_models.created_at', '<=', $today);
                $record = $record->select('assets.*', 'brand.name as brand', 'asset_type.name as type ', 'location.name as location' , 'internal_audit_models.created_at as audit_date');
                $record = $record->get();

                $data=$record;
            }
            if($filter_location!="" && $asset_type ==""){
                // echo "6";
                // exit();
                $record = DB::table('assets');
                $record = $record->join('brand', 'assets.brandid','=','brand.id');
                $record = $record->join('asset_type', 'assets.a_type_id','=','asset_type.id');
                $record = $record->join('internal_audit_models', 'assets.barcode','=','internal_audit_models.assetid');
                $record = $record->join('location', 'assets.locationid','=','location.id');
                $record = $record->where('assets.status','!=','Deleted');
                $record = $record->where('assets.locationid','=',$filter_location);
                $record = $record->whereDate('internal_audit_models.created_at', '>=', $minus_date);
                $record = $record->whereDate('internal_audit_models.created_at', '<=', $today);
                $record = $record->select('assets.*', 'brand.name as brand', 'asset_type.name as type ', 'location.name as location' , 'internal_audit_models.created_at as audit_date');
                $record = $record->get();

                $data=$record;

            }
            if($filter_location=="" && $asset_type!=""){
                // echo "7";
                // exit();
                $record = DB::table('assets');
                $record = $record->join('brand', 'assets.brandid','=','brand.id');
                $record = $record->join('asset_type', 'assets.a_type_id','=','asset_type.id');
                $record = $record->join('internal_audit_models', 'assets.barcode','=','internal_audit_models.assetid');
                $record = $record->join('location', 'assets.locationid','=','location.id');
                $record = $record->where('assets.status','!=','Deleted');
                $record = $record->where('assets.a_type_id','=',$asset_type);
                $record = $record->whereDate('internal_audit_models.created_at', '>=', $minus_date);
                $record = $record->whereDate('internal_audit_models.created_at', '<=', $today);
                $record = $record->select('assets.*', 'brand.name as brand', 'asset_type.name as type ', 'location.name as location' , 'internal_audit_models.created_at as audit_date');
                $record = $record->get();

                $data=$record;

            }
            if($filter_location=="" && $asset_type==""){

                // echo "8";
                // exit();
                $record = DB::table('assets');
                $record = $record->join('brand', 'assets.brandid','=','brand.id');
                $record = $record->join('asset_type', 'assets.a_type_id','=','asset_type.id');
                $record = $record->join('internal_audit_models', 'assets.barcode','=','internal_audit_models.assetid');
                $record = $record->join('location', 'assets.locationid','=','location.id');
                $record = $record->where('assets.status','!=','Deleted');
                $record = $record->whereDate('internal_audit_models.created_at', '>=', $minus_date);
                $record = $record->whereDate('internal_audit_models.created_at', '<=', $today);
                $record = $record->select('assets.*', 'brand.name as brand', 'asset_type.name as type ', 'location.name as location' , 'internal_audit_models.created_at as audit_date');
                $record = $record->get();

                $data=$record;
            }
        }
        elseif ($type=="Not Audited") {

            if($filter_location!="" && $asset_type!=""){

                $record = DB::table('assets');
                $record = $record->join('brand', 'assets.brandid','=','brand.id');
                $record = $record->join('asset_type', 'assets.a_type_id','=','asset_type.id');
                $record = $record->join('internal_audit_models', 'assets.barcode','=','internal_audit_models.assetid');
                $record = $record->join('location', 'assets.locationid','=','location.id');
                $record = $record->where('assets.a_type_id','=',$asset_type);
                $record = $record->where('assets.locationid','=',$filter_location);
                $record = $record->where('assets.status','!=','Deleted');
                $record = $record->whereDate('internal_audit_models.created_at', '>=', $minus_date);
                $record = $record->whereDate('internal_audit_models.created_at', '<=', $today);
                $record = $record->select('assets.*', 'brand.name as brand', 'asset_type.name as type ', 'location.name as location' , 'internal_audit_models.created_at as audit_date');
                $record = $record->get();

                $have_asset=array();
                foreach($record as $row){
                    $have_asset[]=$row->assetid;
                }

                $record_2 = DB::table('assets');
                $record_2 = $record_2->join('brand', 'assets.brandid','=','brand.id');
                $record_2 = $record_2->join('asset_type', 'assets.a_type_id','=','asset_type.id');
                $record_2 = $record_2->join('location', 'assets.locationid','=','location.id');
                $record_2 = $record_2->whereNotIn('assets.assetid',$have_asset);
                $record_2 = $record_2->where('assets.a_type_id','=',$asset_type);
                $record_2 = $record_2->where('assets.locationid','=',$filter_location);
                $record_2 = $record_2->where('assets.status','!=','Deleted');
                $record_2 = $record_2->select('assets.*', 'brand.name as brand', 'asset_type.name as type ', 'location.name as location');
                $record_2 = $record_2->get();

                $data=$record_2;

            }
            if($filter_location!="" && $asset_type ==""){

                $record = DB::table('assets');
                $record = $record->join('brand', 'assets.brandid','=','brand.id');
                $record = $record->join('asset_type', 'assets.a_type_id','=','asset_type.id');
                $record = $record->join('internal_audit_models', 'assets.barcode','=','internal_audit_models.assetid');
                $record = $record->join('location', 'assets.locationid','=','location.id');
                $record = $record->where('assets.locationid','=',$filter_location);
                $record = $record->where('assets.status','!=','Deleted');
                $record = $record->whereDate('internal_audit_models.created_at', '>=', $minus_date);
                $record = $record->whereDate('internal_audit_models.created_at', '<=', $today);
                $record = $record->select('assets.*', 'brand.name as brand', 'asset_type.name as type ', 'location.name as location' , 'internal_audit_models.created_at as audit_date');
                $record = $record->get();

                $have_asset=array();
                foreach($record as $row){
                    $have_asset[]=$row->assetid;
                }

                $record_2 = DB::table('assets');
                $record_2 = $record_2->join('brand', 'assets.brandid','=','brand.id');
                $record_2 = $record_2->join('asset_type', 'assets.a_type_id','=','asset_type.id');
                $record_2 = $record_2->join('location', 'assets.locationid','=','location.id');
                $record_2 = $record_2->whereNotIn('assets.assetid',$have_asset);
                $record_2 = $record_2->where('assets.locationid','=',$filter_location);
                $record_2 = $record_2->where('assets.status','!=','Deleted');
                $record_2 = $record_2->select('assets.*', 'brand.name as brand', 'asset_type.name as type ', 'location.name as location');
                $record_2 = $record_2->get();

                $data=$record_2;

            }
            if($filter_location=="" && $asset_type!=""){

                $record = DB::table('assets');
                $record = $record->join('brand', 'assets.brandid','=','brand.id');
                $record = $record->join('asset_type', 'assets.a_type_id','=','asset_type.id');
                $record = $record->join('internal_audit_models', 'assets.barcode','=','internal_audit_models.assetid');
                $record = $record->join('location', 'assets.locationid','=','location.id');
                $record = $record->where('assets.a_type_id','=',$asset_type);
                $record = $record->where('assets.status','!=','Deleted');
                $record = $record->whereDate('internal_audit_models.created_at', '>=', $minus_date);
                $record = $record->whereDate('internal_audit_models.created_at', '<=', $today);
                $record = $record->select('assets.*', 'brand.name as brand', 'asset_type.name as type ', 'location.name as location' , 'internal_audit_models.created_at as audit_date');
                $record = $record->get();

                $have_asset=array();
                foreach($record as $row){
                    $have_asset[]=$row->assetid;
                }

                $record_2 = DB::table('assets');
                $record_2 = $record_2->join('brand', 'assets.brandid','=','brand.id');
                $record_2 = $record_2->join('asset_type', 'assets.a_type_id','=','asset_type.id');
                $record_2 = $record_2->join('location', 'assets.locationid','=','location.id');
                $record_2 = $record_2->whereNotIn('assets.assetid',$have_asset);
                $record_2 = $record_2->where('assets.a_type_id','=',$asset_type);
                $record_2 = $record_2->where('assets.status','!=','Deleted');
                $record_2 = $record_2->select('assets.*', 'brand.name as brand', 'asset_type.name as type ', 'location.name as location');
                $record_2 = $record_2->get();

                $data=$record_2;


            }


            if($filter_location=="" && $asset_type==""){
                $record = DB::table('assets');
                $record = $record->join('brand', 'assets.brandid','=','brand.id');
                $record = $record->join('asset_type', 'assets.a_type_id','=','asset_type.id');
                $record = $record->join('internal_audit_models', 'assets.barcode','=','internal_audit_models.assetid');
                $record = $record->join('location', 'assets.locationid','=','location.id');
                $record = $record->where('assets.status','!=','Deleted');
                $record = $record->whereDate('internal_audit_models.created_at', '>=', $minus_date);
                $record = $record->whereDate('internal_audit_models.created_at', '<=', $today);
                $record = $record->select('assets.*', 'brand.name as brand', 'asset_type.name as type ', 'location.name as location' , 'internal_audit_models.created_at as audit_date');
                $record = $record->get();

                $have_asset=array();
                foreach($record as $row){
                    $have_asset[]=$row->assetid;
                }

                $record_2 = DB::table('assets');
                $record_2 = $record_2->join('brand', 'assets.brandid','=','brand.id');
                $record_2 = $record_2->join('asset_type', 'assets.a_type_id','=','asset_type.id');
                $record_2 = $record_2->join('location', 'assets.locationid','=','location.id');
                $record_2 = $record_2->whereNotIn('assets.assetid',$have_asset);
                $record_2 = $record_2->where('assets.status','!=','Deleted');
                $record_2 = $record_2->select('assets.*', 'brand.name as brand', 'asset_type.name as type ', 'location.name as location');
                $record_2 = $record_2->get();

                $data=$record_2;

            }
        }

        return Datatables::of($data)

        ->addColumn('bg_color',function($accountsingle)use($type){

            if($type=="All"){
                $today=date('Y-m-d');
                $minus_date=date('Y-m-d', strtotime("-7 day", strtotime($today)));

                $entry = DB::table('internal_audit_models')
                ->where('assetid', $accountsingle->barcode)
                ->whereDate('created_at', '>=', $minus_date)
                ->whereDate('created_at', '<=', $today)
                ->get();

                if(isset($entry[0])){
                    $bg_color='green';
                }
                else{
                    $bg_color='red';
                }
            }
            elseif($type=="Audited"){
                $bg_color='green';
            }
            elseif($type=="Not Audited"){
                $bg_color='red';
            }
			return $bg_color;
        })
        ->addColumn('pictures',function($single){

            if($single->picture !=""){
                return '<img class="yoyo" src="'.url('/').'/../upload/assets/'.$single->picture.'" style="width:50px"/>';
            }else{
                return '<img class="yoyo" src="'.url('/').'/../upload/assets/pic.png" style="width:50px"/>';
            }
        })

        ->addColumn('asset_detail',function($single){
            $asset_detail='Name: <h6>'.$single->name.'</h6>';
            $asset_detail.='AID: <h6>'.$single->assetid.'</h6>';
            $asset_detail.='QR Code: <h6>'.$single->barcode.'</h6>';

			return $asset_detail;
        })

        ->addColumn('emp_detail',function($single){
            $emp_detail="";
            if($single->emp_id!=""){
                $emp_data = DB::table('employees')->where("emp_id",$single->emp_id)->get();
                if(isset($emp_data[0]->fullname)      ){
                    $emp_detail=$emp_data[0]->fullname.'<br>'.$emp_data[0]->emp_id;
                }else{
                    $emp_detail="";
                }
            }
			return $emp_detail;
        })
        ->addColumn( 'action', function ( $accountsingle ) {
            return '
                <div class="btn-group">
                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                </button>
                <div class="dropdown-menu actionmenu">
                <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                </div>
            </div>';

        } )->rawColumns(['bg_color','pictures','emp_detail','asset_detail', 'action'])
        ->make(true);
    }

    public function save_data(Request $request)
    {
        $today=date('Y-m-d');
        $minus_date=date('Y-m-d', strtotime("-7 day", strtotime($today)));

        $save_credentials=[
            'assetid'=>$request->input('scan_assetid'),
        ];

        $emailcheck = DB::table('assets')
        ->where('barcode', '=', $save_credentials['assetid'])
        ->first();

        if($emailcheck){

            $entry = DB::table('internal_audit_models')
            ->where('assetid', $save_credentials['assetid'])
            ->whereDate('created_at', '>=', $minus_date)
            ->whereDate('created_at', '<=', $today)
            ->get();


            if(isset($entry[0])){
                $resp= "Recently Updated..!";
                return response()->json(['response'=>$resp,'assetid'=>$save_credentials['assetid']]);
            }
            else{

                $created_at     = date("Y-m-d H:i:s");
                $updated_at     = date("Y-m-d H:i:s");

                $data           = array('assetid'=>$save_credentials['assetid'],'created_at'=>$created_at, 'updated_at'=>$updated_at);
                $insert         = DB::table( 'internal_audit_models' )->insert( $data );

                $resp="Success";
                return response()->json(['response'=>$resp,'assetid'=>$save_credentials['assetid']]);
            }

        }
        else{
            $resp= "Not Valid ID..!";
            return response()->json(['response'=>$resp,'assetid'=>$save_credentials['assetid']]);
        }


    }

}
