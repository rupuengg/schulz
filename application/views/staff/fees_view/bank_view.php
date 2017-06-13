

<!DOCTYPE html>
<html lang="en">
    <title>Bank List Details</title>
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
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Bank List Details</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('fee_bank_details');
                                        $xcrud->columns("bank_name,branch_name,ifsc_code,bank_addrress,phone_no");
                                        $xcrud->fields("bank_name,branch_name,ifsc_code,bank_addrress,phone_no");
                                        $xcrud->unset_title(TRUE);
                                        $xcrud->label("bank_name", "Bank Name");
                                        $xcrud->label("branch_name", "Branch Name");
                                        $xcrud->label("ifsc_code", "Ifsc Code");
                                        $xcrud->label("bank_addrress", "Bank Addrress");
                                        $xcrud->label("phone_no", "Phone No");
                                        $xcrud->before_insert("validifsc");
                                        $xcrud->validation_pattern("bank_name",'alpha');
                                        $xcrud->validation_pattern("branch_name",'alpha');
                                        $xcrud->validation_pattern("phone_no",'[0-9]{10}');
                                        $xcrud->validation_required("bank_name",TRUE);
                                        $xcrud->validation_required("branch_name",TRUE);
                                        $xcrud->validation_required("ifsc_code",TRUE);
                                        $xcrud->pass_var("entry_by",$this->session->userdata('staff_id'));
                                        $xcrud->pass_var("deo_entry_by",$this->session->userdata('deo_staff_id'));
                                        $xcrud->limit(10);
                                        $xcrud->unset_edit(FALSE);
                                        $xcrud->unset_add(FALSE);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(TRUE);
                                        //$xcrud->unset_remove(TRUE);
                                        echo $xcrud->render();
                                        ?>
                                        
<!--                                        <div class="form-group">
                                            <select id="dd_section_type" onchange="changeURL(this)" name="select1" class="my-select">
                                                <option value="0">Select Menu caption</option>
                                                <?php
//                                                foreach ($menuList as $val) {
                                                    ?>
                                                    <option <?php //echo ($menuId) == $val['menuid'] ? 'selected' : ''; ?> value="<?php echo $val['menuid']; ?>"><?php echo $val['menucaption']; ?></option>
                                                    <?php
//                                                }
                                                ?>

                                            </select>
                                        </div>-->
                                       
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                           <div class="col-md-4">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> How to Manage Bank Details?</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        Given list is complete details of the banks.Click on edit button ,Select any category from drop down and click on add button,fill all the details and return' to proceed.<br>

                                        <b></b>

                                    </div>                                    </div><!--end .card-body -->
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
       var baseURL = '<?php echo base_url(); ?>';
    </script>