
<!DOCTYPE html>
<html lang="en">
    <title>Manage Subjects</title>
    <?php
    //echo $class;
    $sectionType = '';
    $statusvalue = '';
    $class = trim($class);
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
                                        <header><i class="fa fa-fw fa-tag"></i>Manage Subjects</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-group">
                                            <select id="dd_section_type" onchange="changeURL(this)" name="select1" class="my-select">
                                                <option value="0">Select Class</option>
                                                <?php
                                                foreach ($myclassarr as $val) {
                                                    ?>
                                                    <option <?php echo ($class) == $val['standard'] ? 'selected' : ''; ?> value="<?php echo $val['standard']; ?>"><?php echo $val['standard']; ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('subject_list');
                                        $xcrud->where('class_name', $class);
                                        $xcrud->columns("id,subject_name,subject_short_name,subject_type,order_by");
                                        $xcrud->order_by("order_by");
                                        $xcrud->fields("subject_name,subject_short_name,subject_type,order_by");


                                        $xcrud->label("subject_short_name", "Subject short name");
                                        $xcrud->label("subject_name", "Subject");
                                        $xcrud->label("subject_type", "Subject type");
                                        $xcrud->label("order_by", "Subject display sequence");
                                        $ss = '';
                                        for ($i = 1; $i <= 15; $i++) {
                                            $ss = $ss . $i . ',';
                                        }
                                        $ss = substr($ss, 0, -1);
                                        $xcrud->change_type('order_by', 'select', 'General', $ss);
                                        $xcrud->change_type('subject_type', 'select', 'General', array("REGULAR", "ADDITIONAL"));
                                        $xcrud->validation_pattern('subject_name', 'alpha');
                                        $xcrud->validation_pattern('subject_short_name', 'alpha');
                                        $xcrud->pass_var("class_name", $class);
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->pass_var("deo_entry_by", $deo_staff_id);
                                        $xcrud->after_remove('removesubjectothergroups');
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
                                </div><!--end .card -->
                            </div><!--end .col -->
                            <div class="col-md-4">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> How to manage Subjects?</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        Select a class. All the subjects of that class gets loaded. 

                                        Click on ADD button to enter a new subject.<br>

                                        <b>  Note: You can not delete any of the subject if any activity has been done it.</b>

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
                window.location = "<?php echo base_url(); ?>index.php/staff/managesubject/" + element.value;
            }
        }
    </script>
