
<!DOCTYPE html>
<html lang="en">
    <title>Bus Contractor Module</title>
    <?php
    $sectionType = '';
    $statusvalue = '';
    //$class = trim($class);
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
    <body class="menubar-hoverable header-fixed " ng-app="busContractApp" ng-controller="busContractController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">

                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-head style-primary card-head-xs">
                                        <header>Bus Contractor Module</header>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('tms_bus_contract_details');
                                        $xcrud->columns("id,name,address,mobile_num");
                                        $xcrud->fields("name");
                                        $xcrud->fields("address");
                                        $xcrud->fields("mobile_num");
                                        $xcrud->label("name", "Owner Name");
                                        $xcrud->label("address", "Address");
                                        $xcrud->label("mobile_num", "Mobile Number");
                                        $xcrud->change_type('mobile_num', 'int', '', array('maxlength' => 10));
                                        $xcrud->validation_required('name');
                                        $xcrud->validation_required('address');
                                        $xcrud->validation_required('mobile_num');
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
                                    </div><!--end .card-body -->
                                </div>


                            </div>
                            <div class="col-md-4">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> How to Manage Bus Contractor?</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        To add or manage bus contractor in school.


                                    </div>                                    </div><!--end .card-body -->
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
                var myURL = "<?php echo base_url(); ?>";</script>
            <script src="<?php echo base_url(); ?>/assets/myjs/transport/transport.js"></script>
