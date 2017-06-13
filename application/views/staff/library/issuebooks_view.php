<!DOCTYPE html>
<html lang="en">
    <title>Issue Book</title>
    <?php
    $this->load->view('include/headcss');
    ?>

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
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
    <body class="menubar-hoverable header-fixed " ng-app="IssueBook" ng-controller="IssueBookController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content" >
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">

                            <div class="col-lg-12 col-sm-12">
                                <div class="card">
                                    <div class="card-head card-head-xs style-primary">
                                        <header>Issue Book</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">

                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="card card-outlined style-primary height-6">
                                                    <div class="card-body">

                                                        <form class="form-horizontal" role="form">
                                                            <div class="form-group">
                                                                <label for="default14" class="col-sm-2 control-label">Book No</label>
                                                                <div class="col-sm-5">
                                                                    <input type="text" class="form-control" id="default14" placeholder="Book No" ng-model="bookno" ng-keydown="$event.keyCode == 13 && bookdata(bookno)">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="default14" class="col-sm-2 control-label">Admission No</label>
                                                                <div class="col-sm-5">
                                                                    <input type="text" class="form-control" id="default14" placeholder="Admission No" ng-model="admission_no" ng-model-onblur ng-change="studentdata(admission_no)">
                                                                </div>
                                                            </div>

                                                        </form>
                                                        <div class="card-actionbar">
                                                            <div class="card-actionbar-row">
                                                                <button class="btn btn-primary"  ng-click="issuebook()">Issue Book</button>
                                                            </div>
                                                        </div><!--end .card-actionbar -->
                                                    </div><!--end .card-body -->

                                                </div><!--end .card -->
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card card-outlined style-primary">
                                                            <div class="card-body small-padding" >
                                                                <h4 ng-show="bookdetail == -1">No data Found</h4>
                                                                <dl class="dl-horizontal-custom no-margin" ng-show="bookdetail != -1">
                                                                    <dt>Book No:</dt>
                                                                    <dd>{{bookdetail.book_no}}</dd>
                                                                    <dt>Book Title:</dt>
                                                                    <dd>{{bookdetail.book_name}}</dd>
                                                                    <dt>Author:</dt>
                                                                    <dd>{{bookdetail.author_name}}</dd>
                                                                    <dt>Publisher:</dt>
                                                                    <dd>{{bookdetail.publisher}}</dd>
                                                                </dl>

                                                            </div><!--end .card-body -->
                                                            <div class="card-body height-3 small-padding style-primary-bright" >
                                                                <h4 ng-show="studentdetail == -1">No data Found</h4>
                                                                <dl class="dl-horizontal-custom no-margin" ng-show="studentdetail != -1">
                                                                    <dt>Admission No:</dt>
                                                                    <dd>{{studentdetail.adm_no}}</dd>
                                                                    <dt>Student Name:</dt>
                                                                    <dd><a class="tile-content ink ink-reaction" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{studentdetail.adm_no}}">{{studentdetail.firstname + ' ' + studentdetail.lastname}}</a></dd>
                                                                    <dt>Class:</dt>
                                                                    <dd>{{studentdetail.standard + '' + studentdetail.section}}</dd>
                                                                </dl>
                                                            </div><!--end .card-body -->
                                                        </div><!--end .card -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->

                        </div>
                        <div class="row">

                            <div class="col-lg-12 col-sm-12">
                                <div class="card">
                                    <div class="card-head card-head-xs style-primary">
                                        <header>Recently Issued Books</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding  height-10">
                                        <table class="table table-striped no-margin table-condensed table-hover">
                                            <thead>
                                                <tr >
                                                    <th>#</th>
                                                    <th>Book No</th>
                                                    <th>Book Title</th>
                                                    <th>Issued To</th>
                                                    <th>Issued On</th>
                                                    <th>Due Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="issue in issuebookdata">
                                                    <td>{{$index + 1}}</td>
                                                    <td>{{issue.book_no}}</td>
                                                    <td>{{issue.book_name}}</td>
                                                    <td><a class="tile-content ink ink-reaction" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{issue.adm_no}}">{{issue.adm_no + '.' + issue.firstname + ' ' + issue.lastname}}</a></td>
                                                    <td>{{issue.issue_date}}</td>
                                                    <td>{{issue.due_date}}</td>
                                                    <td> <a href="<?php echo base_url() . 'index.php/staff/returnbooks/{{issue.adm_no}}'; ?> "class="btn ink-reaction btn-raised btn-xs btn-primary">Return </a> </td>

                                                </tr>

                                            </tbody>
                                        </table>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->

                        </div>
                    </div>
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
            </div>
        </div>
        <?php
        $this->load->view('include/headjs');
        ?>
        <script> var myURL = '<?php echo base_url(); ?>';</script>

        <script src="<?php echo base_url(); ?>assets/myjs/library/library.js"></script>
</html>
