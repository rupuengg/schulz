
<!DOCTYPE html>
<html lang="en">
    <title>Driver Entry</title>
    <?php
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
    <body class="menubar-hoverable header-fixed " ng-app="driverEntryApp" ng-controller="driverEntryController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head style-primary card-head-xs">
                                        <header>Bus Stop Module</header>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $pathToUpload = FCPATH . 'files/' . $this->session->userdata('school_code') . '/transport/';
                                        if (!is_dir($pathToUpload)) {
                                            mkdir($pathToUpload, 0777, TRUE);
                                        }
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();
                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('tms_bus_driver_details');
                                        $xcrud->columns("name,address,mobile_no,dob,pan_number,licence_number,driving_experience,driver_type");
                                        $xcrud->fields("driver_type");
                                        $xcrud->fields("name");
                                        $xcrud->fields("address");
                                        $xcrud->fields("mobile_no");
                                        $xcrud->fields("emergency_mobile_no");
                                        $xcrud->fields("qualification");
                                        $xcrud->fields("dob");
                                        $xcrud->fields("pan_number");
                                        $xcrud->fields("voter_id_number");
                                        $xcrud->fields("licence_number");
                                        $xcrud->fields("licence_valid_upto");
                                        $xcrud->fields("medical_fitness");
                                        $xcrud->fields("driving_experience");
                                        $xcrud->fields("driver_image");
                                        $xcrud->fields("pan_image");
                                        $xcrud->fields("voter_image");
                                        $xcrud->fields("licence_image");
                                        $xcrud->label("name", "Name");
                                        $xcrud->label("address", "Address");
                                        $xcrud->label("mobile_no", "Mobile Number");
                                        $xcrud->label("emergency_mobile_no", "Emergency Mobile Number");
                                        $xcrud->label("qualification", "Qualification");
                                        $xcrud->label("dob", "Date of Birth");
                                        $xcrud->label("pan_number", "Pan Number");
                                        $xcrud->label("pan_image", "Pan Card Image");
                                        $xcrud->label("voter_id_number", "Voter Id Number");
                                        $xcrud->label("voter_image", "Voter Id Image");
                                        $xcrud->label("licence_number", "Licence Number");
                                        $xcrud->label("licence_image", "Licence Image");
                                        $xcrud->label("licence_valid_upto", "Licence Valid Upto");
                                        $xcrud->label("medical_fitness", "Medical fitness");
                                        $xcrud->label("driving_experience", "Driving Experience");
                                        $xcrud->label("driver_type", "Position");
                                        $xcrud->label("driver_image", "Driver Image");
                                        $xcrud->change_type('driver_type', 'select', '', array('values' => array('Please select Driver Type', 'Driver', 'Conductor')));
                                        $xcrud->validation_pattern('name', '^[A-Za-z \s]+$');
                                        $xcrud->change_type('mobile_no', 'int', '', array('maxlength' => 10));
                                        $xcrud->change_type('emergency_mobile_no', 'int', '', array('maxlength' => 10));
                                        $xcrud->change_type('dob', 'date', '');
                                        $xcrud->change_type('pan_image', 'file', false, array('not_rename' => true, 'path' => $pathToUpload));
                                        $xcrud->change_type('voter_image', 'file', false, array('not_rename' => true, 'path' => $pathToUpload));
                                        $xcrud->change_type('licence_image', 'file', false, array('not_rename' => true, 'path' => $pathToUpload));
                                        $xcrud->change_type('licence_valid_upto', 'date', '');
                                        $xcrud->change_type('driver_image', 'file', false, array('not_rename' => true, 'path' => $pathToUpload));
                                        $xcrud->validation_required('driver_type');
                                        $xcrud->validation_required('name');
                                        $xcrud->validation_required('address');
                                        $xcrud->validation_required('mobile_no');
                                        $xcrud->validation_required('emergency_mobile_no');
                                        $xcrud->validation_required('pan_number');
                                        $xcrud->validation_required('licence_number');
                                        $xcrud->validation_required('licence_valid_upto');
                                        $xcrud->validation_required('driving_experience');
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->pass_var("deo_entry_by", $deo_staff_id);
                                        $xcrud->limit(25);
                                        $xcrud->unset_title(TRUE);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(TRUE);
                                        $xcrud->unset_remove(FALSE);

                                        echo $xcrud->render();
                                        ?>
                                    </div>
                                </div>


                            </div>

                        </div><!--end .section-body -->
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
                var myURL = "<?php echo base_url(); ?>";</script>
            <script src="<?php echo base_url(); ?>/assets/myjs/transport/transport.js?v=<?php echo rand(); ?>"></script>  