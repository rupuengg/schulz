<!DOCTYPE html>
<html lang="en">
    <title>head setting</title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="head_app" ng-controller="head_controller">
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
                                        <header><i class="fa fa-fw fa-tag"></i>Head Setting</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-group">Select Category
                                            <select id="dd_section_type" name="select1" class="my-select" ng-model="categoryval" ng-init="categoryval = 'NA'" ng-change="postback()" >
                                                <option value="NA">----Please Select----</option>
                                                <option ng-repeat="x in category" value="{{x.id}}" ng-selected="<?php echo $catid; ?> === {{x.id}}">{{x.category_name}} </option>
                                            </select>
                                        </div>
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('fee_head_setting');
                                        $xcrud->columns("head_name,head_short_name,refund_type,mandatory_type");
                                        $xcrud->fields("head_name,head_short_name,refund_type,mandatory_type");
                                        $xcrud->unset_title(TRUE);
                                        $xcrud->label("head_name", "Name");
                                        $xcrud->label("head_short_name", "Short Name");
                                        $xcrud->where("main_head_id", $catid);
                                        $xcrud->change_type('refund_type', 'select', 'General',array("YES"=>"YES","NO"=>"NO"));
                                        $xcrud->change_type('mandatory_type', 'select', 'General',array("YES"=>"YES","NO"=>"NO"));
                                        $xcrud->validation_required("head_name",TRUE);
                                        $xcrud->pass_var("main_head_id", $catid);
                                        $xcrud->pass_var("entry_by",$this->session->userdata('staff_id'));
                                        $xcrud->pass_var("deo_entry_by",$this->session->userdata('deo_staff_id'));
                                        $xcrud->limit(50);
                                        $xcrud->unset_edit(FALSE);
                                        $xcrud->unset_add(FALSE);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(TRUE);
//                                        $xcrud->unset_remove(TRUE);
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
                                        <header><i class="fa fa-fw fa-tag"></i> How to Manage Head Setting?</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        Given list is the complete categories of the schoolfees.Select any category from drop down and click on add button,fill all the details and return' to proceed.<br>

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

    <script src="<?php echo base_url(); ?>assets/myjs/feesmgmt/fees.js?v=<?php echo rand(); ?>"></script>
    <script>
                                                    var baseURL = '<?php echo base_url(); ?>';
    </script>
</body>
</html>