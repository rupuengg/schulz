<!DOCTYPE html>
<html lang="en">
    <title>Fine Setting</title>
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
    <body class="menubar-hoverable header-fixed " ng-app="FineSettings" ng-controller="FineSettingsController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content" >
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-lg-8 col-sm-8">
                                <div class="card">
                                    <div class="card-head style-primary card-head-xs">
                                        <header>
                                            <p>Fine setting</p>
                                        </header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label for="amount17" class="col-sm-2 control-label">Due Days</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group">
                                                        <div class="input-group-content">
                                                            <input type="text" class="form-control" id="amount17" ng-model="fine.due_days"><div class="form-control-line"></div>
                                                        </div>
                                                        <span class="input-group-addon"></span>
                                                    </div>
                                                </div>
                                            </div><!--end .form-group -->
                                            <div class="form-group">
                                                <label for="dollars17" class="col-sm-2 control-label">Fine Amount</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-inr fa-lg"></i></span>
                                                        <div class="input-group-content">
                                                            <input type="text" class="form-control" id="dollars17" ng-model="fine.fine_per_day"><div class="form-control-line"></div>
                                                        </div>
                                                        <span class="input-group-addon"></span>
                                                    </div>
                                                    <div class="card-actionbar">
                                                        <div class="card-actionbar-row">
                                                            <button type="submit" class="btn btn-flat btn-primary ink-reaction" ng-click="savefinedata()" ng-disabled="fine.due_days <= 0|| fine.fine_per_day <= 0">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end .form-group -->
                                        </form>
                                    </div><!--end .card-body -->
                                </div>
                            </div><!--end .card -->
                            <div class="col-lg-4 col-sm-4">
                                <div class="card">
                                    <div class="card-head style-primary card-head-xs">
                                        <header>
                                            <p>How to manage fine setting?</p>
                                        </header>
                                    </div>
                                    <div class="card-body">
                                        If you want to save fine per day for calculating fine then, please enter the due days and fine per day.Fine will be calculated at the time of returning book.NOTE:Fine setting module will act as base module for fine calculation in return book module.
                                    </div><!--end .card-body -->
                                </div>
                            </div><!--end .card -->
                        </div><!--end .col -->

                    </div>

                    <!--<div class="row">-->


                    <!--</div>-->
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
<script>    var myURL = "<?php echo base_url(); ?>"; </script>

<script src="<?php echo base_url(); ?>assets/myjs/library/library.js"></script>
</body>
</html>
