
<!DOCTYPE html>
<html lang="en">
    <title>Book centric report</title>
    <?php
    //echo $class;

    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style type="text/css">
        @media (min-width: 769px) {
            .dl-horizontal-custom dt {
                float: left;
                width: 170px;
                clear: left;
                text-align: left;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .dl-horizontal-custom dd {
                margin-left: 120px;
            }
        }
    </style>
    <body class="menubar-hoverable header-fixed " ng-class="cloak" ng-app="bookCentricReport" ng-controller="bookCentricReportController" ng-cloak>
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Book Centric Report</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-outlined style-primary">
                                                        <div class="card-body">
                                                            <form class="form" role="form">


                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-content">
                                                                            <input type="text" class="form-control" id="groupbutton9" ng-model="bookid">
                                                                            <label for="groupbutton9">Book </label>
                                                                        </div>
                                                                        <div class="input-group-btn">
                                                                            <button class="btn btn-default btn-primary" type="button" ng-click="senddata()">View</button>
                                                                        </div>
                                                                    </div>
                                                                </div><!--end .form-group -->
                                                            </form>
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div><!--end .col -->
                                            </div>
                                        </div><!--end .card-body -->
                                        <div class="card-body" ng-show="data.studentlist.length > 0">
                                            <div class="row" >
                                                <div class="col-md-12">
                                                    <div class="card card-outlined style-primary">
                                                        <div class="card-body">
                                                            <div class="table-responsive no-margin">
                                                                <table class="table no-margin table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Pic</th>
                                                                            <th> Student Name</th>
                                                                            <th>Issue Date</th>
                                                                            <th>Due Date</th>
                                                                            <th>Status</th>

                                                                    </thead>
                                                                    <tbody>
                                                                        <tr ng-repeat="student in data.studentlist">
                                                                            <td>{{ $index + 1}}</td>
                                                                            <td><img class="img-circle width-1" src="<?php echo base_url() . 'index.php/staff/getstudphoto/{{student.adm_no}}/THUMB' ?>" alt=""/></td>
                                                                            <td><a class="tile-content ink-reaction" target="_blank" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{student.adm_no}}"> {{student.adm_no+'.'+student.firstname + " " + student.lastname}}</a></td>
                                                                            <td>{{ student.issue_date}}</td>
                                                                            <td>{{ student.due_date}}</td>
                                                                            <td>{{ student.status}}</td>

                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div><!--end .col -->

                                            </div>
                                        </div><!--end .card-body -->


                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                            <div class="col-md-4">
                                <div class="card card-bordered style-primary" ng-show="data.book_name">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> Book Detail</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <dl class="dl-horizontal-custom no-margin">
                                            <dt>Book Name :-</dt>
                                            <dd>{{ data.book_name}}</dd>

                                            <dt>Author name :-</dt>
                                            <dd> {{ data.author_name}}</dd>
                                            <dt>Total Books :-</dt>
                                            <dd>{{ data.counttotalbook.quantity}}</dd>
                                            <dt>Available  In Library :-</dt>
                                            <dd>{{ data.counttotalbook.quantity - (data.countlostbook + data.countissuedbook)}}</dd>
                                            <dt>Lost Books :-</dt>
                                            <dd>{{ data.countlostbook}}</dd>
                                            <dt>Issued Books :-</dt>
                                            <dd>{{ data.countissuedbook}}</dd>
                                        </dl>

                                    </div>                                    
                                </div><!--end .card-body -->
                            </div><!--end .card -->

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
    <div id="toast-container" class="toast-bottom-left" ng-show="data == -1" aria-live="polite" role="alert"><div class="toast toast-error"><div class="toast-message">No Book Found in our database</div></div></div>
    <?php
    $this->load->view('include/headjs');
    ?>
    <script src="<?php echo base_url(); ?>/assets/myjs/library/lms_report.js"></script>
    <script>
        var myURL = "<?php echo base_url(); ?>";</script>
</body>
</html>
