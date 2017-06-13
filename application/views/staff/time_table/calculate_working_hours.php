<!DOCTYPE html>
<html lang="en">
    <title>MasterTable</title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/autocomplete/angucomplete-alt.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/autocomplete/fonts/bariol/bariol.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote9fec.css?1422823374" />

    <style>
        .myProButtons{
            position: relative;
            float: right;
            margin-left: 5px
        }
        .decorateMe{
            text-decoration: underline;
        }
    </style>
    <body class="menubar-hoverable header-fixed " ng-app="WorkingHoursApp" ng-controller="WorkingHoursController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-head style-primary card-head-xs">
                                        <header>Manage Working Hours Module</header>
                                    </div>
                                    <div class="card-body">

                                        <form novalidate="" name="tripForm" class="form-horizontal ng-pristine ng-invalid ng-invalid-required" role="form">

                                            <div class="form-group">
                                                <label for="help13" class="col-sm-5 control-label">No. of working Days:</br>
                                                    (in a week)
                                                </label>
                                                <div class="col-sm-5">
                                                    <input type="text" required="" class="form-control ng-pristine ng-invalid ng-invalid-required" id="regular13" ng-model="worksetting.working_days" ng-pattern="/^[0-9]+$/"><div class="form-control-line"></div><div class="form-control-line"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="help13" class="col-sm-5 control-label">Total Working Hours:</br>
                                                    (in a week)
                                                </label>
                                                <div class="col-sm-5">
                                                    <input type="text" required=""  class="form-control ng-pristine ng-invalid ng-invalid-required ng-valid-pattern" id="regular13" ng-model="worksetting.working_hours" ><div class="form-control-line"></div><div class="form-control-line"></div>
                                                </div>
                                            </div>
                                            <div class="card-body  height-3">
                                                <br>
                                                <button type="button" class="btn ink-reaction btn-raised btn-primary " ng-click="saveworkinghour()">Save</button>
                                            </div>

                                        </form>




                                    </div><!--end .card-body -->

                                </div>


                            </div>

                        </div><!--end .section-body -->

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
                var myURL = "<?php echo base_url(); ?>";</script>

            <script src="<?php echo base_url(); ?>assets/js/autocomplete/angucomplete-alt.js"></script>
            <script src="<?php echo base_url(); ?>assets/myjs/timetable/timetable.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/angular-touch.min.js"></script>
