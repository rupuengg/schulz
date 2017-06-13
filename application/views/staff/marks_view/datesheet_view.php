<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Exam Datesheet View</title>
        <?php
        $this->load->view('include/headcss');
        ?>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    </head>
    <body class="menubar-hoverable header-fixed full-content"  ng-app="examDateSheet" ng-controller="examDateSheetController" ng-cloak>
        <!--<body class="menubar-hoverable header-fixed  ">-->
        <!-- BEGIN HEADER-->
        <?php $this->load->view('include/header'); ?>
        <!-- END HEADER-->

        <!-- BEGIN BASE-->
        <div id="base">
            <!-- BEGIN OFFCANVAS LEFT -->
            <!-- END OFFCANVAS LEFT -->
            <!-- BEGIN CONTENT-->
            <div id="content">

                <section class="has-actions style-default-bright">

                    <!-- BEGIN INBOX -->
                    <div class="section-body" ng-cloak>
                        <div class="row">
                            <div class="col-lg-12 col-sm-6">
                                <div class="card card-outlined style-primary">
                                    <div class="card-head card-head-xs style-primary">
                                        <header>Exam Datesheet </header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">
                                        <div class="card">
                                            <div class="card-body small-padding">
                                                <div class="form">
                                                    <div class="form-group no-margin no-padding">
                                                        <select  id="sel1" class="form-control" ng-change="sectiondata()" ng-model="classtandard" >
                                                            <option value="0" selected="selected">Select Standard</option>
                                                            <option  value="{{classlistObj.standard}}" ng-repeat="classlistObj in classlist">{{classlistObj.standard}}</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card card-outlined style-primary no-margin" ng-show="examdetail">
                                                <div class="card-body small no-padding">
                                                    <div class="card-body no-padding">
                                                        <ul class="list divider-full-bleed">
                                                            <li class="tile" ng-repeat="examdeatil in examdetail">
                                                                <a class="tile-content ink-reaction">
                                                                    <div class="tile-icon">
                                                                        <i class="md md-grade"></i>
                                                                    </div>
                                                                    <div class="tile-text">
                                                                        {{examdeatil.exam_name}}
                                                                    </div>
                                                                </a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div><!--end .card-body -->
                                            </div>
                                        </div>
                                        <div class="col-md-9" ng-show="classtandard > 0">
                                            <div class="card card-outlined style-primary">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group col-sm-3" ng-repeat="sectionlistObj in sectiondetaildata" >
                                                            <label class="checkbox-inline checkbox-styled checkbox-primary">
                                                                <input type="checkbox" ng-model="sectionlistObj.checked"><span>{{sectionlistObj.standard + " " + sectionlistObj.section}}</span>
                                                            </label>
                                                        </div> 
                                                    </div>
                                                    <div class="row margin-bottom-lg">
                                                        <div class="col-sm-4"> 
                                                            <div class="card-head">
                                                                <header>Exam Name:
                                                                    <input type="text" id="timepicker" class="form-control" ng-model="examData.examName" />
                                                                </header>
                                                            </div>  
                                                        </div>
                                                        <div class="col-sm-4"> 
                                                            <div class="card-head">
                                                                <header><i class="hidden small md md-today"></i>
                                                                    <datepicker date-format="dd-MM-yyyy">
                                                                        <input type="text" class="form-control" ng-model="examData.examDate" placeholder="Publish Date" />
                                                                    </datepicker>
                                                                </header>
                                                            </div>  
                                                        </div>
                                                    </div>
                                                    <div class="row margin-bottom-lg">
                                                        <form name="myForm" novalidate>
                                                            <div class="col-sm-3"> 
                                                                <div class="card-head">
                                                                    <header>
                                                                        <select  class="form-control" name="exmSubject" id="select2" ng-model="subject" required>
                                                                            <option value="0">Select Subject</option>
                                                                            <option  value="{{subjectlistObj.id}}"  ng-repeat="subjectlistObj in subjectdetaildata"  >{{subjectlistObj.subject_name}}</option>
                                                                        </select>
                                                                    </header><span class="text-danger" ng-show="myForm.exmSubject.$error.required">Required!</span>
                                                                </div>  
                                                            </div>
                                                            <div class="col-sm-3"> 
                                                                <div class="card-head">
                                                                    <header>
                                                                        <datepicker date-format="dd-MM-yyyy">
                                                                            <input type="text" class="form-control" name="exmDate" ng-model="temp.subjectexamDate" placeholder="Exam Date" required />
                                                                        </datepicker>
                                                                    </header><span class="text-danger" ng-show="myForm.exmDate.$error.required">Required!</span>
                                                                </div>  
                                                            </div>
                                                            <div class="col-sm-2"> 
                                                                <div class="card-head">
                                                                    <header>
                                                                        <input type="text" id="timepicker" class="form-control" name="exmTime" placeholder="Time" ng-model="temp.time" required />
                                                                    </header><span class="text-danger" ng-show="myForm.exmTime.$error.required">Required!</span>
                                                                </div>  

                                                            </div>
                                                            <div class="col-sm-3"> 
                                                                <div class="card-head">
                                                                    <header>
                                                                        <input type="text" id="timepicker" class="form-control" name="exmDuration" placeholder="Time Duration" ng-model="temp.timeduration" required/>
                                                                    </header><span class="text-danger" ng-show="myForm.exmDuration.$error.required">Required!</span>
                                                                </div>  
                                                            </div>
                                                        </form>
                                                        <div class="col-sm-1"> 
                                                            <header>
                                                                <button type="button"  class="btn ink-reaction btn-raised btn-xs btn-success" ng-disabled="myForm.$invalid" ng-click="addexamintable(temp)">Add</button>
                                                            </header>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-12 ">
                                                        <div class="card card-outlined">
                                                            <table class="table table-condensed no-margin table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Subject Name</th>
                                                                        <th>Date</th>
                                                                        <th>Time</th>
                                                                        <th>Time Duration</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr ng-repeat="xx in tempArrSubject">
                                                                        <td>{{$index + 1}}</td>
                                                                        <td ng-repeat="subjectlistObj in subjectdetaildata" ng-if="subjectlistObj.id == xx.sub_id">{{subjectlistObj.subject_name}}</td>
                                                                        <td>{{xx.subexamdate}}</td>
                                                                        <td>{{xx.time}}</td>
                                                                        <td>{{xx.duration}}</td>
                                                                        <td><i class="md md-highlight-remove" ng-click="removeRow($index)"></i></td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                        </div>
                    </div><!--end .section-body -->
                    <!-- END INBOX -->

                    <!-- BEGIN SECTION ACTION -->
                    <div class="section-action style-primary-bright" >
                        <div class="section-floating-action-row" >
                            <button  type="button" ng-disabled="tempArrSubject.length == 0" class="btn ink-reaction btn-floating-action btn-lg btn-success" ng-click="savealldata()"><i class="fa fa-save"></i></button>
                        </div>
                    </div>
                    <!-- END SECTION ACTION -->
                </section>
            </div><!--end #content-->		
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
            </div><!--end #menubar-->
            <!-- END MENUBAR -->
        </div><!--end #base-->	

        <!-- END BASE -->
        <!-- BEGIN JAVASCRIPT -->
        <script type="text/javascript">
                    var myURL = "<?php echo base_url(); ?>";
                    var myDate = "<?php echo date("d-m-Y"); ?>";
        </script>
        <?php
        $this->load->view('include/headjs');
        ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/myjs/examdatesheet.js"></script>
        <!-- END JAVASCRIPT -->
    </body>
</html>