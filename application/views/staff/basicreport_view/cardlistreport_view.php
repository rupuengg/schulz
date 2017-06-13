

<!DOCTYPE html>
<html lang="en">
    <title>Card List Report</title>
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
    <body class="menubar-hoverable header-fixed " ng-app="myApp" ng-controller="customersCtrl">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-bordered style-primary ">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Card List Report</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">


                                        <div class="form-group">
                                            <select id="dd_card_type" name="select1" class="my-select">
                                                <option value="0">Select Card</option>
                                                <?php
                                                foreach ($cardList as $val) {
                                                    ?>
                                                    <option <?php echo ($cardName) == $val['card_type'] ? 'selected' : ''; ?> value="<?php echo $val['card_type']; ?>"><?php echo $val['card_type']; ?></option>
                                                    <?php
                                                }
                                                ?>


                                            </select>
                                        </div>
                                        <div>
                                            <datepicker date-format="yyyy-MM-dd">
                                               FROM: <input id="txtMyDatePicker1" type="text" class="form-control form-group-xs"/>
                                            </datepicker>
                                            
                                           <datepicker date-format="yyyy-MM-dd">

                                               TO: <input id="txtMyDatePicker2" type="text" class="form-control form-group-xs"/>
                                            </datepicker>
                                            <button id="cmdViewAttendance" class="btn btn-success">View Cards</button>

                                        </div>
                                        <?php
                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('cards_details');
                                        $xcrud->columns("adm_no,remarks,card_issue_date");
                                        $xcrud->where('card_type =', $cardName);
                                        $xcrud->where('card_issue_date >=', $fromDate);
                                        $xcrud->where('card_issue_date <=', $toDate);
                                        $xcrud->label("adm_no", "Name");
                                        $xcrud->label("att_status", "Attendance Status");
                                        $xcrud->label("biodata.firstname", "First Name");
                                        $xcrud->label("biodata.lastname", "Last Name");
                                        $xcrud->relation("adm_no", "biodata", "adm_no", array("firstname", "lastname"));
                                        $xcrud->change_type('card_type', 'select', 'General');
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->pass_var("deo_entry_by", $deo_staff_id);
                                        $xcrud->unset_title(TRUE);
                                        $xcrud->unset_edit(TRUE);
                                        $xcrud->unset_add(TRUE);
                                        $xcrud->unset_view(TRUE);
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
                                                                   <header><i class="fa fa-fw fa-tag"></i> How to Generate Card List Report?</header>
                           
                                                               </div><!--end .card-head -->
                                                         <div class="card-body style-default-bright">
                            
                                                                   Please select a card type and 'from' and 'to' date from the calendar.A report containing the name of the student,attendance date,remarks and the card issue date is generated. 
                                                                   Once the report is generated you can take the print out of the generated report.
                            
                            
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
<script type="text/javascript">
    jQuery(function ($) {
        $('button#cmdViewAttendance').click(function () {
            var from_date = $('input#txtMyDatePicker1').val();
            var to_date = $('input#txtMyDatePicker2').val();
            var new_from_date = from_date.split("/").reverse().join("-");
            var new_to_date = to_date.split("/").reverse().join("-");
            var cardName = $('#dd_card_type').val();
            if (from_date.trim() == '' || to_date.trim() == '') {
                alert('Please select a date');
                return false;
            } else {
                window.location = "<?php echo base_url(); ?>index.php/staff/cardlistreport/" + new_from_date + "/" + new_to_date+"/"+cardName ;
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
<script src="<?php echo base_url(); ?>assets/js/modules/materialadmin/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>