@extends('main')
@section('content')
 @if(auth()->user()->role!="itinfra_audit")
<style>

    @media (min-width: 576px)
{
    .modal-dialog {
    max-width: 1000px;
    margin: 1.75rem auto;
}

}
</style>
@endif
<section class="">
    <div class="content p-4">
        <div class="row pt-3">
            <div class="col-md-6">
                <h3 class="">Verified Employees</h3>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body ">
                    <div id="messagesuccess"  class="display-none alert alert-success"><?php echo trans('lang.data_added');?></div>
					<div id="messagedelete" class="display-none alert alert-success"><?php echo trans('lang.data_deleted');?></div>
					<div id="messageupdate"  class="display-none alert alert-success"><?php echo trans('lang.data_updated');?></div>
                        <div class="table-responsive">
                        @if(auth()->user()->role!="itinfra_audit")
                            <table id="data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Emp ID</th>
                                        <th><?php echo trans('lang.fullname');?></th>
                                        <th>Mobile</th>
                                        <th><?php echo trans('lang.email');?></th>
                                        <th>Band</th>
                                        <th>Grade</th>
                                        <th>Role</th>
                                        <th><?php echo trans('lang.city');?></th>
                                        <th><?php echo trans('lang.action');?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Emp ID</th>
                                        <th><?php echo trans('lang.fullname');?></th>
                                        <th>Mobile</th>
                                        <th><?php echo trans('lang.email');?></th>
                                        <th>Band</th>
                                        <th>Grade</th>
                                        <th>Role</th>
                                        <th><?php echo trans('lang.city');?></th>
                                        <th><?php echo trans('lang.action');?></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                            @endif
                            @if(auth()->user()->role=="itinfra_audit")

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <form action="" method="POST" id="form">
                                <div class="">
                                        <div class="form-group">
                                            <!-- <label><?php echo trans('lang.assettype');?></label> -->
                                            <select class="form-control" id="created_by" name="created_by">
                                <option value="0">View All</option>
                                    @foreach($users as $row)
                                        <option value="{{$row->user_id}}">{{$row->fullname}}</option>
                                    @endforeach
                                </select>
                                        </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4"></div>
                    </div>


                           
                            <table id="data" class="table table-striped table-bordered " cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Emp ID</th>
                                         <th>Name</th>
                                         <th>Have Asset</th>
                                        <th>Band</th>
                                        <th>Grade</th>
                                        <th>Division</th>
                                        <th>Role</th>
                                        <th>Work From Home</th>
                                        <th>Email</th>
                                        <th>City</th>
                                        <th>Office City</th>
                                        <th>Mobile</th>
                                        <th>Office</th>
                                        <th>Asset ID</th>
                                        <th>Category</th>
                                        <th>Asset Type</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Serial No</th>
                                        <th>Remark</th>
                                        <th>Spec Ram</th>
                                        <th>Storage</th>
                                        <th>Dongle</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Action</th>
                                       <th>Emp ID</th>
                                        <th>Name</th>
                                        <th>Have Asset</th>
                                        <th>Band</th>
                                        <th>Grade</th>
                                        <th>Division</th>
                                        <th>Role</th>
                                        <th>Work From Home</th>
                                        <th>Email</th>
                                        <th>City</th>
                                        <th>Office City</th>
                                        <th>Mobile</th>
                                        <th>Office</th>
                                        <th>Asset ID</th>
                                        <th>Category</th>
                                        <th>Asset Type</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Serial No</th>
                                        <th>Remark</th>
                                        <th>Spec Ram</th>
                                        <th>Storage</th>
                                        <th>Dongle</th>
                                        <th>Created By</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--edit new data -->
    <div id="edit" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <div class="modal-content col-md-12">
                <div class="modal-header">

                    <h5 class="modal-title">Employee Verification &nbsp;(<span id="editfullname"></span> - <span id="editemp_id"></span>)</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="verify_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Asset Type</th>
                                    <th>Asset Brand</th>
                                    <th>Asset Model</th>
                                    <th>More Details</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            
                            
                        </table>
                    </div>
                </div>
                <form action="#" id="formedit" enctype="multipart/form-data">

                    <div class="modal-body">
                    <div class="row">
                        <div  class="display-none messageexist alert alert-success"><?php echo trans('lang.data_exist');?></div>
                            <div id="assetchecked" class="form-group col-md-12">
                            <span id="req_field" class="text-danger mb-2"></span>
                                <div class="row">
                                <input name="emp_id" type="hidden" id="edit_emp_id" class=" form-control" />
                                <input name="emp_id1" type="hidden" id="emp_id1" class=" form-control" />

                                <div class="form-group col-md-6">
                                    <label>Category</label>
                                    <select name="category" id="edit_category" class="form-control">
                                        <option value="">Choose Category</option>
                                        <option value="Corporate">Corporate</option>
                                        <option value="BYOD">BYOD</option>
                                        <option value="Rental">Rental</option>
                                    </select>
                                    <span class="text-danger mt-2" id="category_" ></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Asset Type</label>
                                    <select name="asset_type" id="edit_asset_type" class="form-control">
                                        <option value="">Choose Asset Type</option>
                                        <option value="Laptop">Laptop</option>
                                        <option value="Desktop">Desktop</option>
                                        <option value="Tab">Tab</option>
                                        <option value="Phone">Phone</option>
                                    </select>
                                    <span class="text-danger mt-2" id="asset_" ></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Brand</label>
                                    <select name="brand" id="edit_brand" class="form-control">
                                        <option value="">Choose Brand</option>
                                        <option value="HP">HP</option>
                                        <option value="Dell">Dell</option>
                                        <option value="Lenovo">Lenovo</option>
                                        <option value="Asus">Asus</option>
                                        <option value="Apple">Apple</option>
                                        <option value="Azex">Azex</option>
                                        <option value="Microsoft">Microsoft</option>
                                        <option value="Others">Others</option>
                                        <option value="Android Phone">Android Phone</option>
                                        <option value="i-Phone">i-Phone</option>
                                        <option value="Tab">Tab</option>
                                    </select>
                                    <span class="text-danger mt-2" id="brand_" ></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Model</label>
                                    <input name="model" type="text" id="editmodel" class=" form-control" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Serial No.</label>
                                    <input name="serial_no" type="text" id="editserial_no" class=" form-control" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Asset ID</label>(OPT)
                                    <input name="asset_id" type="text" id="editasset_id" class=" form-control" />
                                </div>
                               
                               <div class="form-group col-md-6">
                                    <label>Storage</label>
                                    <select name="storage" id="edit_storage" class="form-control">
                                        <option value="">Choose Storage</option>
                                        <option value="128">128</option>
                                        <option value="256">256</option>
                                        <option value="512">512</option>
                                        <option value="500">500</option>
                                        <option value="1TB">1TB</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Spec RAM</label>
                                    <select name="spec_ram" id="edit_spec_ram" class="form-control">
                                        <option value="">Choose Spec RAM</option>
                                        <option value="2">2</option>
                                        <option value="4">4</option>
                                        <option value="8">8</option>
                                        <option value="16">16</option>
                                        <option value="32">32</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Dongle</label>
                                    <select name="dongle" id="edit_dongle" class="form-control">
                                        <option value="">Choose Dongle</option>
                                        <option value="No">No</option>
                                        <option value="Airtel">Airtel</option>
                                        <option value="Vodafone">Vodafone</option>
                                        <option value="Jio">Jio</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <label>Remarks</label>
                                <textarea name="remark" required type="text" id="editremark" class=" form-control"></textarea>
                                <span class="text-danger mt-2" id="remarkk" ></span>
                            </div>
                        </div>
                        <br>
                       

                    </div>
                    <div class="modal-footer">
                        <b id="form_resp"></b>
                        <input type="hidden" name="id" id="editid"/>

                        <input type="hidden" name="itinfra" value="{{auth()->user()->role}}" id="itinfra"/>
                        <input type="hidden" name="asset_edit_id" id="asset_edit_id"/>
                        <button type="button" hidden="true" class="btn btn-primary" id="asset_update">Update</button>
                        <button type="button" class="btn btn-primary" id="save_Addmore">Save and Add More</button>
                        <button type="button" class="btn btn-success"  id="saveedit">Save</button>
                        <button type="button" id="close" class="btn btn-default" data-dismiss="modal"><?php echo trans('lang.close');?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end edit data-->

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
{{-- Returned Status Modal --}}


<!-- Modal -->
<div class="modal fade" id="returned_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Return Asset</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row" id="hide_span_div">
        <div class="col-md-6">
            <span class="font-weight-bold">Employee ID : </span><span id="emp_id"></span>
        </div>
        <div class="col-md-6">
            <span class="font-weight-bold">Employee Name : </span><span id="emp_name"></span>
        </div>
        <div class="col-md-6">
            <span class="font-weight-bold">Role : </span><span id="role"></span>
        </div>
         <div class="col-md-6">
            <span class="font-weight-bold">Band : </span><span id="band"></span>
        </div>
         <div class="col-md-6">
            <span class="font-weight-bold">Grade : </span><span id="grade"></span>
        </div>
         <div class="col-md-6">
            <span class="font-weight-bold">Division : </span><span id="division"></span>
        </div>
         <div class="col-md-6">
            <span class="font-weight-bold">Work Fron Home : </span><span id="wfh"></span>
        </div>
         <div class="col-md-6">
            <span class="font-weight-bold">Email : </span><span id="email"></span><br>
        </div>
         <div class="col-md-6">
            <span class="font-weight-bold">Mobile : </span><span id="mobile"></span>
        </div>
          <div class="col-md-6">
            <span class="font-weight-bold">City : </span><span id="city"></span>
        </div>
          <div class="col-md-6">
            <span class="font-weight-bold">Office City : </span><span id="office_city"></span>
        </div>
         <div class="col-md-6">
            <span class="font-weight-bold">Asset ID : </span><span id="asset_id"></span><br>
        </div>
         <div class="col-md-6">
            <span class="font-weight-bold">Category : </span><span id="category"></span><br>
        </div>
         <div class="col-md-6">
            <span class="font-weight-bold">Serial No : </span><span id="s_no"></span>
        </div>
         <div class="col-md-6">
            <span class="font-weight-bold">Asset Type : </span><span id="asset_type"></span><br>
        </div>
         <div class="col-md-6">
            <span class="font-weight-bold">Brand : </span><span id="brand"></span>
        </div>
        <div class="col-md-6">
            <span class="font-weight-bold">Model : </span><span id="model"></span><br>
        </div>
         <div class="col-md-6">
            <span class="font-weight-bold">Spec RAM : </span><span id="spec_ram"></span><br>
        </div>
         <div class="col-md-6">
            <span class="font-weight-bold">Storage : </span><span id="storage"></span><br>
        </div>
        <div class="col-md-6">
            <span class="font-weight-bold">Dongle : </span><span id="dongle"></span><br>
        </div>
      </div>
       <form action="javascript:void(0)" id="total_asset_update">
        <input type="hidden" name="update_id" id="update_id">
       <div class="row" id="hide_input_div" hidden="true">
            <div class="col-md-6 mt-2">
                <span class="font-weight-bold">Employee ID : </span><span  id="emp_id12"></span>
            </div>
            <div class="col-md-6 mt-2">
                <span class="font-weight-bold">Employee Name : </span><span id="emp_name1"></span>
            </div>
            <div class="col-md-6 mt-2">
                <span class="font-weight-bold">Role : </span><span id="role1"></span>
            </div>
            <div class="col-md-6 mt-2">
                <span class="font-weight-bold">Email : </span><span id="email1"></span><br>
            </div>
            <div class="col-md-6 mt-1">
                <span class="font-weight-bold">Asset ID : </span><input type="text" class="form-control" name="asset_id1" id="asset_id1"><br>
            </div>
            <div class="col-md-6 mt-1">
                <span class="font-weight-bold">Category : </span><select name="category1" class="form-control" id="category1">
                    <option value="">Choose Category</option>
                    <option value="Corporate">Corporate</option>
                    <option value="BYOD">BYOD</option>
                    <option value="Rental">Rental</option>
                </select><br>
            </div>
            <div class="col-md-6 ">
                <span class="font-weight-bold">Serial No : </span><input class="form-control" type="text" name="s_no1" id="s_no1">
            </div>
            <div class="col-md-6 ">
                <span class="font-weight-bold">Asset Type : </span><select class="form-control" name="asset_type1" id="asset_type1">
                    <option value="">Choose Asset Type</option>
                    <option value="Laptop">Laptop</option>
                    <option value="Desktop">Desktop</option>
                    <option value="Tab">Tab</option>
                    <option value="Phone">Phone</option>
                </select><br>
            </div>
            <div class="col-md-6 ">
                <span class="font-weight-bold">Brand : </span><select class="form-control" name="brand1" id="brand1">
                    <option value="">Choose Brand</option>
                    <option value="HP">HP</option>
                    <option value="Dell">Dell</option>
                    <option value="Lenovo">Lenovo</option>
                    <option value="Asus">Asus</option>
                    <option value="Apple">Apple</option>
                    <option value="Azex">Azex</option>
                    <option value="Microsoft">Microsoft</option>
                    <option value="Others">Others</option>
                    <option value="Android Phone">Android Phone</option>
                    <option value="i-Phone">i-Phone</option>
                    <option value="Tab">Tab</option>
                </select>
            </div>
            <div class="col-md-6 ">
                <span class="font-weight-bold">Model : </span><input class="form-control" type="text"  name="model1" id="model1"><br>
            </div>
            <div class="col-md-6 ">
                <span class="font-weight-bold">Spec RAM : </span><select class="form-control" name="spec_ram1" id="spec_ram1">
                    <option value="">Choose Spec RAM</option>
                    <option value="2">2</option>
                    <option value="4">4</option>
                    <option value="8">8</option>
                    <option value="16">16</option>
                    <option value="32">32</option>
                </select><br>
            </div>
            <div class="col-md-6 ">
                <span class="font-weight-bold">Storage : </span><select class="form-control" name="storage1" id="storage1">
                    <option value="">Choose Storage</option>
                    <option value="128">128</option>
                    <option value="256">256</option>
                    <option value="512">512</option>
                    <option value="500">500</option>
                    <option value="1TB">1TB</option>
                </select><br>
            </div>
            <div class="col-md-6 ">
                <span class="font-weight-bold">Dongle : </span><select class="form-control" name="dongle1" id="dongle1">
                    <option value="">Choose Dongle</option>
                    <option value="No">No</option>
                    <option value="Airtel">Airtel</option>
                    <option value="Vodafone">Vodafone</option>
                    <option value="Jio">Jio</option>
                </select><br>
            </div>
      </div>

      <input type="hidden" id="emp_id3" name="emp_id3">
      <input type="hidden" id="fullname3" name="fullname3">
      <input type="hidden" id="email3" name="email3">
      <input type="hidden" id="mobile3" name="mobile3">
      <input type="hidden" id="role3" name="role3">
      <input type="hidden" id="band3" name="band3">
      <input type="hidden" id="grade3" name="grade3">
      <input type="hidden" id="division3" name="division3">
      <input type="hidden" id="wfh3" name="wfh3">
      <input type="hidden" id="city3" name="city3">
      <input type="hidden" id="office_city3" name="office_city3">
        </form>
        <button style="font-size:10px;padding:2px;" id="edit_total_asset" class="btn btn-sm btn-primary float-right"><i class="fa fa-edit"></i>Edit</button>
      </div>
      <div class="modal-footer">
        <button type="button" id="returned_confirm" class="btn btn-primary">Confirm</button>
        <button type="button" id="save_asset" hidden="true" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- Returned Status Modal --}}

</section>

<script>

function get_asset_details(emp_id,id,fullname,email,assetid,asset_type,category,mobile,role,brand,model,s_no,category,dongle,band,grade,division,spec_ram,storage,wfh,city,office_city){
    
     $('#hide_span_div').attr('hidden',false)
    $('#returned_confirm').attr('hidden',false)
    $('#hide_input_div').attr('hidden',true)
    $('#save_asset').attr('hidden',true)
    $('#edit_total_asset').attr('hidden',false)
    
    $("#update_id").val(id)
    $("#emp_id").html(emp_id)
    $("#emp_id3").val(emp_id)
    $("#emp_id12").html(emp_id)
    $("#emp_name").html(fullname)
    $("#fullname3").val(fullname)
    $("#emp_name1").html(fullname)
    $("#email").html(email)
    $("#email3").val(email)
    $("#email1").html(email)
    $("#mobile").html(mobile)
    $("#mobile3").val(mobile)
    $("#role").html(role)
    $("#role3").val(role)
    $("#role1").html(role)
    $("#asset_id").html(assetid)
    $("#asset_id1").val(assetid)
    $("#s_no").html(s_no)
    $("#s_no1").val(s_no)
    $("#asset_type").html(asset_type)
    $("#asset_type1").val(asset_type)
    $("#brand").html(brand)
    $("#brand1").val(brand)
    $("#model").html(model)
    $("#model1").val(model)
    $("#category").html(category)
    $("#category1").val(category)
    $("#dongle").html(dongle)
    $("#dongle1").val(dongle)
    $("#band").html(band)
    $("#band3").val(band)
    $("#grade").html(grade)
    $("#grade3").val(grade)
    $("#division").html(division)
    $("#division3").val(division)
    $("#spec_ram").html(spec_ram)
    $("#spec_ram1").val(spec_ram)
    $("#storage").html(storage)
    $("#storage1").val(storage)
    $("#wfh").html(wfh)
    $("#wfh3").val(wfh)
    $("#city").html(city)
    $("#city3").val(city)
    $("#office_city").html(office_city)
    $("#office_city3").val(office_city)
}

$(document).on('click', '#edit_total_asset', function() {
    $('#hide_span_div').attr('hidden',true)
    $('#returned_confirm').attr('hidden',true)
    $('#hide_input_div').attr('hidden',false)
    $('#save_asset').attr('hidden',false)
    $('#edit_total_asset').attr('hidden',true)
})

$(document).on('click', '#returned_confirm', function() {
    $('#returned_confirm').attr('disabled',true);
    var update_id = $("#update_id").val();
     $.ajax({
			method: "POST",
            url: "{{ url('returned_confirm')}}",
            data: {update_id:update_id,},
            dataType: "JSON",
            success: function(data) {
                $('#returned_confirm').attr('disabled',false);
                if(data.res=="success"){
                    $("#returned_status").modal('hide');
                    toastr['success']("Asset Returned Successfully")
                    window.location.reload();
                }
		    }
		});

})

$(document).on('click', '#save_asset', function() {
     $('#save_asset').attr('disabled',true);
     $.ajax({
			method: "POST",
            url: "{{ url('update_asset')}}",
            data: $("#total_asset_update").serialize(),
            dataType: "JSON",
            success: function(data) {
                $('#save_asset').attr('disabled',false)
                if(data.res=="success"){
                    var id  = data.id;
                    var assetid  = data.asset_id;
                    var s_no  = data.s_no;
                    var asset_type  = data.asset_type;
                    var category  = data.category;
                    var brand  = data.brand;
                    var model  = data.model;
                    var spec_ram  = data.spec_ram;
                    var storage  = data.storage;
                    var emp_id  = data.emp_id;
                    var fullname  = data.fullname;
                    var dongle  = data.dongle;
                    var email  = data.email;
                    var mobile  = data.mobile;
                    var role  = data.role;
                    var band  = data.band;
                    var grade  = data.grade;
                    var division  = data.division;
                    var wfh  = data.wfh;
                    var office_city  = data.office_city;
                    var city  = data.city;

                   get_asset_details(emp_id,id,fullname,email,assetid,asset_type,category,mobile,role,brand,model,s_no,category,dongle,band,grade,division,spec_ram,storage,wfh,city,office_city)
                    toastr['success']("Asset Updated Successfully")
                    $('#hide_span_div').attr('hidden',false)
                    $('#returned_confirm').attr('hidden',false)
                    $('#hide_input_div').attr('hidden',true)
                    $('#save_asset').attr('hidden',true)
                    $('#edit_total_asset').attr('hidden',false)
                }
		    }
		});
})



function fetch_verify_edit(id){
     $('#asset_update').attr('hidden',false);
     $('#save_Addmore').attr('hidden',true);
     $('#saveedit').attr('hidden',true);
     $('.edit_asset_hide').attr('hidden',true);
     $.ajax({
			method: "GET",
            url: "{{ url('get_v_edit')}}",
            data: {id:id,},
            dataType: "JSON",
            success: function(data) {
               $("#asset_edit_id").val(data.res[0].id);
               $("#emp_id1").val(data.res[0].emp_id);
               $("#edit_category").val(data.res[0].category);
               $("#edit_asset_type").val(data.res[0].asset_type);
               $("#edit_brand").val(data.res[0].a_brand);
               $("#editmodel").val(data.res[0].a_model);
               $("#editserial_no").val(data.res[0].serial_no);
               $("#editasset_id").val(data.res[0].assetid);
               $("#edit_storage").val(data.res[0].storage);
               $("#edit_spec_ram").val(data.res[0].spec_ram);
               $("#edit_dongle").val(data.res[0].dongle);
               $("#editremark").val(data.res[0].remark);
		    }
		});
}

$("#close ,.close").click(function(){
    $('#asset_update').attr('hidden',true);
    $('#save_Addmore').attr('hidden',false);
    $('#saveedit').attr('hidden',false);
    $('.edit_asset_hide').attr('hidden',false);
})

$(document).on('click', '#asset_update', function() {
    $('#asset_update').attr('disabled',true);
     $.ajax({
			method: "GET",
            url: "{{ url('update_verify_asset')}}",
            data: $("#formedit").serialize(),
            dataType: "JSON",
            success: function(data) {
                $('#asset_update').attr('disabled',false);
                if(data.res == "success"){
                    $('#formedit')[0].reset();
                    $('#asset_update').attr('hidden',true);
                    $('#save_Addmore').attr('hidden',false);
                    $('#saveedit').attr('hidden',false);
                    $('.edit_asset_hide').attr('hidden',false);
                    var id = data.emp_id;
                    $('#verify_data').DataTable().destroy();
                    asset_table(id);
                }
		    }
		});
})

$(document).on('change', '#created_by', function() {
    var id = $('#created_by').val();

     var dt= $('#data').DataTable({

         ajax: {
            'url':"{{ url('verified_employees')}}",
            'type':"GET",
            'data':{id:id},
        } ,

        processing: true,
        serverSide: true,
        bDestroy: true,
        scrollX: true,
  
        columns: [
            {data: 'returned'},
            {data: 'emp_id'},

            {data: 'fullname'},
            {data: 'have_asset'},
            {data: 'band'},
            {data: 'grade'},
            {data: 'division'},
            {data: 'role'},
            {data: 'work_from_home'},
            {data: 'email'},
            {data: 'city'},
            {data: 'office_city'},
            {data: 'mobile'},
            {data: 'office'},
            {
                data: 'assetid'
            },
            {
                data: 'category'
            },
            {
                data: 'asset_type'
            },
            {
                data: 'a_brand'
            },
            {
                data: 'a_model'
            },
            {
                data: 'serial_no'
            },

            {
                data: 'remark'
            },
            {
                data: 'spec_ram'
            },
            {
                data: 'storage'
            },
            {
                data: 'dongle'
            },
             {
                data: 'verified_by'
            },
           
        ],
        buttons: [{
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.employees_list ');?>',
                exportOptions: {
                     columns: [1, 2, 3, 4 ,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.employees_list');?>',
                exportOptions: {
                     columns: [1, 2, 3, 4 ,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.employees_list');?>',
                orientation: 'landscape',
                exportOptions: {
                     columns: [1, 2, 3, 4 ,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
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
                title: '<?php echo trans('lang.employees_list');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                     columns: [1, 2, 3, 4 ,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
                },
                action: newexportaction,

            }
        ]

        

    });

})



// $(document).on("click", "#btnedit", function(){
function asset_table(id,edit_id,fullname){
    $("#editid").val(edit_id);
    $("#editfullname").html(fullname);
    $("#editemp_id").html(id);
    $('#req_field').html('');
    $("#edit_emp_id").val(id);
        $('#verify_data').DataTable({
        processing: true,
        serverSide: true,
        bDestroy: true,
        ajax: {
            'url':"{{ url('fetch')}}",
            'type':"GET",
            'data':{id:id},
        } ,
        columns: [
        { data: 'asset_type', name: 'asset_type' },
        { data: 'a_brand', name: 'a_brand' },
        { data: 'a_model', name: 'a_model' },
        { data: 'more_detail', name: 'more_detail' },
        { data: 'remark', name: 'remark' },
        { data: 'action', name: 'action' },
        ],
        order: [[0, 'desc']],
        });

       
}


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
"use strict";
if($('#itinfra').val() == "itinfra_audit"){
  var dt=   $('#data').DataTable({

        ajax: "{{ url('verified_employees')}}",

        processing: true,
        serverSide: true,
        bDestroy: true,
         scrollX: true,
  
        columns: [
            {data: 'returned' },
            {data: 'emp_id'},
            {data: 'fullname'},
            {data: 'have_asset'},
            {data: 'band'},
            {data: 'grade'},
            {data: 'division'},
            {data: 'role'},
            {data: 'work_from_home'},
            {data: 'email'},
            {data: 'city'},
            {data: 'office_city'},
            {data: 'mobile'},
            {data: 'office'},
            {
                data: 'assetid'
            },
            {
                data: 'category'
            },
            {
                data: 'asset_type'
            },
            {
                data: 'a_brand'
            },
            {
                data: 'a_model'
            },
            {
                data: 'serial_no'
            },

            {
                data: 'remark'
            },
            {
                data: 'spec_ram'
            },
            {
                data: 'storage'
            },
            {
                data: 'dongle'
            },
            {
                data: 'verified_by'
            },
           
        ],
        buttons: [{
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.employees_list ');?>',
                exportOptions: {
                     columns: [1, 2, 3, 4 ,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.employees_list');?>',
                exportOptions: {
                     columns: [1, 2, 3, 4 ,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.employees_list');?>',
                orientation: 'landscape',
                exportOptions: {
                     columns: [1, 2, 3, 4 ,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
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
                title: '<?php echo trans('lang.employees_list');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                     columns: [1, 2, 3, 4 ,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
                },
                action: newexportaction,

            }
        ]

        

    });
}else{
   var dt= $('#data').DataTable({

        ajax: "{{ url('verified_employees')}}",
  
        columns: [{
            data: 'id',
                orderable: false,
                searchable: false,
                visible: false
            },

            {
                data: 'emp_id'
            },
            {
                data: 'fullname'
            },
            {
                data: 'mobile'
            },
            {
                data: 'email'
            },
            {
                data: 'band'
            },
            {
                data: 'grade'
            },
            {
                data: 'role'
            },

            {
                data: 'city'
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
                title: '<?php echo trans('lang.employees_list ');?>',
                exportOptions: {
                     columns: [0,1, 2, 3, 4 ,5]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.employees_list');?>',
                exportOptions: {
                     columns: [0,1, 2, 3, 4 ,5]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.employees_list');?>',
                orientation: 'landscape',
                exportOptions: {
                     columns: [0,1, 2, 3, 4 ,5]
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
                title: '<?php echo trans('lang.employees_list');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                     columns: [0,1, 2, 3, 4 ,5]
                },
                action: newexportaction,

            }
        ]

        

    });
    }

    $("#spe_role").change(function(){
        var spe_role=$("#spe_role").val();
        if(spe_role=="No"){
            $("#supervisor_div").css("display","block");
        }
        else{
            $("#supervisor_div").css("display","none");
        }
    })


    $("#business").change(function(){
        var business=$("#business").val();
        $.ajax({
			method: "GET",
            url: "{{ url('get_department')}}",
            data: {'business':business,},
            dataType: "JSON",
            success: function(html) {
                $("#department").html(html.sup_div);
                $("#supervisor").html("");
		    }
		});
    })

    $("#department").change(function(){
        var business=$("#business").val();
        var department=$("#department").val();
        $.ajax({
			method: "GET",
            url: "{{ url('get_supervisor')}}",
            data: {'business':business,'department':department,},
            dataType: "JSON",
            success: function(html) {
                $("#supervisor").html(html.sup_div);
		    }
		});
    })

//add data
$("#formedit").validate({
    submitHandler: function(form) {
    $.ajax({
        method: "POST",
        url: "{{ url('saveemployees')}}",
        data: $("#formadd").serialize(),
        dataType: "JSON",
        success: function(data) {
            if(data.message=='success'){
                $("#messagesuccess").css({'display':"block"});
                $('#add').modal('hide');
                location.reload();
            }
            if(data.message=='exist'){
                $(".messageexist").css({'display':"block"});
            }
        },
        
    });
    }
});

//edit data
$(document).on("click", "#saveedit", function(){
    $("#saveedit").attr('disabled',true);
        $.ajax({
			method: "POST",
            url: "{{ url('verified_emp_upd')}}",
            data: $("#formedit").serialize(),
            dataType: "JSON",
            success: function(data) {
                $("#saveedit").attr('disabled',false);
                if(data.message=='need_all_field'){
                    $("#form_resp").html("Need All Fields..!");
                }
                if(data.message=='success'){
                    $("#messageupdate").css({'display':"block"});
                    $('#edit').modal('hide');
                    location.reload();
                }
                if(data.message=='failed'){
                    $('#req_field').html('Please fill in at least one field.')
                }
            },
             error: function (data) {
                $("#remarkk").html((data.responseJSON.errors.remark[0]));
                $("#saveedit").attr('disabled',false);
             }
          
		});
});


$(document).on("click", "#save_Addmore", function(){
     $("#save_Addmore").attr('disabled',true);
    $.ajax({
			method: "POST",
            url: "{{ url('saveaddmore')}}",
            data: $("#formedit").serialize(),
            dataType: "JSON",
            success: function(data) {
                $("#save_Addmore").attr('disabled',false);
                if(data.sts=="success"){
                    $('#formedit')[0].reset();
                    var id = data.emp_id;
                    $('#verify_data').DataTable().destroy();
                    asset_table(id);
                }
                 if(data.message=='failed'){
                    $('#req_field').html('Please fill in at least one field.')
                }
            }
          
        })
})


//delete data
$("#formdelete").validate({
    submitHandler: function(form) {
        $.ajax({
			method: "POST",
            url: "{{ url('deleteemployees')}}",
            data: $("#formdelete").serialize(),
            dataType: "JSON",
            success: function(data) {
                console.log(data);
				$("#messagedelete").css({'display':"block"});
				$('#delete').modal('hide');
				location.reload();
            }
		});
    }
});


//show delete data


$('#delete').on('show.bs.modal', function(e) {
    var $modal = $(this),
    id = $(e.relatedTarget).attr('customdata');
    $("#iddelete").val(id);
});

})(jQuery);
</script>
@endsection
