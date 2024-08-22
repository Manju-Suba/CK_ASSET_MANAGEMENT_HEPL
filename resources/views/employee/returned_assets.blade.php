@extends('main')
@section('content')
<section class="">
    <div class="content p-4">
        <div class="row pt-3">
            <div class="col-md-6">
                <h3 class="">Returned Assets</h3>
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
   
    <!--end edit data-->

    <!--delete data -->
   
    <!--end delete data -->
{{-- Returned Status Modal --}}




</section>

<script>
$(document).on('change', '#created_by', function() {
    var id = $('#created_by').val();
      $('#data').DataTable({

         ajax: {
            'url':"{{ url('get_returned_asset')}}",
            'type':"GET",
            'data':{id:id},
        } ,

        processing: true,
        serverSide: true,
        bDestroy: true,
        scrollX: true,
  
        columns: [
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

        ajax: "{{ url('get_returned_asset')}}",

        processing: true,
        serverSide: true,
        bDestroy: true,
         scrollX: true,
  
        columns: [
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
})(jQuery);
</script>
@endsection
