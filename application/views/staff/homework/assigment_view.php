<!DOCTYPE html>
<html lang="en">
    <title>Assignments</title>
    <?php
    $this->load->view('include/headcss');
    $digits_needed = 10;
    $random_number = '';
    $count = 0;
    restart:
    while ($count < $digits_needed) {
        $random_digit = mt_rand(0, 9);
        $random_number .= $random_digit;
        $count++;
    }
    ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style>
        .alert-callout.alert-info.pink::before {
            background: #F52887 none repeat scroll 0 0;
        }
    </style>

    <body class="menubar-hoverable header-fixed ">
        <?php $this->load->view('include/header'); ?>
        <div id="base" ng-app="assigmentApp">
            <!-- BEGIN OFFCANVAS LEFT -->
            <div id="content" ng-controller="assigmentAppController" ng-cloak>
                <div class="offcanvas">
                    <div id="offcanvas-demo-right" class="offcanvas-pane style-primary-bright width-custom-lg">
                        <div class="offcanvas-head">
                            <header>Manage Attachment </header>
                            <div class="offcanvas-tools">

                                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                            <div>
                                <div class="form">
                                    <div class="card card-outlined style-primary-dark">
                                        <div class="card-body small-padding floating-label">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <input type="file" nv-file-select="" uploader="uploader" multiple="">
                                                    <p>Attached length: {{ uploader.queue.length}}</p>

                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th width="50%">Name</th>
                                                                <th ng-show="uploader.isHTML5">Size</th>
                                                                <th ng-show="uploader.isHTML5">Progress</th>
                                                                <th>Status</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr ng-repeat="item in uploader.queue">
                                                                <td><strong>{{ item.file.name}}</strong></td>
                                                                <td ng-show="uploader.isHTML5" nowrap>{{ item.file.size / 1024 / 1024|number:2 }} MB</td>
                                                                <td ng-show="uploader.isHTML5">
                                                                    <div class="progress" style="margin-bottom: 0;">
                                                                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span ng-show="item.isSuccess"><i class="glyphicon glyphicon-ok"></i></span>
                                                                    <span ng-show="item.isCancel"><i class="glyphicon glyphicon-ban-circle"></i></span>
                                                                    <span ng-show="item.isError"><i class="glyphicon glyphicon-remove"></i></span>
                                                                </td>
                                                                <td nowrap>
                                                                    <button type="button" class="btn btn-success btn-xs" ng-click="item.upload()" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
                                                                        <span class="glyphicon glyphicon-upload"></span> Upload
                                                                    </button>
                                                                    <button type="button" class="btn btn-warning btn-xs" ng-click="item.cancel()" ng-disabled="!item.isUploading">
                                                                        <span class="glyphicon glyphicon-ban-circle"></span> Cancel
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger btn-xs" ng-click="item.remove()">
                                                                        <span class="glyphicon glyphicon-trash"></span> Remove
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div>
                                                        <div>
                                                            Queue progress:
                                                            <div class="progress" style="">
                                                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-success btn-s" ng-click="uploader.uploadAll()" ng-disabled="!uploader.getNotUploadedItems().length">
                                                            <span class="glyphicon glyphicon-upload"></span> Upload all
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-s" ng-click="uploader.cancelAll()" ng-disabled="!uploader.isUploading">
                                                            <span class="glyphicon glyphicon-ban-circle"></span> Cancel all
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-s" ng-click="uploader.clearQueue()" ng-disabled="!uploader.queue.length">
                                                            <span class="glyphicon glyphicon-trash"></span> Remove all
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="offcanvas-demo-student" class="offcanvas-pane style-primary-bright width-12">
                        <div class="offcanvas-head">
                            <header>Manage Student </header>
                            <div class="offcanvas-tools">

                                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                            <div>
                                <div class="form">
                                    <div class="card card-outlined style-primary-dark">


                                        <select  ng-change="loadsectionstudent()" ng-model="mysection_id">
                                            <option  ng-repeat="data in sectiondata" value="{{data.id}}">{{data.standard + '' + data.section}}</option>

                                        </select>
                                        <div class="card-body no-padding" style="height: 350px; overflow-y: scroll;">
                                            <ul data-sortable="true" class="list ui-sortable">
                                                <li class="tile ui-sortable-handle" ng-repeat="std in allstddata">
                                                    <div class="checkbox checkbox-styled tile-text">
                                                        <label>
                                                            <input ng-model="std.selectStudent" type="checkbox" ng-click="GetCountSelectedStudent(std)">
                                                            <span>
                                                                {{std.firstname + '  ' + std.lastname}}
                                                            </span>
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div><!--end .card-body -->
                                        <div class="card-actionbar">
                                            <div class="card-actionbar-row">

                                            </div>
                                        </div>
                                    </div><!--end .card -->

                                </div>


                            </div>
                            <div>
                                <span>Select Student List</span>
                                <div class="row" >
                                    <div class="col-lg-4">
                                        <table>
                                            <tr ng-repeat="n in selectcolm">
                                                <td> {{n.firstname + ' ' + n.lastname}}</td>
                                                <td></td>
                                                <td></td>
                                                <td>  <i class="md md-close" ng-click="delete($ndex)"></i>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div  class="modal fade" id="MSGModal" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="simpleModalLabel">Message</h4>
                            </div>
                            <div class="modal-body">
                                <div id="viewmessage"class="form-group">

                                </div>

                            </div>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head card-head-xs style-primary">
                                        <header><i class="fa fa-table"></i> Assignment Details</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">


                                        <div class="row">

                                            <!-- BEGIN INLINE TABS -->
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <ul data-toggle="tabs" class="nav nav-tabs nav-justified">
                                                            <li class="active"><a href="#daily" ng-click="GetAllAssignList(holidaytype = 'NO')" >Daily Assignment</a></li>
                                                            <li><a href="#holiday"ng-click="GetAllAssignList(holidaytype = 'YES')">Holiday Assignment</a></li>
                                                        </ul>
                                                        <br>
                                                        <div class="tab-content">
                                                            <div id="daily" class="tab-pane active">
                                                                <div class="row">
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="card card-outlined style-primary">
                                                                            <div class="card-body small-padding">
                                                                                <div class="row text-center">
                                                                                    <div id="manage" class="col-md-6">
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>Manage Assignment</header>
                                                                                                <a class="btn ink-reaction btn-primary-dark pull-right" ng-click="postNewAssignment()" href="javascript:void(0);"><i class="fa fa-plus"></i>&nbsp;&nbsp;Post New Homework</a>

                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <h4 ng-show="assignmentdata == - 1">No Data Found</h4>
                                                                                                <table class="table table-striped no-margin" ng-show="assignmentdata != - 1">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th class="text-bold text-center">Tittle</th>
                                                                                                            <th class="text-bold text-center">Date</th>
                                                                                                            <th class="text-bold text-center">Details</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr ng-repeat="assignment in assignmentdata">
                                                                                                            <td>{{assignment.title}}</td>
                                                                                                            <td>{{assignment.hw_date}}</td><td><button class="btn btn-group btn-success btn-xs" ng-click="assignmentfulldetail(assignment.id)">Details</button></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div><!--end .card-body -->
                                                                                        </div><!--end .card -->


                                                                                    </div><!--end .col -->
                                                                                    <div class="col-md-6" ng-hide="postHW == 'yes' || type == 'yes'">
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>How to manage Assignment?</header>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                * Click on post new button to post new Assignment..
                                                                                            </div><!--end .card-body -->

                                                                                        </div><!--end .card -->
                                                                                    </div><!--end .col -->
                                                                                    <div class="col-md-6" ng-show="type == 'yes'">
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>Assignment Full Details</header>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <dl class="dl-horizontal text-lg" >
                                                                                                    <dt>Title:</dt>
                                                                                                    <dd>{{assignmentfull.fulldetail.title}}</dd>
                                                                                                    <dt>Posted Date:</dt>
                                                                                                    <dd>{{assignmentfull.fulldetail.hw_date}}</dd>
                                                                                                    <dt>Last Submission Date:</dt>
                                                                                                    <dd>{{assignmentfull.fulldetail.submission_last_date}}</dd>
                                                                                                    <dt>Total Student:</dt>
                                                                                                    <dd>{{assignmentfull.fulldetail.totalassign}}</dd>
                                                                                                    <dt>Total Done Homework:</dt>
                                                                                                    <dd>{{assignmentfull.fulldetail.workdone}}</dd>
                                                                                                    <dt>Total Not Done Homework</dt>
                                                                                                    <dd>{{assignmentfull.fulldetail.worknotdone}}</dd>
                                                                                                    <dt ng-show="assignmentfull.fulldetail.upload_files.length > 0">Attachments:</dt>
                                                                                                    <dd>
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <a class="btn btn-block btn-raised btn-default-bright ink-reaction" target="_blank" href="<?php echo base_url(); ?>{{filename.file_path}}" ng-repeat="filename in assignmentfull.fulldetail.upload_files">
                                                                                                                {{filename.file_name}}
                                                                                                            </a>
                                                                                                        </div>
                                                                                                    </dd>



                                                                                                </dl>

                                                                                            </div><!--end .card-body -->

                                                                                        </div><!--end .card -->
                                                                                    </div><!--end .col -->
                                                                                    <div class="col-md-6" ng-show="postHW == 'yes'">
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>Post New Assignment</header>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <form name="myform">
                                                                                                    <table class="table table-striped no-margin">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td class="text-bold text-center">Title<span class="text-danger">*</span></td>
                                                                                                                <td><input class="form-control" type="text" ng-model="title" name="title" required></td>
                                                                                                                <td><span class="text-danger" ng-show="myform.title.$invalid">*Mandatory</span></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td class="text-bold text-center">Date</td>
                                                                                                                <td>

                                                                                                        <datepicker date-format="dd-MM-yyyy">
                                                                                                            <input type="text" class="form-control" ng-model="postdate" ng-init="postdate = '<?php echo date('d-m-Y'); ?>'"/>
                                                                                                        </datepicker>
                                                                                                        <i class="fa fa-calendar pull-right"></i>
                                                                                                        </td>
                                                                                                        <td><span class="text-danger" ng-show="postdate < '<?php echo date('d-m-Y'); ?>'">*Incorrect date</span></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td class="text-bold text-center">Last Submission Date</td>
                                                                                                            <td>
                                                                                                        <datepicker date-format="dd-MM-yyyy">
                                                                                                            <input type="text" class="form-control" ng-model="lastsubmitdate" ng-init="lastsubmitdate = '<?php echo date('d-m-Y', strtotime("+ 1 day")); ?>'"/>
                                                                                                        </datepicker>
                                                                                                        <i class="fa fa-calendar pull-right"></i>
                                                                                                        </td>
                                                                                                        <td><span class="text-danger" ng-show="lastsubmitdate <= '<?php echo date('d-m-Y'); ?>' || lastsubmitdate <= postdate">*Incorrect date</span></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><a href="#offcanvas-demo-right" data-toggle="offcanvas"><button class="btn btn-group btn-success btn-xs">Add File Attachment</button></a></td>
                                                                                                            <td>{{ uploader.queue.length}} Attachment attached</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><a href="#offcanvas-demo-student" data-toggle="offcanvas"><button class="btn btn-group btn-success btn-xs">Assign Assignment to Students</button></a></td>

                                                                                                            <td>{{selectcolm.length}} Student Selected</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td> <button class="btn btn-primary" ng-click="postdata()" ng-disabled="!myform.$valid || postdate < '<?php echo date('d-m-Y'); ?>' || lastsubmitdate <= '<?php echo date('d-m-Y'); ?>' || lastsubmitdate <= postdate">POST</button></td>
                                                                                                        </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </form>
                                                                                            </div><!--end .card-body -->

                                                                                        </div><!--end .card -->
                                                                                    </div><!--end .col -->

                                                                                </div><!--end .row -->
                                                                            </div><!--end .card-body -->
                                                                        </div><!--end .card -->
                                                                    </div><!--end .col -->
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12" ng-show="type == 'yes'">
                                                                        <div class="card card-outlined style-primary">
                                                                            <div class="card-body small-padding">
                                                                                <div class="row text-center">

                                                                                    <div id="managedetails" class="col-md-12" >
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>Student Assignment Details</header>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <table class="table table-striped no-margin">
                                                                                                    <thead>
                                                                                                        <tr>

                                                                                                            <th class="text-bold text-center">Name</th>
                                                                                                            <th class="text-bold text-center">Class</th>
                                                                                                            <th class="text-bold text-center">Submission Status</th>

                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr ng-repeat="studentdata in assignmentfull.StudentDetail">

                                                                                                            <td>{{studentdata.adm_no + '.' + studentdata.firstname + ' ' + student.lastname}}</td>                                                                                                            
                                                                                                            <td>{{studentdata.standard + '' + studentdata.section}}</td>
                                                                                                            <td>{{studentdata.hw_submit_status}}</td>


                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div><!--end .card-body -->

                                                                                        </div><!--end .card -->

                                                                                    </div><!--end .col -->
                                                                                    <!--                                                                                    <div class="col-md-6" ng-show="types == 'yes'">
                                                                                                                                                                   </div>end .card 
                                                                                                                                                                        </div>end .col -->
                                                                                </div><!--end .row -->
                                                                            </div><!--end .card-body -->
                                                                        </div><!--end .card -->
                                                                    </div><!--end .col -->
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                </div>
                                                            </div>
                                                            <div id="holiday" class="tab-pane active" ng-show="holidaytype == 'YES'">
                                                                <div class="row">
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="card card-outlined style-primary">
                                                                            <div class="card-body small-padding">
                                                                                <div class="row text-center">
                                                                                    <div id="manage" class="col-md-6">
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>Manage Assignment</header>
                                                                                                <a class="btn ink-reaction btn-primary-dark pull-right" ng-click="postNewAssignment()" href="javascript:void(0);"><i class="fa fa-plus"></i>&nbsp;&nbsp;Post New Assignment</a>

                                                                                            </div>
                                                                                            <div class="card-body">


                                                                                                <h4 ng-show="assignmentdata == - 1">No Data Found</h4>
                                                                                                <table class="table table-striped no-margin" ng-show="assignmentdata != - 1">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th class="text-bold text-center">Tittle</th>
                                                                                                            <th class="text-bold text-center">Date</th>
                                                                                                            <th class="text-bold text-center">Details</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr ng-repeat="assignment in assignmentdata">
                                                                                                            <td>{{assignment.title}}</td>
                                                                                                            <td>{{assignment.hw_date}}</td><td><button class="btn btn-group btn-success btn-xs" ng-click="assignmentfulldetail(assignment.id)">Details</button></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div><!--end .card-body -->
                                                                                        </div><!--end .card -->


                                                                                    </div><!--end .col -->
                                                                                    <div class="col-md-6" ng-hide="postHW == 'yes' || type == 'yes'">
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>How to manage Assignment?</header>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                * Click on post new button to post new Homework..
                                                                                            </div><!--end .card-body -->

                                                                                        </div><!--end .card -->
                                                                                    </div><!--end .col -->
                                                                                    <div class="col-md-6" ng-show="type == 'yes'">
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>Assignment Full Details</header>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <dl class="dl-horizontal text-lg" >
                                                                                                    <dt>Title:</dt>
                                                                                                    <dd>{{assignmentfull.fulldetail.title}}</dd>
                                                                                                    <dt>Posted Date:</dt>
                                                                                                    <dd>{{assignmentfull.fulldetail.hw_date}}</dd>
                                                                                                    <dt>Last Submission Date:</dt>
                                                                                                    <dd>{{assignmentfull.fulldetail.submission_last_date}}</dd>
                                                                                                    <dt>Total Student:</dt>
                                                                                                    <dd>{{assignmentfull.fulldetail.totalassign}}</dd>
                                                                                                    <dt>Total Done Assignment:</dt>
                                                                                                    <dd>{{assignmentfull.fulldetail.workdone}}</dd>
                                                                                                    <dt>Total Not Done Assignment</dt>
                                                                                                    <dd>{{assignmentfull.fulldetail.worknotdone}}</dd>
                                                                                                    <dt>Attachments:</dt>
                                                                                                    <dd>
                                                                                                        <div class="col-md-offset-2 col-md-8">
                                                                                                            <a class="btn btn-block btn-raised btn-default-bright ink-reaction" target="_blank" href="<?php echo base_url(); ?>{{filename.file_path}}" ng-repeat="filename in assignmentfull.fulldetail.upload_files">
                                                                                                                {{filename.file_name}}
                                                                                                            </a>
                                                                                                        </div>
                                                                                                    </dd>



                                                                                                </dl>

                                                                                            </div><!--end .card-body -->

                                                                                        </div><!--end .card -->
                                                                                    </div><!--end .col -->
                                                                                    <div class="col-md-6" ng-show="postHW == 'yes'">
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>Post New Assignment</header>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <form name="myform">
                                                                                                    <table class="table table-striped no-margin">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td class="text-bold text-center">Title<span class="text-danger">*</span></td>
                                                                                                                <td><input class="form-control" type="text" ng-model="title" name="title" required></td>
                                                                                                                <td><span class="text-danger" ng-show="myform.title.$invalid">*Mandatory</span></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td class="text-bold text-center">Date</td>
                                                                                                                <td>

                                                                                                        <datepicker date-format="dd-MM-yyyy">
                                                                                                            <input type="text" class="form-control" ng-model="postdate" ng-init="postdate = '<?php echo date('d-m-Y'); ?>'"/>
                                                                                                        </datepicker>
                                                                                                        <i class="fa fa-calendar pull-right"></i>
                                                                                                        </td>
                                                                                                        <td><span class="text-danger" ng-show="postdate < '<?php echo date('d-m-Y'); ?>'">*Incorrect date</span></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td class="text-bold text-center">Last Submission Date</td>
                                                                                                            <td>
                                                                                                        <datepicker date-format="dd-MM-yyyy">
                                                                                                            <input type="text" class="form-control" ng-model="lastsubmitdate" ng-init="lastsubmitdate = '<?php echo date('d-m-Y', strtotime("+ 1 day")); ?>'"/>
                                                                                                        </datepicker>
                                                                                                        <i class="fa fa-calendar pull-right"></i>
                                                                                                        </td>
                                                                                                        <td><span class="text-danger" ng-show="lastsubmitdate <= '<?php echo date('d-m-Y'); ?>' || lastsubmitdate <= postdate">*Incorrect date</span></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><a href="#offcanvas-demo-right" data-toggle="offcanvas"><button class="btn btn-group btn-success btn-xs">Add File Attachment</button></a></td>
                                                                                                            <td>{{attechmentLength}} Attachment attached</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><a href="#offcanvas-demo-student" data-toggle="offcanvas"><button class="btn btn-group btn-success btn-xs">Assign Assignment to Students</button></a></td>

                                                                                                            <td>{{selectcolm.length}} Student Selected</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td> <button class="btn btn-primary" ng-click="postdata()" ng-disabled="!myform.$valid || postdate < '<?php echo date('d-m-Y'); ?>' || lastsubmitdate <= '<?php echo date('d-m-Y'); ?>' || lastsubmitdate <= postdate">POST</button></td>
                                                                                                        </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </form>
                                                                                            </div><!--end .card-body -->

                                                                                        </div><!--end .card -->
                                                                                    </div><!--end .col -->

                                                                                </div><!--end .row -->
                                                                            </div><!--end .card-body -->
                                                                        </div><!--end .card -->
                                                                    </div><!--end .col -->
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12" ng-show="type == 'yes'">
                                                                        <div class="card card-outlined style-primary">
                                                                            <div class="card-body small-padding">
                                                                                <div class="row text-center">

                                                                                    <div id="managedetails" class="col-md-12" >
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>Student Homework Details</header>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <table class="table table-striped no-margin">
                                                                                                    <thead>
                                                                                                        <tr>

                                                                                                            <th class="text-bold text-center">Name</th>
                                                                                                            <th class="text-bold text-center">Class</th>
                                                                                                            <th class="text-bold text-center">Submission Status</th>

                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr ng-repeat="studentdata in assignmentfull.StudentDetail">

                                                                                                            <td>{{studentdata.adm_no + '.' + studentdata.firstname + ' ' + student.lastname}}</td>                                                                                                            
                                                                                                            <td>{{studentdata.standard + '' + studentdata.section}}</td>
                                                                                                            <td>{{studentdata.hw_submit_status}}</td>


                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div><!--end .card-body -->

                                                                                        </div><!--end .card -->

                                                                                    </div><!--end .col -->
                                                                                    <div class="col-md-6" ng-show="types == 'yes'">
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>Homework Full Details</header>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <table class="table table-striped no-margin">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th class="text-bold text-center">#</th>
                                                                                                            <th class="text-bold text-center">Tittle</th>
                                                                                                            <th class="text-bold text-center">Date</th>
                                                                                                            <th class="text-bold text-center">Details</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td>3</td>
                                                                                                            <td>Larry</td>
                                                                                                            <td>9A</td>
                                                                                                            <td>Yes</td>
                                                                                                            <td></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div><!--end .card-body -->

                                                                                        </div><!--end .card -->
                                                                                    </div><!--end .col -->
                                                                                </div><!--end .row -->
                                                                            </div><!--end .card-body -->
                                                                        </div><!--end .card -->
                                                                    </div><!--end .col -->
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div><!--end .card-body -->
                                                </div><!--end .card -->
                                            </div><!--end .col -->
                                            <!-- END INLINE TABS -->

                                        </div>

                                    </div><!--end .col -->
                                </div>
                            </div><!--end .row -->
                        </div><!--end .section-body -->
                    </div></section>
            </div>

            <!--</section>-->
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

        <script>var myURL = "<?php echo base_url(); ?>";</script>
        <script> var uploadhint = "<?php echo $random_number; ?>"</script>
        <script src="<?php echo base_url(); ?>assets/myjs/assignment.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular-file-upload.js?v=<?php echo rand(); ?>"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular-file-upload.min.js?v=<?php echo rand(); ?>"></script>