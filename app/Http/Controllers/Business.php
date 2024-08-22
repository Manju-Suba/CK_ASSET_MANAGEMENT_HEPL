<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessModel;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\TraitSettings;
use DB;
use App\User;
use App;
use Auth;
use Session;



class Business extends Controller
{
    use TraitSettings;

    public function __construct() {
		$data = $this->getapplications();
    }

    //return view
    public function index() {
		return view( 'business.index' );
    }

    /**
	 * get data from database
	 * @return object
	 */
    public function getdata(){
        $data = DB::table('business_models')->where('status','!=', "Deleted")->select(['business_models.*']);
		return Datatables::of($data)
		->addColumn( 'action', function ( $accountsingle ) {
            return '<a href="#" id="btnedit" customdata='.$accountsingle->id.' class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit"><i class="fa fa-pencil"></i> '. trans('lang.edit').'</a>
                    <a href="#" id="btndelete" customdata='.$accountsingle->id.' class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete"><i class="fa fa-trash"></i> '. trans('lang.delete').'</a>';
        } )->make( true );		
    }

    /**
	 * get all  from database
	 * @return object
	 */
    public function getrows(){
        $data = DB::table('business_models')->where('status','Active')->get();
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

        $data = DB::table('business_models')->where('status','Active')->where('id', $id)->first();
        
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
	 * @param string  $name
     * @param string  $description
	 * @return object
	 */
    public function save(Request $request){
        $name           = $request->input( 'name' );
        $description    = $request->input( 'description' );
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");
        $created_by     = Auth::user()->email;
        $data           = array('name'=>$name,'created_by'=>$created_by, 'description'=>$description,'status'=>'Active','created_at'=>$created_at, 'updated_at'=>$updated_at);

        $check = DB::table('business_models')->where('name', $name)->where('status', "Active")->get();
        
        if(isset($check[0])){
            $resp="Data Already Exist";
            return response()->json(['response'=>$resp]);
        }else{
		    
            $insert         = DB::table( 'business_models' )->insert( $data );

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
        $name           = $request->input( 'name' );
        $description    = $request->input( 'description' );
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");


        $check = DB::table('business_models')->where('name', $name)->where('status', "Active")->where('id','!=', $id)->get();
        
        if(isset($check[0])){
            $resp="Data Already Exist";
            return response()->json(['response'=>$resp]);
        }else{
            $update = DB::table( 'business_models' )->where( 'id', $id )
            ->update(
                [
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
        $delete = DB::table( 'business_models' )->where( 'id', $id )
		->update(
			[
			'status'          => 'Deleted',
			]
		);

		// $delete = DB::table( 'business_models' )->where( 'id', $id )->delete();

            if ( $delete ) {
                $res['success'] = 'success';
            } else{
                $res['success'] = 'failed';
            }
		return response( $res );
	}
}
