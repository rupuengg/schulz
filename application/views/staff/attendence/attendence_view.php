<!DOCTYPE html>
<html lang="en">
    <title>Manage Attendance</title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
    $logintype = $this->session->userdata('staff_desig');
    $this->load->view('include/headcss');
    ?>
    <body class="menubar-hoverable header-fixed ng-cloak" ng-app="Att" ng-controller="AttController" >
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg  ">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs" style="height: 15px;">
                                        <header><i class="fa fa-calendar" ></i><span ng-show="section_id == 0">Attendance of <?php echo $this->session->userdata('is_staff_classteacher') != false ? $this->session->userdata('staff_classteacher_class') : "" ?></span><span ng-show="section_id != 0">Attendance of {{classTeacher.standard + '' + classTeacher.section}}</span></header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="row  margin-bottom-lg" ng-init="section_id = '<?php if (($this->session->userdata('staff_desig') == 'FACULTY') || ($this->session->userdata('staff_desig') == 'DEO')) {
            echo $this->session->userdata('staff_classteacher_section_id');
        } else {
            echo 0;
        } ?>'">
<?php if ($logintype == 'ADMIN') { ?>
                                                <div class="col-lg-3"> 
                                                    <div class="card style-default-bright no-margin">
                                                        <div class="card-head">
                                                            <!--<header>section:-->
                                                            <select ng-model="section_id" ng-change="change()"  class="form-control" name="select2" id="select2">
                                                                <option value="0">Select Sections</option>
                                                                <option ng-repeat="secObj in mySections" value="{{secObj.id}}">{{secObj.standard + secObj.section}}</option>
                                                            </select>
                                                            <!--</header>-->
                                                        </div>  

                                                    </div>
                                                </div>
<?php } ?>
                                            <div class="col-lg-3"> 
                                                <div class="card style-default-bright no-margin">
                                                    <div class="card-head">
                                                        <header>
                                                            <div class="form">
                                                                <datepicker date-format="dd-MM-yyyy">
                                                                    <input type="text" class="form-control" ng-model="attendenceDate" ng-change="change()" placeholder="Publish Date" />
                                                                </datepicker>
                                                                <!--                                                                <div class="form-group no-margin no-padding">
                                                                                                                                    <input type="text" class="form-control datepickerMe" ng-model="attendenceDate" ng-change="change()"  placeholder="Select Date" />
                                                                                                                                </div>-->
                                                            </div>
                                                        </header>
                                                    </div>  
                                                </div>
                                            </div>
                                            <div class="col-lg-3"> 
                                                <div class="card style-default-bright no-margin">
                                                    <div class="card-head"><header>Status : <strong ng-class="{'Not Marked':'text - danger', 'Marked':'text - success'}[status]">{{status}}</strong></header></div>  
                                                </div>
                                            </div>
                                            <div class="col-lg-3"> 
                                                <div class="card style-default-bright no-margin">
                                                    <div class="card-head " ng-show="myAttendence != null"><header><img class="img-circle width-1" src="<?php echo base_url() . "/index.php/staff/getphoto/{{classTeacher.id}}/THUMB"; ?>" alt=""><span class="text-sm"> {{classTeacher.staff_fname + ' ' + classTeacher.staff_lname}}</span></header></div>  
                                                    <div class="card-head " ng-show="myAttendence == null"><header><img class="img-circle width-1" src="<?php echo base_url() . "/index.php/staff/getphoto/" . $this->session->userdata('staff_id') . "/THUMB"; ?>" alt=""><span class="text-sm"><?php echo $this->session->userdata('staff_name'); ?></span></header></div>  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row  margin-bottom-lg">
                                            <div class="col-lg-3"> 
                                                <div role="alert" class="alert alert-callout alert-info small-padding no-margin text-lg">
                                                    Total : <strong>{{myAttendence.length}}</strong> Students
                                                </div>
                                            </div>
                                            <div class="col-lg-3"> 
                                                <div role="alert" class="alert alert-callout alert-success small-padding no-margin text-lg">
                                                    Present : <strong>{{present}}</strong> Students
                                                </div>
                                            </div>
                                            <div class="col-lg-3"> 
                                                <div role="alert" class="alert alert-callout alert-danger small-padding no-margin text-lg">
                                                    Absent : <strong>{{absent}}</strong> Students
                                                </div>
                                            </div>
                                            <div class="col-lg-3"> 
                                                <div role="alert" class="alert alert-callout alert-warning small-padding no-margin text-lg">
                                                    Exempted : <strong>{{exempt}}</strong> Students
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div ng-show="myError == null && section_id > 0" class="card-body" >

                                                <input style="width: 200px; float: right" type="text" class="form-control" placeholder="Filter Student" ng-model="mySearchInput">
                                                <button  type="button" class="btn btn ink-reaction btn-primary" ng-click="saveAttendence()">Save Attendance</button>
                                                <button  type="button" class="btn btn ink-reaction btn-primary" ng-click="markAttendence()">Mark All Present</button>
                                                <table class="table table-condensed no-margin table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Profile Pic</th>
                                                            <th>Adm No</th>
                                                            <th>Name</th>
                                                            <th>Present</th>
                                                            <th>Absent</th>
                                                            <th>Exempted</th>
                                                            <th>Reason</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="myAttObj in myAttendence| orderBy:'name' | filter:mySearchInput" >
                                                            <td><img class="img-circle width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{myAttObj.adm_no}}/THUMB"; ?>" alt=""></td>
                                                            <td>{{myAttObj.adm_no}}</td>
                                                            <td><a href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{myAttObj.adm_no}}">{{myAttObj.name + ' ' + myAttObj.lastname}}</a></td>
                                                            <td><div><label >
                                                                        <input type="radio" ng-model="myAttObj.att_status" value="PRESENT" name="attStatus{{$index}}" >
                                                                    </label></div></td>
                                                            <td><label>
                                                                    <input type="radio" ng-model="myAttObj.att_status" value="ABSENT" name="attStatus{{$index}}">
                                                                </label></td>
                                                            <td><label>
                                                                    <input type="radio" ng-model="myAttObj.att_status" value="EXEMPT" name="attStatus{{$index}}" >
                                                                </label></td>
                                                            <td><input type="text" class="form-control" id="regular13" ng-model="myAttObj.reason"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div><!--end .card-body -->
                                            <div ng-cloak ng-show="myError != null" class="card-body">
                                                <div  class="alert alert-danger" role="alert">
                                                    {{myError}}
                                                </div>


                                            </div>
                                        </div>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                        </div>
                    </div><!--end .row -->

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
                    var myDate = "<?php echo date("d-m-Y"); ?>";
                    var loginType = "<?php echo $logintype; ?>";
        </script>

        <script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
        <script>

                    $('.datepickerMe').datepicker({autoclose: true, todayHighlight: true, format: "dd-mm-yyyy"});
        </script>
        <script src="<?php echo base_url(); ?>/assets/myjs/attendence.js"></script>
