<!DOCTYPE html>
<html lang="en">
    <title>Academics</title>
    <head>

        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="academics" ng-controller="academicsController">
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

                                <div class="col-lg-6">
                                    <div class="card" ng-show="marksData == 0">
                                        <div class="card-body">
                                            <div class="text-danger text-center">
                                                <i class="fa fa-frown-o fa-15x"></i>
                                                <br/>
                                                <p class="text-xxl">Marks of <?php echo $this->session->userdata('current_name'); ?> not available yet</p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="no-padding" ng-show="marksData != 0">
                                        <div class="alert alert-callout alert-warning margin-bottom-lg" role="alert" ng-repeat="stuMarks in marksData| orderBy:'-timestamp'">
                                            <div class="row">
                                                <div class="col-lg-1 no-padding">
                                                    <img src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{stuMarks.data.staff_id}} " . "/THUMB"; ?>" class="img-circle img-responsive width-1">
                                                </div>
                                                <div class="col-lg-11">
                                                    <strong>{{stuMarks.data.subject}}</strong><br>
                                                    Obtained <strong>{{stuMarks.data.marks}}</strong> out of <strong>{{stuMarks.data.max_marks}}</strong> in <strong>{{stuMarks.data.exam_name}}</strong><br>
                                                    <a class="text-xs"><i>{{stuMarks.data.staff_name}}</i></a>
                                                    <i class="text-xs no-margin pull-right text-primary-dark">{{stuMarks.timestamp}}</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--end .col -->
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body no-padding">
                                            <div id="container"></div>
                                        </div>
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
                            <span class="text-lg text-bold text-primary ">Mera School Portal11</span>
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
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
        <!--        <script src="../../assets/js/modules/materialadmin/core/demo/DemoDashboard.js"></script>-->
        <!-- END JAVASCRIPT -->

        <script>
                                                                var myURL = "<?php echo base_url(); ?>";

        </script>
        <script src="<?php echo base_url(); ?>/assets/parentjs/academics.js"></script>
        <script type="text/javascript">
                                                               


        </script>
    </body>
</html>