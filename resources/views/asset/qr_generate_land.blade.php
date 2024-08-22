@extends('main')
@section('content')




<section class="">
    <div class="content p-1">
        <div class="row pt-3"> 
            <div class="col-md-3">
                <h3 class="">QR</h3>
            </div>
            
            <div class="card-body">
                  <form action="javascript:void(0)" id="bulk_upload_form" method="POST" enctype="multipart/form-data">
                  <div class="row">
 
                      <div class="form-group col-md-6">
                        <!-- <label>Choose file</label> -->
                        <input type="file" name="import_file" id="import_file" class="form-control" required>
                      </div>

                    <p id="bulk_up_resp" style="display:none;"></p>
                              
                      <div class="form-group col-md-4">
                        <button type="submit" class="btn btn-primary " id="bulk_upload_form_submit"><i class="fas fa-prescription-bottle-alt"></i>&nbsp;
                                Submit  
                        </button> 
                      </div>
                  </div>
                  </form>
            </div>  

        </div>

        
       
        
    </div>

</section>

<section class="">
    <div class="content p-1">
        <!-- <div class="row pt-3"> -->

        <div class="row pt-3">
            <!-- <div class="col-md-6">
                <h3 class=""><?php echo trans('lang.brand_list');?></h3>
            </div> -->
            <!-- <div class="col-md-6 text-md-right pb-md-0 pb-3"> -->
            <!-- <button type="button" id="download_all_btn" class="btn btn-sm btn-fill btn-primary"> Download All</button> -->

            <!-- <button type="button" id="download_all_btn" class="btn btn-sm btn-fill btn-primary"> Download All</button> -->


            </div>
        </div>

        <a class="btn btn-sm btn-success btn_download" id="btn_download" href="#" style="display:none;"><i class="fa fa-download" aria-hidden="true"></i> Download Code</a>
        <div id="qr_div_output" style="display:none;"></div> 

        <input type="hidden" id="download_img_name">

            
        <!-- </div> -->
       
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
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.description');?></th>
                                        <th>QR</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.description');?></th>
                                        <th>QR</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div id="editor"></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">

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

    $('#data').DataTable({
        ajax: "{{ url('get_temp_qr')}}",
        columns: [{
            data: 'id',
                orderable: false,
                searchable: false,
                visible: false
            },
           
            {
                data: 'asset_code' 
            },
            {
                data: 'asset_name'
            },
            {
                data: 'qr'
            },
            {
                data: 'action'
            },
            
        ],
       
        buttons: [{
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.brand_list ');?>',
                exportOptions: {
                    columns: [1, 2,3]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.brand_list');?>',
                exportOptions: {
                    columns: [1, 2,3]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.brand_list');?>',
                orientation: 'landscape',
                exportOptions: {
                    columns: [1, 2,3]
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
                title: '<?php echo trans('lang.brand_list');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    columns: [1, 2,3]
                },
                action: newexportaction,

            }
        ]
    });




})(jQuery);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script>

    
$("#bulk_upload_form").submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);

    // $("#bulk_upload_form_submit").attr("disabled","true");
    // $("#bulk_upload_form_submit").html("Loading..");

    var import_file=$("#import_file")[0];
    formData.append('upload_file', import_file.files[0]);


    $.ajax({  
        type: "POST",
        url: "{{ url('qr_bulk_generate')}}", 
        data: formData,   
        cache:false,
        contentType: false,
        processData: false,

        success: function (data) {

            if(data.response=="Success"){
                $("#bulk_up_resp").css("display","block");
                $("#bulk_up_resp").html('<b style="color:green;">Added Successfully..!</b></b>');
                $("#bulk_up_resp").delay(3000).fadeOut(500);
                $('#bulk_upload_form')[0].reset();
                location.reload();
            }
            else {
                $("#bulk_up_resp").css("display","block");
                $("#bulk_up_resp").html('<b style="color:red;">Not Added..</b></b>');
                $("#bulk_up_resp").delay(3000).fadeOut(500);
            }

            $("#bulk_upload_form_submit").removeAttr("disabled");
            $("#bulk_upload_form_submit").html('<i class="fas fa-prescription-bottle-alt"></i>&nbsp;Add Ambassador');
            
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

    Popup($("#qr_div_img"+code).html(),$("#qr_div_name"+code).html(),$("#qr_div_code"+code).html(),$("#qr_div"+code).html());
    
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

            $.ajax(
            {
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