
<!DOCTYPE html>
<html lang="en">
    <title>Attendance Summary</title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <body class="menubar-hoverable header-fixed " ng-app="AttSum" ng-controller="AttSumController" >
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg  ng-cloak">

                        <div class="card">
                            <div class="card-head card-head-xs style-primary">
                                <header><i class="fa fa-calendar" ></i> Attendence Summary </header>
                            </div><!--end .card-head -->
                            <div class="form-inline">
                                <div class="card no-margin">
                                    <div class="card-body small-padding">
                                        <div class="col-sm-3">
                                            <div class="form-group control-width-normal">
                                                <div class="input-group date" id="demo-date">
                                                    <datepicker date-format="dd-MM-yyyy">
                                                        <input type="text" class="form-control" ng-model="attendenceDate" ng-change="change()" placeholder="Publish Date" />
                                                    </datepicker>
<!--                                                    <div class="input-group-content">
                                                        <input  type="text" class="form-control datepickerMe" placeholder="Select Date">
                                                    </div>-->
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div><!--end .form-group -->
                                            <!--<button class="btn btn-raised btn-default-light ink-reaction" type="submit">Login</button>-->
                                        </div>
                                        <span ng-show="myError == null">
                                            <div class="col-sm-3">
                                                <div role="alert" class="alert alert-callout alert-info small-padding no-margin">
                                                    <p class="text-lg">Total Sections : <strong>{{status}}</strong></p>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div role="alert" class="alert alert-callout alert-success small-padding no-margin">
                                                    <p class="text-lg">Marked : <strong>{{marked}}</strong></p>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div role="alert" class="alert alert-callout alert-danger small-padding no-margin">
                                                    <p class="text-lg">Not Marked : <strong>{{unmarked}}</strong></p>
                                                </div>
                                            </div>

                                        </span>


                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div>
                            <div class="card-body small-padding">

                                <div ng-cloak ng-show="myError != null"  class="alert alert-danger no-margin" role="alert">
                                    {{myError}}
                                </div>

                                <div class="panel-group" id="accordion7">
                                    <div ng-cloak ng-show="myError == null" ng-repeat="i in myAttSum">
                                        <div  ng-if="i.status == 'MARKED'" class="card panel">
                                            <div class="card-head collapsed style-success" data-toggle="collapse" data-parent="#accordion7" data-target="#acc{{$index}}">
                                                <header>{{i.standard + ' ' + i.section + '-'}} {{i.student.length}} Absent out of <strong>{{i.total}}</strong></header>
                                                <header class="pull-right">{{i.teacher[0].staff_fname + ' ' + i.teacher[0].staff_lname}} <img class="img-circle width-1" src="<?php echo base_url(); ?>/index.php/staff/getphoto/{{i.teacher[0].id}}/THUMB" alt=""></header>


                                            </div>
                                            <div id="acc{{$index}}" class="collapse">
                                                <div class="card-body no-padding">
                                                    <ul class="list divider-full-bleed col-lg-offset-1">
                                                        <li class="tile" ng-repeat="AbsentListobj in i.student">
                                                            <a href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{AbsentListobj.adm_no}}" class="tile-content ink-reaction">
                                                                <div class="tile-icon">
                                                                    <img alt="" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{AbsentListobj.adm_no}}/THUMB"; ?>">
                                                                </div>
                                                                <div class="tile-text">{{AbsentListobj.adm_no + '.' + AbsentListobj.firstname + ' ' + AbsentListobj.lastname}}{{AbsentListobj.reason==""?'':' due to: '+AbsentListobj.reason}}</div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!--end .panel -->
                                        <div class="card panel" ng-if="i.status == 'UNMARKED'">
                                            <div class="card-head collapsed style-danger" data-toggle="collapse" data-parent="#accordion7" data-target="#acc{{$index}}">
                                                <header>{{i.standard + ' ' + i.section + '-' + 'Not Marked'}} </header>
                                                <header class="pull-right"><a href="<?php echo base_url(); ?>index.php/staff/staffprofile/{{i.teacher[0].id}}" class="tile-content ink-reaction">{{i.teacher[0].staff_fname + ' ' + i.teacher[0].staff_lname}} <img class="img-circle width-1" src="<?php echo base_url(); ?>/index.php/staff/getphoto/{{i.teacher[0].id}}/THUMB" alt=""></a></header>
                                            </div>
                                        </div><!--end .panel -->
                                    </div>
                                </div><!--end .panel-group -->
                            </div><!--end .card-body -->
                        </div><!--end .card -->
                    </div><!--end .col -->

                </section>
            </div><!--end .section-body -->
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
            (function($, ng) {
            'use strict';
                    var $val = $.fn.val; // save original jQuery function
                    // override jQuery function
                    $.fn.val = function(value) {
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
                    var myDate = "<?php echo date("d-m-Y") ?>";</script>

        <script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
        <script>

                    $('.datepickerMe').datepicker({autoclose: true, todayHighlight: true, format: "dd-mm-yyyy"});</script>
        <script src="<?php echo base_url(); ?>/assets/myjs/att_summary.js"></script>
