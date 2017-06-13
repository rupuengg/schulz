
<!DOCTYPE html>
<html lang="en">
    <title>Class Wise Time Table</title>
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
    <body class="menubar-hoverable header-fixed " ng-app="classtimetableApp" ng-controller="classtimetableController" ng-cloak>
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" >
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head style-primary card-head-xs">
                                        <header>Class Wise Time Table Module</header>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-sm-6 card card-outlined style-primary height-3" >
                                            <div class="form-group">
                                            </div>
                                            <form role="form" class="form-horizontal" >
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label" for="select13">Select Group</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control my-select" ng-model="groupId" ng-change="selectClassGroup();">
                                                            <option value="">Please Select Group</option>
                                                            <option value="{{group.id}}" ng-repeat="group in groupList" ng-selected="{{'<?php echo $this->uri->segment(3) ?>' === group.id}}">{{group.group_name}}</option>
                                                        </select><div class="form-control-line"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label" for="select13">Select Section</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control" name="select13" ng-model="sectionId" id="select13" ng-change="selectSection()">
                                                            <option value="">Please select Class Section</option>
                                                            <option ng-repeat="section in sectionList" value="{{section.section_id}}"  ng-selected="{{'<?php echo $this->uri->segment(4) ?>' === section.section_id}}">{{section.standard}}{{section.section}}</option>
                                                        </select><div class="form-control-line"></div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-12" ng-show="{{'<?php echo $this->uri->segment(4) ?>' != ''}}">
                                            <div class="card">
                                                <div class="card-body" >
                                                    <?php //echo '<pre>'; print_r(count($classdata['weekData']));?>
                                                    <table class="table table-hover no-margin table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Day</th>
                                                                <?php foreach ($classdata['periodDetail'] as $res) { ?>
                                                                    <th><?php echo $res['period_name']; ?></br><?php echo $res['start_time']; ?>-<?php echo $res['end_time']; ?></th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php for ($i = 0; $i < count($classdata['weekData']); $i++) { ?>
                                                                <tr>
                                                                    <td><?php echo $classdata['weekData'][$i]['dayfullname'] ?></td>
                                                                    <?php
                                                                    for ($j = 0; $j < count($classdata['weekData'][$i]['periodData']) - 1; $j++) {
                                                                        if ($i == 0 && strtoupper($classdata['periodDetail'][$j]['period_type']) == 'LUNCH') {
                                                                            ?>
                                                                            <?php if ($j) { ?>
                                                                                <td rowspan="<?php echo count($classdata['weekData']) ?>">Lunch</td>
                                                                                <td><?php if ($classdata['weekData'][$i]['periodData'][$j]['subject_id'] != '') { ?><?php echo $classdata['weekData'][$i]['periodData'][$j]['subject_name'] ?></br>
                                                                                        <?php echo $classdata['weekData'][$i]['periodData'][$j]['salutation'] ?><?php echo $classdata['weekData'][$i]['periodData'][$j]['staff_lname'] ?>
                                                                                        <a ng-click="showSubjectList('<?php echo $classdata['weekData'][$i]['weekName'] ?>', '<?php echo $classdata['periodDetail'][$j]['id'] ?>');" data-target="#simpleModal" data-toggle="modal" class="btn btn-flat ink-reaction"><i class="fa fa-pencil"></i></a><?php } else { ?>
                                                                                        <a ng-click="showSubjectList('<?php echo $classdata['weekData'][$i]['weekName'] ?>', '<?php echo $classdata['periodDetail'][$j]['id'] ?>');" data-target="#textModal" data-toggle="modal" class="btn btn-flat ink-reaction"><i class="fa fa-pencil"></i></a> 
                                                                                    <?php } ?>
                                                                                </td>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <td>
                                                                                <?php if ($classdata['weekData'][$i]['periodData'][$j]['subject_id'] != '') { ?><?php echo $classdata['weekData'][$i]['periodData'][$j]['subject_name'] ?></br>
                                                                                    <?php echo $classdata['weekData'][$i]['periodData'][$j]['salutation'] ?><?php echo $classdata['weekData'][$i]['periodData'][$j]['staff_lname'] ?>
                                                                                    <a ng-click="showSubjet('<?php echo $classdata['weekData'][$i]['weekName'] ?>', '<?php echo $classdata['periodDetail'][$j]['id'] ?>');" data-target="#simpleModal" data-toggle="modal" class="btn btn-flat ink-reaction"><i class="fa fa-pencil"></i></a><?php } else { ?>
                                                                                    <a ng-click="showSubjectList('<?php echo $classdata['weekData'][$i]['weekName'] ?>', '<?php echo $classdata['periodDetail'][$j]['id'] ?>');" data-target="#textModal" data-toggle="modal" class="btn btn-flat ink-reaction"><i class="fa fa-pencil"></i></a> 
                                                                                <?php } ?></td> 
                                                                        <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tr>
<?php } ?>
                                                            <tr><td>Sunday</td>
                                                                <td colspan="11"><div class="form-group text-center text-bold">Holiday</div></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div><!--end .card-body -->

                                            </div><!--end .card -->
                                            <!--                                            <div class="card-actionbar-row">
                                                                                            <button  class="btn btn-flat btn-primary ink-reaction ng-binding" type="submit" >Save</button>
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
            <div ng-show="showable == true"aria-hidden="false" aria-labelledby="textModalLabel" role="dialog" tabindex="-1" id="textModal" class="modal fade in" style="display: none;"><div class="modal-backdrop fade in" style="height: 1021px;"></div>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button id="textModalLabel" aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 id="textModalLabel" class="modal-title">Subject List</h4>
                        </div>
                        <div class="card-body">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Subject Name</th>
                                        <th>Teacher Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="subject in subjectList">
                                        <td>{{$index + 1}}</td>
                                        <td>{{subject.subject_name}}</td>
                                        <td>{{subject.salutation}}{{subject.staff_fname}}{{subject.staff_lname}}</td>
                                        <td><button class="btn btn-primary" type="button" ng-click="assignSubjectTeacher(subject)">Select</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!--end .card-body -->

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <div ng-show="showsubject == true" aria-hidden="false" aria-labelledby="simpleModalLabel" role="dialog" tabindex="-1" id="simpleModal" class="modal fade in" style="display: block; padding-right: 13px;"><div class="modal-backdrop fade in" style="height: 346px;"></div>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button id="simpleModalLabel" aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 id="simpleModalLabel" class="modal-title">Do you want to change?</h4>
                        </div>
                        <div class="card-body">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Subject Name</th>
                                        <th>Teacher Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="subject in subjectList">
                                        <td>{{$index + 1}}</td>
                                        <td>{{subject.subject_name}}</td>
                                        <td><a class="tile-content ink-reaction" href="<?php echo base_url(); ?>index.php/staff/staffprofile/{{subject.teacher_id}}">{{subject.salutation}}{{subject.staff_fname}}{{subject.staff_lname}}</a></td>
                                        <td><button class="btn btn-primary" type="button" ng-click="assignSubjectTeacher(subject)">Update</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>  
                </div> 
            </div>
            <?php
            $this->load->view('include/headjs');
            ?>
            <script>
                var myURL = "<?php echo base_url(); ?>";
                var group_id = "<?php echo $this->uri->segment(3); ?>";
                var section_id = "<?php echo $this->uri->segment(4); ?>";
            </script>
            <script src="<?php echo base_url(); ?>assets/myjs/timetable/timetable.js"></script>