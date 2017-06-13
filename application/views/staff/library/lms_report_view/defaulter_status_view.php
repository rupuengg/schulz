
<!DOCTYPE html>
<html lang="en">
    <title>Defaulter student's list</title>
    <?php
    //echo $class;

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
                                        <header><i class="fa fa-fw fa-tag"></i>Defaulter Student's List</header>
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
                                        $today_date = date('Y-m-d');
                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('biodata');
                                        $xcrud->columns("name,lms_book_details.book_name,lms_book_issue_detail.issue_date,lms_book_issue_detail.due_date,lms_book_issue_detail.fine_ammount");
                                        $xcrud->join('adm_no', 'lms_book_issue_detail', 'adm_no');
                                        $xcrud->join('lms_book_issue_detail.book_id', 'lms_book_details', 'id');
                                        $xcrud->subselect('name', "select concat(firstname, ' ',lastname) as name from biodata as a where a.adm_no={adm_no}");
                                        if ($section_id != NULL) {
                                            $xcrud->where('section_id =', $section_id);
                                        }
                                        $xcrud->where('lms_book_issue_detail.status =', 'LOST');
                                        $xcrud->where('lms_book_issue_detail.due_date <', $today_date);
                                        $xcrud->label("name", "Name");
                                        $xcrud->label("book_id", "Book Name");
                                        $xcrud->label("issue_date", "Issue Date");
                                        $xcrud->label("due_date", "Due Date");
                                        $xcrud->label("lms_book_issue_detail.fine_ammount", "Fine");
                                        //$xcrud->pass_var("issued", $status);

                                        $xcrud->after_remove('removesubjectothergroups');
                                        $xcrud->limit(25);
                                        $xcrud->unset_title(TRUE);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_print(FALSE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(FALSE);
                                        $xcrud->unset_remove(TRUE);
                                        $xcrud->unset_add(TRUE);
                                        $xcrud->unset_edit(TRUE);
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
                                        <header><i class="fa fa-fw fa-tag"></i> How to manage defaulter list?</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">List of students who have not paid the late fine or fine due to any other reasons yet, is generated in this defaulter's student report.

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
                window.location = "<?php echo base_url(); ?>index.php/staff/defaulterreport/" + element.value;
            }
        }

    </script>
