
<!DOCTYPE html>
<html lang="en">
    <title>
        Manage Holiday Details
    </title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed" ng-app="holidayApp" ng-controller="holidayAppController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <div class="offcanvas">
                    <!-- BEGIN OFFCANVAS DEMO LEFT -->
                    <div class="offcanvas-pane width-12" id="offcanvas-demo-left" style="">
                        <div class="offcanvas-head">
                            <header style="margin-left: 20px;">Declare Large Holiday</header>
                            <div class="offcanvas-tools">
                                <a data-dismiss="offcanvas" class="btn btn-icon-toggle btn-default ">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>

                        <div class="nano has-scrollbar" style="height: 628.083px;"><div class="nano-content" tabindex="0" style="right: -13px;"><div class="offcanvas-body">

                                    <h4>Holiday details</h4>
                                    <form name="myForm" novalidate>
                                        <ul class="list-divided">
                                            <li><strong>Start Date</strong><br><span class="opacity-75">
                                                    <div class="input-group input-group-lg  "  >
                                                        <div class="input-group date datepickerMe" id="demo-date">
                                                           <datepicker date-format="dd-MM-yyyy">
                                                        <input type="text" class="form-control" ng-model="mainHL.holiday_sdate" ng-change="change()" placeholder="Publish Date" />
                                                         </datepicker>
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div></span></li>
                                            <li><strong>End Date</strong><br><span class="opacity-75"><div class="input-group input-group-lg  "  >
                                                        <div class="input-group date datepickerMe" id="demo-date">
                                                             <datepicker date-format="dd-MM-yyyy">
                                                             <input type="text" class="form-control" ng-model="mainHL.holiday_edate" ng-change="change()" placeholder="Publish Date" />
                                                             </datepicker>
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>

                                                    </div></span></li>
                                            <li><strong>Reason</strong><br><span class="opacity-75"><div class="input-group" id="demo-date">
                                                        <div class="input-group-content">
                                                            <input type="text" required ng-model="mainHL.holiday_reason" class="form-control">

                                                        </div>
                                                    </div>
                                                    </div></span></li>
                                    </form>
                                    <li><button ng-disabled="myForm.$invalid" ng-click="SaveLargeHoliday()" style="margin-left: 150px;" class="btn ink-reaction btn-raised btn-primary" type="button">Save</button></li>
                                    </ul>
                                </div></div><div class="nano-pane" style="display: none;"><div class="nano-slider" style="height: 615px; transform: translate(0px, 0px);"></div></div></div>
                    </div>
                    <!-- END OFFCANVAS DEMO LEFT -->
                </div>
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="md md-colorize"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Manage Holidays</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-8">

                                                </div>

                                                <div class="col-md-4" >
                                                    <div class="form-group" >
                                                        <a data-toggle="offcanvas" href="#offcanvas-demo-left" class="btn btn-raised btn-primary">
                                                            Declare Large Holiday
                                                        </a>
                                                        <!--<a style="width: 180px;position: relative;float: right;margin-left: 5px;margin-top: 24px" type="button" class="btn btn-block ink-reaction btn-primary" >Declare Large Holiday</a>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();
                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('session_holiday_details');
                                        $xcrud->columns("holiday_reason, date, holiday_type");
                                        $xcrud->order_by("id");
                                        $xcrud->fields("holiday_reason, date, holiday_type");
                                        $xcrud->validation_required("holiday_reason");
                                        $xcrud->validation_required("date");
                                        $xcrud->label("holiday_reason", "Holiday Reason");
                                        $xcrud->label("date", "Date");
                                        $xcrud->label("holiday_type", "Holiday Type");
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->pass_var("deo_entry_by", $deo_staff_id);
                                        $xcrud->limit(25);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_title();
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(TRUE);
                                        $xcrud->unset_remove(false);

                                        echo $xcrud->render();
                                        ?>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                            <div class="col-md-4">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> How to manage Holiday?</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        Add any holiday, all the holidays gets loaded. 

                                        Click on Add button to enter any new holiday in the database.

                                        <br>-> You can edit or delete any of the holiday if any activity has been done in it.

                                    </div>                                    </div><!--end .card-body -->
                            </div><!--end .card -->

                        </div>
                    </div><!--end .row -->
            </div><!--end .section-body -->
        </section>
    </div>
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
    echo Xcrud::load_js();
    ?>
    <script>
        (function ($, ng) {
            'use strict';
            var $val = $.fn.val; // save original jQuery function
// override jQuery function
            $.fn.val = function (value) {
// if getter, just return original
                if (!arguments.length) {
                    return $val.call(this);
                }
// get result of original function
                var result = $val.call(this, value);
// trigger angular input (this[0] is the DOM object)
                ng.element(this[0]).triggerHandler('input');
// return the original result
                return result;
            }
        })(window.jQuery, window.angular);
        var myURL = "<?php echo base_url(); ?>";
    </script>
     <script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
   <script src="<?php echo base_url(); ?>assets/myjs/holiday.js"></script>  
 