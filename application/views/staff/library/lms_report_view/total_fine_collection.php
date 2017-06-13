
<!DOCTYPE html>
<html lang="en">
    <title>Total Fine Collection</title>
    <?php
    //echo $class;

    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="totalfeereport" ng-controller="totalfeereportcontroller">
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
                                        <header><i class="fa fa-fw fa-tag"></i>Total fine Collection</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-outlined style-primary">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="Firstname5" class="col-sm-4 control-label">From</label>
                                                                        <div class="col-sm-8">
                                                                            <datepicker date-format="dd-MM-yyyy">
                                                                                <input type="text" class="form-control" id="Firstname5" ng-model="from">
                                                                            </datepicker>
                                                                            <div class="form-control-line"></div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 margin-bottom-xxl">
                                                                    <div class="form-group">
                                                                        <label for="Lastname5" class="col-sm-4 control-label">To</label>
                                                                        <div class="col-sm-8">
                                                                            <datepicker date-format="dd-MM-yyyy">
                                                                                <input type="text" class="form-control"  id="Lastname5" ng-model="to">
                                                                            </datepicker>
                                                                            <div class="form-control-line"></div>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <div class="input-group-btn">
                                                                    <button class="btn btn-default btn-primary pull-right" type="button" ng-click="viewdata()">View</button>
                                                                </div>
                                                            </div>
                                                        </div><!--end .card-body -->

                                                    </div><!--end .card -->
                                                </div><!--end .col -->

                                            </div>
                                        </div><!--end .card-body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="toast-container" class="toast-bottom-left" ng-show="data.totalfinelist == -1" aria-live="polite" role="alert"><div class="toast toast-error"><div class="toast-message">No data Found in our database</div></div></div>
                                                    <div class="card card-outlined style-primary" ng-show="data.totalfinelist.detail">
                                                        <div class="card-body">
                                                            <div class="table-responsive no-margin">
                                                                <table class="table no-margin table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Name</th>
                                                                            <th>Book Name</th>
                                                                            <th>Late fine</th>
                                                                            <th>Other Charges(Lost/Damaged,etc..)</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr ng-repeat="fine in data.totalfinelist.detail">
                                                                            <td>{{ $index + 1}}</td>
                                                                            <td><a class="tile-content ink-reaction" target="_blank" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{fine.adm_no}}">{{fine.studentName}}</a></td>
                                                                            <td>{{fine.bookName}}</td>
                                                                            <td>&#8377; {{fine.fine_ammount}}</td>
                                                                            <td>&#8377; {{fine.other_charges}}</td>
                                                                    </tbody>
                                                                </table>

                                                                <div class="card-head "><header>Total Fine from {{from}} to {{to}} is &#8377; {{data.totalfinelist.totalfine.fine}} </header></div>
                                                                <span class="text-danger card-foot">Note:TOTAL FINE = LATE FINE + OTHER CHARGES</span>
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
                                <div class="card card-bordered style-primary" ng-show="data.monthvisesummary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Monthly Wise Summary</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="row"
                                             <div class="col-md-3">

                                                <div class="no-padding">
                                                    <div class="panel-group" id="accordion2">
                                                        <div class="card panel" ng-repeat="monthlyfine in data.monthvisesummary">
                                                            <div class="card-head card-head-xs" data-toggle="collapse" data-parent="#accordion2" data-target="#accordion2-{{$index}}">
                                                                <header class="pull-left">{{monthlyfine.month + "-" + monthlyfine.year}}</header>
                                                            </div>
                                                            <div id="accordion2-{{$index}}" class="collapse" >
                                                                <div class="card-body no-padding" >
                                                                    <div role="alert" class="alert alert-callout no-y-padding no-margin alert-danger">
                                                                        <p ng-show="monthlyfine.finesummary!=null">Total fine - &#8377; {{monthlyfine.finesummary}}</p>
            <!--                                                                    <a class="text-sm"> <i>-</i></a>-->
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div><!--end .panel -->
                                                    </div><!--end .panel-group -->
                                                </div>
                                            </div>
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
            <?php
            $this->load->view('include/headjs');
            ?>
            <script type="text/javascript">
                        var myURL = "<?php echo base_url(); ?>";
                        var myDate = "<?php echo date("d-m-Y"); ?>";
            </script>
            <script>var myURL = "<?php echo base_url(); ?>";</script>
            <script src="<?php echo base_url(); ?>assets/myjs/library/lms_totalfinereport.js"></script>
    </body>
</html>


