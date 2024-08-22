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
use Session;


class Department extends Controller
{
    use TraitSettings;

    public function __construct() {

		$data = $this->getapplications();
		// $lang = $data->language;
		// App::setLocale($lang);
        $this->middleware('auth');
    }

    //return view
    public function index() {
        $business_data = DB::table('business_models')->select(['business_models.*'])->where('status','!=', "Deleted")->get();
		return view( 'department.index' )->with(['business_data'=>$business_data]);
    }

    /**
	 * get data from database
	 * @return object
	 */
    public function getdata(){
        $data = DB::table('department')->select(['department.*'])->where('status', "Active");
		return Datatables::of($data)
        ->addColumn('business_div', function($data) {
            $get_business_details = DB::table('business_models')
            ->select(['business_models.*'])
            ->where('status', "Active")
            ->where('id', $data->b_id)
            ->get();
            if(isset($get_business_details[0])){
                $business_div = $get_business_details[0]->name;
                return $business_div;
            }else{
                return '';
            }
            // $business_div = $get_business_details[0]->name;
            // return $business_div;
        })
		->addColumn( 'action', function ( $accountsingle ) {
            $action= '<a href="#" id="btnedit" customdata='.$accountsingle->id.' class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit"><i class="fa fa-pencil"></i> '. trans('lang.edit').'</a>
                    <a href="#" id="btndelete" customdata='.$accountsingle->id.' class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete"><i class="fa fa-trash"></i> '. trans('lang.delete').'</a>';
            return $action;
        } )
        ->rawColumns(['business_div','action'])
        ->make( true );
    }



    public function get_depat_b_bus(Request $request ){
        $business         = $request->input( 'business' );

        $dept_data = DB::table('department')->where("b_id",$business)->where('status','Active')->get();


        $sup_div='<option value="">Choose Department</option>';
        foreach ($dept_data as $key => $dept_data) {
                $sup_div.='<option value="'.$dept_data->id.'">'.$dept_data->name.' </option>';
        }

        if ( $dept_data ) {
			$res['success'] = true;
			$res['sup_div']= $sup_div;
        }

        return response( $res );
    }

    /**
	 * get all  from database
	 * @return object
	 */
    public function getrows(){
        $data = DB::table('department')->where('status','Active')->get();
        if ( $data ) {
			$res['success'] = true;
			$res['message']= $data;
        }
        return response( $res );
    }

    /**
	 * get single data
	 * @param integer $id
	 * @return object
	 */

    public function byid( Request $request ) {
        $id            = $request->input( 'id' );

        $data = DB::table('department')->where('id', $id)->where('status','Active')->first();

        $get_business_details = DB::table('business_models')->select(['business_models.*'])->where('status','!=', "Deleted")->get();

        $business_div='<option value="">Choose Business</option>';

        foreach ($get_business_details as $key => $row_data) {
            if ($row_data->id==$data->b_id)
            {
                $business_div.='<option value="'.$row_data->id.'" selected>'.$row_data->name.'</option>';
            }
            else{
                $business_div.='<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
            }
        }

        if ( $data ) {
			$res['success'] = 'success';
			$res['message']= $data;
			$res['business_div']= $business_div;

        } else{
            $res['success'] = 'failed';
        }
        return response( $res );

    }

    /**
	 * insert data  to database
	 *
	 * @param string  $name
     * @param string  $description
	 * @return object
	 */
    public function save(Request $request){

        $b_id           = $request->input( 'business' );
        $name           = $request->input( 'name' );
        $description    = $request->input( 'description' );
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");
        $created_by     = Auth::user()->email;
        $data           = array('b_id'=>$b_id, 'name'=>$name,'created_by'=>$created_by, 'description'=>$description,'created_at'=>$created_at, 'updated_at'=>$updated_at);


        $check = DB::table('department')->where('name', $name)->where('b_id',$b_id)->where('status', "Active")->get();

        if(isset($check[0])){
            $resp="Data Already Exist";
            return response()->json(['response'=>$resp]);
        }else{
            $insert         = DB::table( 'department' )->insert( $data );

            if ( $insert ) {
                $res['success'] = 'success';

            } else{
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
        $b_id           = $request->input( 'edit_business' );
        $name           = $request->input( 'name' );
        $description    = $request->input( 'description' );
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");

        $check = DB::table('department')->where('name', $name)->where('b_id',$b_id)->where('id','!=', $id)->where('status', "Active")->get();
        if(isset($check[0])){
            $resp="Data Already Exist";
            return response()->json(['response'=>$resp]);
        }else{
            $update = DB::table( 'department' )->where( 'id', $id )
            ->update(
                [
                'b_id'          => $b_id,
                'name'          => $name,
                'description'   => $description,
                'updated_at'    => $updated_at
                ]
            );

            if ( $update ) {
                $res['success'] = 'success';

            } else{
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
        $delete = DB::table( 'department' )->where( 'id', $id )
		->update(
			[
			'status'          => 'Deleted',
			]
		);
		// $delete = DB::table( 'department' )->where( 'id', $id )->delete();
            if ( $delete ) {
                $res['success'] = 'success';
            } else{
                $res['success'] = 'failed';
            }
		return response( $res );
	}
}
