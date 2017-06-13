<!DOCTYPE html>
<html lang="en">
    <title>Substitute Time Table</title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/autocomplete/angucomplete-alt.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/autocomplete/fonts/bariol/bariol.css"/>
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
    <body class="menubar-hoverable header-fixed " ng-app="substituteTimetableApp" ng-controller="substituteTimetableController">
        <?php $this->load->view('include/header'); ?>
        <script> var mydate = '<?php echo $substitute_date; ?>';</script>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head style-primary card-head-xs">
                                        <header>Substitute Time Table Module</header>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-sm-6 card card-outlined style-primary" >
                                            <div class="form-group">
                                            </div>
                                            <form role="form" class="form-horizontal" >
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label" for="select13">Select Date</label>
                                                    <div class="col-sm-7">
                                                        <datepicker date-format="yyyy-MM-dd">
                                                            <input type="text" class="form-control" placeholder="Date" ng-model="mydate" ng-change="getdate()"> 
                                                        </datepicker><div class="form-control-line"></div>
                                                        </br ><?php echo "Today is " . date("l"); ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-body text-right height-3">
                                            <br>
                                            <button type="button" class="btn ink-reaction btn-floating-action btn-primary" ng-click="addAnotherRow()"><i class="fa fa-plus"></i></button>
                                        </div><!--end .card-body -->
                                        <div class="col-md-12">
                                            <div class="card" ng-repeat="(fIndex,period) in periodArray" id="{{'divID-' + $index}}" > 
                                                <div class="card-head card-head-xs">
                                                    <form class="form-horizontal" name="myForm" role="form" novalidate>
                                                        <div class="form-group">
                                                            <label for="select13" class="col-sm-2 control-label">{{period.teacherId}}Absent Teacher{{$index + 1}}:</label>
                                                            <div class="col-sm-3">
                                                                <select class="my-select" name="select13"  ng-model="period.teacherId"  ng-change="setteacher(period.teacherId, $index);" ng-init="period.teacherId = 0">
                                                                    <option value="0">Select Teacher</option>
                                                                    <option selected="selected" ng-repeat="absent in absentteachers" 
                                                                            value="{{absent.id}}" ng-selected="{{'<?php echo $this->uri->segment(4) ?>' === absent.id}}">{{absent.salutation + '' + absent.staff_fname + ' ' + absent.staff_lname}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-bordered no-margin" >
                                                        <thead>
                                                            <tr>
                                                                <th ng-repeat="periods in perioddata[fIndex]" ng-model="period.periodId" >{{periods.period_name}}</br>{{periods.start_time + '-' + periods.end_time}}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td ng-repeat="list in subjectsectionlist[fIndex]">{{list.standard + '' + list.section}}</br>{{list.subject_name}}
                                                                    <select class="my-select" id="{{'subject' + list.id}}" name="selectId" ng-model="period.substitute" ng-change="savesubstitutedetails(list, period.teacherId);" >
                                                                        <option value="">Substitute Teacher</option>
                                                                        <option  ng-repeat="substitute in substituteteachers[fIndex]"
                                                                                 value="{{substitute.id}}" >{{substitute.name}}</option>
                                                                    </select>
                                                                </td>
                                                        </tbody>
                                                    </table>
                                                </div><!--end .card-body -->
                                                <!--                                                <div class="card-body" >
                                                                                                    <h4 >No data Found</h4>
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
                var curr_date = "<?php echo $substitute_date ?>";
                var staff_id = "<?php echo $this->uri->segment(4); ?>";

            </script>

            <script src="<?php echo base_url(); ?>assets/js/autocomplete/angucomplete-alt.js"></script>
            <script src="<?php echo base_url(); ?>assets/myjs/timetable/timetable.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/angular-touch.min.js"></script>
