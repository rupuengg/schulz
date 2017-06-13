<!DOCTYPE html>
<html lang="en">
    <title>Manage Section</title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
    $this->load->view('include/headcss');
    $statusvalue = -1;
    if ($sectionType == 'ACT') {
        $statusvalue = 1;
    }
    if ($sectionType == 'DEC') {
        $statusvalue = 0;
    }
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
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="md md-colorize"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> Add Section</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-group">
                                            <select id="dd_section_type" ng-model="sectionMain" ng-app ng-init="sectionMain = 'NA'" onchange="changeURL(this)" name="select1" class="my-select">
                                                <option value="NA">Select Status</option>
                                                <option <?php echo $sectionType == 'ACT' ? 'selected' : ''; ?> value="ACT">Activated</option>
                                                <option <?php echo $sectionType == 'DEC' ? 'selected' : ''; ?> value="DEC">Deactivated</option>
                                                <option <?php echo $sectionType == 'ALL' ? 'selected' : ''; ?> value="ALL">ALL</option>
                                            </select>
                                            <!--                                            <label for="select1">Select Section type</label>-->
                                        </div>
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('section_list');
                                        if ($sectionType != 'ALL') {
                                            $xcrud->where('status', $statusvalue);
                                        }
                                        $xcrud->unset_title();

                                        $xcrud->columns("standard,section,status,order");

                                        $xcrud->order_by("order");
                                        $xcrud->fields("standard,section,status,order");
                                        $xcrud->relation('standard', 'master_class_list', 'standard', array("standard"), '', 'order_by ASC');
                                        $xcrud->label("standard", "Standard");
                                        $xcrud->label("section", "Section");
                                        $xcrud->label("status", "Status");
                                        $xcrud->label("order", "Display Sequence");
                                        $xcrud->set_lang('add', 'Add new Section');
                                        $ss = '';
                                        for ($i = 1; $i <= 50; $i++) {
                                            $ss = $ss . $i . ',';
                                        }
                                        $ss = substr($ss, 0, -1);
                                        $xcrud->change_type('order', 'select', 'General', $ss);
                                        $xcrud->change_type('standard', 'select');
                                        $xcrud->change_type('status', 'select', 'General', array("0" => "Deactivated", "1" => "Activated"));
                                        $xcrud->validation_pattern('standard', 'alpha_numeric');
                                        $xcrud->validation_pattern('section', 'alpha_numeric');
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->pass_var("deo_entry_by", $deo_staff_id);

                                        $xcrud->limit(50);
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
                            <div class="col-md-4">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> How to Manage Section?</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        To add or manage any new section in school,any option from the drop downlist must be selected.This drop downlist helps to differentiate the 'active' and 'inactive' sections.
                                        <br>--> All the sections which are not in use(for ex.Z,R,etc)comes under inactive. ( Rest part can be written as it is)



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
                window.location = "<?php echo base_url(); ?>index.php/staff/managesection/" + element.value;
            }
        }
    </script>

