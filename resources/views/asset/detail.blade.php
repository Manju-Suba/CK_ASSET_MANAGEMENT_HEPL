@extends('main')
@section('content')

<style>
    .table {
        color: #000000;
        font-weight: 600;
    }
    #qr_asset_id{
        font-size: 10px;
        margin-top: 5px;
    }

    .qrcss{
        font-size: 12px !important;
        line-height: 17px !important;
        font-weight: 600;
        color: #000000e3;
    }
    
    .qrcss b{
        font-size: 15px !important;
        font-weight: 900;
        color: black;
    }

    /* .common-class .qrcrss{
        font-size: 15px !important;
        line-height: 6px !important;
        font-weight: 600;
        color: #000000e3;
    }

    .common-class .qrcss b{
        font-size: 16px !important;
        font-weight: 900;
        color: black;
    } */

</style>

<section class="">
    <div class="content p-4">
        <div class="row pt-3">
            <div class="col-md-8">
                <h3 class=""><?php echo trans('lang.assetdetail');?></h3>
            </div>
            <div class="col-md-4 text-md-right">

                <!-- <a target="_blank" href="{{url('assetlist/generatelabel', $id)}}" id="btndetail" class="btn btn-sm btn-fill btn-primary"><i
                    class="ti-info"></i> <?php echo trans('lang.generatelabel');?></a> -->

                <a class="btn btn-sm btn-success btn-Convert-Html2Image" id="btn-Convert-Html2Image" href="#" ><i class="fa fa-download" aria-hidden="true"></i> Download Code</a>
                {{-- @if($a_type_id == 34)
                    <a href="{{ url('softwares_report') }}" id="btndetail"  class="btn btn-sm btn-fill btn-warning"><i
                    class="ti-info"></i> <!?php echo trans('lang.backtosoftware');?></a>
                @else
                    <a href="{{ url('assetlist') }}" id="btndetail"  class="btn btn-sm btn-fill btn-warning"><i
                    class="ti-info"></i> <!?php echo trans('lang.backtoasset');?></a>
                @endif --}}
                <a href="{{ url('assetlist') }}" id="btndetail"  class="btn btn-sm btn-fill btn-warning"><i
                    class="ti-info"></i> <?php echo trans('lang.backtoasset');?></a>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-9">
                                <input type="hidden" value="{{ $id }}" name="id" id="id" />
                                <p class="title-detail font-bold"> <span class="assetname"></span></p>
                                <p class="assetdetail"><span class="assettype"></span>&bull;<span
                                        class="assetstatus"></span></p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details"
                                            role="tab" aria-controls="details"
                                            aria-selected="true"><?php echo trans('lang.details');?></a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#components"
                                            role="tab" aria-controls="components"
                                            aria-selected="false"><?php echo trans('lang.components');?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#maintenance"
                                            role="tab" aria-controls="maintenance"
                                            aria-selected="false"><?php echo trans('lang.maintenances');?></a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a class="nav-link" id="history-tab" data-toggle="tab" href="#history"
                                            role="tab" aria-controls="history"
                                            aria-selected="false"><?php echo trans('lang.history');?></a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="details" role="tabpanel"
                                        aria-labelledby="details-tab">
                                        <div class="row">
                                            <div class="col-md-8 pt-3">
                                                <table class="table table-hover" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold"><?php echo trans('lang.business');?>:
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 business"></p>
                                                        </td>
                                                    </tr>
                                                     <tr>
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold"><?php echo trans('lang.type');?>:
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assettype2"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">Employee:
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetEmp"></p>
                                                        </td>
                                                    </tr>

                                                     <tr>
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold"><?php echo trans('lang.serialno');?>:
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 serial_no"></p>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold"><?php echo trans('lang.brand');?>:
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetbrand"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold"><?php echo trans('lang.portno');?>:
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetport_no"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                Date:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetdate"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold"><?php echo trans('lang.cost');?>:
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetcost"></p>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('lang.location');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetlocation"></p>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('lang.updatedat');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetupdated"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('lang.createdat');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetcreated"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('lang.description');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetdescription"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('Asset Domain');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetAssetDomain"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="showable_edit_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('CPU Model');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetCPUModel"></p>
                                                        </td>
                                                    </tr><tr class="showable_edit_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('CPU Configuration');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetCPUConfiguration"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="showable_edit_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('CPU SL#/Service Tag');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetCPUSL"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="showable_edit_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                Host Name:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 host_name" id="host_name"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="showable_edit_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('RAM');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetRAM"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="showable_edit_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('HDD');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetHDD"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="showable_edit_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('Keyboard');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetKeyboard"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="showable_edit_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('MOUSE');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetMouse"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="showable_edit_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('OS');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetOs"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="ip_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">IP Address :</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 ip_address"></p>
                                                        </td>
                                                    </tr>

                                                    <tr class="camera_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">Camera Pixel :</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 cam_pix"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="camera_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">Camera Model :</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 cam_model"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="camera_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">Camera Serial No :</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 cam_serial_no"></p>
                                                        </td>
                                                    </tr>

                                                    <tr class="desktop_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">Monitor Size :</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 asset_mon_size"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="desktop_div">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">Monitor Serial:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 asset_mon_serial"></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="showable_edit_div lap_asset">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('Charger');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetCharger"></p>
                                                        </td>
                                                    </tr><tr class="showable_edit_div lap_asset">
                                                        <td bgcolor="#f2f3f4" width="200">
                                                            <p class="mb-0 font-bold">
                                                                <?php echo trans('Bag');?>:</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 assetBag"></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-4 pt-2 text-center">
                                                <img width="100%" class="img-responsive assetimage" src="" />
                                                <hr>
                                                <div class="col-md-12">
                                                <div class="row border" id="qr_div">
                                                    <div class="col-md-4 p-2 pt-3">
                                                        <div class="assetbarcode"></div>
                                                    </div>
                                                    <div class="col-md-8 pr-2 pt-3 pl-0 pb-0" style="text-align: left;">
                                                        <h6 id="qr_img_id" hidden></h6>
                                                        <div class="qrcss"><b id="entity_name"></b></div>
                                                        <!-- <div class="qrcss">Emp ID : &nbsp;<b id="emp_id"></b></div> -->
                                                        <!-- <div class="qrcss">Emp Name : &nbsp;<b id="emp_name"></b></div> -->
                                                        <div class="qrcss">SL# : &nbsp;<b id="serial_no"></b></div>
                                                        <div class="qrcss">Asset ID : &nbsp;<b id="qr_asset_no"></b></div>
                                                    </div>
                                                    <!-- <div class="col-md-12 common-class">
                                                        <div class="row"> -->
                                                            <div class="col-md-5" style="text-align: right;padding-right: 15px;">
                                                                <p class="qrcss pt-1" style="margin-bottom: 1px;">IT Helpdesk &nbsp;: </p>
                                                            </div>
                                                            <div class="col-md-7" style="text-align: left;padding-left: 0px;">
                                                                <b id="support_no" style="font-size: 14px !important;" ></b>
                                                                <p><b id="support_email" style="font-size: 12px !important;" ></b></p>
                                                            </div>
                                                        <!-- </div>
                                                    </div> -->
                                                </div>
                                                </div>

                                                <br>
                                                <button id="btn-Preview-Image" style="display:none;">Download</button>
                                                <a class="btn btn-sm btn-success btn-Convert-Html2Image" id="btn-Convert-Html2Image" href="#" ><i class="fa fa-download" aria-hidden="true"></i> Download Code</a>
                                                <div id="previewImage" style="display:none;"></div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="components" role="tabpanel"
                                        aria-labelledby="components-tab">
                                         <div class="table-responsive  pt-4">
                                         <table id="datacomponent" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th><?php echo trans('lang.picture');?></th>
                                                        <th><?php echo trans('lang.name');?></th>
                                                        <th><?php echo trans('lang.type');?></th>
                                                        <th><?php echo trans('lang.brand');?></th>
                                                        <th><?php echo trans('lang.quantity');?></th>
                                                        <th><?php echo trans('lang.avalaiblequantity');?></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th><?php echo trans('lang.picture');?></th>
                                                        <th><?php echo trans('lang.name');?></th>
                                                        <th><?php echo trans('lang.type');?></th>
                                                        <th><?php echo trans('lang.brand');?></th>
                                                        <th><?php echo trans('lang.quantity');?></th>
                                                        <th><?php echo trans('lang.avalaiblequantity');?></th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                </tbody>
                                            </table>
                                         </div>
                                    </div>
                                    <div class="tab-pane fade" id="maintenance" role="tabpanel"
                                        aria-labelledby="maintenance-tab">
                                        <div class="table-responsive  pt-4">
                                            <table id="datamaintenance" class="table table-striped table-bordered"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th><?php echo trans('lang.asset');?></th>
                                                        <th><?php echo trans('lang.supplier');?></th>
                                                        <th><?php echo trans('lang.type');?></th>
                                                        <th><?php echo trans('lang.startdate');?></th>
                                                        <th><?php echo trans('lang.enddate');?></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th><?php echo trans('lang.asset');?></th>
                                                        <th><?php echo trans('lang.supplier');?></th>
                                                        <th><?php echo trans('lang.type');?></th>
                                                        <th><?php echo trans('lang.startdate');?></th>
                                                        <th><?php echo trans('lang.enddate');?></th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="history" role="tabpanel"
                                        aria-labelledby="history-tab">
                                        <div class="table-responsive  pt-4">
                                           {{-- <h1> {{$a_type_id}}</h1> --}}

                                            @if($a_type_id == 34)
                                                <table id="sofhistory" class="table table-striped table-bordered"
                                                    cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Purchase Date</th>
                                                            <th>Cost</th>
                                                            <th>Expired Date</th>
                                                            <th>Document</th>
                                                            {{-- <th>Remark</th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Purchase Date</th>
                                                            <th>Cost</th>
                                                            <th>Expired Date</th>
                                                            <th>Document</th>
                                                            {{-- <th>Remark</th> --}}
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            @else
                                                <table id="datahistory" class="table table-striped table-bordered"
                                                    cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Allocated Date</th>
                                                            <th><?php echo trans('lang.assetname');?></th>
                                                            <th><?php echo trans('lang.employee');?></th>
                                                            <th>Type</th>
                                                            <th>Reason</th>
                                                            <th>Remark</th>
                                                            <!-- <th><!?php echo trans('lang.action');?></th> -->
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Allocated Date</th>
                                                            <th><?php echo trans('lang.assetname');?></th>
                                                            <th><?php echo trans('lang.employee');?></th>
                                                            <th>Type</th>
                                                            <th>Reason</th>
                                                            <th>Remark</th>
                                                            <!-- <th><!?php echo trans('lang.action');?></th> -->
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
                </div>
            </div>
        </div>

        <!--add checkin -->
        <div id="docin" class="modal fade"  tabindex="-1" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><b>Show Images</b></h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <br>
                                    <br>
                                    <div class="row" id="show_img">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo trans('lang.close'); ?></button>
                        </div>
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

    // Global variable
    var getCanvas="";

(function($) {
"use strict";

    var id = $("#id").val();
    $(".showable_edit_div").hide();
    $(".desktop_div").hide();
    $(".lap_asset").hide();
    $(".camera_div").hide();

    $.ajax({
        type: "POST",
        url: "{{ url('assetbyid')}}",
        data: {
            id: id
        },
        dataType: "JSON",
        success: function(data) {
            function trucateOverflow(name,maxLength) {
                var displayText = name.length > maxLength ? name.slice(0, maxLength) + '...' : name;
                return displayText;
            }

            // console.log(data.message.assetname);
            $(".assetname").html(data.message.assetname);
            $(".business").html(data.message.business);
            $(".assettype").html(data.message.type);
            $(".assetstatus").html(data.assetstatus);
            $(".assetbrand").html(data.message.brand);
            $(".assetport_no").html(data.message.port_no);
            $(".assettype2").html(data.message.type);
            $("#qr_img_type").html(data.message.type);
            $("#qr_img_id").html(data.message.barcode);
            $("#qr_asset_id").html(data.message.assetid);

            if(data.message.business == "CKPL"){
                var entityname = "Cavinkare";
            }else{
                var entityname = data.message.business;
            }
            $("#entity_name").html(entityname);
            // $("#emp_id").html(data.emp_detail.id);

            if(data.message.cpu_si != "Nil"){
                var si_no = data.message.cpu_si;
            }else{
                var si_no = '';
            }
            $("#serial_no").html(trucateOverflow(si_no,12));
            // $("#emp_name").html(trucateOverflow(data.emp_detail.name,10));
            $("#support_no").html(data.message.support_no);
            $("#support_email").html(data.message.support_email);
            $("#qr_asset_no").html(data.message.assetid);
            


            $(".assetEmp").html(data.emp_detail.name+' / '+data.emp_detail.id);
            $(".assetdate").html(data.message.date);
            $(".serial_no").html(data.message.cpu_si);
            $(".assetcost").html(data.assetcost);
            $(".assetdescription").html(data.message.assetdescription);
            $(".assetcreated").html(data.assetcreated_at);
            $(".assetupdated").html(data.assetupdated_at);
            $(".assetserial").html(data.message.serial);
            $(".assetlocation").html(data.message.location);
            $(".assetbarcode").html(data.assetbarcode);
            $(".ip_address").html(data.message.ip_address);
            $(".assetimage").attr("src", data.assetimage);
            $(".assetAssetDomain").html(data.message.Asset_Domain);
            if(data.message.field_id=='Laptop Field')
            {
//host_name
                $(".showable_edit_div").show();
                $(".lap_asset").show();
                $(".assetAssetDomain").html(data.message.Asset_Domain);
                $(".assetCPUModel").html(data.message.CPU_Model);
                $(".assetCPUConfiguration").html(data.message.CPU_Configuration);
                $(".assetCPUSL").html(data.message.CPU_Sl);
                $(".assetRAM").html(data.message.RAM);
                $(".assetHDD").html(data.message.HDD);
                $(".assetKeyboard").html(data.message.Keyboard);
                $(".assetMouse").html(data.message.MOUSE);
                $(".assetOs").html(data.message.OS);
                $("#host_name").html(data.message.host_name);

                if(data.message.charger==1)
                {
                    $(".assetCharger").html('Yes');
                }
                else{
                    $(".assetCharger").html('No');
                }
                if(data.message.bag==1)
                {
                    $(".assetBag").html('Yes');
                }
                else{
                    $(".assetBag").html('No');
                }
            }
           else  if(data.message.field_id=='Desktop Field')
            {
                $(".showable_edit_div").show();
                $(".desktop_div").show();
                $(".lap_asset").hide();
                $(".assetAssetDomain").html(data.message.Asset_Domain);
                $(".assetCPUModel").html(data.message.CPU_Model);
                $(".assetCPUConfiguration").html(data.message.CPU_Configuration);
                $(".assetCPUSL").html(data.message.CPU_Sl);
                $(".assetRAM").html(data.message.RAM);
                $(".assetHDD").html(data.message.HDD);
                $(".assetKeyboard").html(data.message.Keyboard);
                $(".assetMouse").html(data.message.MOUSE);
                $(".assetOs").html(data.message.OS);

                $(".asset_mon_size").html(data.message.mon_size);
                $(".asset_mon_serial").html(data.message.mon_serial);
            }
            else  if(data.message.a_type_id=='12'||data.message.a_type_id=='13'||data.message.a_type_id=='14')
            {
                $(".camera_div").show();
                $(".cam_pix").html(data.message.cam_pix);
                $(".cam_model").html(data.message.cam_model);
                $(".cam_serial_no").html(data.message.cam_serial_no);

            }
            else{
                $(".showable_edit_div").hide();
                $(".lap_asset").hide();

            }




        // Global variable
        var element = $("#html-content-holder");


        html2canvas($("#qr_div")[0]).then((canvas) => {
            console.log("done ... ");
            $("#previewImage").append(canvas);
            getCanvas = canvas;
        });


        }
    });


    $(".btn-Convert-Html2Image").on('click', function() {
            var imgageData = getCanvas.toDataURL("image/png");

            // Now browser starts downloading
            // it instead of just showing it
            var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");

            var canvas_name=$("#qr_img_id").html();
            $(".btn-Convert-Html2Image").attr("download", canvas_name+".png").attr("href", newData);
    });


    //maintenance data
    $('#datamaintenance').DataTable({
        ajax: {
        url: "{{ url('maintenanceassetsbyid')}}",
        type: "post",
        data: function (d) {
              d.assetid = id;
            },
        },

        columns: [{
                data: 'id',
                orderable: false,
                searchable: false,
                visible: false
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
            }
        ],
        buttons: [{
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.maintenance_list ');?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.maintenance_list ');?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.maintenance_list ');?>',
                orientation: 'landscape',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
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
                title: '<?php echo trans('lang.maintenance_list ');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                },
                action: newexportaction,

            }
        ]
    });


    //component data
    $('#datacomponent').DataTable({
        ajax: {
        url: "{{ url('componentassetbyid')}}",
        type: "post",
        data: function (d) {
              d.assetid = id;
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
                data: 'quantity'
            },
            {
                data: 'avalaiblequantity'
            },

        ],

        buttons: [{
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.component_list ');?>',
                exportOptions: {
                    columns: [1, 2, 3, 4 ,5]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.component_list');?>',
                exportOptions: {
                    columns: [1, 2, 3, 4 ,5]
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
                title: '<?php echo trans('lang.component_list');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    columns: [1, 2, 3, 4 ,5]
                },
                action: newexportaction,

            }
        ]
    });



    //history data
    $('#datahistory').DataTable({
        ajax: {
        url: "{{ url('historyassetbyid')}}",
        type: "post",
        data: function (d) {
              d.assetid = id;
            }
        },

        columns: [{
            data: 'id',
                orderable: false,
                searchable: false,
                visible: false
            },

            {
                data: 'date_div'
            },
            {
                data: 'assetname'
            },
            {
                data: 'employeename'
            },
            {
                data: 'type'
            },
            {
                data: 'reason'
            },
            {
                data: 'remark'
            },


        ],

        buttons: [{
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.history_list ');?>',
                exportOptions: {
                    columns: [1, 2, 3, 4 ]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.history_list');?>',
                exportOptions: {
                    columns: [1, 2, 3, 4]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.history_list');?>',
                orientation: 'landscape',
                exportOptions: {
                    columns: [1, 2, 3, 4]
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
                title: '<?php echo trans('lang.history_list');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    columns: [1, 2, 3, 4 ]
                },
                action: newexportaction,

            }
        ]
    });

    // Software history data
    $('#sofhistory').DataTable({
        ajax: {
        url: "{{ url('sofhistoryassetbyid')}}",
        type: "post",
        data: function (d) {
              d.assetid = id;
            }
        },

        columns: [
            {
                data: 'date'
            },
            {
                data: 'sof_cost'
            },
            {
                data: 'expiry_date'
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            },

        ],

        buttons: [{
                extend: 'copy',
                text: 'Copy <i class="fa fa-files-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.history_list ');?>',
                exportOptions: {
                    columns: [1, 2, 3]
                },
                action: newexportaction,

            },
            {
                extend: 'csv',
                text: 'CSV <i class="fa fa-file-excel-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.history_list');?>',
                exportOptions: {
                    columns: [1, 2, 3]
                },
                action: newexportaction,

            },
            {
                extend: 'pdf',
                text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                className: 'btn btn-sm btn-fill btn-info ',
                title: '<?php echo trans('lang.history_list');?>',
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
                title: '<?php echo trans('lang.history_list');?>',
                className: 'btn btn-sm btn-fill btn-info ',
                text: 'Print <i class="fa fa-print"></i>',
                exportOptions: {
                    columns: [1, 2, 3 ]
                },
                action: newexportaction,

            }
        ]
    });

     //show checkin
     $('#docin').on('show.bs.modal', function(e) {
        var $modal = $(this),
        id = $(e.relatedTarget).attr('customdata');
        $.ajax({
            type: "POST",
            url: "{{ url('sof_id') }}",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(response) {
                // $("#assetid").val(data.message.assetid);
                // $("#picture").val(data.picture);
            if(response.res == "success"){

                $("#show_img").html(response.result);
            }

            }
        });
    });


})(jQuery);
</script>


@endsection
