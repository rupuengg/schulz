
<!DOCTYPE html>
<html lang="en">
    <title>Staff Profile</title>
    <?php
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
    </style>
    <body class="menubar-hoverable header-fixed ">
        <?php $this->load->view('include/header'); ?>
        <div id="base" ng-app="staffProfileDetails">

            <!-- BEGIN CONTENT-->
            <div id="content" ng-controller="staffProfileDetailsController" ng-cloak ng-class="cloak">
                <section>
                    <?php
//                    $data = json_decode($data, TRUE);
//                    $basicdetails = $data['basicdata'];
//                    $medical = $data['medical'];
                    ?>
                    <div class="section-body">
                        <div class="card">

                            <!-- BEGIN CONTACT DETAILS HEADER -->
                            <div class="card-head style-primary">
                                <header>Staff Profile</header>
                                <div class="tools pull-right">
                                    <form class="navbar-search" role="search">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="contactSearch" placeholder="Search Staff">
                                        </div>
                                        <!--<button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>-->
                                    </form>
                                </div><!--end .tools -->
                                <!--                                <div class="tools">
                                                                    <a class="btn btn-flat hidden-xs" href="search.html"><span class="glyphicon glyphicon-arrow-left"></span> &nbsp;Back to search results</a>
                                                                </div>end .tools -->
                            </div><!--end .card-head -->
                            <!-- END CONTACT DETAILS HEADER -->

                            <!-- BEGIN CONTACT DETAILS -->
                            <div class="card-tiles">
                                <div class="hbox-md col-md-12">
                                    <div class="hbox-column col-md-9">
                                        <div class="row">
                                            <!-- BEGIN CONTACTS MAIN CONTENT -->
                                            <div class="col-sm-12">
                                                <div class="margin-bottom-xxl">
                                                    <div class="pull-left width-4 clearfix hidden-xs">
                                                        <img class="img-rounded size-3" src="<?php echo base_url(); ?>index.php/staff/getphoto/<?php echo $staff_id; ?>/THUMB" alt="" />
                                                    </div>{{profileData.classTeach}}
                                                    <h1 class="no-margin"><span> {{profileData[0].salutation}} {{profileData[0].staff_fname}} {{profileData[0].staff_lname}} <small> {{profileData[0].qualification}}</small></span></h1>

                                                    <h4 ng-show="profileData[0].classTeach!='-1'">Class Teacher: {{profileData[0].classTeach}}</h4>
                                                   
                                                    <!--                                                    <div class="star-rating">
                                                                                                            <input type="number" name="rating" class="rating" value="3"/>
                                                                                                        </div>-->
                                                </div><!--end .margin-bottom-xxl -->
                                                <ul class="nav nav-tabs" data-toggle="tabs">
                                                    <li class="active"><a href="#activity">ACTIVITY</a></li>
                                                    <li><a href="#personal">PERSONAL</a></li>
                                                    <li><a href="#subject">SUBJECT</a></li>
                                                    <li><a href="#event">EVENTS</a></li>
                                                </ul>
                                                <div class="tab-content">

                                                    <!-- BEGIN ACTIVITY -->
                                                    <div class="tab-pane active" id="activity">
                                                        <hr class="no-margin"/>
                                                        <ul class="timeline collapse-md">

                                                            <li ng-if="data.cards.BLUE.length == 0 && data.cards.YELLOW.length == 0 && data.cards.PINK.length == 0 && data.cards.RED.length == 0">
                                                                <p class="text-medium text-center" >
                                                                    No Entry Found
                                                                </p>
                                                            </li>

                                                            <li class="timeline-inverted" ng-repeat="bluecard in data.cards['BLUE'] | orderBy:'-card_issue_date'" ng-show="bluecard.remarks != '' && bluecard.remarks != 'undefined'">
                                                                <div class="timeline-circ circ-xl style-info"><span class="glyphicon glyphicon-credit-card"></span></div>
                                                                <div class="timeline-entry">
                                                                    <div class="card style-default-light">
                                                                        <div class="card-body small-padding">
                                                                            <img class="img-circle img-responsive pull-left width-1" src="<?php echo base_url() . 'index.php/staff/getstudphoto/{{bluecard.adm_no}}/THUB' ?>" alt="" />
                                                                            <span class="text-medium"> 
                                                                                Issued
                                                                                <a class="text-primary" href="javascript:void(0)">{{bluecard.card_type}} Card</a> to
                                                                                <span class="text-primary"><a class="tile-content ink ink-reaction" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{bluecard.adm_no}}">{{bluecard.adm_no}}. {{bluecard.firstname}} {{bluecard.lastname}}</a></span> for 
                                                                                <span class="text-primary">{{bluecard.remarks}}</span>
                                                                                <br/>
                                                                                <span class="opacity-50" >
                                                                                    {{bluecard.card_issue_date}}
                                                                                </span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li ng-repeat="yellowcards in data.cards['YELLOW'] | orderBy:'-card_issue_date'" ng-show="yellowcards.remarks != '' && yellowcards.remarks != 'undefined'">
                                                                <div class="timeline-circ circ-xl style-warning"><span class="glyphicon glyphicon-credit-card"></span></div>
                                                                <div class="timeline-entry">
                                                                    <div class="card style-default-light">
                                                                        <div class="card-body small-padding">
                                                                            <img class="img-circle img-responsive pull-left width-1" src="<?php echo base_url() . 'index.php/staff/getstudphoto/{{yellowcards.adm_no}}/THUB' ?>" alt="" />
                                                                            <span class="text-medium"> 
                                                                                Issued
                                                                                <a class="text-primary" href="javascript:void(0)">{{yellowcards.card_type}} Card</a> to
                                                                                <span class="text-primary"><a class="tile-content ink ink-reaction" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{yellowcards.adm_no}}">{{yellowcards.adm_no}}. {{yellowcards.firstname}} {{yellowcards.lastname}}</a></span> for 
                                                                                <span class="text-primary">{{yellowcards.remarks}}</span>
                                                                                <br/>
                                                                                <span class="opacity-50" >
                                                                                    {{yellowcards.card_issue_date}}
                                                                                </span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="timeline-inverted" ng-repeat="pinkcards in data.cards['PINK']| orderBy:'-card_issue_date'" ng-show="pinkcards.remarks != '' && pinkcards.remarks != 'undefined'">
                                                                <div class="timeline-circ circ-xl " style="background-color: #F52887;"><span class="glyphicon glyphicon-credit-card"></span></div>
                                                                <div class="timeline-entry">
                                                                    <div class="card style-default-light">
                                                                        <div class="card-body small-padding">
                                                                            <img class="img-circle img-responsive pull-left width-1" src="<?php echo base_url() . 'index.php/staff/getstudphoto/{{pinkcards.adm_no}}/THUB' ?>" alt="" />
                                                                            <span class="text-medium"> 
                                                                                Issued
                                                                                <a class="text-primary" href="javascript:void(0)">{{pinkcards.card_type}} Card</a> to
                                                                                <span class="text-primary"><a class="tile-content ink ink-reaction" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{pinkcards.adm_no}}">{{pinkcards.adm_no}}. {{pinkcards.firstname}} {{pinkcards.lastname}}</a></span> for 
                                                                                <span class="text-primary">{{pinkcards.remarks}}</span>
                                                                                <br/>
                                                                                <span class="opacity-50" >
                                                                                    {{pinkcards.card_issue_date}}
                                                                                </span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li ng-repeat="redcards in data.cards['RED']| orderBy:'-card_issue_date'" ng-show="redcards.remarks != '' && redcards.remarks != 'undefined'">
                                                                <div class="timeline-circ circ-xl style-danger"><span class="glyphicon glyphicon-credit-card"></span></div>
                                                                <div class="timeline-entry">
                                                                    <div class="card style-default-light" >
                                                                        <div class="card-body small-padding">
                                                                            <img class="img-circle img-responsive pull-left width-1" src="<?php echo base_url() . 'index.php/staff/getstudphoto/{{redcards.adm_no}}/THUB' ?>" alt="" />
                                                                            <span class="text-medium"> 
                                                                                Issued
                                                                                <a class="text-primary" href="javascript:void(0)">{{redcards.card_type}} Card</a> to
                                                                                <span class="text-primary"><a class="tile-content ink ink-reaction" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{redcards.adm_no}}">{{redcards.adm_no}}. {{redcards.firstname}} {{redcards.lastname}}</a></span> for 
                                                                                <span class="text-primary">{{redcards.remarks}}</span>
                                                                                <br/>
                                                                                <span class="opacity-50" >
                                                                                    {{redcards.card_issue_date}}
                                                                                </span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>


                                                        </ul>
                                                    </div>
                                                    <!-- END ACTIVITY -->


                                                    <!-- BEGIN PERSONAL DETAILS -->
                                                    <div class="tab-pane myNewClass" id="personal" style="margin-left:220px;" >

                                                        <h3 class="opacity-75 text-center">Personal Details</h3>
                                                        <dl class="dl-horizontal" ng-repeat="personal in data.profile">
                                                            <dt>Date of Birth</dt>
                                                            <dd><strong>: </strong>{{personal.dob_date}}</dd>
                                                            <dt>Date of Joining</dt>
                                                            <dd><strong>: </strong>{{personal.date_of_joining}}</dd>
                                                            <dt>Designation</dt>
                                                            <dd><strong>: </strong>{{data.depart.designation}}</dd>
                                                            <dt>Department</dt>
                                                            <dd><strong>: </strong>{{data.depart.department}}</dd>
                                                            <dt>Qualification</dt>
                                                            <dd><strong>: </strong>{{personal.qualification}}</dd>
                                                            <dt>Experience</dt>
                                                            <dd><strong>: </strong>{{personal.experience}}</dd>
                                                            <dt>Extra Skill</dt>
                                                            <dd><strong>: </strong>{{personal.extra_skills}}</dd>
                                                            <dt>Address</dt>
                                                            <dd><strong>: </strong>{{personal.staff_add}}</dd>
                                                            <dt>Home Phone</dt>
                                                            <dd><strong>: </strong>{{personal.staff_landline}}</dd>
                                                            <dt>Mobile Phone</dt>
                                                            <dd><strong>: </strong>{{personal.mobile_no_for_sms}}</dd>
                                                        </dl>
                                                    </div>
                                                    <!-- END PERSONAL DETAILS -->

                                                    <!-- BEGIN SUBJECT -->
                                                    <div class="tab-pane" id="subject">
                                                        <ul class="list">
                                                            <li class="tile" ng-if="data.class.length == '0'">
                                                                <span class="tile-content ink-reaction" href="#2">
                                                                    <div class="tile-text" style="text-align: center">
                                                                        No Entry Found
                                                                    </div>

                                                                </span>

                                                            </li>

                                                            <li class="tile" ng-repeat="subjectlist in data.class">
                                                                <span class="tile-content ink-reaction" href="#2">
                                                                    <div class="tile-text">
                                                                        {{subjectlist.sbject}} ({{subjectlist.standard}}{{subjectlist.section}})
                                                                        <small>FA1, FA2, SA1 Marks Entry Done</small>
                                                                    </div>
                                                                    <div class="tile-icon" data-toggle="tooltip" data-placement="left" title="" data-original-title="1101.Prateek Mehrotra - Highest Achiever">
                                                                        <!--<img src="<?php echo base_url(); ?>assets/img/main/2.jpg" alt="">-->
                                                                    </div>
                                                                </span>

                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <!-- END SUBJECT -->

                                                    <!-- BEGIN EVENT -->
                                                    <div class="tab-pane" id="event"> 
                                                        <h3 class="opacity-75 text-center">Event Details</h3>
                                                        <ul class="timeline collapse-md">
                                                            <li ng-if="data.eventincharge.length == '0' && data.eventvolunteer.length == '0'" >
                                                                <span class="text-medium"> 
                                                                    No Entry Found
                                                                </span>
                                                            </li>

                                                            <li class="timeline-inverted" ng-repeat="incharge in data.eventincharge | orderBy:'-on_date'">
                                                                <div class="timeline-circ circ-xl style-info"><span class="glyphicon glyphicon-credit-card"></span></div>
                                                                <div class="timeline-entry">
                                                                    <div class="card style-default-light">
                                                                        <div class="card-body small-padding">
                                                                            <!--<img class="img-circle img-responsive pull-left width-1" src="<?php echo base_url() . 'assets/img/main/2.jpg' ?>" alt="" />-->
                                                                            <span class="text-medium"> 
                                                                                Incharge of 
                                                                                <a class="text-primary" href="javascript:void(0)">{{incharge.name}}</a> at
                                                                                <span class="text-primary"> {{incharge.venue}}</span> from 
                                                                                <span class="text-primary">{{incharge.on_date}}</span> to 
                                                                                <span class="text-primary">{{incharge.event_end_date}}</span>
                                                                                <br/>
                                                                                <span class="opacity-50" >
                                                                                    Volunteer: {{incharge.volunteer}} / Member: {{incharge.member}} / Team: {{incharge.team}}
                                                                                </span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li ng-repeat="volunteer in data.eventvolunteer | orderBy:'-on_date' " ng-show="volunteer.name != undefined">
                                                                <div class="timeline-circ circ-xl style-info"><span class="glyphicon glyphicon-credit-card"></span></div>
                                                                <div class="timeline-entry">
                                                                    <div class="card style-default-light">
                                                                        <div class="card-body small-padding">
                                                                            <!--<img class="img-circle img-responsive pull-left width-1" src="<?php echo base_url() . 'assets/img/main/2.jpg' ?>" alt="" />-->
                                                                            <span class="text-medium"> 
                                                                                Volunteer of 
                                                                                <a class="text-primary" href="javascript:void(0)">{{volunteer.name}}</a> at
                                                                                <span class="text-primary"> {{volunteer.venue}}</span> from 
                                                                                <span class="text-primary">{{volunteer.on_date}}</span> to 
                                                                                <span class="text-primary">{{volunteer.event_end_date}}</span>
                                                                                <br/>
                                                                                <span class="opacity-50" >
                                                                                    Member: {{volunteer.member}} / Team: {{volunteer.team}}
                                                                                </span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- END EVENT -->

                                                </div><!--end .tab-content -->
                                            </div><!--end .col -->
                                            <!-- END CONTACTS MAIN CONTENT -->

                                        </div><!--end .row -->
                                    </div><!--end .hbox-column -->

                                    <!-- BEGIN CONTACTS COMMON DETAILS -->
                                    <div class="hbox-column col-sm-3 style-primary-light">
                                        <div class="row">
                                            <div class="col-xs-12 no-padding">
                                                <h3 class="no-margin">Profile Status</h3>
                                                <div class="card-body no-side-padding">
                                                    <table class="col-sm-12">
                                                        <tr>
                                                            <td>Personal Detail</td>
                                                            <td>
                                                                <div class="progress margin-bottom-lg">
                                                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                                                         aria-valuemin="0" aria-valuemax="100" style="width:40%">
                                                                        40% Complete (success)
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td >Marks Entry</td>
                                                            <td><div class="progress margin-bottom-lg">
                                                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50"
                                                                         aria-valuemin="0" aria-valuemax="100" style="width:45%">
                                                                        45% Complete (info)
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <h3 class="no-margin">Cards</h3>
                                                <div class="card-body no-side-padding">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-6">
                                                                <!--<a class="ink-reaction" href="#offcanvas-demo-right-blue" data-toggle="offcanvas">-->
                                                                <div class="card">
                                                                    <div class="card-body style-info small-padding text-center"><p class="text-xl no-margin" >{{data.cards.BLUE.length}}</p></div>
                                                                </div>
                                                                <!--</a>end .card -->
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <!--<a class="ink-reaction" href="#offcanvas-demo-right-yellow" data-toggle="offcanvas">-->
                                                                <div class="card">
                                                                    <div class="card-body style-warning small-padding text-center" style="background-color: #FFFF00;"><p class="text-xl no-margin">{{data.cards.YELLOW.length}}</p></div>
                                                                </div>
                                                                <!--</a>end .card -->
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-6">
                                                                <!--<a class="ink-reaction" href="#offcanvas-demo-right-pink" data-toggle="offcanvas">-->
                                                                <div class="card">
                                                                    <div class="card-body small-padding text-center"  style="background-color: #F52887; border-color: #ff00cc; color: #ffffff;"><p class="text-xl no-margin">{{data.cards.PINK.length}}</p></div>
                                                                </div>
                                                                <!--</a>end .card -->
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <!--<a class="ink-reaction" href="#offcanvas-demo-right-red" data-toggle="offcanvas">-->
                                                                <div class="card">
                                                                    <div class="card-body style-danger small-padding text-center" style="background-color: #FF0000;"><p class="text-xl no-margin">{{data.cards.RED.length}}</p></div>
                                                                </div>
                                                                <!--</a>end .card -->
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div><!--end .col -->
                                        </div><!--end .row -->
                                    </div><!--end .hbox-column -->
                                    <!-- END CONTACTS COMMON DETAILS -->
                                </div><!--end .hbox-md -->
                            </div><!--end .card-tiles -->
                            <!-- END CONTACT DETAILS -->
                        </div><!--end .card -->
                    </div><!--end .section-body -->
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
            </div>
        </div>
        <?php
        $this->load->view('include/headjs');
        ?>
        <script>
            var staff_id = "<?php echo $staff_id; ?>";
            var base_url = "<?php echo base_url(); ?>";

        </script>

        <script src="<?php echo base_url(); ?>assets/myjs/staffprofile.js?v=<?php echo rand(); ?>"></script>
    </body>
</html>
