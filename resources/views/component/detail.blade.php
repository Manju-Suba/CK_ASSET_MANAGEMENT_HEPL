@extends('main')
@section('content')

<section class="">
    <div class="content p-4">
        <div class="row pt-3">
            <div class="col-md-8">
                <h3 class=""><?php echo trans('lang.componentdetail');?></h3>
            </div>
            <div class="col-md-4 text-md-right">
                                 
                                <a href="{{ url('componentlist') }}" id="btndetail"  class="btn btn-sm btn-fill btn-warning"><i
                                        class="ti-info"></i> <?php echo trans('lang.backtocomponent');?></a>
                           
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-9">
                                <input type="hidden" value="{{ $componentid }}" name="componentid" id="componentid" />
                                <p class="title-detail font-bold"> <span class="componentname"></span> </p>
                                
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="checkinsuccess"  class="alert alert-success display-none"><?php echo trans('lang.data_checkin_succeess');?></div>
                                <div >
                                    
                                    <div>
                                         <div class="table-responsive  pt-4">
                                         <table id="datacomponent" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th><?php echo trans('lang.asset');?></th>
                                                        <th><?php echo trans('lang.quantity');?></th>
                                                        <th><?php echo trans('lang.date');?></th>
                                                        <th><?php echo trans('lang.action');?></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th><?php echo trans('lang.asset');?></th>
                                                        <th><?php echo trans('lang.quantity');?></th>
                                                        <th><?php echo trans('lang.date');?></th>
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
                </div>
            </div>
        </div>

        <!--add checkin -->
     <div id="checkin" class="modal fade" role="dialog" >
        <div class="modal-dialog ">
            <div class="modal-content">

                <form action="#" id="formcheckin" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        
                        <h5 class="modal-title"><?php echo trans('lang.checkin');?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                         <div id="checkinfailed"  class="display-none alert alert-success"><?php echo trans('lang.data_checkin_failed_quantity');?></div>
                        <div class="form-row">
                           
                            <div class="form-group col-md-12">
                                <label><?php echo trans('lang.component');?></label>
                                <input name="assetname" type="text" readonly id="checkinname" class="componentname form-control" required placeholder="<?php echo trans('lang.component');?>"/>
                            </div>
                            
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label><?php echo trans('lang.quantity');?></label>
                                <input name="quantity" type="text" id="checkinquantity" class=" form-control" required placeholder="<?php echo trans('lang.quantity');?>"/>
                            </div>
                        </div>
                       
                        <div class="form-row">
                            <div class="form-group col-md-12 mb-0" >
                                    <label for="checkindate" class="control-label"><?php echo trans('lang.checkindate');?></label>     
                                    <div class="input-group mb-0" >                       
                                    <input class="form-control setdate" required="" placeholder="<?php echo trans('lang.checkindate');?>" id="checkindate" name="checkindate" type="text">
                                    <span class="input-group-addon border-1" id="date" ><i class="fa fa-calendar"></i></span>      
                                </div>
                                <label class="error" for="checkoutdate"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <input type="hidden" name="historyid" id="historyid"/>
                    <input type="hidden" name="componentid" id="checkincomponentid"/>
                    <input type="hidden" name="assetid" id="checkinassetid"/> 

                        <button type="submit" class="btn btn-primary"
                            id="savecheckin"><?php echo trans('lang.save');?></button>
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo trans('lang.close');?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end checkin-->
       
    </div>
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

    var componentid = $("#componentid").val();
    $.ajax({
        type: "POST",
        url: "{{ url('componentbyid')}}",
        data: {
            id: componentid
        },
        dataType: "JSON",
        success: function(data) {
            $(".componentname").html(data.message.componentname);
            $(".componentname").val(data.message.componentname);
        }
    });
    


    //component data
    $('#datacomponent').DataTable({

        ajax: {
        url: "{{ url('historycomponentbyid')}}",
        type: "post",
        data: function (d) {
              d.id = componentid;
            }
        },
      
        columns: [{
            data: 'id',
                orderable: false,
                searchable: false,
                visible: false
            },
            
            {
                data: 'assetname'
            },
           
            {
                data: 'quantity'
            },
            {
                data: 'date'
            },
            {
                data: 'action'
            },
           
           
        ],
     
        buttons: [{
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.componentdetail ');?>',
                exportOptions: {
                    columns: [1, 2, 3]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.componentdetail');?>',
                exportOptions: {
                    columns: [1, 2, 3]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.componentdetail');?>',
                orientation: 'landscape',
                exportOptions: {
                    columns: [1, 2, 3]
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
                title: '<?php echo trans('lang.componentdetail');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    columns: [1, 2, 3]
                },
                action: newexportaction,

            }
        ]
    });

    //checkin
    $("#formcheckin").validate({
        rules: {
          quantity: {
            required: true,
            digits: true
          }
        },
        submitHandler: function(form) {
            $.ajax({
                method: "POST",
                url: "{{ url('savecheckincomponent')}}",
                data: $("#formcheckin").serialize(),
                dataType: "JSON",
                success: function(data) {
                    if(data.success=='0'){
                        $("#checkinfailed").css({'display':"block"});
                    }
                    if(data.success=='success'){
                        $("#checkinsuccess").css({'display':"block"});
                        $('#checkin').modal('hide');
                        window.setTimeout(function(){location.reload()},2000)
                    }
                }
            });
        }
    });

    //getdetail
    $('#checkin').on('show.bs.modal', function(e) {
        var $modal = $(this),
        id = $(e.relatedTarget).attr('customdata');
        $.ajax({
            type: "POST",
            url: "{{ url('singlehistorycomponentbyid')}}",
            data: {id:id},
            dataType: "JSON",
            success: function(data) {
                $("#historyid").val(id);
                $("#checkincomponentid").val(data.message.componentid);
                $("#checkinassetid").val(data.message.assetid);
            }
        });
    });
})(jQuery);
</script>
@endsection