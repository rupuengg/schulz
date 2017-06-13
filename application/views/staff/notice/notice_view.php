
<!DOCTYPE html>
<html lang="en">
    <title>Send Notice</title>
    <?php
    $this->load->view('include/headcss');
    ?>

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote9fec.css?1422823374" />
    <style>
        .myProButtons{
            position: relative;
            float: left;
            margin-left: 5px
        }
    </style>
    <body class="menubar-hoverable header-fixed " ng-app="notice" ng-controller="noticeController" ng-cloak ng-class="cloak">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs style-primary">
                                        <header><i class="fa fa-fw fa-tag"></i>Send Notice</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="row text-center">

                                                        <p class="myProButtons"><button type="button" ng-click="type = 'SCHOOL'" class="btn btn-sm ink-reaction" ng-class="type=='SCHOOL'?'btn-info':''">Notice To Complete School</button></p>
                                                        <p class="myProButtons"><button type="button" ng-click="type = 'ALLSTAFF'" class="btn btn-sm ink-reaction" ng-class="type=='ALLSTAFF'?'btn-info':''">Notice To ALL STAFF</button></p>
                                                        <p class="myProButtons"><button type="button" ng-click="type = 'STAFF'" class="btn btn-sm ink-reaction" ng-class="type=='STAFF'?'btn-info':''">Notice To Selected STAFF</button></p>
                                                        <p class="myProButtons"><button type="button" ng-click="type = 'ALLSTUDENT'" class="btn btn-sm ink-reaction" ng-class="type=='ALLSTUDENT'?'btn-info':''">Notice To ALL STUDENT</button></p>
                                                        <p class="myProButtons"><button type="button" ng-click="type = 'STUDENT'" class="btn btn-sm ink-reaction" ng-class="type=='STUDENT'?'btn-info':''">Notice To SELECTED Student</button></p>
                                                    </div><!--end .row -->
                                                </div>
                                            </div><!--end .card-body -->
                                        </div>
                                        <div class='row'>
                                            <div class="col-md-8">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="col-md-12">
                                                            <div class="form-group floating-label">
                                                                <input type="text" class="form-control" ng-model="noticeTitle" ng-init="noticeTitle = ''" id="Subject1" name="Subject1" placeholder="Title Here" >
                                                            </div><!--end .form-group -->
                                                            <div class="form-group">
                                                                <textarea name="message" ng-model="myMessage" ng-init="myMessage = ''" class="form-control control-6-rows" spellcheck="false" placeholder="Type your notice" ></textarea>
                                                            </div><!--end .form-group -->
                                                            <span >Total <b> {{getCheckedMemberCount() + ' ' + type}} </b> Selected to send Notice.</span>
                                                        </div>
                                                    </div><!--end .card-body -->
                                                </div>
                                            </div>
                                            <div class="col-md-4" ng-show="type == 'STUDENT'">
                                                <div class="card">
                                                    <div class="card tabs-left style-default-light">
                                                        <div style="margin: 0px" class="form-group floating-label">
                                                            <select ng-model="sectionId" ng-change="getStudentList()"  name="select2" class="form-control">
                                                                <option value="0">Select Class</option>
                                                                <option ng-repeat="mySection in mySectionList"value="{{mySection.id}}">{{mySection.standard + ' ' + mySection.section}}</option>
                                                            </select>

                                                        </div>
                                                        <form  style="width:100%" class="navbar-search expanded" role="search">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" ng-model="mySearchinput" name="contactSearch" placeholder="Enter your keyword">
                                                            </div>
                                                            <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                                                        </form>
                                                        <ul style="height: 300px;overflow: auto" class="list ui-sortable" data-sortable="true">

                                                            <li class="tile ui-sortable-handle" ng-repeat="myAllStudentList in myStudentList| filter:mySearchinput">
                                                                <div class="checkbox checkbox-styled tile-text">
                                                                    <label>
                                                                        <input type="checkbox" ng-model="myAllStudentList.noticeSend" >
                                                                        <span style="padding-left: 25px">
                                                                            <img style="width: 25px" class=" width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{myAllStudentList.adm_no}}/THUMB"; ?>" alt="">
                                                                            <a href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{myAllStudentList.adm_no}}">{{ myAllStudentList.adm_no + '.' + myAllStudentList.firstname + ' ' + myAllStudentList.lastname}}</a>
                                                                        </span>
                                                                    </label>
                                                                </div>

                                                            </li> 
                                                        </ul>
                                                    </div><!--end .card-body -->
                                                    <p class="myProButtons"><button type="button" ng-disabled="noticeTitle == '' || myMessage == ''"  ng-click="noticeSend()" class="btn btn-sm ink-reaction btn-info" >Send</button></p>
                                                    <p class="myProButtons"><button type="button" ng-click="noticeCancel()" class="btn btn-sm ink-reaction btn-danger">Cancel</button></p>
                                                </div><!--end .card -->
                                            </div>
                                            <div class="col-md-4" ng-show="type == 'STAFF'">
                                                <div class="card">
                                                    <div class="card tabs-left style-default-light">                                                        
                                                        <form  style="width:100%" class="navbar-search expanded" role="search">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" ng-model="mySearchInput" name="contactSearch" placeholder="Enter your keyword">
                                                            </div>
                                                            <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                                                        </form>
                                                        <ul style="height: 300px;overflow: auto" class="list ui-sortable" data-sortable="true">

                                                            <li class="tile ui-sortable-handle" ng-repeat="myAllStaffList in myStaffList| filter:mySearchInput">
                                                                <div class="checkbox checkbox-styled tile-text">
                                                                    <label>
                                                                        <input type="checkbox" ng-model="myAllStaffList.noticeSend" >
                                                                        <span style="padding-left: 25px">
                                                                            <img style="width: 25px" class=" width-1" src="<?php echo base_url() . "index.php/staff/getphoto/" . "{{myAllStaffList.id}}" . "/THUMB"; ?>" alt="">
                                                                            <a href="<?php echo base_url(); ?>index.php/staff/staffprofile/{{myAllStaffList.id}}"> {{ myAllStaffList.staff_fname + ' ' + myAllStaffList.staff_lname}}</a>
                                                                        </span>
                                                                    </label>
                                                                </div>

                                                            </li> 
                                                        </ul>
                                                    </div><!--end .card-body -->
                                                    <p class="myProButtons"><button type="button" ng-disabled="noticeTitle == '' || myMessage == ''" ng-click="noticeSend()" class="btn btn-sm ink-reaction btn-info">Send</button></p>
                                                    <p class="myProButtons"><button type="button" ng-click="noticeCancel()" class="btn btn-sm ink-reaction btn-danger">Cancel</button></p>
                                                </div><!--end .card -->
                                            </div>

                                            <div class="col-md-4" ng-show="type == 'SCHOOL'">
                                                <div class="card">
                                                    <div class="card tabs-left style-default-light">                                                        
                                                        <form  style="width:100%" class="navbar-search expanded" role="search">
                                                            <div class="form-group">

                                                            </div>

                                                        </form> 
                                                        <ul class="list ui-sortable" data-sortable="true">

                                                            <li class="tile ui-sortable-handle">
                                                                <p>This notice will be send to complete school.Total staff is  <b>{{myStaffList.length}}</b> and total student is  <b>{{myAllStuList.length}}</b> .</p>

                                                            </li> 
                                                        </ul>
                                                    </div><!--end .card-body -->
                                                    <p class="myProButtons"><button type="button" ng-disabled="noticeTitle == '' || myMessage == ''" ng-click="sendDirect(myType = 'SCHOOL')" class="btn btn-sm ink-reaction btn-info">Send</button></p>
                                                    <p class="myProButtons"><button type="button" ng-click="noticeCancel()" class="btn btn-sm ink-reaction btn-danger">Cancel</button></p>
                                                </div><!--end .card -->
                                            </div>

                                            <div class="col-md-4" ng-show="type == 'ALLSTAFF'">
                                                <div class="card">
                                                    <div class="card tabs-left style-default-light">                                                        
                                                        <form  style="width:100%" class="navbar-search expanded" role="search">
                                                            <div class="form-group">

                                                            </div>

                                                        </form> 
                                                        <ul class="list ui-sortable" data-sortable="true">

                                                            <li class="tile ui-sortable-handle">
                                                                <p>This Notice will be send to <b>{{myStaffList.length}} </b>staff members.</p>

                                                            </li> 
                                                        </ul>
                                                    </div><!--end .card-body -->
                                                    <p class="myProButtons"><button type="button" ng-disabled="noticeTitle == '' || myMessage == ''" ng-click="sendDirect(myType = 'ALLSTAFF')" class="btn btn-sm ink-reaction btn-info">Send</button></p>
                                                    <p class="myProButtons"><button type="button" ng-click="noticeCancel()" class="btn btn-sm ink-reaction btn-danger">Cancel</button></p>
                                                </div><!--end .card -->
                                            </div>

                                            <div class="col-md-4" ng-show="type == 'ALLSTUDENT'">
                                                <div class="card">
                                                    <div class="card tabs-left style-default-light">                                                        
                                                        <form  style="width:100%" class="navbar-search expanded" role="search">
                                                            <div class="form-group">

                                                            </div>

                                                        </form> 
                                                        <ul class="list ui-sortable" data-sortable="true">

                                                            <li class="tile ui-sortable-handle" >
                                                                <p>This notice will be send to all the students of school. Total students is <b>{{myAllStuList.length}}.<b></p>
                                                                            </li> 
                                                                            </ul>
                                                                            </div><!--end .card-body -->
                                                                            <p class="myProButtons"><button type="button" ng-disabled="noticeTitle == '' || myMessage == ''" ng-click="sendDirect(myType = 'ALLSTUDENT')" class="btn btn-sm ink-reaction btn-info">Send</button></p>
                                                                            <p class="myProButtons"><button type="button" ng-click="noticeCancel()" class="btn btn-sm ink-reaction btn-danger">Cancel</button></p>
                                                                            </div><!--end .card -->
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
                                                                            <script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/libs/summernote/summernote.min.js"></script>
                                                                            <script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/core/demo/DemoFormEditors.js"></script>
                                                                            <script> var myURL = "<?php echo base_url(); ?>"; </script>
                                                                            <script src="<?php echo base_url(); ?>/assets/myjs/notice.js?v=<?php echo rand(); ?>"></script>
<!--                                                                            <script>
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
                                                                            </script>-->
