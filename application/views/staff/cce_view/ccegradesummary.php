<!DOCTYPE html>
<html lang="en">
    <title>CCE Grade Summary</title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="gradesummary" ng-controller="gradeSummaryController" ng-cloak ng-class="cloak">
        <?php $this->load->view('include/header'); ?>

        <div id="base">

            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head card-head-xs style-primary">
                                        <header><i class="fa fa-table"></i> CCE Grade Summary</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">
                                        <div class="card card-outlined style-primary">
                                            <div class="card-body small-padding">
                                                <div class="col-sm-4">
                                                    <p class="no-margin">
                                                        <button ng-click="firstterm()"  ng-class="term == '1' ? 'btn-primary' : 'btn-primary-bright'" class="btn btn-block ink-reaction" type="button">Term - I</button>
                                                    </p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="no-margin">
                                                        <button ng-click="secondterm()"  ng-class="term == '2' ? 'btn-primary' : 'btn-primary-bright'" class="btn btn-block ink-reaction" type="button">Term - II</button>
                                                    </p>
                                                </div>
                                                <div class="col-sm-4">

                                                    <p class="no-margin">
                                                    <div class="form-group">

                                                        <div class="col-sm-12">
                                                            <select ng-model="sectionId" ng-change="getStudentList()" ng-disabled="term == ''" ng-init="sectionId == 0" class="form-control" id="sel1">
                                                                <option value="0">Select Section</option>
                                                                <option ng-repeat="myAllSection in mySectionList" value="{{myAllSection.id}}">{{myAllSection.standard + ' ' + myAllSection.section}}</option>                                                        
                                                            </select>
                                                        </div>
                                                    </div>
                                                    </p>
                                                </div>
                                            </div><!--end .card-body -->
                                        </div>
                                        <p ng-show="sectionId!=0" style="margin-left: 30px;margin-top: 10px;font-size: 13px;">Class Teacher &nbsp;: &nbsp <span><a href="<?php echo base_url(); ?>index.php/staff/staffprofile/{{classTeacherId}}" target="_blank">{{classTeacher}}</a></span> &nbsp;&nbsp;<span style="float:right">Total {{mycceStudentList.student.length}} Students</span></p>

                                        <div class="card card-outlined style-primary">
                                            <div class="card-body no-padding">
                                                <table class="table table-condensed no-margin table-bordered" ng-hide="sectionId==0">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th  ng-repeat="myCceNameList in mycceStudentList.cce_element" title="{{myCceNameList.cce_name+' | '+myCceNameList.teacher_name}}">{{myCceNameList.caption_short}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="myStudentNameList in mycceStudentList.student" >
                                                            <td><a href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{myStudentNameList.adm_no}}">{{myStudentNameList.adm_no + '.' + myStudentNameList.firstname + ' ' + myStudentNameList.lastname}}</a></td>
                                                            <td ng-repeat="myStd_ccegradedi in myStudentNameList.cce" title="{{myStd_ccegradedi.di}}" class="{{myStd_ccegradedi.color}} text-center text-bold">{{myStd_ccegradedi.grade}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <div class="col-sm-12 small-padding">
                                                    <div class="col-lg-3"> 
                                                        <div class="card style-danger no-margin">
                                                            <div class="card-body small-padding">
                                                                <p class="no-margin">Grade and DI both are not fill.</p>
                                                            </div>  
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-3">
                                                        <div class="card style-warning no-margin">
                                                            <div class="card-body small-padding">
                                                                <p class="no-margin">Grade not fill but DI fill.</p>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-3"> 
                                                        <div class="card style-success no-margin">
                                                            <div class="card-body small-padding">
                                                                <p class="no-margin">Grade and DI both are fill.</p>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-3"> 
                                                        <div class="card style-info no-margin">
                                                            <div class="card-body small-padding">
                                                                <p class="no-margin">Grade fill but DI are not fill.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
            <?php
            $this->load->view('include/headjs');
            ?>
            <script>
                var myURL = "<?php echo base_url(); ?>";</script>
            <script src="<?php echo base_url(); ?>/assets/myjs/gradesummary.js"></script>
        </div>
    </body>
</html>

