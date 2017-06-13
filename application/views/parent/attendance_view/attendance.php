<!DOCTYPE html>
<html lang="en">
    <title>Attendance</title>
    <head>

        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="parent_attendance_app" ng-controller="attendance_angularjs_controller" ng-cloak ng-class="cloak">
        <!-- BEGIN HEADER-->
        <?php
        $this->load->view('include_parent/header');
        ?>

        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body" ng-cloak>


                        <div class="row">
                            <div class="row">

                                <div class="col-lg-6 col-sm-12">
                                    <div class="card " ng-show="absentData == 0">
                                        <div class="card-body">
                                            <div class="text-success text-center">
                                                <i class="fa fa-smile-o fa-15x"></i>
                                                <br/>
                                                <p class="text-xl"><?php echo $this->session->userdata('current_name'); ?> is very regular to school.</p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="no-padding"  ng-show="absentData != 0">
                                        <div role="alert" class="alert alert-callout alert-warning margin-bottom-lg" ng-repeat="absentDetails in absentData| orderBy:'-timestamp'">
                                            <div class="row" > 
                                                <div class="col-lg-1 no-padding">
                                                    <img class="img-circle img-responsive width-1" src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{absentDetails.data.staff_id}} " . "/THUMB"; ?>"/>
                                                </div>
                                                <div class="col-lg-11">
                                                    Absent on
                                                    <strong>{{absentDetails.data.att_date| date:'MMM d, y'}}</strong><br/>
                                                    <p class="no-margin">{{absentDetails.data.reason}}</p>

                                                    <a class="text-xs"><i>{{absentDetails.data.staff_name}}</i></a>

                                                    <i class="text-xs no-margin pull-right text-primary-dark">{{absentDetails.timestamp}}</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--end .col -->
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card style-primary">
                                        <div class="card-body small-padding text-center">
                                            <strong class="text-xxl">Today!</strong><span class="text-xl">&nbsp;<?php echo $this->session->userdata('current_name'); ?>  has come to school.</span>
                                        </div>
                                    </div>
                                    <div class="card ">
<!--                                        <div class="card-body no-padding text-center">
                                           <span class="text-lg"> Days</span> <strong class="text-xxl">{{summaryData.shortSummary.totWrkdy}} |</strong>
                                           <span class="text-lg">Present </span><strong class="text-xxl">{{summaryData.shortSummary.totPresent}} |</strong>
                                           <span class="text-lg"> Attendance</span><strong class="text-xxl">{{summaryData.shortSummary.percent}}%</strong>
                                            
                                            
                                        </div>-->
                                    <div class="no-padding">
                                        <div class="panel-group" id="accordion2">
                                            <div class="card panel" ng-repeat="attdata in summaryData.fullSummary">
                                                <div class="card-head card-head-xs" data-toggle="collapse" data-parent="#accordion2" data-target="#accordion2-{{$index}}">
                                                    <header class="pull-left">{{attdata.month + ' - ' + attdata.year}}</header>
                                                    <header class="pull-right">Days Present {{attdata.total_present + ' / ' + attdata.total_working_days}}</header>

                                                </div>
                                                <div id="accordion2-{{$index}}" class="collapse" >
                                                    <div class="card-body no-padding" ng-repeat="reason in attdata.absent_summary" >
                                                        <div role="alert" class="alert alert-callout no-y-padding no-margin alert-danger">
                                                            <strong>{{ reason.attendance_date| date:'MMM d, y'}}</strong>
                                                            <p>{{reason.reason}}</p>
<!--                                                                    <a class="text-sm"> <i>-</i></a>-->
                                                        </div>

                                                    </div>
                                                </div>
                                            </div><!--end .panel -->
                                        </div><!--end .panel-group -->
                                    </div>

                                </div><!--end .col -->
                            </div>
                        </div>
                    </div><!--end .section-body -->
                </section>
            </div><!--end #content-->		
            <!-- END CONTENT -->
            <!-- BEGIN MENUBAR-->
            <div id="menubar" class="menubar-inverse">
                <div class="menubar-fixed-panel">
                    <div>
                        <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="expanded">
                        <a href="dashboard.html">
                            <span class="text-lg text-bold text-primary ">Mera School Portal</span>
                        </a>
                    </div>
                </div>
                <div class="menubar-scroll-panel">
                    <?php
                    $this->load->view('include_parent/sidemenu.php');
                    ?>
                    <div class="menubar-foot-panel">
                        <small class="no-linebreak hidden-folded">
                            <span class="opacity-75">Copyright &copy; <?php echo date('Y'); ?></span> <strong>Mera School Portal</strong>
                        </small>
                    </div>
                </div><!--end .menubar-scroll-panel-->
            </div><!--end #menubar-->
            <!-- END MENUBAR -->
        </div><!--end #base-->	
        <!-- END BASE -->
        <!-- BEGIN JAVASCRIPT -->
        <?php
        $this->load->view('include_parent/headjs');
        ?>
        <script>
                    var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>/assets/parentjs/attendance.js"></script>

        <!-- END JAVASCRIPT -->
    </body>
</html>
