<!DOCTYPE html>
<html lang="en">
    <title>Admin Dashboard</title>
    <?php
    $s_code = $this->session->userdata('school_code');
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style>
        .alert-callout.alert-info.pink::before {
            background: #F52887 none repeat scroll 0 0;
        }
    </style>
    <body class="menubar-hoverable header-fixed ">
        <?php $this->load->view('include/header'); ?>
        <div id="base" ng-app="adminDetails">
            <!-- BEGIN OFFCANVAS LEFT -->
            <div ng-controller="adminDasboardController" ng-cloak ng-class="ng-cloak">
                <div class="offcanvas">

                    <!-- BEGIN OFFCANVAS DEMO LEFT -->
                    <div id="canvas1" class="offcanvas-pane style-primary width-10">
                        <div class="offcanvas-head">
                            <header>Attendance Pending ({{data.section.length}} section) </header>
                            <span> <?php echo date('jS M,Y'); ?></span><br>
                            <span> Attendance Not Marked</span>
                            <div class="offcanvas-tools">
                                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                            <!--<li class="tile bullet" ng-repeat="section in data.section">
                                <div class="tile-content">
                                    <div class="tile-text" style="padding:10px;"><img class=" img-circle" src="<?php echo base_url(); ?>{{section.profile_pic_path_thumbnail}}" alt="" width="46px"> <span style="padding:10px;">{{section.staffname}} {{section.staff_lname}}</span><span>({{section.sectionname}}{{$last ? '' : ($index==section.sectionname-2) ? ' and ' : ''}})</span></div>
                                </div>
                            </li>-->
                              <div class="table-responsive no-margin">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Staff Name</th>
                                            <th class = "lessspace"> Class</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="section in data.section">
                                            <td>{{$index+1}} <img class=" img-circle" src="<?php echo base_url() . 'index.php/staff/getphoto/{{section.id}}/THUMB' ?>" alt="" width="46px"> </td>
                                            <td class = "lessspace1">{{section.staffname}} {{section.staff_lname}}</td>
                                            <td class = "lessspace">{{section.sectionname}}</td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
 




                        </div>
                    </div>
                    <div id="canvas2" class="offcanvas-pane style-primary width-10">
                        <div class="offcanvas-head">
                            <header> Last seven day staff not logged </header>
                            <span> <?php echo date('jS M,Y'); ?></span>
                            <div class="offcanvas-tools">
                                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                             <div class="table-responsive no-margin">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Staff Name</th>
                                            <th>Last Logged</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="data in data.notlogged |orderBy:'lastLogin'"">
                                            <td><img class=" img-circle" src="<?php echo base_url() . 'index.php/staff/getphoto/{{data.staff_id}}/THUMB' ?>" alt="" width="46px"> </td>
                                            <td class = "lessspace1" style="{{data.notlogged_class}}">{{data.staffname}}</td>
                                            <td class = "lessspace" style="{{data.notlogged_class}}" >{{data.lastLogin| date :  "d MMM.y" }} <span ng-show="data.dateintrvl > 0">({{data.dateintrvl}} days ago)</span></td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>



<!--                            <span ng-repeat="section in data.section">
    {{section.sectionname}}{{$last ? '' : ($index==section.sectionname-2) ? ' and ' : ', '}}</span>-->

                        </div>
                    </div>
                    <div id="canvas3" class="offcanvas-pane style-primary width-10">
                        <div class="offcanvas-head">
                            <header>Marks entry done (3 sections) </header>
                            <span> <?php echo date('l jS,M '); ?></span>
                            <div class="offcanvas-tools">
                                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                            <li class="tile" style="padding-bottom:20px;">
                                <div class="tile-content">

                                    <div class="tile-text"> <img class=" img-circle" src="<?php echo base_url(); ?>assets/img/avatar2666b.jpg" alt="" width="46px"> <span style="padding:30px;">Lisa Roy</span> <span>(7A)</span></div>

                                </div>
                            </li>
                            <li class="tile" style="padding-bottom:20px;" >
                                <div class="tile-content">

                                    <div class="tile-text"> <img class=" img-circle" src="<?php echo base_url(); ?>assets/img/avatar2666b.jpg" alt="" width="46px"> <span style="padding:30px;">Lisa Roy</span> <span>(7A)</span></div>

                                </div>
                            </li>
                            <li class="tile" >
                                <div class="tile-content">

                                    <div class="tile-text"> <img class=" img-circle" src="<?php echo base_url(); ?>assets/img/avatar2666b.jpg" alt="" width="46px"> <span style="padding:30px;">Lisa Roy</span> <span>(7A)</span></div>

                                </div>
                            </li>


<!--                            <span ng-repeat="section in data.section">
    {{section.sectionname}}{{$last ? '' : ($index==section.sectionname-2) ? ' and ' : ', '}}</span>-->

                        </div>
                    </div>
                    <div id="canvas4" class="offcanvas-pane style-primary width-10">
                        <div class="offcanvas-head">
                            <header>CCE grade entry </header>
                            <span> <?php echo date('l jS,M '); ?></span>
                            <div class="offcanvas-tools">
                                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                            <li class="tile" style="padding-bottom:20px;" >
                                <div class="tile-content">

                                    <div class="tile-text"> <img class=" img-circle" src="<?php echo base_url(); ?>assets/img/avatar42dba.jpg" alt="" width="46px"> <span style="padding:30px;">Gaurav Rupani</span> <span>(7A)</span></div>

                                </div>
                            </li>
                            <li class="tile" style="padding-bottom:20px;">
                                <div class="tile-content">

                                    <div class="tile-text"> <img class=" img-circle" src="<?php echo base_url(); ?>assets/img/avatar42dba.jpg" alt="" width="46px"> <span style="padding:30px;">Gaurav Rupani</span> <span>(7A)</span></div>

                                </div>
                            </li>
                            <li class="tile" >
                                <div class="tile-content">

                                    <div class="tile-text"> <img class=" img-circle" src="<?php echo base_url(); ?>assets/img/avatar42dba.jpg" alt="" width="46px"> <span style="padding:30px;">Gaurav Rupani</span> <span>(7A)</span></div>

                                </div>
                            </li>


<!--                            <span ng-repeat="section in data.section">
    {{section.sectionname}}{{$last ? '' : ($index==section.sectionname-2) ? ' and ' : ', '}}</span>-->

                        </div>
                    </div>

                    <div id="offcanvas-demo-left" class="offcanvas-pane style-primary width-10">
                        <div class="offcanvas-head">
                            <header><span>Schedule of {{examName}}</span></header>
                            <div class="offcanvas-tools">
                                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                            <h5 ng-show="myExamSchedule == -1">No Datesheet Available</h5>
                            <div class="col-lg-12" ng-show="myExamSchedule != -1">
                                <div class="card">
                                    <div class="card-body no-padding style-primary">
                                        <div class="table-responsive no-margin">
                                            <table class="table table-striped no-margin style-primary">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Subject Name</th>
                                                        <th> Date</th>
                                                        <th> Time</th>
                                                        <th>Duration</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="examDate in myExamSchedule">
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{examDate.subject_name}}</td>
                                                        <td>{{examDate.exam_date}}</td>
                                                        <td>{{examDate.exam_time}}</td>
                                                        <td>{{examDate.duration}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div><!--end .table-responsive -->
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div>
                        </div>
                    </div>

                    <!-- END OFFCANVAS DEMO LEFT -->

                </div>
                <!--end .offcanvas->
                <!--</div>end .offcanvas-->
                <!-- END OFFCANVAS LEFT -->
                <div id="content" >
                    <section>
                        <div class="section-body" ng-cloak>
                            <div class="row">

                                <!-- BEGIN ALERT - REVENUE -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="card">
                                        <div class="card-body no-padding">
                                            <div class="alert alert-callout alert-info no-margin">
                                                <strong class="pull-right text-info text-lg">Today:{{data.totalblue.count}} <i class="fa fa-credit-card"></i></strong>
                                                <strong class="text-xl">{{data.blue.count}}</strong><br>
                                                <span class="opacity-50">Blue Cards Issued</span>
                                                <div class="stick-bottom-left-right">
                                                    <div class="height-2 sparkline-revenue" data-line-color="#FF0000"></div>
                                                </div>
                                            </div>
                                        </div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div><!--end .col -->
                                <!-- END ALERT - REVENUE -->

                                <!-- BEGIN ALERT - VISITS -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="card">
                                        <div class="card-body no-padding myalert">
                                            <div class="alert alert-callout alert-warning no-margin ">
                                                <strong class="pull-right custom-text-warning text-lg" >Today:{{data.totalyellow.count}} <i class="fa fa-credit-card"></i></strong>
                                                <strong class="text-xl">{{data.yellow.count}}</strong><br>
                                                <span class="opacity-50">Yellow Cards Issued</span>

                                            </div>
                                        </div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div><!--end .col -->
                                <!-- END ALERT - VISITS -->



                                <!-- BEGIN ALERT - TIME ON SITE -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="card">
                                        <div class="card-body no-padding">
                                            <div class="alert alert-callout alert-info no-margin pink">
                                                <strong class="pull-right  text-lg" style="color: #F52887">Today:{{data.totalpink.count}} <i class="fa fa-credit-card"></i></strong>
                                                <strong class="text-xl">{{data.pink.count}}</strong><br>
                                                <span class="opacity-50">Pink Cards Issued</span>

                                            </div>
                                        </div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div><!--end .col -->
                                <!-- END ALERT - TIME ON SITE -->
                                <!-- BEGIN ALERT - BOUNCE RATES -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="card">
                                        <div class="card-body no-padding">
                                            <div class="alert alert-callout alert-danger no-margin">
                                                <strong class="pull-right text-danger text-lg">Today:{{data.totalred.count}} <i class="fa fa-credit-card"></i></strong>
                                                <strong class="text-xl">{{data.red.count}}</strong><br>
                                                <span class="opacity-50">Red Cards Issued</span>

                                            </div>
                                        </div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div><!--end .col -->
                                <!-- END ALERT - BOUNCE RATES -->

                            </div><!--end .row -->
                            <div class="row">

                                <!-- BEGIN SITE ACTIVITY -->
                                <div class="col-md-9">
                                    <div class="card" >
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="card-head">
                                                    <header>Login Status of Students and Teachers  </header>
                                                </div><!--end .card-head -->
                                                <div class="mycard-body height-8" id="myGraph">


                                                </div><!--end .card-body -->
                                            </div><!--end .col -->
                                            <div class="col-md-4" >
                                                <div class="card-head">
                                                    <header>Today Status</header>
                                                </div>
                                                <div class="card-body height-8 myscroll" >
                                                    <div ng-if="data.present.length > 0">
                                                        <strong>{{data.present.length}}</strong> Student Present
                                                        <div class="progress progress-hairline">
                                                            <div class="progress-bar progress-bar-primary-dark" style="width:100%"></div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div ng-if="data.absent.length > 0">
                                                        <strong>{{data.absent.length}}</strong> Student Absent
                                                        <div class="progress progress-hairline">
                                                            <div class="progress-bar progress-bar-danger" style="width:100%"></div>
                                                        </div>
                                                    </div>
                                                    <div ng-if="data.section.length != '0'">
                                                        <a class="ink-reaction pull-left tab blink" href="#canvas1" data-toggle="offcanvas">
                                                            <strong>{{data.section.length}}</strong> Section Attendance not taken</a>
                                                        <i class="md md-arrow-forward"></i>
                                                        <div class="progress progress-hairline">
                                                            <div class="progress-bar progress-bar-danger" style="width:100%"></div>
                                                        </div>
                                                    </div>
                                                    <a class="ink-reaction pull-left tab blink" href="#canvas2" data-toggle="offcanvas">
                                                        <strong></strong>  Last seven day staff not logged</a>
                                                    <i class="md md-arrow-forward"></i>
                                                    <div class="progress progress-hairline">
                                                        <div class="progress-bar progress-bar-danger" style="width:100%"></div>
                                                    </div>
                                                    <!---<a class="ink-reaction pull-left tab blink" href="#canvas3" data-toggle="offcanvas">
                                                        <strong></strong>Marks entry done</a>
                                                    <i class="md md-arrow-forward"></i>
                                                    <div class="progress progress-hairline">
                                                        <div class="progress-bar progress-bar-danger" style="width:100%"></div>
                                                    </div>
                                                    <a class="ink-reaction pull-left tab blink" href="#canvas4" data-toggle="offcanvas">
                                                        <strong></strong>  CCE grade entry</a>
                                                    <i class="md md-arrow-forward"></i>
                                                    <div class="progress progress-hairline">
                                                        <div class="progress-bar progress-bar-danger" style="width:100%"></div>
                                                    </div>--->

                                                    <div ng-if="data.absentstaff.length > 0">
                                                        <strong>{{data.absentstaff.length}}</strong> Staff Absent

                                                        <div class="progress progress-hairline">
                                                            <div class="progress-bar progress-bar-danger" style="width:100%"></div>
                                                        </div>
                                                    </div>
                                                    <div ng-if="data.late.length > 0">
                                                        <strong>{{data.late.length}}</strong> Student Late 

                                                        <div class="progress progress-hairline">
                                                            <div class="progress-bar progress-bar-danger" style="width:100%"></div>
                                                        </div>
                                                    </div>
                                                </div><!--end .card-body -->
                                            </div><!--end .col -->
                                        </div><!--end .row -->
                                    </div><!--end .card -->		
                                </div><!--end .col -->
                                <!-- END SITE ACTIVITY -->

                                <!-- BEGIN SERVER STATUS -->
                                <div class="col-md-3">
                                    <!--<div class="col-md-6">-->
                                    <div class="card ">
                                        <div class="card-head " ng-repeat="j in data.todayholiday">
                                            <header  ng-if="j.is_holiday == 'No'" >School is Open Today</header>
                                            <header ng-if="j.is_holiday == 'Yes'">School is Closed Today<br>
                                                <small>({{j.reason}})</small></header>

                                        </div><!--end .card-head -->
                                        <div  style="height: 80px;" ng-repeat="xx in data.todayholiday" ng-if="xx.is_holiday == 'No'">
                                            <div class="alert">
                                                Click to mark holiday                                               
                                                <button ng-show="edit == 'yes'" type="button" class="btn btn-xs btn-success pull-right" id='{{xx.date}}' ng-click="editHoliday($event)">Close</button>
                                                <br>
                                                <input ng-show="type == 'yes'" ng-model="todo" type="text" id="groupbutton9" class="">
                                                <button ng-show="type == 'yes'" type="button" class="btn btn-sm btn-danger pull-right"  ng-click="canceledit()"><i class="md md-cancel"></i></button>
                                                <button ng-show="type == 'yes'" type="button" id="{{xx.date}}" holiday ="{{xx.is_holiday}}" class="btn btn-sm btn-success pull-right" ng-click="saveHoliday(todo, xx)"><i class="md md-save"></i></button>

                                            </div>

                                        </div>
                                        <div  style="height: 80px;" ng-repeat="xx in data.todayholiday" ng-if="xx.is_holiday == 'Yes'">
                                            <div class="alert">
                                                Click to open the school
                                                <button ng-show="edit == 'yes'" type="button" class="btn btn-xs btn-success pull-right" id='{{xx.date}}' ng-click="editHoliday($event)">Open</button>
                                                <br>
                                                <input ng-show="type == 'yes'" ng-model="todo" type="text" id="groupbutton9" class="">
                                                <button ng-show="type == 'yes'" type="button" class="btn btn-sm btn-danger pull-right"  ng-click="canceledit()"><i class="md md-cancel"></i></button>
                                                <button ng-show="type == 'yes'" type="button" id="{{xx.date}}" holiday ="{{xx.is_holiday}}" class="btn btn-sm btn-success pull-right" ng-click="saveHoliday(todo, xx)"><i class="md md-save"></i></button>

                                            </div>

                                        </div>

                                    </div>
                                    <!--</div>-->
                                    <!--<div class="col-md-6">-->
                                    <div class="card">
                                        <div class="card-head">
                                            <header>Upcoming Holiday</header>
                                            <div class="tools">
                                                <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                            </div>
                                        </div><!--end .card-head -->
                                        <div style="height: 161px;" class="nano myscroll">
                                            <div style="right: -15px;" tabindex="0" >
                                                <div  style="height: 160px;">
                                                    <div  tabindex="0" >
                                                        <div style="height: auto;" class="card-body no-padding ">
                                                            <ul data-sortable="true" class="list">
                                                                <?php if (empty($holiday)) { ?>
                                                                    <li class="tile">
                                                                        <div class="tile-content">

                                                                            <div class="tile-text">No Entry Found</div>
                                                                        </div>

                                                                    </li>
                                                                    <?php
                                                                } else {
                                                                    for ($i = 0; $i < count($holiday); $i++) {
                                                                        ?>
                                                                        <li class="tile" >
                                                                            <div class="checkbox checkbox-styled tile-text">
                                                                                <p class="ml30">
                                                                                   
                                                                                        <?php echo $holiday[$i]['holiday_reason'] ?>
                                                                                        <small> <?php echo $holiday[$i]['date'] ?></small>
                                                                                   
                                                                                </p>
                                                                            </div>

                                                                        </li>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>


                                                            </ul>
                                                        </div></div></div></div></div><!--end .card-body -->
                                    </div><!--end .card -->
                                    <!--</div>-->
                                </div>
                                <!-- END SERVER STATUS -->

                            </div><!--end .row -->

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card ">
                                        <div class="card-head">
                                            <header>Absent Staff({{data.absentstaff.length}})</header>
                                            <div class="tools">
                                                <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                            </div>
                                        </div><!--end .card-head -->
                                        <div style="height: 322px;" class="nano myscroll">
                                            <div style="right: -15px;" tabindex="0">
                                                <div  style="height: 320px;">
                                                    <div  tabindex="0" >
                                                        <div style="height: auto;" class="card-body no-padding">
                                                            <ul class="list">

                                                                <?php if (empty($staffabsent)) { ?>
                                                                    <li class="tile">
                                                                        <div class="tile-content">

                                                                            <div class="tile-text">No Entry Found</div>
                                                                        </div>

                                                                    </li>
                                                                    <?php
                                                                } else {
                                                                    for ($k = 0; $k < count($staffabsent); $k++) {
                                                                        ?>
                                                                        <li class="tile">
                                                                            <a class="btn btn-flat btn-info ink-reaction">
                                                                                <i class="md md-event"></i>
                                                                            </a>
                                                                            <!--<div class="tile-content">-->
                                                                            <a class="tile-content ink-reaction" href="<?php echo base_url(); ?>index.php/staff/staffprofile/<?php echo $staffabsent[$k]['id']; ?>">
                                                                                <div class="tile-icon">
                                                                                    <img src="<?php echo base_url() . 'index.php/staff/getphoto/' . $staffabsent[$k]['id'] . '/THUMB' ?>" alt="">
                                                                                </div>
                                                                                <div class="tile-text"><?php echo $staffabsent[$k]['staff_fname'] . ' ' . $staffabsent[$k]['staff_lname'] ?></div>
                                                                                <!--</div>-->
                                                                            </a>
                                                                        </li> 

                                                                        <?php
                                                                    }
                                                                }
                                                                ?>



                                                            </ul>
                                                        </div></div></div></div></div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div>
                                <div class="col-md-3">
                                    <div class="card ">
                                        <div class="card-head">
                                            <header>Absent student</header>
                                            <div class="tools">
                                                <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                            </div>
                                        </div><!--end .card-head -->
                                        <div style="height: 322px;" class="nano myscroll">
                                            <div style="right: -15px;" tabindex="0">
                                                <div  style="height: 320px;">
                                                    <div  tabindex="0" >
                                                        <div style="height: auto;" class="card-body no-padding">
                                                            <ul class="list">

                                                                <?php if (empty($absent)) { ?>
                                                                    <li class="tile">
                                                                        <div class="tile-content">

                                                                            <div class="tile-text">No Entry Found</div>
                                                                        </div>

                                                                    </li>
                                                                    <?php
                                                                } else {
                                                                    for ($k = 0; $k < count($absent); $k++) {
                                                                        ?>
                                                                        <li class="tile">
                                                                            <!--<div class="tile-content">-->
                                                                            <a class="tile-content ink-reaction" href="<?php echo base_url(); ?>index.php/staff/studentprofile/<?php echo $absent[$k]['adm_no']; ?>">
                                                                                <div class="tile-icon">
                                                                                    <img src="<?php echo base_url() . "index.php/staff/getstudphoto/" . $absent[$k]['adm_no'] . "/THUMB" ?>" alt="">
                                                                                </div>
                                                                                <div class="tile-text"><?php echo $absent[$k]['firstname'] . ' ' . $absent[$k]['lastname'] ?></div>
                                                                                <!--</div>-->
                                                                            </a>
                                                                        </li>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>



                                                            </ul>
                                                        </div></div>
                                                   </div></div>
                                                        </div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div>

                                <div class="col-md-3">
                                    <div class="card ">
                                        <div class="card-head">
                                            <header>Late Entry</header>
                                            <div class="tools">
                                                <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                            </div>
                                        </div><!--end .card-head -->
                                        <div style="height: 322px;" class="nano myscroll">
                                            <div style="right: -15px;" tabindex="0" >
                                                <div  style="height: 320px;">
                                                    <div  tabindex="0">
                                                        <div style="height: auto;" class="card-body no-padding">
                                                            <ul class="list">

                                                                <?php if (empty($late)) { ?>
                                                                    <li class="tile">
                                                                        <div class="tile-content">

                                                                            <div class="tile-text">No Entry Found</div>
                                                                        </div>

                                                                    </li>
                                                                    <?php
                                                                } else {
                                                                    for ($k = 0; $k < count($late); $k++) {
                                                                        ?>
                                                                        <li class="tile">
                                                                            <!--<div class="tile-content">-->
                                                                            <a class="tile-content ink-reaction" href="<?php echo base_url(); ?>index.php/staff/studentprofile/<?php echo $late[$k]['adm_no']; ?>">
                                                                                <div class="tile-icon">
                                                                                    <img src= "<?php echo base_url() . "index.php/staff/getstudphoto/" . $late[$k]['adm_no'] . "/THUMB"; ?> " alt="">
                                                                                </div>
                                                                                <div class="tile-text"><?php echo $late[$k]['firstname'] . ' ' . $late[$k]['lastname'] ?></div>
                                                                                <!--</div>-->
                                                                            </a>
                                                                        </li>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>



                                                            </ul>
                                                        </div></div></div></div></div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div>
                                <div class="col-md-3">
                                    <div class="card ">
                                        <div class="card-head">
                                            <header>Birthdays</header>
                                            <div class="tools">
                                                <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                            </div>
                                        </div><!--end .card-head -->
                                        <div style="height: 322px;" class="nano myscroll">
                                            <div style="right: -15px;" tabindex="0" >
                                                <div  style="height: 320px;">
                                                    <div  tabindex="0" style="right: -1px;">
                                                        <div style="height: auto;" class="card-body no-padding ">
                                                            <ul class="list">
                                                                <?php for ($i = 0; $i < count($birthday); $i++) { ?>
                                                                    <li class="tile" >
                                                                        <a class="btn btn-flat btn-danger ink-reaction">
                                                                            <i class="fa fa-birthday-cake"></i>
                                                                        </a>
                                                                        <a class="tile-content ink-reaction" href="<?php
                                                                        if ($birthday[$i]['type'] == 'STUDENT') {
                                                                            echo base_url();
                                                                            ?>index.php/staff/studentprofile/<?php echo $birthday[$i]['adm_no'] ?><?php } else { ?><?php echo base_url() ?>index.php/staff/staffprofile/ <?php echo $birthday[$i]['id'] ?> <?php } ?>">
                                                                            <div class="tile-text">
                                                                                <p class="text-sm" ><?php echo $birthday[$i]['firstname'] . ' ' . $birthday[$i]['lastname'] ?></p>
                                                                                <small><?php echo $birthday[$i]['type'] ?>: <strong><?php echo $birthday[$i]['day'] ?></strong></small>
                                                                            </div>

                                                                            <div class="tile-icon">
                                                                                <img alt="" src="<?php
                                                                                if ($birthday[$i]['type'] == 'STUDENT') {
                                                                                    echo base_url() . "index.php/staff/getstudphoto/" . $birthday[$i]['adm_no'] . "/THUMB"
                                                                                    ?><?php } else { ?><?php echo base_url() . "index.php/staff/getphoto/" . $birthday[$i]['id'] . " /THUMB"; ?> <?php } ?>">
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>


                                                            </ul>
                                                        </div></div></div></div></div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div>


                                <!-- END NEW REGISTRATIONS -->
                                <div class="col-md-3">
                                    <div class="card" >
                                        <div class="card-head">
                                            <header>Exam Datesheet</header>
                                            <div class="tools">
                                                <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                            </div>
                                        </div><!--end .card-head -->
                                        <div style="height: 322px;" class="nano myscroll">
                                            <div style="right: -15px;" tabindex="0" >
                                                <div  style="height: 320px;">
                                                    <div  tabindex="0">
                                                        <div style="height: auto;" class="card-body no-padding ">
                                                            <ul class="list">

                                                                <?php if ($examDatesheet == -1) { ?>
                                                                    <li class="tile">
                                                                        <div class="tile-content">

                                                                            <div class="tile-text">No Entry Found</div>
                                                                        </div>

                                                                    </li>
                                                                    <?php
                                                                } else {
                                                                    for ($i = 0; $i < count($examDatesheet); $i++) {
                                                                        ?>
                                                                    <li class="tile" >
                                                                            <a class="btn btn-flat btn-info ink-reaction">
                                                                                <span>&bullet;</span>
                                                                            </a>
                                                                            <a class="tile-content ink-reaction pull-left" href="#offcanvas-demo-left" data-toggle="offcanvas" ng-click="examSchedule(examName = '<?php echo $examDatesheet[$i]['exam_name']; ?>',<?php echo $examDatesheet[$i]['id']; ?>)">
                                                                                <div class="tile-text">
                                                                                    <p class="text-sm"><?php echo $examDatesheet[$i]['exam_name'] . '(' .'class '. $examDatesheet[$i]['standard'] . ')'; ?></p>
                                                                                </div>
                                                                            </a>
                                                                        </li>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>



                                                            </ul>
                                                        </div></div>
                                                    </div>
                                            </div>
                                            
                                                
                                        </div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div>
                            </div><!--end .row -->
                        </div><!--end .section-body -->
                    </section>

                </div>

                <!--</section>-->
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
        </div>
        <?php
        $this->load->view('include/headjs');
        ?>
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
        <script src="<?php echo base_url(); ?>assets/myjs/admindashboard.js"></script>
        <script>
                                                                                var schoolcode = "<?php echo $s_code; ?>"
        </script>
        <script>
            function blinker() {
                $('.blinking').fadeOut(500);
                $('.blinking').fadeIn(500);
            }
            setInterval(blinker, 1000);
            $(function () {
                $('#myGraph').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Last 7 Days '
                    },
                    exporting: {
                        enabled: false
                    },
                    credits: {
                        enabled: false
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        categories: <?php echo json_encode($loginGraph['wrkngDay']); ?>,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'No. of students/Teachers logined'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y: 1f}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                            name: 'Students',
                            data: <?php echo str_replace('"', '', json_encode($loginGraph['studentLogin'])); ?>,
                        }, {
                            name: 'Teachers',
                            data: <?php echo str_replace('"', '', json_encode($loginGraph['staffLogin'])); ?>,
                        }]
                });
            });
        </script>
