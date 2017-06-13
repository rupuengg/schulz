<!DOCTYPE html>
<html lang="en">
    <title>
        ID CARD
    </title>
    <style>
        #header-image{
            background: #7B0002;
            padding-top: 0px;

        }
        #content-image{
            padding-bottom: 0px;
            background: #eeeeee;
            height: 367px;
            overflow: hidden;
        }
        #footer-image{
            background: #7B0002;
            height:40px;
            margin-bottom: 20px;

        }
        #powerd{
            text-align: center;
            color: wheat;
            padding-top: 10px;

        }
        .schoolname{
            font-family: 'Slabo 18px', serif;
            font-size: 100%;

        }
    </style>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed ">
        <?php $this->load->view('include/header'); ?>
        <div id="base" >
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="card-body style-default-bright">

                            <div class="row" >

                                <div class="card">
                                    <div class="card card-bordered style-primary" >                                                                             
                                        <div class="card-head card-head-sm">
                                            <header><i class="fa fa-fw fa-tag"></i>Student's Id Card</header>
                                        </div><!--end .card-head -->
                                    </div>
                                    <div class="card-body style-default-bright">
                                        <div class="col-xs-12">
                                            <div class="col-sm-12">
                                                <div class="form-group col-sm-4">
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
                                                    <?php if ($section_id > 0) { ?>
                                                        <p <span>Total<b> <?php echo count($idcardinfo); ?> </b>ID cards generated</span></p>
                                                    <?php } ?> 
                                                </div>
                                            </div>
                                            <div>

                                                <?php
                                                if (!empty($idcardinfo)) {
                                                    foreach ($idcardinfo as $key => $value) {
                                                        echo $value['idcard'];
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
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
            </div>
            <div class="menubar-scroll-panel">
                <?php $this->load->view('include/menu'); ?>
            </div>
        </div>
        <?php
        $this->load->view('include/headjs');
        ?>      
        <script>
            function changeURL(element) {

                if (element.value == '') {
                } else {
                    window.location = "<?php echo base_url(); ?>index.php/staff/idcard/" + element.value;
                }
            }

        </script>

