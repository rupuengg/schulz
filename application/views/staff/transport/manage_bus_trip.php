
<!DOCTYPE html>
<html lang="en">
    <title>Manage Bus Trip</title>
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
    <body class="menubar-hoverable header-fixed " ng-app="busTripApp" ng-controller="busTripController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-head style-primary card-head-xs">
                                        <header>Bus Trip Manage Module</header>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" class="form-horizontal"  name="tripForm" novalidate>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="select13">Select Bus</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="select13" id="select13" ng-model="tripDetail.bus_id" ng-change="selectBus()">
                                                        <option value="">Please select Bus No.</option>
                                                        <option ng-repeat="bus in busDetail" value="{{bus.id}}"  ng-selected="{{'<?php echo $this->uri->segment(3) ?>' === bus.id}}">{{bus.school_bus_no}}</option>
                                                    </select><div class="form-control-line"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="help13">Trip Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="regular13" class="form-control" ng-model="tripDetail.trip_name" ng-pattern="/[a-zA-Z0-9]/" required><div class="form-control-line"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="help13">Trip Time</label>
                                                <div class="col-sm-10">
                                                    <uib-timepicker  ng-change="changed()" ng-model="tripDetail.trip_time" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></uib-timepicker>
                                                    <!--<input type="text" id="regular13" class="form-control" ng-model="tripDetail.trip_time" ng-pattern="/[a-zA-Z0-9]/" required><div class="form-control-line"></div>-->
                                                </div>
                                            </div>
                                            <div class="card-actionbar">
                                                <div class="card-actionbar-row">
                                                    <button type="submit" class="btn btn-flat btn-primary ink-reaction" ng-click="saveTripDetail()" ng-disabled="tripForm.$invalid">{{'<?php echo $this->uri->segment(4) ?>'!='' ? 'Update Trip Detail & stop' : 'Save Trip & Add Stop' }}</button>
                                                </div>
                                                <div class="form-group" ng-show="{{'<?php echo $this->uri->segment(3) ?>'}}">
                                                    Total 3 trips in the bus are allowed.
                                                </div>
                                            </div>

                                        </form>
                                    </div><!--end .card-body -->
                                </div>
                                <div class="col-md-6" ng-repeat="trip in busTripDetail">
                                    <div class="card">
                                        <div class="card-head style-primary card-head-xs">
                                            <div class="demo-icon-hover pull-right">
                                                <span class="glyphicon glyphicon-remove" ng-click="removeTrip(trip.bus_id, trip.id);"></span>
                                            </div>

                                            <div class="demo-icon-hover pull-right">
                                                <span class="glyphicon glyphicon-pencil" ng-click="editTrip(trip.bus_id, trip.id);"></span>
                                            </div>
                                            <header>{{trip.trip_name}}</header>
                                        </div>
                                        <div class="card-body">
                                            <div role="alert" ng-repeat="stop in trip.stopList" >
                                                <strong>Stop {{$index + 1}} :</strong> {{stop.stop_name}} at {{stop.arrival_time}}.
                                            </div>

                                        </div>
                                        <!--end .card-body -->

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6" ng-show="{{'<?php echo $this->uri->segment(4) ?>' != ''}}">
                                <div class="card">
                                    <div class="card-head style-primary card-head-xs">
                                        <header>Add stop for {{tripDetail.trip_name}}</header>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group" ng-repeat="stop in stopArray" id="{{'divID-' + $index}}">
                                            <div class="">
                                                <div  angucomplete-alt id="{{'busstop' + $index}}" placeholder="Search Stop" pause="50" selected-object="selectedObject" remote-url="<?php echo base_url(); ?>index.php/staff/getallstoplist?search= " remote-url-data-field="results" title-field="stop" minlength="1" input-class="" match-class="highlight"></div>
                                            </div>
                                            <div class="">
                                                <!--<input type="text" id="regular13" class="" ng-change="addReachtime(reachTime)" ng-model="reachTime" placeholder="Max Reach Time">-->
                                                <uib-timepicker  ng-change="addReachtime(reachTime)" ng-model="reachTime" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></uib-timepicker>
                                                <div class="demo-icon-hover pull-right">
                                                    <i class="md md-delete" ng-click="removeStop($index)"></i>
                                                </div>
                                                <div class="demo-icon-hover pull-right">
                                                    <i class="md md-add-box" ng-click="addAnotherStop()"></i>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="card-actionbar">
                                            <div class="card-actionbar-row">
                                                <button type="button" class="btn btn-flat btn-primary ink-reaction" ng-click="saveAllStop()">Save All</button>
                                            </div>
                                        </div>
                                    </div><!--end .card-body -->
                                </div>
                                <!--end .card-body -->
                            </div>
                        </div>
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
                        var bus_id = "<?php echo $this->uri->segment(3) ?>";
                        var trip_id = "<?php echo $this->uri->segment(4) ?>"
            </script>
            <script src="<?php echo base_url(); ?>assets/js/ui-bootstrap.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/autocomplete/angucomplete-alt.js"></script>
            <script src="<?php echo base_url(); ?>assets/myjs/transport/transport.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/angular-touch.min.js"></script>
