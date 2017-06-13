
<!DOCTYPE html>
<html lang="en">
    <title>
        Add and Manage Event
    </title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed ">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <header><i class="fa fa-fw fa-tag"></i>Manage Events</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-group">
                                        </div>
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('event_details');


                                        $xcrud->columns("name,category,on_date,event_end_date,venue,incharge_staff_id");
                                        $xcrud->order_by("id");

                                        $xcrud->fields("name,category,on_date,event_end_date,venue");
                                        $xcrud->relation("incharge_staff_id", "staff_details", "id", array("staff_fname", "staff_lname"));

                                        $xcrud->where("incharge_staff_id", $staff_id);
                                        $xcrud->label("name", "Event Name");
                                        $xcrud->label("category", "Category");
                                        $xcrud->label("on_date", "Start Date");
                                        $xcrud->label("event_end_date", "End Date");
                                        $xcrud->label("venue", "Venue");
                                        $xcrud->label("incharge_staff_id", "Incharge Name");
                                        $xcrud->validation_required('name');
                                        $xcrud->validation_required('on_date');
                                        $xcrud->set_lang('add', 'Add new Event');
                                    
                                        $xcrud->limit(25);
                                        $xcrud->pass_var("incharge_staff_id", $staff_id);
                                        $xcrud->pass_var("deo_entry_by", $deo_staff_id);
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_title();
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(TRUE);
                                        $xcrud->unset_remove(false);

                                        echo $xcrud->render();
                                        ?>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                            <div class="col-md-4">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> How to manage Events?</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        Add any Event, all the events gets loaded. 

                                        Click on Add button to enter any new event in the database.

                                        <br>-> You can edit or delete any of the event if any activity has been done in it.

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
    echo Xcrud::load_js();
    ?>
     <script>
        var myURL = "<?php echo base_url(); ?>";       
    </script>
   