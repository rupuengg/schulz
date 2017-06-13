<!DOCTYPE html>
<html lang="en">
    <title>
        Manage Event
    </title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
  
   foreach ($team_name as $value) {
        $TeamName = $value['name'];
    }
    
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="eventApp" ng-controller="eventAppController" ng-cloak ng-class="cloak">

        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="form-group" style="margin-left: 11px;">
                                <label for="select1">Select Event</label>
                                <select ng-model="eventDetail" ng-app ng-init="eventDetail='<?php echo $event_id; ?>'" ng-change="selectEvent()" id="dd_section_type"  class="my-select" >
                                    <option value="0">Select Event</option>
                                    <option  ng-repeat="eventObj in myEvent" value="{{eventObj.id}}" ng-selected="eventDetail === eventObj.id">{{eventObj.name}}</option>
                                </select>
                                
                            </div>
                            <div ng-show="eventDetail>0">
                                <div class="col-md-7">
                                    <div class="card card-bordered style-primary">
                                        <div class="card-head card-head-xs">
                                            <header><i class="fa fa-fw fa-tag"></i>Manage Events</header>
                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright myNewClass">

                                            <div  class="row">
                                                <dl ng-repeat="j in myEventDetail" class="dl-horizontal text-lg">
                                                    <dt>Event Name</dt>
                                                    <dd style="margin-left: 130px !important;"><strong>: </strong>{{j.name}}</dd>
                                                    <dt>Category</dt>
                                                    <dd style="margin-left: 130px !important;"><strong>: </strong>{{j.category}}</dd>
                                                    <dt>Subevent Type</dt>
                                                    <dd style="margin-left: 130px !important;"><strong>: </strong>{{j.subevent_type}}</dd>
                                                    <dt>Start Date</dt>
                                                    <dd style="margin-left: 130px !important;"><strong>: </strong>{{j.on_date}}</dd>
                                                    <dt>End Date</dt>
                                                    <dd style="margin-left: 130px !important;"><strong>: </strong>{{j.event_end_date}}</dd>
                                                    <dt>Venue</dt>
                                                    <dd style="margin-left: 130px !important;"><strong>: </strong>{{j.venue}}</dd>
                                                    <dt>Start Time</dt>
                                                    <dd style="margin-left: 130px !important;"><strong>: </strong>{{j.start_time}}</dd>
                                                    <dt>End Time</dt>
                                                    <dd style="margin-left: 130px !important;"><strong>: </strong>{{j.end_time}}</dd>
                                                    <dt>End Time</dt>
                                                    <dd style="margin-left: 130px !important;"><strong>: </strong>{{j.end_time}}</dd>
                                                    <dt>Report</dt>
                                                    <dd style="margin-left: 130px !important;"><strong>: </strong>{{j.report}}</dd>
                                                    <dt>Rules</dt>
                                                    <dd style="margin-left: 130px !important;"><strong>: </strong>{{j.rules}}</dd>

                                                    <dt>Volunteers:</dt>
                                                    <dd style="margin-left: 130px !important;"><strong>: </strong>Total {{myEventVolStud.length + myEventVolStaff.length}} | {{myEventVolStud.length}} Students | {{myEventVolStaff.length}} Staff</dd>
                                                    <dt>Teams:</dt>
                                                    <dd style="margin-left: 130px !important;"><strong>: </strong>{{myTeamLength.length}}({{myTeamMemLength.length}} Members)</dd>

                                                </dl>

                                            </div>

                                        </div><!--end .card-body -->

                                    </div><!--end .card -->

                                </div><!--end .col -->
                                <div class="col-md-5">
                                    <div class="card card-bordered style-primary">
                                        <div class="card-head card-head-xs">
                                            <div class="tools">

                                            </div>
                                            <header><i class="fa fa-fw fa-tag"></i> Manage Teams</header>
                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright">
                                            <?php
                                            $this->load->library('loadxcrud');
                                            echo Xcrud::load_css();

                                            $xcrudteam = Xcrud::get_instance();
                                            $xcrudteam->table('event_team_detail');
                                            $xcrudteam->columns("name,team_type,deo_entry_by");
                                            $xcrudteam->relation("event_id", "event_details", "id", array("name"), array("id" => $event_id));
                                            $xcrudteam->fields("name,team_type");
                                            $xcrudteam->validation_required("name");
                                            $xcrudteam->label("deo_entry_by", "Action");
                                            $xcrudteam->label("team_type", "Type");
                                            $xcrudteam->label("team_type", "Type");
                                            $xcrudteam->where("event_id", $event_id);
                                            $xcrudteam->set_lang('add', 'Add new Team');
                                            $xcrudteam->column_pattern('deo_entry_by', "<a href='" . base_url() . "index.php/staff/myevents/$event_id/{id}' class='btn btn-warning '>Add Member</a>");

                                            $xcrudteam->pass_var("event_id", $event_id);
                                            $xcrudteam->pass_var("entry_by", $staff_id);
                                            $xcrudteam->pass_var("deo_entry_by", $deo_staff_id);

                                            $xcrudteam->limit(50);
                                            $xcrudteam->unset_view(TRUE);
                                            $xcrudteam->unset_title();
                                            $xcrudteam->unset_print(TRUE);
                                            $xcrudteam->unset_csv(TRUE);
                                            $xcrudteam->unset_search(TRUE);
                                            $xcrudteam->unset_remove(FALSE);

                                            echo $xcrudteam->render();
                                            ?>
                                        </div>                               
                                    </div><!--end .card-body -->
                                </div>

                                <div class="col-md-7">  <!--start Volunteers -->
                                    <div class="card card-bordered style-primary">
                                        <div class="card-head card-head-xs">
                                            <header><i class="fa fa-fw fa-tag"></i>Manage Student Volunteer for Event &nbsp;:&nbsp;<span ng-repeat="e in myEventDetail"> {{e.name}}</span></header>
                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright" >

                                            <?php
                                            $xcrud = Xcrud::get_instance();
                                            $xcrud->table('event_volunteer_student');
                                            $xcrud->columns("volunteer_adm_id,work,remark");
                                            $xcrud->order_by("volunteer_adm_id");
                                            $xcrud->fields("volunteer_adm_id,work,remark");
                                            $xcrud->relation("event_id", "event_details", "id", array("name"), array("id" => $event_id));
                                            $xcrud->relation("volunteer_adm_id", "biodata", "adm_no", array("firstname", 'lastname'));
                                            
                                            $xcrud->validation_required('volunteer_adm_id');
                                            $xcrud->label("volunteer_adm_id", "Volunteer Name");
                                            $xcrud->label("work", "Work");
                                            $xcrud->label("remark", "Remark");
                                            $xcrud->set_lang('add', 'Add new Volunteer Student');
                                            $xcrud->where("event_id", $event_id);

                                            $xcrud->pass_var("event_id", $event_id);
                                            $xcrud->pass_var("entry_by", $staff_id);
                                            $xcrud->pass_var("deo_entry_by", $deo_staff_id);


                                            $xcrud->limit(50);

                                            $xcrud->unset_view(TRUE);
                                            $xcrud->unset_print(TRUE);
                                            $xcrud->unset_csv(TRUE);
                                            $xcrud->unset_search(TRUE);
                                            $xcrud->unset_remove(FALSE);
                                            $xcrud->unset_title();
                                            echo $xcrud->render();
                                            ?>


                                        </div><!--end .card-body -->

                                    </div><!--end .card -->

                                </div><!--end Volunteers -->
                                <div ng-show="showDivTeamMember" >
                                    <div class="col-md-5">
                                        <div class="card card-bordered style-primary">
                                            <div class="card-head card-head-xs">
                                                <div class="tools">

                                                </div>
                                                <header><i class="fa fa-fw fa-tag"></i> Manage Team Members for Team <?php
                                                    if (isset($TeamName)) {
                                                        echo $TeamName;
                                                    }
                                                    ?>  </header>
                                            </div><!--end .card-head -->
                                            <div class="card-body style-default-bright">
                                                <?php
                                                $xcrudteam_member = Xcrud::get_instance();
                                                $xcrudteam_member->table('event_team_member');
                                                $xcrudteam_member->columns("adm_no,role");
                                                $xcrudteam_member->fields("adm_no,role");
                                                $xcrudteam_member->relation("team_id", "event_team_detail", "id", array("name"), array("id" => $team_id));
                                                $xcrudteam_member->relation("adm_no", "biodata", "adm_no", array("firstname", "lastname"));
                                                $xcrudteam_member->validation_required('team_id');
                                                $xcrudteam_member->label("adm_no", "Student Name");
                                                $xcrudteam_member->label("role", "Role");
                                                $xcrudteam_member->where("team_id", $team_id);
                                                $xcrudteam_member->set_lang('add', 'Add new Team Member');
                                                $xcrudteam_member->pass_var("team_id", $team_id);
                                                $xcrudteam_member->pass_var("event_id", $event_id);
                                                $xcrudteam_member->pass_var("entry_by", $staff_id);
                                                $xcrudteam_member->pass_var("deo_entry_by", $deo_staff_id);


                                                $xcrudteam_member->limit(50);
                                                $xcrudteam_member->unset_view(TRUE);

                                                $xcrudteam_member->unset_print(TRUE);
                                                $xcrudteam_member->unset_csv(TRUE);
                                                $xcrudteam_member->unset_search(TRUE);
                                                $xcrudteam_member->unset_remove(FALSE);
                                                $xcrudteam_member->unset_title();
                                                echo $xcrudteam_member->render();
                                                ?>
                                            </div>                               
                                        </div><!--end .card-body -->
                                    </div>
                                </div>

                                <div class="col-md-7">  <!--start Volunteers -->
                                    <div class="card card-bordered style-primary">
                                        <div class="card-head card-head-xs">
                                            <header><i class="fa fa-fw fa-tag"></i>Manage Staff Volunteer for Event &nbsp;:&nbsp;<span ng-repeat="k in myEventDetail"> {{k.name}}</span></header>
                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright" >

                                            <?php
                                            $xcrudstaff = Xcrud::get_instance();
                                            $xcrudstaff->table('event_volunteer_staff');

                                            $xcrudstaff->columns("volunteer_staff_id, work,remark");
                                            $xcrudstaff->order_by("volunteer_staff_id");
                                            $xcrudstaff->fields("volunteer_staff_id, work,remark");
                                            $xcrudstaff->relation("event_id", "event_details", "id", array("name"), array("id" => $event_id));
                                            $xcrudstaff->relation("volunteer_staff_id", "staff_details", "id", array("staff_fname", 'staff_lname'));
                                            $xcrudstaff->label("event_id", "Event Name");
                                            $xcrudstaff->label("volunteer_staff_id", "Volunteer Name");
                                            $xcrudstaff->set_lang('add', 'Add new Volunteer Staff');
                                            $xcrudstaff->label("work", "Work");
                                            $xcrudstaff->label("remark", "Remark");
                                            
                                            $xcrudstaff->where("event_id", $event_id);
                                            $xcrudstaff->validation_required('volunteer_staff_id');
                                            $xcrudstaff->pass_var("event_id", $event_id);
                                            $xcrudstaff->pass_var("entry_by", $staff_id);
                                            $xcrudstaff->pass_var("deo_entry_by", $deo_staff_id);


                                            $xcrudstaff->limit(50);
                                            $xcrudstaff->unset_view(TRUE);
                                            $xcrudstaff->unset_print(TRUE);
                                            $xcrudstaff->unset_csv(TRUE);
                                            $xcrudstaff->unset_search(TRUE);
                                            $xcrudstaff->unset_remove(FALSE);
                                            $xcrudstaff->unset_title();
                                            echo $xcrudstaff->render();
                                            ?>


                                        </div><!--end .card-body -->

                                    </div><!--end .card -->

                                </div><!--end Volunteers -->


                                <!--end .card -->
                            </div>
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
    echo Xcrud::load_js();
    ?>
    <script>
        var myURL = "<?php echo base_url(); ?>";
        var event_id = "<?php echo $event_id; ?>";
        var team_id = "<?php echo $team_id; ?>";
    </script>
    <script src="<?php echo base_url(); ?>/assets/myjs/eventstaff.js"></script>
