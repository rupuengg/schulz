
<!DOCTYPE html>
<html lang="en">
    <title>Bus/Student Manage Module</title>
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
    <body class="menubar-hoverable header-fixed " ng-app="studentBusTripApp" ng-cloak ng-class="cloak" ng-controller="studentBusController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head">
                                        <ul data-toggle="tabs" class="nav nav-tabs">
                                            <li class="{{'<?php echo $this->uri->segment(3) ?>'==''?'active' : ''}}"><a href="#first1">Assign Student Bus Wise</a></li>
                                            <li class="{{'<?php echo $this->uri->segment(3) ?>'!=''?'active' : ''}}"><a href="#third1">Assign Student Section Wise</a></li>
                                        </ul>
                                    </div><!--end .card-head -->
                                    <div class="card-body tab-content">
                                        <div id="first1" class="tab-pane {{'<?php echo $this->uri->segment(3) ?>'==''?'active' : ''}}">
                                            <div class="card-head style-primary card-head-xs">
                                                <header>Assign Student By Bus Wise</header>
                                            </div>
                                            <form role="form" class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Add Bus Number | Trip</label>
                                                    <div class="col-sm-10" >
                                                        <div  angucomplete-alt id="tripId" placeholder="Bus Number | Trip Name" pause="50" selected-object="selectedObject" remote-url="<?php echo base_url(); ?>index.php/staff/getalltripdetail?search= " remote-url-data-field="results" title-field="trip" minlength="1" input-class="form-control form-control-small" match-class="highlight"></div>

                                                    </div>
                                                </div>
                                                <div class="card card-outlined style-primary">

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Add Student</label>
                                                        <div class="col-sm-3" >
                                                            <div  angucomplete-alt id="stdId" placeholder="4059.Rahul(9A)" pause="50" selected-object="selectedObject" remote-url="<?php echo base_url(); ?>index.php/staff/getallstudent?search= " remote-url-data-field="results" title-field="studentId,name" minlength="1" input-class="form-control form-control-small" match-class="highlight"></div>


                                                        </div>
                                                        <div class="col-sm-3" >
                                                            <div>
                                                                <label class="radio-inline radio-styled">
                                                                    <input type="radio" name="trip" ng-model="tripStatus" value="COMING"><span>Coming</span>
                                                                </label>
                                                                <label class="radio-inline radio-styled">
                                                                    <input type="radio"  name="trip" ng-model="tripStatus" value="GOING"><span>Going</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3" >
                                                            <button class="btn btn-flat btn-primary ink-reaction" type="button"  ng-click="saveStudentBus()">Save</button>
                                                            <button class="btn btn-flat btn-primary ink-reaction" type="button" ng-click="cancel()">Cancel</button>

                                                        </div>
                                                    </div>
                                            </form>
                                        </div>
                                        <table class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Photo</th>
                                                    <th>Name</th>
                                                    <th>Bus no. & Trip Name</th>
                                                    <th>Trip Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="trip in StudentTripData">
                                                    <td>{{$index + 1}}</td>
                                                    <td ><img style="width: 25px" class="img-circle border-white width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{trip.adm_no}}/THUMB"; ?>" alt="">
                                                    </td>
                                                    <td>{{trip.adm_no + '.' + trip.firstname}}{{trip.lastname}}</td>
                                                    <td>{{trip.bus_reg_no}} & {{trip.trip_name}}</td>
                                                    <td>{{trip.trip_type}}</td>
                                                    <td><a class="btn btn-flat ink-reaction">
                                                            <i class="glyphicon glyphicon-remove" ng-click="removeStudentTrip(trip)"></i>
                                                        </a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="third1" class="tab-pane {{'<?php echo $this->uri->segment(3) ?>'!=''?'active' : ''}}">
                                        <div class="card-head style-primary card-head-xs">
                                            <header>Assign Student By Section Wise</header>
                                        </div>
                                        <form role="form" class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="select13">Select Section</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="select13" ng-model="sectionId" id="select13" ng-change="selectSection()">
                                                        <option value="">Please select Class Section</option>
                                                        <option ng-repeat="section in sectionList" value="{{section.id}}"  ng-selected="{{'<?php echo $this->uri->segment(3) ?>' === section.id}}">{{section.standard}}{{section.section}}</option>
                                                    </select><div class="form-control-line"></div>
                                                </div>
                                            </div>
                                        </form>
                                        <table class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Photo</th>
                                                    <th>Name</th>
                                                    <th>Bus no. & Trip Name for coming</th>
                                                    <th>Bus no. & Trip Name for going</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="student in studentDetail">
                                                    <td>{{$index + 1}}</td>
                                                    <td ><img style="width: 25px" class="img-circle border-white width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{student.adm_no}}/THUMB"; ?>" alt="">
                                                    </td>
                                                    <td>{{student.adm_no}}.{{student.firstname}}{{student.lastname}}</td>
                                                    <td><div ng-show="{{student.comingTrip == false}}" angucomplete-alt id="coming{{student.adm_no}}" placeholder="Select coming trip" pause="50" selected-object="selectedObjectcoming" remote-url="<?php echo base_url(); ?>index.php/staff/getalltripdetail?adm_no={{student.adm_no}}&search= " remote-url-data-field="results" title-field="trip" minlength="1" input-class="form-control form-control-small width-5" match-class="highlight"> </div>
                                                        <span ng-show="{{student.comingTrip != false}}">{{student.comingTrip[0].bus_reg_no}} {{student.comingTrip[0].trip_name}}
                                                            <a ng-click="removeComingTrip({{student.comingTrip[0].id}})" class="btn btn-flat ink-reaction">
                                                                <i class="fa fa-trash"></i>
                                                            </a></span>
                                                    </td>
                                                    <td><div ng-show="{{student.goingTrip == false}}" angucomplete-alt id="going{{student.comingTrip[0].id}}" placeholder="Select outgoing trip" pause="50" selected-object="selectedObjectgoing" remote-url="<?php echo base_url(); ?>index.php/staff/getalltripdetail?adm_no={{student.adm_no}}&search= " remote-url-data-field="results" title-field="trip" minlength="1" input-class="form-control form-control-small width-5" match-class="highlight"></div>
                                                        <span ng-show="{{student.goingTrip != false}}">{{student.goingTrip[0].bus_reg_no}} {{student.goingTrip[0].trip_name}}
                                                            <a ng-click="removeOutTrip({{student.goingTrip[0].id}})" class="btn btn-flat ink-reaction">
                                                                <i class="fa fa-trash"></i>
                                                            </a></span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>    
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
                        var section = "<?php echo $this->uri->segment(3) ?>";</script>
    <script src="<?php echo base_url(); ?>assets/js/autocomplete/angucomplete-alt.js"></script>
    <script src="<?php echo base_url(); ?>assets/myjs/transport/transport.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/angular-touch.min.js"></script>