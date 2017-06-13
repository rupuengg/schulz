<!DOCTYPE html>
<html lang="en">
    <title>Homework</title>
    <head>
        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="homework" ng-controller="homeworkController">
        <!-- BEGIN HEADER-->
        <?php
        $this->load->view('include_parent/header');
        ?>
        <script> var Fulldata = <?php echo json_encode($homeWorkFulldeatils); ?>;</script>
        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body" ng-cloak>
                        <div class="row">
                            <div class="row">
                                <div class="text-center text-warning" style="margin-top: 16%;" ng-show="homeworkData == -1">
                                    <i class="fa fa-wrench fa-15x"></i><br/>
                                    <p class="text-xxl text-ultra-bold">No Data Found Yet...</p> 
                                </div>
                                <div class="col-lg-6 col-sm-12" ng-show="homeworkData != -1">
                                    <div class="no-padding">
                                        <div role="alert" class="alert alert-callout alert-warning margin-bottom-lg" ng-repeat="homework in homeworkData">
                                            <div class="row" >
                                                <div class="col-lg-1 no-padding">
                                                    <img src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{homework.data.staff_id}}" . "/THUMB"; ?>" class="img-circle img-responsive width-1">
                                                </div>
                                                <div class="col-lg-11">

                                                    <strong>{{homework.data.type}}</strong><br/>
                                                    <a href="<?php echo base_url(); ?>index.php/parent/homework/{{homework.data.hw_id}}"><p class="no-margin">{{homework.data.title}}. Last date of submission is {{homework.data.last_date|date:'dd MMM,yyyy'}}</p></a>

                                                    <a class="text-xs"><i>{{homework.data.staff_name}}</i></a>

                                                    <i class="text-xs no-margin pull-right text-primary-dark">{{homework.timestamp}}</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--end .col -->
                                <?php if ($homeWorkFulldeatils != -1) { ?>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="card">
                                            <div class="card-body small-padding">
                                                <h4 class="text-center">HomeWork Fulldetail</h4>
                                                <dl class="dl-horizontal  text-center">
                                                    <dt>Title:</dt>
                                                    <dd>{{FullDeatil.title}}</dd>
                                                    <dt>Homework Given On:</dt>
                                                    <dd>{{FullDeatil.hw_date|date:'dd MMM,yyyy'}}</dd>
                                                    <dt>Last Date Of Submission:</dt>
                                                    <dd>{{FullDeatil.last_date|date:'dd MMM,yyyy'}}</dd>
                                                    <dt>Count Submit work:</dt>
                                                    <dd>{{FullDeatil.complete}}</dd>
                                                    <dt>Count Non-Submit work:</dt>
                                                    <dd>{{FullDeatil.incomplete}}</dd>
                                                    <dt>Your Submission Status:</dt>
                                                    <dd>{{FullDeatil.studentStatus}}</dd>
                                                    <dt>Your Submission Date:</dt>
                                                    <dd>{{FullDeatil.studSubmitDate|date:'dd MMM,yyyy'}}</dd>
                                                </dl>
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
        <script>
                    var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>/assets/parentjs/homework.js"></script>
    </body>
</html>