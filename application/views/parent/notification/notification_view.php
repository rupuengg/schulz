<!DOCTYPE html>
<html lang="en">
     <title>Notification</title>
    <head>

        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="notification" ng-controller="notificationcontroller">
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

                            <div class="col-lg-6 col-sm-12">
                                <div class="card">
                                    <div class="card-head card-head-xs style-default-dark text-center">
                                        <header>Notifications</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">
                                        <div ng-repeat="notificationdata in notificationdata| orderBy:'notificationdata.timestamp'"> 
                                            <div role="alert" class="alert alert-callout alert-warning margin-bottom-lg small-padding" ng-show="notificationdata.type == 'EVENT'">
                                                  {{notificationdata.data.name}} is scheduled on {{notificationdata.data.date}} at {{notificationdata.data.venue}}.
                                            </div>
                                            <div role="alert" class="alert alert-callout alert-danger margin-bottom-lg small-padding"ng-show="notificationdata.type == 'MARKS'">
                                                  Check the marks of {{notificationdata.data.subject}} for {{notificationdata.data.exam_fullname}} and you obtain {{notificationdata.data.marks}} out of {{notificationdata.data.max_marks}}.
                                            </div>
                                            <div role="alert" class="alert alert-callout alert-success margin-bottom-lg small-padding"ng-show="notificationdata.type == 'CLUB MEETING'">
                                                Meeting is scheduled on {{notificationdata.data.meetingdate}} at {{notificationdata.data.venue}} and meeting agenda is {{notificationdata.data.meetingagenda}}.
                                            </div>
                                            <div role="alert" class="alert alert-callout alert-info margin-bottom-lg small-padding" ng-show="notificationdata.type == 'CARD'">
                                                  Got the {{notificationdata.data.card_type}} card for {{notificationdata.data.remark}} on {{notificationdata.data.issue_date}}.
                                            </div>
                                            <div role="alert" class="alert alert-callout alert-warning margin-bottom-lg small-padding"ng-show="notificationdata.type == 'CCEGRADE'">
                                                 Got the grade '{{notificationdata.data.grade}}' by {{notificationdata.data.staff_name}} for {{notificationdata.data.cce_name}}.
                                            </div>
                                            <div role="alert" class="alert alert-callout alert-danger margin-bottom-lg small-padding" ng-show="notificationdata.type == 'DATESHEET'">
                                                  {{notificationdata.data.exam_name}} is started from {{notificationdata.data.publish_date}}
                                            </div>
                                            <div role="alert" class="alert alert-callout alert-blue margin-bottom-lg small-padding"ng-show="notificationdata.type == 'LIBRARY DETAIL'">
                                                  Book of {{notificationdata.data.book_name}} is issued on {{notificationdata.data.issue_date}} and due date is {{notificationdata.data.due_date}}.
                                            </div>
                                            <div role="alert" class="alert alert-callout alert-success margin-bottom-lg small-padding" ng-show="notificationdata.type == 'HOLIDAY'">
                                              School is closed on {{notificationdata.data.date}} cause of {{notificationdata.data.holiday_reason}}.
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end .card -->
                            </div><!--end .col -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="card" >
                                    <div class="card-head card-head-xs style-default-dark text-center">
                                        <!-- ngRepeat: dexam in dedata --><!-- ngIf: dexam.id == examshortname --><header >Stats</header><!-- end ngIf: dexam.id == examshortname --><!-- end ngRepeat: dexam in dedata --><!-- ngIf: dexam.id == examshortname --><!-- end ngRepeat: dexam in dedata --><!-- ngIf: dexam.id == examshortname --><!-- end ngRepeat: dexam in dedata --><!-- ngIf: dexam.id == examshortname --><!-- end ngRepeat: dexam in dedata --><!-- ngIf: dexam.id == examshortname --><!-- end ngRepeat: dexam in dedata --><!-- ngIf: dexam.id == examshortname --><!-- end ngRepeat: dexam in dedata -->
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">

                                        <div role="alert" class="alert alert-callout alert-warning margin-bottom-xl small-padding">
                                            <span class="ng-binding"><?php echo $this->session->userdata('current_name'); ?>'s Card</span>
                                        </div> 
                                        <div class="card-body small-padding">
                                            <div class="col-md-3" ng-repeat="cardStatsObj in cardStats">
                                                <div class="card card-issued card-issued-{{cardStatsObj.card_name}} no-margin u7">
                                                    <!--end .card-head -->
                                                    <div class="card-body no-padding">
                                                        <p class="text-xxxl text-center text-ultra-bold no-margin">{{cardStatsObj.count}}</p>      
                                                    </div><!--end .card-body -->
                                                </div><!--end .card -->
                                            </div>
                                        </div>

                                    </div>
                                    <div ng-repeat="stats in stats">
                                        <div class="card-body small-padding" ng-show="stats.type == 'ATTENDANCE DETAIL'">
                                            <div >
                                                <div role="alert" class="alert alert-callout alert-warning margin-bottom-xl small-padding ">
                                                    <span class="ng-binding"> {{stats.type}}</span>
                                                </div>   
                                                <div class="col-md-3 ng-scope ">
                                                    <div class="card card-issued no-margin card-issued-blue">
                                                        <!--end .card-head -->
                                                        <div class="card-body no-padding style-success">
                                                            <p class="text-ultra-bold  text-lg text-center  ng-binding">Total Day</p>    
                                                            <p class="text-xl text-center  ng-binding">{{stats.totalday}}</p>       
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div>
                                                <div class="col-md-3 ng-scope">
                                                    <div class="card card-issued no-margin card-issued-blue">
                                                        <!--end .card-head -->
                                                        <div class="card-body no-padding style-warning">
                                                            <p class="text-ultra-bold  text-lg text-center  ng-binding">Total Present</p>    
                                                            <p class="text-xl text-center  ng-binding">{{stats.totalpresent}}</p>    
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div>
                                                <div class="col-md-3 ng-scope">
                                                    <div class="card card-issued no-margin card-issued-blue">
                                                        <!--end .card-head -->
                                                        <div class="card-body no-padding style-danger">
                                                            <p class="text-ultra-bold   text-lg text-center  ng-binding">Total Absent</p>    
                                                            <p class="text-xl text-center  ng-binding">{{stats.totalabsent}}</p>     
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body small-padding" ng-show="stats.type == 'LIBRARY DETAIL'">
                                            <div >
                                                <div role="alert" class="alert alert-callout alert-warning margin-bottom-xl small-padding">
                                                    <span class="ng-binding"> {{stats.type}}</span>
                                                </div>   
                                                <div class="col-md-3 ng-scope">
                                                    <div class="card card-issued no-margin card-issued-blue">
                                                        <!--end .card-head -->
                                                        <div class="card-body no-padding style-success">
                                                            <p class="text-ultra-bold  text-lg text-center  ng-binding">Issued Book</p>    
                                                            <p class="text-xl text-center  ng-binding">{{stats.countissued}}</p>    
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div>
                                                <div class="col-md-3 ng-scope">
                                                    <div class="card card-issued no-margin card-issued-blue">
                                                        <!--end .card-head -->
                                                        <div class="card-body no-padding style-danger">
                                                            <p class="text-ultra-bold  text-lg text-center  ng-binding">Lost Book</p>    
                                                            <p class="text-xl text-center  ng-binding">{{stats.countlost}}</p>     
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-body small-padding" ng-show="stats.type == 'EVENT DETAIL'">
                                            <div >
                                                <div role="alert" class="alert alert-callout alert-warning margin-bottom-xl small-padding">
                                                    <span class="ng-binding"> {{stats.type}}</span>
                                                </div>   
                                                <div class="col-md-3 ng-scope">
                                                    <div class="card card-issued no-margin card-issued-blue">
                                                        <!--end .card-head -->
                                                        <div class="card-body no-padding style-accent-dark">
                                                            <p class="text-ultra-bold  text-lg text-center  ng-binding">Total Event</p>    
                                                            <p class="text-xl text-center  ng-binding">{{stats.counttotalevent}}</p>       
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div>
                                                 <div class="col-md-3 ng-scope">
                                                    <div class="card card-issued no-margin card-issued-blue">
                                                        <!--end .card-head -->
                                                        <div class="card-body no-padding style-info">
                                                            <p class="text-ultra-bold text-lg text-center  ng-binding">Event Attend</p>    
                                                            <p class="text-xl text-center  ng-binding">{{stats.countevent}}</p>       
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end .col -->

                        </div>

                    </div>
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
        <script> var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>/assets/parentjs/notification.js"></script>
    </body>
</html>