<!DOCTYPE html>
<html lang="en">
    <title>Tardy</title>
    <head>
        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="tardy" ng-controller="tardyController" ng-cloak ng-class="cloak">
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
                                     <div class="card " ng-show="lateData == 0">
                                        <div class="card-body">
                                            <div class="text-success text-center">
                                                <i class="fa fa-smile-o fa-15x"></i>
                                                <br/>
                                                <p class="text-xl"><?php echo $this->session->userdata('current_name'); ?> has never been late to school.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="no-padding" ng-show="lateData != 0">
                                        <div role="alert" class="alert alert-callout alert-warning margin-bottom-lg" ng-repeat="lateAttData in lateData| orderBy:'-timestamp'">
                                            <div class="row" >
                                                <div class="col-lg-1 no-padding">
                                                    <img class="img-circle img-responsive width-1" src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{lateAttData.data.staff_id}}" . "/THUMB"; ?>"/>
                                                </div>
                                                <div class="col-lg-11">
                                                    Came late on
                                                    <strong>{{lateAttData.data.coming_date| date:'MMM d, y'}}</strong><br/>
                                                    <p class="no-margin">{{lateAttData.data.reason}}</p>

                                                    <a class="text-xs"><i>- {{lateAttData.data.staff_name}}</i></a>

                                                    <i class="text-xs no-margin pull-right text-primary-dark">{{lateAttData.timestamp}}</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--end .col -->
                                <div class="col-lg-6 col-sm-12">




                                    <div class="card style-primary">
                                        <div class="card-body no-padding text-center">
                                            <strong class="text-xxl">Today!</strong><span class="text-lg"><?php echo $this->session->userdata('current_name'); ?> isn't tardy.</span>
                                        </div>
                                    </div>
                                    <div class="no-padding">
                                        <div class="panel-group" id="accordion2">
                                            <div class="card panel" ng-repeat="myTardy in summaryData">
                                                <div class="card-head card-head-xs" data-toggle="collapse" data-parent="#accordion2" data-target="#accordion2-{{$index}}">
                                                    <header class="pull-left">{{myTardy.month + '-' + myTardy.year}}</header>
                                                    <header class="pull-right">Tardiness - {{myTardy.tardiness}}</header>

                                                </div>
                                                <div id="accordion2-{{$index}}" class="collapse">
                                                    <div class="card-body no-padding" ng-repeat="reason in myTardy.tardyDetail">
                                                        <div role="alert" class="alert alert-callout no-y-padding no-margin alert-danger">
                                                            <strong>{{reason.coming_date| date:'MMM d, y'}}</strong>
                                                            <p>{{reason.reason}}</p>
<!--                                                                    <a class="text-sm"> <i>-Kumar Gaurav Rupani</i></a>-->
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
        <script>var myURL = "<?php echo base_url(); ?>";</script>

        <?php
        $this->load->view('include_parent/headjs');
        ?>
        <script src="<?php echo base_url(); ?>/assets/parentjs/tardy.js"></script>
        <!-- END JAVASCRIPT -->
    </body>
</html>