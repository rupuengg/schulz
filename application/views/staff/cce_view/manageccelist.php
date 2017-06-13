
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CCE List Master</title>
    </head>
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
                                    <div class="card-head">
                                        <div class="tools">
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="md md-colorize"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>MANAGE CCE CO-SCHOLASTIC ELEMENTS</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-group">
                                            <select id="dd_section_type" onchange="changeURL(this)" name="select1" class="my-select">
                                                <option value="">Select Class</option>
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
                                        $xcrud->table('cce_list');

                                        $xcrud->where('class', $class);

                                        $xcrud->columns("cce_name,caption_show,order_by,cce_group_by");
                                        $xcrud->order_by("order_by");
                                        $xcrud->fields("cce_name,caption_show,order_by,cce_group_by");
                                        
                                        $xcrud->validation_required('cce_name', 2);
                                        $xcrud->validation_required('caption_show', 2);
                                        $xcrud->validation_required('cce_group_by');
                                        $xcrud->validation_required('order_by');
                                        
                                      //  $xcrud->validation_pattern('email', 'email')->validation_pattern('extension', 'alpha_numeric')->validation_pattern('officeCode', 'natural');

                                        $xcrud->unset_title();
                                        $xcrud->label("cce_name", "Name");
                                        $xcrud->label("caption_show", "Short name");
                                        $xcrud->label("cce_group_by", "Group(1A,2A,3A etc)");
                                        $xcrud->label("order_by", "Element display sequence");
                                        $ss = '';
                                        for ($i = 1; $i <= 25; $i++) {
                                            $ss = $ss . $i . ',';
                                        }
                                        $ss = substr($ss, 0, -1);
                                        $xcrud->change_type('order_by', 'select', 'General', $ss);
                                        $xcrud->pass_var('class', $class);
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
                                    <div class="card-head">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> CCE Elements</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        Select any class, All the CCE Elements of that standard/class gets loaded. 
                                        <br>    <br>
                                        -> Click on Add button to enter any new element of that class in the database.
                                        <br>
                                        <b>Note-> You can not delete any of the cce element if any activity has been done in it. Activities like grade and DI entry of any student.</b>

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
                    <span class="text-lg text-bold text-primary ">MERA SCHOOL PORTAL</span>
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
                window.location = "<?php echo base_url(); ?>index.php/staff/ccelist/" + element.value;
            }
        }
    </script>
