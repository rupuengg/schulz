<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Late attendance</title>
        <?php
        $this->load->view('include/headcss');
        ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/autocomplete/angucomplete-alt.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/autocomplete/fonts/bariol/bariol.css">
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    </head>
    <body class="menubar-hoverable header-fixed full-content"  ng-app="lateattendance" ng-controller="lateattendanceController" ng-cloak ng-class="cloak">
        <!--<body class="menubar-hoverable header-fixed  ">-->
        <!-- BEGIN HEADER-->
        <?php $this->load->view('include/header'); ?>
        <!-- END HEADER-->

        <!-- BEGIN BASE-->
        <div id="base">
            <!-- BEGIN OFFCANVAS LEFT -->
            <!-- END OFFCANVAS LEFT -->
            <!-- BEGIN CONTENT-->
            <div id="content">

                <section class="has-actions style-default-bright" > 

                    <!-- BEGIN INBOX -->
                    <div class="section-body" ng-cloak>
                        <div class="row">
                            <div class="col-lg-12 col-sm-6">
                                <div class="card card-outlined style-primary">
                                    <div class="card-head card-head-xs style-primary">
                                        <header>Late Attendance</header>

                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="row  margin-bottom-lg">
                                            <div class="col-lg-3"> 
                                                <div class="">
                                                    <div class="">
                                                        <header>
                                                            <div class="form">
                                                                <div class="form-group no-margin no-padding">
                                                                    <datepicker date-format="dd-MM-yyyy" date-max-limit="<?php echo date('Y-m-d') ?>">
                                                                        <input type="text" class="form-control datepickerMe" ng-model="lateDate"/>
                                                                    </datepicker> 
                                                                </div>
                                                            </div>
                                                        </header>
                                                    </div>  
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <form class="form-inline" name="myform">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="form-group col-lg-3">
                                                                <div angucomplete-alt id="studentName"  name="stuname" placeholder="Search Name Here" pause="25" selected-object="studentObj" remote-url="<?php echo base_url(); ?>index.php/staff/studentlist?search= " remote-url-data-field="results" title-field="firstname,lastname" minlength="1" input-class="form-control form-control-small" match-class="highlight">
                                                                </div><label for="Password4">Student Name</label>
                                                                </div>
                                                            <div class="form-group col-lg-3">
                                                                 <input type="text" class="form-control time-mask" name="comingtime" ng-init="temp.time = ''" ng-model="temp.time" required/>
                                                                <label for="Password4">Late Coming Time</label>
                                                            </div>
                                                            <div class="form-group col-lg-3">
                                                                <input type="text" id="timepicker" class="form-control" placeholder="Reason" ng-init="temp.reason = ''" ng-model="temp.reason" name="reason" required/>
                                                                <label><span>Reason</span></label>
                                                            </div>
                                                            <button type="submit" class="btn btn-raised btn-primary-light ink-reaction" ng-disabled="(!myform.reason.$valid) || (!myform.comingtime.$valid) || (studentObj.originalObject.adm_no == undefined)"  ng-click="addtable(temp, studentObj.originalObject.adm_no, studentObj.originalObject.firstname)">ADD</button>
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive no-margin">
                                                    <table class="table table-striped no-margin">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Time</th>
                                                                <th>Reason</th>
                                                                <th>Date</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr ng-repeat="table in tempArrLate">
                                                                <td>{{$index + 1}}</td>
                                                                <td>{{table.name}}</td>
                                                                <td>{{table.coming_time}}</td>
                                                                <td>{{table.reason}}</td>
                                                                <td>{{table.coming_date}}</td>
                                                                <td><i class="md md-highlight-remove" ng-click="removeRow($index)"></i></td>

                                                            </tr>
                                                    </table>
                                                </div>
                                            </div><!--end .card-body -->
                                        </div>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                        </div>
                    </div><!--end .section-body -->
                    <!-- END INBOX -->

                    <!-- BEGIN SECTION ACTION -->
                    <div class="section-action style-primary-bright">
                        <div class="section-floating-action-row" >
                            <button  type="button" class="btn ink-reaction btn-floating-action btn-lg btn-success" ng-disabled="tempArrLate.length == 0" ng-click="savealldata()"><i class="fa fa-save"></i></button>
                        </div>
                    </div>
                    <!-- END SECTION ACTION -->
                </section>
            </div><!--end #content-->		
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
            </div><!--end #menubar-->
            <!-- END MENUBAR -->
        </div><!--end #base-->	
        <!-- END BASE -->
        <!-- BEGIN JAVASCRIPT -->
        <script type="text/javascript">           
                    var myURL = "<?php echo base_url(); ?>";
                    var myDate = "<?php echo date("d-m-Y"); ?>";
        </script>
        <?php
        $this->load->view('include/headjs');
        ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/myjs/lateattendance.js"></script>
        <script src="<?php echo base_url(); ?>/assets/js/modules/materialadmin/core/demo/DemoFormComponents.js"></script>
        <script src="<?php echo base_url(); ?>/assets/js/autocomplete/angucomplete-alt.js"></script>
        <script src="<?php echo base_url(); ?>/assets/js/angular-touch.min.js"></script>
       <!-- END JAVASCRIPT -->
    </body>
</html>