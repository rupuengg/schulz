
<!DOCTYPE html>
<html lang="en">
    <title>
        Student Profile
    </title>
    <?php
    $session_id = $this->session->userdata('staff_id');
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style>
        .progress{
            margin-bottom: 0px
        }
        td{
            padding: 5px
        }
        .myNewClass{
            position: relative;
            float: left;

        }
        .newtimeline{
            padding-left: 20px;
            overflow-y: scroll;
            height: 500px;
            width: 100%;
        }
        .textareapadding{
            padding-top: 4px;
            padding-right: 0px;
            padding-bottom: 4px;
            padding-left: 0px;
        }
    </style>
    <body class="menubar-hoverable header-fixed ">
        <?php $this->load->view('include/header'); ?>
        <div id="base" ng-app="StudentDetails">
            <div id="content" ng-controller="StudentProfileDetails"  ng-cloak ng-class="cloak">
                <div class="offcanvas">

                    <!-- BEGIN OFFCANVAS DEMO LEFT -->
                    <div id="offcanvas-demo-right-blue" class="offcanvas-pane width-6">
                        <div class="offcanvas-head">
                            <header>Issue Blue Card</header>
                            <div class="offcanvas-tools">
                                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                            <div class="col-xs-12">
                                <label for="textarea2">Reason:</label>
                                <div class="form-group floating-label">
                                    <textarea name="textarea2" ng-model="todo"id="textarea2" class="form-control" rows="3" placeholder=""></textarea>

                                </div>

                            </div>
                            <button type="button" id="Blue"  class="btn btn-small ink-reaction btn-raised btn-primary" ng-click="issueBluecard(todo, $event)"><i class="md md-add-circle">Issue</i></button>
                        </div>
                    </div>
                    <div id="offcanvas-demo-right-yellow" class="offcanvas-pane width-6">
                        <div class="offcanvas-head">
                            <header>Issue Yellow Card</header>
                            <div class="offcanvas-tools">
                                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                            <div class="col-xs-12">
                                <label>Reason:</label>
                                <div class="form-group floating-label">
                                    <textarea ng-model="todo" class="form-control" rows="3" placeholder=""></textarea>

                                </div>

                            </div>
                            <button type="button" id="Yellow"  class="btn btn-small ink-reaction btn-raised btn-primary" ng-click="issueBluecard(todo, $event)"><i class="md md-add-circle">Issue</i></button>
                        </div>
                    </div>
                    <div id="offcanvas-demo-right-pink" class="offcanvas-pane width-6">
                        <div class="offcanvas-head">
                            <header>Issue Pink Card</header>
                            <div class="offcanvas-tools">
                                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                            <div class="col-xs-12">
                                <label for="textarea2">Reason:</label>
                                <div class="form-group floating-label">
                                    <textarea name="textarea2" ng-model="todo"id="textarea2" class="form-control" rows="3" placeholder=""></textarea>

                                </div>

                            </div>
                            <button type="button" id="Pink"  class="btn btn-small ink-reaction btn-raised btn-primary" ng-click="issueBluecard(todo, $event)"><i class="md md-add-circle">Issue</i></button>
                        </div>
                    </div>
                    <div id="offcanvas-demo-right-red" class="offcanvas-pane width-6">
                        <div class="offcanvas-head">   
                            <div >
                                <header>Issue Red Card</header>
                            </div>
                            <div class="offcanvas-tools">
                                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                            <div class="col-xs-12">
                                <label for="textarea2">Reason:</label>
                                <div class="form-group floating-label">
                                    <textarea name="textarea2" ng-model="todo"id="textarea2" class="form-control" rows="3" placeholder=""></textarea>

                                </div>

                            </div>
                            <button type="button" id="Red"  class="btn btn-small ink-reaction btn-raised btn-danger" ng-click="issueBluecard(todo, $event)"><i class="md md-add-circle">Issue</i></button>
                        </div>
                    </div>
                    <!-- END OFFCANVAS DEMO LEFT -->

                </div><!--end .offcanvas-->
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head">

                                        <header>Student Profile</header>


                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">


                                        <div class="col-lg-9">

                                            <div class="card tabs-right style-default-light">
                                                <ul class="card-head nav nav-tabs text-center" data-toggle="tabs">
                                                    <li class="active"><a href="#summary"><i class="fa fa-lg fa-user"></i><br><h4>Summary<br><small>Basic details</small></h4></a></li>
                                                    <li><a href="#attendance"><i class="fa fa-lg fa-clock-o"></i><h4>Attendance<br></h4></a></li>
                                                    <li><a href="#cardsdetail"><i class="fa fa-lg fa-clock-o"></i><br><h4>Cards<br></h4></a></li>
                                                    <li><a href="#personal"><i class="fa fa-lg fa-clock-o"></i><br><h4>Personal<br></h4></a></li>
                                                    <li><a href="#subject"><i class="fa fa-lg fa-clock-o"></i><br><h4>Subject<br></h4></a></li>
                                                </ul>
                                                <div class="card-body tab-content style-default-bright">
                                                    <div class="tab-pane active" id="summary">	

                                                        <!--                                                        <div>
                                                                                                                    <h3 class="text-light"><strong>{{data.biodata.firstname}} {{data.biodata.lastname}} {{data.biodata.standard}}{{data.biodata.section}}</strong></h3></div>-->
                                                        <div class="myNewClass" style="min-height: 50px;">
                                                            <img ng-src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{data.biodata.adm_no}}/THUMB"; ?>" alt="">
                                                        </div>
                                                        <div class="myNewClass">  
                                                            <dl class="dl-horizontal">
                                                                <dt>Adm.No</dt>
                                                                <dd><strong>: </strong>{{data.biodata.adm_no}}</dd>
                                                                <dt>Name</dt>
                                                                <dd><strong>: </strong>{{data.biodata.firstname}} {{data.biodata.lastname}}</dd>
                                                                <dt>Sex</dt>
                                                                <dd><strong>: </strong>{{data.biodata.sex}}</dd>
                                                                <dt>Date Of Birth</dt>
                                                                <dd><strong>: </strong>{{data.biodata.dob_date}}</dd>
                                                                <dt>Class</dt>
                                                                <dd><strong>: </strong>{{data.section.standard}} {{data.section.section}}</dd>

                                                            </dl>

                                                        </div>

                                                        <div style="float: left; position: relative;width: 100%;" style="overflow: scroll">
                                                            <div class="card">
                                                                <div class="card-head card-head-xs style-primary">
                                                                    <header>Summary Details</header>

                                                                </div>
                                                                <ul class="timeline collapse-lg timeline-hairline newtimeline">
                                                                    <li class="timeline-inverted" ng-if="data.absent.length == 0 && data.late.length == 0 && data.All.length == 0">
                                                                        <div class="timeline-entry">
                                                                            <div class="card style-default-bright">
                                                                                <div class="card-body small-padding">
                                                                                    <span class="text-medium text-center">No Entry Found </span>

                                                                                </div><!--end .card-body -->
                                                                            </div><!--end .card -->
                                                                        </div>

                                                                    </li>
                                                                    <li class="timeline-inverted" ng-repeat="absent in data.absent">
                                                                        <div class="timeline-circ circ-xl style-primary"><span class="glyphicon glyphicon-leaf"></span></div>
                                                                        <div class="timeline-entry">
                                                                            <div class="card style-default-bright">
                                                                                <div class="card-body small-padding">
                                                                                    <img class="img-circle img-responsive pull-left width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{data.biodata.adm_no}}/THUMB"; ?>" alt="">
                                                                                    <span class="text-medium">{{data.biodata.firstname}} {{data.biodata.lastname}} <a class="text-primary" href="javascript:void(0);">Absent</a> <span class="text-primary" ng-show="absent.reason!=''"> <span class="text-default">because </span> {{absent.reason}}</span></span><br>
                                                                                    <span class="opacity-50">
                                                                                        {{absent.day}}, {{absent.date}}
                                                                                    </span>
                                                                                </div><!--end .card-body -->
                                                                            </div><!--end .card -->
                                                                        </div><!--end .timeline-entry -->
                                                                    </li>
                                                                    <li class="timeline-inverted" ng-repeat="late in data.late">
                                                                        <div class="timeline-circ circ-xl style-primary"><span class="glyphicon glyphicon-leaf"></span></div>
                                                                        <div class="timeline-entry">
                                                                            <div class="card style-default-bright">
                                                                                <div class="card-body small-padding">
                                                                                    <img class="img-circle img-responsive pull-left width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{data.biodata.adm_no}}/THUMB"; ?>" alt="">
                                                                                    <span class="text-medium">{{data.biodata.firstname}} {{data.biodata.lastname}} <a class="text-primary" href="javascript:void(0);">Late</a><span class="text-primary" ng-show="late.reason!=''"><span class="text-default">with</span> {{late.reason}}</span></span><br>
                                                                                    <span class="opacity-50">
                                                                                        {{late.day}}, {{absent.date}}
                                                                                    </span>
                                                                                </div><!--end .card-body -->
                                                                            </div><!--end .card -->
                                                                        </div><!--end .timeline-entry -->
                                                                    </li>

                                                                    <li class="timeline-inverted" ng-repeat="cards in data.All">
                                                                        <div class="timeline-circ circ-xl" style="background:{{cards.card_type}}"><span class="glyphicon glyphicon-leaf"></span></div>
                                                                        <div class="timeline-entry">
                                                                            <div class="card style-default-bright">
                                                                                <div class="card-body small-padding">
                                                                                    <img class="img-circle img-responsive pull-left width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{data.biodata.adm_no}}/THUMB"; ?>" alt="">
                                                                                    <span class="text-medium">{{data.biodata.firstname}} {{data.biodata.lastname}} issued <a class="text-primary" href="javascript:void(0);">{{cards.card_type}} </a> card <span class="text-primary" ng-show="cards.remarks!='' && cards.remarks!='undefined'"><span class="text-default">for reason</span> {{cards.remarks}}</span></span><br>
                                                                                    <span class="opacity-50">
                                                                                        {{cards.day}}, {{cards.date}}
                                                                                    </span>
                                                                                </div><!--end .card-body -->
                                                                            </div><!--end .card -->
                                                                        </div><!--end .timeline-entry -->
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="attendance">
                                                        <!--                                                        <div>
                                                                                                                    <h3 class="text-light"><strong>{{data.biodata.firstname}} {{data.biodata.lastname}} {{data.biodata.standard}}{{data.biodata.section}}</strong></h3></div>-->
                                                        <div class="myNewClass" style="width: 30%;min-height: 50px;">
                                                            <img src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{data.biodata.adm_no}}/THUMB"; ?>" alt="">
                                                        </div>
                                                        <div class="myNewClass"  style="width: 70%">  
                                                            <dl class="dl-horizontal">
                                                                <dt>Adm.No</dt>
                                                                <dd><strong>: </strong>{{data.biodata.adm_no}}</dd>
                                                                <dt>Name:</dt>
                                                                <dd><strong>: </strong>{{data.biodata.firstname}} {{data.biodata.lastname}}</dd>
                                                                <dt>Sex:</dt>
                                                                <dd><strong>: </strong>{{data.biodata.sex}}</dd>
                                                                <dt>Date Of Birth:</dt>
                                                                <dd><strong>: </strong>{{data.biodata.dob_date}}</dd>
                                                                <dt>Class:</dt>
                                                                <dd><strong>: </strong>{{data.section.standard}} {{data.section.section}}</dd>

                                                            </dl>

                                                        </div>
                                                        <div style="float: left; position: relative;width: 100%;"> 
                                                            <div class="card">
                                                                <div class="card-head card-head-xs style-primary">
                                                                    <header>Attendance</header>

                                                                </div><!--end .card-head -->
                                                                <ul class="timeline collapse-lg timeline-hairline">
                                                                    <li class="timeline-inverted" ng-if="data.absent.length == 0">
                                                                        <div class="timeline-entry">
                                                                            <div class="card style-default-bright">
                                                                                <div class="card-body small-padding">
                                                                                    <span class="text-medium text-center">No Entry Found </span>

                                                                                </div><!--end .card-body -->
                                                                            </div><!--end .card -->
                                                                        </div>

                                                                    </li>
                                                                    <li class="timeline-inverted" ng-repeat="absent in data.absent">
                                                                        <div class="timeline-circ circ-xl style-primary"><span class="glyphicon glyphicon-leaf"></span></div>
                                                                        <div class="timeline-entry">
                                                                            <div class="card style-default-bright">
                                                                                <div class="card-body small-padding">
                                                                                    <img class="img-circle img-responsive pull-left width-1" src= "{{data.basicdata.profile_pic_path}}" alt="">
                                                                                    <span class="text-medium">{{data.biodata.firstname}} {{data.biodata.lastname}} <a class="text-primary" href="javascript:void(0);">Absent</a> <span class="text-primary" ng-show="absent.reason!=''"> <span class="text-default">with</span> {{absent.reason}}</span></span><br>
                                                                                    <span class="opacity-50">
                                                                                        {{absent.day}}, {{absent.date}}
                                                                                    </span>
                                                                                </div><!--end .card-body -->
                                                                            </div><!--end .card -->
                                                                        </div><!--end .timeline-entry -->
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="tab-pane" id="cardsdetail">
                                                        <!--                                                        <div>
                                                                                                                    <h3 class="text-light"><strong>{{data.biodata.firstname}} {{data.biodata.lastname}} {{data.biodata.standard}}{{data.biodata.section}}</strong></h3></div>-->
                                                        <div class="myNewClass" style="width: 30%;min-height: 50px;">
                                                            <img src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{data.biodata.adm_no}}/THUMB"; ?>" alt="">
                                                        </div>
                                                        <div class="myNewClass"  style="width: 70%">  
                                                            <dl class="dl-horizontal">
                                                                <dt>Adm.No</dt>
                                                                <dd><strong>: </strong>{{data.biodata.adm_no}}</dd>
                                                                <dt>Name</dt>
                                                                <dd><strong>: </strong>{{data.biodata.firstname}} {{data.biodata.lastname}}</dd>
                                                                <dt>Sex</dt>
                                                                <dd><strong>: </strong>{{data.biodata.sex}}</dd>
                                                                <dt>Date Of Birth</dt>
                                                                <dd><strong>: </strong>{{data.biodata.dob_date}}</dd>
                                                                <dt>Class</dt>
                                                                <dd><strong>: </strong>{{data.section.standard}} {{data.section.section}}</dd>

                                                            </dl>

                                                        </div>
                                                        <div style="float: left; position: relative;width: 100%;"> 
                                                            <div class="card">
                                                                <div class="card-head card-head-xs style-primary">
                                                                    <header>Cards</header>

                                                                </div><!--end .card-head -->
                                                                <ul class="timeline collapse-lg timeline-hairline">
                                                                    <li class="timeline-inverted" ng-if="data.All == 0">
                                                                        <div class="timeline-entry">
                                                                            <div class="card style-default-bright">
                                                                                <div class="card-body small-padding">
                                                                                    <span class="text-medium text-center">No Entry Found </span>

                                                                                </div><!--end .card-body -->
                                                                            </div><!--end .card -->
                                                                        </div>

                                                                    </li>
                                                                    <!--ngRepeat: absent in data.absent <ul class="timeline collapse-md">-->
                                                                    <li class="timeline-inverted" ng-repeat="cards in data.All">
                                                                        <div class="timeline-circ circ-xl" style="background:{{cards.card_type}}"><span class="glyphicon glyphicon-leaf"></span></div>
                                                                        <div class="timeline-entry">
                                                                            <div class="card style-default-bright">
                                                                                <div class="card-body small-padding">
                                                                                    <img class="img-circle img-responsive pull-left width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{data.biodata.adm_no}}/THUMB"; ?>" alt="">
                                                                                    <span class="text-medium">{{data.biodata.firstname}} {{data.biodata.lastname}} issued <a class="text-primary" href="javascript:void(0);">{{cards.card_type}} </a> card <span class="text-primary" ng-show="cards.remarks!='' && cards.remarks!='undefined'"><span class="text-default">for reason</span> {{cards.remarks}}</span></span><br>
                                                                                    <span class="opacity-50">
                                                                                        {{cards.day}}, {{cards.date}}
                                                                                    </span>
                                                                                </div><!--end .card-body -->
                                                                            </div><!--end .card -->
                                                                        </div><!--end .timeline-entry -->
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="tab-pane" id="personal">
                                                        <!--                                                        <div>
                                                                                                                    <h3 class="text-light"><strong>{{data.biodata.firstname}} {{data.biodata.lastname}} {{data.biodata.standard}}{{data.biodata.section}}</strong></h3></div>-->
                                                        <div class="myNewClass" style="width: 30%;min-height: 50px;">
                                                            <img src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{data.biodata.adm_no}}/THUMB"; ?>" alt="">
                                                        </div>
                                                        <div class="myNewClass"  style="width: 70%">  
                                                            <dl class="dl-horizontal">
                                                                <dt>Adm.No</dt>
                                                                <dd><strong>: </strong>{{data.biodata.adm_no}}</dd>
                                                                <dt>Name</dt>
                                                                <dd><strong>: </strong>{{data.biodata.firstname}} {{data.biodata.lastname}}</dd>
                                                                <dt>Sex</dt>
                                                                <dd><strong>: </strong>{{data.biodata.sex}}</dd>
                                                                <dt>Date Of Birth</dt>
                                                                <dd><strong>: </strong>{{data.biodata.dob_date}}</dd>
                                                                <dt>Class</dt>
                                                                <dd><strong>: </strong>{{data.section.standard}} {{data.section.section}}</dd>

                                                            </dl>

                                                        </div>
                                                        <div style="float: left; position: relative;width: 100%;">
                                                            <div class="card">
                                                                <div class="card-head card-head-xs style-primary">
                                                                    <header>Personal Details</header>

                                                                </div><!--end .card-head -->
                                                                <div class="card-body myNewClass" style="padding: 0px">
                                                                    <dl class="dl-horizontal" >
                                                                        <dt>Adm.No</dt>
                                                                        <dd><strong>: </strong>{{data.biodata.adm_no}}</dd>
                                                                        <dt>Name</dt>
                                                                        <dd><strong>: </strong>{{data.biodata.firstname}} {{data.biodata.lastname}}</dd>
                                                                        <dt>Sex</dt>
                                                                        <dd><strong>: </strong>{{data.biodata.sex}}</dd>
                                                                        <dt>Email Id</dt>
                                                                        <dd><strong>: </strong>{{data.biodata.e_mail}}</dd>
                                                                        <dt>Date Of Birth</dt>
                                                                        <dd><strong>: </strong>{{data.biodata.dob_date}}</dd>
                                                                        <dt>Address</dt>
                                                                        <dd><strong>: </strong>{{data.biodata.address1}} {{data.biodata.address2}} {{data.biodata.city}} {{data.biodata.state}}</dd>
                                                                        <dt>Class</dt>
                                                                        <dd><strong>: </strong>{{data.section.standard}}{{data.section.section}}</dd>

                                                                    </dl>
                                                                </div><!--end .card-body -->
                                                            </div>
                                                        </div>
                                                        <div style="float: left; position: relative;width: 100%;">
                                                            <div class="card">
                                                                <div class="card-head card-head-xs style-primary">
                                                                    <header>Family Details</header>

                                                                </div><!--end .card-head -->
                                                                <div class="card-body" style="padding: 0px">
                                                                    <div class="col-sm-12">
                                                                        <div class="col-sm-6">
                                                                            <div style="text-align: center">
                                                                                <header>Father</header>
                                                                            </div>
                                                                            <div class="myNewClass">    
                                                                            <dl class="dl-horizontal">
                                                                                <dt>Name</dt>
                                                                                <dd><strong>: </strong>{{data.relation[0].g_name}}</dd>
                                                                                <dt>Qualification</dt>
                                                                                <dd><strong>: </strong>{{data.relation[0].g_quali}}</dd>
                                                                                <dt>Occupation</dt>
                                                                                <dd><strong>: </strong>{{data.relation[0].g_occp}}</dd>
                                                                                <dt>Designation</dt>
                                                                                <dd><strong>: </strong>{{data.relation[0].g_desig}}</dd>
                                                                                <dt>Department</dt>
                                                                                <dd><strong>: </strong>{{data.relation[0].g_dept}}</dd>
                                                                                <dt>Office Address</dt>
                                                                                <dd><strong>: </strong>{{data.relation[0].g_office_add}}</dd>
                                                                                <dt>Home Address</dt>
                                                                                <dd><strong>: </strong>{{data.relation[0].g_home_add}}</dd>
                                                                                <dt>Mobile</dt>
                                                                                <dd><strong>: </strong>{{data.relation[0].g_mob}}</dd>
                                                                                <dt>Email Id</dt>
                                                                                <dd><strong>: </strong>{{data.relation[0].g_mail}}</dd>

                                                                            </dl>
                                                                        </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div style="text-align: center">
                                                                                <header>Mother</header>
                                                                            </div>
                                                                            <div class="myNewClass">
                                                                            <dl class="dl-horizontal">
                                                                                <dt>Mother Name</dt>
                                                                                <dd><strong>: </strong>{{data.relation[1].g_name}}</dd>
                                                                                <dt>Qualification</dt>
                                                                                <dd><strong>: </strong>{{data.relation[1].g_quali}}</dd>
                                                                                <dt>Occupation</dt>
                                                                                <dd><strong>: </strong>{{data.relation[1].g_occp}}</dd>
                                                                                <dt>Designation</dt>
                                                                                <dd><strong>: </strong>{{data.relation[1].g_desig}}</dd>
                                                                                <dt>Department</dt>
                                                                                <dd><strong>: </strong>{{data.relation[1].g_dept}}</dd>
                                                                                <dt>Office Address</dt>
                                                                                <dd><strong>: </strong>{{data.relation[1].g_office_add}}</dd>
                                                                                <dt>Home Address</dt>
                                                                                <dd><strong>: </strong>{{data.relation[1].g_home_add}}</dd>
                                                                                <dt>Mobile</dt>
                                                                                <dd><strong>: </strong>{{data.relation[1].g_mob}}</dd>
                                                                                <dt>Email Id</dt>
                                                                                <dd><strong>: </strong>{{data.relation[1].g_mail}}</dd>
                                                                            </dl>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div><!--end .card-body -->
                                                            </div>
                                                        </div>
                                                        <div style="float: left; position: relative;width: 100%;">
                                                            <div class="card">
                                                                <div class="card-head card-head-xs style-primary">
                                                                    <header>Medical Details</header>
                                                                </div><!--end .card-head -->
                                                                <div class="card-body myNewClass" style="padding: 0px">
                                                                    <dl class="dl-horizontal">
                                                                        <dt>Blood Group</dt>
                                                                        <dd><strong>: </strong>{{data.medical.blood_group}}</dd>
                                                                        <dt>Height</dt>
                                                                        <dd><strong>: </strong>{{data.medical.height}}</dd>
                                                                        <dt>Weight</dt>
                                                                        <dd><strong>: </strong>{{data.medical.weight}}</dd>
                                                                        <dt>Vision Left</dt>
                                                                        <dd><strong>: </strong>{{data.medical.vision_left}}</dd>
                                                                        <dt>Vision Right</dt>
                                                                        <dd><strong>: </strong>{{data.medical.vision_right}}</dd>
                                                                        <dt>Teeth</dt>
                                                                        <dd><strong>: </strong>{{data.medical.teeth}}</dd>
                                                                        <dt>Hygiene</dt>
                                                                        <dd><strong>: </strong>{{data.medical.hygiene}}</dd>
                                                                        <dt>Allergy</dt>
                                                                        <dd><strong>: </strong>{{data.medical.allergies}}</dd>
                                                                        <dt>Medication</dt>
                                                                        <dd><strong>: </strong>{{data.medical.medication}}</dd>
                                                                        <dt>Physician Name</dt>
                                                                        <dd><strong>: </strong>{{data.medical.physician_name}}</dd>
                                                                        <dt>Physician Phone</dt>
                                                                        <dd><strong>: </strong>{{data.medical.physician_phone}}</dd>

                                                                    </dl>
                                                                </div><!--end .card-body -->
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="tab-pane" id="subject">
                                                        <!--                                                        <div>
                                                                                                                    <h3 class="text-light"><strong>{{data.biodata.firstname}} {{data.biodata.lastname}} {{data.biodata.standard}}{{data.biodata.section}}</strong></h3></div>-->
                                                        <div class="myNewClass" style="width: 30%;min-height: 50px;">
                                                            <img src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{data.biodata.adm_no}}/THUMB"; ?>" alt="">
                                                        </div>
                                                        <div class="myNewClass"  style="width: 70%">  
                                                            <dl class="dl-horizontal">
                                                                <dt>Adm.No</dt>
                                                                <dd><strong>: </strong>{{data.biodata.adm_no}}</dd>
                                                                <dt>Name</dt>
                                                                <dd><strong>: </strong>{{data.biodata.firstname}} {{data.biodata.lastname}}</dd>
                                                                <dt>Sex</dt>
                                                                <dd><strong>: </strong>{{data.biodata.sex}}</dd>
                                                                <dt>Date Of Birth</dt>
                                                                <dd><strong>: </strong>{{data.biodata.dob_date}}</dd>
                                                                <dt>Class</dt>
                                                                <dd><strong>: </strong>{{data.section.standard}} {{data.section.section}}</dd>

                                                            </dl>

                                                        </div>
                                                        <div style="float: left; position: relative;width: 100%;">
                                                            <div class="card">
                                                                <div class="card-head card-head-xs style-primary">
                                                                    <header>Subject</header>

                                                                </div><!--end .card-head -->
                                                                <div class="card-body newtimeline" style="padding: 0px">
                                                                    <table class="table table-bordered no-margin">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Subject Name</th>
                                                                                <th>Subject Teacher</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr ng-if="data.subject.length == 0">
                                                                                <td colspan="2" style="text-align: center">No Entry Found</td>
                                                                            </tr>
                                                                            <tr ng-repeat="subjectlist in data.subject">

                                                                                <td>{{subjectlist.subject_name}}</td>
                                                                                <td><a class="tile-content ink-reaction" href="<?php echo base_url(); ?>index.php/staff/staffprofile/{{subjectlist.staff_id}}">{{subjectlist.teacher}}</a></td>
                                                                            </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div><!--end .card-body -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end .card -->


                                        </div><!--end .col -->
                                        <div class="col-lg-3">
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-head card-head-xs style-primary">
                                                            <header>Profile Status</header>
                                                            <div class="tools">
                                                                <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                                            </div>
                                                        </div><!--end .card-head -->
                                                        <div class="card-body" style="padding: 0px">
                                                            <table>
                                                                <tr>
                                                                    <td >Personal Detail</td>
                                                                    <td><div class="progress">
                                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                                                                 aria-valuemin="0" aria-valuemax="100" style="width:40%">
                                                                                40% Complete (success)
                                                                            </div>
                                                                        </div></td>
                                                                </tr>
                                                                <tr>
                                                                    <td >Guardian Detail</td>
                                                                    <td><div class="progress">
                                                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50"
                                                                                 aria-valuemin="0" aria-valuemax="100" style="width:50%">
                                                                                50% Complete (info)
                                                                            </div>
                                                                        </div></td>
                                                                </tr>
                                                                <tr>
                                                                    <td >Medical Detail</td>
                                                                    <td><div style="margin-top: -5px" class="progress">
                                                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60"
                                                                                 aria-valuemin="0" aria-valuemax="100" style="width:60%">
                                                                                60% Complete (warning)
                                                                            </div>
                                                                        </div></td>
                                                                </tr>
                                                               
                                                            </table>
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div>
                                                <div class="col-lg-12 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-head card-head-xs style-primary">
                                                            <header>Cards</header>

                                                        </div><!--end .card-head -->
                                                        <div class="card-body no-side-padding">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="col-lg-6">
                                                                        <a class="ink-reaction" href="#offcanvas-demo-right-blue" data-toggle="offcanvas">
                                                                            <div class="card">
                                                                                <div class="card-body style-info small-padding text-center"><p class="text-xl no-margin">{{data.card.BLUE.length}}</p></div>
                                                                            </div><!--end .card -->
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <a class="ink-reaction" href="#offcanvas-demo-right-yellow" data-toggle="offcanvas">
                                                                            <div class="card">
                                                                                <div class="card-body style-warning small-padding text-center" style="background-color: #FFFF00;"><p class="text-xl no-margin">{{data.card.YELLOW.length}}</p></div>
                                                                            </div><!--end .card -->
                                                                        </a>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="col-lg-6">
                                                                        <a class="ink-reaction" href="#offcanvas-demo-right-pink" data-toggle="offcanvas">
                                                                            <div class="card no-margin">
                                                                                <div class="card-body small-padding text-center"  style="background-color: #F52887; border-color: #ff00cc; color: #ffffff;"><p class="text-xl no-margin">{{data.card.PINK.length}}</p></div>
                                                                            </div></a><!--end .card -->
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <a class="ink-reaction" href="#offcanvas-demo-right-red" data-toggle="offcanvas">
                                                                            <div class="card">
                                                                                <div class="card-body style-danger small-padding text-center" style="background-color: #FF0000;"><p class="text-xl no-margin">{{data.card.RED.length}}</p></div>
                                                                            </div>
                                                                        </a><!--end .card -->
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div>




                                            </div><!--
    
    
    
                                        </div><!--end .card-body -->
                                        </div><!--end .card -->

                                    </div><!--end .col -->

                                </div>
                            </div><!--end .row -->
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
                var std_id = "<?php echo $admno; ?>";
                var login = "<?php echo $session_id; ?>";
                var base_url = "<?php echo base_url(); ?>";
            </script>
            <script src="<?php echo base_url(); ?>assets/myjs/studentprofile.js"></script>