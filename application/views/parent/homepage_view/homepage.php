<!DOCTYPE html>
<html lang="en">
    <title>Home Page</title>
    <head>
        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="homepage" ng-controller="homepageController">
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
                            <?php for ($i = 0; $i < count($studentList); $i++) { ?>
                                <div class="col-md-6"> 
                                    <div class="card card-bordered style-gray-dark">
                                        <!--end .card-head -->

                                        <div class="card-body small-padding">

                                            <div class="no-margin">
                                                <div class="pull-left width-3 clearfix hidden-xs">
                                                    <img class="img-circle size-2" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . $studentList[$i]['adm_no'] . "/THUMB"; ?>" alt="">
                                                </div>
                                                <h1 class="text-light no-margin"><a href="<?php echo base_url(); ?>index.php/parent/switchstudent/<?php echo $studentList[$i]['adm_no']; ?>"><?php echo $studentList[$i]['firstname'] . ' ' . $studentList[$i]['lastname']; ?></a></h1>
                                                <h5 class="text-light">
                                                    Section : <?php echo $studentList[$i]['class'] . ' ' . $studentList[$i]['section'] ?>
                                                </h5>
                                            </div>

                                        </div><!--end .card-body -->

                                    </div><!--end .card -->

                                </div> 
                            <?php } ?>
                        </div>
                        <div class="row">

                            <div class="col-lg-6 col-sm-12">
                                <div class="card">
                                    <div class="card-head card-head-xs style-default-dark text-center">
                                        <header>Notifications</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">

                                        <div role="alert" class="alert alert-callout alert-success margin-bottom-lg small-padding" ng-show="notificationData.marks != 0" ng-repeat="noitimarks in notificationData.marks| orderBy:'-timestamp' | limitTo:2">
                                            {{noitimarks.data.subject}}  marks for {{noitimarks.data.exam_name}} entered.
                                        </div>
                                        <div role="alert" class="alert alert-callout alert-blue margin-bottom-lg small-padding"  ng-show="notificationData.card != 0" ng-repeat="noiticard in notificationData.card| orderBy:'-timestamp' | limitTo:2" >
                                            Got {{noiticard.data.card_type}} Card from {{noiticard.data.staff_name}}.
                                        </div>
                                        <!--                                        <div role="alert" class="alert alert-callout alert-info margin-bottom-lg small-padding" ng-show="'{{noitiData.type}}'== ''">
                                                                                    Math FA2 marks for Term-I entered.
                                                                                </div>-->
                                        <div role="alert" class="alert alert-callout alert-warning margin-bottom-lg small-padding" ng-show="notificationData.event != 0" ng-repeat="noitievent in notificationData.event| orderBy:'-timestamp' | limitTo:2">
                                            {{noitievent.data.work}} in {{noitievent.data.event_name}} .
                                        </div>
                                    </div>
                                </div><!--end .card -->
                            </div><!--end .col -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="card">
                                    <div class="card-head card-head-xs style-default-dark text-center">
                                        <header>News Updates</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding" style="height: 260px;overflow: hidden;">
                                        <marquee direction="up" scrollamount="2" onmouseover="this.stop();" onmouseout="this.start();">
                                            <div ng-repeat="upNews in newsData| orderBy:'date'">
                                                <div role="alert" class="alert alert-info margin-bottom-lg small-padding" ng-show="'{{upNews.type}}'== 'EVENT'">{{upNews.data.name}} start on {{upNews.data.date| date:'MMM d, y'}}. Venue of this event is {{upNews.data.venue}}.</div>
                                                <div role="alert" class="alert alert-danger margin-bottom-lg small-padding" ng-show="'{{upNews.type}}'=='DATESHEET'">Date Sheet of {{upNews.data.exam_name}} schedule uploaded on {{upNews.data.publish_date| date:'MMM d, y'}}.</div>
                                                <div role="alert" class="alert alert-warning margin-bottom-lg small-padding" ng-show=" '{{upNews.type}}'== 'HOLIDAY'">Holiday on {{upNews.data.date| date:'MMM d, y'}} due to {{upNews.data.holiday_reason}}.</div>
                                                <!--<div role="alert" class="alert alert-info margin-bottom-lg small-padding">Inter School Event -2016 will start from 19th Aug 2016</div>-->
                                                <!--<div role="alert" class="alert alert-success margin-bottom-lg small-padding">Manoj kumar 12 A won the first prize in Maths Quiz. Congratulations!</div>-->
                                            </div>
                                        </marquee>
                                    </div>
                                </div><!--end .card -->
                                <div class="card">
                                    <div class="card-head card-head-xs style-default-dark text-center">
                                        <header>Holiday List</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">
                                        <div role="alert" class="alert alert-info margin-bottom-lg small-padding" ng-repeat="holidyData in holidayData"><strong>{{holidyData.data.date}} ({{holidyData.data.weekday}} )</strong><br/>{{holidyData.data.holiday_reason}}</div>
                                    </div>
                                </div><!--end .card -->
                            </div><!--end .col -->

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
                    <!-- BEGIN MAIN MENU -->
                    <?php
                    $this->load->view('include_parent/sidemenu.php');
                    ?>
                    <!-- END MAIN MENU -->

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
        <!-- END JAVASCRIPT -->
        <script>var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>/assets/parentjs/homepage.js"></script>



    </body>
</html>