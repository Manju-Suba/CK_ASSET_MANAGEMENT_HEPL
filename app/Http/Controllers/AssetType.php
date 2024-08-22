<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetTypeModel;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\TraitSettings;
use DB;
use App\User;
use App;
use Auth;
use Session;

class AssetType extends Controller
{
    use TraitSettings;

    public function __construct() {

		$data = $this->getapplications();
		// $lang = $data->language;
		// App::setLocale($lang);
        //$this->middleware('auth');
    }

    //return view
    public function index() {

        $a_c_data = DB::table('asset_category_models')->select(['asset_category_models.*'])->where('status','!=', "Deleted")->get();
		return view( 'assettype.index' )->with(['a_c_data'=>$a_c_data]);

    }

    /**
	 * get data from database
	 * @return object
	 */
    public function getdata(){
        $data = DB::table('asset_type')->where('status','!=', "Deleted")->select(['asset_type.*']);
		return Datatables::of($data)
        ->addColumn( 'action', function ( $accountsingle ) {
            $action= '<a href="#" id="btnedit" customdata='.$accountsingle->id.' class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit"><i class="fa fa-pencil"></i> '. trans('lang.edit').'</a>
                    <a href="#" id="btndelete" customdata='.$accountsingle->id.' class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete"><i class="fa fa-trash"></i> '. trans('lang.delete').'</a>';
        return $action;
        } )
        ->rawColumns(['action'])
        ->make( true );
    }

    /**
	 * get all  from database
	 * @return object
	 */
    public function getrows(){
        if(Auth::user()->user_id == "L1-L2-HD-001" || Auth::user()->user_id == "900300"){
            $data = DB::table('asset_type')->where('name','Laptop')->orwhere('name','Desktop')->where('status','!=','Deleted')->get();
        }else{
            $data = DB::table('asset_type')->where('status','!=','Deleted')->get();
        }

        $data2 =  DB::table('asset_category_models');
        $data2 = $data2->where('status','!=','Deleted');
        
        if(Auth::user()->role == "6"){
            $data2 = $data2->where('id','!=','1');
            $data2 = $data2->where('id','!=','5');
        }
        if(Auth::user()->user_id == "L1-L2-HD-001" || Auth::user()->user_id == "900300"){
            $data2 = $data2->where('id','=','1');
        }
        $data2 = $data2->get();

        if ( $data ) {
			$res['success'] = true;
			$res['message']= $data;
			$res['category']= $data2;
        }
        return response( $res );
    }

    public function listlocation_b_location(Request $request){

        $location  = $request->input( 'location' );


        $record = DB::table('assets');
        $record = $record->join('asset_type', 'assets.a_type_id','=','asset_type.id');
        $record = $record->where('assets.locationid','=',$location);
        $record = $record->select('asset_type.*');
        $record = $record->groupBy('a_type_id');
        $record = $record->get();


        $asset_type_div='<option value="">Choose Asset Type</option>';

        foreach ($record as $key => $role_data) {

                $asset_type_div.='<option value="'.$role_data->id.'">'.$role_data->name.'</option>';
        }

			$res['success'] = 'success';
			$res['message']= 'success';
			$res['asset_type_div']= $asset_type_div;

        return response( $res );



    }
    public function created(){
        // $record1 = DB::table('assets');

        $record = DB::table('users');
        $record = $record->join('assets','users.email','=','assets.created_by');
        $record = $record->where('users.role','=','1');
        $record = $record->where('users.user_id','!=','AD-001');
        // $record = $record->where('assets.created_by','=','users.email');
        $record = $record->groupby('users.email');
        $record = $record->get();


        $asset_type_div='<option value="">All</option>';

        foreach ($record as $key => $role_data) {

                $asset_type_div.='<option value="'.$role_data->email.'">'.$role_data->fullname.'</option>';
        }

			$res['success'] = 'success';
			$res['message']= 'success';
			$res['asset_type_div']= $asset_type_div;

        return response( $res );



    }

    /**
	 * get single data
	 * @param integer $id
	 * @return object
	 */

    public function byid( Request $request ) {
        $id            = $request->input( 'id' );

        $data = DB::table('asset_type')->where('id', $id)->where('status','!=', "Deleted")->first();

        $get_asset_category_details = DB::table('asset_category_models')->select(['asset_category_models.*'])->where('status','!=', "Deleted")->get();

        $category_div='<option value="">Choose Category</option>';

        foreach ($get_asset_category_details as $key => $role_data) {
            if ($role_data->id==$data->c_id) // i change
            {
                $category_div.='<option value="'.$role_data->id.'" selected>'.$role_data->name.'</option>';
            }
            else{
                $category_div.='<option value="'.$role_data->id.'">'.$role_data->name.'</option>';
            }
        }

        if ( $data ) {
			$res['success'] = 'success';
			$res['message']= $data;
			$res['category_div']= $category_div;
        } else{
            $res['success'] = 'failed';
        }
        return response( $res );

    }

    public function asset_type_based_category( Request $request ) {
        $id            = $request->input( 'id' );

        $get_asset_type_details = DB::table('asset_type')->select(['asset_type.*'])->where('status','!=', "Deleted")->where('c_id', $id)->get();

        $asset_type_div='<option value="">Choose Type</option>';

        foreach ($get_asset_type_details as $key => $role_data) {
                $asset_type_div.='<option value="'.$role_data->id.'">'.$role_data->name.'</option>';
        }

        if ( $get_asset_type_details ) {
			$res['success'] = 'success';
			$res['asset_type_div']= $asset_type_div;
        } else{
            $res['success'] = 'failed';
        }
        return response( $res );
    }
    public function category_info( Request $request ) {
        $get_asset_type_details = DB::table('asset_type')->where('status','!=', "Deleted")->select(['asset_type.*'])->get();

        $asset_type_div='<option value="">Choose Type</option>';

        foreach ($get_asset_type_details as $key => $role_data) {
                $asset_type_div.='<option value="'.$role_data->id.'">'.$role_data->name.'</option>';
        }

        if ( $get_asset_type_details ) {
			$res['success'] = 'success';
			$res['asset_type_div']= $asset_type_div;
        } else{
            $res['success'] = 'failed';
        }
        return response( $res );
    }
    public function asset_type_based_show_catagory( Request $request ) {
        $id= $request->input( 'id' );

        $get_asset_type_details = DB::table('asset_type')->select(['asset_type.field_id'])->where('status','!=', "Deleted")->where('id', $id)->first();
        if ( $get_asset_type_details ) {
			$res['success'] = 'success';
			$res['asset_type_div']= $get_asset_type_details;
        } else{
            $res['success'] = 'failed';
        }
        return response( $res );
    }
    public function asset_type_based_category_edit( Request $request ) {

        if(isset($request->id)){
            $id            = $request->input( 'id' );
            if(isset($request->assetid)){
                $assetid            = $request->input( 'assetid' );
                $data = DB::table('assets')->where('assetid', $assetid)->where('status',"Active")->first();
            }


            $get_asset_type_details = DB::table('asset_type')->select(['asset_type.*'])->where('status','!=', "Deleted")->where('c_id', $id)->get();

            $asset_type_div='<option value="">Choose Type</option>';
            foreach ($get_asset_type_details as $key => $role_data) {
                if(isset($request->assetid)){
                    if ($role_data->id==$data->a_type_id)
                    {
                        $asset_type_div.='<option value="'.$role_data->id.'" selected>'.$role_data->name.'</option>';
                    }
                    else{
                        $asset_type_div.='<option value="'.$role_data->id.'">'.$role_data->name.'</option>';
                    }
                } else{
                    $asset_type_div.='<option value="'.$role_data->id.'">'.$role_data->name.'</option>';
                }

            }

            if ( $get_asset_type_details ) {
                $res['success'] = 'success';
                $res['asset_type_div']= $asset_type_div;
            } else{
                $res['success'] = 'failed';
            }
            return response( $res );
        }
        if(isset($request->cat_id)){
            $id = $request->cat_id;
            // if(Auth::user()->user_id == "L1-L2-HD-001"){
            //     $get_asset_type_details = DB::table('asset_type')
            //     ->whereIn('name',['Laptop','Desktop'])
            //     ->where('status','!=','Deleted')
            //     ->where('c_id', $id)
            //     ->get();
            // }else{
                $get_asset_type_details = DB::table('asset_type')->where('status','!=', "Deleted")->where('c_id', $id)->get();
            // }
            $asset_type_div='<option value="">Choose Type</option>';
            foreach ($get_asset_type_details as $key => $role_data) {
                $asset_type_div.='<option value="'.$role_data->id.'">'.$role_data->name.'</option>';
            }
            if ( $get_asset_type_details ) {
                $res['success'] = 'success';
                $res['asset_type_div']= $asset_type_div;
            } else{
                $res['success'] = 'failed';
            }
            return response( $res );

        }


    }

    /**
	 * insert data  to database
	 *
	 * @param string  $name
     * @param string  $description
	 * @return object
	 */
    public function save(Request $request){
        $field_id           = "Common Field";
        $c_id           = $request->input( 'asset_category' );
        $name           = $request->input( 'name' );
        $description    = $request->input( 'description' );
        $created_by     = Auth::user()->email;
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");
        $data           = array('field_id'=>$field_id,'c_id'=>$c_id, 'name'=>$name, 'description'=>$description,'created_at'=>$created_at,'status'=>'Active', 'updated_at'=>$updated_at,'created_by'=>$created_by);

        $check = DB::table('asset_type')->where('c_id', $c_id)->where('name', $name)->where('status', "Active")->get();

        if(isset($check[0])){
            $resp="Data Already Exist";
            return response()->json(['response'=>$resp]);
        }
        else{

        $insert         = DB::table( 'asset_type' )->insert( $data );

		if ( $insert ) {
            $res['response'] = 'success';
			$res['success'] = 'success';

        } else{
            $res['response'] = 'failed';
            $res['success'] = 'failed';
        }

        return response( $res );
        }
    }

    /**
	 * update data  to database
	 *
	 * @param string  $name
     * @param string  $description
	 * @return object
	 */
    public function update(Request $request){
        $id             = $request->input( 'id' );
        $c_id           = $request->input( 'edit_asset_category' );
        $name           = $request->input( 'name' );
        $description    = $request->input( 'description' );
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");

        $check = DB::table('asset_type')->where('c_id', $c_id)->where('name', $name)->where('status', "Active")->where('id','!=', $id)->get();

        if(isset($check[0])){
            $resp="Data Already Exist";
            return response()->json(['response'=>$resp]);
        }
        else{

		$update = DB::table( 'asset_type' )->where( 'id', $id )
		->update(
			[
			'c_id'      => $c_id,
			'name'          => $name,
            'description'   => $description,
            'updated_at'    => $updated_at
			]
		);

        if ( $update ) {
            $res['response'] = 'success';
			$res['success'] = 'success';

        } else{
            $res['response'] = 'failed';
            $res['success'] = 'failed';
        }

        return response( $res );
        }
    }

     /**
	 * delete to database
	 *
	 * @param integer $id
	 * @return object
	 */

	public function delete( Request $request ) {
		$id = $request->input( 'id' );

        $delete = DB::table( 'asset_type' )->where( 'id', $id )
		->update(
			[
			'status'          => 'Deleted',
			]
		);

		// $delete = DB::table( 'asset_type' )->where( 'id', $id )->delete();
            if ( $delete ) {
                $res['success'] = 'success';
            } else{
                $res['success'] = 'failed';
            }
		return response( $res );
	}
}
