@extends('main')
@section('content')
    <style>
        body {
            font-family: Arial;
        }

        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }

    </style>

    <section class="">
        <div class="content p-4">
            <div class="row pt-3">
                <div class="col-md-6">
                    <h3 class="">Software List</h3>
                </div>
                <!-- <div class="col-md-6 text-md-right pb-md-0 pb-3">
                <button type="button" data-toggle="modal" data-target="#add" class="btn btn-sm btn-fill btn-primary"><i class="fa fa-plus"></i> <?php echo trans('lang.add_data'); ?></button>
                </div> -->
            </div>

            <div class="tab">
                <button class="tablinks active" onclick="openCity(event, 'close_to_expiry')">Close To Expiry /
                    Expired</button>
                <button class="tablinks" onclick="openCity(event, 'all')">All</button>
                <input type="hidden" id="active_tab" value="close_to_expiry">

            </div>

            <div id="close_to_expiry" class="tabcontent" style="display: block;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body ">
                                <div id="messagesuccess" class="display-none alert alert-success"><?php echo trans('lang.data_added'); ?></div>
                                <div id="messagedelete" class="display-none alert alert-success"><?php echo trans('lang.data_deleted'); ?></div>
                                <div id="messageupdate" class="display-none alert alert-success"><?php echo trans('lang.data_updated'); ?></div>
                                <div class="table-responsive">
                                    <table id="exp_data" class="table table-striped table-bordered" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th><?php echo trans('lang.picture'); ?></th>
                                                <th>Asset ID</th>
                                                <th>Asset Detail</th>
                                                <th><?php echo trans('lang.date'); ?></th>
                                                <th><?php echo trans('lang.cost'); ?></th>
                                                <th><?php echo trans('lang.description'); ?></th>
                                                <th><?php echo trans('lang.name'); ?></th>
                                                <th><?php echo trans('lang.type'); ?></th>
                                                <th><?php echo trans('lang.brand'); ?></th>
                                                <th>Emp</th>
                                                <th>Expiry Date</th>

                                                <!-- <th><?php echo trans('lang.location'); ?></th>
                                                <th>QR</th> -->
                                                <th><?php echo trans('lang.action'); ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th><?php echo trans('lang.picture'); ?></th>
                                                <th>Asset ID</th>
                                                <th>Asset Detail</th>
                                                <th><?php echo trans('lang.date'); ?></th>
                                                <th><?php echo trans('lang.cost'); ?></th>
                                                <th><?php echo trans('lang.description'); ?></th>
                                                <th><?php echo trans('lang.name'); ?></th>
                                                <th><?php echo trans('lang.type'); ?></th>
                                                <th><?php echo trans('lang.brand'); ?></th>
                                                <th>Emp</th>
                                                <th>Expiry Date</th>

                                                <!-- <th><?php echo trans('lang.location'); ?></th>
                                                <th>QR</th> -->
                                                <th><?php echo trans('lang.action'); ?></th>
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

            <div id="all" class="tabcontent">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body ">
                                <div id="messagesuccess" class="display-none alert alert-success"><?php echo trans('lang.data_added'); ?></div>
                                <div id="messagedelete" class="display-none alert alert-success"><?php echo trans('lang.data_deleted'); ?></div>
                                <div id="messageupdate" class="display-none alert alert-success"><?php echo trans('lang.data_updated'); ?></div>
                                <div class="table-responsive">
                                    <table id="all_data" class="table table-striped table-bordered" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th><?php echo trans('lang.picture'); ?></th>
                                                <th>Asset ID</th>
                                                <th>Asset Detail</th>
                                                <th><?php echo trans('lang.date'); ?></th>
                                                <th><?php echo trans('lang.cost'); ?></th>
                                                <th><?php echo trans('lang.description'); ?></th>
                                                <th><?php echo trans('lang.name'); ?></th>
                                                <th><?php echo trans('lang.type'); ?></th>
                                                <th><?php echo trans('lang.brand'); ?></th>
                                                <th>Emp</th>
                                                <th>Expiry Date</th>
                                                <!-- <th><?php echo trans('lang.location'); ?></th>
                                                <th>QR</th> -->
                                                <th><?php echo trans('lang.action'); ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th><?php echo trans('lang.picture'); ?></th>
                                                <th>Asset ID</th>
                                                <th>Asset Detail</th>
                                                <th><?php echo trans('lang.date'); ?></th>
                                                <th><?php echo trans('lang.cost'); ?></th>
                                                <th><?php echo trans('lang.description'); ?></th>
                                                <th><?php echo trans('lang.name'); ?></th>
                                                <th><?php echo trans('lang.type'); ?></th>
                                                <th><?php echo trans('lang.brand'); ?></th>
                                                <th>Emp</th>
                                                <th>Expiry Date</th>
                                                <!-- <th><?php echo trans('lang.location'); ?></th>
                                                <th>QR</th> -->
                                                <th><?php echo trans('lang.action'); ?></th>
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

        <!--add checkin -->
        <div id="checkin" class="modal fade" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <form action="#" id="formcheckin" enctype="multipart/form-data" autocomplete="off">
                        <div class="modal-header">
                            <h5 class="modal-title">Renew Form</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Asset ID</label>
                                    <input name="assetid" type="text" readonly id="assetid" class=" form-control"
                                        required placeholder="Asset ID" />
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Expired Date</label>
                                    <input name="expired_date" type="text" readonly id="expired_date" class=" form-control"
                                        />
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12 mb-0">
                                    <label for="allocated_date" class="control-label">Next Renewal Date</label>
                                    <div class="input-group mb-0">
                                        <input class="form-control setdate" required="" placeholder="Renew date"
                                            id="allocated_date" name="allocated_date" type="text">
                                        <span class="input-group-addon border-1" id="date"><i
                                                class="fa fa-calendar"></i></span>
                                    </div>
                                    <label class="error" for="allocated_date"></label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Cost</label>
                                    <input name="sof_cost" type="text" id="sof_cost" class=" form-control"
                                     placeholder="Rs.--/" />
                                </div>
                                <div class="form-group col-md-12">
                                    <label><?php echo trans('lang.picture'); ?></label>
                                    <input name="image_upload[]" type="file" id="image_upload" class=" form-control"
                                        multiple/>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="savecheckin"><?php echo trans('lang.save'); ?></button>
                            <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo trans('lang.close'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end checkin-->

    </section>


    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");

            $("#active_tab").val(cityName);

            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>

    <script>
        // for export all data
        function newexportaction(e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()[0]._iDisplayStart;
            dt.one('preXhr', function(e, s, data) {
                // Just this once, load all data from the server...
                data.start = 0;
                data.length = 2147483647;
                dt.one('preDraw', function(e, settings) {
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
                    dt.one('preXhr', function(e, s, data) {
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
            $('#all_data').DataTable({
                ajax: "{{ url('software_data_all') }}",

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
                        data: 'assetid',
                        visible: false
                    },
                    {
                        data: 'asset_detail'
                    },
                    {
                        data: 'date',
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
                        data: 'name',
                        visible: false
                    },
                    {
                        data: 'type',
                        name: 'asset_type.name',
                        searchable: true
                    },
                    {
                        data: 'brand',
                        name: 'brand.name',
                        searchable: true
                    },
                    {
                        data: 'emp_detail'
                    },
                    {
                        data: 'expiry_date'
                    },
                    // {
                    //     data: 'location',name: 'location.name', searchable: true
                    // },
                    // {
                    //     data: 'qr'
                    // },

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
                        title: '<?php echo trans('lang.department_list '); ?>',
                        exportOptions: {
                            columns: [1, 2]
                        },
                        action: newexportaction,

                    },
                    {
                        extend: 'csv',
                        text: 'CSV <i class="fa fa-file-excel-o"></i>',
                        className: 'btn btn-sm btn-fill btn-info ',
                        title: '<?php echo trans('lang.department_list'); ?>',
                        exportOptions: {
                            columns: [1, 2]
                        },
                        action: newexportaction,

                    },
                    {
                        extend: 'pdf',
                        text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                        className: 'btn btn-sm btn-fill btn-info ',
                        title: '<?php echo trans('lang.department_list'); ?>',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [1, 2]
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
                        title: '<?php echo trans('lang.department_list'); ?>',
                        className: 'btn btn-sm btn-fill btn-info ',
                        text: 'Print <i class="fa fa-print"></i>',
                        exportOptions: {
                            columns: [1, 2]
                        },
                        action: newexportaction,

                    }
                ]
            });


            $('#exp_data').DataTable({
                ajax: "{{ url('software_data_exp') }}",

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
                        data: 'assetid',
                        visible: false
                    },
                    {
                        data: 'asset_detail'
                    },
                    {
                        data: 'date',
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
                        data: 'name',
                        visible: false
                    },
                    {
                        data: 'type',
                        name: 'asset_type.name',
                        searchable: true
                    },
                    {
                        data: 'brand',
                        name: 'brand.name',
                        searchable: true
                    },
                    {
                        data: 'emp_detail'
                    },
                    {
                        data: 'expiry_date'
                    },
                    // {
                    //     data: 'location',name: 'location.name', searchable: true
                    // },
                    // {
                    //     data: 'qr'
                    // },

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
                        title: '<?php echo trans('lang.department_list '); ?>',
                        exportOptions: {
                            columns: [1, 2]
                        },
                        action: newexportaction,

                    },
                    {
                        extend: 'csv',
                        text: 'CSV <i class="fa fa-file-excel-o"></i>',
                        className: 'btn btn-sm btn-fill btn-info ',
                        title: '<?php echo trans('lang.department_list'); ?>',
                        exportOptions: {
                            columns: [1, 2]
                        },
                        action: newexportaction,

                    },
                    {
                        extend: 'pdf',
                        text: 'PDF <i class="fa fa-file-pdf-o"></i>',
                        className: 'btn btn-sm btn-fill btn-info ',
                        title: '<?php echo trans('lang.department_list'); ?>',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [1, 2]
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
                        title: '<?php echo trans('lang.department_list'); ?>',
                        className: 'btn btn-sm btn-fill btn-info ',
                        text: 'Print <i class="fa fa-print"></i>',
                        exportOptions: {
                            columns: [1, 2]
                        },
                        action: newexportaction,

                    }
                ]
            });


            //show checkin
            $('#checkin').on('show.bs.modal', function(e) {
                var $modal = $(this),
                    id = $(e.relatedTarget).attr('customdata');
                $.ajax({
                    type: "POST",
                    url: "{{ url('assetby_id') }}",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(data,sof_cost) {
                        $("#expired_date").val(data.message.sof_expiry_date);
                        $("#assetid").val(data.message.assetid);
                        // $("#sof_cost").val(data.message.cost);
                        $("#sof_cost").val(data.sof_cost);
                    }
                });
            });

            // checkin

            $('#formcheckin').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "{{ url('sof_expiry') }}",
                    data: new FormData(this),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        $("#checkinsuccess").css({
                            'display': "block"
                        });
                        $('#checkin').modal('hide');
                        window.setTimeout(function() {
                            location.reload()
                        }, 2000)
                    }
                });
            });

           

            //add data
            $("#formadd").validate({
                submitHandler: function(form) {
                    $.ajax({
                        method: "POST",
                        url: "{{ url('savedepartment') }}",
                        data: $("#formadd").serialize(),
                        dataType: "JSON",
                        success: function(data) {
                            console.log(data);
                            $("#messagesuccess").css({
                                'display': "block"
                            });
                            $('#add').modal('hide');
                            window.setTimeout(function() {
                                location.reload()
                            }, 2000)
                        }
                    });
                }
            });

            //edit data
            $("#formedit").validate({
                submitHandler: function(form) {
                    $.ajax({
                        method: "POST",
                        url: "{{ url('updatedepartment') }}",
                        data: $("#formedit").serialize(),
                        dataType: "JSON",
                        success: function(data) {
                            console.log(data);
                            $("#messageupdate").css({
                                'display': "block"
                            });
                            $('#edit').modal('hide');
                            window.setTimeout(function() {
                                location.reload()
                            }, 2000)
                        }
                    });
                }
            });



            //delete data
            $("#formdelete").validate({
                submitHandler: function(form) {
                    $.ajax({
                        method: "POST",
                        url: "{{ url('deletedepartment') }}",
                        data: $("#formdelete").serialize(),
                        dataType: "JSON",
                        success: function(data) {
                            console.log(data);
                            $("#messagedelete").css({
                                'display': "block"
                            });
                            $('#delete').modal('hide');
                            window.setTimeout(function() {
                                location.reload()
                            }, 2000)
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
                    url: "{{ url('departmentbyid') }}",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $("#editid").val(id);
                        $("#edit_business").html(data.business_div);
                        $("#editname").val(data.message.name);
                        $("#editstatus").val(data.message.status);
                        $("#editdescription").val(data.message.description);
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
