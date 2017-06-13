
<!DOCTYPE html>
<html lang="en">
    <title>School Setting</title>
    <?php $this->load->view('include/headcss'); ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style>
        label.myLabel input[type="file"] {
            position: fixed;
            top: -1000px;
        }
        body {
            font-size: 12px;
            font-family: Helvetica, Arial;
            background: white;
            margin: 0;
            padding: 0;

        }
        hr {
            border: none;
            height: 1px;
            width: 80%;
            background: rgba(0,0,0,.3);
            margin: 40px auto;
        }
        .result-datauri {
            width: 300px;
            height: 100px;
            font-size: 11px;
            line-height: 15px;
            padding: 5px;
            border: 1px solid black;
            clear: both;
            display: block;
            margin: 20px auto;
        }
    </style>

    <body class="menubar-hoverable header-fixed " ng-app="schoolsetting" ng-controller="schoolsettingController">
        <!-- BEGIN HEADER-->
        <?php $this->load->view('include/header'); ?>

        <!-- END HEADER-->
        <!-- BEGIN BASE-->
        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <!-- BEGIN FORM WIZARD -->
                        <div class="row">
                            <!-- BEGIN LAYOUT RIGHT ALIGNED -->

                            <div class="col-md-12" >
                                <div class="card card-underline" >
                                    <div  class="modal fade" id="simpleModal" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="simpleModalLabel">Upload image</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div>
                                                        <p ng-hide="imageCropResult || imageCropStep != 1">Let's get started &rarr; <a ng-click="showImageCropper = true;
                                                                    imageCropStep = 1">Crop Image</a></p>
                                                        <p ng-show="imageCropResult">Wanna start over? &rarr; <a ng-click="imageCropResult = null;
                                                                    imageCropStep = 1">Reset</a></p>
                                                        <image-crop
                                                            data-width="300"
                                                            data-height="300"
                                                            data-shape="square"
                                                            data-step="imageCropStep"
                                                            data-result="imageCropResult"
                                                            ng-show="showImageCropper"
                                                            ></image-crop>
                                                        <hr>
                                                        <p ng-hide="imageCropResult">Not cropped yet</p>

                                                    </div>
                                                </div>

                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    <div class="card-head" >
                                        <header>School Settings</header>
                                    </div>
                                    <div class="card-body tab-content">
                                        <div class="tab-pane active" id="first2">
                                            <div class="row">
                                                <div class="col-sm-3 text-center">
                                                    <img  src="{{schooldata.school_logo_path}}" style="width: 200px; height: 200px; margin:10px;">

                                                    <button class="btn btn-danger" data-toggle="modal" data-target="#simpleModal">Upload</button>

                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="form floating-label">
                                                            <div class="row" >
                                                                <div class="col-sm-2">
                                                                    <div class="form-group">
                                                                        <input type="hidden" ng-model="schooldata.id">
                                                                        <input  class="form-control input-sm" ng-model="schooldata.school_affiliation_no">
                                                                        <label for="City" class="control-label">School_Affiliation No </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control input-sm" ng-model="schooldata.school_name">
                                                                        <label for="State" class="control-label">School_Name</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <div class="form-group">
                                                                        <input  type="text" class="form-control input-sm" ng-model="schooldata.school_board_name">
                                                                        <label for="State" class="control-label">School_Board_Name</label>
                                                                    </div>
                                                                </div>


                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control input-sm" ng-model="schooldata.school_address">
                                                                        <label for="State" class="control-label">School_Address</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <input type="text"  class="form-control input-sm" ng-model="schooldata.school_phone">
                                                                        <label for="State" class="control-label">School_Phone  </label>
                                                                    </div>
                                                                </div>
                                                            </div>                                              
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="pull-right">
                                                            <button class="btn ink-reaction btn-danger" type="button" ng-click="Cancel(schooldata)">Cancel</button>
                                                            <button id="cmdSave" class="btn ink-reaction btn-primary" type="button" ng-click="SaveDetail(schooldata)">Save Changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end .card -->

                                    </div><!--end .col -->
                                    <!-- END LAYOUT RIGHT ALIGNED -->
                                </div><!--end .row -->
                                <!-- END FORM WIZARD -->
                            </div><!--end .section-body -->
                            </section>
                        </div><!--end #content-->		
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
                                <!-- BEGIN MAIN MENU -->
                                <?php $this->load->view('include/menu'); ?>
                                <!--end .main-menu -->
                                <!-- END MAIN MENU -->
                            </div><!--end .menubar-scroll-panel-->
                        </div><!--end #menubar-->
                        <!-- END BASE -->
                        <!-- BEGIN JAVASCRIPT -->
                    </div>
                    <?php
                    $this->load->view('include/headjs');
                    ?>
                    <script>
                                var school = "<?php echo $this->session->userdata('school_code'); ?>";
                                var myURL = "<?php echo base_url(); ?>";</script>
                    <script src="<?php echo base_url(); ?>/assets/myjs/schoolsetting.js?v=<?php echo base_url(); ?>"></script>

                    </body>
                    </html>
