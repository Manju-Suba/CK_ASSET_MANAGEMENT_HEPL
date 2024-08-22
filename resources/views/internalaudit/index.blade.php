@extends('main')
@section('content')

<style>
    input#scan_assetid {
    background-color: #ffc1c1;
    }
    input#scan_assetid:focus {
    background-color: #b4f7bf;
    }
    .dropdown-item{
        cursor:pointer;
    }

</style>

<style>
      .blink {
      animation: blink 2s steps(5, start) infinite;
      -webkit-animation: blink 1s steps(5, start) infinite;
    }
    @keyframes blink {
      to {
        visibility: hidden;
      }
    }
    @-webkit-keyframes blink {
      to {
        visibility: hidden;
      }
    }
</style>

<section class="">
    <div class="content p-4">

        <div class="row">
            <div class="col-md-12">
                <div class="card">

                <!-- <div class="w3-bar w3-black" style="margin: 5px 5px 5px 5px;">
                    <button class="w3-bar-item btn btn-sm btn-success" onclick="openCity('Stock')">Stock</button>
                    <button class="w3-bar-item btn btn-sm btn-warning" onclick="openCity('Allocated')">Allocated</button>
                    <button class="w3-bar-item btn btn-sm btn-danger" onclick="openCity('Retiral')">Retiral</button>
                    <b id="tab_name"></b>
                </div> -->

                <!-- <div id="checkoutsuccess" class="display-none alert alert-success"><?php echo trans('lang.data_checkout_succeess');?></div>
                <div id="checkinsuccess"  class="display-none alert alert-success"><?php echo trans('lang.data_checkin_succeess');?></div>
                <div id="messagesuccess"  class="display-none alert alert-success"><?php echo trans('lang.data_added');?></div>
				<div id="messagedelete"  class="display-none alert alert-success"><?php echo trans('lang.data_deleted');?></div>
                <div id="messageretiral"  class="display-none alert alert-success">Moved to Retiral</div>
				<div id="messageupdate"  class="display-none alert alert-success"><?php echo trans('lang.data_updated');?></div> -->

                <div id="Stock" class="w3-container city">

                <div class="row pt-3" style="    margin: 0 5px 0 5px;">
                    <!-- <div class="col-md-6">
                        <h5 class="">Internal Audit</h5>
                    </div> -->

                    <form action="javascript:void(0)" id="scan_formadd" enctype="multipart/form-data" autocomplete="off" >
                        <input name="scan_assetid" type="text" id="scan_assetid" class="" placeholder="QR Code" autofocus required/>
                        <button type="submit" class="" id="scan_save_btn"><i class="fa fa-qrcode blink"></i>Submit</button>
<br>
                    <div id="form_resp"></div>

                    </form>
                    <div class="col-md-8 text-md-right pb-md-0 pb-3">

                    <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-11">
                            <div class="row">

                            <div class="col-md-4 choose_type_div">
                                <div class="form-group">
                                    <select  name="choose_type" id="choose_type" class="form-control nice_select select2" >
                                        <option value="All">All</option>
                                        <option value="Audited">Audited</option>
                                        <option value="Not Audited">Not Audited</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 choose_type_div">
                                <div class="form-group">
                                    <select  name="asset_location" id="asset_location" class="form-control nice_select select2" >
                                        <option value="" >Please Choose Location</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 choose_type_div">
                                <div class="form-group">
                                    <select  name="asset_typeid" id="asset_typeid" class="form-control nice_select select2" >
                                    <option value=""><?php echo trans('lang.assettype');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="col-md-1 choose_type_div">
                            <button class="btn btn-sm btn-warning" id="refresh_btn"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                        </div>

                        </div>
                    </div>
                    </div>

                </div>

                    <div class="card-body " style="padding: 0.5rem;">
                        <div class="table-responsive">
                            <table id="data_tb" class="table table-bordered" cellspacing="0" width="100%">
                                <h6>Records Found: <span class="total_res_show"></span> &nbsp;(<span id="filter_type_hint">All</span>)</h6>


                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.picture');?></th>
                                        <th>Details</th>
                                        <th><?php echo trans('lang.date');?></th>
                                        <th><?php echo trans('lang.cost');?></th>
                                        <th><?php echo trans('lang.description');?></th>
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.brand');?></th>
                                        <th>Emp</th>
                                        <th><?php echo trans('lang.location');?></th>
                                        <th><?php echo trans('lang.action');?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.picture');?></th>
                                        <th>Details</th>
                                        <th><?php echo trans('lang.date');?></th>
                                        <th><?php echo trans('lang.cost');?></th>
                                        <th><?php echo trans('lang.description');?></th>
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.brand');?></th>
                                        <th>Emp</th>
                                        <th><?php echo trans('lang.location');?></th>
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


    <!--add new data -->

    <!--end add data-->

    <script>
        var internal_audit_report_list="{{url('internal_audit_report_list')}}";
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



$(document).ready(function(){
    get_internal_audit_list('All',"","");
    get_location();
});

$("#refresh_btn").click(function(){
    location.reload();


})

var intervalId="";

// var intervalId = window.setInterval(function(){
// $("#scan_assetid").focus();
// }, 1000);

function processInfo(info) {
    var res_found = info.recordsDisplay;
    $('.total_res_show').text(res_found);
}

//get all asset type
// $.ajax({
//         type: "GET",
// 		url: "{{ url('listassettype')}}",
// 		dataType: "JSON",
// 		success: function(html) {
//             var objs = html.message;
//             jQuery.each(objs, function (index, record) {
//                 var id = decodeURIComponent(record.id);
//                 var name = decodeURIComponent(record.name);
//                 $("#asset_typeid").append($("<option></option>")
//                     .attr("value",id)
//                     .text(name));

//             });
// 		}
//     });

// location
    function get_location(){
        $.ajax({
        type: "POST",
		url: "{{ url('listlocation_select_b')}}",
		dataType: "JSON",
		success: function(html) {

            $("#asset_location").html(html.location_div);

		}
    });
    }

$("#asset_location").change(function(){

    var type=$("#choose_type").val();
    var location=$("#asset_location").val();

    $.ajax({
        type: "POST",
		url: "{{ url('listlocation_b_location')}}",
        data:{'location':location},
		dataType: "JSON",
		success: function(html) {
            $("#asset_typeid").html(html.asset_type_div);
            get_internal_audit_list(type,location,"");
		}
    });


})

$("#choose_type").change(function(){
    var location=$("#asset_location").val();
    var type=$("#choose_type").val();
    var asset_type=$("#asset_typeid").val();
    get_internal_audit_list(type,location,asset_type);
})

$("#asset_typeid").change(function(){
    var location=$("#asset_location").val();
    var type=$("#choose_type").val();
    var asset_type=$("#asset_typeid").val();
    get_internal_audit_list(type,location,asset_type);
})

function get_record(type){
get_internal_audit_list(type)
}

// $("#choose_type").focus(function(){
//     clearInterval(intervalId);
// });

// $("#choose_type").focusout(function(){
//     var intervalId = window.setInterval(function(){
//     $("#scan_assetid").focus();
//     }, 1000);
// });

function get_internal_audit_list(type,location,asset_type){

    $("#filter_type_hint").html(type);

    var filter_location=location;
    var filter_type=type;
    var asset_type=asset_type;


    table = $('#data_tb').DataTable({
        lengthMenu: [[10,50, 100, 200, 300, 400, 500, 1000, -1], [10,50, 100, 200, 300, 400, 500, 1000, "All"]],
        processing: true,
        serverSide: true,
        bDestroy: true,
        autoWidth: false,
        scrollX: true,
        iDisplayLength: 10,
        drawCallback : function() {
            processInfo(this.api().page.info());
        },

        ajax: {
            url: internal_audit_report_list,
            type: 'POST',
            data: function (data) {
                data.filter_location = filter_location;
                data.filter_type = filter_type;
                data.asset_type = asset_type;
                }
           },
        createdRow: function( row, data, dataIndex ) {
            if (data.bg_color == "red") {
                $(row).addClass('danger');
            }
            else{
                $(row).addClass('success');
            }
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
            // {
            //     data: 'assetid'
            // },
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
                data: 'name'
            },
            {
                data: 'type'
            },
            {
                data: 'brand'
            },
            {
                data: 'emp_detail'
            },
            {
                data: 'location'
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

}





$("#scan_formadd").submit(function(e){
    e.preventDefault();
    $("#scan_save_btn").attr("disabled","true");
    $("#scan_save_btn").html("Loading..");

    $.ajax({
        type: "POST",
        url: "{{ url('internal_audit_scan_save')}}",
        data: $("#scan_formadd").serialize(),
        dataType: "JSON",

        success: function (data) {

            if(data.response=="Success"){
                $("#form_resp").css("display","block");
                $("#form_resp").html('<h6 style="color:green;">'+data.assetid+' - Added Successfully..!</h6></b>');
                $("#form_resp").delay(3000).fadeOut(500);

                const audio = new Audio("http://hub1.cavinkare.in/Asset_Management_HEPL/public/upload/Success.mp3");
                audio.play();

                var filter_type=$("#filter_type_hint").html();
                get_internal_audit_list(filter_type);

            }
            else {
                $("#form_resp").css("display","block");
                $("#form_resp").html('<h6 style="color:red;">'+data.assetid+' - '+data.response
                +'</h6></b>');
                $("#form_resp").delay(3000).fadeOut(500);

                const audio = new Audio("http://hub1.cavinkare.in/Asset_Management_HEPL/public/upload/Windows%20error.mp3");
                audio.play();

            }
            $('#scan_formadd')[0].reset();

            $("#scan_save_btn").removeAttr("disabled");
            $("#scan_save_btn").html('<i class="fa fa-plus"></i>&nbsp;Submit');

        }
    })
})

</script>

<script>
    function openCity(cityName) {
    var i;
    var x = document.getElementsByClassName("city");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    document.getElementById(cityName).style.display = "block";
    }
</script>

@endsection
