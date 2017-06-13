<!DOCTYPE html>
<html lang="en">
    <title>BlueSheet</title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />

    <body class="menubar-hoverable header-fixed " ng-app="bluesheet" ng-class="cloak" ng-controller="bluesheetController" ng-cloak >
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content" >
                <section>
                    <div class="section-body contain">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <header><i class="fa fa-fw fa-tag"></i> Blue Sheet</header>
                                    </div><!--end .card-head -->

                                    <div class="card-body style-default-bright">
                                        <form class="form-inline ng-pristine ng-valid">

                                            <div class="form-group col-lg-3" >
                                                <select ng-model="classDetails"  ng-change="getClassDetail()" style="position: relative;float: left;;  margin-top: 5px;width: 160px" class="form-control" id="sel1">
                                                    <option value="0">Select Section</option>
                                                    <option ng-repeat="myAllSectionList in mySectionList" value="{{myAllSectionList}}">{{myAllSectionList.standard + ' ' + myAllSectionList.section}}</option>    
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-1" ng-repeat="examNewList in examList" >
                                                <label class="checkbox-inline checkbox-styled checkbox-primary">
                                                    <input type="checkbox" ng-model="examNewList.loadresult"  ng-change="checkCount()"><span>{{examNewList.exam_name}}</span>
                                                </label>
                                            </div>

                                            <button class="btn ink-reaction btn-flat style-success btn-loading-state" ng-show="checked " ng-click="loadMarks(examNewList)" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="fa fa-search"></i>VIEW</button>
                                            <!--<button type="button" class="btn ink-reaction btn-flat style-success btn-loading-state" ng-hide="classDetails=='0'" ng-click="loadMarks(examNewList)" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="fa fa-search"></i> VIEW</button>-->

                                        </form>
                                        <div class="clearfix"></div>
                                        <div>
                                            <p style="margin-left: 30px;margin-top: 10px;font-size: 13px; display:inline;" ng-hide="classDetails == '0'">Class Teacher &nbsp;: &nbsp; <span>{{classTeacher}}</span> &nbsp;&nbsp;<span style="float:right" ng-show="subList.studentList.length > 0" >Total<b> {{subList.studentList.length}} </b>Students</span></p>
                                        </div>

                                        <div class="table-responsive no-margin" ng-show="show == 'TRUE'">
                                            <table class="table table-striped no-margin table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="3">Adm.No.</th>
                                                        <th rowspan="3">Name</th>
                                                        <th colspan="{{mySubject.colspan}}" ng-repeat="mySubject in subList.subjectList">{{mySubject.subject_name}}</th>
                                                    </tr>
                                                    <tr>

                                                        <th colspan="{{exm.colspan}}" ng-repeat="exm in subList.examLis">{{exm.ename}}</th>
                                                    </tr>
                                                    <tr>
                                                        <th ng-repeat="part in subList.part"><span>{{part.pname}}<br>({{part.max_mrk}})</span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="stuData in subList.studentList">
                                                        <td>{{stuData.adm_no}}</td>
                                                        <td style="white-space: nowrap;"><a href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{stuData.adm_no}}" target="_blank">{{stuData.fname + ' ' + stuData.lname}}</a></td>
                                                        <td ng-repeat="mrks in stuData.marks">{{mrks.marks}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div><!--end .col -->
                                    </div><!--end .col -->
                                </div>

                            </div><!--end .row -->
                        </div><!--end .section-body -->
                    </div>
                </section>
            </div>
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
        <script src="<?php echo base_url(); ?>/assets/myjs/bluesheet.js"></script>