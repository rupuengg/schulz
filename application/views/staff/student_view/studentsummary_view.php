<!DOCTYPE html>
<html lang="en">
    <title>Student Summary</title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body  class="menubar-hoverable header-fixed" ng-app="StudsummaryApp" ng-controller="StudsummaryController" ng-cloak>
        <?php $this->load->view('include/header');
        ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs" style="height: 15px;">

                                        <header ><i class="fa fa-fw fa-tag" ></i>Student Summary</header>


                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="card">

                                            <div class="card-body">
                                                <div class="form-group col-sm-3" >
                                                    <label class="text-bold" >Select Class</label>
                                                    <select onchange="changeURL(this)"  name="select1" class="my-select">
                                                        <option value=" ">Select Section</option>
                                                        <?php
                                                        foreach ($section_list as $val) {
                                                            ?>
                                                            <option <?php echo ($section_id) == $val['id'] ? 'selected' : ''; ?> value="<?php echo $val['id']; ?>"><?php echo $val['standard'] . ' ' . $val['section']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                        <option <?php echo ($section_id) == '-1' ? 'selected' : ''; ?> value="-1">Unassigned Student</option>
                                                    </select>
                                                    <?php if ($classteacher) { ?>
                                                        <div class="row"><p style="margin-left: 0px;margin-top: 10px;font-size: 13px; display:inline;"  ng-show="mystudents.length > 0">Class Teacher &nbsp;: &nbsp; <span> <?php echo $classteacher; ?> </span> &nbsp;&nbsp;<span style="margin-left:0px; float:left">Total<b> {{mystudents.length}} </b>Students</span></p></div>  
                                                    <?php } ?>
                                                </div>
                                                <div class="form-group11">
                                                    <input style="width: 200px; float: right" ng-show="mystudents.length > 0" type="text" class="form-control" placeholder="Filter Student" ng-model="mySearchInput">
                                                    <a   href="<?php echo base_url(); ?>index.php/staff/managestudent" target="_blank" class="btn btn-info" style="margin-right: 0px;margin-top: 25px"><i class="fa fa-plus"></i>New Student</a>
                                                </div>


                                                <table class="table table-condensed no-margin table-bordered table-striped table-responsive" ng-show="mystudents.length > 0">

                                                    <tr>
                                                        <th class="text-center">Photo</th>
                                                        <th class="text-center ">Adm.No.(Name)</th>
                                                        <th class="text-center ">Guardian</th>
                                                        <th class="text-center ">Mobile</th>
                                                        <th class="text-center ">D.O.B</th>
                                                        <!--<th class="text-center ">House</th>-->
                                                        <!--<th class="text-center ">Roll.No</th>-->
                                                        <th class="text-center ">Sex</th>
                                                        <th class="text-center ">Email</th>
                                                        <th class="text-center ">Address</th>
                                                        <th class="text-center ">Action</th>

                                                    </tr>
                                                    <tr ng-repeat="studinfo in mystudents| filter:mySearchInput" >
                                                        <td ><img class="img-circle width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{studinfo.adm_no}}/THUMB"; ?>" alt=""></td>
                                                        <td><a class="tile-content ink ink-reaction" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{studinfo.adm_no}}" target="_blank()">{{studinfo.adm_no}}.{{studinfo.stud_name}}</a></td>
                                                        <td>{{studinfo.g_name}}</td>
                                                        <td>{{studinfo.contact_no}}</td>
                                                        <td style="white-space: nowrap">{{studinfo.dob_date| date:'dd MMM yyyy'}}</td>
                                                       <!--/ <td>{{studinfo.house}}</td>-->
                                                        <!--<td>{{studinfo.roll_no}}</td>-->
                                                        <td>{{studinfo.sex}}</td>
                                                        <td>{{studinfo.e_mail}}</td>
                                                        <td>{{studinfo.address}}</td>
                                                        <td><a title="Edit Deatils" href="<?php echo base_url(); ?>index.php/staff/managestudent/{{studinfo.adm_no}}" class="btn btn-flat btn-info"><i class="fa fa-edit"></a></td>
                                                    </tr>
                                                </table>
                                            </div><!--end .card-body -->
                                            <button ng-show="showLoad == true" ng-click="loadStudent()" class="btn btn-loading-state btn-default-dark" style="display:block;   margin: 0 auto; border:0px;">Load More</button>

                                        </div>

                                    </div><!--end .card-body -->
                                </div><!--end .card -->
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
        var sec_id = '<?php echo $section_id ? $section_id : "FALSE"; ?>';
        function changeURL(element) {

            if (element.value == '') {
            } else {
                window.location = "<?php echo base_url(); ?>index.php/staff/studentsummary/" + element.value;
            }
        }

    </script>
    <script src="<?php echo base_url(); ?>/assets/myjs/studentsummary.js"></script>
