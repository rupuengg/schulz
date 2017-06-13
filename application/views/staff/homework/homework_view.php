<!DOCTYPE html>
<html lang="en">
    <title>Homework</title>
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
    <!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/angularfileupload.css" type="text/css">-->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style>
        .alert-callout.alert-info.pink::before {
            background: #F52887 none repeat scroll 0 0;
        }
        .rowchange{
            background-color: #13a901;
        }
        .myclass{
            font-size: 14px;
        }
    </style>
    <body class="menubar-hoverable header-fixed " ng-app="homeworkApp"  ng-controller="homeworkAppController" ng-cloak ng-class="ng - cloak">
        <?php $this->load->view('include/header'); ?>
        <div id="base" >
            <!-- BEGIN OFFCANVAS LEFT -->
            <div id="content" >
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
                                        <header><i class="fa fa-table"></i> Homework Details</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">


                                        <div class="row">

                                            <!-- BEGIN INLINE TABS -->
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <ul data-toggle="tabs" class="nav nav-tabs nav-justified">
                                                            <li class="{{hmwrktypeclass1}}"><a ng-click="reload('NO')" href="#daily">Daily Homework</a></li>
                                                            <li class="{{hmwrktypeclass2}}"><a href="#holiday" ng-click="reload('YES')">Holiday Homework</a></li>
                                                        </ul>
                                                        <br>
                                                        <div class="tab-content">
                                                            <div id="daily" class="tab-pane active">
                                                                <div class="row">
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                    <div class="col-md-12">
                                                                        <div class="card card-outlined style-primary">
                                                                            <div class="card-body small-padding">
                                                                                <div class="row text-center">
                                                                                    <div class="col-sm-3" ng-repeat="datas in stddata.staffdata">
                                                                                        <div class="btn-group">
                                                                                            <button ng-class="subject_id == datas.subject_id  ? 'btn-primary' : 'btn-primary-bright'" class="btn btn-block ink-reaction margin-bottom-xl" type="button" ng-click="loadhwdata(datas);uploader.clearQueue()">{{datas.subject_name}} {{datas.standard}} {{datas.section}}</button>
                                                                                        </div> 
                                                                                    </div>
                                                                                </div><!--end .row -->
                                                                            </div><!--end .card-body -->
                                                                        </div><!--end .card -->
                                                                    </div><!--end .col -->


                                                                </div>
                                                                <div class="row" ng-show="subject_id != ''">
                                                                    <div class="col-md-12">
                                                                        <div class="card card-outlined style-primary">
                                                                            <div class="card-body small-padding">
                                                                                <div class="row text-center">
                                                                                    <div id="manage" class="col-md-6">
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>Manage Homework</header>
                                                                                                <a class="btn ink-reaction btn-primary-dark pull-right" ng-click="postHomework()" href="javascript:void(0);"><i class="fa fa-plus"></i>&nbsp;&nbsp;Post New Homework</a>

                                                                                            </div>
                                                                                            <div class="card-body" ng-show="resultdata != - 1">
                                                                                                <table class="table table-striped no-margin">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th class="text-bold text-center">Title</th>
                                                                                                            <th class="text-bold text-center">Date</th>
                                                                                                            <th class="text-bold text-center">Details</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody >
                                                                                                        <tr ng-repeat="da in resultdata">
                                                                                                            <td>{{da.title}}</td>
                                                                                                            <td>{{da.hw_date}}</td>
                                                                                                            <td><button class="btn btn-group btn-success btn-xs" ng-click="details(da.id)">Details</button></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div><!--end .card-body -->
                                                                                        </div><!--end .card -->
                                                                                    </div><!--end .col -->
                                                                                    <div class="col-md-6" ng-show="fulldeatil == 'yes'">
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>Homework Full Details</header>
                                                                                            </div>
                                                                                            <div class="card-body myNewClass" style="margin-left:20px;">
                                                                                                <dl class="dl-horizontal text-lg leftaligncustom">
                                                                                                    <dt>Title</dt>
                                                                                                    <dd style="margin-left: 220px !important;">: {{studentdata.hwfulldetail.title}}</dd>
                                                                                                    <dt>Posted Date:</dt>
                                                                                                    <dd style="margin-left: 220px !important;">: {{studentdata.hwfulldetail.date}}</dd>
                                                                                                    <dt>Last Submission Date</dt>
                                                                                                    <dd style="margin-left: 220px !important;">: {{studentdata.hwfulldetail.submissionlast_date}}</dd>
                                                                                                    <dt>Total Student</dt>
                                                                                                    <dd style="margin-left: 220px !important;">: {{studentdata.hwfulldetail.totalstd}}</dd>
                                                                                                    <dt>Total Done Homework</dt>
                                                                                                    <dd style="margin-left: 220px !important;">: {{studentdata.hwfulldetail.totaldonstd}}</dd>
                                                                                                    <dt>Total Not Done Homework</dt>
                                                                                                    <dd style="margin-left: 220px !important;">: {{studentdata.hwfulldetail.notdonstd}}</dd>
                                                                                                    <dt ng-show="studentdata.hwfulldetail.upload_files.length > 0">Attachments</dt>
                                                                                                    <dd >
                                                                                                        <div class="col-md-offset-2 col-md-8" style="margin-left: 70px !important;">
                                                                                                            <a class="btn btn-block btn-raised btn-default-bright ink-reaction"  target="_blank" href="<?php echo base_url(); ?>{{filename.file_path}}" ng-repeat="filename in studentdata.hwfulldetail.upload_files">
                                                                                                                : {{filename.file_name}}
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
                                                                                                <header>Post New HomeWork</header>
                                                                                            </div>

                                                                                            <div class="card-body">
                                                                                                <form name="myform">
                                                                                                    <table class="table table-striped no-margin">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td class="text-bold text-center" >Title<span class="text-danger">*</span></td>
                                                                                                                <td><input class="form-control" type="text" ng-model="title" name="title" required></td>
                                                                                                                <td><span class="text-danger" ng-show="myform.title.$invalid">*Mandatory</span></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td class="text-bold text-center">Date</td>
                                                                                                                <td>  <datepicker date-format="dd-MM-yyyy">
                                                                                                            <input type="text" class="form-control" ng-model="postdate" ng-init="postdate = '<?php echo date('d-m-Y'); ?>'"/>
                                                                                                        </datepicker></td>
                                                                                                        <td><span class="text-danger" ng-show="postdate < '<?php echo date('d-m-Y'); ?>'">*Incorrect date</span></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td class="text-bold text-center">Submission Date</td>
                                                                                                            <td><datepicker date-format="dd-MM-yyyy">
                                                                                                            <input type="text" class="form-control" ng-model="submitdate" ng-init="submitdate = '<?php echo date('d-m-Y', strtotime("+ 1 day")); ?>'"/>
                                                                                                        </datepicker><td>
                                                                                                        <td><span class="text-danger" ng-show="submitdate <= '<?php echo date('d-m-Y'); ?>' || submitdate <= postdate">*Incorrect date</span></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><a href="#offcanvas-demo-right" data-toggle="offcanvas"><button class="btn btn-group btn-success btn-xs">Add File Attachment</button></a></td>
                                                                                                            <td>{{ uploader.queue.length}} Attachment attached</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><button ng-click="postdata()" class="btn btn-primary" ng-disabled="!myform.$valid || postdate < '<?php echo date('d-m-Y'); ?>' || submitdate <= '<?php echo date('d-m-Y'); ?>' || submitdate <= postdate">POST</button></td>
                                                                                                        </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </form>
                                                                                            </div>
                                                                                            <!--end .card-body -->

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
                                                                <div class="row" ng-show="studentdata.stddetail.length > 0">
                                                                    <div class="col-md-12">
                                                                        <div class="card card-outlined style-primary">
                                                                            <div class="card-body small-padding">
                                                                                <div class="row text-center">

                                                                                    <div id="managedetails" class="col-md-12">
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>Student Homework Details</header>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <table class="table table-striped no-margin">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th class="text-bold text-center">Pic</th>
                                                                                                            <th class="text-bold text-center">Name</th>
                                                                                                            <th class="text-bold text-center">Class</th>
                                                                                                            <th class="text-bold text-center">Submission Status</th>
                                                                                                            <th class="text-bold text-center">Action </th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody >
                                                                                                        <tr ng-repeat="hw in studentdata.stddetail">
                                                                                                            <td><img class="img-circle width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{hw.adm_no}}/THUMB"; ?>" alt=""></td>
                                                                                                            <td>{{hw.adm_no + '  ' + hw.firstname + ' ' + hw.lastname}}</td>
                                                                                                            <td>{{hw.standard + '' + hw.section}}</td>
                                                                                                            <td>{{hw.hw_submit_status}}</td>
                                                                                                            <td><button class="btn btn-group btn-success btn-xs" ng-click="managedetails(hw.adm_no)">View</button></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div><!--end .card-body -->

                                                                                        </div><!--end .card -->

                                                                                    </div><!--end .col -->

                                                                                    <div class="col-md-6" ng-show="types == 'yes'">
                                                                                        <div class="card card-outlined">
                                                                                            <div class="card-head card-head-xs style-primary">
                                                                                                <header>{{name}} Homework Summary</header>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <dl class="dl-horizontal myclass">
                                                                                                    <table class="table no-margin" >
                                                                                                        <tr>
                                                                                                            <th class="text-bold text-center">#</th>
                                                                                                            <th class="text-bold text-center">Title</th>
                                                                                                            <th class="text-bold text-center">Date</th>
                                                                                                            <th class="text-bold text-center">Submission Date</th>
                                                                                                            <th class="text-bold text-center">Details</th>
                                                                                                        </tr>
                                                                                                        <tr ng-repeat="hw in studhw" ng-class="{'style-success': hw.hw_submit_status == 'Submitted', 'style-danger' : hw.hw_submit_status == 'Not Submitted'}">
                                                                                                            <td>{{$index + 1}}</td>
                                                                                                            <td>{{hw.title}}</td>
                                                                                                            <td>{{hw.hw_date}}</td>
                                                                                                            <td>{{hw.timestamp}}</td>
                                                                                                            <td>{{hw.hw_submit_status}}</td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </dl>
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
                                                            <div id="holiday" class="tab-pane">
                                                                <div class="row">
                                                                    <!--end .col -->
                                                                    <!--end .col -->
                                                                    <div class="col-md-12">
                                                                        <div class="card card-outlined style-primary">
                                                                            <div class="card-body small-padding">
                                                                                <div class="row text-center" fulldeatil=='no'>
                                                                                    <div class="col-sm-3"  ng-repeat="holiday in stddata.staffdata">
                                                                                        <div class="btn-group">
                                                                                            <button ng-class="subject_id == holiday.subject_id  ? 'btn-primary' : 'btn-primary-bright'" class="btn btn-block ink-reaction margin-bottom-xl" type="button" ng-click="loadhwdata(holiday);uploader.clearQueue()">{{holiday.subject_name}} {{holiday.standard}} {{holiday.section}}</button>
                                                                                        </div>                                                                                        

                                                                                    </div><!--end .card-body -->
                                                                                </div><!--end .card -->
                                                                            </div><!--end .col -->


                                                                        </div>
                                                                        <div class="row" ng-show="subject_id != ''">
                                                                            <div class="col-md-12">
                                                                                <div class="card card-outlined style-primary">
                                                                                    <div class="card-body small-padding">
                                                                                        <div class="row text-center">
                                                                                            <div id="manage" class="col-md-6">
                                                                                                <div class="card card-outlined">
                                                                                                    <div class="card-head card-head-xs style-primary">
                                                                                                        <header>Manage holiday Homework</header>
                                                                                                        <a class="btn ink-reaction btn-primary-dark pull-right" ng-click="postHomework()" href="javascript:void(0);"><i class="fa fa-plus"></i>&nbsp;&nbsp;Post New Homework</a>

                                                                                                    </div>
                                                                                                    <div class="card-body" ng-show="resultdata != - 1">
                                                                                                        <table class="table table-striped no-margin">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <th class="text-bold text-center">Tittle</th>
                                                                                                                    <th class="text-bold text-center">Date</th>
                                                                                                                    <th class="text-bold text-center">Details</th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody >
                                                                                                                <tr ng-repeat="da in resultdata">
                                                                                                                    <td>{{da.title}}</td>
                                                                                                                    <td>{{da.hw_date}}</td>
                                                                                                                    <td><button class="btn btn-group btn-success btn-xs" ng-click="details(da.id)">Details</button></td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div><!--end .card-body -->
                                                                                                </div><!--end .card -->
                                                                                            </div><!--end .col -->
                                                                                            <div class="col-md-6" ng-show="fulldeatil == 'yes'">
                                                                                                <div class="card card-outlined">
                                                                                                    <div class="card-head card-head-xs style-primary">
                                                                                                        <header>Homework Full Details</header>
                                                                                                    </div>
                                                                                                    <div class="card-body">
                                                                                                        <dl class="dl-horizontal text-lg">
                                                                                                            <dt>Title:</dt>
                                                                                                            <dd>{{studentdata.hwfulldetail.title}}</dd>
                                                                                                            <dt>Posted Date:</dt>
                                                                                                            <dd>{{studentdata.hwfulldetail.date}}</dd>
                                                                                                            <dt>Last Submission Date:</dt>
                                                                                                            <dd>{{studentdata.hwfulldetail.submissionlast_date}}</dd>
                                                                                                            <dt>Total Student:</dt>
                                                                                                            <dd>{{studentdata.hwfulldetail.totalstd}}</dd>
                                                                                                            <dt>Total Don Homework:</dt>
                                                                                                            <dd>{{studentdata.hwfulldetail.totaldonstd}}</dd>
                                                                                                            <dt>Total Not Don Homework</dt>
                                                                                                            <dd>{{studentdata.hwfulldetail.notdonstd}}</dd>
                                                                                                        </dl>
                                                                                                    </div><!--end .card-body -->
                                                                                                </div><!--end .card -->
                                                                                            </div><!--end .col -->
                                                                                            <div class="col-md-6" ng-show="postHW == 'yes'">
                                                                                                <div class="card card-outlined">
                                                                                                    <div class="card-head card-head-xs style-primary">
                                                                                                        <header>Post New HomeWork</header>
                                                                                                    </div>

                                                                                                    <div class="card-body">
                                                                                                        <form name="myform">
                                                                                                            <table class="table table-striped no-margin">
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td class="text-bold text-center" >Title<span class="text-danger">*</span></td>
                                                                                                                        <td><input class="form-control" type="text" ng-model="title" name="title" required></td>
                                                                                                                        <td><span class="text-danger" ng-show="myform.title.$invalid">*Mandatory</span></td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td class="text-bold text-center">Date</td>
                                                                                                                        <td>  <datepicker date-format="dd-MM-yyyy">
                                                                                                                    <input type="text" class="form-control" ng-model="postdate" ng-init="postdate = '<?php echo date('d-m-Y'); ?>'"/>
                                                                                                                </datepicker></td>
                                                                                                                <td><span class="text-danger" ng-show="postdate < '<?php echo date('d-m-Y'); ?>'">*Incorrect date</span></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td class="text-bold text-center">Submission Date</td>
                                                                                                                    <td><datepicker date-format="dd-MM-yyyy">
                                                                                                                    <input type="text" class="form-control" ng-model="submitdate" ng-init="submitdate = '<?php echo date('d-m-Y', strtotime("+ 1 day")); ?>'"/>
                                                                                                                </datepicker><td>
                                                                                                                <td><span class="text-danger" ng-show="submitdate <= '<?php echo date('d-m-Y'); ?>' || submitdate <= postdate">*Incorrect date</span></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td><a href="#offcanvas-demo-right" data-toggle="offcanvas"><button class="btn btn-group btn-success btn-xs">Add File Attachment</button></a></td>
                                                                                                                    <td>{{importFile.length}} Attachment attached</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td><button ng-click="postdata()" class="btn btn-primary" ng-disabled="!myform.$valid || postdate < '<?php echo date('d-m-Y'); ?>' || submitdate <= '<?php echo date('d-m-Y'); ?>' || submitdate <= postdate">POST</button></td>
                                                                                                                </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </form>
                                                                                                    </div>
                                                                                                    <!--end .card-body -->

                                                                                                </div><!--end .card -->
                                                                                            </div><!--end .col -->
                                                                                            <!--                                                                                            <div class="col-md-6" ng-show="fulldeatil == 'yes'">
                                                                                                                                                                                            <div class="card card-outlined">
                                                                                                                                                                                                <div class="card-head card-head-xs style-primary">
                                                                                                                                                                                                    <header>Homework Full Details3</header>
                                                                                                                                                                                                </div>
                                                                                                                                                                                                <div class="card-body">
                                                                                                                                                                                                    <dl class="dl-horizontal text-lg">
                                                                                                                                                                                                        <dt>Title:</dt>
                                                                                                                                                                                                        <dd>{{studentdata.hwfulldetail.title}}</dd>
                                                                                                                                                                                                        <dt>Posted Date:</dt>
                                                                                                                                                                                                        <dd>{{studentdata.hwfulldetail.hw_date}}</dd>
                                                                                                                                                                                                        <dt>Last Submission Date:</dt>
                                                                                                                                                                                                        <dd>{{studentdata.hwfulldetail.submission_last_date}}</dd>
                                                                                                                                                                                                        <dt>Total Student:</dt>
                                                                                                                                                                                                        <dd>{{studentdata.hwfulldetail.totalstd}}</dd>
                                                                                                                                                                                                        <dt>Total Don Homework:</dt>
                                                                                                                                                                                                        <dd>{{studentdata.hwfulldetail.totaldonstd}}</dd>
                                                                                                                                                                                                        <dt>Total Not Don Homework</dt>
                                                                                                                                                                                                        <dd>{{studentdata.hwfulldetail.notdonstd}}</dd>
                                                                                                                                                                                                    </dl>
                                                                                                                                                                                                </div>end .card-body 
                                                                                            
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
                                                                        <div class="row" ng-show="subject_id != '' && studentdata.stddetail.length > 0">
                                                                            <div class="col-md-12">
                                                                                <div class="card card-outlined style-primary">
                                                                                    <div class="card-body small-padding">
                                                                                        <div class="row text-center">

                                                                                            <div id="managedetails" class="col-md-12">
                                                                                                <div class="card card-outlined">
                                                                                                    <div class="card-head card-head-xs style-primary">
                                                                                                        <header>Student Homework Details</header>
                                                                                                    </div>
                                                                                                    <div class="card-body">
                                                                                                        <table class="table table-striped no-margin">
                                                                                                            <thead>
                                                                                                                <tr >

                                                                                                                    <th class="text-bold text-center">pic</th>
                                                                                                                    <th class="text-bold text-center">Name</th>
                                                                                                                    <th class="text-bold text-center">Class</th>
                                                                                                                    <th class="text-bold text-center">Submission Status</th>
                                                                                                                    <th class="text-bold text-center">Action</th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody >
                                                                                                                <tr ng-repeat="hw in studentdata.stddetail">
                                                                                                                    <td><img class="img-circle width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{hw.adm_no}}/THUMB"; ?>" alt=""></td>
                                                                                                                    <td>{{hw.adm_no + '  ' + hw.firstname + ' ' + hw.lastname}}</td>
                                                                                                                    <td>{{hw.standard + '' + hw.section}}</td>
                                                                                                                    <td>{{hw.hw_submit_status}}</td>
                                                                                                                    <td><button class="btn btn-group btn-success btn-xs" ng-click="managedetails(hw.adm_no)">View</button></td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div><!--end .card-body -->

                                                                                                </div><!--end .card -->

                                                                                            </div><!--end .col -->
                                                                                            <div class="col-md-6">
                                                                                                <div class="card card-outlined">
                                                                                                    <div class="card-head card-head-xs style-primary">
                                                                                                        <header>{{name}} Homework Summary</header>
                                                                                                    </div>
                                                                                                    <div class="card-body">
                                                                                                        <table class="table no-margin">
                                                                                                            <tr>
                                                                                                                <th class="text-bold text-center">#</th>
                                                                                                                <th class="text-bold text-center">Title</th>
                                                                                                                <th class="text-bold text-center">Date</th>
                                                                                                                <th class="text-bold text-center">Details</th>
                                                                                                            </tr>
                                                                                                            <tr ng-repeat="hw in studhw" ng-class="{'style-success': hw.hw_submit_status == 'Submitted', 'style-danger' : hw.hw_submit_status == 'Not Submitted'}">
                                                                                                                <td>{{$index + 1}}</td>
                                                                                                                <td>{{hw.title}}</td>
                                                                                                                <td>{{hw.hw_date}}</td>
                                                                                                                <td>{{hw.timestamp}}</td>
                                                                                                                <td>{{hw.hw_submit_status}}</td>
                                                                                                            </tr>
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
                    ?><script src="<?php echo base_url(); ?>assets/myjs/homework.js?v=<?php echo rand(); ?>"></script>
                    <script>
                        var uploadhint = "<?php echo $random_number; ?>"
                        var myURL = "<?php echo base_url(); ?>";
                        var postHw_id= '<?php  if($hw_id>0) { echo $hw_id; } else { echo ''; } ?>';
                    </script>
                    
                    <script src="<?php echo base_url(); ?>assets/js/angular-file-upload.js?v=<?php echo rand(); ?>"></script>
                    <script src="<?php echo base_url(); ?>assets/js/angular-file-upload.min.js?v=<?php echo rand(); ?>"></script>
