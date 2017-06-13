<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Add Employee </title>
    <?php
    //echo $class;

    $this->load->view('include/headcss');
    $staff_id = $this->session->userdata('company_staff_id');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed ">
        <?php $this->load->view('testing/include/header'); ?>
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
                                        <header><i class="fa fa-fw fa-tag"></i>Employee List</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();
                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->connection($db['default']['username'], $db['default']['password'], $db['default']['database'], $db['default']['hostname']);
                                        $xcrud->table('company_staff_details');
                                        $xcrud->columns("name,designation,email_address,mobile_for_sms");
                                        $xcrud->fields("name,designation,rm_id,admin_type,email_address,mobile_for_sms,sms_status,email_status");
                                        $xcrud->label("name", "Name");
                                        $xcrud->label("sms_status", "Sms Status");
                                        $xcrud->label("email_address", "Email");
                                        $xcrud->label("mobile_for_sms", "Mobile No.");
                                        $xcrud->label("sms_status", "Sms Status");
                                        $xcrud->label("email_status", "Email Status");
                                        $xcrud->label("rm_id", "Reporting Manager Name");
                                        $xcrud->label("designation", "Designation");
                                        $xcrud->label("admin_type", "Admin Status");
                                        $xcrud->relation('rm_id', 'company_staff_details', 'id', array("name"));
                                        $xcrud->relation('designation', 'acr_designation', 'designation_name', array("designation_name"));
                                        $xcrud->change_type('admin_type', 'select', 'General', array("NO", "YES"));
                                        $xcrud->limit(25);
                                        $xcrud->validation_required('email_address')->validation_required('email_status')->validation_required('sms_status');
                                        $xcrud->validation_pattern('email_status', 'alpha')->validation_pattern('email_address', 'email')->validation_pattern('mobile_for_sms', 'numeric')->validation_pattern('sms_status', 'alpha');
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->unset_title(TRUE);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(FALSE);
                                        $xcrud->unset_remove(FALSE);
                                        $xcrud->unset_add(FALSE);
                                        $xcrud->unset_edit(FALSE);
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
                                        <header><i class="fa fa-fw fa-tag"></i> How to add a employee</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright"> 
                                        1. Click on ADD button to add a new employee.<br>
                                        2. For edit or delete a employee Detail click on the row's edit or delete button.

                                    </div> 
                                </div><!--end .card-body -->
                            </div><!-- end .card -->

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
            <?php $this->load->view('testing/include/menu'); ?>
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
                window.location = "<?php echo base_url(); ?>index.php/staff/managesubject/" + element.value;
            }
        }
    </script>
