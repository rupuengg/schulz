
<!DOCTYPE html>
<html lang="en">
    <title>Manage Combo</title>
    <?php
    $class = trim($class);
    $comboheader = '';
    if (isset($section_id)) {
        
    } else {
        $section_id = '';
    }
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');

    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed ">
        <?php $this->load->view('include/header'); ?>
    <head>
        <title>Manage Combo</title>
    </head>
    <div id="base">
        <div id="content">
            <section>
                <div class="section-body contain-lg">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card card-bordered style-primary">
                                <div class="card-head card-head-xs">
                                    <div class="tools">
                                    </div>
                                    <header><i class="fa fa-fw fa-tag"></i>Manage Combo</header>
                                </div><!--end .card-head -->
                                <div class="card-body style-default-bright">

                                    <div class="form-group" >
                                        <div class=" col-md-6">

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
                                        <div class=" col-md-6">
                                            <div class="card-actionbar">
                                                <div class="card-actionbar-row" >
                                                    <button id="assigncombo" class="btn btn-block btn-raised btn-primary" type="submit">Assign combo to section</button>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <?php
                                    $this->load->library('loadxcrud');
                                    echo Xcrud::load_css();

                                    $xcrud = Xcrud::get_instance();
                                    $xcrud->table('combo_details');

                                    $xcrud->where('class_name', $class);

                                    $xcrud->columns("combo_name,combo_desp,deo_entry_by");
                                    $xcrud->order_by("combo_name");
                                    $xcrud->fields("combo_name,combo_desp");
                                    $xcrud->label("combo_name", "Combo Name");
                                    $xcrud->label("deo_entry_by", "Action");
                                    $xcrud->label("combo_desp", "Description");
                                    $xcrud->unset_title();
                                    $xcrud->column_pattern('deo_entry_by', "<a href='" . base_url() . "/index.php/staff/managecombourl/" . $class . "/{id}' class='btn btn-warning '>Add Subjects</a>");
                                    $xcrud->pass_var("class_name", $class);
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
                        <?php
                        if ($pagetype == 'COMBOONLY') {
                            if ($combo_id == -1) {
                                echo '<h3>Please create and select any Subject Combo from left</h3>';
                            } elseif ($combo_id > 0) {
                                ?>
                                <div class=" col-md-5">
                                    <div class="card">
                                        <div class="card-head card-head-xs">
                                            <header><?php echo 'Combo Name-' . $combo_name; ?> </header>
                                        </div>
                                        <div class="card-body">
                                            <form class="form-horizontal" role="form">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <?php
                                                        $i = 0;
                                                        foreach ($classsubjects as $valsub) {
                                                            $i = $i + 1;
                                                            $type1 = '';
                                                            if (in_array($valsub['id'], $combosubjects) == TRUE) {
                                                                $type1 = 'checked';
                                                            }
                                                            ?>
                                                            <div class="checkbox checkbox-styled">
                                                                <label>
                                                                    <input class="cbkSubject" type="checkbox" <?php echo $type1; ?> value="<?php echo $valsub['id']; ?>" >
                                                                    <span><?php echo $i . '. ' . $valsub['subject_name']; ?></span>
                                                                </label>
                                                            </div>
                                                            <?php
                                                        }
                                                        if ($i == 0) {
                                                            ?>
                                                            No Subjects found in class <?php echo $class; ?>.
                                                            <br>
                                                            To assign subjects in combo. You must add the subjects to that class and proceed. Click below to open Subject Management Module.
                                                            <?php
                                                        }
                                                        ?>
                                                    </div><!--end .col -->
                                                </div><!--end .form-group -->
                                            </form>
                                        </div><!--end .card-body -->
                                        <div class="card-actionbar">
                                            <?php if ($i == 0) {
                                                ?>
                                                <div class="card-actionbar-row" >
                                                    <button onclick="window.location='<?php echo base_url()."/index.php/staff/managesubject/$class";?>'" id="cmdsave" class="btn btn-block btn-raised btn-primary" type="submit">Add Subjects to Class <?php echo $class ?></button>
                                                </div>
                                            <?php } else {
                                                ?>
                                                <div class="card-actionbar-row" >
                                                    <button id="cmdsave" class="btn btn-block btn-raised btn-primary" type="submit">Assign Selected Subjects to Combo - <?php echo $combo_name; ?></button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div><!--end .col -->
                                <?php
                            }
                        }
                        if ($pagetype == 'COMBOSECTION') {
                            ?>
                            <div class=" col-md-5">
                                <div class="card">
                                    <div class="card-head card-head-xs">
                                        <header><?php echo 'Assign Combo to Section (Class ' . $class . 'th)'; ?></header>
                                    </div>
                                    <div class="card-body">

                                        <div class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <select id="dd_section_class_type" onchange="changeURLclass(this)" name="select12" class="my-select" >
                                                        <option value="0">Select Section</option>
                                                        <?php
                                                        foreach ($section_list as $val) {
                                                            $sectionname = $val['standard'] . ' ' . $val['section'];
                                                            ?>
                                                            <option <?php echo ($section_id) == $val['id'] ? 'selected' : ''; ?> value="<?php echo $val['id']; ?>"><?php echo $sectionname; ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div><!--end .col -->
                                            </div><!--end .form-group -->
                                        </div>
                                        <form role="form" class="form-horizontal">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <?php
                                                    if ($section_id <> -1) {
                                                        $i = 0;
                                                        foreach ($comboinclass as $valcombo) {
                                                            $i = $i + 1;
                                                            $type1 = '';
                                                            if (in_array($valcombo['id'], $comboinsection) == TRUE) {
                                                                $type1 = 'checked';
                                                            }
                                                            ?>
                                                            <div class="checkbox checkbox-styled">
                                                                <label>
                                                                    <input class="cbkcomboclass" type="checkbox" <?php echo $type1; ?> value="<?php echo $valcombo['id']; ?>" >
                                                                    <span><?php echo $i . '. ' . $valcombo['combo_name'] . ' (' . $valcombo['combo_desp'] . ')'; ?></span>
                                                                </label>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div><!--end .col -->
                                            </div><!--end .form-group -->
                                        </form>

                                    </div><!--end .card-body -->
                                    <div class="card-actionbar">
                                        <?php if ($section_id <> -1) { ?>
                                            <div class="card-actionbar-row" >
                                                <button id="cmdsavecomboclass" class="btn btn-block btn-raised btn-primary" type="submit">Assign/Save selected combos</button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div><!--end .col -->
                            <?php
                        }
                        ?>
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
                <span class="text-lg text-bold text-primary "></span>
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
            window.location = "<?php echo base_url(); ?>index.php/staff/managecombourl/" + element.value;
        }
    }
    function changeURLclass(element) {
        if (element.value == '') {
        } else {
            window.location = "<?php echo base_url(); ?>index.php/staff/managecombosectionurl/<?php echo $class . '/'; ?>" + element.value;
                    }
                }
                jQuery(function ($) {
                    $('#assigncombo').click(function () {
                        window.location = "<?php echo base_url(); ?>index.php/staff/managecombosectionurl/<?php echo $class; ?>";
                                });

                                $('#cmdsave').click(function () {
                                    var selectedSubject = '{"combo_id":<?php echo $combo_id; ?>,"sub_id":[';
                                    $('.cbkSubject').each(function (element, index) {
                                        if ($(this).is(':checked')) {
                                            selectedSubject += $(this).val() + ',';
                                        }
                                    });
                                    selectedSubject = selectedSubject.substring(0, selectedSubject.length - 1) + ']}';
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/staff/combosave',
                                        type: 'POST',
                                        data: 'data=' + selectedSubject,
                                        success: function (msg) {
                                            alert("Data saved successfully");
                                        },
                                        error: function () {
                                            alert("Serious problem is save");
                                        }
                                    });
                                });

                                $('#cmdsavecomboclass').click(function () {

                                    var selectedCombo = '{"section_id":<?php echo $section_id; ?>,"combo_id":[';
                                    $('.cbkcomboclass').each(function (element, index) {
                                        if ($(this).is(':checked')) {
                                            selectedCombo += $(this).val() + ',';
                                        }
                                    });
                                    selectedCombo = selectedCombo.substring(0, selectedCombo.length - 1) + ']}';
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/staff/combosectionsave',
                                        type: 'POST',
                                        data: 'data=' + selectedCombo,
                                        success: function (msg) {
                                            alert("Data saved successfully");
                                        },
                                        error: function () {
                                            alert("Serious problem is save1");
                                        }
                                    });
                                });
                            });
</script>
