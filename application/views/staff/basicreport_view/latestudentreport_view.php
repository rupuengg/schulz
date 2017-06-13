

<!DOCTYPE html>
<html lang="en">
    <title>Late Student Report</title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <?php
    $this->load->library('loadxcrud');
    echo Xcrud::load_css();
    ?>
    <style>
        .mybuttoncustom{
            position: relative;
            float: none !important;
        }
    </style>
    <body class="menubar-hoverable header-fixed " ng-app="myApp" ng-controller="customersCtrl">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Late Coming Student Reports</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class=" row">
                                            <div class="col-md-4">
                                                <datepicker date-format="yyyy-MM-dd">
                                                    <input id="txtMyDatePicker" class="form-control form-group" type="text" />
                                                </datepicker>
                                                <!--<input  name="myDate" placeholder="dd-mm-yyyy"/>-->
                                                <button id="cmdViewAttendance" class="btn btn-success mybuttoncustom">View </button>
                                            </div>
                                        </div>
                                        <?php
                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('late_coming_details');
                                        $xcrud->columns("adm_no,coming_date,coming_time,reason");
                                        $xcrud->where('coming_date =', $attDate);
                                        $xcrud->unset_title();
                                        $xcrud->label("adm_no", "Name");
                                        $xcrud->label("coming_date", "Coming Date");
                                        $xcrud->label("coming_time", "Coming Time");
                                        $xcrud->label("reason", "Reason");
                                        $xcrud->relation("adm_no", "biodata", "adm_no", array("firstname", "lastname"));
                                        $xcrud->change_type('att_date', 'select', 'General');
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->pass_var("deo_entry_by", $deo_staff_id);
                                        $xcrud->limit(50);
                                        $xcrud->unset_edit(TRUE);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_add(TRUE);
                                        $xcrud->unset_print(FALSE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(TRUE);
                                        $xcrud->unset_remove(TRUE);
                                        echo $xcrud->render();
                                        ?>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                            <div class="col-md-4">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> How to Generate Late Student Report?</header>

                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">

                                        Please select a class and any particular date from the drop down list.You can see a report containing the name of the student,late coming date,late coming time and the reason for being late. 



                                    </div>                                    </div><!--end .card-body -->
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
        </div>
        <div class="menubar-scroll-panel">
            <?php $this->load->view('include/menu'); ?>
        </div>
    </div>
    <?php
    $this->load->view('include/headjs');
    ?>
    <script type="text/javascript">
        jQuery(function ($) {
            $('button#cmdViewAttendance').click(function () {
                var att_date = $('input#txtMyDatePicker').val();
                var newdate = att_date.split("/").reverse().join("-");
                var mydate = '{"attdate" :"' + newdate + '"}';
                if (att_date.trim() == '') {
                    alert('Please select a date');
                    return false;
                } else {
                    window.location = "<?php echo base_url(); ?>index.php/staff/latestudentreport/" + mydate;
                }
            });
           
        });
        var app = angular.module('myApp', ['720kb.datepicker']);
        app.controller('customersCtrl', function ($scope, $http) {

        });

    </script>
    <?php
    echo Xcrud::load_js();
    ?>
  