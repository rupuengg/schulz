<!DOCTYPE html>
<html lang="en">
    <title>CCE Grade Entry</title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="grade" ng-controller="gradeController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head card-head-xs style-primary">
                                        <header><i class="fa fa-table"></i>CCE Co-Scholastic Grade DI Entry.</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">
                                        <div class="card card-outlined style-primary">
                                            <div class="card-body small-padding">
                                                <div class="col-sm-4">
                                                    <p class="no-margin">
                                                        <button ng-click="term = '1'"  ng-class="term == '1' ? 'btn-primary' : 'btn-primary-bright'" class="btn btn-block ink-reaction" type="button">Term - I</button>
                                                    </p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="no-margin">
                                                        <button ng-click="term = '2'"  ng-class="term == '2' ? 'btn-primary' : 'btn-primary-bright'" class="btn btn-block ink-reaction" type="button">Term - II</button>
                                                    </p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="no-margin">
                                                        <select  ng-model="studentAll" ng-change="getStudentList()"ng-disabled="term == ''" class="form-control" id="sel1">
                                                            <option value="0">Select Section</option>
                                                            <option ng-repeat="myAllSection in myCceNameList" value="{{myAllSection}}">{{myAllSection.standard + ' ' + myAllSection.section + ' - ' + myAllSection.cce_name}}</option>                                                        
                                                        </select>
                                                    </p>
                                                </div>
                                            </div><!--end .card-body -->
                                        </div>
                                        <p ng-show="studentAll != 0" style="margin-left: 30px;margin-top: 10px;font-size: 13px;">Class Teacher &nbsp;: &nbsp <span><a href="<?php echo base_url(); ?>index.php/staff/staffprofile/{{classTeacher.teachr_id}}" target="_blank">{{classTeacher.class_teacher}}</a></span> &nbsp;&nbsp;<span style="float:right">Total {{myStudentList.length}} Students</span></p>
                                        <div class="card card-outlined style-primary" ng-show="studentAll != 0">
                                            <div class="card-body no-padding">

                                                <table class="table table-condensed no-margin table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <!--<th>Profile Pic</th>-->
                                                            <th class="col-sm-4 text-bold text-center">Name</th>
                                                            <th class="col-sm-2 text-bold text-center">Grade</th>
                                                            <th class="col-sm-6 text-bold text-center">Descriptive Indicators</th>
                                                            <th class="text-bold text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr ng-repeat="myStudentAllList in myStudentList">
                                                            <!--<td><img class="img-circle width-1" src="<?php //echo base_url() . "index.php/staff/getstudphoto/" . "{{myStudentAllList.adm_no}}/THUMB";  ?>" alt=""></td>-->
                                                            <td>
                                                                <img class="img-circle width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{myStudentAllList.adm_no}}/THUMB"; ?>" alt="">
                                                                <a href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{myStudentAllList.adm_no}}">{{ myStudentAllList.adm_no + '.' + myStudentAllList.firstname + ' ' + myStudentAllList.lastname}}</a>
                                                            </td>
                                                            <td>
                                                                <select ng-model="myStudentAllList.grade" class="form-control" id="sel1">
                                                                    <option value="0">Select Grade</option>
                                                                    <option ng-repeat="myAllGradeList in myGradeList" ng-selected="myStudentAllList.grade === myAllGradeList.id"  value="{{myAllGradeList.id}}">{{myAllGradeList.grade}}</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <textarea style="font-size: 12px;" rows="1" ng-model="myStudentAllList.di" type="text" class="form-control" id="regular13"></textarea></td>
                                                            <td> <button type="button" ng-click="saveGradeDiDetails(myStudentAllList)" class="btn ink-reaction btn-floating-action btn-primary"><i class="fa fa-save"></i></button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

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
        </div>
        <?php
        $this->load->view('include/headjs');
        ?>
        <script>
                    var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>/assets/myjs/grade.js"></script>
    </body>
</html>