
<!DOCTYPE html>
<html lang="en">
    <title>SQL REPORT</title>
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
    <body class="menubar-hoverable header-fixed " >
        <?php $this->load->view('include/header'); ?>
        <div id="base" ng-app="sqlreport">
            <div id="content" ng-controller="sqlreportController">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                           <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <header>SQL REPORT</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright center-block">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="card card-underline">
                                                    <div class="card-head">
                                                        <header>Select Column </header>
                                                    </div>
                                                    <div class="card-body no-padding" style="height: 350px; overflow-y: scroll;">
                                                        <ul data-sortable="true" class="list ui-sortable">
                                                            <li class="tile ui-sortable-handle" ng-repeat="fieldname in sqlReport.field.name">
                                                                <div class="checkbox checkbox-styled tile-text">
                                                                    <label>
                                                                        <input ng-click="getSelectData(fieldname, type)" ng-model="type" ng-true-value="'YES'" ng-false-value="'NO'"
                                                                               type="checkbox" >
                                                                        <span>
                                                                            {{fieldname}}
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div><!--end .card-body -->
                                                </div><!--end .card -->

                                            </div><!--end .col -->
                                            <div class="col-md-4">
                                                <div class="card card-underline">
                                                    <div class="card-head">
                                                        <header>Condition Column</header>
                                                    </div>
                                                    <div class="card-body no-padding" style="height: 350px; overflow-y: scroll;">
                                                        <ul data-sortable="true" class="list ui-sortable">
                                                            <li class="tile ui-sortable-handle" ng-repeat="fieldname in sqlReport.field.name">
                                                                <div class="checkbox checkbox-styled tile-text">
                                                                    <label>
                                                                        <input ng-click="getWheredData(fieldname, type)" ng-model="type"
                                                                               ng-true-value="'YES'" ng-false-value="'NO'"  type="checkbox" >
                                                                        <span>
                                                                            {{fieldname}}
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div><!--end .card-body -->
                                                </div><!--end .card -->
                                            </div><!--end .col -->
                                            <div class="col-md-4">
                                                <div class="card card-underline">
                                                    
                                                    <div class="card-body small-padding" style="height: 350px; overflow-y: scroll;">
                                                        <div class="form floating-label">
                                                            <div class="form-group" ng-show="wherecolm.length != 0" ng-repeat="n in wherecolm">
                                                                <input type="text" class="form-control input-sm" ng-model="sqlReport.fields[n]" name="contactSearch" placeholder="">
                                                                <label><b>{{n}}</b></label>
                                                            </div>
                                                            <!--end .col -->
                                                        </div><!--end .row -->
                                                    </div>
                                                    <div class="card-head">
                                                        <header><div class="col-xs-12">
                                                                <button ng-click="searchButton()"  typesearchElement="button" class="btn btn-sm ink-reaction btn-info">Search</button>
                                                            </div>
                                                        </header>
                                                    </div>
                                                </div><!--end .card-body -->
                                            </div><!--end .card -->
                                        </div><!--end .col -->
                                    </div>
                                </div>
                            </div><!--end .card-body -->
                        </div><!--end .card -->
                        </div>
                            <div class="row" ng-show="sqlresult!=''"> <div class="col-md-12"  >
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
                                                            <th ng-repeat="colname in selectcolm" class="col-sm text-bold text-center"><h4>{{colname}}</h4></th>
                                                        </tr>

                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="coldata in sqlresult " >
                                                            <td ng-repeat="m in  coldata" class="col-sm text text-center"><span >{{m}}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div><!--end .col -->
                                </div>
                            </div><!--end .row --></div>
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

