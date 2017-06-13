
<!DOCTYPE html>
<html lang="en">
    <title>Late Fine Details</title>
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
                                        <header><i class="fa fa-fw fa-tag"></i>Late Fine Details</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('fee_late_fine_setting');
                                        $xcrud->columns("fee_due_day,fine_amount");
                                        $xcrud->fields("fee_due_day,fine_amount");
                                        $xcrud->unset_title(TRUE);
                                        $xcrud->label("fee_due_day", "Fee Perday");
                                        $xcrud->label("fine_amount", "Fine Dayamount");
//                                        $xcrud->label("coming_time", "Coming Time");
//                                        $xcrud->label("reason", "Reason");
//                                       
                                        $xcrud->pass_var("entry_by", $this->session->userdata('staff_id'));
                                        $xcrud->pass_var("deo_entry_by", $this->session->userdata('deo_staff_id'));
                                        $xcrud->limit(20);
                                        $xcrud->unset_edit(FALSE);
                                        $xcrud->unset_remove(TRUE);
                                        $xcrud->unset_add(TRUE);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(TRUE);
                                        //$xcrud->unset_remove(TRUE);
                                        echo $xcrud->render();
                                        ?>

                                        </select>
                                    </div>

                                </div><!--end .card-body -->
                            </div><!--end .card -->
                        </div><!--end .col -->
                        <div class="col-md-4">
                            <div class="card card-bordered style-primary">
                                <div class="card-head card-head-xs">
                                    <div class="tools">

                                    </div>
                                    <header><i class="fa fa-fw fa-tag"></i> How to Manage Late Fine Details?</header>
                                </div><!--end .card-head -->
                                <div class="card-body style-default-bright">
                                    Given list is complete details of the Late Fine.Click on edit button ,Select any category from drop down and click on add button,fill all the details and return' to proceed.<br>

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