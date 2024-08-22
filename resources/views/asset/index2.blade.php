@extends('main')
@section('content')

<style>
    .card .qr_txt h6 {
        font-size: 11px;
        margin: 0;
        font-weight: 100;
    }
</style>
<section class="">
    <div class="content p-4">
        

        <div class="row">
            <div class="col-md-12">
                <div class="card">

                <div class="w3-bar w3-black" style="margin: 5px 5px 5px 5px;">
                    <button class="w3-bar-item btn btn-sm btn-success" onclick="openCity('Stock')">Stock</button>
                    <button class="w3-bar-item btn btn-sm btn-warning" onclick="openCity('Allocated')">Allocated</button>
                    <button class="w3-bar-item btn btn-sm btn-danger" onclick="openCity('Retiral')">Retiral</button>
                    <b id="tab_name"></b>
                    <input type="hidden" id="active_tab" value="Stock">
                </div>

                <div id="checkoutsuccess" class="display-none alert alert-success"><?php echo trans('lang.data_checkout_succeess');?></div>
                <div id="checkinsuccess"  class="display-none alert alert-success"><?php echo trans('lang.data_checkin_succeess');?></div>
                <div id="messagesuccess"  class="display-none alert alert-success"><?php echo trans('lang.data_added');?></div>
				<div id="messagedelete"  class="display-none alert alert-success"><?php echo trans('lang.data_deleted');?></div>
                <div id="messageretiral"  class="display-none alert alert-success">Moved to Retiral</div>
				<div id="messageupdate"  class="display-none alert alert-success"><?php echo trans('lang.data_updated');?></div>

                <div class="row pt-3" style="    margin: 0 5px 0 5px;padding-top:0rem !important;">
                    <div class="col-md-4"> 
                        <h5 class="" id="tab_title">Stock Asset List</h5> 
                    </div>
                    <div class="col-md-4">
                        <form action="" method="POST" id="form">
                            <div class="">
                                    <div class="form-group">
                                        <!-- <label><?php echo trans('lang.assettype');?></label> -->
                                        <select name="typeid" id="typeid"  class="form-control nice_select">
                                            <option value=""><?php echo trans('lang.assettype');?></option> 
                                        </select>
                                    </div>
                                    <!-- <div class="form-group" style="margin: 0 0 0 10px;">
                                        <button type="submit" class="form-control btn btn-sm btn-fill btn-info"><i class="fa fa-search"></i> <?php echo trans('lang.search');?></button>
                                    </div> -->
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 text-md-right pb-md-0 pb-3">
                    <button type="button" data-toggle="modal" data-target="#add" class="btn btn-sm btn-fill btn-primary" ><i class="fa fa-plus"></i> Add Asset</button>
                    </div>
                </div> 

                <div id="Stock" class="w3-container city">


                    <div class="card-body " style="padding: 0.5rem;">
                        <div class="table-responsive">
                            <table id="data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.picture');?></th>
                                        <th>Asset ID</th>
                                        <th>Asset Detail</th>
                                        <th><?php echo trans('lang.date');?></th>
                                        <th><?php echo trans('lang.cost');?></th>
                                        <th><?php echo trans('lang.description');?></th>
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.brand');?></th>
                                        <th>Emp</th>
                                        <th><?php echo trans('lang.location');?></th>
                                        <th>QR</th>
                                        <th><?php echo trans('lang.action');?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.picture');?></th>
                                        <th>Asset ID</th>
                                        <th>Asset Detail</th>
                                        <th><?php echo trans('lang.date');?></th>
                                        <th><?php echo trans('lang.cost');?></th>
                                        <th><?php echo trans('lang.description');?></th>
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.brand');?></th>
                                        <th>Emp</th>
                                        <th><?php echo trans('lang.location');?></th>
                                        <th>QR</th>
                                        <th><?php echo trans('lang.action');?></th>
                                    </tr>
                                </tfoot>
                               
                            </table>
                        </div>
                    </div>

                </div>

                <div id="Allocated" class="w3-container city" style="display:none">

                <div class="card-body " style="padding: 0.5rem;">
                        <div class="table-responsive">
                            <table id="allocated_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.picture');?></th>
                                        <th>Asset ID</th>
                                        <th>Asset Detail</th>
                                        <th><?php echo trans('lang.date');?></th>
                                        <th><?php echo trans('lang.cost');?></th>
                                        <th><?php echo trans('lang.description');?></th>
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.brand');?></th>
                                        <th>Emp</th>
                                        <th><?php echo trans('lang.location');?></th>
                                        <th>QR</th>
                                        <th><?php echo trans('lang.action');?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.picture');?></th>
                                        <th>Asset ID</th>
                                        <th>Asset Detail</th>

                                        <th><?php echo trans('lang.date');?></th>
                                        <th><?php echo trans('lang.cost');?></th>
                                        <th><?php echo trans('lang.description');?></th>
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.brand');?></th>
                                        <th>Emp</th>
                                        <th><?php echo trans('lang.location');?></th>
                                        <th>QR</th>
                                        <th><?php echo trans('lang.action');?></th>
                                    </tr>
                                </tfoot>
                               
                            </table>
                        </div>
                    </div>

                </div>
                <div id="Retiral" class="w3-container city" style="display:none">

                <div class="card-body " style="padding: 0.5rem;">
                        <div class="table-responsive">
                            <table id="retiral_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.picture');?></th>
                                        <th>Asset ID</th>
                                        <th>Asset Detail</th>

                                        <th><?php echo trans('lang.date');?></th>
                                        <th><?php echo trans('lang.cost');?></th>
                                        <th><?php echo trans('lang.description');?></th>
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.brand');?></th>
                                        <th>Emp</th>
                                        <th><?php echo trans('lang.location');?></th>
                                        <th>QR</th>
                                        <th><?php echo trans('lang.action');?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.picture');?></th>
                                        <th>Asset ID</th>
                                        <th>Asset Detail</th>

                                        <th><?php echo trans('lang.date');?></th>
                                        <th><?php echo trans('lang.cost');?></th>
                                        <th><?php echo trans('lang.description');?></th>
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.brand');?></th>
                                        <th>Emp</th>
                                        <th><?php echo trans('lang.location');?></th>
                                        <th>QR</th>
                                        <th><?php echo trans('lang.action');?></th>
                                    </tr>
                                </tfoot>
                               
                            </table>
                        </div>
                    </div>

                </div>
                <!-- end tab -->


                    
                </div>
            </div>
        </div>
    </div>

    <!--add new data -->
    <div id="add" class="modal fade" role="dialog" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="javascript:void(0)" id="formadd" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                       
                        <h5 class="modal-title"><?php echo trans('lang.add_data');?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div  class="display-none messageexist alert alert-success"><?php echo trans('lang.tag_exist');?></div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Type</label>
                                <select name="type" id="type" required class="form-control">
                                    <option value="">Choose Type</option> 
                                    <option value="OWN">OWN</option>
                                    <option value="Rental">Rental</option>
                                    <option value="BYOD">BYOD</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Asset Category</label>
                                <select name="a_c_id" id="a_c_id" required class="form-control">
                                    <option value="">Choose Asset Category</option> 
                                    @foreach($a_c_data as $key=>$row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Asset Type</label>
                                <select name="a_type_id" id="a_type_id" required class="form-control">
                                    <option value="">Choose Asset Type</option> 
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label><?php echo trans('lang.name');?></label>
                                <input name="name" type="text" id="name" class=" form-control" required placeholder="<?php echo trans('lang.name');?>"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Asset ID</label>
                                <input name="assetid" type="text" id="assetid" class=" form-control" required placeholder="Asset ID"/>
                            </div>
                            <!-- <div class="form-group col-md-4">
                                <label><?php echo trans('lang.serial');?></label>
                                <input name="serial" type="text" id="serial" class="form-control " required placeholder="<?php echo trans('lang.serial');?>"/>
                            </div> -->
                            <div class="form-group col-md-4">
                                <label>Barcode</label>
                                <input name="barcode" type="text" id="barcode" class="form-control " required placeholder="Enter Barcode"/>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Cost Center</label>
                                <input name="cost_center" type="text" id="cost_center" class="form-control "  placeholder="Enter Cost Center"/>
                            </div>
                            
                            <!-- <div class="form-group col-md-4">
                                <label>Employee</label>
                                <select name="employeeid" id="employeeid" required class="form-control">
                                    <option value="">Employee</option> 
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label><?php echo trans('lang.supplier');?></label>
                                <select name="supplierid" id="supplierid" required class="form-control">
                                    <option value=""><?php echo trans('lang.supplier');?></option> 
                                </select>
                            </div> -->

                            
                           
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><?php echo trans('lang.location');?></label>
                                <select name="locationid" id="locationid" class="form-control">
                                    <option value="">Choose Location</option> 
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                            <label><?php echo trans('lang.brand');?></label>
                                <select name="brandid" id="brandid" class="form-control">
                                    <option value="">Choose Brand</option>
                                </select>
                            </div>
                        </div>
                       
                        
                        <div class="form-row">
                            <div class="form-group col-md-4 mb-0" >
								<label for="cost" class="control-label"><?php echo trans('lang.cost');?></label> 
								<div class="input-group mb-0">
									<span class="input-group-addon  border-1" id="currency">₹</span>                                      
									<input class="form-control number" required="" placeholder="<?php echo trans('lang.cost');?>" id="cost" name="cost" type="text">
								</div>
                                <label class="error" for="cost"></label>
							</div>
                            <div class="form-group col-md-4 mb-0">
                                    <label for="date" class="control-label">Date</label>     
                                    <div class="input-group mb-0">                       
									<input class="form-control setdate" required="" placeholder="Date" id="date" name="date" type="text">
                                    <span class="input-group-addon border-1" id="date" ><i class="fa fa-calendar"></i></span>      
                                </div>
                                <label class="error" for="date"></label>
                            </div>

                            <div class="form-group col-md-4 mb-0">
                                <label><?php echo trans('Asset Domain');?></label>
                                <input name="asset_domain" type="text" id="asset_domain" class=" form-control"  placeholder="<?php echo trans('Asset Description');?>"/>
                            </div>
                            
                        </div>
                        <div class="form-row">
                            <!-- <div class="form-group col-md-6 mb-0" >
                                <label for="warranty" class="control-label"><?php echo trans('lang.warranty');?></label> 
								<div class="input-group mb-0" >                                    
									<input class="form-control number" required="" placeholder="<?php echo trans('lang.warranty');?>" id="warranty" name="warranty" type="text">
                                    <span class="input-group-addon border-1" id="warrantyyear" ><?php echo trans('lang.month');?></span>
                                </div>
                                <label class="error" for="warranty"></label>
                            </div> -->
                            <!-- <div class="form-group col-md-4 mb-0">
                                <label><?php echo trans('lang.status');?></label>
                                <select name="status" id="status" required class="form-control">
                                    <option value=""><?php echo trans('lang.status');?></option>
                                    <option value="1"><?php echo trans('lang.readytodeploy');?></option>
                                    <option value="2"><?php echo trans('lang.pending');?></option>
                                    <option value="3"><?php echo trans('lang.archived');?></option>
                                    <option value="4"><?php echo trans('lang.broken');?></option>
                                    <option value="5"><?php echo trans('lang.lost');?></option>
                                    <option value="6"><?php echo trans('lang.outofrepair');?></option>
                                </select>
                            </div> -->
                            <div class="form-group col-md-4">
                                <label>SPOC</label>
                                <select name="spoc_employeeid" id="spoc_employeeid"  class="form-control">
                                    <option value="">Choose SPOC</option> 
                                    @foreach($emp_data as $key=>$row)
                                        <option value="{{$row->emp_id}}">{{$row->fullname}} / {{$row->emp_id}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2 mb-0">
                                <label>Asset Allocate</label>
                                <select name="allocate_check" id="allocate_check" required class="form-control">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 hid_div" style="display:none;">
                                <label>Employee</label>
                                <select name="employeeid" id="employeeid" required class="form-control">
                                    <option value="">Choose Employee</option> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo trans('lang.description');?></label>
                            <textarea class="form-control" name="description" id="description" placeholder="<?php echo trans('lang.description');?>"></textarea>
                        </div>

                        <div class="form-row camera_div">
                            <div class="form-group col-md-3 mb-0 ">
                                <label>Camera Pixel</label>
                                <input name="cam_pix" type="text" id="cam_pix" class=" form-control"  placeholder="Camera Pixel"/>
                            </div> 
                            <div class="form-group col-md-3 mb-0 ">
                                <label>Model</label>
                                <input name="cam_model" type="text" id="cam_model" class=" form-control"  placeholder="Model"/>
                            </div>  
                            <div class="form-group col-md-6 mb-0 ">
                                <label>Serial No</label>
                                <input name="cam_serial_no" type="text" id="cam_serial_no" class=" form-control"  placeholder="Serial No"/>
                            </div>  
                        </div>  

                        <div class="form-row software_div">
                            <div class="form-group col-md-3 mb-0 ">
                                <label>Version</label>
                                <input name="sof_ver" type="text" id="sof_ver" class=" form-control"  placeholder="Version"/>
                            </div> 
                            <div class="form-group col-md-3 mb-0 ">
                                <label>Qty</label>
                                <input name="sof_qty" type="text" id="sof_qty" class=" form-control"  placeholder="Qty"/>
                            </div>  
                            <div class="form-group col-md-6 mb-0 ">
                                <label>User List</label>
                                <input name="sof_user_list" type="text" id="sof_user_list" class=" form-control"  placeholder="User List"/>
                            </div>
                            <div class="form-group col-md-6 mb-0 ">
                                <label>Vendor</label>
                                <input name="sof_vendor" type="text" id="sof_vendor" class=" form-control"  placeholder="Vendor"/>
                            </div> 
                            <div class="form-group col-md-6 mb-0 ">
                                <label>License Key</label>
                                <input name="sof_license_key" type="text" id="sof_license_key" class=" form-control"  placeholder="License Key"/>
                            </div>
                            <div class="form-group col-md-6 mb-0 ">
                                <label>Expiry Date</label>
                                <input name="sof_expiry_date" type="date" id="sof_expiry_date" class=" form-control"  placeholder="Expiry Date"/>
                            </div>  
                        </div> 

                        <div class="form-row ip_div">
                            <div class="form-group col-md-6 mb-0 ">
                                <label>IP Address</label>
                                <input name="ip_address" type="text" id="ip_address" class=" form-control"  placeholder="IP Address"/>
                            </div> 
                        </div> 

                        

                    <div class="form-row showable_div_id">
                        <div class="form-group col-md-6 mb-0">
                            <label><?php echo trans('CPU-Laptop Model');?></label>
                            <input name="cpu_model" type="text" id="cpu_model" class=" form-control"  placeholder="<?php echo trans('CPU Model');?>"/>
                        </div>  
                    </div>

                    

                  <div class="form-row showable_div_id">
                        <div class="form-group col-md-6 mb-0">
                            <label><?php echo trans('CPU-Laptop Configuration');?></label>
                            <input name="cpu_configuration" type="text" id="cpu_configuration" class=" form-control"  placeholder="<?php echo trans('CPU Configuration');?>"/>
                        </div> 
                         <div class="form-group col-md-6 mb-0">
                            <label><?php echo trans('CPU-Laptop Si#');?></label>
                            <input name="cpu_si" type="text" id="cpu_si" class=" form-control"  placeholder="<?php echo trans('CPU Si#');?>"/>
                        </div> 
</div>
                    <div class="form-row showable_div_id">
                        <div class="form-group col-md-6 mb-0">
                            <label><?php echo trans('RAM');?></label>
                            <input name="ram" type="text" id="ram" class=" form-control"  placeholder="<?php echo trans('RAM');?>"/>
                        </div>  
                        <div class="form-group col-md-6 mb-0">
                            <label><?php echo trans('HDD-SSD');?></label>
                            <input name="hdd" type="text" id="hdd" class=" form-control"  placeholder="<?php echo trans('HDD');?>"/>
                        </div>  
</div>

                    <div class="form-row showable_div_id">
                        <div class="form-group col-md-6 mb-0">
                            <label><?php echo trans('MOUSE');?></label>
                            <input name="mouse" type="text" id="mouse" class=" form-control"  placeholder="<?php echo trans('MOUSE');?>"/>
                        </div>  
                        <div class="form-group col-md-6 mb-0">
                            <label><?php echo trans('OS');?></label>
                            <input name="os" type="text" id="os" class=" form-control"  placeholder="<?php echo trans('OS');?>"/>
                        </div> 
</div>

                        <div class="form-row desktop_div">
                            <div class="form-group col-md-6 mb-0 ">
                                <label>Monitor Size</label>
                                <input name="mon_size" type="text" id="mon_size" class=" form-control"  placeholder="Monitor Size"/>
                            </div>  
                            <div class="form-group col-md-6 mb-0 ">
                                <label>Monitor Serial</label>
                                <input name="mon_serial" type="text" id="mon_serial" class=" form-control"  placeholder="Monitor Serial"/>
                            </div>  
                        </div> 

                        <div class="form-row ">
                            <div class="form-group col-md-6 mb-0 showable_div_id" >
                                <label><?php echo trans('Keyboard');?></label>
                                <input name="keyboard" type="text" id="keyboard" class=" form-control"  placeholder="<?php echo trans('MOUSE');?>"/>
                            </div>  
                            <div class="form-group col-md-6 mb-0">                         
                                <label><?php echo trans('lang.picture');?></label>
                                <input name="picture" type="file" id="picture" class=" form-control"  placeholder="<?php echo trans('lang.picture');?>"/>
                            </div>
                        </div>      
                        <div class="form-row ">
                        <div class="form-group col-md-6 mb-0  lap_asset" >
                             <label><?php echo trans('Charger');?></label><br>
                            <input type="checkbox" id="asset_charger" name="asset_charger" value="1">
                            <label for="vehicle1"> </label><br>
  
                        </div>
                        <div class="form-group col-md-6 mb-0  lap_asset">
                        <label><?php echo trans('Bag');?></label><br>
                        <input type="checkbox" id="asset_bag" name="asset_bag" value="1">
                        <label for="vehicle1"> </label><br>
                        </div>  
                        
</div>                 
                       
                    </div>
                    <div class="modal-footer">
                    <input type="hidden" id="asset_type_hidden_field">
                        <button type="submit" class="btn btn-primary"
                            id="save"><?php echo trans('lang.save');?></button>
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo trans('lang.close');?></button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
    <!--end add data-->

    <!--edit new data -->
    <div id="edit" class="modal fade" role="dialog" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="#" id="formedit" enctype="multipart/form-data">
                    <div class="modal-header">
                       
                        <h5 class="modal-title"><?php echo trans('lang.edit_data');?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div  class="messageexist alert alert-success display-none">Error! The Asset ID has been registered for another asset.</div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Type</label>
                                <select name="edit_type" id="edit_type" required class="form-control" disabled >
                                    <option value="">Choose Type</option> 
                                    <option value="OWN">OWN</option>
                                    <option value="Rental">Rental</option>
                                    <option value="BYOD">BYOD</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Asset Category</label>
                                <select name="edit_a_c_id" id="edit_a_c_id" required class="form-control" disabled>
                                    <option value="">Choose Asset Category</option> 
                                    @foreach($a_c_data as $key=>$row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Asset Type</label>
                                <select name="edit_a_type_id" id="edit_a_type_id" required class="form-control" disabled>
                                    <option value="">Choose Asset Type</option> 
                                </select>
                            </div>
                        </div>

                        
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label><?php echo trans('lang.name');?></label>
                                <input name="name" type="text" id="editname" class=" form-control" required placeholder="<?php echo trans('lang.name');?>"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Asset ID</label>
                                <input name="assetid" type="text" id="editassetid" class=" form-control" required placeholder="Asset ID" readonly/>
                            </div>
                            <!-- <div class="form-group col-md-4">
                                <label><?php echo trans('lang.serial');?></label>
                                <input name="serial" type="text" id="editserial" class="form-control " required placeholder="<?php echo trans('lang.serial');?>"/>
                            </div> -->
                            <div class="form-group col-md-4">
                                <label>Barcode</label>
                                <input name="edit_barcode" type="text" id="edit_barcode" class="form-control " required placeholder=""/>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Cost Center</label>
                                <input name="edit_cost_center" type="text" id="edit_cost_center" class="form-control "  placeholder="Enter Cost Center"/>
                            </div>

                            <!-- <div class="form-group col-md-4">
                                <label>Employee</label>
                                <select name="employeeid" id="editemployeeid" required class="form-control">
                                    <option value="">Employee</option> 
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label><?php echo trans('lang.supplier');?></label>
                                <select name="supplierid" id="editsupplierid" required class="form-control">
                                    <option value=""><?php echo trans('lang.supplier');?></option> 
                                </select>
                            </div> -->
                        </div>
                        <div class="form-row">
                            
                            <div class="form-group col-md-6">
                                <label><?php echo trans('lang.location');?></label>
                                <select name="locationid" id="editlocationid" required class="form-control">
                                    <option value="">Choose Location</option> 
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                            <label><?php echo trans('lang.brand');?></label>
                                <select name="brandid" id="editbrandid" required class="form-control">
                                    <option value="">Choose Brand</option>
                                </select>
                            </div>
                        </div>
                       
                        <div class="form-row">
                            <!-- <div class="form-group col-md-6">
                                <label><?php echo trans('lang.serial');?></label>
                                <input name="serial" type="text" id="editserial" class="form-control " required placeholder="<?php echo trans('lang.serial');?>"/>
                            </div> -->
                            <!-- <div class="form-group col-md-6">
                                <label><?php echo trans('lang.assettype');?></label>
                                <select name="typeid" id="edittypeid" required class="form-control">
                                    <option value=""><?php echo trans('lang.assettype');?></option> 
                                </select>
                            </div> -->
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 mb-0" >
								<label for="cost" class="control-label"><?php echo trans('lang.cost');?></label> 
								<div class="input-group mb-0" >
									<span class="input-group-addon setcurrency border-1" id="editcurrency" ></span>                                      
									<input class="form-control number" required="" placeholder="<?php echo trans('lang.cost');?>" id="editcost" name="cost" type="text">
								</div>
                                <label class="error" for="cost"></label>
							</div>
                            <div class="form-group col-md-4 mb-0" >
                                    <label for="date" class="control-label">Date</label>     
                                    <div class="input-group mb-0" >                       
									<input class="form-control setdate" required="" placeholder="Date" id="editdate" name="date" type="text">
                                    <span class="input-group-addon border-1" id="editdate" ><i class="fa fa-calendar"></i></span>      
                                </div>
                                <label class="error" for="date"></label>
                            </div>
                            <div class="form-group col-md-4 mb-0">
                                <label><?php echo trans('Asset Domain');?></label>
                                <input name="editasset_domain" type="text" id="editasset_domain" class=" form-control"  placeholder="<?php echo trans('Asset Description');?>"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <!-- <div class="form-group col-md-6 mb-0" >
                            <label for="warranty" class="control-label"><?php echo trans('lang.warranty');?></label> 
								<div class="input-group mb-0" >                                    
									<input class="form-control number" required="" placeholder="<?php echo trans('lang.warranty');?>" id="editwarranty" name="warranty" type="text">
                                    <span class="input-group-addon border-1" id="editwarrantyyear" ><?php echo trans('lang.month');?></span>
                                </div>
                                <label class="error" for="warranty"></label>
                            </div> -->
                            <!-- <div class="form-group col-md-4 mb-0" >
                            <label><?php echo trans('lang.status');?></label>
                            <select name="status" id="editstatus" required class="form-control">
                                <option value=""><?php echo trans('lang.status');?></option>
                                <option value="1"><?php echo trans('lang.readytodeploy');?></option>
                                <option value="2"><?php echo trans('lang.pending');?></option>
                                <option value="3"><?php echo trans('lang.archived');?></option>
                                <option value="4"><?php echo trans('lang.broken');?></option>
                                <option value="5"><?php echo trans('lang.lost');?></option>
                                <option value="6"><?php echo trans('lang.outofrepair');?></option>
                            </select>
                            </div> -->
                            <div class="form-group col-md-4 edit_hid_div" style="">
                                <label>SPOC</label>
                                <select name="edit_spoc_employeeid" id="edit_spoc_employeeid"  readonly class="form-control">
                                    <option value="">Choose Employee</option> 
                                </select>
                            </div>
                            <div class="form-group col-md-2 mb-0">
                                <label>Asset Allocate</label>
                                <select name="edit_allocate_check" id="edit_allocate_check" required readonly class="form-control">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 edit_hid_div" style="display:none;">
                                <label>Employee</label>
                                <select name="edit_employeeid" id="edit_employeeid" required readonly class="form-control">
                                    <option value="">Choose Employee</option> 
                                </select>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label><?php echo trans('lang.description');?></label>
                            <textarea class="form-control" name="description" id="editdescription" placeholder="<?php echo trans('lang.description');?>"></textarea>
                        </div>

                        <div class="form-row edit_camera_div">
                            <div class="form-group col-md-3 mb-0 ">
                                <label>Camera Pixel</label>
                                <input name="edit_cam_pix" type="text" id="edit_cam_pix" class=" form-control"  placeholder="Camera Pixel"/>
                            </div> 
                            <div class="form-group col-md-3 mb-0 ">
                                <label>Model</label>
                                <input name="edit_cam_model" type="text" id="edit_cam_model" class=" form-control"  placeholder="Model"/>
                            </div>  
                            <div class="form-group col-md-6 mb-0 ">
                                <label>Serial No</label>
                                <input name="edit_cam_serial_no" type="text" id="edit_cam_serial_no" class=" form-control"  placeholder="Serial No"/>
                            </div>  
                        </div> 

                        <div class="form-row edit_software_div">
                            <div class="form-group col-md-3 mb-0 ">
                                <label>Version</label>
                                <input name="edit_sof_ver" type="text" id="edit_sof_ver" class=" form-control"  placeholder="Version"/>
                            </div> 
                            <div class="form-group col-md-3 mb-0 ">
                                <label>Qty</label>
                                <input name="edit_sof_qty" type="text" id="edit_sof_qty" class=" form-control"  placeholder="Qty"/>
                            </div>  
                            <div class="form-group col-md-6 mb-0 ">
                                <label>User List</label>
                                <input name="edit_sof_user_list" type="text" id="edit_sof_user_list" class=" form-control"  placeholder="User List"/>
                            </div>
                            <div class="form-group col-md-6 mb-0 ">
                                <label>Vendor</label>
                                <input name="edit_sof_vendor" type="text" id="edit_sof_vendor" class=" form-control"  placeholder="Vendor"/>
                            </div> 
                            <div class="form-group col-md-6 mb-0 ">
                                <label>License Key</label>
                                <input name="edit_sof_license_key" type="text" id="edit_sof_license_key" class=" form-control"  placeholder="License Key"/>
                            </div>
                            <div class="form-group col-md-6 mb-0 ">
                                <label>Expiry Date</label>
                                <input name="edit_sof_expiry_date" type="date" id="edit_sof_expiry_date" class=" form-control"  placeholder="Expiry Date"/>
                            </div>  
                        </div> 

                        <div class="form-row edit_ip_div">
                            <div class="form-group col-md-6 mb-0 ">
                                <label>IP Address</label>
                                <input name="edit_ip_address" type="text" id="edit_ip_address" class=" form-control"  placeholder="IP Address"/>
                            </div> 
                        </div> 


                        <div class="form-row showable_div_id_2">
                       
                        
                        <div class="form-group col-md-6 mb-0">
                            <label><?php echo trans('CPU-Laptop Model');?></label>
                            <input name="edit_cpu_model" type="text" id="edit_cpu_model" class=" form-control"  placeholder="<?php echo trans('CPU Model');?>"/>
                        </div>  
</div>
                  <div class="form-row showable_div_id_2">
                        <div class="form-group col-md-6 mb-0">
                            <label><?php echo trans('CPU-Laptop Configuration');?></label>
                            <input name="edit_cpu_configuration" type="text" id="edit_cpu_configuration" class=" form-control"  placeholder="<?php echo trans('CPU Configuration');?>"/>
                        </div> 
                         <div class="form-group col-md-6 mb-0">
                            <label><?php echo trans('CPU-Laptop Si#');?></label>
                            <input name="edit_cpu_si" type="text" id="edit_cpu_si" class=" form-control"  placeholder="<?php echo trans('CPU Si#');?>"/>
                        </div> 
</div>
                    <div class="form-row showable_div_id_2">
                        <div class="form-group col-md-6 mb-0">
                            <label><?php echo trans('RAM');?></label>
                            <input name="edit_ram" type="text" id="edit_ram" class=" form-control"  placeholder="<?php echo trans('RAM');?>"/>
                        </div>  
                        <div class="form-group col-md-6 mb-0">
                            <label><?php echo trans('HDD-SSD');?></label>
                            <input name="edit_hdd" type="text" id="edit_hdd" class=" form-control"  placeholder="<?php echo trans('HDD');?>"/>
                        </div>  
</div>

                    <div class="form-row showable_div_id_2">
                        <div class="form-group col-md-6 mb">
                            <label><?php echo trans('Keyboard');?></label>
                            <input type="text"  name="edit_Keyboard" id="edit_Keyboard" class="form-control verification_key"  placeholder="<?php echo trans('Keyboard');?>"/>
                        </div>  
                        <div class="form-group col-md-6 mb">
                            <label><?php echo trans('MOUSE');?></label>
                            <input name="edit_mouse" type="text" id="edit_mouse" class=" form-control"  placeholder="<?php echo trans('MOUSE');?>"/>
                        </div>  
</div>

                <div class="form-row desktop_div_edit">
                    <div class="form-group col-md-6 mb-0 ">
                        <label>Monitor Size</label>
                        <input name="edit_mon_size" type="text" id="edit_mon_size" class=" form-control"  placeholder="Monitor Size"/>
                    </div>  
                    <div class="form-group col-md-6 mb-0 ">
                        <label>Monitor Serial</label>
                        <input name="edit_mon_serial" type="text" id="edit_mon_serial" class=" form-control"  placeholder="Monitor Serial"/>
                    </div>  
                </div> 

                <div class="form-row showable_div_id_2">
                <div class="form-group col-md-6 mb-0">
                            <label><?php echo trans('OS');?></label>
                            <input name="edit_os" type="text" id="edit_os" class=" form-control"  placeholder="<?php echo trans('OS');?>"/>
                        </div> 
                        <div class="form-group">
                            <label><?php echo trans('lang.picture');?></label>
                            <input name="picture" type="file" id="editpicture" class=" form-control"  placeholder="<?php echo trans('lang.picture');?>"/>
                        </div>
</div>
<div class="form-row ">
                        <div class="form-group col-md-6 mb-0  lap_asset1" >
                             <label><?php echo trans('Charger');?></label><br>
                            <input type="checkbox" id="editasset_charger" name="editasset_charger">
                            <label for="vehicle1"> </label><br>
  
                        </div>
                        <div class="form-group col-md-6 mb-0  lap_asset1">
                        <label><?php echo trans('Bag');?></label><br>
                        <input type="checkbox" id="editasset_bag" name="editasset_bag">
                        <label for="vehicle1"> </label><br>
                        </div>  
                        
</div>                 
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="editid"/>
                        <input type="hidden" id="editasset_type_hidden_field">
                        <button type="submit" class="btn btn-primary"
                            id="saveedit"><?php echo trans('lang.save');?></button>
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo trans('lang.close');?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end edit data-->



     <!--add checkout -->
     <div id="checkout" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" id="formcheckout" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                       
                        <h5 class="modal-title">Get Back</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Asset ID</label>
                                <input name="assetid" type="text" readonly id="checkoutassetid" class=" form-control" required placeholder="Asset ID"/>
                            </div>
                            <div class="form-group col-md-12">
                                <label><?php echo trans('lang.asset');?></label>
                                <input name="asset" type="text" readonly id="checkoutname" class=" form-control" required placeholder="<?php echo trans('lang.asset');?>"/>
                            </div>
                            
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Location</label>
                                <select name="locationid" id="retiral_locationid" required class="form-control">
                                    <option value="">Choose Location</option> 
                                </select>
                            </div>
                        </div>
                        
                       
                        <div class="form-row">
                            <div class="form-group col-md-12 mb-0" >
                                    <label for="get_back_date" class="control-label">Get Back Date</label>     
                                    <div class="input-group mb-0" >                       
									<input class="form-control setdate" required="" placeholder="get back Date" id="get_back_date" name="get_back_date" type="text">
                                    <span class="input-group-addon border-1" id="date" ><i class="fa fa-calendar"></i></span>      
                                </div>
                                <label class="error" for="get_back_date"></label>
                            </div>
                        </div>
                        <div class="form-row ">
                        <div class="form-group col-md-6 mb-0  disallocate_lap_asset" >
                             <label><?php echo trans('Charger');?></label><br>
                            <input type="checkbox" id="disallocate_charger" name="disallocate_charger" value="1">
                            <label for="disallocate_charger"> </label><br>
  
                        </div>
                        <div class="form-group col-md-6 mb-0  disallocate_lap_asset">
                        <label><?php echo trans('Bag');?></label><br>
                        <input type="checkbox" id="disallocate_bag" name="disallocate_bag" value="1">
                        <label for="disallocate_bag"> </label><br>
                        </div>  
                        
</div>                  
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"
                            id="savecheckout"><?php echo trans('lang.save');?></button>
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo trans('lang.close');?></button>
                    </div>
                    <input type="hidden" id="hidden_disallocate_id">
                </form>
            </div>
        </div>
    </div>
    <!--end checkout-->


     <!--add checkin -->
     <div id="checkin" class="modal fade" role="dialog" >
        <div class="modal-dialog ">
            <div class="modal-content">
                <form action="#" id="formcheckin" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <h5 class="modal-title">Allocate Asset</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Asset ID</label>
                                <input name="assetid" type="text" readonly id="checkinassetid" class=" form-control" required placeholder="Asset ID"/>
                            </div>
                            <div class="form-group col-md-12">
                                <label><?php echo trans('lang.asset');?></label>
                                <input name="asset" type="text" readonly id="checkinname" class=" form-control" required placeholder="<?php echo trans('lang.asset');?>"/>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Employee</label>
                                <select name="ch_in_employeeid" id="ch_in_employeeid" required class="form-control">
                                    <option value="">Choose Employee</option> 
                                    @foreach($emp_data as $key=>$row)
                                        <option value="{{$row->emp_id}}">{{$row->fullname}} / {{$row->emp_id}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                            
                        </div>
                       
                        <div class="form-row">
                            <div class="form-group col-md-12 mb-0" >
                                    <label for="allocated_date" class="control-label">Allocated Date</label>     
                                    <div class="input-group mb-0" >                       
                                    <input class="form-control setdate" required="" placeholder="allocated date" id="allocated_date" name="allocated_date" type="text">
                                    <span class="input-group-addon border-1" id="date" ><i class="fa fa-calendar"></i></span>      
                                </div>
                                <label class="error" for="allocated_date"></label>
                            </div>
                        </div>
                        <div class="form-row ">
                        <div class="form-group col-md-6 mb-0  allocate_lap_asset" >
                             <label><?php echo trans('Charger');?></label><br>
                            <input type="checkbox" id="allocate_charger" name="allocate_charger" value="1">
                            <label for="allocate_charger"> </label><br>
  
                        </div>
                        <div class="form-group col-md-6 mb-0  allocate_lap_asset">
                        <label><?php echo trans('Bag');?></label><br>
                        <input type="checkbox" id="allocate_bag" name="allocate_bag" value="1">
                        <label for="allocate_bag"> </label><br>
                        </div>  
                        
</div>                 
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"
                            id="savecheckin"><?php echo trans('lang.save');?></button>
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo trans('lang.close');?></button>
                    </div>
                    <input type="hidden" id="hidden_asset_id">
                </form>
            </div>
        </div>
    </div>
    <!--end checkin-->

    <!-- retiral -->
    <div class="modal fade" id="retiral" role="dialog">
        <div class="modal-dialog">
        <div class="modal-content col-md-12">
            <form action="#" id="formretiral">
                <div class="modal-header">
                    <h5 class="modal-title">Move to Retiral</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="row">

                <div class="form-group col-md-6">
                    <label>Retiral Type</label>
                    <select name="retiral_type" id="retiral_type" required class="form-control">
                        <option value="">Choose Type</option> 
                        <option value="Retiral">Retiral</option> 
                        <option value="Replacement & Retiral">Replacement / Retiral</option> 
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <div style="display:none;" id="asset_id_hid_field">
                        <label>Asset ID</label>
                        <select name="r_assetid" id="r_assetid" class="form-control nice_select">
                            <option value="">Choose Asset ID</option> 
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>Retiral Date</label>
                    <input type="date" name="retiraldate" id="retiraldate" required class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label>Reason</label>
                    <select name="retiral_reason" id="retiral_reason" required class="form-control">
                        <option value="">Choose Reason</option> 
                        <option value="LOST">LOST</option> 
                        <option value="STOLEN">STOLEN</option> 
                        <option value="EMPLOYEE ABSCONDING">EMPLOYEE ABSCONDING</option> 
                        <option value="PERMANENTLY DAMAGED">PERMANENTLY DAMAGED</option> 
                        <option value="END OF LIFE">END OF LIFE</option> 
                        <option value="EMPLOYEE BUY BACK (BYOD)">EMPLOYEE BUY BACK (BYOD)</option> 
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <label>Remark</label>
                    <textarea name="remark" id="remark" cols="30" class="form-control" rows="10"></textarea>
                </div>

                </div>


                <div class="modal-body">
                    <p>Are you sure to Retiral?</p>
                    <input type="hidden" value="" name="id" id="idretiral"/>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="delete">Retiral</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo trans('lang.close');?></button>
                </div>
            </form>   
        </div>
        </div>
    </div>
    <!-- end retiral -->

    <!--delete data -->
    <div class="modal fade" id="delete" role="dialog">
        <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="#" id="formdelete">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo trans('lang.delete');?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p><?php echo trans('lang.delete_confirm');?></p>
                    <input type="hidden" value="" name="id" id="iddelete"/>
            
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="delete"><?php echo trans('lang.delete');?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo trans('lang.close');?></button>
                </div>
            </form>   
        </div>
        </div>
    </div>
    <!--end delete data -->
</section>

<script> 


// for export all data
function newexportaction(e, dt, button, config) {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;
    dt.one('preXhr', function (e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647;
        dt.one('preDraw', function (e, settings) {
            // Call the original action function
            if (button[0].className.indexOf('buttons-copy') >= 0) {
                $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
            dt.one('preXhr', function (e, s, data) {
                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                // Set the property to what it was before exporting.
                settings._iDisplayStart = oldStart;
                data.start = oldStart;
            });
            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
            setTimeout(dt.ajax.reload, 0);
            // Prevent rendering of the full data to the DOM
            return false;
        });
    });
    // Requery the server with the new one-time export settings
    dt.ajax.reload();
}

(function($) {
$(".camera_div").hide();
$(".showable_div_id").hide();
$(".desktop_div").hide();
$(".lap_asset").hide();
$(".lap_asset1").hide();
$(".showable_div_id_2").hide();
$(".desktop_div_edit").hide();



"use strict";

    var tabledata = $('#data').DataTable({

        bFilter : true,

        ajax: {
                url : "{{ url('asset')}}",
                data: function (d) {
                    d.assettype = $("#typeid").val();
                },
            },
        columns: [{
            data: 'id',
                orderable: false,
                searchable: false,
                visible: false
            },
            {
                data: 'pictures'
            },
            {
                data: 'assetid',
                visible: false
            },
            {
                data: 'asset_detail'
            },
            {
                data: 'date',
                orderable: false,
                searchable: false,
                visible: false
            },
            {data: 'cost',
                orderable: false,
                searchable: false,
                visible: false
            },
           
            {
             data: 'description',
                orderable: false,
                searchable: false,
                visible: false
            },
            {
                data: 'name',
                visible: false
            },
            {
                data: 'type',name: 'asset_type.name', searchable: true
            },
            {
                data: 'brand',name: 'brand.name', searchable: true
            },
            {
                data: 'emp_detail'
            },
            {
                data: 'location',name: 'location.name', searchable: true
            },
            {
                data: 'qr'
            },

            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ],
        buttons: [{
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.asset_list ');?>',
                exportOptions: {
                    page: 'all',
                    columns: [2, 3, 4 ,5, 6 ,7 ,8, 9, 10]
                },
                action: newexportaction,
            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.asset_list');?>',
                exportOptions: {
                    page: 'all',
                    columns: [2, 3, 4 ,5, 6 ,7 ,8, 9, 10]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.asset_list');?>',
                orientation: 'landscape',
                exportOptions: {
                    page: 'all',
                    columns: [2, 3, 4 ,5, 6 ,7 ,8, 9, 10]
                },
                action: newexportaction,
                
                customize: function(doc) {
                    doc.styles.tableHeader.alignment = 'left';
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1)
                        .join('*').split('');
                }
            },
            {
                extend: 'print',
                title: '<?php echo trans('lang.asset_list');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    page: 'all',
                    columns: [2, 3, 4 ,5, 6 ,7 ,8, 9, 10]
                },
                action: newexportaction,

            }
        ]
    });


    var allocated_tabledata = $('#allocated_data').DataTable({

    bFilter : true,

    ajax: {
            url : "{{ url('allocated_asset')}}",
            data: function (d) {
                d.assettype = $("#typeid").val();
            },
        },

      
        columns: [{
            data: 'id',
                orderable: false,
                searchable: false,
                visible: false
            },
            {
                data: 'pictures'
            },
            {
                data: 'assetid',
                visible: false
            },
            {
                data: 'asset_detail'
            },
            {
                data: 'date',
                orderable: false,
                searchable: false,
                visible: false
            },
            {data: 'cost',
                orderable: false,
                searchable: false,
                visible: false
            },
           
            {
             data: 'description',
                orderable: false,
                searchable: false,
                visible: false
            },
            {
                data: 'name',
                visible: false
            },
            {
                data: 'type',name: 'asset_type.name', searchable: true
            },
            {
                data: 'brand',name: 'brand.name', searchable: true
            },
            {
                data: 'emp_detail'
            },
            {
                data: 'location',name: 'location.name', searchable: true
            },
            {
                data: 'qr'
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ],
        buttons: [{
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.asset_list ');?>',
                exportOptions: {
                    columns: [2, 3, 4 ,5, 6 ,7 ,8, 9, 10]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.asset_list');?>',
                exportOptions: {
                    columns: [2, 3, 4 ,5, 6 ,7 ,8, 9, 10]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.asset_list');?>',
                orientation: 'landscape',
                exportOptions: {
                    columns: [2, 3, 4 ,5, 6 ,7 ,8, 9, 10]
                },
                action: newexportaction,

                customize: function(doc) {
                    doc.styles.tableHeader.alignment = 'left';
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1)
                        .join('*').split('');
                }
            },
            {
                extend: 'print',
                title: '<?php echo trans('lang.asset_list');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    columns: [2, 3, 4 ,5, 6 ,7 ,8, 9, 10]
                },
                action: newexportaction,

            }
        ]
    });

    var retiral_tabledata = $('#retiral_data').DataTable({

    bFilter : true,

    ajax: {
            url : "{{ url('retiral_asset')}}",
            data: function (d) {
                d.assettype = $("#typeid").val();
            },
        },
        
        columns: [{
            data: 'id',
                orderable: false,
                searchable: false,
                visible: false
            },
            {
                data: 'pictures'
            },
            {
                data: 'assetid',
                visible: false
            },
            {
                data: 'asset_detail'
            },
            {
                data: 'date',
                orderable: false,
                searchable: false,
                visible: false
            },
            {data: 'cost',
                orderable: false,
                searchable: false,
                visible: false
            },
           
            {
             data: 'description',
                orderable: false,
                searchable: false,
                visible: false
            },
            {
                data: 'name',
                visible: false
            },
            {
                data: 'type',name: 'asset_type.name', searchable: true
            },
            {
                data: 'brand',name: 'brand.name', searchable: true
            },
            {
                data: 'emp_detail'
            },
            {
                data: 'location',name: 'location.name', searchable: true
            },
            {
                data: 'qr'
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ],
        buttons: [{
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.asset_list ');?>',
                exportOptions: {
                    columns: [2, 3, 4 ,5, 6 ,7 ,8, 9, 10]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.asset_list');?>',
                exportOptions: {
                    columns: [2, 3, 4 ,5, 6 ,7 ,8, 9, 10]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.asset_list');?>',
                orientation: 'landscape',
                exportOptions: {
                    columns: [2, 3, 4 ,5, 6 ,7 ,8, 9, 10]
                },
                action: newexportaction,

                customize: function(doc) {
                    doc.styles.tableHeader.alignment = 'left';
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1)
                        .join('*').split('');
                }
            },
            {
                extend: 'print',
                title: '<?php echo trans('lang.asset_list');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    columns: [2, 3, 4 ,5, 6 ,7 ,8, 9, 10]
                },
                action: newexportaction,

            }
        ]
    });



    //do search
    $("#typeid").change(function(e){

        var tab=$("#active_tab").val();
        if(tab=="Stock"){
            tabledata.draw();
        }
        if(tab=="Allocated"){
            allocated_tabledata.draw();
        }
        if(tab=="Retiral"){
            retiral_tabledata.draw();
        }

        e.preventDefault();
    });



// get asset type
// $("#a_c_id").change(function(){
//     var id=$("#a_c_id").val();
    
//     $.ajax({
//         type: "GET",
// 		url: "{{ url('asset_type_based_category')}}",
//         data: {"id":id},
// 		dataType: "JSON",
// 		success: function(html) {
//             $("#a_type_id").html(html.asset_type_div);
// 		}   
//     }); 
// })
$(()=>{
    $.ajax({
        type: "GET",
		url: "{{ url('category_info')}}",
		dataType: "JSON",
		success: function(html) {
            $("#a_type_id").html(html.asset_type_div);
		}   
    });   
})
$("#edit_a_c_id").change(function(){
    var id=$("#edit_a_c_id").val();
    var assetid=$("#editassetid").val();
    $.ajax({
        type: "GET",
		url: "{{ url('asset_type_based_category_edit')}}",
        data: {"id":id,"assetid":assetid},
		dataType: "JSON",
		success: function(html) {
            $("#edit_a_type_id").html(html.asset_type_div);
		}   
    }); 
})
$("#edit_a_type_id").change(()=>{
    var id=$("#edit_a_type_id").val();
    $.ajax({
        type: "POST",
		url: "{{ url('asset_type_based_show_catagory')}}",
        data: {"id":id},
		dataType: "JSON",
		success: function(html) {
           
              if(html.asset_type_div.field_id=="2")
                {
                    $(".showable_div_id_2").show();
                    $(".lap_asset1").show(); 
                       
                }
                else if(html.asset_type_div.field_id=="3")
                {
                    $(".showable_div_id_2").show();
                    $(".lap_asset1").hide(); 
                     
                }
                
                else{
                    $(".showable_div_id_2").hide();
                    $(".lap_asset1").hide();
                }
                $('#editasset_type_hidden_field').val(html.asset_type_div.field_id)
                
            // $("#edit_a_type_id").html(html.asset_type_div);
		}   
    }); 
   
})
$("#a_type_id").change(()=>{
    var id=$("#a_type_id").val(); 
    $.ajax({
        type: "POST",
		url: "{{ url('asset_type_based_show_catagory')}}",
        data: {"id":id},
		dataType: "JSON",
		success: function(html) {
            console.log(html)

                $(".camera_div").hide(); 
                $(".showable_div_id").hide(); 
                $(".desktop_div").hide();  
                $(".lap_asset").hide(); 
                $(".software_div").hide(); 

              if(html.asset_type_div.field_id=="2")
                {
                    $(".showable_div_id").show();  
                    $(".desktop_div").hide();  
                         
                    if($("#allocate_check").val()=="Yes"){
                    $(".lap_asset").show();                                  
                    }
                    else{
                      $(".lap_asset").hide();                                  
                    }
                }
               else if(html.asset_type_div.field_id=="3") 
                {  
                    $(".showable_div_id").show(); 
                    $(".desktop_div").show();  
                    $(".lap_asset").hide(); 
                }
                else if(html.asset_type_div.field_id=="4") 
                {  
                    $(".camera_div").show(); 
                }
                else if(html.asset_type_div.field_id=="5") 
                {  
                    $(".software_div").show(); 
                    $(".ip_div").hide();
                }
                else{  
                    $(".showable_div_id").hide();
                    $(".lap_asset").hide();
                }
                $('#asset_type_hidden_field').val(html.asset_type_div.field_id)
            // $("#edit_a_type_id").html(html.asset_type_div);
		}   
    }); 
   
})
//get all supplier
$.ajax({
        type: "GET",
		url: "{{ url('listsupplier')}}",
		dataType: "JSON",
		success: function(html) {
            
            var objs = html.message;
            jQuery.each(objs, function (index, record) {
                // console.log(record)
                var id = decodeURIComponent(record.id);
                var name = decodeURIComponent(record.name);
                $("#supplierid").append($("<option></option>")
                    .attr("value",id)
                    .text(name)); 
                $("#editsupplierid").append($("<option></option>")
                    .attr("value",id)
                    .text(name));     
            });
		}   
    }); 

//get all employee
$.ajax({
        type: "GET",
		url: "{{ url('listemployees')}}", 
		dataType: "JSON",
		success: function(html) {
            var objs = html.message;
            jQuery.each(objs, function (index, record) {
                var id = decodeURIComponent(record.id);
                var name = decodeURIComponent(record.fullname);
                $("#checkinemployeeid").append($("<option></option>")
                    .attr("value",id)
                    .text(name)); 
                // $("#checkoutemployeeid").append($("<option></option>")
                //     .attr("value",id)
                //     .text(name)); 
            });

            jQuery.each(objs, function (index, record) {
                var id = decodeURIComponent(record.id);
                var name = decodeURIComponent(record.fullname);
                var emp_id = decodeURIComponent(record.emp_id);
                var show_val = name+' / '+emp_id ;

                $("#employeeid").append($("<option></option>")
                    .attr("value",emp_id)
                    .text(show_val)); 
                
            });
		}   
    }); 


//get all asset type
$.ajax({
        type: "GET",
		url: "{{ url('listassettype')}}",
		dataType: "JSON",
		success: function(html) {
            var objs = html.message;
            jQuery.each(objs, function (index, record) {
                var id = decodeURIComponent(record.id);
                var name = decodeURIComponent(record.name);
                $("#typeid").append($("<option></option>")
                    .attr("value",id)
                    .text(name)); 
                $("#edittypeid").append($("<option></option>")
                    .attr("value",id)
                    .text(name));     
            });
		}   
    }); 

//check allocated list
$("#allocate_check").change(function(){
    var check=$("#allocate_check").val();
    if(check=="Yes"){
        $(".hid_div").css("display","block");
    }
    else{
        $(".hid_div").css("display","none");
    }
}) 

// retiral type change
$("#retiral_type").change(function(){
    var retiral_type=$("#retiral_type").val();
    if(retiral_type=="Replacement & Retiral"){

        // get active assets list
        var edit_asset_id=$("#idretiral").val();

        $.ajax({  
            type: "POST",
            url: "{{ url('listasset_active')}}", 
            data: {'edit_asset_id':edit_asset_id,},  
            dataType: "JSON",

            success: function (data) {

                if(data.response=="Success"){
                    $("#r_assetid").html(data.asset_div);
                }
            }
        })

        // end get active assets list
        $("#r_assetid").attr("required", "required");

        $("#asset_id_hid_field").css("display","block");
    }
    else{
        $("#r_assetid").removeAttr('required');
        $("#asset_id_hid_field").css("display","none");
    }
})

//check allocated list
$("#edit_allocate_check").change(function(){
    var check=$("#edit_allocate_check").val();
    if(check=="Yes"){
        $(".edit_hid_div").css("display","block");
    }
    else{
        $(".edit_hid_div").css("display","none");
    }
}) 

//get all brand 
$.ajax({
        type: "GET",
		url: "{{ url('listbrand')}}",
		dataType: "JSON",
		success: function(html) {
            var objs = html.message;
            jQuery.each(objs, function (index, record) {
                var id = decodeURIComponent(record.id);
                var name = decodeURIComponent(record.name);
                $("#brandid").append($("<option></option>")
                    .attr("value",id)
                    .text(name)); 
                $("#editbrandid").append($("<option></option>")
                    .attr("value",id)
                    .text(name));     
            });
		}   
    }); 

//get all location 
$.ajax({
        type: "GET",
		url: "{{ url('listlocation')}}",
		dataType: "JSON",
		success: function(html) {
            var objs = html.message;
            jQuery.each(objs, function (index, record) {
                var id = decodeURIComponent(record.id);
                var name = decodeURIComponent(record.name);
                $("#locationid").append($("<option></option>")
                    .attr("value",id)
                    .text(name)); 
                $("#retiral_locationid").append($("<option></option>")
                    .attr("value",id)
                    .text(name)); 
                $("#editlocationid").append($("<option></option>")
                    .attr("value",id)
                    .text(name));     
            });
		}   
    });     

//generate product code
$.ajax({
        type: "GET",
		url: "{{ url('asset/generateproductcode')}}",
		dataType: "JSON",
		success: function(html) {
            var objs = html.message;
            $("#barcode").val(html.message);
		}   
    }); 

// $("#save").on('click',((e)=>{
//    e.preventDefault();
//      console.log($("#asset_domain").val())
//      console.log($("#cpu_model").val())
//      console.log($("#cpu_configuration").val())
//      console.log($("#cpu_si").val())
//      console.log($("#ram").val())
//      console.log($("#hdd").val())
//      console.log($("#mouse").val())
//      console.log($("#os").val())

// }))


//add data
$("#formadd").validate({
    rules: {
      warranty: {
        required: true,
        digits: true,
        maxlength:2
      },
      name: {
        required: false
      
      },
      cost: {
        required: false,
        digits: true,
      
      }
    },
    submitHandler: function(form) {
        var form = new FormData();
        var type                = $("#type").val();
        var a_c_id                = $("#a_c_id").val();
        var a_type_id                = $("#a_type_id").val();
        var name                = $("#name").val();
        var allocate_check      = $("#allocate_check").val();
        var spoc_emp_id                = $("#spoc_employeeid").val();
        var emp_id                = $("#employeeid").val();
        var locationid          = $("#locationid").val();
		var brandid             = $("#brandid").val();
		var assetid            = $("#assetid").val();
        var barcode              = $("#barcode").val();
        var cost_center              = $("#cost_center").val();
        var quantity            = $("#quantity").val();
        var date        = $("#date").val();
        var cost                = $("#cost").val();
        var warranty            = $("#warranty").val();
        var status              = $("#status").val();
        var description         = $("#description").val();
        var ip_address         = $("#ip_address").val();

		var picture             = $('#picture')[0].files[0];
		if($("#asset_type_hidden_field").val()=="2")
        {
            form.append('showable_type',2)
            form.append('asset_domain',$("#asset_domain").val())
            form.append('cpu_model',$("#cpu_model").val())
            form.append('cpu_configuration',$("#cpu_configuration").val())
            form.append('cpu_si',$("#cpu_si").val())
            form.append('ram',$("#ram").val())
            form.append('hdd',$("#hdd").val())
            form.append('mouse',$("#mouse").val())
            if($("#allocate_check").val()=="Yes")
            {
                if($("#asset_charger").is(":checked")){
                form.append('charger',1);
                }
                else{
                form.append('charger',0);                 
                }
                if($("#asset_bag").is(":checked")){
                form.append('bag',1);
                }
                else{
                form.append('bag',0);                 
                }
            }
            else{
                form.append('charger',0); 
                form.append('bag',0);                 
            }

            form.append('os',$("#os").val())
            form.append('keyboard',$("#keyboard").val())
          
        }
        else if($("#asset_type_hidden_field").val()=="3")
        {
            form.append('showable_type',3)
            form.append('asset_domain',$("#asset_domain").val())
            form.append('cpu_model',$("#cpu_model").val())
            form.append('cpu_configuration',$("#cpu_configuration").val())
            form.append('cpu_si',$("#cpu_si").val())
            form.append('ram',$("#ram").val())
            form.append('hdd',$("#hdd").val())
            form.append('mouse',$("#mouse").val())
            form.append('os',$("#os").val())
            form.append('keyboard',$("#keyboard").val())
            form.append('mon_size',$("#mon_size").val())
            form.append('mon_serial',$("#mon_serial").val()) 
            
        }
        else if($("#asset_type_hidden_field").val()=="4")
        {
            form.append('showable_type',4)
            form.append('cam_pix',$("#cam_pix").val());
            form.append('cam_model',$("#cam_model").val());
            form.append('cam_serial_no',$("#cam_serial_no").val());
        }
        else if($("#asset_type_hidden_field").val()=="5")
        {
            form.append('showable_type',5)
            form.append('sof_ver',$("#sof_ver").val());
            form.append('sof_qty',$("#sof_qty").val());
            form.append('sof_user_list',$("#sof_user_list").val());
            form.append('sof_vendor',$("#sof_vendor").val());
            form.append('sof_license_key',$("#sof_license_key").val());
            form.append('sof_expiry_date',$("#sof_expiry_date").val());
        }
        else
        {
            form.append('showable_type',1)              
        }
        form.append('type', type);
        form.append('a_c_id', a_c_id);
        form.append('a_type_id', a_type_id);
        form.append('name', name);
        form.append('allocate_check', allocate_check);
        form.append('emp_id', emp_id);
        form.append('spoc_emp_id', spoc_emp_id);
        form.append('locationid', locationid);
		form.append('brandid', brandid);
		form.append('assetid', assetid);
        form.append('barcode', barcode);
        form.append('cost_center', cost_center);
        form.append('quantity', quantity);
        form.append('date', date);
        form.append('cost', cost);
        form.append('warranty', warranty);
        form.append('status', status);
        form.append('description', description);
        form.append('picture', picture);
        form.append('ip_address', ip_address);
        $.ajax({
			type: "POST",
            url: "{{ url('saveasset')}}",  
            data: form,
			contentType: 'multipart/form-data',
			processData: false,
            contentType: false,
            success: function(data) {
                console.log(data)
                if(data.message=='success'){
                    $("#messagesuccess").css({'display':"block"});
                    $('#add').modal('hide');
                    window.setTimeout(function(){location.reload()},2000);
                }
                if(data.message=='exist'){
                    $(".messageexist").css({'display':"block"});
                }
            }
		});
    }
});


















//edit data
$("#formedit").validate({
    rules: {
      warranty: {
        required: true,
        digits: true,
        maxlength:2
      },
      name: {
        required: false,
       
      },
      cost: {
        required: false,
        
      }
    },
    submitHandler: function(form) {
        var form = new FormData();
        var id                  = $("#editid").val();
        var type                  = $("#edit_type").val();
        var category_id           = $("#edit_a_c_id").val();
        var category_type_id      = $("#edit_a_type_id").val();
        var name                = $("#editname").val();
        var assetid                = $("#editassetid").val();
        var barcode                = $("#edit_barcode").val();
        var cost_center                = $("#edit_cost_center").val();
        var locationid            = $("#editlocationid").val();
		var brandid             = $("#editbrandid").val();
        var cost                = $("#editcost").val();
        var date        = $("#editdate").val();
        var spoc_employeeid                = $("#edit_spoc_employeeid").val();
        var allocate_check                = $("#edit_allocate_check").val();
        var employeeid                = $("#edit_employeeid").val();
        var description         = $("#editdescription").val(); 
		var picture             = $('#editpicture')[0].files[0];

        if($("#editasset_type_hidden_field").val()=="2")
        {          
            form.append('showable_type',2)
            form.append('asset_domain',$("#editasset_domain").val())
            form.append('cpu_model',$("#edit_cpu_model").val())
            form.append('cpu_configuration',$("#edit_cpu_configuration").val())
            form.append('cpu_si',$("#edit_cpu_si").val())
            form.append('ram',$("#edit_ram").val())
            form.append('hdd',$("#edit_hdd").val())
            form.append('Keyboard',$(".verification_key").val())
            form.append('mouse',$("#edit_mouse").val())
            form.append('os',$("#edit_os").val())
            if($("#editasset_charger").is(":checked")){
            form.append('charger',1);
            }
            else{
            form.append('charger',0);                 
            }
            if($("#editasset_bag").is(":checked")){
            form.append('bag',1);
            }
            else{
            form.append('bag',0);                 
            }
        }
        else if($("#editasset_type_hidden_field").val()=="3")
        {          
            form.append('showable_type',3)
            form.append('asset_domain',$("#editasset_domain").val())
            form.append('cpu_model',$("#edit_cpu_model").val())
            form.append('cpu_configuration',$("#edit_cpu_configuration").val())
            form.append('cpu_si',$("#edit_cpu_si").val())
            form.append('ram',$("#edit_ram").val())
            form.append('hdd',$("#edit_hdd").val())
            form.append('Keyboard',$(".verification_key").val())
            form.append('mouse',$("#edit_mouse").val())
            form.append('os',$("#edit_os").val())

            form.append('mon_size',$("#edit_mon_size").val())
            form.append('mon_serial',$("#edit_mon_serial").val())
        }
        else if($("#editasset_type_hidden_field").val()=="4")
        {          
            form.append('showable_type',4)
            form.append('cam_pix',$("#edit_cam_pix").val());
            form.append('cam_model',$("#edit_cam_model").val());
            form.append('cam_serial_no',$("#edit_cam_serial_no").val());
            form.append('ip_address',$("#edit_ip_address").val());
        }
        else if($("#asset_type_hidden_field").val()=="5")
        {
            form.append('showable_type',5)
            form.append('sof_ver',$("#edit_sof_ver").val());
            form.append('sof_qty',$("#edit_sof_qty").val());
            form.append('sof_user_list',$("#edit_sof_user_list").val());
            form.append('sof_vendor',$("#edit_sof_vendor").val());
            form.append('sof_license_key',$("#edit_sof_license_key").val());
            form.append('sof_expiry_date',$("#edit_sof_expiry_date").val());
        }

        else
        {
            
            form.append('showable_type',1)              
        }
        form.append('id', id);
        form.append('type', type);
        form.append('category_id', category_id);
        form.append('category_type_id', category_type_id);
		form.append('name', name);
		form.append('assetid', assetid);
		form.append('barcode', barcode);
		form.append('cost_center', cost_center);
		form.append('locationid', locationid);
        form.append('brandid', brandid);
        form.append('cost', cost);
        form.append('date', date);
        form.append('spoc_employeeid', spoc_employeeid);
        form.append('allocate_check', allocate_check);
        form.append('employeeid', employeeid);
        form.append('description', description);
        form.append('picture', picture);
        $.ajax({
			type: "POST",
            url: "{{ url('updateasset')}}",
            data: form,
			contentType: 'multipart/form-data',
			processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
                if(data.message=='success'){
                    $("#messageupdate").css({'display':"block"});
                    $('#edit').modal('hide');
                    window.setTimeout(function(){location.reload()},2000);
                }
                if(data.message=='exist'){
                    $(".messageexist").css({'display':"block"});
                }

            }
		});
    }
});

//delete data
$("#formdelete").validate({
    submitHandler: function(form) {
        $.ajax({
			method: "POST",
            url: "{{ url('deleteasset')}}",
            data: $("#formdelete").serialize(),
            dataType: "JSON",
            success: function(data) {
                console.log(data);
				$("#messagedelete").css({'display':"block"});
				$('#delete').modal('hide');
				window.setTimeout(function(){location.reload()},2000)
            }
		});
    }
});

// retiral
$("#formretiral").validate({
    submitHandler: function(form) {
        $.ajax({
			method: "POST",
            url: "{{ url('retiralasset')}}",
            data: $("#formretiral").serialize(),
            dataType: "JSON",
            success: function(data) {
                console.log(data);
				$("#messageretiral").css({'display':"block"});
				$('#retiral').modal('hide');
				window.setTimeout(function(){location.reload()},2000)
            }
		});
    }
});
//show edit data
$('#edit').on('show.bs.modal', function(e) {

    $(".showable_div_id_2").hide();
    $(".desktop_div_edit").hide();
    $(".edit_camera_div").hide();
    $(".edit_software_div").hide();

    var $modal = $(this),
    id = $(e.relatedTarget).attr('customdata');
	$.ajax({
		type: "POST",
		url: "{{ url('assetbyid')}}",
		data: {id:id},
		dataType: "JSON",
		success: function(data) { 
			$("#editid").val(id);
            $("#editasset_type_hidden_field").val(data.category_type_field_id)
			$("#edit_type").html(data.type_div);
			$("#edit_a_c_id").html(data.category_div);
			$("#edit_a_type_id").html(data.category_type_div);
			$("#editlocationid").html(data.location_div);
			$("#editbrandid").html(data.brand_div);
			$("#edit_spoc_employeeid").html(data.spoc_emp_div);
			$("#edit_allocate_check").html(data.allo_check_div);
			$("#edit_employeeid").html(data.emp_div);           
            $("#edit_barcode").val(data.message.barcode);
            $("#edit_cost_center").val(data.message.cost_center);
            $("#editname").val(data.message.assetname);
            $("#editassetid").val(data.message.assetid);
            $("#editdate").val(data.message.date);
            $("#editcost").val(data.message.cost);
            $("#editdescription").val(data.message.assetdescription);

            $("#edit_cam_pix").val(data.message.cam_pix);
            $("#edit_cam_model").val(data.message.cam_model);
            $("#edit_cam_serial_no").val(data.message.cam_serial_no);
            $("#edit_ip_address").val(data.message.ip_address);


            if((data.category_type_field_id==2))
            {
                  $(".showable_div_id_2").show();
                  $('.lap_asset1').show();
                  $("#editasset_domain").val(data.message.Asset_Domain)
                  $("#edit_cpu_model").val(data.message.CPU_Model)
                  $("#edit_cpu_configuration").val(data.message.CPU_Configuration)
                  $("#edit_cpu_si").val(data.message.CPU_Sl)
                  $("#edit_ram").val(data.message.RAM)
                  $("#edit_hdd").val(data.message.HDD)
                  $("#edit_Keyboard").val(data.message.Keyboard)
                  $("#edit_mouse").val(data.message.MOUSE)
                  $("#edit_os").val(data.message.OS)
                 if($("#edit_allocate_check").val()=="Yes")  
                  {
                  if(data.message.charger==1)
                  {
                  $("#editasset_charger").prop('checked',true);
                  }
                  else{
                  $("#editasset_charger").prop('checked',false);
                  }
                  if(data.message.bag==1)
                  {
                  $("#editasset_bag").prop('checked',true);
                  }
                  else{
                  $("#editasset_bag").prop('checked',false);

                  }
            
                  }
                  else{
                          $(".lap_asset1").hide()
                  }
            }
            else if((data.category_type_field_id==3))
            {
                  $(".showable_div_id_2").show();
                  $(".desktop_div_edit").show();
                  
                  $('.lap_asset1').hide();
                  $("#editasset_domain").val(data.message.Asset_Domain)
                  $("#edit_cpu_model").val(data.message.CPU_Model)
                  $("#edit_cpu_configuration").val(data.message.CPU_Configuration)
                  $("#edit_cpu_si").val(data.message.CPU_Sl)
                  $("#edit_ram").val(data.message.RAM)
                  $("#edit_hdd").val(data.message.HDD)
                  $("#edit_Keyboard").val(data.message.Keyboard)
                  $("#edit_mouse").val(data.message.MOUSE)
                  $("#edit_os").val(data.message.OS)

                  $("#edit_mon_size").val(data.message.mon_size)
                  $("#edit_mon_serial").val(data.message.mon_serial)
            }
            else if((data.category_type_field_id==4))
            {
                $(".edit_camera_div").show(); 
            }
            else if((data.category_type_field_id==5))
            {
                $("#edit_sof_ver").val(data.message.sof_ver);
                $("#edit_sof_qty").val(data.message.sof_qty);
                $("#edit_sof_user_list").val(data.message.sof_user_list);
                $("#edit_sof_vendor").val(data.message.sof_vendor);
                $("#edit_sof_license_key").val(data.message.sof_license_key);
                $("#edit_sof_expiry_date").val(data.message.sof_expiry_date);

                $(".edit_software_div").show();
                $(".edit_ip_div").hide();
            }
            else{
                $(".showable_div_id_2").hide();
            }
		}   
	});
});


//checkout
$("#formcheckout").validate({
    submitHandler: function(form) {
        $.ajax({
			method: "POST",
            url: "{{ url('savecheckout')}}",
            data: $("#formcheckout").serialize()+"&id=" + $("#hidden_disallocate_id").val(),
            dataType: "JSON",
            success: function(data) {
                console.log(data);
				$("#checkoutsuccess").css({'display':"block"});
				$('#checkout').modal('hide');
				window.setTimeout(function(){location.reload()},2000)
            }
		});
    }
});


//checkin
$("#formcheckin").validate({
    submitHandler: function(form) {
        $.ajax({
            method: "POST",
            url: "{{ url('savecheckin')}}",
            data: $("#formcheckin").serialize()+"&id=" + $("#hidden_asset_id").val(),
            dataType: "JSON",
            success: function(data) {
                console.log(data);
                $("#checkinsuccess").css({'display':"block"});
                $('#checkin').modal('hide');
                window.setTimeout(function(){location.reload()},2000)
            }
        });
    }
});

//show checkout
$('#checkout').on('show.bs.modal', function(e) {
    var $modal = $(this),
    id = $(e.relatedTarget).attr('customdata');
	$.ajax({
		type: "POST",
		url: "{{ url('assetbyid')}}",
		data: {id:id},
		dataType: "JSON",
		success: function(data) {
			$("#assetid").val(id); 
            $("#hidden_disallocate_id").val(data.message.field_id)
            if(data.message.field_id==2)
             {
                $(".disallocate_lap_asset").show();
                if(data.message.charger==1)
                {
                     $("#disallocate_charger").prop('checked',true);
                }
                else{
                    $("#disallocate_charger").prop('checked',false);

                }
                if(data.message.bag==1)
                {
                     $("#disallocate_bag").prop('checked',true);
                }
                else{
                    $("#disallocate_bag").prop('checked',false);

                }
             }
             else{
                  $('.disallocate_lap_asset').hide();
             }
            $("#checkoutname").val(data.message.name);
            $("#checkoutassetid").val(data.message.assetid);
		}   
	});
});

//show checkin
$('#checkin').on('show.bs.modal', function(e) {
    var $modal = $(this),
    id = $(e.relatedTarget).attr('customdata');
    $.ajax({
        type: "POST",
        url: "{{ url('assetbyid')}}",
        data: {id:id},
        dataType: "JSON",
        success: function(data) {
             $("#hidden_asset_id").val(data.message.field_id)
             if(data.message.field_id==2)
             {
                $(".allocate_lap_asset").show();
                if(data.message.charger==1)
                {
                     $("#allocate_charger").prop('checked',true);
                }
                else{
                    $("#allocate_charger").prop('checked',false);

                }
                if(data.message.bag==1)
                {
                     $("#allocate_bag").prop('checked',true);
                }
                else{
                    $("#allocate_bag").prop('checked',false);

                }
             }
             else{
                  $('.allocate_lap_asset').hide();
             }
            $("#checkinname").val(data.message.name);
            $("#checkinassetid").val(data.message.assetid);
        }   
    });
});

//show delete data

$('#retiral').on('show.bs.modal', function(e) {
    var $modal = $(this),
    id = $(e.relatedTarget).attr('customdata');
    $("#idretiral").val(id);
});
$('#delete').on('show.bs.modal', function(e) {
    var $modal = $(this),
    id = $(e.relatedTarget).attr('customdata');
    $("#iddelete").val(id);
});
})(jQuery);
// function Edit_assets(one){
//      $("#edit").modal('show');
//      $.ajax({
//          url:"{{url('get_asset_info')}}",
//          type:"POST",
//          data:{id:one},
//          beforeSend:function(data){
//               console.log("Loading!...");
//          },
//          success:function(data)
//          {
//               console.log(data)
//          }   
//      })

// }

$(()=>{
     $("#allocate_check").change(()=>{
            if($("#allocate_check").val()=="Yes" && $("#a_type_id").find(":selected").text()=="Laptop"){
                  $(".lap_asset").show();
            }
            else{
                $(".lap_asset").hide();
            }
     }) 
})





</script>

<script>
    function openCity(cityName) {
    var i;
    var x = document.getElementsByClassName("city");

    $("#active_tab").val(cityName);
    if(cityName=="Stock"){
        $("#tab_title").html("Stock Asset List");
    }
    if(cityName=="Allocated"){
        $("#tab_title").html("Allocated Asset List");
    }
    if(cityName=="Retiral"){
        $("#tab_title").html("Retiral Asset List");
    }

    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";  
    }
    document.getElementById(cityName).style.display = "block";  

    // trigger load data
    $("#form")[0].reset();
    // end trigger load data
    }
</script>


<!-- download barcode -->
<script>

var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};


function download_row_qr(code){

    Popup($("#qr_div_img"+code).html(),$("#qr_div_name"+code).html(),$("#qr_div_code"+code).html(),$("#qr_div"+code).html());
    
}

    // Global variable
    var getCanvas=""; 

function download_row_qr_img(code){

        // Popup($("#qr_div_img"+code).html(),$("#qr_div_name"+code).html(),$("#qr_div_code"+code).html());
        $("#download_img_name").val(code);
        var element = $("#html-content-holder"); 
        
        html2canvas($("#qr_div"+code)[0]).then((canvas) => {
            console.log("done ... ");
            $("#qr_div_output").html(canvas);
            getCanvas = canvas;

            var imgageData = getCanvas.toDataURL("image/png");
                                                                                                
            // Now browser starts downloading 
            // it instead of just showing it
            var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                                                                                                
            var canvas_name=$("#download_img_name").val();

            $("#btn_download").attr("download", canvas_name+".png").attr("href", newData);

        });
        var explode = function(){
            jQuery('#btn_download')[0].click();
        };
        setTimeout(explode, 2000);

}

$("#download_all_btn").click(function(){

    $.ajax({  
        type: "POST",
        url: "{{ url('download_all_qr_get')}}", 
        data: {},
        dataType: "JSON",

        success: function (data) {

            var mywindow = window.open('', 'PRINT', 'height=400,width=600');
            
            mywindow.document.write('<html><head><title></title>');
            mywindow.document.write('</head><body >');

            mywindow.document.write('<link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.css" media="print"');

            var a=0; 
            mywindow.document.write('<img src="http://hub1.cavinkare.in/Asset_Management_HEPL/public/index.php/../upload/cropped-Hema-logo-1.png" style="width:100%;">');
                
           
            mywindow.document.write('</body></html>');
            
            mywindow.print();
            mywindow.close();

            return true;
            
        }
    })

})


// function PrintElem(elem)
// {
//     Popup($(elem).html());
// }

function Popup(img,name,code,full_div)
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');
    mywindow.document.write('<html><head><title></title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<div style="width:100px; position: absolute;margin:15px 10px 10px 10px;">');
    mywindow.document.write(img);
    mywindow.document.write('</div></div>');
    mywindow.document.write('<div class="" style="padding-left:115px;text-align: left;width:300px; position: absolute;">');
    mywindow.document.write('<p style="">');
    mywindow.document.write(name);
    mywindow.document.write('</p>');
    mywindow.document.write('<p style="margin-top: -10px;">');
    mywindow.document.write(code);
    mywindow.document.write('</p>');
    mywindow.document.write('</div>');
    mywindow.document.write('</div>');
    mywindow.document.write('</div>');
    // mywindow.document.write(full_div);

    mywindow.document.write('</body></html>');

    mywindow.print();
    mywindow.close();

    return true;
}


$("#download_all_btn").click(function(){

    doc.fromHTML($('#qr_div_H-FF-PBC-00001').html(), 10, 10, {
    'width': 50, // max width of content on PDF
    'elementHandlers': specialElementHandlers
},
function(bla){

var blob = doc.output('blob');

            var formData = new FormData();
            formData.append('pdf', blob);

            $.ajax(
            {
                method: 'POST',
                url: "{{ url('qr_upload')}}", 
                data: formData,
                processData: false,
                contentType: false,
                success: function(data){console.log(data)},
                error: function(data){console.log(data)}
            });

        });

})


</script>
<!-- end download barcode -->

@endsection