
<!DOCTYPE html>
<html lang="en">
    <title>Generate Report</title>
    <?php
    $this->load->view('include/headcss');
    ?>

    <!--<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote9fec.css?1422823374" />-->
    <style>
        .myProButtons{
            position: relative;
            float: left;
            margin-left: 5px
        }
        .chekedstu{
            background-color: #f2f3f3;
        }

        #scrollArea {
            height: 280px;
            overflow: auto;
        }

        #bottom {
            display: block;
            margin-top: 2000px;
        }
    </style>
    <body class="menubar-hoverable header-fixed " ng-app="reportCard" ng-controller="reportCardController" ng-cloak ng-class="cloak">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <header><i class="fa fa-fw fa-tag"></i> Report Card Generation</header>  
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class='row'>
                                            <div class="col-md-8">
                                                <div class="card no-margin">
                                                    <div class="card-body">
                                                        <div class="col-md-12">
<!--                                                            <div class="col-sm-6">
                                                                <div class="form-group floating-label">
                                                                    <select  name="select2" class="form-control">
                                                                        <option value="0" disabled>Select Exam Type</option>
                                                                        <option value="">Mid Term</option>
                                                                        <option value="">Half Yearly Term</option>
                                                                        <option value="">Quarterly Term</option>
                                                                        <option value="">Final Term</option>
                                                                    </select>
                                                                </div>
                                                            </div>-->
                                                            <div class="col-sm-12">
                                                                <div class="form-group floating-label" ng-init="showdiv = false;">
                                                                    <select ng-model="sectionId" ng-change="getStudentList()"  name="select2" class="form-control" ng-disabled="showdiv != false" >
                                                                        <option value="0" disabled>Select Class</option>
                                                                        <option ng-repeat="mySection in mySectionList" value="{{mySection.id}}" >{{mySection.standard + ' ' + mySection.section}}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="card no-margin">
                                                                <header class="text-bold text-center text-lg" ng-show="sectionId == 0">Please select a class to proceed!!</header>
                                                                <form ng-show="sectionId != 0"  style="width:100%" class="navbar-search expanded" role="search">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" ng-model="mySearchinput" name="contactSearch" placeholder="Enter your keyword">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                                                                </form>
                                                                <ul style="height: 350px;overflow: auto" class="list divider-full-bleed" data-sortable="true">
                                                                    <li class="tile ui-sortable-handle" id="client_email_{{$index}}" ng-repeat="myAllStudentList in myStudentList| filter:mySearchinput">
                                                                        <div class="checkbox checkbox-styled tile-text" style="width:80%">
                                                                            <label ng-class="{'chekedstu':myAllStudentList.noticeSend == true}">
                                                                                <input type="checkbox" ng-init="allcheck = false" ng-checked=""  ng-model="myAllStudentList.noticeSend" ng-change="getCheckedMemberCount()">
                                                                                <span class="text-sm">
                                                                                    <img style="width: 25px" class=" width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{myAllStudentList.adm_no}}/THUMB"; ?>" alt="">{{' ' + myAllStudentList.adm_no + '.' + myAllStudentList.firstname + ' ' + myAllStudentList.lastname}}
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                        <span ng-init="showbuttn = false" ng-hide="showbuttn" ng-click="showbuttn = true;gerateStudentReportCard(myAllStudentList);">
                                                                            <center>

                                                                                <a ng-hide="myAllStudentList.imagecross == true || myAllStudentList.imagedone == true || myAllStudentList.imageloader == true" href="" class="btn btn-flat ink-reaction btn-primary">
                                                                                    Generate
                                                                                </a>
                                                                                <img ng-show="myAllStudentList.imageloader == true" ng-model="myAllStudentList.imageloader" src="<?php echo base_url(); ?>/assets/img/ajax-loader.gif" />
                                                                                <i ng-show="myAllStudentList.imagecross == true" ng-model="myAllStudentList.imagecross" class="md md-clear"></i>
                                                                                <i ng-show="myAllStudentList.imagedone == true" ng-model="myAllStudentList.imagedone" class="md md-done"></i>
                                                                            </center>
                                                                        </span>

                                                                        <span ng-show="showbuttn && !showDownoad()">
                                                                            <button title="Download" class="btn ink-reaction btn-xs btn-success" ng-click="dwnld(myAllStudentList)" type="button"><i class="fa fa-download"></i></button>

                                                                            <a title="Regenrate" href="" ng-click="gerateStudentReportCard(myAllStudentList);" class="btn ink-reaction btn-xs btn-danger">
                                                                                <i class="fa fa-repeat"></i>
                                                                            </a>
                                                                            <a title="View" href="<?php echo base_url() . "index.php/staff/studentreportcard/" ?>{{myAllStudentList.adm_no}}/{{sectionId}}/<?php echo $this->session->userdata('school_code') ?>" target="_blank" class="btn ink-reaction btn-primary btn-xs">
                                                                                <i class="fa fa-search"> View</i>
                                                                            </a>
                                                                        </span>
                                                                        <span ng-show="showbuttn && showDownoad()">
                                                                            <button title="Download" class="btn ink-reaction btn-xs btn-success" ng-click="dwnld(myAllStudentList)" type="button"><i class="fa fa-download"></i></button>

                                                                            <a title="Regenrate" href="" ng-click="gerateStudentReportCard(myAllStudentList);" class="btn ink-reaction btn-xs btn-danger">
                                                                                <i class="fa fa-repeat"></i>
                                                                            </a>
                                                                            <a title="View" href="<?php echo base_url() . "index.php/staff/primarycard/" ?>{{myAllStudentList.adm_no}}/{{sectionId}}/<?php echo $this->session->userdata('school_code') ?>" target="_blank" class="btn ink-reaction btn-primary btn-xs">
                                                                                <i class="fa fa-search"> View</i>
                                                                            </a>
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!--end .card-body -->
                                            </div>
                                            <div class="col-md-4 text-center" ng-show="sectionId != 0">
                                                <div>Total {{studenttotal}} Students of Class {{standard + ' '}}{{+section}} are loaded.</div>
                                                <div>To Generate and Download the report of the whole class click on Buttons Below.
                                                </div>
                                                <div>
                                                    <button ng-disabled="sectionId == 0" style="font-size:12px" class="btn ink-reaction btn-raised btn-success" ng-click="checkAll();genrateReportCard(myStudentList, 0, 'ALL');" type="button">Generate Complete Report of {{standard + ' '}}{{+section}}</button>
                                                </div>
                                                <div style="padding-top:10px;">
                                                    <button style="font-size:12px" ng-disabled="sectionId == 0 || myCount == 0" class="btn ink-reaction btn-raised btn-success" type="button" ng-click="genrate();genrateReportCard(myArry, 0, 'PARTIAL');">Generate Report of Selected Students({{myCount}})</button>
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

<!--    <script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/libs/summernote/summernote.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/core/demo/DemoFormEditors.js"></script>-->
    <script>
                                                        var myURL = "<?php echo base_url(); ?>";
                                                        var schoolCode = '<?php echo $this->session->userdata('school_code'); ?>';
    </script>
    <script src="<?php echo base_url(); ?>/assets/myjs/reportCard.js?v=67"></script>
    <!--<script src="//ajax.googleapis.com/ajax/libs/angularjs/X.Y.Z/angular-resource.js"></script>-->


