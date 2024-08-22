<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ComponentModel;
use Illuminate\Support\Facades\File; 
use Yajra\Datatables\Datatables;
use App\Http\Controllers\TraitSettings;
use DB;
use App\User;
use App;
use Auth;
use Milon\Barcode\DNS2D;
use Session;


class Component extends Controller
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
		return view( 'component.index' );
    }

    
    /**
	 * get  detail page
	 * @return object
	 */
    public function detail($componentid){
        return view('component.detail', compact('componentid'));
    }

    /**
     * check quantity 
     * @return object
     */
    public function checkquantity($componentid, $quantity, $status){
            $usedquantity = 0;
            $used =   DB::table('component_assets')
            ->select(array( DB::raw('SUM(component_assets.quantity) as components')))
            ->where('status', $status)
            ->where('component_assets.componentid',$componentid)->first();
                $usedquantity = $used->components;
            if(!$used){
                $usedquantity = 0;
            }
            $remain =  $quantity - $usedquantity;
            return $remain;
    }

    /**
	 * get data from database
	 * @return object
	 */
    public function getdata(){
        $data = DB::select("select component.*, supplier.name as supplier, location.name as location, brand.name as brand, asset_type.name as type 
        from component left join supplier 
        on component.supplierid = supplier.id
        left join brand 
        on component.brandid = brand.id
        left join location 
        on component.locationid = location.id
        left join asset_type
        on component.typeid = asset_type.id
        order by component.created_at desc"); 
        return Datatables::of($data)
        ->addColumn('avalaiblequantity',function($single){

            $remain = $this->checkquantity($single->id, $single->quantity, 1);
			return $remain;
        })
        ->addColumn('pictures',function($single){
			return '<img src="'.url('/').'/../upload/assets/'.$single->picture.'" style="width:90px"/>';
        })
		->addColumn( 'action', function ( $accountsingle ) {
            //for checkout 2 button, checkin or checkout depand the record

            $remain = $this->checkquantity($accountsingle->id, $accountsingle->quantity, 1);
            $checkout = '<a class="dropdown-item" href="#" id="btncheckin" customdata='.$accountsingle->id.'  data-toggle="modal" data-target="#checkout"><i class="fa fa-check"></i> '. trans('lang.checkout').'</a>';

            if($accountsingle->checkstatus===2 ){
                    if($remain === 0){
                        $checkout = '';
                    }
                    else{
                        $checkout = '<a class="dropdown-item" href="#" id="btncheckout"  customdata='.$accountsingle->id.'  data-toggle="modal" data-target="#checkout"><i class="fa fa-check"></i> '. trans('lang.checkout').'</a>';
                    }
            }        

            return '
                <div class="btn-group">
                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                </button>
                <div class="dropdown-menu actionmenu">
               '.$checkout.'
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="'.url('/').'/componentlist/detail/'.$accountsingle->id.'"id="btndetail" customdata='.$accountsingle->id.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>
                <a class="dropdown-item" href="#" id="btnedit" customdata='.$accountsingle->id.'  data-toggle="modal" data-target="#edit"><i class="fa fa-pencil"></i> '. trans('lang.edit').'</a>
                <a class="dropdown-item" href="#" id="btnedit" customdata='.$accountsingle->id.'  data-toggle="modal" data-target="#delete"><i class="fa fa-trash"></i> '. trans('lang.delete').'</a>
                </div>
            </div>';
        } )->rawColumns(['avalaiblequantity','pictures', 'action'])
        ->make(true);		
    }




    /**
	 * get single data 
	 * @param integer $id
	 * @return object
	 */

    public function byid( Request $request ) {
        $id            = $request->input( 'id' );

        $data = DB::table('component')->select('component.*','component.name as componentname', 'component.created_at as assetcreated_at', 'component.updated_at as assetupdated_at', 'component.description as componentdescription', 'brand.*', 'brand.name as brand','asset_type.name as type','supplier.name as supplier','location.name as location')
        ->join('brand', 'brand.id', '=', 'component.brandid')
        ->join('asset_type', 'asset_type.id', '=', 'component.typeid')
        ->join('supplier', 'supplier.id', '=', 'component.supplierid')
        ->join('location', 'location.id', '=', 'component.locationid')
        ->where('component.id',$id)
        ->first();
        
        if ( $data ) {

            //set status
            if($data->status=='1'){
                $status = trans('lang.readytodeploy');
            }
            if($data->status=='2'){
                $status = trans('lang.pending');
            }
            if($data->status=='3'){
                $status = trans('lang.archived');
            }
            if($data->status=='4'){
                $status = trans('lang.broken');
            }
            if($data->status=='5'){
                $status = trans('lang.lost');
            }
            if($data->status=='6'){
                $status = trans('lang.outofrepair');
            }

            //get date format setting
            $setting = DB::table('settings')->where('id', '1')->first();


			$res['success'] = 'success';
            $res['message']= $data;
            $res['assetcreated_at']= date($setting->formatdate, strtotime($data->assetcreated_at));
            $res['assetupdated_at']= date($setting->formatdate, strtotime($data->updated_at));
            $res['assetpurchasedate']= date($setting->formatdate, strtotime($data->purchasedate));
            $res['assetcost']= $setting->currency.$data->cost;
            $res['assetstatus']= $status;
           

            $res['assetimage']  = url('/').'/../upload/assets/'.$data->picture;
        } else{
            $res['success'] = 'failed';
        }
        return response( $res );
        
    }


    /**
     * get single data 
     * @param integer $id
     * @return object
     */

    public function singlehistorycomponentbyid( Request $request ) {
        $id            = $request->input( 'id' );

        $data = DB::table('component_assets')->select('component_assets.*')
        ->where('component_assets.id',$id)
        ->first();
        
        if ( $data ) {

            $res['success'] = 'success';
            $res['message']= $data;
          
        } else{
            $res['success'] = 'failed';
        }
        return response( $res );
        
    }


    /**
	 * insert data  to database
	 *
	 * @param integer  $supplierid
     * @param integer  $typeid
     * @param integer  $brandid
	 * @param string  $locationid
     * @param string  $name
     * @param string  $serial
     * @param string  $quantity
     * @param string  $purchasedate
     * @param string  $cost
     * @param string  $warranty
     * @param string  $status
     * @param string  $picture
     * @param string  $description
     * @return object
	 */
    public function save(Request $request){
        $supplierid         = $request->input( 'supplierid' );
        $locationid         = $request->input( 'locationid' );
        $typeid             = $request->input( 'typeid' );
        $brandid            = $request->input( 'brandid' );
        $name               = $request->input( 'name' );
        $serial             = $request->input( 'serial' );
        $quantity           = $request->input( 'quantity' );
        $purchasedate       = $request->input( 'purchasedate' );
        $cost               = $request->input( 'cost' );
        $warranty           = $request->input( 'warranty' );
        $status             = $request->input( 'status' );
        $picture            = $request->file( 'picture' );
        $description        = $request->input( 'description' );
        $defaultimage       = 'pic.png';
        $created_at         = date("Y-m-d H:i:s");
        $updated_at         = date("Y-m-d H:i:s");
        $created_by     = Auth::user()->email;
        $message = ['picture.mimes'=>trans('lang.upload_error')];

       
      
            if($request->hasFile('picture')) {
                $this->validate($request, ['picture' => 'mimes:jpeg,png,jpg|max:2048'],$message);
                $picturename  = date('mdYHis').uniqid().$request->file('picture')->getClientOriginalName();
                $request->file('picture')->move(public_path("/upload/assets"), $picturename);
                $data       = array('name'=>$name, 
                            'locationid'=>$locationid,
                            'supplierid'=>$supplierid,
                            'brandid'=>$brandid,
                            'typeid'=>$typeid,
                            'serial'=>$serial,
                            'quantity'=>$quantity,
                            'purchasedate'=>$purchasedate,
                            'cost'=>$cost,
                            'warranty'=>$warranty,
                            'status'=>$status,
                            'picture'=>$picturename,
                            'description'=>$description,
                            'checkstatus'=>0,
                            'created_at'=>$created_at,
                            'created_by'=>$created_by,
                            'updated_at'=>$updated_at);
                $insert     = DB::table( 'component' )->insert( $data ); 

            }else{
                $data       = array('name'=>$name, 
                                'locationid'=>$locationid,
                                'supplierid'=>$supplierid,
                                'typeid'=>$typeid,
                                'brandid'=>$brandid,
                                'serial'=>$serial,
                                'quantity'=>$quantity,
                                'purchasedate'=>$purchasedate,
                                'cost'=>$cost,
                                'warranty'=>$warranty,
                                'status'=>$status,
                                'checkstatus'=>0,
                                'picture'=>$defaultimage,
                                'description'=>$description,
                                'created_at'=>$created_at,
                                'updated_at'=>$updated_at);

                $insert     = DB::table( 'component' )->insert( $data );

            }

            if ( $insert ) {
                $res['message'] = 'success';
                
            } else{
                $res['message'] = 'failed';
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
        $id                 = $request->input( 'id' );
        $supplierid         = $request->input( 'supplierid' );
        $locationid         = $request->input( 'locationid' );
        $typeid             = $request->input( 'typeid' );
        $brandid            = $request->input( 'brandid' );
        $name               = $request->input( 'name' );
        $serial             = $request->input( 'serial' );
        $quantity           = $request->input( 'quantity' );
        $purchasedate       = $request->input( 'purchasedate' );
        $cost               = $request->input( 'cost' );
        $warranty           = $request->input( 'warranty' );
        $status             = $request->input( 'status' );
        $picture            = $request->file( 'picture' );
        $description        = $request->input( 'description' );
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");
        $message = ['picture.mimes'=>trans('lang.upload_error')];

        
    
       
        if($request->hasFile('picture')) {
            $this->validate($request, ['picture' => 'mimes:jpeg,png,jpg|max:2048'],$message);
            $picturename  = date('mdYHis').uniqid().$request->file('picture')->getClientOriginalName();
            $request->file('picture')->move(public_path("/upload/assets"), $picturename);

            $update = DB::table( 'component' )->where( 'id', $id )
            ->update(
                [
                'name'                => $name,
                'locationid'          => $locationid,    
                'supplierid'          => $supplierid,
                'brandid'             => $brandid,
                'typeid'              => $typeid,
                'serial'              => $serial,
                'quantity'            => $quantity,
                'purchasedate'        => $purchasedate,
                'cost'                => $cost,
                'warranty'            => $warranty,
                'status'              => $status,
                'description'         => $description,
                'picture'             => $picturename,
                'updated_at'          => $updated_at
                ]
            );
        }else{
            $update = DB::table( 'component' )->where( 'id', $id )
            ->update(
                [
                    'name'                => $name,
                    'locationid'          => $locationid,
                    'supplierid'          => $supplierid,
                    'brandid'             => $brandid,
                    'typeid'              => $typeid,
                    'serial'              => $serial,
                    'quantity'            => $quantity,
                    'purchasedate'        => $purchasedate,
                    'cost'                => $cost,
                    'warranty'            => $warranty,
                    'status'              => $status,
                    'description'         => $description,
                    'updated_at'          => $updated_at
                ]
            );
        }

            if ( $update ) {
                $res['message'] = 'success';
                
            } else{
                $res['message'] = 'failed';
            }
        
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
        $componentid    = $request->input( 'componentid' );
        $assetid        = $request->input( 'assetid' );
        $quantity       = $request->input( 'quantity' );
        $date           = $request->input( 'checkoutdate' );
        $status         = '1'; //checkout = 1
        $checkstatus    = '2'; 
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");
        
        $balance = DB::table('component')->select('quantity')->where('id', $componentid)->first();
        $checkquantity = $this->checkquantity($componentid, $balance->quantity, 1);
        $remain =  $checkquantity - $quantity;


        if($remain < 0){
            $res['success'] ='0';
        }
        else{
            $data               = array('componentid'=>$componentid, 'status'=>$status, 'quantity'=>$quantity, 'assetid'=>$assetid,'date'=>$date,'created_at'=>$created_at, 'updated_at'=>$updated_at);
            $insert         = DB::table( 'component_assets' )->insert( $data );

            if ( $insert ) {

                //set status in table asset
                $update = DB::table( 'component' )->where( 'id', $componentid )
                ->update(
                    [
                        'checkstatus'         => $checkstatus,
                        'updated_at'          => $updated_at
                    ]
                );

                $res['success'] = 'success';
            } else{
                $res['success'] = 'failed';
            }
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
        $componentid    = $request->input( 'componentid' );
        $assetid        = $request->input( 'assetid' );
        $historyid      = $request->input( 'historyid' );
        $quantity       = $request->input( 'quantity' );
        $date           = $request->input( 'checkindate' );
        $status         = '2'; //checkout = 1
        $checkstatus    = '0'; 
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");
        

        //check balance
        $balance = DB::table('component')->select('quantity')->where('id', $componentid)->first();
        $checkquantity = $this->checkquantity($componentid, $balance->quantity, 2);
        $remain =  $checkquantity - $quantity;

      
        //checkbalance current should not more then the input
        $balance = DB::table('component_assets')->select('quantity')->where('id', $historyid)->first();
        
        if($balance->quantity < $quantity || $quantity <=0){
            $res['success'] ='0';
        }

        else{

            //update current data base on quantity
            $updatequantity = $balance->quantity - $quantity;
            $updatehistory = DB::table( 'component_assets' )->where( 'id', $historyid )
                ->update(
                    [
                        'quantity'            => $updatequantity,
                        'updated_at'          => $updated_at
                    ]
                );

            $data           = array('assetid'=>$assetid, 'status'=>$status, 'quantity'=>$quantity, 'componentid'=>$componentid,'date'=>$date,'created_at'=>$created_at, 'updated_at'=>$updated_at);
            $insert         = DB::table( 'component_assets' )->insert( $data );

            if ( $insert ) {
                //set status in table asset
              /*  $update = DB::table( 'assets' )->where( 'id', $assetid )
                ->update(
                    [
                        'checkstatus'         => $checkstatus,
                        'updated_at'          => $updated_at
                    ]
                );*/
                $res['success'] = 'success';
            } else{
                $res['success'] = 'failed';
            }
        }

        return response( $res );
    }



    /**
     * get single data by assets id for history
     * @param integer $id
     * @return object
     */

    public function assetsbyid( Request $request ) {
        $id            = $request->input( 'assetid' );

      $data = DB::select("select component.*, supplier.name as supplier, brand.name as brand, asset_type.name as type 
        from component left join supplier  
        on component.supplierid = supplier.id
        left join brand 
        on component.brandid = brand.id
        left join component_assets 
        on component.id = component_assets.componentid
        left join asset_type
        on component.typeid = asset_type.id where component_assets.assetid ='$id'
        order by component.created_at desc"); 
        return Datatables::of($data)
        ->addColumn('avalaiblequantity',function($single){
            //count avalaible component
            $usedquantity = 0;
            $total = $single->quantity;
            $used =   DB::table('component_assets')
            ->select(array( DB::raw('SUM(component_assets.quantity) as components')))
            ->where('component_assets.componentid',$single->id)->first();
                $usedquantity = $used->components;
            if(!$used){
                $usedquantity = 0;
            }
            $remain =  $total - $usedquantity;
            return $remain;
        })
        ->addColumn('pictures',function($single){
            return '<img src="'.url('/').'/../upload/assets/'.$single->picture.'" style="width:90px"/>';
        })
       ->rawColumns(['avalaiblequantity','pictures'])
        ->make(true);
        
    }


    /**
     * get single data by component id for history
     * @param integer $id
     * @return object
     */

    public function historycomponentbyid( Request $request ) {
        $id            = $request->input( 'id' );

      $data = DB::select("select component_assets.*, assets.name as assetname 
        from component_assets left join assets  
        on component_assets.assetid = assets.id
        where component_assets.componentid = '$id' and component_assets.status = 1 and component_assets.quantity > 0
        order by component_assets.created_at desc"); 
        return Datatables::of($data)
        
        ->addColumn('action',function($single){

            return '<a class="btn btn-sm btn-primary" href="#" id="btncheckin" customdata='.$single->id.'  data-toggle="modal" data-target="#checkin"><i class="fa fa-check"></i> '. trans('lang.checkin').'</a>';
        })

         ->addColumn('date',function($single){

            $setting = DB::table('settings')->where('id', '1')->first();
            return date($setting->formatdate, strtotime($single->date));
        })
        ->rawColumns(['action','date'])
        ->make(true);
        
    }


    /**
	 * get all  from database
	 * @return object
	 */
    public function getrows(){
        $data = DB::table('component')->get();
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


        //check if used in assets/user
        $getcomponent = DB::table('component_assets')
        ->where('componentid', '=', $id)
        ->first();
        if($getcomponent){
            $res['message'] = 'exist';
        }
        else{
            $getfilename = DB::table('component')
            ->where('id', '=', $id)
            ->first();

            $delete          = DB::table( 'component' )->where( 'id', $id )->delete();
            $notdefaultimage = 'pic.png';
            $filename        = $getfilename->picture;

            if($filename != $notdefaultimage){
                $deleteimage = File::delete('upload/assets/'.$getfilename->picture);
            }
                    if ( $delete ) {
                        $res['message'] = 'success';
                    } else{
                        $res['message'] = 'failed';
                    }
            }
        return response( $res );
        
    }
    

    /**
	 * Generate Product Code
	 *
	 * @return object
	 */

	public function generateproductcode() {
        $lastid = DB::table('component')->orderBy('id', 'desc')->first();
    
        if ( $lastid ) {
			$res['success'] = 'success';
			$res['message']=  'COM'.date('ymd').$lastid->id;
        } else{
            $res['message']=  'COM'.date('ymd').'1';
        }
        return response( $res );
    }
}
