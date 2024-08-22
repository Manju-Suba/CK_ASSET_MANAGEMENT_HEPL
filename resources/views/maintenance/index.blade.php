@extends('main')
@section('content')

<section class="">
    <div class="content p-4">
        <div class="row pt-3">
            <div class="col-md-6">
                <h3 class=""><?php echo trans('lang.maintenance_list');?></h3>
            </div>
            <div class="col-md-6 text-md-right pb-md-0 pb-3">
            <button type="button" data-toggle="modal" data-target="#add" class="btn btn-sm btn-fill btn-primary"><i class="fa fa-plus"></i> <?php echo trans('lang.add_data');?></button>
            </div>
        </div>
       
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body ">
                    <div id="messagesuccess"  class="display-none alert alert-success"><?php echo trans('lang.data_added');?></div>
					<div id="messagedelete"  class="display-none alert alert-success"><?php echo trans('lang.data_deleted');?></div>
					<div id="messageupdate"  class="display-none alert alert-success"><?php echo trans('lang.data_updated');?></div>
                        <div class="table-responsive">
                            <table id="data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.assettag');?></th>
                                        <th><?php echo trans('lang.asset');?></th>
                                        <th><?php echo trans('lang.supplier');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.startdate');?></th>
                                        <th><?php echo trans('lang.enddate');?></th>
                                        <th><?php echo trans('lang.action');?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.assettag');?></th>
                                        <th><?php echo trans('lang.asset');?></th>
                                        <th><?php echo trans('lang.supplier');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.startdate');?></th>
                                        <th><?php echo trans('lang.enddate');?></th>
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

    <!--add new data -->
    <div id="add" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" id="formadd" autocomplete="off">
                    <div class="modal-header">
                       
                        <h5 class="modal-title"><?php echo trans('lang.add_data');?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" >
                            <label><?php echo trans('lang.asset');?></label>
                                <select name="assetid" id="assetid" required class="form-control">
                                    <option value=""><?php echo trans('lang.asset');?></option>
                                </select>
                        </div>
                        <div class="form-group" >
                            <label><?php echo trans('lang.supplier');?></label>
                                <select name="supplierid" id="supplierid" required class="form-control">
                                    <option value=""><?php echo trans('lang.supplier');?></option>
                                </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.type');?></label>
                                <select name="type" id="type" required class="form-control">
                                    <option value=""><?php echo trans('lang.type');?></option>
                                    <option value="<?php echo trans('lang.Maintenance');?>"><?php echo trans('lang.Maintenance');?></option>
                                    <option value="<?php echo trans('lang.Repair');?>"><?php echo trans('lang.Repair');?></option>
                                    <option value="<?php echo trans('lang.Upgrade');?>"><?php echo trans('lang.Upgrade');?></option>
                                    <option value="<?php echo trans('lang.Testing');?>"><?php echo trans('lang.Testing');?></option>
                                    <option value="<?php echo trans('lang.Calibration');?>"><?php echo trans('lang.Calibration');?></option>
                                    <option value="<?php echo trans('lang.Softwaresupport');?>"><?php echo trans('lang.Softwaresupport');?></option>
                                    <option value="<?php echo trans('lang.Hardwaresupport');?>"><?php echo trans('lang.Hardwaresupport');?></option>
                                </select>
                        </div>
                        <div class="form-group mb-0" >
                                    <label for="startdate" class="control-label"><?php echo trans('lang.startdate');?></label>     
                                    <div class="input-group mb-0" >                       
									<input class="form-control setdate" required="" placeholder="<?php echo trans('lang.startdate');?>" id="startdate" name="startdate" type="text">
                                    <span class="input-group-addon border-1" id="date" ><i class="fa fa-calendar"></i></span>      
                                </div>
                                <label class="error" for="startdate"></label>
                        </div>
                        <div class="form-group  mb-0" >
                                    <label for="enddate" class="control-label"><?php echo trans('lang.enddate');?></label>     
                                    <div class="input-group mb-0" >                       
									<input class="form-control setdate" required="" placeholder="<?php echo trans('lang.enddate');?>" id="enddate" name="enddate" type="text">
                                    <span class="input-group-addon border-1" id="date"><i class="fa fa-calendar"></i></span>      
                                </div>
                                <label class="error" for="enddate"></label>
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
                <form action="#" id="formedit">
                    <div class="modal-header">
                       
                        <h5 class="modal-title"><?php echo trans('lang.edit_data');?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div class="form-group" >
                            <label><?php echo trans('lang.asset');?></label>
                                <select name="assetid" id="editassetid" required class="form-control">
                                    <option value=""><?php echo trans('lang.asset');?></option>
                                </select>
                        </div>
                        <div class="form-group" >
                            <label><?php echo trans('lang.supplier');?></label>
                                <select name="supplierid" id="editsupplierid" required class="form-control">
                                    <option value=""><?php echo trans('lang.supplier');?></option>
                                </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.type');?></label>
                                <select name="type" id="edittype" required class="form-control">
                                    <option value=""><?php echo trans('lang.type');?></option>
                                    <option value="<?php echo trans('lang.Maintenance');?>"><?php echo trans('lang.Maintenance');?></option>
                                    <option value="<?php echo trans('lang.Repair');?>"><?php echo trans('lang.Repair');?></option>
                                    <option value="<?php echo trans('lang.Upgrade');?>"><?php echo trans('lang.Upgrade');?></option>
                                    <option value="<?php echo trans('lang.Testing');?>"><?php echo trans('lang.Testing');?></option>
                                    <option value="<?php echo trans('lang.Calibration');?>"><?php echo trans('lang.Calibration');?></option>
                                    <option value="<?php echo trans('lang.Softwaresupport');?>"><?php echo trans('lang.Softwaresupport');?></option>
                                    <option value="<?php echo trans('lang.Hardwaresupport');?>"><?php echo trans('lang.Hardwaresupport');?></option>
                                </select>
                        </div>
                        <div class="form-group mb-0" >
                                    <label for="editstartdate" class="control-label"><?php echo trans('lang.startdate');?></label>     
                                    <div class="input-group mb-0" >                       
									<input class="form-control setdate" required="" placeholder="<?php echo trans('lang.startdate');?>" id="editstartdate" name="startdate" type="text">
                                    <span class="input-group-addon border-1" id="date" ><i class="fa fa-calendar"></i></span>      
                                </div>
                                <label class="error" for="editstartdate"></label>
                        </div>
                        <div class="form-group mb-0">
                                    <label for="editenddate" class="control-label"><?php echo trans('lang.enddate');?></label>     
                                    <div class="input-group mb-0" >                       
									<input class="form-control setdate" required="" placeholder="<?php echo trans('lang.enddate');?>" id="editenddate" name="enddate" type="text">
                                    <span class="input-group-addon border-1" id="date" ><i class="fa fa-calendar"></i></span>      
                                </div>
                                <label class="error" for="editenddate"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
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
//get all supplier
$.ajax({
        type: "GET",
		url: "{{ url('listsupplier')}}",
		dataType: "JSON",
		success: function(html) {
            var objs = html.message;
            jQuery.each(objs, function (index, record) {
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


//get all asset
$.ajax({
        type: "GET",
		url: "{{ url('listasset')}}",
		dataType: "JSON",
		success: function(html) {
            var objs = html.message;
            jQuery.each(objs, function (index, record) {
                var id = decodeURIComponent(record.id);
                var name = decodeURIComponent(record.name);
                $("#assetid").append($("<option></option>")
                    .attr("value",id)
                    .text(name)); 
                $("#editassetid").append($("<option></option>")
                    .attr("value",id)
                    .text(name));     
            });
		}   
    }); 


    $('#data').DataTable({

        ajax: "{{ url('maintenance')}}",
        
        columns: [{
            data: 'id',
                orderable: false,
                searchable: false,
                visible: false
            },
            {
                data: 'assettag'
            },
            {
                data: 'asset'
            },
            {
                data: 'supplier'
            },
            {
                data: 'type'
            },
            {
                data: 'startdate'
            },
            {
                data: 'enddate'
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
                title: '<?php echo trans('lang.maintenance_list ');?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5,6]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.maintenance_list');?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5,6]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.maintenance_list');?>',
                orientation: 'landscape',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5,6]
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
                title: '<?php echo trans('lang.maintenance_list');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5,6]
                },
                action: newexportaction,

            }
        ]
    });

//add data
$("#formadd").validate({
    submitHandler: function(form) {
        $.ajax({
			method: "POST",
            url: "{{ url('savemaintenance')}}",
            data: $("#formadd").serialize(),
            dataType: "JSON",
            success: function(data) {
                console.log(data);
				$("#messagesuccess").css({'display':"block"});
				$('#add').modal('hide');
				window.setTimeout(function(){location.reload()},2000)
            }
		});
    }
});

//edit data
$("#formedit").validate({
    submitHandler: function(form) {
        $.ajax({
			method: "POST",
            url: "{{ url('updatemaintenance')}}",
            data: $("#formedit").serialize(),
            dataType: "JSON",
            success: function(data) {
                console.log(data);
				$("#messageupdate").css({'display':"block"});
				$('#edit').modal('hide');
				window.setTimeout(function(){location.reload()},2000)
            }
		});
    }
});

//delete data
$("#formdelete").validate({
    submitHandler: function(form) {
        $.ajax({
			method: "POST",
            url: "{{ url('deletemaintenance')}}",
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
		url: "{{ url('maintenancebyid')}}",
		data: {id:id},
		dataType: "JSON",
		success: function(data) {
			$("#editid").val(id);
            $("#editassetid").val(data.message.assetid);
            $("#editsupplierid").val(data.message.supplierid);
			$("#edittype").val(data.message.type);
            $("#editstartdate").val(data.message.startdate);
            $("#editenddate").val(data.message.enddate);
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