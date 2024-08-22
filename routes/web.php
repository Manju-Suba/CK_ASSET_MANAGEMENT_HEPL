<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/master','Home@index');

Route::get('/','Home@index');
Route::get('/home','Home@index');
Route::get('/brandlist','Brand@index');
Route::get('/businesslist','Business@index');
Route::get('/departmentlist','Department@index');
Route::get('/internalauditlist','Internalaudit@index');
Route::get('/assettypelist','AssetType@index');
Route::get('/assetcategorylist','AssetCategory@index');

Route::get('/locationlist','Location@index');
Route::get('/employeeslist','Employees@index');
Route::get('/emp_verification','Employees@emp_verify'); //i put
Route::get('/hepl_verification','Employees@verified_employee'); //i put
Route::get('/returned_asset','Employees@returned_asset'); //i put
//i put
Route::get('/supplierlist','Supplier@index');
Route::get('/userlist','User@index');
Route::get('/settinglist','Settings@index');
Route::get('/assetlist','Asset@index');
Route::get('/assetlist/detail/{id}','Asset@detail');
Route::get('/assetlist/generatelabel/{id}', 'Asset@generatelabel');
Route::post('asset_bulk_upload', 'Asset@asset_bulk_upload'); // i put


Route::get('/componentlist','Component@index');
Route::get('/componentlist/detail/{componentid}','Component@detail');
Route::get('/maintenancelist','Maintenance@index');

Route::get('/hold_employee','Employees@holdemployee');
Route::get('/fetch_holdEmployee','Employees@fetchHoldEmployee');
Route::get('/get_v_edit','Employees@Get_verify_Edit');
Route::get('/update_verify_asset','Employees@Update_Verify_Asset');
Route::post('/returned_confirm','Employees@returned_confirm');
Route::post('/update_asset','Employees@update_asset');


Route::get('/softwares_report','Software@index');
Route::get('software_data_exp', 'Software@get_software_data_exp');
Route::get('software_data_all', 'Software@get_software_data_all');
Route::post('sof_expiry', 'Software@sof_expiry'); // i put
Route::post('sof_id', 'Software@sof_id'); // i put





//report
Route::get('/reports/assetactivity','Reports@assetactivity');
Route::get('/reports/componentactivity','Reports@componentactivity');
Route::get('/reports/maintenance','Reports@maintenance');
Route::get('/reports/bytype','Reports@bytype');
Route::get('/reports/bystatus','Reports@bystatus');
Route::get('/reports/bylocation','Reports@bylocation');
Route::get('/reports/bysupplier','Reports@bysupplier');
Route::get('/reports/allreports','Reports@allreports');

Route::get('logout', 'Auth\LoginController@logout');

//login
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::get('login/getapplication','Auth\LoginController@getapplication');
Route::post('login', 'Auth\LoginController@authenticate');
Route::post('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@authenticate']);


//Home API
Route::get('home/totalbalance', 'Home@totalbalance');
Route::get('home/assetbytype', 'Home@assetbytype');
Route::get('home/assetbystatus', 'Home@assetbystatus');
Route::get('home/recentassetactivity', 'Home@recentassetactivity');
Route::get('home/recentcomponentactivity', 'Home@recentcomponentactivity');



//Brand API
Route::get('brand', 'Brand@getdata');
Route::get('listbrand', 'Brand@getrows');
Route::post('savebrand', 'Brand@save');
Route::post('updatebrand', 'Brand@update');
Route::post('deletebrand', 'Brand@delete');
Route::post('brandbyid', 'Brand@byid');

//Business API
Route::get('business', 'Business@getdata');
Route::get('listbusiness', 'Business@getrows');
Route::post('savebusiness', 'Business@save');
Route::post('updatebusiness', 'Business@update');
Route::post('deletebusiness', 'Business@delete');
Route::post('businessbyid', 'Business@byid');

//Department API
Route::get('department', 'Department@getdata');
Route::get('listdepartment', 'Department@getrows');
Route::post('savedepartment', 'Department@save');
Route::post('updatedepartment', 'Department@update');
Route::post('deletedepartment', 'Department@delete');
Route::post('departmentbyid', 'Department@byid');
Route::get('get_department', 'Department@get_depat_b_bus');


//Asset category Type API
Route::get('assetcategory', 'AssetCategory@getdata');
Route::get('listassetcategory', 'AssetCategory@getrows');
Route::post('saveassetcategory', 'AssetCategory@save');
Route::post('updateassetcategory', 'AssetCategory@update');
Route::post('deleteassetcategory', 'AssetCategory@delete');
Route::post('assetcategorybyid', 'AssetCategory@byid');

//Asset Type API
Route::get('assettype', 'AssetType@getdata');
Route::get('listassettype', 'AssetType@getrows');
Route::post('listlocation_b_location', 'AssetType@listlocation_b_location');

Route::post('saveassettype', 'AssetType@save');
Route::post('updateassettype', 'AssetType@update');
Route::post('deleteassettype', 'AssetType@delete');
Route::post('assettypebyid', 'AssetType@byid');
Route::get('asset_type_based_category', 'AssetType@asset_type_based_category');
Route::get('category_info','AssetType@category_info');
Route::post('asset_type_based_show_catagory','AssetType@asset_type_based_show_catagory');
Route::get('asset_type_based_category_edit', 'AssetType@asset_type_based_category_edit');
Route::get('created', 'AssetType@created');



//Location API
Route::post('listlocation_select_b', 'Location@getrows_select_b');


Route::get('location', 'Location@getdata');
Route::get('listlocation', 'Location@getrows');
Route::post('savelocation', 'Location@save');
Route::post('updatelocation', 'Location@update');
Route::post('deletelocation', 'Location@delete');
Route::post('locationbyid', 'Location@byid');

//Employees API
Route::get('employees', 'Employees@getdata');
Route::get('employeess', 'Employees@get_emp_data');//i put
Route::get('verified_employees', 'Employees@get_verified_data');//i put
Route::get('get_returned_asset', 'Employees@get_returned_assets');//i put
Route::get('listemployees', 'Employees@getrows');
Route::post('saveemployees', 'Employees@save');
Route::post('updateemployees', 'Employees@update');
Route::post('verifyemployees', 'Employees@emp_update');//i put
Route::post('verified_emp_upd', 'Employees@verified_emp_update');//i put
Route::post('deleteemployees', 'Employees@delete');
Route::post('employeesbyid', 'Employees@byid');
Route::get('fetch', 'Employees@Fetch');
Route::post('saveaddmore', 'Employees@save_and_addmore');
Route::get('employees_byid', 'Employees@employees_byid');//i put
Route::post('employee_bulk_upload', 'Employees@employee_bulk_upload'); // i put
Route::post('anyway_upload', 'Employees@anyway_upload'); // i put

Route::get('get_supervisor', 'Employees@get_sup_rows_d_dept');


//Supplier API
Route::get('supplier', 'Supplier@getdata');
Route::get('listsupplier', 'Supplier@getrows');
Route::post('savesupplier', 'Supplier@save');
Route::post('updatesupplier', 'Supplier@update');
Route::post('deletesupplier', 'Supplier@delete');
Route::post('supplierbyid', 'Supplier@byid');

//User API
Route::get('user', 'User@getdata');
Route::get('listuser', 'User@getrows');
Route::post('saveuser', 'User@save');
Route::post('updateuser', 'User@update');
Route::post('deleteuser', 'User@delete');
Route::post('userbyid', 'User@byid');

//Settings API
Route::get('settings', 'Settings@getdata');
Route::post('updatesettings', 'Settings@update');

// internalaudit
Route::post('internal_audit_report_list', 'Internalaudit@getdata');
Route::post('internal_audit_scan_save', 'Internalaudit@save_data');

//Asset API
Route::POST('asset', 'Asset@getdata');
Route::post('allocated_asset', 'Asset@get_allocated_asset_data');
Route::post('temp_allocated_asset', 'Asset@get_temp_allocated_asset_data'); // i put
Route::get('retiral_asset', 'Asset@get_retiral_asset_data');
Route::get('listasset', 'Asset@getrows');
Route::post('saveasset', 'Asset@save');
Route::post('updateasset', 'Asset@update');
Route::post('deleteasset', 'Asset@delete');
Route::post('retiralasset', 'Asset@retiral');
Route::post('listasset_active', 'Asset@listasset_active');
Route::post('assetbyid', 'Asset@byid');
Route::post('assetby_id', 'Asset@by_id'); // i put
Route::post('savecheckout', 'Asset@savecheckout');
Route::post('savecheckin', 'Asset@savecheckin');
Route::post('historyassetbyid', 'Asset@historyassetbyid');
Route::post('sofhistoryassetbyid', 'Asset@sofhistoryassetbyid');// i put
Route::get('asset/generateproductcode', 'Asset@generateproductcode');
Route::post('get_asset_info','Asset@get_asset_info');


Route::get('asset_qr_generate', 'Asset@asset_qr_generate_land');
Route::post('qr_bulk_generate', 'Asset@qr_bulk_generate');
Route::post('bulk_qr_generate', 'Asset@bulk_qr_generate');
Route::post('selected_row_qr_generate', 'Asset@selected_row_qr_generate');


Route::get('get_temp_qr', 'Asset@get_temp_asset_qr_data');
Route::get('get_allocated_qr_generate', 'Asset@get_allocated_qr_generate');

Route::post('qr_upload', 'Asset@qr_upload');
Route::post('download_all_qr_get', 'Asset@download_all_qr_get');
Route::post('asset_history', 'Asset@asset_history');


Route::get('bulk_qrcode_generate', 'Asset@bulk_qrcode_generate');




//Component API
Route::get('component', 'Component@getdata');
Route::get('listcomponent', 'Component@getrows');
Route::post('savecomponent', 'Component@save');
Route::post('updatecomponent', 'Component@update');
Route::post('deletecomponent', 'Component@delete');
Route::post('savecheckoutcomponent', 'Component@savecheckout');
Route::post('savecheckincomponent', 'Component@savecheckin');
Route::post('componentbyid', 'Component@byid');
Route::post('singlehistorycomponentbyid', 'Component@singlehistorycomponentbyid');
Route::get('component/generateproductcode', 'Component@generateproductcode');
Route::post('componentassetbyid', 'Component@assetsbyid');
Route::post('historycomponentbyid', 'Component@historycomponentbyid');

//Maintenance API
Route::get('maintenance', 'Maintenance@getdata');
Route::get('listmaintenance', 'Maintenance@getrows');
Route::post('savemaintenance', 'Maintenance@save');
Route::post('updatemaintenance', 'Maintenance@update');
Route::post('deletemaintenance', 'Maintenance@delete');
Route::post('maintenancebyid', 'Maintenance@byid');
Route::post('maintenanceassetsbyid', 'Maintenance@assetsbyid');


//Report API
Route::get('listassetactivityreport', 'Reports@getassetactivityreport');
Route::get('listcomponentactivityreport', 'Reports@getcomponentactivityreport');
Route::get('getdatabytypereport', 'Reports@getdatabytypereport');
Route::get('getdatabystatusreport', 'Reports@getdatabystatusreport');
Route::get('getdatabysupplierreport', 'Reports@getdatabysupplierreport');
Route::get('getdatabylocationreport', 'Reports@getdatabylocationreport');


Route::get('add_bulk_employee', 'FunctionalityController@add_bulk_employee');
Route::get('new_asset_update', 'FunctionalityController@new_asset_update');// i put
Route::get('update_employee', 'FunctionalityController@update_employee');// i put

Route::get('/portal_user','Employees@emp_verify'); //i put


