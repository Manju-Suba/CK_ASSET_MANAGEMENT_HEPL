@extends('main')
@section('content')

<section class="">
    <div class="content p-4">
        <div class="row pt-3">
            <div class="col-md-6">
                <h3 class=""><?php echo trans('lang.component_list');?></h3>
            </div>
            <div class="col-md-6 text-md-right pb-md-0 pb-3">
            <button type="button" data-toggle="modal" data-target="#add" class="btn btn-sm btn-fill btn-primary"><i class="fa fa-plus"></i> <?php echo trans('lang.add_data');?></button>
            </div>
        </div>
       
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body ">
                    <div id="checkoutsuccess"  class="display-none alert alert-success"><?php echo trans('lang.data_checkout_succeess');?></div>
                    <div id="checkinsuccess"  class="display-none alert alert-success"><?php echo trans('lang.data_checkin_succeess');?></div>
                    <div id="messagesuccess"  class="display-none alert alert-success"><?php echo trans('lang.data_added');?></div>
					<div id="messagedelete"  class="display-none alert alert-success"><?php echo trans('lang.data_deleted');?></div>
					<div id="messageupdate"  class="display-none alert alert-success"><?php echo trans('lang.data_updated');?></div>
                        <div class="table-responsive">
                            <table id="data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.picture');?></th>
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.serial');?></th>
                                        <th><?php echo trans('lang.purchasedate');?></th>
                                        <th><?php echo trans('lang.cost');?></th>
                                        <th><?php echo trans('lang.description');?></th>
                                        <th><?php echo trans('lang.location');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.brand');?></th>
                                        <th><?php echo trans('lang.quantity');?></th>
                                        <th><?php echo trans('lang.avalaiblequantity');?></th>
                                        <th><?php echo trans('lang.action');?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th><?php echo trans('lang.picture');?></th>
                                        <th><?php echo trans('lang.name');?></th>
                                        <th><?php echo trans('lang.serial');?></th>
                                        <th><?php echo trans('lang.purchasedate');?></th>
                                        <th><?php echo trans('lang.cost');?></th>
                                        <th><?php echo trans('lang.description');?></th>
                                        <th><?php echo trans('lang.location');?></th>
                                        <th><?php echo trans('lang.type');?></th>
                                        <th><?php echo trans('lang.brand');?></th>
                                        <th><?php echo trans('lang.quantity');?></th>
                                        <th><?php echo trans('lang.avalaiblequantity');?></th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="#" id="formadd" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                       
                        <h5 class="modal-title"><?php echo trans('lang.add_data');?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label><?php echo trans('lang.name');?></label>
                                <input name="name" type="text" id="name" class=" form-control" required placeholder="<?php echo trans('lang.name');?>"/>
                            </div>
                            
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><?php echo trans('lang.serial');?></label>
                                <input name="serial" type="text" id="serial" class="form-control " required placeholder="<?php echo trans('lang.serial');?>"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?php echo trans('lang.quantity');?></label>
                                <input name="quantity" type="text" id="quantity" class="form-control " required placeholder="<?php echo trans('lang.quantity');?>"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><?php echo trans('lang.supplier');?></label>
                                <select name="supplierid" id="supplierid" required class="form-control">
                                    <option value=""><?php echo trans('lang.supplier');?></option> 
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?php echo trans('lang.assettype');?></label>
                                <select name="typeid" id="typeid" required class="form-control">
                                    <option value=""><?php echo trans('lang.assettype');?></option> 
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><?php echo trans('lang.location');?></label>
                                <select name="locationid" id="locationid" required class="form-control">
                                    <option value=""><?php echo trans('lang.location');?></option> 
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                            <label><?php echo trans('lang.brand');?></label>
                                <select name="brandid" id="brandid" required class="form-control">
                                    <option value=""><?php echo trans('lang.brand');?></option>
                                </select>
                            </div>
                        </div>
                       
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0" >
								<label for="cost" class="control-label"><?php echo trans('lang.cost');?></label> 
								<div class="input-group mb-0" >
									<span class="input-group-addon setcurrency border-1" id="currency" ></span>                                      
									<input class="form-control number" required="" placeholder="<?php echo trans('lang.cost');?>" id="cost" name="cost" type="text">
								</div>
                                <label class="error" for="cost"></label>
							</div>
                            <div class="form-group col-md-6 mb-0" >
                                    <label for="purchasedate" class="control-label"><?php echo trans('lang.purchasedate');?></label>     
                                    <div class="input-group mb-0" >                       
									<input class="form-control setdate" required="" placeholder="<?php echo trans('lang.purchasedate');?>" id="purchasedate" name="purchasedate" type="text">
                                    <span class="input-group-addon border-1" id="date" ><i class="fa fa-calendar"></i></span>      
                                </div>
                                <label class="error" for="purchasedate"></label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0" >
                            <label for="warranty" class="control-label"><?php echo trans('lang.warranty');?></label> 
								<div class="input-group mb-0" >                                    
									<input class="form-control number" required="" placeholder="<?php echo trans('lang.warranty');?>" id="warranty" name="warranty" type="text">
                                    <span class="input-group-addon border-1" id="warrantyyear" ><?php echo trans('lang.month');?></span>
                                </div>
                                <label class="error" for="warranty"></label>
                            </div>
                            <div class="form-group col-md-6 mb-0" >
                            <label><?php echo trans('lang.status');?></label>
                            <select name="status" id="status" required class="form-control">
                                <option value=""><?php echo trans('lang.status');?></option>
                                <option value="1"><?php echo trans('lang.readytodeploy');?></option>
                                <option value="2"><?php echo trans('lang.pending');?></option>
                                <option value="3"><?php echo trans('lang.archived');?></option>
                                <option value="4"><?php echo trans('lang.broken');?></option>
                                <option value="5"><?php echo trans('lang.lost');?></option>
                                <option value="6"><?php echo trans('lang.outofrepair');?></option>
                            </select>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label><?php echo trans('lang.description');?></label>
                            <textarea class="form-control" name="description" id="description" placeholder="<?php echo trans('lang.description');?>"></textarea>
                        </div>
                       
                        <div class="form-group">
                            <label><?php echo trans('lang.picture');?></label>
                            <input name="picture" type="file" id="picture" class=" form-control"  placeholder="<?php echo trans('lang.picture');?>"/>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="#" id="formedit" enctype="multipart/form-data">
                    <div class="modal-header">
                       
                        <h5 class="modal-title"><?php echo trans('lang.edit_data');?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                   
                    <div class="form-row">
                            <div class="form-group col-md-12">
                                <label><?php echo trans('lang.name');?></label>
                                <input name="name" type="text" id="editname" class=" form-control" required placeholder="<?php echo trans('lang.name');?>"/>
                            </div>
                            
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><?php echo trans('lang.serial');?></label>
                                <input name="serial" type="text" id="editserial" class="form-control " required placeholder="<?php echo trans('lang.serial');?>"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?php echo trans('lang.quantity');?></label>
                                <input name="quantity" type="text" id="editquantity" class="form-control " required placeholder="<?php echo trans('lang.quantity');?>"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><?php echo trans('lang.supplier');?></label>
                                <select name="supplierid" id="editsupplierid" required class="form-control">
                                    <option value=""><?php echo trans('lang.supplier');?></option> 
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?php echo trans('lang.assettype');?></label>
                                <select name="typeid" id="edittypeid" required class="form-control">
                                    <option value=""><?php echo trans('lang.assettype');?></option> 
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><?php echo trans('lang.location');?></label>
                                <select name="locationid" id="editlocationid" required class="form-control">
                                    <option value=""><?php echo trans('lang.location');?></option> 
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                            <label><?php echo trans('lang.brand');?></label>
                                <select name="brandid" id="editbrandid" required class="form-control">
                                    <option value=""><?php echo trans('lang.brand');?></option>
                                </select>
                            </div>
                        </div>
                       
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0" >
								<label for="cost" class="control-label"><?php echo trans('lang.cost');?></label> 
								<div class="input-group mb-0" >
									<span class="input-group-addon setcurrency border-1" id="currency" ></span>                                      
									<input class="form-control number" required="" placeholder="<?php echo trans('lang.cost');?>" id="editcost" name="cost" type="text">
								</div>
                                <label class="error" for="cost"></label>
							</div>
                            <div class="form-group col-md-6 mb-0" >
                                    <label for="purchasedate" class="control-label"><?php echo trans('lang.purchasedate');?></label>     
                                    <div class="input-group mb-0" >                       
									<input class="form-control setdate" required="" placeholder="<?php echo trans('lang.purchasedate');?>" id="editpurchasedate" name="purchasedate" type="text">
                                    <span class="input-group-addon border-1" id="date" ><i class="fa fa-calendar"></i></span>      
                                </div>
                                <label class="error" for="purchasedate"></label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0" >
                            <label for="warranty" class="control-label"><?php echo trans('lang.warranty');?></label> 
								<div class="input-group mb-0" >                                    
									<input class="form-control number" required="" placeholder="<?php echo trans('lang.warranty');?>" id="editwarranty" name="warranty" type="text">
                                    <span class="input-group-addon border-1" id="editwarrantyyear" ><?php echo trans('lang.month');?></span>
                                </div>
                                <label class="error" for="warranty"></label>
                            </div>
                            <div class="form-group col-md-6 mb-0" >
                            <label><?php echo trans('lang.status');?></label>
                            <select name="status" id="editstatus" required class="form-control">
                                <option value=""><?php echo trans('lang.status');?></option>
                                <option value="1"><?php echo trans('lang.readytodeploy');?></option>
                                <option value="2"><?php echo trans('lang.pending');?></option>
                                <option value="3"><?php echo trans('lang.archived');?></option>
                                <option value="4"><?php echo trans('lang.broken');?></option>
                                <option value="5"><?php echo trans('lang.lost');?></option>
                                <option value="6"><?php echo trans('lang.outofrepair');?></option>
                            </select>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label><?php echo trans('lang.description');?></label>
                            <textarea class="form-control" name="description" id="editdescription" placeholder="<?php echo trans('lang.description');?>"></textarea>
                        </div>
                       
                        <div class="form-group">
                            <label><?php echo trans('lang.picture');?></label>
                            <input name="picture" type="file" id="editpicture" class=" form-control"  placeholder="<?php echo trans('lang.picture');?>"/>
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



    <!--add checkout -->
     <div id="checkout" class="modal fade" role="dialog" >
        <div class="modal-dialog ">
            <div class="modal-content">

                <form action="#" id="formcheckout" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        
                        <h5 class="modal-title"><?php echo trans('lang.checkout');?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                         <div id="checkoutfailed"  class=" display-none alert alert-success"><?php echo trans('lang.data_checkout_failed_quantity');?></div>
                        <div class="form-row">
                           
                            <div class="form-group col-md-12">
                                <label><?php echo trans('lang.component');?></label>
                                <input name="component" type="text" readonly id="checkoutname" class=" form-control" required placeholder="<?php echo trans('lang.component');?>"/>
                            </div>
                            
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label><?php echo trans('lang.checkoutto');?></label>
                                <select name="assetid" id="checkoutassetid" required class="form-control">
                                    <option value=""><?php echo trans('lang.asset');?></option> 
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label><?php echo trans('lang.quantity');?></label>
                                <input name="quantity" type="text" id="checkoutquantity" class=" form-control" required placeholder="<?php echo trans('lang.quantity');?>"/>
                            </div>
                        </div>
                       
                        <div class="form-row">
                            <div class="form-group col-md-12 mb-0" >
                                    <label for="checkoutdate" class="control-label"><?php echo trans('lang.checkoutdate');?></label>     
                                    <div class="input-group mb-0" >                       
                                    <input class="form-control setdate" required="" placeholder="<?php echo trans('lang.checkoutdate');?>" id="checkoutdate" name="checkoutdate" type="text">
                                    <span class="input-group-addon border-1" id="date" ><i class="fa fa-calendar"></i></span>      
                                </div>
                                <label class="error" for="checkoutdate"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <input type="hidden" name="componentid" id="checkoutcomponentid"/>
                        <button type="submit" class="btn btn-primary"
                            id="savecheckout"><?php echo trans('lang.save');?></button>
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo trans('lang.close');?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end checkout-->


     

    
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
                <div  class="display-none messageexist alert alert-success"><?php echo trans('lang.errordeletecomponent');?></div>
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
    $('#data').DataTable({
        ajax: "{{ url('component')}}",
        columns: [{
            data: 'id',
                orderable: false,
                searchable: false,
                visible: false
            },
            
            {
                data: 'pictures'
            },
           
            {
                data: 'name'
            },
            {
            data: 'serial',
                orderable: false,
                searchable: false,
                visible: false
            },
             {
            data: 'purchasedate',
                orderable: false,
                searchable: false,
                visible: false
            },
             {
            data: 'cost',
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
            data: 'location',
                orderable: false,
                searchable: false,
                visible: false
            },
            {
                data: 'type'
            },
            {
                data: 'brand'
            },
            {
                data: 'quantity'
            },
            {
                data: 'avalaiblequantity'
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ],
        dom: "<'row'<'col-sm-9 text-left'B><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-2'l><'col-sm-5'i><'col-sm-5'p>>",
        buttons: [{
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.component_list ');?>',
                exportOptions: {
                    columns: [2, 3, 4 ,5, 6, 7 ,8, 9, 10, 11]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.component_list');?>',
                exportOptions: {
                    columns: [2, 3, 4 ,5, 6, 7 ,8, 9, 10, 11]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.component_list');?>',
                orientation: 'landscape',
                exportOptions: {
                    columns: [2, 3, 4 ,5, 6, 7 ,8, 9, 10, 11]
                },
                action: newexportaction,

                customize: function(doc) {
                    doc.styles.tableHeader.alignment = 'left';
                    
                }
            },
            {
                extend: 'print',
                title: '<?php echo trans('lang.component_list');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    columns: [2, 3, 4 ,5, 6, 7 ,8, 9, 10, 11]
                },
                action: newexportaction,

            }
        ]
    });


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


//get all asset type
$.ajax({
        type: "GET",
		url: "{{ url('listassettype')}}",
		dataType: "JSON",
		success: function(html) {
            var objs = html.message;
            jQuery.each(objs, function (index, record) {
                var id = decodeURIComponent(record.id);
                var name = decodeURIComponent(record.name);
                $("#typeid").append($("<option></option>")
                    .attr("value",id)
                    .text(name)); 
                $("#edittypeid").append($("<option></option>")
                    .attr("value",id)
                    .text(name));     
            });
		}   
    }); 

//get all brand 
$.ajax({
        type: "GET",
		url: "{{ url('listbrand')}}",
		dataType: "JSON",
		success: function(html) {
            var objs = html.message;
            jQuery.each(objs, function (index, record) {
                var id = decodeURIComponent(record.id);
                var name = decodeURIComponent(record.name);
                $("#brandid").append($("<option></option>")
                    .attr("value",id)
                    .text(name)); 
                $("#editbrandid").append($("<option></option>")
                    .attr("value",id)
                    .text(name));     
            });
		}   
    }); 

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
                $("#editlocationid").append($("<option></option>")
                    .attr("value",id)
                    .text(name));     
            });
		}   
    });     

//get all asset list
$.ajax({
        type: "GET",
        url: "{{ url('listasset')}}",
        dataType: "JSON",
        success: function(html) {
            var objs = html.message;
            jQuery.each(objs, function (index, record) {
                var id = decodeURIComponent(record.id);
                var name = decodeURIComponent(record.name);
                
                $("#checkoutassetid").append($("<option></option>")
                    .attr("value",id)
                    .text(name)); 
            });
        }   
    }); 

//add data
$("#formadd").validate({
    rules: {
      quantity: {
        required: true,
        digits: true
      },
      warranty: {
        required: true,
        digits: true,
        maxlength:2
      }
    },
    submitHandler: function(form) {
        var form = new FormData();
        var name                = $("#name").val();
        var locationid          = $("#locationid").val();
		var supplierid          = $("#supplierid").val();
		var typeid              = $("#typeid").val();
		var brandid             = $("#brandid").val();
        var serial              = $("#serial").val();
        var quantity            = $("#quantity").val();
        var purchasedate        = $("#purchasedate").val();
        var cost                = $("#cost").val();
        var warranty            = $("#warranty").val();
        var status              = $("#status").val();
        var description         = $("#description").val();
		var picture             = $('#picture')[0].files[0];
		
        form.append('name', name);
        form.append('locationid', locationid);
		form.append('supplierid', supplierid);
		form.append('brandid', brandid);
		form.append('typeid', typeid);
        form.append('serial', serial);
        form.append('quantity', quantity);
        form.append('purchasedate', purchasedate);
        form.append('cost', cost);
        form.append('warranty', warranty);
        form.append('status', status);
        form.append('description', description);
        form.append('picture', picture);
        
        $.ajax({
			type: "POST",
            url: "{{ url('savecomponent')}}",
            data: form,
			contentType: 'multipart/form-data',
			processData: false,
            contentType: false,
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
      quantity: {
        required: true,
        digits: true
      },
      warranty: {
        required: true,
        digits: true,
        maxlength:2
      }
    },
    submitHandler: function(form) {
        var form = new FormData();
        var id                  = $("#editid").val();
        var name                = $("#editname").val();
        var locationid          = $("#editlocationid").val();
		var supplierid          = $("#editsupplierid").val();
		var typeid              = $("#edittypeid").val();
		var brandid             = $("#editbrandid").val();
        var serial              = $("#editserial").val();
        var quantity            = $("#editquantity").val();
        var purchasedate        = $("#editpurchasedate").val();
        var cost                = $("#editcost").val();
        var warranty            = $("#editwarranty").val();
        var status              = $("#editstatus").val();
        var description         = $("#editdescription").val();
		var picture             = $('#editpicture')[0].files[0];
		
        form.append('name', name);
        form.append('id', id);
        form.append('locationid', locationid);
		form.append('supplierid', supplierid);
		form.append('brandid', brandid);
		form.append('typeid', typeid);
        form.append('serial', serial);
        form.append('quantity', quantity);
        form.append('purchasedate', purchasedate);
        form.append('cost', cost);
        form.append('warranty', warranty);
        form.append('status', status);
        form.append('description', description);
        form.append('picture', picture);

        $.ajax({
			type: "POST",
            url: "{{ url('updatecomponent')}}",
            data: form,
			contentType: 'multipart/form-data',
			processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
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
            url: "{{ url('deletecomponent')}}",
            data: $("#formdelete").serialize(),
            dataType: "JSON",
            success: function(data) {
                console.log(data.message);
                if(data.message=='success'){
                    $("#messagedelete").css({'display':"block"});
                    $('#delete').modal('hide');
                    window.setTimeout(function(){location.reload()},2000);
                }
                if(data.message=='exist'){
                    $(".messageexist").css({'display':"block"});
                }

               
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
		url: "{{ url('componentbyid')}}",
		data: {id:id},
		dataType: "JSON",
		success: function(data) {
			$("#editid").val(id);
            $("#editname").val(data.message.componentname);
            $("#editlocationid").val(data.message.locationid);
            $("#editsupplierid").val(data.message.supplierid);
            $("#editbrandid").val(data.message.brandid);
            $("#edittypeid").val(data.message.typeid);
            $("#editserial").val(data.message.serial);
            $("#editquantity").val(data.message.quantity);
            $("#editpurchasedate").val(data.message.purchasedate);
            $("#editcost").val(data.message.cost);
            $("#editwarranty").val(data.message.warranty);
            $("#editstatus").val(data.message.status);
            $("#editdescription").val(data.message.componentdescription);
		}   
	});
});




//checkout
$("#formcheckout").validate({
    rules: {
      quantity: {
        required: true,
        digits: true
      }
    },
    submitHandler: function(form) {
        $.ajax({
            method: "POST",
            url: "{{ url('savecheckoutcomponent')}}",
            data: $("#formcheckout").serialize(),
            dataType: "JSON",
            success: function(data) {
                //check if more than avalaible quantity
                console.log(data);
                if(data.success=='0'){
                    $("#checkoutfailed").css({'display':"block"});
                }
                if(data.success=='success'){
                    $("#checkoutsuccess").css({'display':"block"});
                    $('#checkout').modal('hide');
                    window.setTimeout(function(){location.reload()},2000)
                }
            }
        });
    }
});



//show checkout
$('#checkout').on('show.bs.modal', function(e) {
    var $modal = $(this),
    id = $(e.relatedTarget).attr('customdata');
    $.ajax({
        type: "POST",
        url: "{{ url('componentbyid')}}",
        data: {id:id},
        dataType: "JSON",
        success: function(data) {
            console.log(data);
            $("#checkoutcomponentid").val(id);
            $("#checkoutname").val(data.message.componentname);
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