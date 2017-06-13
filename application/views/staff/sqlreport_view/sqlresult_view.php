
<!DOCTYPE html>
<html lang="en">
    <title>Sql Report</title>
    <?php
    $this->load->view('include/headcss');
    ?>

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote9fec.css?1422823374" />
    <style>
        .myProButtons{
            position: relative;
            float: right;
            margin-left: 5px
        }
        .decorateMe{
            text-decoration: underline;
        }
    </style>
    <body class="menubar-hoverable header-fixed "ng-app="sqlreport" ng-controller="sqlreportController" >
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-12" >
                                <div class="card">
                                    <div class="card-head card-head-xs style-primary" >
                                        <header><i class="fa fa-table"></i>SqlReport Result</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding" >
                                        <div class="card card-outlined style-primary" ng-if="sqlresult =='-1'">
                                            <div class="card-body small-padding" >

                                                <h3 class="text-center">No Data Found</h3>

                                            </div><!--end .card-body -->
                                        </div>

                                        <div class="card card-outlined style-primary" ng-if="sqlresult !='-1'">
                                            <div class="card-body no-padding" >

                                                <table class="table table-condensed no-margin table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th ng-repeat="colname in myArr1" class="col-sm text-bold text-center">{{colname}}</th>
                                                        </tr>

                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="coldata in sqlresult " >
                                                            <td ng-repeat="m in  coldata" class="col-sm text-bold text-center"><span >{{m}}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div><!--end .col -->
                                </div>
                            </div><!--end .row -->
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
<script>
    var myURL = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url(); ?>assets/myjs/sqlreport.js"></script>

