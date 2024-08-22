@extends('main')
@section('content')
<style>
    @media (min-width: 576px)
{
    .modal-dialog {
    max-width: 1000px;
    margin: 1.75rem auto;
}

}
</style>
<section class="">
    <div class="content p-4">
        <div class="row pt-3">
            <div class="col-md-6">
                <h3 class=""><?php echo trans('lang.employees_list');?></h3>
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
                            {{-- <div class="form-group col-md-12">
                                <input type="checkbox" id="check_asset" name="check_asset" checked>
                                <p>have an Asset check</p>
                            </div> --}}
                            <div class="form-group edit_asset_hide col-md-12">
                                <p>Do you have a Corporate Asset?</p>
                                <div class="row ml-1">
                                    <input type="radio" id="check_yes" class="radio_btn" name="radio1" value="yes" checked>&nbsp;
                                    <label >Yes</label><br>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="check_no" value="no" class="radio_btn" name="radio1">&nbsp;
                                    <label >No</label><br>&nbsp;&nbsp;&nbsp;
                                     <input type="radio" id="check_hold" value="hold" class="radio_btn" name="radio1">&nbsp;
                                    <label >Hold</label><br>&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
                            
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
                        <input type="hidden" name="asset_edit_id" id="asset_edit_id"/>
                        <button type="button" hidden="true" class="btn btn-primary" id="asset_update">Update</button>
                        <button type="button" class="btn btn-primary" id="save_Addmore">Save and Add More</button>
                        <button type="button" class="btn btn-success" id="saveedit">Save</button>
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
</section>

<script>


$(function() {
    $('#check_yes').click(function() {
        $('#assetchecked').attr('hidden',false);
         $('#save_Addmore').attr('hidden',false);
         $("#remarkk").html("");
         $("#category_").html("");
         $("#asset_").html("");
         $("#brand_").html("");
    });
    $('#check_no').click(function() {
        $('#assetchecked').attr('hidden',true);
        $('#save_Addmore').attr('hidden',true);
         $("#remarkk").html("");
          $("#category_").html("");
         $("#asset_").html("");
         $("#brand_").html("");
    });
    $('#check_hold').click(function() {
        $('#assetchecked').attr('hidden',false);
        $('#save_Addmore').attr('hidden',true);
         $("#remarkk").html("");
          $("#category_").html("");
         $("#asset_").html("");
         $("#brand_").html("");
    });
});





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
    $('#asset_update').attr('disabled',true)
     $.ajax({
			method: "GET",
            url: "{{ url('update_verify_asset')}}",
            data: $("#formedit").serialize(),
            dataType: "JSON",
            success: function(data) {
                $('#asset_update').attr('disabled',false)
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
        order: [[0, 'desc']]
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
    $('#data').DataTable({

        ajax: "{{ url('employeess')}}",
  
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
                    columns: [1, 2, 3, 4 ,5]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.employees_list');?>',
                exportOptions: {
                    columns: [1, 2, 3, 4 ,5]
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
                    columns: [1, 2, 3, 4 ,5]
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
                    columns: [1, 2, 3, 4 ,5]
                },
                action: newexportaction,

            }
        ]
    });

   

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
    $('#saveedit').attr('disabled',true)
        $.ajax({
			method: "POST",
            url: "{{ url('verifyemployees')}}",
            data: $("#formedit").serialize(),
            dataType: "JSON",
            success: function(data) {
                $('#saveedit').attr('disabled',false)
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
                    $('#saveedit').attr('disabled',false)
             }
           
		});
});


$(document).on("click", "#save_Addmore", function(){
     $('#save_Addmore').attr('disabled',true)
    $.ajax({
			method: "POST",
            url: "{{ url('saveaddmore')}}",
            data: $("#formedit").serialize(),
            dataType: "JSON",
            success: function(data) {
                $('#save_Addmore').attr('disabled',false)
                if(data.sts=="success"){
                    $('#formedit')[0].reset();
                    var id = data.emp_id;
                    $('#verify_data').DataTable().destroy();
                    asset_table(id);
                }
                 if(data.message=='failed'){
                    $('#req_field').html('Please fill in at least one field.')
                }
            },
           
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




$('#delete').on('show.bs.modal', function(e) {
    var $modal = $(this),
    id = $(e.relatedTarget).attr('customdata');
    $("#iddelete").val(id);
});

})(jQuery);
</script>
@endsection
