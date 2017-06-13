
<!DOCTYPE html>
<html lang="en">
    <title>Add Club</title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
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
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Add Club</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-group">


                                        </div>
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('club_details');
                                        $xcrud->fields("name,description,incharge_id");
                                        $xcrud->columns("name,description,incharge_id");
                                        $xcrud->unset_title();
                                        $xcrud->label("name", "Club Name");
                                        $xcrud->label("description", "Description");
                                        $xcrud->label("incharge_id", "Incharge Name");
//                                        $xcrud->where("incharge_id = $staff_id ");
                                        $xcrud->relation('incharge_id', 'staff_details', 'id', array('staff_fname', 'staff_lname'));
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->pass_var("deo_entry_by", $deo_staff_id);
                                        $xcrud->limit(50);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_edit(FALSE);
                                        $xcrud->unset_print(TRUE);
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
                                        <header><i class="fa fa-fw fa-tag"></i> How to Assign Club?</header>

                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">

                                        Click on ADD button to select a club.Choose a club name,incharge name and role you want to enroll in.  

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
    echo Xcrud::load_js();
    ?>
    <script>
        function changeURL(element) {
            if (element.value == '') {
            } else {
                window.location = "<?php echo base_url(); ?>index.php/staff/addclub/" + element.value;
            }
        }


    </script>