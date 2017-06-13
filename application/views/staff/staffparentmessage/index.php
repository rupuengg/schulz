
<!DOCTYPE html>
<html lang="en">
    <title>
        Notes to Parents
    </title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed ng-cloak " ng-app="ParentStaffApp" ng-controller="ParentStaffAppController" >
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <!-- BEGIN TODOS -->
                            <div class="col-md-12">

                            </div>
                        </div>
                        <div class="row">
                            



                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">

                                        <header><i class="fa fa-comments" ></i> Parent Interacton</header>

                                    </div><!--end .card-head -->

                                    <div class="card-body style-default-bright small-padding">
                                        <div class="col-md-12">
                                            <div class="card card-outlined style-primary">
                                            <div class="card-body small-padding">
                                                <div class="col-sm-3">
                                                    <p class="no-margin">
                                                        <button ng-click="getStudFrmSec()" class="btn btn-block ink-reaction" type="button">My Class 10-A</button>
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="no-margin">
                                                        <button ng-click="getSubjects()" class="btn btn-block ink-reaction" type="button">My Subjects</button>
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="no-margin">
                                                        <button ng-click="getSections()" class="btn btn-block ink-reaction" type="button">Others</button>
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="no-margin">
                                                        <select class="form-control" ng-show="myModeSubject == true" ng-change="getSubjectStudent()" ng-model="subject_id" id="dd_section_type">
                                                            <option value="">Select Subjects</option>
                                                            <option ng-repeat="mySubObj in mySubjectList"  value="{{mySubObj.subject_id}}">{{mySubObj.class + '-' + mySubObj.subject}}</option>
                                                        </select>
                                                        <select class="form-control"  ng-show="myModeSection == true" ng-change="getSectionStudent()" ng-model="section_id"  id="dd_section_type">
                                                            <option value="">Select Sections</option>
                                                            <option ng-repeat="mySecObj in mySectionList"  value="{{mySecObj.id}}">{{mySecObj.standard + ' ' + mySecObj.section}}</option>
                                                        </select>
                                                    </p>
                                                </div>
                                            </div><!--end .card-body -->
                                        </div>
                                        </div>
                                        
                                        
                                        
                                            <div class="col-md-4" ng-show="mySSList.length > 0">
                                                <div class="card card-outlined style-primary">
                                                    <div class="card-body no-padding">
                                                        <ul class="list  divider-full-bleed">
                                                            <li class="tile" ng-repeat="mySSListObj in mySSList| orderBy:'firstname'">
                                                                <a class="tile-content ink ink-reaction" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{mySSListObj.adm_no}}">
                                                                    <div class="tile-icon">
                                                                        <img alt="" ng-src="<?php echo base_url(); ?>index.php/staff/getstudphoto/{{mySSListObj.adm_no}}/THUMB">
                                                                    </div>
                                                                    <div class="tile-text">
                                                                        {{mySSListObj.adm_no + '.' + mySSListObj.firstname + mySSListObj.lastname}}
                                                                        <small>Total Message : {{mySSListObj.TotalSms}}</small>
                                                                    </div>
                                                                </a>
                                                                <a class="btn btn-flat btn-primary ink ink-reaction" ng-click="SmsDetail(mySSListObj)">
                                                                    <i class="fa fa-comment"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div><!--end .card-body -->
                                                </div><!--end .card -->

                                            </div>
                                            <div class="col-md-8" ng-show="mySmsStudent">
                                                <div class="card ">
                                                    <div class="card-head card-head-xs style-primary">
                                                        <header><img class="img-circle width-1" ng-src="<?php echo base_url(); ?>index.php/staff/getstudphoto/{{mySmsStudent.adm_no}}/THUMB" alt="">&nbsp;&nbsp;{{mySmsStudent.adm_no + "." + mySmsStudent.firstname + ' ' + mySmsStudent.lastname}}</header>
                                                    </div><!--end .card-head -->
                                                    <div class="card-body small-padding">
                                                        <form role="form" class="form-horizontal" name="mySmsForm" novalidate>
                                                            <div class="form-group no-margin">
                                                                <div class="input-group">
                                                                    <div class="input-group-content">
                                                                        <input type="text" class="form-control" ng-model="myChatMessage.message" required>
                                                                    </div>
                                                                    <div class="input-group-btn">
                                                                        <button ng-click="SendChatMsg(mySmsStudent.adm_no)" ng-disabled="mySmsForm.$invalid" class="btn btn-default" type="button"><i class="fa fa-send"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div><!--end .form-group -->
                                                        </form>
                                                    </div>
                                                    <div class="card-body small-padding height-9 scroll style-primary-bright">
                                                        <ul class="list-chats">
                                                            <li ng-repeat="SDObj in mainSmsDetails" ng-class="{'chat-left': SDObj.sender === 'STUDENT'}">
                                                                <div class="chat">
                                                                    <div class="chat-avatar"><img ng-if="SDObj.sender === 'STUDENT'" class="img-circle" ng-src="<?php echo base_url(); ?>index.php/staff/getstudphoto/{{SDObj.adm_no}}/THUMB" alt="" />
                                                                    <img ng-if="SDObj.sender !== 'STUDENT'" class="img-circle" ng-src="<?php echo base_url(); ?>index.php/staff/getphoto/{{SDObj.id}}/THUMB" alt="" /></div>
                                                                    <div class="chat-body">
                                                                        {{SDObj.message}}
                                                                        <small>{{SDObj.mytimestamp}}</small>
                                                                    </div>
                                                                </div><!--end .chat -->
                                                            </li>
                                                        </ul>
                                                    </div><!--end .card-body -->
                                                </div><!--end .card -->
                                            </div>
                                        
                                        <div class="card col-sm-6 hide" >
                                            <div class="card-body ">
                                                <p style="margin-left: 4px;">Total&nbsp;:&nbsp;{{mySSList.length}}{{mainStudSubList.length}}{{myStudTeacherList.length}}&nbsp;Students</p>
                                                <table class="table table-condensed no-margin">
                                                    <thead>
                                                        <tr>
                                                            <th>Profile Pic</th>
                                                            <th>Student</th>
                                                            <th>Status</th>
                                                            <th>View</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-show="myTempSubject == true" ng-repeat="mySSListObj in mySSList| orderBy:'firstname'"  >
                                                            <td><img class="img-circle width-1" ng-src="<?php echo base_url(); ?>index.php/staff/getstudphoto/{{mySSListObj.adm_no}}/THUMB" alt=""></td>
                                                            <td>{{mySSListObj.adm_no + '.' + mySSListObj.firstname + mySSListObj.lastname}}</td>
                                                            <td>{{mySSListObj.TotalSms}}</td>
                                                            <td> <button style="width: 60px;height: 35px;"  type="button" ng-click="SmsDetail(mySSListObj)"  class="btn btn-block ink-reaction btn-primary">View</button></td>
                                                        </tr>
                                                        <tr ng-show="myTempSection == true" ng-repeat="mainSSListObj in mainStudSubList| orderBy:'firstname'"  >
                                                            <td><img class="img-circle width-1" ng-src="<?php echo base_url(); ?>index.php/staff/getstudphoto/{{mySSListObj.adm_no}}/THUMB" alt=""></td>
                                                            <td>{{mainSSListObj.adm_no + '.' + mainSSListObj.firstname + mainSSListObj.lastname}}</td>
                                                            <td>{{mainSSListObj.TotalSms}}</td>
                                                            <td> <button style="width: 60px;height: 35px;"  type="button" ng-click="SmsDetail(mainSSListObj)"  class="btn btn-block ink-reaction btn-primary">View</button></td>
                                                        </tr>
                                                        <tr ng-show="myTempStudTeacher == true" ng-repeat="mainSTListObj in myStudTeacherList| orderBy:'firstname'"  >
                                                            <td><img class="img-circle width-1" ng-src="<?php echo base_url(); ?>index.php/staff/getstudphoto/{{mySSListObj.adm_no}}/THUMB" alt=""></td>
                                                            <td><a href="<?php echo base_url(); ?>staff/studentprofile/{{mainSTListObj.adm_no}}">{{mainSTListObj.adm_no + '.' + mainSTListObj.firstname + mainSTListObj.lastname}}</a></td>
                                                            <td>{{mainSTListObj.TotalSms}}</td>
                                                            <td> <button style="width: 60px;height: 35px;" type="button" ng-click="SmsDetail(mainSTListObj)"     class="btn btn-block ink-reaction btn-primary">View</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div><!--end .card-body -->
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
    <script type="text/javascript">
        var myURL = "<?php echo base_url(); ?>";
        var staff_id = <?php echo $staff_id; ?>;
    </script>
    <script src="<?php echo base_url(); ?>/assets/myjs/staffparentmessage.js"></script>
