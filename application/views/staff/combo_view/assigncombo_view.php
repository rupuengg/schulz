<!DOCTYPE html>
<html lang="en">
    <title>Assign Combo</title>
    <?php
    $session_id = $this->session->userdata('staff_id');
    $this->load->view('include/headcss');
    ?>
    <body class="menubar-hoverable header-fixed "  ng-app="ComboDetails"  ng-controller="ComboDetailsController" ng-cloak>
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head card-head-xs style-primary">
                                        <header>Assign Combo</header>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="select1">Section</label>
                                                    <select ng-model="score" ng-app ng-init="score = 'NA'" ng-change="getScoreData()" class="form-control">
                                                        <option value="NA">Please Select</option>
                                                        <option ng-repeat="sectionlist in data.section" value="{{sectionlist.id}}"> {{sectionlist.standard}} {{sectionlist.section}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="select1">Combo</label>

                                                    <select ng-model="selectcombo" ng-app ng-init="selectcombo = 'NA'" id="select1" name="select1" class="form-control">
                                                        <option value="NA">Please Select</option>
                                                        <option ng-repeat="combosubjectObj in studentlist.combo" value="{{combosubjectObj.combo_id}}">{{combosubjectObj.combo_name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!--end .card-body -->
                                    <div class="card-body no-padding" ng-show="type == 'yes'">
                                        <div class="card-body">
                                            <div class="col-sm-12">
                                                <table class="table table-striped no-margin" >
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Pic</th>
                                                            <th>Student Name</th>
                                                            <th>Combo</th>
                                                            <th>Status</th>
                                                            <th><button type="button" class="btn btn-small ink-reaction btn-success"  ng-click="assignCombo(selectcombo)">Save</button></p></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="studentlistObj in studentlist.student">
                                                            <td ><input value="{{studentlistObj.adm_no}}" type="checkbox" ng-model="studentlistObj.checked" ng-hide="studentlistObj.display"></td>
                                                            <td><img class="img-circle width-1" alt="" src="<?php echo base_url(); ?>index.php/staff/getstudphoto/{{studentlistObj.adm_no}}/THUMB"></td>
                                                            <td><a class="tile-content ink ink-reaction" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{studentlistObj.adm_no}}">{{studentlistObj.firstname}} {{studentlistObj.lastname}}</a></td>
                                                            <td>{{studentlistObj.combo}}</td>
                                                            <td>{{studentlistObj.assign}}</td>
                                                            <td><a class="btn btn-flat ink-reaction btn-default" ng-show="studentlistObj.display" ng-click="deleteCombo(studentlistObj);">
                                                                    <i id="{{studentlistObj.adm_no}}" class="fa fa-trash" ></i>
                                                                </a></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
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
                            <span class="text-lg text-bold text-primary "></span>
                        </a>
                    </div>
                </div>
                <div class="menubar-scroll-panel">
                    <?php $this->load->view('include/menu'); ?>
                </div>
            </div><!--end #menubar-->
            <!-- END MENUBAR -->
        </div>
        <?php
        $this->load->view('include/headjs');
        ?>
        <script>
            var login = "<?php echo $session_id; ?>";
            var base_url = "<?php echo base_url(); ?>";
        </script>
        <script src="<?php echo base_url(); ?>assets/myjs/combodetails.js?A=a"></script>

    </body>
</html>