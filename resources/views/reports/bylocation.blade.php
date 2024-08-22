@extends('main')
@section('content')

<section class="">
    <div class="content p-4">
        <div class="row pt-3">
            <div class="col-md-6">
                <h3 class=""><?php echo trans('lang.reportbylocation');?></h3>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body ">
                        <form action="" method="POST" id="form">
                            <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label><?php echo trans('lang.location');?></label>
                                        <select name="locationid" id="locationid"  class="form-control select2">
                                            <option value=""><?php echo trans('lang.location');?></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2" style="padding-top:33px;">
                                        <button type="submit" class="form-control btn btn-sm btn-fill btn-info"><i class="fa fa-search"></i> <?php echo trans('lang.search');?></button>
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table id="data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.picture');?></th>
                                        <th><?php echo trans('lang.assettag');?></th>
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.brand');?></th>
                                        <th><?php echo trans('lang.location');?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.picture');?></th>
                                        <th><?php echo trans('lang.assettag');?></th>
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.brand');?></th>
                                        <th><?php echo trans('lang.location');?></th>
                                    </tr>
                                </tfoot>
                               
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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


$("#locationid").select2({
    placeholder: "Select a Location",
    allowClear: true
});



"use strict";  

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
                 
            });
        }   
    });  

    var tabledata = $('#data').DataTable({
        bFilter : false,
        ajax: {
                url : "{{ url('getdatabylocationreport')}}",
                data: function (d) {
                    d.locationid = $("#locationid").val();
                },
            },
       
        columns: [{
            data: 'id',
                orderable: false,
                searchable: false,
                visible: false,
                name:'id'
            },
            
            {
                data: 'pictures',
                name:'pictures'
            },
            {
                data: 'assetid',
                name: 'assetid'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'brand',
                name: 'brand'
            },
            {
                data: 'location',
                name: 'location'
            }
        ],
        dom: "<'row'<'col-sm-9 text-left'B><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-2'l><'col-sm-5'i><'col-sm-5'p>>",
        buttons: [{
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.reportbylocation');?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5,6, 7, 8, 9, 10]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.reportbylocation');?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5,6, 7, 8, 9, 10]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.reportbylocation');?>',
                orientation: 'landscape',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5,6, 7, 8, 9, 10]
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
                title: '<?php echo trans('lang.reportbylocation');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5,6, 7, 8, 9, 10]
                },
                action: newexportaction,

            }
        ]
    });
    
    //do filter

    //do search
    $('#form').on('submit', function(e) {
        tabledata.draw();
        e.preventDefault();
    });

})(jQuery);
</script>
@endsection