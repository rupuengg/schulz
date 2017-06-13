
<!DOCTYPE html>
<html lang="en">
    <title>Student centric report</title>
    <?php
    //echo $class;

    $this->load->view('include/headcss');
    ?>
    <style type="text/css">
       @media (min-width: 769px) {
           .dl-horizontal-custom dt {
               float: left;
               width: 100px;
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
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-class="cloak" ng-app="studentCentricReport" ng-controller="studentCentricReportController" ng-cloak>
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
                                        <header><i class="fa fa-fw fa-tag"></i>Student Centric Report</header>
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
                                                                            <input type="text" class="form-control" id="groupbutton9" ng-model="admno">
                                                                            <label for="groupbutton9">Admission No.</label>
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
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-outlined style-primary" ng-show="data.bookdetail">
                                                        <div class="card-body">
                                                            <div class="table-responsive no-margin">
                                                                <table class="table no-margin table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Book Name</th>
                                                                            <th>Issue Date</th>
                                                                            <th>dues Date</th>
                                                                            <th>Fine</th>
                                                                            <th>Status</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr ng-repeat="book in data.bookdetail">
                                                                            <td>{{ $index + 1}}</td>
                                                                            <td>{{book.book_name}}</td>
                                                                            <td>{{book.issue_date}}</td>
                                                                            <td>{{book.due_date}}</td>
                                                                            <td>{{book.fine_ammount}}</td>
                                                                            <td>{{book.status}}</td>
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
                                <div class="card card-bordered style-primary" >
                                    <div class="card-head card-head-xs">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> Student Detail</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright" ng-repeat="data in mydata">
                                        <dl class="dl-horizontal-custom" >
                                            <dt>Name :-</dt>
                                            <dd><a class="tile-content ink ink-reaction" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{data.adm_no}}">{{ data.stud_name}}</a></dd>
                                            <dt>Adm. No :-</dt>
                                            <dd>{{ data.adm_no}}</dd>
                                            <dt>Class :-</dt>
                                            <dd>{{ data.class}}</dd>
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
    <div id="toast-container" class="toast-bottom-left" ng-show="data == -1" aria-live="polite" role="alert"><div class="toast toast-error"><div class="toast-message">No Student Found in our database</div></div></div>
    <?php
    $this->load->view('include/headjs');
    ?>

    <script>var myURL = "<?php echo base_url(); ?>";</script>
    <script src="<?php echo base_url(); ?>assets/myjs/library/lms_studentreport.js"></script>


</body>
</html>
