<!DOCTYPE html>
<html lang="en">
    <title>Events</title>
    <head>

        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <script>
        var data = <?php echo json_encode($eventdetail); ?>;
    </script>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="events" ng-controller="eventsController">
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
                                <div class="text-center text-warning" style="margin-top: 16%;" ng-show="eventData == 0">
                                    <i class="fa fa-wrench fa-15x"></i><br/>
                                    <p class="text-xxl text-ultra-bold">No Data Found Yet...</p> 
                                </div>

                                <div class="col-lg-6 col-sm-12" ng-show="eventData != 0">
                                    <div class="no-padding" ng-repeat="myEvents in eventData">
                                        <div role="alert" class="alert alert-callout alert-warning margin-bottom-lg ">
                                            <div class="row">
                                                <div class="col-lg-1 no-padding">
                                                    <img class="img-circle img-responsive width-1" src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{myEvents.data.staff_id}}" . "/THUMB"; ?>"/>
                                                </div>
                                                <div class="col-lg-11">
                                                    <strong>{{myEvents.data.work}} </strong> in <a href="<?php echo base_url(); ?>index.php/parent/events/{{myEvents.data.eventId}}"><strong> {{myEvents.data.event_name}}</strong></a><br/>
                                                    <p class="no-margin ">{{myEvents.data.teams}} Teams | {{myEvents.data.teamMember}} Members </p>
                                                    <a class="text-xs"><i>{{myEvents.data.staff_name}}</i></a>
                                                    <i class="text-xs no-margin pull-right text-primary-dark">{{myEvents.timestamp}}</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--end .col -->
                                <?php if (!empty($eventdetail)) { ?>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="card" >
                                            <div class="card-body small-padding" ng-repeat="primaryInfo in eventDetails.eventInfo">

                                                <h3>{{primaryInfo.name}}</h3>

                                                <p class="text-justify">{{primaryInfo.name}} event start on {{primaryInfo.startDate| date:'MMM d, y'}} . Venue of this event is {{primaryInfo.venue}} .</p>
                                            </div>
                                            <div class="card-body no-padding style-gray-dark">
                                                <ul class="list divider-full-bleed" n>
                                                    <li class="tile">
                                                        <a href="#2" class="tile-content ink-reaction">
                                                            <div class="tile-icon">
                                                                <img alt="" src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{eventDetails.eventInchrg.id}}" . "/THUMB"; ?>">
                                                            </div>
                                                            <div class="tile-text">{{eventDetails.eventInchrg.name}}<small>Event-in-Charge</small></div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-head card-head-xs style-gray-dark">
                                                <header>Volunteers</header>
                                            </div>
                                            <div class="card-body no-padding">
                                                <ul class="list divider-full-bleed">

                                                    <li class="tile style-gray-bright" ng-repeat="staffName in eventDetails.staffVolun" >
                                                        <a class="tile-content ink-reaction" href="#2">
                                                            <div class="tile-text no-padding">
                                                                <p class="text-sm no-margin">{{staffName.name}} <span ng-show="type =='{{staffName.ctStatus}}'" >(Class Teacher)</span></p>
                                                                <p class="text-xs no-margin">Teaching - {{staffName.subjects}}</p>
                                                            </div>
                                                            <div class="tile-icon">
                                                                <img alt="" src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{staffName.id}}" . "/THUMB"; ?>">
                                                            </div>
                                                        </a>
                                                    </li>

                                                    <li class="tile" ng-repeat="studata in eventDetails.stuVolun">

                                                        <a class="tile-content ink-reaction" href="#2" >
                                                            <div class="tile-text no-padding">
                                                                <p class="text-sm no-margin">{{studata.stuName}}</p>
                                                                <p class="text-xs no-margin">Section : {{studata.class}}</p>
                                                            </div>
                                                            <div class="tile-icon">
                                                                <img alt="" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{studata.adm_no}}/THUMB"; ?>">
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!--end .col -->
                                <?php } ?>
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
        <!-- END JAVASCRIPT -->
        <script>
                    var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>/assets/parentjs/events.js"></script>
    </body>
</html>