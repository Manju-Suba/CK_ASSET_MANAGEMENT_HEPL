<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DepartmentModel;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\TraitSettings;
use DB;
use App\User;
use App;
use Auth;
use Milon\Barcode\DNS2D;


class Software extends Controller
{
    //
    use TraitSettings;

    public function __construct() {

		$data = $this->getapplications();
		// $lang = $data->language;
		// App::setLocale($lang);
        //$this->middleware('auth');
    }

    //return view
    public function index() {
		return view( 'software.index' );
    }

    public function get_software_data_exp(Request $request){

            $today=date('Y-m-d');
            $effectiveDate = date('Y-m-d', strtotime("+3 months", strtotime($today)));

            $data = DB::table('assets');
            $data =$data->leftJoin('brand', 'assets.brandid', '=', 'brand.id');
            $data =$data->leftjoin('asset_type', 'assets.a_type_id', '=', 'asset_type.id');
            $data =$data->leftJoin('location', 'assets.locationid', '=', 'location.id');
            $data =$data->where('assets.sof_expiry_date', '<=', $effectiveDate);
            $data =$data->where('assets.a_type_id', '=', '34');
            $data =$data->where('assets.available_status', '=', 'Stock');
            $data =$data->where('assets.status', '!=', 'Deleted');


            $data =$data->select(['assets.*','brand.name as brand','brand.id as brandid', 'asset_type.name as type' , 'location.name as location']);

            return Datatables::of($data)
            ->addColumn('pictures',function($single){
                return '<img class="yoyo" src="'.url('/').'/../upload/assets/'.$single->picture.'" style="width:50px"/>';
            })
            ->addColumn('asset_detail',function($single){

                $asset_detail='Name: <h6>'.$single->name.'</h6>';
                $asset_detail.='AID: <h6>'.$single->assetid.'</h6>';

                return $asset_detail;
            })
            ->addColumn('expiry_date',function($single){

                $expiry_date=date("d-m-Y", strtotime($single->sof_expiry_date));

                return $expiry_date;
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
                                    <div class="assetbarcode" id="qr_div_img'.$single->barcode.'"><img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="width:100%;"  /></div>
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

                $checkout = '<a class="dropdown-item" href="#" id="btncheckin" customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal" data-target="#checkin"><i class="fa fa-check"></i> Renewal</a>';

                $action ='';
                // $action.= '<a class="btn btn-sm btn-fill btn-primary" href="#" id="btncheckin" onclick=download_row_qr('."'".$accountsingle->barcode."'".')  style="margin-left: 10px;"><i class="fa fa-print"></i></a>';

                return '
                    <div class="btn-group">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu actionmenu">
                    '.$checkout.'
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>

                    </div>
                </div>'.$action.'';

            } )
            ->rawColumns(['expiry_date','asset_detail','qr','pictures','emp_detail', 'action'])
            ->make(true);
        }


        public function get_software_data_all(Request $request){

            $data = DB::table('assets');
            $data =$data->leftJoin('brand', 'assets.brandid', '=', 'brand.id');
            $data =$data->leftjoin('asset_type', 'assets.a_type_id', '=', 'asset_type.id');
            $data =$data->leftJoin('location', 'assets.locationid', '=', 'location.id');
            $data =$data->where('assets.a_type_id', '=', '34');
            $data =$data->where('assets.available_status', '=', 'Stock');
            $data =$data->where('assets.status', '!=', 'Deleted');


            $data =$data->select(['assets.*','brand.name as brand','brand.id as brandid', 'asset_type.name as type' , 'location.name as location']);

            return Datatables::of($data)
            ->addColumn('pictures',function($single){
                return '<img class="yoyo" src="'.url('/').'/../upload/assets/'.$single->picture.'" style="width:50px"/>';
            })
            ->addColumn('asset_detail',function($single){

                $asset_detail='Name: <h6>'.$single->name.'</h6>';
                $asset_detail.='AID: <h6>'.$single->assetid.'</h6>';

                return $asset_detail;
            })
            ->addColumn('expiry_date',function($single){

                $expiry_date=date("d-m-Y", strtotime($single->sof_expiry_date));

                return $expiry_date;
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
                                    <div class="assetbarcode" id="qr_div_img'.$single->barcode.'"><img src="data:image/png;base64,' . (new DNS2D)->getBarcodePNG($single->barcode, 'QRCODE') . '" alt="barcode" style="width:100%;"  /></div>
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

                $checkout = '<a class="dropdown-item" href="#" id="btncheckin" customdata='."'".$accountsingle->assetid."'".'  data-toggle="modal" data-target="#checkin"><i class="fa fa-check"></i> Renewal</a>';

                $action ='';
                // $action.= '<a class="btn btn-sm btn-fill btn-primary" href="#" id="btncheckin" onclick=download_row_qr('."'".$accountsingle->barcode."'".')  style="margin-left: 10px;"><i class="fa fa-print"></i></a>';

                return '
                    <div class="btn-group">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu actionmenu">
                    '.$checkout.'
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="'.url('/').'/assetlist/detail/'.$accountsingle->assetid.'"id="btndetail" customdata='.$accountsingle->assetid.'  ><i class="fa fa-file-text"></i> '. trans('lang.detail').'</a>

                    </div>
                </div>'.$action.'';

            } )
            ->rawColumns(['expiry_date','asset_detail','qr','pictures','emp_detail', 'action'])
            ->make(true);
        }

        public function sof_id(Request $request){
            $id   = $request->input( 'id' );
            $result = DB::table('sof_history')->where('assetid',$id)->get();
            // dd($result);
            // exit();
            $html="";
                foreach ($result as $result){
                    // $picture = $result->picture;
                    $images =explode(",",$result->picture);
                    foreach ($images as $image){
                        $html.='<div class="col-md-3">';
                            $html.='<figure class="effect-text-in img-ms-form" style="max-height:75% !important;">';
                                $html.='<a href="'.url('/').'/../upload/assets/img_upload/'.$image.'" target="_blank"><img src="'.url('/').'/../upload/assets/img_upload/'.$image.'" width="110px"height="100px" style="padding-right:4px;padding-top:3px;padding-bottom:3px;"/></a>';
                            $html.='</figure>';
                        $html.='</div>';
                        // $html.='<td><img src="'.url('/').'/../upload/assets/img_upload/'.$image.'" width="110px"height="100px" style="padding-right:4px;padding-top:3px;padding-bottom:3px;"/></td>';
                    }
                }

            // echo $html;
            // exit();

            $data = array('res' => 'success', 'result' => $html);
            echo json_encode($data);

        }

        public function sof_expiry(Request $request){

            // $sof_cost    = $request->input( 'sof_cost' );
            // print_r($sof_cost);
            // exit();

            $assetid        = $request->input( 'assetid' );
            $expired_date    = $request->input( 'expired_date' );
            $allocated_date    = $request->input( 'allocated_date' );
            $sof_cost    = $request->input( 'sof_cost' );
            $created_at     = date("Y-m-d H:i:s");
            $updated_at     = date("Y-m-d H:i:s");
            $message = ['picture.mimes'=>trans('lang.upload_error')];
            $defaultimage       = 'pic.png';
            // $picture    = $request->file('picture');

            if($request->image_upload !=""){

                if ($request->image_upload) {
                    $images = $request->image_upload;
                    foreach ($images as $image) {
                        $imagesName =time() . '.' . $image->getClientOriginalName();
                        // $picturename  = date('mdYHis').uniqid().$request->file('picture')->getClientOriginalName();
                        // print_r($imagesName);
                        // exit();
                        $randonName = rand(1, 200);
                        $image->move(public_path('/upload/assets/img_upload'), $imagesName);
                        $pic[] = $imagesName;
                    }
                }

                $pic = str_replace(array('[', ']'), "", htmlspecialchars(json_encode($pic), ENT_NOQUOTES));
                $pic = str_replace('"', '', $pic);
            }else{
                $pic = $defaultimage;
            }

            if($sof_cost!=""){
                $data     = array('assetid'=>$assetid,
                'expirydate'=>$expired_date,
                'extenddate'=>$allocated_date,
                'sof_cost'=>$sof_cost,
                'picture'=>$pic,
                'created_at'=>$created_at,
                'updated_at'=>$updated_at);

            }else{
                $data    = array('assetid'=>$assetid,
                'expirydate'=>$expired_date,
                'extenddate'=>$allocated_date,
                'picture'=>$pic,
                'created_at'=>$created_at,
                'updated_at'=>$updated_at);
            }

            $insert  = DB::table( 'sof_history' )->insert( $data );

            // exit();

            if ( $insert ) {
                //set status in table asset

                $update = DB::table( 'assets' )->where( 'assetid', $assetid )

                    ->update(
                        [
                            'sof_expiry_date'   => $allocated_date,
                        ]
                    );
                $res['success'] = 'success';
            } else{
                $res['success'] = 'failed';
            }

            return response( $res );
        }

}
