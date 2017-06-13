
<!DOCTYPE html>
<html lang="en">
    <title>Add Member</title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
    $this->load->view('include/headcss');
//    print_r($clubDetail);
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <?php
    $this->load->library('loadxcrud');
    echo Xcrud::load_css();
    ?>
    <style>
        .fixediv{
            overflow-y: scroll;
            height: 500px
        }
    </style>
    <body class="menubar-hoverable header-fixed " ng-app="clubmgnt" ng-controller="clubmgntController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                     <div class="section-body contain-lg">
                        <div class="row">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-bordered style-primary">
                                <div class="card-head card-head-xs">
                                    <div class="tools">

                                    </div>
                                    <header><i class="fa fa-fw fa-tag"></i> Manage Club?</header>



                                </div><!--end .card-head -->
                                <div class="card-body style-default-bright">
                                    <div class="form-group">

                                        <select id="dd_section_type" onchange="changeURL(this)" name="select1" class="my-select">

                                            <option value="0">Select club</option>
                                            <?php
                                            foreach ($clubList as $val) {
                                                ?>
                                                <option <?php echo ($clubId) == $val['id'] ? 'selected' : ''; ?> value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div> 


                                </div>                                    </div><!--end .card-body -->
                        </div><!--end .card -->
                    </div>
                    <?php if ($clubId > 0) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">

                                    <div class="card-head card-head-xs">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Club Details</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="col-md-3">
                                            <label ><span class="text-bold">Club Name :</span> <?php echo $clubDetail[0]['name'] ?></label>
                                        </div>
                                        <div class="col-md-3">
                                            <label> <span class="text-bold">In-Charge Name:</span><a href="<?php echo base_url() . "/index.php/staff/staffprofile/" . $clubDetail[0]['incharge_id']; ?>" target="_blank"><?php echo $clubDetail[0]['staff_fname'] . ' ' . $clubDetail[0]['staff_lname'] ?></a></label>
                                        </div>
                                        <div class="col-md-3">
                                            <label> <span class="text-bold">Total Member :</span> <?php echo $clubDetail[0]['countmember'] ?></label>
                                        </div>
                                        <div class="col-md-3">
                                            <label> <span class="text-bold">Total Meeting :</span> <?php echo $clubDetail[0]['countmeeting'] ?></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php } ?>

                    <div class="section-body contain-lg">
                        <div class="row">
                            <?php if ($clubId > 0) { ?>
                                <!--end .col -->
                                <div class="col-md-7">
                                    <div class="card card-bordered style-primary  ">
                                        <div class="card-head card-head-xs">
                                            <div class="tools">
                                            </div>
                                            <header><i class="fa fa-fw fa-tag"></i>Manage Meetings</header>
                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright fixediv">
                                            <?php
                                            $xcrud1 = Xcrud::get_instance();
                                            $xcrud1->table('club_meetings');
                                            $xcrud1->fields('meeting_date,venue,meeting_agenda,meeting_summary');
                                            $xcrud1->columns("meeting_date,venue,meeting_agenda,meeting_summary,id");
                                            $xcrud1->where("club_id", $clubId);
                                            $xcrud1->unset_title();
                                            $xcrud1->label("meeting_date", "Meeting Date");
                                            $xcrud1->label("venue", "Venue");
                                            $xcrud1->label("meeting_agenda", "Meeting Agenda");
                                            $xcrud1->label("meeting_summary", "Meeting Summary");
                                            $xcrud1->label("id", "Mark Attendance");
                                            $xcrud1->column_pattern('id', "<a href='javascript:void(0);' ng-click='GetAttDetail({id},$clubId)' class='btn btn-warning'>Mark Attendance</a>");
                                            $xcrud1->relation("club_id", "club_details", "id", array("name"));
                                            $xcrud1->pass_var("club_id", $clubId);
                                            $xcrud1->pass_var("entry_by", $staff_id);
                                            $xcrud1->pass_var("deo_entry_by", $deo_staff_id);
                                            $xcrud1->limit(50);
                                            $xcrud1->unset_add(FALSE);
                                            $xcrud1->unset_edit(False);
                                            $xcrud1->unset_view(TRUE);
                                            $xcrud1->unset_print(TRUE);
                                            $xcrud1->unset_csv(TRUE);
                                            $xcrud1->unset_search(TRUE);
                                            $xcrud1->unset_remove(TRUE);
                                            echo $xcrud1->render();
                                            ?>
                                        </div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div><!--end .col -->
                                <div class="col-md-5">

                                    <div class="card card-bordered style-primary ">

                                        <div class="card-head card-head-xs">
                                            <div class="tools">

                                            </div>
                                            <header><i class="fa fa-fw fa-tag"></i>Manage Club Members</header>
                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright fixediv">


                                            <?php
                                            $xcrud = Xcrud::get_instance();
                                            $xcrud->table('club_member');
                                            $xcrud->fields('adm_no,role');
                                            $xcrud->columns("adm_no,role");
                                            $xcrud->where("club_id", $clubId);
                                            $xcrud->unset_title();
                                            $xcrud->label("club_id", "Club Name");
                                            $xcrud->label("adm_no", "Student Name");
                                            $xcrud->label("role", "Role");
                                            $xcrud->relation("adm_no", "biodata", "adm_no", array("adm_no", "firstname", "lastname"));
                                            $xcrud->relation("club_id", "club_details", "id", array("name"));
                                            $xcrud->pass_var("club_id", $clubId);
                                            $xcrud->pass_var("entry_by", $staff_id);
                                            $xcrud->pass_var("deo_entry_by", $deo_staff_id);
                                            $xcrud->limit(50);
                                            $xcrud->unset_add(FALSE);
                                            $xcrud->unset_edit(TRUE);
                                            $xcrud->unset_view(TRUE);
                                            $xcrud->unset_print(TRUE);
                                            $xcrud->unset_csv(TRUE);
                                            $xcrud->unset_search(TRUE);
                                            $xcrud->unset_remove(TRUE);
                                            echo $xcrud->render();
                                            ?>
                                        </div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div><!--end .col -->
                                <?php ?>


                                <div class="col-md-7" ng-show="meetingId != null">
                                    <div class="card card-bordered style-primary">
                                        <div class="card-head card-head-xs">
                                            <div class="tools">
                                            </div>
                                            <header><i class="fa fa-fw fa-tag"></i>Manage Meeting Attendance</header>
                                        </div><!--end .card-head -->
                                        <div class="card card-outlined style-primary">
                                            <div class="card-body no-padding">
                                                <table class="table table-condensed no-margin table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="memberlist in getmemberData.memberAttDetails" >
                                                            <td>{{memberlist.firstname + ' ' + memberlist.lastname}}</td>
                                                            <td><input ng-model="memberlist.status" ng-checked=" '{{memberlist.attstatus}}'=== 'true'" type="checkbox"> </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <button type="button" ng-disabled="getmemberData.saveAttStatus === 'NO'" ng-click="saveAttDetails()" class="btn ink-reaction btn-floating-action btn-primary"><i class="fa fa-save"></i></button>
                                            </div>

                                        </div>

                                    </div><!--end .card -->
                                </div><!--end .col -->
                            <?php } ?>
                        </div>
                    </div><!--end .card-body -->
                        </div>
                     </div>
                </section>
            </div><!--end .card -->
        </div><!--end .row -->
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
echo Xcrud::load_js();
?>  
<script>
    function changeURL(element) {
        if (element.value == '') {
        } else {
            window.location = "<?php echo base_url(); ?>index.php/staff/addmember/" + element.value;
        }
    }
</script>
<script>var myURL = "<?php echo base_url(); ?>";</script>
<script src="<?php echo base_url(); ?>assets/myjs/clubmgnt.js"></script>