
<!DOCTYPE html>
<html lang="en">
    <title>Bus/Driver Manage Module</title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/autocomplete/angucomplete-alt.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/autocomplete/fonts/bariol/bariol.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote9fec.css?1422823374" />

    <style>
        .myProButtons{
            position: relative;
            float: right;
            margin-left: 5px
        }
        .decorateMe{
            text-decoration: underline;
        }
    </style>
    <body class="menubar-hoverable header-fixed " ng-app="busDriverApp" ng-controller="busDriverController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head style-primary card-head-xs">
                                        <header>Bus/Driver Manage Module</header>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-sm-6 card card-outlined style-primary height-2" >
                                            <div class="form-group">
                                            </div>
                                            <form role="form" class="form-horizontal" >
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label" for="select13">Select Bus No. </label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control my-select" name="select13" ng-model="selectBusno" ng-change="changedBusNo()">
                                                            <option value="ALL">ALL</option>
                                                            <option ng-repeat="busObj in busdetails.busdetail" ng-selected="busObj.id === selectBusno" value="{{busObj.id}}">{{busObj.school_bus_no + ' | '  + busObj.bus_reg_no + ' | ' + busObj.bus_name}}</option>
                                                        </select><div class="form-control-line"></div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-sm-6 card card-outlined style-primary height-2">
                                            <div class="form-group">
                                            </div>
                                            <strong class="text-lg">Total {{busdetails.busdetail.length}} Bus with {{busdetails.totaltrip}} trips.</strong>
                                        </div>


                                        <div class="col-md-12" ng-show="bustripdetails.length > 0">
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table table-hover no-margin">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Bus Details</th>
                                                                <th>Bus Trip</th>
                                                                <th>Driver</th>
                                                                <th>Conductor</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr ng-repeat="mainObj in bustripdetails">
                                                                <td>{{$index + 1}}</td>
                                                                <td>{{mainObj.bus_detail}}</td>
                                                                <td>{{mainObj.trip_name}}</td>
                                                                <td ><span>{{mainObj.driver_name}}</span>
                                                                    <span class="pull-right">
                                                                        <a ng-click="editDriverConductor(mainObj.bus_detail, 1, $index)" class="btn btn-flat ink-reaction">
                                                                            <i class="fa fa-pencil"></i>
                                                                        </a>
                                                                        <a ng-hide="mainObj.driver_name == '' || mainObj.driver_name == null" ng-click="deleteDriverConductor(mainObj.bus_detail, mainObj.driver_name, mainObj.trip_id, 1, $index)" class="btn btn-flat ink-reaction">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a> 
                                                                    </span>
                                                                        <div ng-show="mainObj.driver_name == '' || mainObj.driver_name == null" angucomplete-alt id="id" placeholder="Driver Name" pause="50" selected-object="selectedDriver" remote-url="<?php echo base_url(); ?>index.php/staff/getalldriverlist?type=1 & trip_id={{mainObj.trip_id}} & search= " remote-url-data-field="results" title-field="name" minlength="1" input-class="form-control form-control-small width-5" match-class="highlight"></div>
                                                               </td>
                                                                <td><span>{{mainObj.conductor_name}}</span>
                                                                    <span class="pull-right">
                                                                        <a ng-click="editDriverConductor(mainObj.bus_detail, 2, $index)" class="btn btn-flat ink-reaction">
                                                                            <i class="fa fa-pencil"></i>
                                                                        </a>
                                                                        <a ng-hide="mainObj.conductor_name == '' || mainObj.conductor_name == null" ng-click="deleteDriverConductor(mainObj.bus_detail, mainObj.conductor_name, mainObj.trip_id, 2, $index)" class="btn btn-flat ink-reaction">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a> 
                                                                    </span>
                                                                     <div ng-show="mainObj.conductor_name == '' || mainObj.conductor_name == null" angucomplete-alt id="id" placeholder="Conductor Name" pause="50" selected-object="selectedDriver" remote-url="<?php echo base_url(); ?>index.php/staff/getalldriverlist?type=2 & trip_id={{mainObj.trip_id}} & search= " remote-url-data-field="results" title-field="name" minlength="1" input-class="form-control form-control-small width-5" match-class="highlight"></div>
                                                            </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div><!--end .card-body -->
                                            </div><!--end .card -->

                                        </div>


                                    </div><!--end .card-body -->

                                </div>


                            </div>

                        </div><!--end .section-body -->

                    </div><!--end .section-body -->

                </section>
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN MENUBAR-->
            <div id="menubar" class="menubar-inverse ">
                <div class="menubar-fixed-panel">
                    <div>
                        <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="expanded">
                        <a href="dashboard.html">
                            <span class="text-lg text-bold text-primary ">MATERIAL&nbsp;ADMIN</span>
                        </a>
                    </div>
                </div>
                <div class="menubar-scroll-panel">
                    <?php $this->load->view('include/menu'); ?>
                </div>
            </div>
            <?php
            $this->load->view('include/headjs');
            ?>
            <script>
                var myURL = "<?php echo base_url(); ?>";
                        var bus_id = "<?php echo $bus_id; ?>";</script>

            <script src="<?php echo base_url(); ?>assets/js/autocomplete/angucomplete-alt.js"></script>
    <script src="<?php echo base_url(); ?>assets/myjs/transport/transport.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/angular-touch.min.js"></script>
