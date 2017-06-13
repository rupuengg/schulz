<!DOCTYPE html>
<html lang="en">
    <title>
        Manage Holiday Session
    </title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote9fec.css?1422823374" />
    <body class="menubar-hoverable header-fixed " ng-app="holidayApp" ng-controller="holidayAppController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content" >
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <header><i class="fa fa-fw fa-tag"></i>Manage Holiday</header>
                                    </div><!--end .card-head -->

                                    <div class="card-body style-default-bright">

                                        <div class="card-body"  style="margin-top: 20px;">
                                            <form name="myForm" novalidate>
                                                <div class="row">

                                                    <div class="col-sm-4">

                                                        <label  class="col-sm-4 control-label"><h4>Term-1</h4></label>
                                                        <div class="col-sm-8">
                                                            <div class="input-group input-group-lg  "  >
                                                                <div class="input-group date datepickerMe" id="demo-date">
                                                                    <div class="input-group-content">
                                                                        <datepicker date-format="yyyy-MM-dd">
                                                                            <input type="text" class="form-control" ng-model="mainHoliday.t1_sdate" />
                                                                        </datepicker>
                                                                    </div>
                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="col-sm-8">
                                                            <div class="input-group input-group-lg  "  >
                                                                <div class="input-group date datepickerMe" id="demo-date">
                                                                    <div class="input-group-content">
                                                                        <datepicker date-format="yyyy-MM-dd">
                                                                            <input type="text" class="form-control" ng-model="mainHoliday.t1_edate" />
                                                                        </datepicker>
                                                                    </div>
                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4" style="margin-top: 25px;">
                                                        <label for="Firstname5" class="col-sm-4 control-label"><h4>Term-2</h4></label>
                                                        <div class="col-sm-8">
                                                            <div class="input-group input-group-lg  "  >
                                                                <div class="input-group date datepickerMe" id="demo-date">
                                                                    <div class="input-group-content">
                                                                        <datepicker date-format="yyyy-MM-dd">
                                                                            <input type="text" class="form-control" ng-model="mainHoliday.t2_sdate" />
                                                                        </datepicker>
                                                                    </div>
                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4" style="margin-top: 25px;">


                                                        <div class="col-sm-8">
                                                            <div class="input-group input-group-lg  "  >
                                                                <div class="input-group date datepickerMe" id="demo-date">
                                                                    <div class="input-group-content">
                                                                        <datepicker date-format="yyyy-MM-dd">
                                                                            <input type="text" class="form-control" ng-model="mainHoliday.t2_edate" />
                                                                        </datepicker>
                                                                    </div>
                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        </form>


                                        <div class="row" style="margin-top: 15px; margin-left: 20px;">
                                            <div class=" checkbox checkbox-styled tile-text" >
                                                <label>
                                                    <input type="checkbox" ng-model="mainHoliday.sat"  >
                                                    <span style="padding-left: 25px;font-size: 16px;">
                                                        Saturday
                                                    </span>
                                                </label>
                                            </div>

                                            <div class="checkbox checkbox-styled tile-text">
                                                <label>
                                                    <input type="checkbox" ng-model="mainHoliday.sun">
                                                    <span style="padding-left: 25px;font-size: 16px;">
                                                        Sunday
                                                    </span>
                                                </label>
                                            </div>

                                        </div>

                                        <div class="row" style=" margin-left: 16px;">
                                            <p class="myProButtons" style="float: left"  ><button ng-disabled="myForm.$invalid " ng-click="UpdateTermSession()" type="button" class="btn btn-block ink-reaction btn-info">Save</button></p>
                                            <p  class="myProButtons" style="float: left"><button ng-disabled="myForm.$invalid" ng-click="cancelHoliday()" type="button" class="btn btn-block ink-reaction btn-danger">Cancel</button></p>
                                        </div>

                                    </div>




                                </div>
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
<script> var myURL = "<?php echo base_url(); ?>"; </script>
<script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>

<script src="<?php echo base_url(); ?>/assets/myjs/holiday.js"></script>