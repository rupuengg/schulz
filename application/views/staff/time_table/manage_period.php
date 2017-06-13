
<!DOCTYPE html>
<html lang="en">
    <title>Manage Period Table</title>
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
    <body class="menubar-hoverable header-fixed " ng-app="PeriodApp" ng-controller="periodController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head style-primary card-head-xs">
                                        <header>Manage Period Module</header>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-sm-6 card card-outlined style-primary height-2" >
                                            <div class="form-group">
                                            </div>
                                            <form role="form" class="form-horizontal" >
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label" for="select13">Select Class Group</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control my-select" ng-model="groupId" ng-change="selectClassGroup();">
                                                            <option value="">Please Select Group</option>
                                                            <option value="{{group.id}}" ng-repeat="group in grouList" ng-selected="{{'<?php echo $this->uri->segment(3) ?>' === group.id}}">{{group.group_name}}</option>
                                                        </select><div class="form-control-line"></div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-md-12" ng-show="{{'<?php echo $this->uri->segment(3) ?>' != ''}}">
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table table-hover no-margin">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No.</th>
                                                                <th>Period Name</th>
                                                                <th>Start Time</th>
                                                                <th>End Time</th>
                                                                <th>Type</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody><span>
                                                            <tr ng-repeat="periodDetail in periodData" id="{{'divID-' + $index}}">
                                                                <td>{{$index + 1}}</td>
                                                                <td><input id="{{'period_name-' + $index}}" ng-model="periodDetail.period_name"  class="form-control-small"/></td>
                                                                <td><input ng-pattern="/^[0-9]+(\:[0-9]{1,2})?$/" id="{{'start_time-' + $index}}" ng-model="periodDetail.start_time" class="form-control-small" placeholder="09:30"/></td>
                                                                <td><input ng-pattern="/^[0-9]+(\:[0-9]{1,2})?$/" id="{{'end_time-' + $index}}" ng-model="periodDetail.end_time" ng- class="form-control-small" placeholder="10:20"/></td>
                                                                <td><input id="{{'period_type-' + $index}}" ng-model="periodDetail.period_type"class="form-control-small"/></td>
                                                                <td><div  class="demo-icon-hover btn btn-flat ink-reaction" ng-click="removePeriodData($index, periodDetail.id)">
                                                                        <i class="fa fa-trash"></i>
                                                                    </div></td>
                                                            </tr>
                                                        </span>
                                                        <tr ng-repeat="period in periodArray" id="{{'divID-' + $index}}" >
                                                            <td>{{indexNo + 1 + $index}}</td>
                                                            <td><input id="{{'period_name-' + $index}}" ng-model="periodDetail.period_name" ng-value="{{period.period_name}}" class="form-control-small"/></td>
                                                            <td><input ng-pattern="/^[0-9]+(\:[0-9]{1,2})?$/" id="{{'start_time-' + $index}}" ng-model="periodDetail.start_time" class="form-control-small" placeholder="09:30"/></td>
                                                            <td><input ng-pattern="/^[0-9]+(\:[0-9]{1,2})?$/" id="{{'end_time-' + $index}}" ng-model="periodDetail.end_time" ng- class="form-control-small" placeholder="10:20"/></td>
                                                            <td><input id="{{'period_type-' + $index}}" ng-model="periodDetail.period_type"class="form-control-small"/></td>
                                                            <td><div  class="demo-icon-hover btn btn-flat ink-reaction" ng-click="addAnotherRow()">
                                                                    <i class="md md-add-box"></i>
                                                                </div><div  class="demo-icon-hover btn btn-flat ink-reaction" ng-click="removePeriod($index)">
                                                                    <i class="fa fa-trash"></i>
                                                                </div><button  class="btn btn-flat btn-primary ink-reaction ng-binding" type="button" ng-click="savePeriod(periodDetail)" >Save</button></td>
                                                        </tr>

                                                        </tbody>
                                                    </table>

                                                </div><!--end .card-body -->

                                            </div><!--end .card -->
                                            <!--                                            <div class="card-actionbar-row">
                                                                                            <button  class="btn btn-flat btn-primary ink-reaction ng-binding" type="button" ng-click="savePeriod()" >Save</button>
                                                                                        </div>-->
                                        </div>


                                    </div><!--end .card-body -->

                                </div>


                            </div>

                        </div><!--end .section-body -->

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
                        var group_id = "<?php echo $this->uri->segment(3); ?>";</script>
            <script src="<?php echo base_url(); ?>assets/myjs/timetable/timetable.js?v=<?php echo rand() ?>"></script>
