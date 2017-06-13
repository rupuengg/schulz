<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Marks Entry</title>
        <?php
        $this->load->view('include/headcss');
        $date = date("Y/m/d");
        ?>
        <script>
            var subId = '<?php echo $sub_id; ?>';
            var sectionId = '<?php echo $section_id; ?>';
            var examId = '<?php echo $examid; ?>';
            var examlist = <?php echo json_encode($examlist); ?>;
            var allSubjctList = <?php echo $allSubjctList;?>;
        </script>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    </head>
    <body class="menubar-hoverable header-fixed full-content"  ng-app="marks" ng-controller="marksController" ng-cloak>
        <!--<body class="menubar-hoverable header-fixed  ">-->
        <!-- BEGIN HEADER-->
        <?php $this->load->view('include/header'); ?>
        <!-- END HEADER-->

        <!-- BEGIN BASE-->
        <div id="base">
            <!-- BEGIN OFFCANVAS LEFT -->
            <div class="offcanvas">
                <div id="offcanvas-demo-right" class="offcanvas-pane style-primary-bright width-12">
                    <div class="offcanvas-head">
                        <header>Manage Exam </header>
                        <div class="offcanvas-tools">

                            <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                <i class="md md-close"></i>
                            </a>
                        </div>
                    </div>
                    <div class="offcanvas-body">
                        <div >
                            <input type="hidden" ng-model="examPart.id">
                            <span><b>{{myExamParts.remaining_mrk - examPart.max_marks}}</b> Marks Remaining to be declared</span>
                            <div class="form">
                                <form name="manageexam" >
                                <div class="card card-outlined style-primary-dark">
                                    <!--                                        <div class="card-head card-head-xs style-primary">
                                                                                <header>Create an account</header>
                                                                            </div>-->
                                    <div class="card-body small-padding floating-label">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <div class="form-group no-margin">
                                                    <input ng-model="examPart.part_name" type="text" id="Firstname2" class="form-control" required>
                                                    <label for="Firstname2">Exam Name</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group no-margin">
                                                    <input ng-model="examPart.max_marks" name="marks"type="text" ng-pattern="/^[0-9]{1,7}$/" id="Lastname2" class="form-control" ng-change="checkMax()" required>
                                                    <label for="Lastname2">Marks</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end .card-body -->
                                    <div class="card-actionbar">
                                        <div class="card-actionbar-row">
                                            <button ng-click="saveExamPart()" ng-disabled="manageexam.$invalid " class="btn btn-sm btn-primary ink-reaction" type="submit">Add Exam</button>
                                        </div>
                                    </div>
                                </div><!--end .card -->
                                </form>

                            </div>


                        </div>
                        <div ng-show="myExamParts.part_detail.length > 0">
                            <span>Exam Part Declared</span>
                            <div class="row">
                                <div class="col-lg-4" ng-repeat="myAllExamParts in myExamParts.part_detail">
                                    <div class="card card-outlined style-primary">
                                        <div class="card-head card-head-xs">
                                            <div class="tools no-padding">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0);" ng-click="removeExamPart(myAllExamParts, $index)" class="btn btn-icon-toggle btn-close btn-danger"><i class="fa fa-times"></i></a>
                                                </div>
                                            </div>
                                        </div><!--end .card-head -->
                                        <div class="card-body no-padding text-center">
                                            <h3 class="no-margin">{{myAllExamParts.part_name}}</h3>
                                            <h4>{{myAllExamParts.max_marks}}</h4> 
                                        </div><!--end .card-body -->
                                    </div>
                                </div>
                            </div>
<!--                            <table class="table table-condensed no-margin hide">
                                <tr ng-repeat="myAllExamParts in myExamParts.part_detail">
                                    <td>{{myAllExamParts.part_name}}</td>
                                    <td>{{myAllExamParts.max_marks}}</td>
                                    <td><i class="fa fa-remove" ng-click="removeExamPart(myAllExamParts)" ></td>
                                </tr>
                            </table>-->
                        </div>
                    </div>
                </div>
                <div id="offcanvas-demo-right_out" class="offcanvas-pane width-12 style-primary-light">
                    <form name="saveactualmrks">
                    <div class="offcanvas-head">
                        <header>Marks Entry </header>
                        <div class="offcanvas-tools">
                            <!--<button style="width: 60px;"  type="button" ng-click="saveActualMrks(myActualMarks)"  class="btn ink-reaction btn-raised btn-xs btn-success">Save</button>-->
                            <a data-dismiss="offcanvas" class="btn btn-icon-toggle btn-danger pull-right text-bold">
                                <i class="fa fa-times"></i>
                            </a>
                            <button type="button" class="btn btn-icon-toggle btn-primary pull-right text-bold" ng-disabled="saveactualmrks.$invalid" ng-click="saveActualMrks(myActualMarks)">
                                <i class="fa fa-save"></i>
                            </button>

                        </div>
                        <table class="table table-condensed no-margin table-striped table-responsive">
                            <tr>
                                <th>Out Of Marks</th> 
                                <th class="width-1"><input ng-model="outOfMarks" ng-pattern="/^[0-9]{1,7}$/" name="outofmrk" id="regular13" required></th>
                            </tr>
                        </table>
                    </div>
                    <div class="offcanvas-body">
                        <!--<input type="hidden" ng-model="examPart.id">-->

                        <table class="table table-condensed no-margin table-striped table-responsive">
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center width-1">Marks</th>
                            </tr>
                            <tr ng-repeat="actualMrks in myActualMarks.studentList" >
                                <td><a target="_blank" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{actualMrks.adm_no}}">{{actualMrks.adm_no + '.' + actualMrks.fname + ' ' + actualMrks.lname}}</a></td>
                                <td>
                                    <span ng-show="actualMrks.marks.outOf == 'true'" class="text-danger">{{myErrorMessage}}</span>
                                    <input type="text" ng-keyup="validateActualMarks(actualMrks.marks)"  ng-change="chkValidteActualMrks($index)" ng-pattern="mrkEntryValidation" name="myactualmrks"  ng-model="actualMrks.marks.mrk" required>
                                </td>   
                            </tr>
                        </table>


                    </div>
                    </form>
                </div>
            </div><!--end .offcanvas-->
            <!-- END OFFCANVAS LEFT -->

            <!-- BEGIN CONTENT-->
            <div id="content">

                <section class="has-actions style-default-bright">

                    <!-- BEGIN INBOX -->
                    <div class="section-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-6">
                                <div class="card card-outlined style-primary">
                                    <div class="card-head card-head-xs style-primary">
                                        <header>Marks Entry</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">
                                        <div class="card">
                                            <div class="card-body small-padding">
                                                <div class="form">
                                                    <div class="form-group no-margin no-padding">
                                                        <select ng-model="classID"  ng-change="getExamName()"  id="sel1" class="form-control">
                                                            <option value="0">Select Section</option>
                                                            <option ng-repeat="myAllSectionList in mySubjectList" ng-selected="classID == myAllSectionList" value="{{myAllSectionList}}">{{myAllSectionList.standard + ' ' + myAllSectionList.section + ' - ' + myAllSectionList.subject_name}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-outlined style-primary" ng-show="myExamList.length > 0 && noticeMessage == ''">
                                            <div class="card-body small-padding">
                                                <div class="col-sm-2" ng-repeat="myAllExamList in myExamList">
                                                    <p class="no-margin">
                                                        <button ng-click="getExamPart(myAllExamList)"  ng-class="myAllExamList.exam_master_id == master_id.exam_master_id ? 'btn-primary' : 'btn - primary - bright'" class="btn btn-block ink-reaction" type="button">Marks {{myAllExamList.exam_name}}</button>
                                                    </p>
                                                </div>
                                            </div><!--end .card-body -->
                                        </div>
                                        <div class="card card-outlined style-primary"ng-show="noticeMessage != ''">
                                            <div class="col-sm-12" >
                                                <p class="no-margin"><h3 class="center">{{noticeMessage}}</h3>
                                            </div>
                                        </div>
                                         <form name="marksEntry" novalidate>
                                        <div class="card card-outlined style-primary no-margin" ng-show="master_id != ''">
                                           
                                                <div class="card-body small-padding style-primary-bright">
                                                    <div class="table-responsive">
                                                        <table class="table no-margin table-condensed table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th class="col-lg-1 col-sm-1 text-bold">Profile Pic</th>
                                                                    <th class="text-bold">Name</th>
                                                                    <th class="text-center col-lg-1 col-sm-1 text-bold" ng-repeat="myPart in myExamParts.part_detail">
                                                                        {{myPart.part_name| uppercase}} ({{myPart.max_marks}}) <br>
                                                                        <button ng-disabled="myExamParts.lock_date === 'FALSE'" ng-click="getMyActualMark(myPart)" class="btn ink-reaction btn-raised btn-xs btn-primary" type="button">Out Of</button>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr ng-repeat="myStudentDetail in  myExamParts.studentDetail">
                                                                    <td><img class="img-circle width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{myStudentDetail.adm_no}}/THUMB"; ?>" alt=""></td>
                                                                    <td style='white-space: nowrap;'><a href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{myStudentDetail.adm_no}}">{{myStudentDetail.adm_no + '.' + myStudentDetail.fname + ' ' + myStudentDetail.lname}}</a></td>
                                                                    <td class="text-center" ng-repeat="myMarks in myStudentDetail.marks">
                                                                        <span ng-show="myMarks.xx == 'true'" class="text-danger">{{myErrorMessage}}</span>
                                                                        <input type="text" ng-keyup="validateMarks(myMarks)" ng-change="checkValidteMaxmarks($parent.$index,$index)" ng-pattern="mrkEntryValidation"   ng-model="myMarks.mrk"  required>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            
                                        </div>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                        </div>
                        <a class="ink-reaction pull-right hide" ng-disabled="'{{myExamParts.status}}'== 'FALSE'  " href="#offcanvas-demo-right_out" id="cmdOpenCanvas" data-toggle="offcanvas" >{{myPart.part_name| uppercase}} ({{myPart.max_marks}}) Out Of</a><!--end .row -->
                    </div><!--end .section-body -->
                    <!-- END INBOX -->

                    <!-- BEGIN SECTION ACTION -->
                    <div class="section-action style-primary-bright" ng-show="master_id != ''">
                        <div class="section-action-row">
                            <a ng-disabled="myExamParts.lock_date === 'FALSE'" class="btn ink-reaction btn-primary-dark" href="#offcanvas-demo-right" data-toggle="offcanvas"><i class="fa fa-plus"></i>&nbsp;&nbsp;Declare Exam</a>
                        </div>
                        <div class="section-floating-action-row" >
                            <button ng-disabled="myExamParts.lock_date === 'FALSE' || marksEntry.$invalid  " ng-show="myExamParts.part_detail.length != 0" ng-click="saveMarksDetail(myStudentDetail)" type="button" class="btn ink-reaction btn-floating-action btn-lg btn-success"><i class="fa fa-save"></i></button>
                        </div>
                    </div>
                    </form>
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
        </script>
        <?php
        $this->load->view('include/headjs');
        ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/myjs/marks.js"></script>
        <!-- END JAVASCRIPT -->
    </body>
</html>