<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('upload/favico-300x300.png')}}">
    <title>Assets Management System</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugin/datatables2/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">


    <!-- Script -->
    <script src="{{ asset('js/jquery-3.5.1.min.js')}}"></script>

    <script src="{{ asset('js/popper.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js')}}"></script>
    <script src="{{ asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('plugin/chart/moment.min.js')}}"></script>
    <script src="{{ asset('plugin/chart/Chart.min.js')}}"></script>
    <script src="{{ asset('plugin/chart/utils.js')}}"></script>
    <script src="{{ asset ('plugin/jqueryvalidation/jquery.validate.js')}}"></script>
    <script src="{{ asset('plugin/jqueryvalidation/additional-methods.js')}}"></script>
    <script src="{{ asset('plugin/datatables2/datatables.min.js')}}"></script>
    <script src="{{ asset('js/general.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




    <!-- select 2 -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
       .select2-container--default .select2-selection--single{
           height:auto;
       }
       .select2-container--default .select2-selection--single .select2-selection__rendered{
            padding-top: 5px;
            padding-bottom: 5px;
       }
       .select2-container--default .select2-selection--single .select2-selection__arrow
       {
        top: 6px;
       }
       span.select2{
           width:100% !important;
       }
       .danger{
           background-color: #ffc1c1 !important;
       }
       .success{
           background-color: #98fda9 !important;
       }
       .table{
            color: #000000;
            font-weight: 400;
       }
       .select2-selection__clear{
           display: none;
       }

       
       .dataTables_wrapper .col-sm-9{
            flex: 0 0 66.666667%;
            max-width: 66.666667% !important;
        }

        .dataTables_wrapper .col-sm-3{
            flex: 0 0 33.333333%;
            max-width: 33.333333% !important;
        }

        
	</style>


</head>

<body>

    <div class="sidebar">
        <div class=" sidebar-wrapper">
            <div class="logo" style="background: white;">
                <img class="logoimg" src="" style="width:200px" />
                </a>
            </div>
            <ul class="nav">


                @if(auth()->user()->role=="4" )
                <li class="{{ Request::is( 'emp_verification') ? 'active' : '' }}">
                    <a href="{{ URL::to( 'emp_verification') }}">
                        <p><img width="25"
                            src="<?php echo asset('images/icon-employee.png')?>" /> Employee List
                        </p>
                    </a>
                </li>
                <li class="{{ Request::is( 'hepl_verification') ? 'active' : '' }}">
                    <a href="{{ URL::to( 'hepl_verification') }}">
                        <p><img width="25"
                            src="<?php echo asset('images/icon-employee.png')?>" /> Verified Employee
                        </p>
                    </a>
                </li>
		        <li class="{{ Request::is( 'hold_employee') ? 'active' : '' }}">
                    <a href="{{ URL::to( 'hold_employee') }}">
                        <p><img width="25"
                            src="<?php echo asset('images/icon-employee.png')?>" /> Hold Employee
                        </p>
                    </a>
                </li>
                @endif


                @if(auth()->user()->role=="itinfra_audit")

                        <li class="{{ Request::is( 'hepl_verification') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'hepl_verification') }}">
                                <p><img width="25"
                                    src="<?php echo asset('images/icon-employee.png')?>" /> Verified Employee
                                </p>
                            </a>
                        </li>
                        <li class="{{ Request::is( 'hold_employee') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'hold_employee') }}">
                                <p><img width="25"
                                    src="<?php echo asset('images/icon-employee.png')?>" /> Hold Employee
                                </p>
                            </a>
                        </li>
                         <li class="{{ Request::is( 'emp_verification') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'emp_verification') }}">
                                <p><img width="25"
                                    src="<?php echo asset('images/icon-employee.png')?>" /> Non-Verified Employee List
                                </p>
                            </a>
                        </li>
                         <li class="{{ Request::is( 'returned_asset') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'returned_asset') }}">
                                <p><img width="25"
                                    src="<?php echo asset('images/icon-asset.png')?>" /> Returned Assets
                                </p>
                            </a>
                        </li>
                @endif


                @if(auth()->user()->role=="IA" )
                <li class="{{ Request::is( 'internalauditlist') ? 'active' : '' }}">
                    <a href="{{ URL::to( 'internalauditlist') }}">
                        <p><i class="fa fa-briefcase" style="margin-right: 0px;"></i>IA Report
                        </p>
                    </a>
                </li>
                @endif


                @if(auth()->user()->role!=="4" && auth()->user()->role!=="IA" && auth()->user()->role!=="itinfra_audit")


                    <li class="{{ Request::is( 'home') ? 'active' : '' }}">
                        <a href="{{ URL::to( 'home') }}">
                            <p><img width="22"
                                    src="<?php echo asset('images/icon-dashboard.png')?>" />&nbsp;&nbsp;&nbsp;<?php echo trans('lang.dashboard');?>
                            </p>
                        </a>
                    </li>


                    <li class="{{ Request::is( 'assetlist') ? 'active' : '' }}">
                        <a href="{{ URL::to( 'assetlist') }}">
                            <p><img width="22"
                                    src="<?php echo asset('images/icon-asset.png')?>" />&nbsp;&nbsp;&nbsp;<?php echo trans('lang.assetmenu');?>
                            </p>
                        </a>
                    </li>

                    <!-- <li class="{{ Request::is( 'componentlist') ? 'active' : '' }}">
                        <a href="{{ URL::to( 'componentlist') }}">
                            <p><img width="22"
                                    src="<?php echo asset('images/icon-component.png')?>" />&nbsp;&nbsp;&nbsp;<?php echo trans('lang.componentmenu');?>
                            </p>
                        </a>
                    </li>

                    <li class="{{ Request::is( 'maintenancelist') ? 'active' : '' }}">
                        <a href="{{ URL::to( 'maintenancelist') }}">
                            <p><img width="22"
                                    src="<?php echo asset('images/icon-maintenance.png')?>" />&nbsp;&nbsp;&nbsp;<?php echo trans('lang.maintenancemenu');?>
                            </p>
                        </a>
                    </li> -->

                    @if(auth()->user()->role!=="5" && auth()->user()->role!=="6" && auth()->user()->role!=="7")
                        <li class="{{ Request::is( 'assetcategorylist') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'assetcategorylist') }}">
                                <p style="margin-left: -4px;"><i class="fa fa-list-alt" style="margin-right: 0px;"></i>&nbsp;&nbsp;Asset Category
                                </p>
                            </a>
                        </li>

                        <li class="{{ Request::is( 'assettypelist') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'assettypelist') }}">
                                <p><img width="22"
                                        src="<?php echo asset('images/icon-type.png')?>" />&nbsp;&nbsp;&nbsp;<?php echo trans('lang.assettypemenu');?>
                                </p>
                            </a>
                        </li>

                        <li class="{{ Request::is( 'brandlist') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'brandlist') }}">
                                <p><img width="25"
                                        src="<?php echo asset('images/icon-manufacturer.png')?>" />&nbsp;&nbsp;&nbsp;<?php echo trans('lang.brandmenu');?>
                                </p>
                            </a>
                        </li>

                        <!-- <li class="{{ Request::is( 'supplierlist') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'supplierlist') }}">
                                <p><img width="25"
                                        src="<?php echo asset('images/icon-supplier.png')?>" />&nbsp;&nbsp;&nbsp;<?php echo trans('lang.suppliermenu');?>
                                </p>
                            </a>
                        </li> -->

                        <li class="{{ Request::is( 'locationlist') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'locationlist') }}">
                                <p><img width="25"
                                        src="<?php echo asset('images/icon-location.png')?>" />&nbsp;&nbsp;&nbsp;<?php echo trans('lang.locationmenu');?>
                                </p>
                            </a>
                        </li>
                        <li class="{{ Request::is( 'departmentlist') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'departmentlist') }}">
                                <p><img width="20"
                                        src="<?php echo asset('images/icon-department.png')?>" />&nbsp;&nbsp;&nbsp;<?php echo trans('lang.departmentmenu');?>
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->role!=="6")
                    <li class="{{ Request::is( 'employeeslist') ? 'active' : '' }}">
                        <a href="{{ URL::to( 'employeeslist') }}">
                            <p><img width="25"
                                    src="<?php echo asset('images/icon-employee.png')?>" />&nbsp;&nbsp;&nbsp;<?php echo trans('lang.employeemenu');?>
                            </p>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->role=="1" || auth()->user()->role=="2")
                        <li class="{{ Request::is( 'internalauditlist') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'internalauditlist') }}">
                                <p style="margin-left: -4px;"><i class="fa fa-briefcase" style="margin-right: 0px;"></i>&nbsp;&nbsp;IA Report
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->role!=="5" && auth()->user()->role!=="6" && auth()->user()->role!=="7")
                        <li class="{{ Request::is( 'businesslist') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'businesslist') }}">
                                <p style="margin-left: -4px;"><i class="fa fa-briefcase" style="margin-right: 0px;"></i>&nbsp;&nbsp;Business
                                </p>
                            </a>
                        </li>
                        <li class="{{ Request::is( 'softwares_report') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'softwares_report') }}">
                                <p><img width="20"
                                        src="<?php echo asset('images/icon-maintenance.png')?>" />&nbsp;&nbsp;&nbsp;Softwares
                                </p>
                            </a>
                        </li>
                        <li class="{{ Request::is( 'reports/allreports') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'reports/allreports') }}">
                                <p><img width="25"
                                        src="<?php echo asset('images/icon-report.png')?>" />&nbsp;&nbsp;&nbsp;<?php echo trans('lang.reportmenu');?>
                                </p>
                            </a>
                        </li>
                        <li class="{{ Request::is( 'bulk_qrcode_generate') ? 'active' : '' }}">
                            <a href="{{ URL::to( 'bulk_qrcode_generate') }}">
                                <p style="margin-left: -4px;" ><i class="fa fa-download" style="margin-right: 0px;"></i> &nbsp; QR code Download
                                </p>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="collapse" href="#settings"
                                class="{{ Request::is( 'settings/profile') || Request::is( 'settings/allusers') || Request::is( 'settings/application') ? '' : 'collapsed' }}"
                                aria-expanded="{{Request::is( 'settings/profile') || Request::is( 'settings/allusers') || Request::is( 'settings/application') ? 'true' : 'false' }}">
                                <i class="ti-settings"></i>
                                <p><img width="25"
                                        src="<?php echo asset('images/icon-setting.png')?>" />&nbsp;&nbsp;&nbsp;<?php echo trans('lang.settingmenu');?>
                                </p>
                            </a>
                            <div class="{{ Request::is( 'settings/profile') || Request::is( 'settings/allusers') || Request::is( 'settings/application') ? 'collapse in' : 'collapse' }}"
                                id="settings"
                                aria-expanded="{{ Request::is( 'settings/profile') || Request::is( 'settings/allusers') || Request::is( 'settings/application') ? 'true' : 'false' }}"
                                style="{{ Request::is( 'settings/profile') || Request::is( 'settings/allusers') || Request::is( 'settings/application') ? '' : 'height: 0px;' }}">
                                <ul class="nav">


                                    <li class="{{ Request::is( 'userlist') ? 'active' : '' }}">
                                        <a href="{{ URL::to( 'userlist') }}">
                                            <span class="sidebar-mini"><i class="fa fa-angle-right"></i></span>
                                            <span class="sidebar-normal"><?php echo trans('lang.usermenu');?></span>
                                        </a>
                                    </li>

                                    <li class="{{ Request::is( 'settinglist') ? 'active' : '' }}">
                                        <a href="{{ URL::to( 'settinglist') }}">
                                            <span class="sidebar-mini"><i class="fa fa-angle-right"></i></span>
                                            <span class="sidebar-normal"><?php echo trans('lang.applicationmenu');?></span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                    @endif

                @endif

            </ul>
        </div>
    </div>


    <div class="main-panel">
        <nav class="navbar navbar-expand-lg navbar-light bg-light pl-4 pr-4">

                <div class="col-md-6 ">
                <a class="navbar-brand company" href="#"></a>
                <button class="navbar-toggler nav-toggler-mobile" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu"
                    aria-expanded="false" aria-label="">
                    <span class="navbar-toggler-icon"></span>
                </button>

                </div>
                <div class="col-md-6 ">
                     <!--responsive-->
                        <div class="collapse" id="menu">
                        <ul class="nav navmobile" >

                            <li class="{{ Request::is( 'home') ? 'active' : '' }}">
                                    <a href="{{ URL::to( 'home') }}">
                                        <p><?php echo trans('lang.dashboard');?>
                                        </p>
                                    </a>
                                </li>


                                <li class="{{ Request::is( 'assetlist') ? 'active' : '' }}">
                                    <a href="{{ URL::to( 'assetlist') }}">
                                        <p><?php echo trans('lang.assetmenu');?>
                                        </p>
                                    </a>
                                </li>

                                <li class="{{ Request::is( 'componentlist') ? 'active' : '' }}">
                                    <a href="{{ URL::to( 'componentlist') }}">
                                        <p><?php echo trans('lang.componentmenu');?>
                                        </p>
                                    </a>
                                </li>

                                <li class="{{ Request::is( 'maintenancelist') ? 'active' : '' }}">
                                    <a href="{{ URL::to( 'maintenancelist') }}">
                                        <p><?php echo trans('lang.maintenancemenu');?>
                                        </p>
                                    </a>
                                </li>

                                <li class="{{ Request::is( 'assettypelist') ? 'active' : '' }}">
                                    <a href="{{ URL::to( 'assettypelist') }}">
                                        <p><?php echo trans('lang.assettypemenu');?>
                                        </p>
                                    </a>
                                </li>

                                <li class="{{ Request::is( 'brandlist') ? 'active' : '' }}">
                                    <a href="{{ URL::to( 'brandlist') }}">
                                        <p><?php echo trans('lang.brandmenu');?>
                                        </p>
                                    </a>
                                </li>

                                <li class="{{ Request::is( 'supplierlist') ? 'active' : '' }}">
                                    <a href="{{ URL::to( 'supplierlist') }}">
                                        <p><?php echo trans('lang.suppliermenu');?>
                                        </p>
                                    </a>
                                </li>

                                <li class="{{ Request::is( 'locationlist') ? 'active' : '' }}">
                                    <a href="{{ URL::to( 'locationlist') }}">
                                        <p><?php echo trans('lang.locationmenu');?>
                                        </p>
                                    </a>
                                </li>
                                <li class="{{ Request::is( 'employeeslist') ? 'active' : '' }}">
                                    <a href="{{ URL::to( 'employeeslist') }}">
                                        <p><?php echo trans('lang.employeemenu');?>
                                        </p>
                                    </a>
                                </li>

                                <li class="{{ Request::is( 'departmentlist') ? 'active' : '' }}">
                                    <a href="{{ URL::to( 'departmentlist') }}">
                                        <p><?php echo trans('lang.departmentmenu');?>
                                        </p>
                                    </a>
                                </li>

                                <li class="{{ Request::is( 'internalauditlist') ? 'active' : '' }}">
                                    <a href="{{ URL::to( 'internalauditlist') }}">
                                        <p>IA Report
                                        </p>
                                    </a>
                                </li>


                                <li class="{{ Request::is( 'reports/allreports') ? 'active' : '' }}">
                                    <a href="{{ URL::to( 'reports/allreports') }}">
                                        <p><?php echo trans('lang.reportmenu');?>
                                        </p>
                                    </a>
                                </li>


                                <li>
                                    <a data-toggle="collapse" href="#settingsmob"
                                        class="{{ Request::is( 'settings/profile') || Request::is( 'settings/allusers') || Request::is( 'settings/application') ? '' : 'collapsed' }}"
                                        aria-expanded="{{Request::is( 'settings/profile') || Request::is( 'settings/allusers') || Request::is( 'settings/application') ? 'true' : 'false' }}">
                                        <i class="ti-settings"></i>
                                        <p><?php echo trans('lang.settingmenu');?>
                                        </p>
                                    </a>
                                    <div class="{{ Request::is( 'settings/profile') || Request::is( 'settings/allusers') || Request::is( 'settings/application') ? 'collapse in' : 'collapse' }}"
                                        id="settingsmob"
                                        aria-expanded="{{ Request::is( 'settings/profile') || Request::is( 'settings/allusers') || Request::is( 'settings/application') ? 'true' : 'false' }}"
                                        style="{{ Request::is( 'settings/profile') || Request::is( 'settings/allusers') || Request::is( 'settings/application') ? '' : 'height: 0px;' }}">
                                        <ul class="nav">


                                            <li class="{{ Request::is( 'userlist') ? 'active' : '' }}">
                                                <a href="{{ URL::to( 'userlist') }}">
                                                    <span class="sidebar-mini"><i class="fa fa-angle-right"></i></span>
                                                    <span class="sidebar-normal"><?php echo trans('lang.usermenu');?></span>
                                                </a>
                                            </li>

                                            <li class="{{ Request::is( 'settinglist') ? 'active' : '' }}">
                                                <a href="{{ URL::to( 'settinglist') }}">
                                                    <span class="sidebar-mini"><i class="fa fa-angle-right"></i></span>
                                                    <span class="sidebar-normal"><?php echo trans('lang.applicationmenu');?></span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>

                            </ul>
                    </div>
                        <!--end responsive-->
                    <ul class="topmenu float-md-right float-sm-left">
                        <li>

                                    <span class="sidebar-mini"><i class="fa fa-user"></i></span>
                                    <span class="sidebar-normal"><?php echo trans('lang.welcome');?>, {{ Auth::user()->fullname }} &nbsp;&nbsp;&nbsp;</span>

                        </li>
                        <li>
                        <a href="{{ URL::to( 'logout') }}">
                                    <span class="sidebar-mini"><i class="fa fa-sign-out"></i></span>
                                    <span class="sidebar-normal"><?php echo trans('lang.logout');?></span>
                                </a>
                        </li>
                    </ul>
                </div>
        </nav>

        @yield('content')
        <footer class="footer">
            <div class="container-fluid">

                <div class="copyright pull-right">
                    © 2021, made with <i class="fa fa-heart heart"></i> by <span class="company"></span></a>
                </div>
            </div>
        </footer>
    </div>

    <script>
    (function($) {
    "use strict";

            //get app setting
            $.ajax({
                type: "GET",
                url: "{{ url('settings')}}",
                dataType: "JSON",
                success: function(data) {
                    $("#id").val('1');
                    $(".company").html(data.data.company);
                    $(".setcurrency").html(data.data.currency);
                    $(".logoimg").attr("src", data.logo);
                }
            });
            //datepicker

            $('.setdate').datepicker({
                autoclose: true,
                dateFormat: "yy-mm-dd",
                todayHighlight: true,
                 minDate: new Date()
            });



    })(jQuery);
    </script>

</body>

    <!-- select 2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $(".nice_select").select2({
        allowClear: true
    });

</script>


</html>
