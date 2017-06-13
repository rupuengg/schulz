
<!DOCTYPE html>
<html lang="en">
    <title>CCE Teacher Assignment</title>
    <?php
    $section_id = trim($section_id);
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
                                      
                                        <header><i class="fa fa-fw fa-tag"></i>ASSIGN CCE CO-SCHOLASTIC ELEMENTS TO TEACHERS</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-group">
                                            <select id="dd_section_type" onchange="changeURL(this)" name="select1" class="my-select">
                                                <option value="">Select Section</option>
                                                <?php
                                                foreach ($section_list as $val) {
                                                    ?>
                                                    <option <?php echo ($section_id) == $val['id'] ? 'selected' : ''; ?> value="<?php echo $val['id']; ?>"><?php echo $val['standard'] . ' ' . $val['section']; ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('cce_staff_relation');
                                        $xcrud->columns("cce_id,staff_id");
                                        $xcrud->order_by("cce_id");
                                        $xcrud->fields("cce_id,staff_id");
                                        $xcrud->unset_title();
                                        $xcrud->relation("cce_id", "cce_list", "id", array("cce_name"));
                                        $xcrud->relation("staff_id", "staff_details", "id", array("staff_fname", "staff_lname"));

                                        $xcrud->label("cce_id", "CCE Element");
                                        $xcrud->label("staff_id", "Teacher Name");
                                        $xcrud->where("section_id", $section_id);

                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->pass_var("deo_entry_by", $deo_staff_id);

                                        $xcrud->limit(50);
                                        $xcrud->unset_add(TRUE);
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
                                <div style="display: none"class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> One Click assignment.</header>

                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">

                                        Class Teacher of 7A is SUNIL KUMAR. You can also assign to all these CCE Elements to Sunil Kumar in one click.
                                        <br>

                                        <br>
                                        <button type="button" class="btn ink-reaction btn-raised btn-primary text-center" >ASSIGN ALL ELEMENTS TO SUNIL KUMAR</button>


                                    </div>                                    </div><!--end .card-body -->
                            </div><!--end .card -->
                            <div class="col-md-4">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> How to assign CCE Teacher?</header>

                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">

                                        Please select any section from the dropdown list.You can see all the CCE Elements of the selected section. If no CCE Elements are displayed, then please use the 'CCE Master list management module'. 
                                        <br>
                                        Now Click on the edit button and select any teacher to assign CCE elements.
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
                window.location = "<?php echo base_url(); ?>index.php/staff/assigncceelement/" + element.value;
            }
        }
    </script>
