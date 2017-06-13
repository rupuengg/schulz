
<!DOCTYPE html>
<html lang="en">
    <title>
     Manage House
    </title>
    <?php
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
                                    <div class="card-head">
                                        <div class="tools">
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="md md-colorize"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Manage House</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-group">

                                        </div>
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('house_list');


                                        $xcrud->columns("house_name,house_desc,incharge_staff_id");
                                        $xcrud->order_by("id");

                                        $xcrud->fields("house_name,house_desc,house_icon_path,incharge_staff_id");
                                        $xcrud->relation("incharge_staff_id", "staff_details", "id", array("staff_fname", "staff_lname"));
                                        $xcrud->label("house_name", "House Name");
                                        $xcrud->label("house_desc", "House Description");
                                        $xcrud->label("incharge_staff_id", "Incharge Name");
                                        $xcrud->validation_required('house_name');
                                        $xcrud->validation_required('incharge_staff_id');
                                        $xcrud->limit(25);
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
                                        <header><i class="fa fa-fw fa-tag"></i> How to manage House?</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        Add any House, All the Houses gets loaded. 

                                        Click on Add button to enter any new house in the database.

                                        -> You can edit or delete any of the house if any activity has been done in it.

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
       
        var myURL = "<?php echo base_url(); ?>";
       
    </script>
   