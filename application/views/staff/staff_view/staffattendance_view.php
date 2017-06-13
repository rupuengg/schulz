<!DOCTYPE html>
<html lang="en">
    <title>Staff Attendance</title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
    $logintype = $this->session->userdata('logintype');
    $this->load->view('include/headcss');
    ?>

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed ng-cloak" ng-app="Att" ng-controller="AttController" ng-cloak ng-class="cloak">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg  ">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <header><i class="fa fa-calendar" ></i> Staff Attendance</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="row  margin-bottom-lg">
                                            <div class="col-lg-3"> 
                                                <div class="card style-default-bright no-margin">
                                                    <div class="card-head ">
                                                        <header>
                                                            <div class="form">
                                                                <datepicker date-format="dd-MM-yyyy">
                                                                    <input type="text" class="form-control" ng-model="attendenceDate" ng-change="change()" ng-init="dateAtt = '<?php echo date('d-m-Y'); ?>'" readonly/>
                                                                </datepicker>

                                                            </div>
                                                        </header>
                                                    </div>  
                                                </div>
                                            </div>
                                            <div class="col-lg-4"> 
                                                <div class="card style-default-bright no-margin">
                                                    <div class="card-head"><header>Status : <strong ng-class="{'Not Marked':'text - danger', 'Marked':'text - success'}[status]">{{myAttendence.status.status}}</strong></header></div>  
                                                </div>
                                            </div>
                                            <div class="col-lg-4"> 
                                                <div class="card style-default-bright no-margin">
                                                    <div class="card-head"><header><input ng-model="mySearchInput" type="text" class="form-control" name="contactSearch" placeholder="Enter your keyword"></header></div>  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row  margin-bottom-lg">
                                            <div class="col-lg-3"> 
                                                <div role="alert" class="alert alert-callout alert-info small-padding no-margin text-lg">
                                                    Total : <strong>{{total}}</strong> Staff
                                                </div>
                                            </div>
                                            <div class="col-lg-4"> 
                                                <div role="alert" class="alert alert-callout alert-success small-padding no-margin text-lg">
                                                    Present : <strong>{{present}}</strong> Staff
                                                </div>
                                            </div>
                                            <div class="col-lg-4"> 
                                                <div role="alert" class="alert alert-callout alert-danger small-padding no-margin text-lg">
                                                    Absent : <strong>{{absent}}</strong> Staff
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div  class="card-body" ng-show="attendenceDate <= '<?php echo date('d-m-Y'); ?>'">

                                                <!--<input style="width: 200px; float: right" type="text" class="form-control" placeholder="Filter Student" ng-model="mySearchInput">-->
                                                <!--<button  type="button" class="btn btn ink-reaction btn-primary" ng-click="saveAttendence()">Save Attendance</button>-->
                                                <button  type="button" class="btn btn ink-reaction btn-primary" ng-disabled="attendenceDate != '<?php echo date('d-m-Y'); ?>'" ng-click="markAttendence()">Mark All Present</button>


                                                <table class="table table-condensed no-margin table-striped" >
                                                    <thead>
                                                        <tr>
                                                            <th >Profile Pic</th>
                                                            <th >Name</th>
                                                            <th class="text-center">Remark</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr  ng-repeat="myAttObj in myAttendence.staff_list| orderBy:'att_status' | filter:mySearchInput" >
                                                            <td><img class="img-circle width-1" src="<?php echo base_url() . "index.php/staff/getphoto/" . "{{myAttObj.staff_id}}/THUMB"; ?>" alt=""></td>
                                                            <td><a href="<?php echo base_url(); ?>index.php/staff/staffprofile/{{myAttObj.staff_id}}">{{myAttObj.name}}</a></td>
                                                            <td class="text-center">
                                                                <div>
                                                                    <label>
                                                                        <input type="text" class="form-control" id="regular13" ng-model="myAttObj.reason">
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="btn-group" id="{{$index}}">
                                                                    <label  ng-class="myAttObj.att_status == 'PRESENT'?'btn btn-sm btn-success':'btn btn - sm btn - default'" ng-click="switchv (myAttObj.staff_id, $index, 'PRESENT', attendenceDate)" btn-radio="test">Present</label>

                                                                    <label  ng-class="myAttObj.att_status == 'ABSENT'?'btn btn-sm btn-danger':'btn btn - sm btn - default'" ng-click="switchv (myAttObj.staff_id, $index, 'ABSENT', attendenceDate)" btn-radio="test">Absent</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div><!--end .card-body -->
                                            <div ng-cloak ng-show="attendenceDate > '<?php echo date('d-m-Y'); ?>'" class="card-body">
                                                <div  class="alert alert-danger" role="alert">
                                                    <label>You cannot mark Attendance in advance!!!</label>
                                                </div>
                                            </div>
                                            <!--                                            <div ng-cloak ng-show="" class="card-body">
                                                                                            <div  class="alert alert-danger" role="alert">
                                                                                                <label>Holiday!!</label>
                                                                                            </div>
                                                                                        </div>-->
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
                    <span class="text-lg text-bold text-primary">MATERIAL&nbsp;ADMIN</span>
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
                var myURL = "<?php echo base_url(); ?>";
                var myDate = "<?php echo date("d-m-Y"); ?>";
                var loginType = "<?php echo $logintype; ?>";    </script>
    <script src="<?php echo base_url(); ?>assets/myjs/staffattendance.js"></script>
