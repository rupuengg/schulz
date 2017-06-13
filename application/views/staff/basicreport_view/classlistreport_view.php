

<!DOCTYPE html>
<html lang="en">
    <title>Class List Report</title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <?php
    $this->load->library('loadxcrud');
    echo Xcrud::load_css();
    ?>
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
                                        <header><i class="fa fa-fw fa-tag"></i>Class List Report</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">


                                        <div class="form-group">
                                            <select id="dd_section_type" onchange="changeURL(this)" name="select1" class="my-select">

                                                <option value="0">Select Class</option>
                                                <?php
                                                foreach ($sectionList as $val) {
                                                    ?>
                                                    <option <?php echo ($class) == $val['id'] ? 'selected' : ''; ?> value="<?php echo $val['id']; ?>"><?php echo $val['standard'] . ' ' . $val['section']; ?></option> ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <?php
                                        ?>
                                        <?php
                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('biodata');
                                        $xcrud->columns("adm_no,firstname,lastname,dob_date,roll_no,house");
                                        $xcrud->where("section_id", $class);
                                        $xcrud->unset_title();
                                        $xcrud->label("adm_no", "Admission No.");
                                        $xcrud->label("firstname", "First Name");
                                        $xcrud->label("lastname", "Last Name");
                                        $xcrud->label("dob_date", "Date of Birth");
                                        $xcrud->label("roll_no", "Roll No.");
                                        $xcrud->label("house", "House");
                                        $xcrud->relation("section_id", "section_list", "id", array("standard", "section"), "", "'order'");
                                        $xcrud->change_type('section_id', 'select', 'General');
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->pass_var("deo_entry_by", $deo_staff_id);
                                        $xcrud->limit(50);
                                        $xcrud->unset_edit(TRUE);
                                        $xcrud->unset_add(TRUE);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_print(FALSE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(TRUE);
                                        $xcrud->unset_remove(TRUE);
                                        echo $xcrud->render();
                                        ?>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                            <!--                           <div class="col-md-4">
                                                           <div class="card card-bordered style-primary">
                                                               <div class="card-head">
                                                                   <div class="tools">
                           
                                                                   </div>
                            <!--                                       <header><i class="fa fa-fw fa-tag"></i> How to assign Subject Teacher?</header>
                           
                                                               </div><!--end .card-head -->
                            <!--                                   <div class="card-body style-default-bright">
                           
                                                                   Please select a class and any particular date from the drop down list.You can see a report containing the admission no.,attendance date,attendance status and the reason of being absent. 
                                                                   If you are unable to see the 'section' of any particular student,then click on edit button and assign a 'section'.
                           
                           
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
            window.location = "<?php echo base_url(); ?>index.php/staff/classlistreport/" + element.value;
        }
    }


</script>