@extends('main')
@section('content')
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
        cursor: default;
        padding-left: 15px;
        padding-right: 5px;
    }

    #editdomain .select2-search.select2-search--inline{
        display: none;
    }

    .select2-search--inline {
        display: contents; /*this will make the container disappear, making the child the one who sets the width of the element*/
    }

    .select2-search__field:placeholder-shown {
        width: 100% !important; /*makes the placeholder to be 100% of the width while there are no options selected*/
    }

</style>
<section class="">
    <div class="content p-4">
        <div class="row pt-3">
            <div class="col-md-6">
                <h3 class=""><?php echo trans('lang.user_list');?></h3>
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
                                        <th><?php echo trans('lang.fullname');?></th>
                                        <th><?php echo trans('lang.email');?></th>
                                        <th><?php echo trans('lang.phone');?></th>
                                        <th><?php echo trans('lang.role');?></th>
                                        <th>Domain</th>
                                        <th><?php echo trans('lang.city');?></th>
                                        <th><?php echo trans('lang.status');?></th>
                                        <th><?php echo trans('lang.action');?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.fullname');?></th>
                                        <th><?php echo trans('lang.email');?></th>
                                        <th><?php echo trans('lang.phone');?></th>
                                        <th><?php echo trans('lang.role');?></th>
                                        <th>Domain</th>
                                        <th><?php echo trans('lang.city');?></th>
                                        <th><?php echo trans('lang.status');?></th>
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
                <form action="#" id="formadd">
                    <div class="modal-header">

                        <h5 class="modal-title"><?php echo trans('lang.add_data');?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div   class="display-none messageexist alert alert-success"><?php echo trans('lang.data_exist');?></div>
                        <div class="form-group">
                            <label><?php echo trans('lang.fullname');?></label>
                            <input name="fullname" type="text" id="fullname" class=" form-control" required placeholder="<?php echo trans('lang.fullname');?>"/>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.email');?></label>
                            <input name="email" type="email" id="email" class=" form-control" required placeholder="<?php echo trans('lang.email');?>"/>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.phone');?></label>
                            <input name="phone" type="text" id="phone" class=" form-control" required placeholder="<?php echo trans('lang.phone');?>"/>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.status');?></label>
                            <select name="status" required class="form-control select2">
                                <option value=""><?php echo trans('lang.status');?></option>
                                <option value="1"><?php echo trans('lang.active');?></option>
                                <option value="2"><?php echo trans('lang.inactive');?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.role');?></label>
                            <select name="role" required class="form-control select2">
                                <option value=""><?php echo trans('lang.role');?></option>
                                <option value="1"><?php echo trans('lang.admin');?></option>
                                <option value="2"><?php echo trans('lang.user');?></option>
                                <option value="5">IT Infra</option>
                                <option value="3">IT Infra Testing (Type 1)</option>
                                <option value="4">IT Infra Testing (Type 2)</option>
                                <option value="IA">IA</option>
                                <option value="itinfra_audit">IT Infra Audit</option>
                                <option value="6">Asset Management</option>
                                <option value="7">IT Infra @CITPL</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Domain</label>
                            <select name="domain[]" id="domain" required multiple="multiple" class="form-control select2">
                                <option selected  disabled value="" >Choose Domain</option>
                                @foreach($business as $row)
                                <option value="{{$row->name}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php echo trans('lang.city');?></label>
                            <input name="city" type="text" id="city" class=" form-control" required placeholder="<?php echo trans('lang.city');?>"/>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.password');?></label>
                            <input name="password" type="password" id="password" class=" form-control" required placeholder="<?php echo trans('lang.password');?>"/>
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
                    <div   class="display-none messageexist alert alert-success"><?php echo trans('lang.data_exist');?></div>
                        <div class="form-group">
                            <label><?php echo trans('lang.fullname');?></label>
                            <input name="fullname" type="text" id="editfullname" class=" form-control" required placeholder="<?php echo trans('lang.fullname');?>"/>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.email');?></label>
                            <input name="email" type="email" id="editemail" class=" form-control" required placeholder="<?php echo trans('lang.email');?>"/>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.phone');?></label>
                            <input name="phone" type="text" id="editphone" class=" form-control" required placeholder="<?php echo trans('lang.phone');?>"/>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.status');?></label>
                            <select name="status" id="editstatus" required class="form-control select2">
                                <option value=""><?php echo trans('lang.status');?></option>
                                <option value="1"><?php echo trans('lang.active');?></option>
                                <option value="2"><?php echo trans('lang.inactive');?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.role');?></label>
                            <select name="role" id="editrole" required class="form-control select2">
                                <option value=""><?php echo trans('lang.role');?></option>
                                <option value="1"><?php echo trans('lang.admin');?></option>
                                <option value="2"><?php echo trans('lang.user');?></option>
                                <option value="5">IT Infra</option>
                                <option value="3">IT Infra Testing (Type 1)</option>
                                <option value="4">IT Infra Testing (Type 2)</option>
                                <option value="IA">IA</option>
                                <option value="itinfra_audit">IT Infra Audit</option>
                                <option value="6">Asset Management</option>
                                <option value="7">IT Infra @CITPL</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Domain</label>
                            <select name="domain[]" id="editdomain" multiple="multiple" class="form-control multiple select2">
                                <option selected  disabled value="" >Choose Domain</option>
                                @foreach($business as $row)
                                <option value="{{$row->name}}">{{$row->name}}</option>
                                @endforeach
                                {{-- <option value="">Domain</option>
                                <option value="HEPL"> HEPL</option>
                                <option value="CKPL"> CKPL</option> --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.city');?></label>
                            <input name="city" type="text" id="editcity" class=" form-control" required placeholder="<?php echo trans('lang.city');?>"/>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('lang.password');?></label>
                            <input name="password" type="password" id="editpassword" class=" form-control"  placeholder="<?php echo trans('lang.password');?>"/>
                            <p class="text-help"><?php echo trans('lang.password_note');?></p>
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

    $('#editdomain').select2();


    $('#editdomain').on('select2:opening select2:closing', function( event ) {
        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.remove();
        // $searchfield.prop('disabled', true);
        $("option[value='']").remove();
    });

    $('#domain').select2();
    $('#domain').on('select2:opening select2:closing', function( event ) {
        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.remove();
        $("option[value='']").remove();
    });


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

        ajax: "{{ url('user')}}",
        columns: [{
            data: 'id',
                orderable: false,
                searchable: false,
                visible: false
            },

            {
                data: 'fullname'
            },

            {
                data: 'email'
            },
            {
                data: 'phone'
            },
            {
                data: 'role'
            },
            {
                data: 'domain'
            },
            {
                data: 'city'
            },
            {
                data: 'status'
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
                title: '<?php echo trans('lang.user_list ');?>',
                exportOptions: {
                    columns: [1, 2, 3, 4 ,5, 6]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.user_list');?>',
                exportOptions: {
                    columns: [1, 2, 3, 4 ,5, 6]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.user_list');?>',
                orientation: 'landscape',
                exportOptions: {
                    columns: [1, 2, 3, 4 ,5, 6]
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
                title: '<?php echo trans('lang.user_list');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    columns: [1, 2, 3, 4 ,5, 6]
                },
                action: newexportaction,

            }
        ]
    });


//add data
$("#formadd").validate({
    rules: {
      phone: {
        required: true,
        digits: true
      }
    },
    submitHandler: function(form) {
        $.ajax({
			method: "POST",
            url: "{{ url('saveuser')}}",
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
            }
		});
    }
});

//edit data
$("#formedit").validate({
    rules: {
      phone: {
        required: true,
        digits: true
      },
    "domain[]":{
        required:  function () {
                return $("#editrole").val()==5;
            }
      }
    },
    submitHandler: function(form) {
        $.ajax({
			method: "POST",
            url: "{{ url('updateuser')}}",
            data: $("#formedit").serialize(),
            dataType: "JSON",
            success: function(data) {

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
            url: "{{ url('deleteuser')}}",
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
		url: "{{ url('userbyid')}}",
		data: {id:id},
		dataType: "JSON",
		success: function(data) {
			$("#editid").val(id);
            $("#editfullname").val(data.message.fullname);
            $("#editemail").val(data.message.email);
            $("#editcity").val(data.message.city);
            $("#editphone").val(data.message.phone);
            $("#editstatus").select2().val(data.message.status).trigger('change.select2');
            $("#editrole").select2().val(data.message.role).trigger('change.select2');

            var domain = data.message.domain ;

            if(domain == null || domain == undefined){
                var s_val = "";
                $("#editdomain").select2().val(s_val).trigger('change.select2');

            }else{
                var s_val = domain.split(',')
                $("#editdomain").select2().val(s_val).trigger('change.select2');
            }
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
