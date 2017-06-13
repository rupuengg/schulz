
<!DOCTYPE html>
<html lang="en">
    <title>Menu List</title>
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
                                    <div class="card-head">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Menu List</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-group">
                                            <select id="dd_section_type" onchange="changeURL(this)" name="select1" class="my-select">
                                                <option value="0">Select Menu caption</option>
                                                <?php
                                                foreach ($menuList as $val) {
                                                    ?>
                                                    <option <?php echo ($menuId) == $val['menuid'] ? 'selected' : ''; ?> value="<?php echo $val['menuid']; ?>"><?php echo $val['menucaption']; ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('staff_menu_child_list');
                                        $xcrud->columns("childcaption,description,page_url");
                                        $xcrud->fields("childcaption,page_url");
                                        $xcrud->unset_title();
                                        $xcrud->label("childcaption", "Childcaption ");
                                        $xcrud->label("description", "Description ");
                                        $xcrud->label("page_url", "Page URL");
                                        $xcrud->where("main_menu_id", $menuId);
                                        $xcrud->change_type('menucaption', 'select', 'General');
                                        $xcrud->pass_var("main_menu_id", $menuId);
                                        $xcrud->pass_var("entry_by", $staff_id);                                       
                                        $xcrud->limit(50);
                                        $xcrud->unset_edit(FALSE);
                                        $xcrud->unset_add(FALSE);
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
<!--                                <div class="card card-bordered style-primary">
                                    <div class="card-head">
                                        <div class="tools">

                                        </div>
          <!--                              <header><i class="fa fa-fw fa-tag"></i> How to assign Subject Teacher?</header>

                                    </div><!--end .card-head -->
 <!--                                 <div class="card-body style-default-bright">

                                        Please select a menu caption from the drop down list.You can see all the childcaption,description and page url of the selected menucaption. 
                                        If you want to add any childcaption for any particular menucaption then click on ADD button and if you want to edit any predefined childcaption and page url,then click on edit button.


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
                window.location = "<?php echo base_url(); ?>index.php/staff/menulist/" + element.value;
            }
        }


    </script>