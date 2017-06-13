<!DOCTYPE html>
<html lang="en">
    <title>Group Wise Setting</title>
    <?php
    $sectionType = '';
    $statusvalue = '';
//    $class = trim($class);
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
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
    <body class="menubar-hoverable header-fixed "  ng-app="groupApp" ng-controller="groupController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="card">
                                    <div class="card-head card-head-xs style-primary">
                                        <header>Select Class</header>
                                        <div class="tools">
                                        </div>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding" >
                                        <form novalidate="" name="tripForm" class="form-horizontal ng-pristine ng-invalid ng-invalid-required" role="form">

                                            <div class="form-group">
                                                <label for="help13" class="col-sm-3 control-label">Group Name:</br>
                                                </label>
                                                <div class="col-sm-5">
                                                    <input type="text" ng-model="group_name"required="" class="form-control ng-pristine ng-invalid ng-invalid-required" id="regular13" ><div class="form-control-line"></div><div class="form-control-line"></div>
                                                </div>
                                            </div>

                                        </form>
                                        <div class="input-group" ng-repeat="class in classArray">
                                            <div class="input-group-addon">
                                                <div class="checkbox checkbox-inline checkbox-styled">
                                                    <label>
                                                        <input id="{{class}}" type="checkbox" value="{{class}}" ng-checked="selection.indexOf(class) > - 1" ng-click="toggleSelection(class)"><span></span>
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="input-group-content">
                                                <label for="groupcheckbox10">{{class}}</label>
                                            </div>

                                        </div>
                                        <div class="card-body  height-3">
                                            <br>
                                            <button type="button" class="btn ink-reaction btn-raised btn-primary" ng-click="savegroup()">Save</button>
                                        </div>
                                    </div><!--end .card-body -->
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="card card-outlined style-primary height-10">
                                    <div class="card-head card-head-xs style-primary ">
                                        <header>Groups Details</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body height-10  scroll">

                                        <div class=" height-8 scroll">
                                            <table class="table table-striped no-margin table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Group Name</th>
                                                        <th>Classes</th>
                                                        <th>Assign teacher</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr  ng-repeat="group in groupdata">
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{group.groupname}}</td>
                                                        <td><button  class="btn btn-flat btn-primary ink-reaction ng-binding" type="submit" ng-click="addgroupstaffs(group.groupId)">Add Teacher</button> </td>
                                                        <td>{{group.detail}}</td>
                                                        <td> <div class="demo-icon-hover" >
                                                                <span class="glyphicon glyphicon-trash" ng-click="deletegroup($index, group.groupId)"></span>
                                                            </div></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end .col -->
                            <div class="col-md-6" ng-show="returndiv == 'true'">
                                <div class="card card-outlined style-primary ">
                                    <div class="card-head card-head-xs style-primary ">
                                        <header>Assigned Teachers</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body ">
                                        <div class="input-group" ng-repeat="teachers in assignedteachers" >
                                            <div class="input-group-addon">
                                                <div class="checkbox checkbox-inline checkbox-styled">
                                                    <label>
                                                        <input id="{{teachers}}" ng-model="teachersId"  type="checkbox" value="{{teachers}}" ng-checked="selectionteachers.indexOf(teachers) > - 1" ng-click="toggleSelectionTeachers(teachers.id)"><span>{{teachers.name}}</span>
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="input-group-content">
                                                <label for="groupcheckbox10"></label>
                                            </div>

                                        </div>
                                                                                <div class="card-body  height-3">
                                                                                    <br>
                                                                                    <button type="button" class="btn ink-reaction btn-raised btn-primary" ng-click="saveassignteachers()">Save</button>
                                                                                </div>
                                    </div>
                                </div>
                            </div><!--end .col -->
                        </div><!--end .row -->

                    </div>
                </section>
            </div><!--end .section-body -->

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
                    var staff_id = "<?php echo $this->uri->segment(3); ?>";</script>

        <script src="<?php echo base_url(); ?>assets/myjs/timetable/timetable.js"></script>
