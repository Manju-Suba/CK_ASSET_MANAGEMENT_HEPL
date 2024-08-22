<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserModel;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\TraitSettings;
use DB;
use App;
use Auth;
use Session;

class User extends Controller
{
    use TraitSettings;

    public function __construct() {

		$data = $this->getapplications();
		// $lang = $data->language;
		// App::setLocale($lang);
        $this->middleware('auth');
    }

    //return Branch
    public function index() {
        $business = DB::table('business_models')->select('*')->where('status','Active')->get();
		return view( 'user.index' )->with(['business'=>$business]);
		// return view( 'user.index' );
    }


    /**
	 * get data from database
	 * @return object
	 */
    public function getdata(){
        $data = DB::table('users')->where('status','!=', 0)->select(['users.*']);
        return Datatables::of($data)
        ->addColumn('status',function($single){
            $status = '';
            if($single->status=='1'){
                $status = '<label class="badge badge-success">'.trans('lang.active').'</label>';
            }
            if($single->status=='2'){
                $status = '<label class="badge badge-warning">'.trans('lang.inactive').'</label>';
            }
			return $status;
        })
        ->addColumn('role',function($single){
            $status = '';
            if($single->role=='1'){
                $status = trans('lang.admin');
            }
            if($single->role=='2'){
                $status = trans('lang.user');
            }
            if($single->role=='3'){
                $status = 'IT infra Testing(type 1)';
            }
            if($single->role=='4'){
                $status = 'IT infra Testing(type 2)';
            }

            if($single->role=='5'){
                $status = 'IT Infra';
            }

            if($single->role=='6'){
                $status = 'Asset Management';
            }
            if($single->role =='7'){
                $status = 'IT Infra @CITPL';
            }

            if($single->role !=='1' && $single->role !=='2' && $single->role !=='3'&& $single->role !=='4' && $single->role !=='5' && $single->role !=='6' && $single->role !=='7'){
                $status = $single->role;
            }
			return $status;
        })
		->addColumn( 'action', function ( $accountsingle ) {
            return '<a href="#" id="btnedit" customdata='.$accountsingle->id.' class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit"><i class="ti-pencil"></i> '. trans('lang.edit').'</a>
                    <a href="#" id="btndelete" customdata='.$accountsingle->id.' class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete"><i class="ti-trash"></i> '. trans('lang.delete').'</a>';
        } )->rawColumns(['status','role', 'action'])
        ->make( true );
    }


    /**
	 * get all from database
	 * @return object
	 */
    public function getrows(){
        $data = DB::table('users')->where('status',1)->get();
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

        $data = DB::table('users')->where('id', $id)->first();

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
	 * @param string  $fullname
	 * @param string  $email
     * @param string  $password
     * @param string  $status
     * @param string  $city
     * @param string  $phone
     * @param string  $role
     * @return object
	 */
    public function save(Request $request){
        $fullname       = $request->input( 'fullname' );
        $email          = $request->input( 'email' );
        $password       = $request->input( 'password' );
        $status         = $request->input( 'status' );
        $city           = $request->input( 'city' );
        $phone          = $request->input( 'phone' );
        $role           = $request->input( 'role' );
        // $domain         = $request->input( 'domain' );
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");
        $created_by     = Auth::user()->email;

        $domain= ( implode(",",$request->input('domain')) );

        $emailcheck = DB::table('users')
		    ->where('email', '=', $email)
            ->first();

        if($emailcheck){
                $res['message'] = 'exist';
        }
        else{

            $data       = array('fullname'=>$fullname,
                        'email'=>$email,
                        'password'=>bcrypt($password),
                        'status'=>$status,
                        'role'=>$role,
                        'domain'=>$domain,
                        'city'=>$city,
                        'phone'=>$phone,
                        'created_at'=>$created_at,
                        'created_by'=>$created_by,
                        'updated_at'=>$updated_at);
            $insert     = DB::table( 'users' )->insert( $data );

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
     * @param string  $password
     * @param string  $status
     * @param string  $city
     * @param string  $phone
     * @param string  $role
	 * @return object
	 */
    public function update(Request $request){
        $id             = $request->input( 'id' );
        $fullname       = $request->input( 'fullname' );
        $email          = $request->input( 'email' );
        $password       = $request->input( 'password' );
        $status         = $request->input( 'status' );
        $city           = $request->input( 'city' );
        $phone          = $request->input( 'phone' );
        $role           = $request->input( 'role' );
        // $domain           = $request->input( 'domain' );
        $created_at     = date("Y-m-d H:i:s");
        $updated_at     = date("Y-m-d H:i:s");

        if($request->input('domain') !=""){
            $domain = ( implode(",",$request->input('domain')) );
        }else{
            $domain = $request->input('domain');
        }

        $emailcheck = DB::table('users')
        ->where('email', '=', $email)
        ->where('id', '!=', $id)
        ->first();

        if($emailcheck){
                $res['message'] = 'exist';
        }
        else{

            if ($password !='') {
                $update = DB::table( 'users' )->where( 'id', $id )
                ->update(
                    [
                    'fullname'          => $fullname,
                    'email'             => $email,
                    'password'          =>bcrypt($password),
                    'status'            => $status,
                    'city'              => $city,
                    'phone'             => $phone,
                    'role'              => $role,
                    'domain'            => $domain,
                    'updated_at'        => $updated_at
                    ]
                );

                if ( $update ) {
                    $res['message'] = 'success';

                } else{
                    $res['message'] = 'failed';
                }
            }else{
                $update = DB::table( 'users' )->where( 'id', $id )
                ->update(
                    [
                    'fullname'          => $fullname,
                    'email'             => $email,
                    'status'            => $status,
                    'city'              => $city,
                    'phone'             => $phone,
                    'role'              => $role,
                    'domain'            => $domain,
                    'updated_at'        => $updated_at
                    ]
                );

                if ( $update ) {
                    $res['message'] = 'success';

                } else{
                    $res['message'] = 'failed';
                }

            }
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
		$delete = DB::table( 'users' )->where( 'id', $id )->update(['status' => 0]);
            if ( $delete ) {
                $res['success'] = 'success';
            } else{
                $res['success'] = 'failed';
            }
		return response( $res );
	}
}
