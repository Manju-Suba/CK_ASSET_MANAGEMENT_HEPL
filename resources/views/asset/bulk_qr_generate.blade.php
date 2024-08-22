@extends('main')
@section('content')


<section class="">
    <div class="content p-1 pl-3">
        <div class="row pt-3"> 
            <div class="col-md-12">
                <h3 class="">QR Code Download</h3>
            </div>
            
            <div class="card-body">
                <form action="javascript:void(0)" id="bulk_download_form" method="POST" enctype="multipart/form-data">
                    <div class="row">
 
                      <div class="form-group col-md-3">
                        <label>From Asset Id</label>
                        <input type="text" name="from_assetid" id="from_assetid" class="form-control" placeholder="From Asset ID" required>
                      </div>

                      <div class="form-group col-md-3">
                        <label>To Asset Id</label>
                        <input type="text" name="to_assetid" id="to_assetid" class="form-control"  placeholder="To Asset ID" required>
                      </div>
                      <div class="form-group col-md-4" style="margin-top: 28px;">
                        <button type="submit" class="btn btn-primary " id="bulk_download_submit"><i class="fas fa-prescription-bottle-alt"></i>&nbsp;
                                Submit
                        </button>
                      </div>
                      <p id="bulk_up_resp" style="display:none;"></p>

                    </div>
                </form>
            </div>

        </div>

        
       
        
    </div>

</section>

<section class="">
    <div class="content p-1">

        <a class="btn btn-sm btn-success btn_download" id="btn_download" href="#" style="display:none;"><i class="fa fa-download" aria-hidden="true"></i> Download Code</a>
        <div id="qr_div_output" style="display:none;"></div>

        <input type="hidden" id="download_img_name">

            
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body ">
                    <div class="col selectedQrDownloadAction">
                        <button class="btn btn-md btn-primary float-right" id="getSelectedButton">QR <i class="fa fa-download" aria-hidden="true"></i></button>
                    </div>
                    <div id="messagesuccess"  class="display-none alert alert-success"><?php echo trans('lang.data_added');?></div>
					<div id="messagedelete"  class="display-none alert alert-success"><?php echo trans('lang.data_deleted');?></div>
					<div id="messageupdate"  class="display-none alert alert-success"><?php echo trans('lang.data_updated');?></div>
                        <div class="table-responsive">
                            <table id="data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="overall" name="overall" class="select-checkbox" /></th>
                                        <th>ID</th>
                                        <th>AssetId</th>
                                        <th>Emp Details</th>
                                        <th>QR</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>AssetId</th>
                                        <th>Emp Details</th>
                                        <th>QR</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot> -->
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div id="editor"></div>
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
"use strict";

    var table = $('#data').DataTable({
        ajax: "{{ url('get_allocated_qr_generate') }}",
        columns: [
            {
                data: 'checkbox',
                orderable: false,
                searchable: false,
            },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                visible: false
            },
            {
                data: 'asset_detail'
            },
            {
                data: 'emp_detail'
            },
            {
                data: 'qr'
            },
            {
                data: 'action'
            }
        ],
        buttons: [
            {
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info',
                title: '<?php echo trans('lang.brand_list'); ?>',
                exportOptions: {
                    columns: [1, 2, 3]
                },
                action: newexportaction,
            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info',
                title: '<?php echo trans('lang.brand_list'); ?>',
                exportOptions: {
                    columns: [1, 2, 3]
                },
                action: newexportaction,
            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info',
                title: '<?php echo trans('lang.brand_list'); ?>',
                orientation: 'landscape',
                exportOptions: {
                    columns: [1, 2, 3]
                },
                action: newexportaction,
                customize: function (doc) {
                    doc.styles.tableHeader.alignment = 'left';
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            },
            {
                extend: 'print',
                title: '<?php echo trans('lang.brand_list'); ?>',
                className: 'btn btn-sm btn-fill btn-info',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    columns: [1, 2, 3]
                },
                action: newexportaction,
            }
        ]
    });

    $('.selectedQrDownloadAction').css('display','none');


    // // Event listener for checkbox change
    $('#data tbody').on('change', 'input.select-checkbox', function () {
        toggleActionButtons();
        var values = getSelectedCheckboxValues();
        if (values.length > 0) {
            $('.selectedQrDownloadAction').css('display','block');
        }else{
            $('.selectedQrDownloadAction').css('display','none');
        }
    });

    // Handle row checkbox click to maintain state of header checkbox
    // $('#data tbody').on('change', 'input.select-checkbox', function () {
    //     if (!this.checked) {
    //         $('input#overall').prop('checked', false);
    //     } else {
    //         var allChecked = true;
    //         $('#data tbody input.select-checkbox').each(function () {
    //             if (!this.checked) {
    //                 allChecked = false;
    //             }
    //         });
    //         $('input#overall').prop('checked', allChecked);
    //     }
    // });

   // Handle header checkbox click
   $('#data thead').on('change', 'input#overall', function () {
        var checked = this.checked;
        $('#data tbody input.select-checkbox').each(function () {
            this.checked = checked;
        });

        var values = getSelectedCheckboxValues();
        if (values.length > 0) {
            $('.selectedQrDownloadAction').css('display','block');
        }else{
            $('.selectedQrDownloadAction').css('display','none');
        }
        toggleActionButtons();
    });


    // // Function to enable/disable action buttons
    function toggleActionButtons() {
        $('#data tbody tr').each(function () {
            var rowCheckbox = $(this).find('input.select-checkbox');
            var actionButtons = $(this).find('.row-action');

            if (rowCheckbox.is(':checked')) {
                actionButtons.css('pointer-events', 'none');
                actionButtons.attr("disabled","true");
            } else {
                actionButtons.css('pointer-events', 'auto');
                actionButtons.removeAttr("disabled");
            }
        });

        var anyChecked = $('#data tbody input.select-checkbox:checked').length > 0;
        $('.action-button').prop('disabled', !anyChecked);
    }

    // // Initial call to disable buttons on page load if no checkboxes are checked
    // toggleActionButtons();


})(jQuery);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

<script>

    function getSelectedCheckboxValues() {
        var selectedValues = [];
        $('#data tbody input.select-checkbox:checked').each(function() {
            selectedValues.push($(this).data('id'));
        });
        return selectedValues;
    }

    // Event listener for a button to get selected values
    $('#getSelectedButton').on('click', function() {
        $("#getSelectedButton").html('Processing...');

        var selectedValues = getSelectedCheckboxValues();
        $.ajax({
            type: "POST",
            url: "{{ url('selected_row_qr_generate')}}",
            data: {ids:selectedValues},
            success: function (data) {
                if(data.response=="Success"){
                    var datas = JSON.parse(data.data); // Parse the JSON string into an array
                    bulk_qr_download(datas);
                    window.setTimeout(function() {
                        location.reload()
                    }, 2000)
                }

                $("#getSelectedButton").removeAttr("disabled");
                $("#getSelectedButton").html('Submit');
            }
        })

    });


    $("#bulk_download_form").submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);

        $("#bulk_download_submit").attr("disabled","true");
        $("#bulk_download_submit").html("Loading..");

        $.ajax({
            type: "POST",
            url: "{{ url('bulk_qr_generate')}}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function (data) {
                if(data.response=="Success"){

                    var datas = JSON.parse(data.data); // Parse the JSON string into an array
                    bulk_qr_download(datas);

                    setTimeout(function() {
                        $("#bulk_up_resp").css("display","block");
                        $("#bulk_up_resp").html('<b style="color:green;">QR Printed Successfully..!</b>');
                        $("#bulk_up_resp").delay(3000).fadeOut(500);
                        $('#bulk_download_form')[0].reset();
                        location.reload();
                    }, 500);
                }
                else {
                    $("#bulk_up_resp").css("display","block");
                    $("#bulk_up_resp").html('<b style="color:red;">Something went wrong!</b><p>note: this is an order range bulk print.</p>');
                    $("#bulk_up_resp").delay(3000).fadeOut(500);
                }

                $("#bulk_download_submit").removeAttr("disabled");
                $("#bulk_download_submit").html('Submit');
            }
        })
    })


    var doc = new jsPDF();
    var specialElementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };


    function download_row_qr(code){
        qr_popup($("#qr_div_img" + code).html(),$("#qr_div" + code).html() , $("#qr_entity_name" + code).html() , $("#qr_emp_id" + code).html() , 
                $("#qr_emp_name" + code).html() , $("#qr_sn" + code).html(), $("#qr_support_no" + code).html(), $("#asset_id" + code).html(), $("#qr_support_email" + code).html());
        // Popup($("#qr_div_img"+code).html(),$("#qr_div_name"+code).html(),$("#qr_div_code"+code).html(),$("#qr_div"+code).html());
    }


    function qr_popup(imgSrc, full_div, entitname, emp_id, emp_name, sn, support_no, assetId, support_email) {

        if(entitname == "CKPL"){
            var entityname = "Cavinkare";
        }else{
            var entityname = entitname;
        }

        var mywindow = window.open('', 'PRINT', 'height=200,width=400');
        mywindow.document.write('<html><head><title>Print Preview</title>');
        mywindow.document.write('<style>');
        mywindow.document.write('@page { size: auto; }');
        mywindow.document.write('body { font-family: Arial, sans-serif; margin: 0; display: flex; justify-content: center; align-items: center; height: 100%; }');
        mywindow.document.write('.container { border: 1px solid black; padding: 1mm; display: flex; flex-direction: column; width: 100%; height: 100%; box-sizing: border-box; justify-content: center; }');
        mywindow.document.write('.row { display: flex; align-items: center; width: 100%; margin-bottom: 1mm; }'); // Added margin-bottom to rows
        mywindow.document.write('.left { width: 30%; padding-left: 1mm; display: flex; align-items: center; }'); // Ensured flex and alignment
        mywindow.document.write('.left2 { width: 40%; text-align: left; font-size: 2.5mm; margin-left: 1mm; display: flex; align-items: center; }'); // Ensured flex and alignment
        mywindow.document.write('.barcode { width: 10mm; height: 10mm; }'); // Adjusted width and height to fit better
        mywindow.document.write('.right { width: 70%; padding-top: 1mm; padding-left: 3mm; display: flex; flex-direction: column;}'); // Removed margin-bottom
        mywindow.document.write('.right2 { width: 60%; padding-left: 0; text-align: left; display: flex; align-items: center; }'); // Adjusted for inline layout
        mywindow.document.write('.qrcss { font-size: 2.5mm; margin: 0; } b { font-size: 2.8mm; }');
        mywindow.document.write('.leftcss { padding-bottom: 1mm; }');
        mywindow.document.write('.support { font-size: 2.5mm; font-weight: bold; margin-top: 0; margin-left: 0; }'); // Adjusted margin
        mywindow.document.write('.supportmail { font-size: 2.2mm; font-weight: bold; margin-top: 1mm; }');
        mywindow.document.write('</style>');
        mywindow.document.write('</head><body>');
        mywindow.document.write('<div class="container">');

        mywindow.document.write('<div class="row">');
        mywindow.document.write('<div class="left">');
        mywindow.document.write('<div class="barcode">' + imgSrc + '</div>');
        mywindow.document.write('</div>');
        mywindow.document.write('<div class="right">');
        mywindow.document.write('<div class="qrcss leftcss"><b>' + entityname + '</b></div>');
        mywindow.document.write('<div class="qrcss leftcss">SL# : <b>' + sn + '</b></div>');
        mywindow.document.write('<div class="qrcss">Asset ID : <b>' + assetId + '</b></div>');
        mywindow.document.write('</div>');
        mywindow.document.write('</div>');

        mywindow.document.write('<div class="row" style="margin-top:2mm; margin-left: 0;">');
        mywindow.document.write('<div class="left2">');
        mywindow.document.write('<div style="padding-left:2mm;">IT Helpdesk :</div>');
        mywindow.document.write('</div>');
        mywindow.document.write('<div class="right2">');
        mywindow.document.write('<div class="support"><b>' + support_no + '</b></div>');
        mywindow.document.write('</div>');
        mywindow.document.write('</div>');

        mywindow.document.write('<div class="row" style="margin-top:-1.5mm;" >');
        mywindow.document.write('<div class="left2"></div>');
        mywindow.document.write('<div class="right2">');
        mywindow.document.write('<div class="supportmail">' + support_email + '</div>');
        mywindow.document.write('</div>');
        mywindow.document.write('</div>');

        mywindow.document.write('</div>');
        mywindow.document.write('</body></html>');

        mywindow.document.close();
        mywindow.focus();

        setTimeout(function() {
            mywindow.print();
            mywindow.close();
        }, 500);

        return true;
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


    function bulk_qr_download(data) {
        var mywindow = window.open('', 'PRINT', 'height=200,width=400');
        mywindow.document.write('<html><head><title>Print Preview</title>');
        mywindow.document.write('<style>');
        mywindow.document.write('@page { size: auto; }');
        mywindow.document.write('body { font-family: Arial, sans-serif; }');
        // mywindow.document.write('.container { padding: 1mm; display: flex; flex-direction: column; width: 100%; height: 100%;  }'); // Set fixed width and page break after
        mywindow.document.write('.container { padding: 10px; display: flex; flex-direction: column; width: 100%; }');
        mywindow.document.write('.row { display: flex; align-items: center;width: 100%; margin-bottom: 1mm; }');
        mywindow.document.write('.left { width: 28%; padding-left: 1mm; display: flex; align-items: center; }');
        mywindow.document.write('.left2 { width: 40%; text-align: left; font-size: 2.5mm; margin-left: 1mm; display: flex; align-items: center; }');
        mywindow.document.write('.barcode {width: 10mm; height: 10mm; }');
        mywindow.document.write('.right { width: 72%; padding-left: 3mm; padding-top: 1mm; flex-direction: column;}');
        mywindow.document.write('.right2 { width: 60%; padding-left: 0; text-align: left;display: flex; align-items: center; }');
        mywindow.document.write('.qrcss { font-size: 2.5mm; margin: 0; } b{ font-size: 2.8mm; }');
        mywindow.document.write('.leftcss { padding-bottom: 1mm; }');

        mywindow.document.write('.support { font-size: 2.5mm; font-weight: bold; margin-top: 0; margin-left: 0;}');
        mywindow.document.write('.supportmail { font-size: 2.2mm; font-weight: bold; margin-top: 1mm; }');
        mywindow.document.write('</style>');
        mywindow.document.write('</head><body>');

        data.forEach(function(record, index) {

            if(record.entityname == "CKPL"){
                var entityname = "Cavinkare";
            }else{
                var entityname = entitname;
            }
            // Ensure the last page does not have a page break after
            mywindow.document.write('<div class="container">');
            mywindow.document.write('<div class="row">');
            mywindow.document.write('<div class="left">');
            mywindow.document.write('<div class="barcode">'+ record.img + '</div>');
            mywindow.document.write('</div>');
            mywindow.document.write('<div class="right">');
            mywindow.document.write('<div class="qrcss leftcss"><b>' + entityname + '</b></div>');
            mywindow.document.write('<div class="qrcss leftcss">SL# :&nbsp;<b>' + record.sn + '</b></div>');
            mywindow.document.write('<div class="qrcss">Asset ID :&nbsp;<b>' + record.assetid + '</b></div>');
            mywindow.document.write('</div>');
            mywindow.document.write('</div>');

            mywindow.document.write('<div class="row" style="margin-top:2mm; margin-left: 0;" >');
            mywindow.document.write('<div class="left2" >');
            mywindow.document.write('<div style="padding-left:2mm;">IT Helpdesk : </div>');
            mywindow.document.write('</div>');
            mywindow.document.write('<div class="right2" style="padding-left:0;">');
            mywindow.document.write('<div class="support"><b>' + record.support_no + '</b></div>');
            mywindow.document.write('</div>');
            mywindow.document.write('</div>');

            mywindow.document.write('<div class="row" style="margin-top:-1.5mm;" >');
            mywindow.document.write('<div class="left2"></div>');
            mywindow.document.write('<div class="right2">');
            mywindow.document.write('<div class="supportmail">' + record.support_email + '</div>');
            mywindow.document.write('</div>');
            mywindow.document.write('</div>');

            mywindow.document.write('</div>');
        });

        mywindow.document.write('</body></html>');
        mywindow.document.close();
        mywindow.focus();

        setTimeout(function() {
            mywindow.print();
            mywindow.close();
        }, 500); // Delay in milliseconds

        return true;
    }


// $("#btn_download").on('click', function() {

//     // alert();
//             var imgageData = getCanvas.toDataURL("image/png");
                                                                                                
//             // Now browser starts downloading 
//             // it instead of just showing it
//             var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                                                                                                
//             var canvas_name=$("#download_img_name").val();

//             $("#btn_download").attr("download", canvas_name+".png").attr("href", newData);
//             // $("#btn_download").click();

//     });


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
                    
                // $.each(data.data, function(index, value) {
                    // alert(value.asset_code);


                    // mywindow.document.write('<table style="margin:20px 0 100px 15px">');
                    // mywindow.document.write('<tr>');
                    // mywindow.document.write('<td style="width:20px; ">');
                    // mywindow.document.write('<img src="http://hub1.cavinkare.in/Asset_Management_HEPL/public/index.php/upload/cropped-Hema-logo-1.png" style="width:100%;">');
                    // mywindow.document.write('</td>');
                    // mywindow.document.write('<td style="width:300px;">');
                    // mywindow.document.write(value.asset_name);
                    // mywindow.document.write('</br>');
                    // mywindow.document.write(value.asset_code);
                    // mywindow.document.write('</td>');
                    // mywindow.document.write('</tr>');
                    // mywindow.document.write('</table>');

                    // a++;

                // });

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

            $.ajax({
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

@endsection