@extends('main')
@section('content')

<section class="">
    <div class="content p-4">
        <div class="row pt-3" style="margin: 0 5px 0 5px;padding-top:0rem !important;">
            <div class="col-md-3">
                <h3 class=""><?php echo trans('lang.employees_list');?></h3>
            </div>

            @if(auth()->user()->role!=="7")
            <div class="col-md-9 text-md-right pb-md-0 pb-3">
                <button type="button" data-toggle="modal" data-target="#upload" class="btn btn-sm btn-fill btn-primary" ><i class="fa fa-upload"></i> Bulk Upload</button>
                <button type="button" data-toggle="modal" data-target="#add" class="btn btn-sm btn-fill btn-primary"><i class="fa fa-plus"></i> <?php echo trans('lang.add_data');?></button>
            </div>
            @endif
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
                                        <th><?php echo trans('lang.email');?></th>
                                        <th><?php echo trans('lang.jobrole');?></th>
                                        <th><?php echo trans('lang.department');?></th>
                                        <th>Business</th>
                                        <!-- <th><?php echo trans('lang.city');?></th> -->
                                        <th><?php echo trans('lang.action');?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Emp ID</th>
                                        <th><?php echo trans('lang.fullname');?></th>
                                        <th><?php echo trans('lang.email');?></th>
                                        <th><?php echo trans('lang.jobrole');?></th>
                                        <th><?php echo trans('lang.department');?></th>
                                        <th>Business</th>
                                        <!-- <th><?php echo trans('lang.city');?></th> -->
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

    <!-- start upload file -->
    <div id="upload" class="modal fade" role="dialog" >
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form action="javascript:void(0)" id="employee_bulk_upload" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <div ><h5 class="card-title" >Bulk Upload <a title="Sample Excel" href="{{URL::asset('sample_excel/employee_sample.xlsx')}}">DOWNLOAD</a></h5></div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="file" name="file_upload" id="file_upload" class=" form-control" required/>
                                <input type="hidden" name="repeat" id="repeat" class=" form-control" value=""/>
                            </div>
                        </div>
                    </div>
                    <div id="uploadresponse" class="display-none alert"></div>
                    <div class="modal-footer">
                        {{-- <div id="uploaderror" class="display-none alert alert-danger"></div> --}}
                        <button type="submit" class="btn btn-primary" id="employee_bulk_upload_submit">Upload</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo trans('lang.close');?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end upload file-->

    <!--add new data -->
    <div id="add" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" id="formadd" enctype="multipart/form-data">
                    <div class="modal-header">

                        <h5 class="modal-title"><?php echo trans('lang.add_data');?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div  class="display-none messageexist text-white alert" style="background-color:rgb(244,97,83)"><?php echo trans('lang.data_exist');?></div>
                        <div class="form-group">
                            <label>Emp ID</label>
                            <input name="emp_id" type="text" id="emp_id" class=" form-control" required placeholder="Emp ID"/>
                        </div>
                        <span class="text-danger" id="error"></span>
                        <div class="form-group">
                            <label><?php echo trans('lang.fullname');?></label>
                            <input name="fullname" type="text" id="fullname" class=" form-control" required placeholder="<?php echo trans('lang.fullname');?>"/>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.email');?></label>
                            <input name="email" type="email" id="email" class=" form-control" required placeholder="<?php echo trans('lang.email');?>"/>
                        </div>

                        <div class="form-group">
                            <label><?php echo trans('lang.jobrole');?></label>
                            <input name="jobrole" type="text" id="jobrole" class=" form-control" required placeholder="<?php echo trans('lang.jobrole');?>"/>
                        </div>
                        <div class="form-group">
                            <label>Business</label>
                            <select name="business" id="business" required class="form-control select2">
                                <option value="">Choose Business</option>
                                @foreach($business_data as $key=>$row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.department');?></label>
                            <select name="department" id="department" required class="form-control select2">
                                <option value=""><?php echo trans('lang.department');?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>COST Center Code</label>
                            <input name="cost_center" type="text" id="cost_center" class=" form-control" required placeholder="Enter COST Center Code"/>
                        </div>

                        <div class="form-group">
                            <label>Special Role</label>
                            <select name="spe_role" id="spe_role" required class="form-control select2">
                                <option value="">Choose Special Role</option>
                                <option value="No">No</option>
                                <option value="Supervisor">Supervisor</option>
                            </select>
                        </div>
                        <div class="form-group" id="supervisor_div" >
                            <label>Supervisor List</label>
                            <select name="supervisor" id="supervisor"  class="form-control select2">
                                <option value="">Supervisor</option>
                            </select>
                        </div>



                    </div>
                    <div class="modal-footer">
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
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" id="formedit" enctype="multipart/form-data">
                    <div class="modal-header">

                        <h5 class="modal-title"><?php echo trans('lang.edit_data');?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div  class="display-none messageexist text-white  alert" style="background-color:rgb(244,97,83)"><?php echo trans('lang.data_exist');?></div>
                        <div class="form-group">
                            <label>Emp ID</label>
                            <input name="emp_id" type="text" id="editemp_id" class=" form-control" required placeholder="Emp ID" readonly/>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.fullname');?></label>
                            <input name="fullname" type="text" id="editfullname" class=" form-control" required placeholder="<?php echo trans('lang.fullname');?>"/>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.email');?></label>
                            <input name="email" type="email" id="editemail" class=" form-control" required placeholder="<?php echo trans('lang.email');?>"/>
                        </div>

                        <div class="form-group">
                            <label><?php echo trans('lang.jobrole');?></label>
                            <input name="jobrole" type="text" id="editjobrole" class=" form-control" required placeholder="<?php echo trans('lang.jobrole');?>"/>
                        </div>

                        <div class="form-group">
                            <label>Business</label>
                            <select name="editbusiness" id="editbusiness" required class="form-control select2">
                                <option value="">Choose Business</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php echo trans('lang.department');?></label>
                            <select name="department" id="editdepartment" required class="form-control select2">
                                <option value=""><?php echo trans('lang.department');?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>COST Center Code</label>
                            <input name="editcost_center" type="text" id="editcost_center" class=" form-control" required placeholder="Enter COST Center Code"/>
                        </div>

                        <div class="form-group">
                            <label>Special Role</label>
                            <select name="spe_role" id="edit_spe_role" required class="form-control select2">
                                <option value="">Choose Special Role</option>
                                <option value="No">No</option>
                                <option value="Supervisor">Supervisor</option>
                            </select>
                        </div>
                        <div class="form-group" id="editsupervisor_div" >
                            <label>Supervisor List</label>
                            <select name="supervisor" id="editsupervisor"  class="form-control select2">
                                <option value="">Supervisor</option>
                            </select>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <b id="form_resp"></b>
                        <input type="hidden" name="id" id="editid"/>
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
    var userRole = "{{ Auth::user()->role }}";
</script>
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

$('.select2').each(function() {
   var $p = $(this).parent();
   $(this).select2({
     dropdownParent: $p
   });
});

"use strict";
    $('#data').DataTable({

        ajax: "{{ url('employees')}}",

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
                data: 'email'
            },

            {
                data: 'jobrole'
            },
            {
                data: 'department'
            },
            {
                data: 'businessid',searchable: true ,visible: false
            },
            // {
            //     data: 'city'
            // },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                visible: (userRole === '7') ? false : true
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


    // $("#spe_role").change(function(){
    //     var spe_role=$("#spe_role").val();
    //     if(spe_role=="No"){
    //         $("#supervisor_div").css("display","block");
    //     }
    //     else{
    //         $("#supervisor_div").css("display","none");
    //     }
    // })
    // $("#edit_spe_role").change(function(){
    //     var spe_role=$("#edit_spe_role").val();
    //     if(spe_role=="No"){
    //         $("#editsupervisor_div").css("display","block");
    //     }
    //     else{
    //         $("#editsupervisor_div").css("display","none");
    //     }
    // })

    $("#business").change(function(){
        var business=$("#business").val();
        $.ajax({
			method: "GET",
            url: "{{ url('get_department')}}",
            data: {'business':business,},
            dataType: "JSON",
            success: function(html) {
                $("#department").html(html.sup_div);

                // temp
                $.ajax({
                    method: "GET",
                    url: "{{ url('get_supervisor')}}",
                    data: {},
                    dataType: "JSON",
                    success: function(html) {
                        $("#supervisor").html(html.sup_div);
                    }
                });
                // temp

		    }
		});
    })

    // $("#department").change(function(){
    //     var business=$("#business").val();
    //     var department=$("#department").val();
    //     $.ajax({
	// 		method: "GET",
    //         url: "{{ url('get_supervisor')}}",
    //         data: {'business':business,'department':department,},
    //         dataType: "JSON",
    //         success: function(html) {
    //             $("#supervisor").html(html.sup_div);
	// 	    }
	// 	});
    // })


    $("#editbusiness").change(function(){
        var business=$("#editbusiness").val();
        $.ajax({
			method: "GET",
            url: "{{ url('get_department')}}",
            data: {'business':business,},
            dataType: "JSON",
            success: function(html) {
                $("#editdepartment").html(html.sup_div);
                $("#editsupervisor").html("");
		    }
		});
    })

    $("#editdepartment").change(function(){
        var business=$("#editbusiness").val();
        var department=$("#editdepartment").val();
        $.ajax({
			method: "GET",
            url: "{{ url('get_supervisor')}}",
            data: {'business':business,'department':department,},
            dataType: "JSON",
            success: function(html) {
                $("#editsupervisor").html(html.sup_div);
		    }
		});
    })

    // $("#editdepartment").change(function(){
    //     var department=$("#editdepartment").val();
    //     $.ajax({
	// 		method: "GET",
    //         url: "{{ url('get_supervisor')}}",
    //         data: {'department':department,},
    //         dataType: "JSON",
    //         success: function(html) {
    //             $("#editsupervisor").html(html.sup_div);
	// 	    }
	// 	});
    // })


//get all department
// $.ajax({
//         type: "GET",
// 		url: "{{ url('listdepartment')}}",
// 		dataType: "JSON",
// 		success: function(html) {
//             var objs = html.message;
//             jQuery.each(objs, function (index, record) {
//                 var id = decodeURIComponent(record.id);
//                 var name = decodeURIComponent(record.name);
//                 $("#department").append($("<option></option>")
//                     .attr("value",id)
//                     .text(name));
//                 $("#editdepartment").append($("<option></option>")
//                     .attr("value",id)
//                     .text(name));
//             });
// 		}
//     });


// upload part

$('#employee_bulk_upload').submit(function(e) {
    e.preventDefault();
    $("#employee_bulk_upload_submit").attr('disabled',true);

    $.ajax({
        type: 'POST',
        url: "{{ url('employee_bulk_upload') }}",
        data: new FormData(this),
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            $("#employee_bulk_upload_submit").attr('disabled',false);
            $("#uploadresponse").fadeIn();

            if(data.response=='success'){
                $("#uploadresponse").addClass("alert-success");
                $("#uploadresponse").html('Uploaded Successfully!');
                $("#uploadresponse").fadeOut(3000);
                window.setTimeout(function(){location.reload()},3000);
            }

            if(data.response=='error'){
                $("#uploadresponse").addClass("alert-danger");
                $("#uploadresponse").html('Upload Error');
            }

            if(data.response=='emp_id_missing_error'){
                $("#uploadresponse").addClass("alert-danger");
                $("#uploadresponse").html('Emp_id Missing, please check!');
            }

            if(data.response=='xlrpt_error'){
                $("#uploadresponse").addClass("alert-danger");
                $("#uploadresponse").html(data.name +'-Emp_id repeated, please remove & upload again!');
            }

            if(data.response=='dep_id_missing_error'){
                $("#uploadresponse").addClass("alert-danger");
                $("#uploadresponse").html('Department Missing, please check!');
            }

            if(data.response=='business_missing_error'){
                $("#uploadresponse").addClass("alert-danger");
                $("#uploadresponse").html('Business Field Missing, please check!');
            }

            if(data.response =='department_missing'){
                $("#uploadresponse").addClass("alert-danger");
                $("#uploadresponse").html(data.dep_id+' Mismatch department, please check format!');
            }

            if(data.response=='repeat_emp'){

                Swal.fire({
                        title: "Duplicate Entry!",
                        text: "Some Details are Already Available, you want to upload again!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#34c38f",
                        cancelButtonColor: "#f46a6a",
                        confirmButtonText: "Continue This.."
                    }).then(function (result) {
                    if (result.value) {

                        var repeat_val = "repeated" ;
                        $("#repeat").val(repeat_val);

                        $("#employee_bulk_upload_submit").click();

                    }else{
                        $('#upload').modal('hide');
                        $('#file_upload').val('');

                    }
                });
            }
        }
    });
});






//add data
$("#formadd").validate({
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
                    window.setTimeout(function(){location.reload()},2000);
                }
                if(data.message=='exist'){
                    $(".messageexist").css({'display':"block"});
                }
            },
            error: function (data) {
                if(data.responseJSON.message){
                    $("#error").html(("Employee ID Already Exist"));
                }
             }
		});
    }
});

//edit data
$("#formedit").validate({
    submitHandler: function(form) {
        $.ajax({
			method: "POST",
            url: "{{ url('updateemployees')}}",
            data: $("#formedit").serialize(),
            dataType: "JSON",
            success: function(data) {
                if(data.message=='need_all_field'){
                    $("#form_resp").html("Need All Fields..!");
                }
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
            url: "{{ url('deleteemployees')}}",
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

//show edit data
$('#edit').on('show.bs.modal', function(e) {
    var $modal = $(this),
    id = $(e.relatedTarget).attr('customdata');
	$.ajax({
		type: "POST",
		url: "{{ url('employeesbyid')}}",
		data: {id:id},
		dataType: "JSON",
		success: function(data) {
			$("#editid").val(id);
			$("#editemp_id").val(data.message.emp_id);
            $("#editfullname").val(data.message.fullname);
            $("#editbusiness").html(data.business_div);
            $("#editdepartment").html(data.dept_div);
            $("#editsupervisor").html(data.superior_div);
            $("#edit_spe_role").html(data.spe_role_div);
            $("#editcost_center").val(data.message.cost_center);



            // if(data.check_special_role=="No"){
            //     $("#editsupervisor_div").css("display","block");
            // }
            // else{
            //     $("#editsupervisor_div").css("display","none");
            // }

            $("#editemail").val(data.message.email);
            $("#editjobrole").val(data.message.jobrole);
            $("#editcity").val(data.message.city);
            $("#editcountry").val(data.message.country);
            $("#editaddress").val(data.message.address);
		}
	});
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
