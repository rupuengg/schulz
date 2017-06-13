<!DOCTYPE html>
<html lang="en">
    <title>Notice</title>
    <head>
           
        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <script>
        var data = <?php echo json_encode($myNotice); ?>;
    </script>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="notice" ng-controller="noticeController">
        <!-- BEGIN HEADER-->
        <?php
        $this->load->view('include_parent/header');
        ?>

        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body" ng-cloak>


                        <div class="row">
                            <div class="row">

                                <div class="col-lg-6 col-sm-12">
                                    <div class="no-padding">
                                        <div role="alert" class="alert alert-callout alert-warning margin-bottom-lg " ng-repeat="notice in noticeData">
                                            <div class="row">
                                                <div class="col-lg-1 no-padding">
                                                    <img src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{notice.data.staff_id}}" . "/THUMB"; ?>" class="img-circle img-responsive width-1">
                                                </div>
                                                <div class="col-lg-11">

                                                    <strong>{{notice.data.notice_type}}</strong><br/>
                                                    <a href="<?php echo base_url(); ?>index.php/parent/notice/{{notice.data.notice_id}}">  <p class="no-margin">{{notice.data.title}}</p></a>

                                                    <a class="text-xs"><i>{{notice.data.staff_name}}</i></a>

                                                    <i class="text-xs no-margin pull-right text-primary-dark">{{notice.timestamp}}</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--end .col -->
                                <?php if (!empty($myNotice)) { ?>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="card">
                                            <div class="card-body small-padding">
                                                <h4>Dear Students,</h4>
                                                <p>{{noticeDetail.content}}</p>
                                                <hr class="margin-bottom-lg">
                                                <h4 class="no-margin">{{noticeDetail.staff_name}}</h4>
                                                <i class="text-xs no-margin text-primary-dark">{{noticeDetail.timestamp}}</i>
                                            </div>
                                        </div>
                                    </div><!--end .col -->
                                <?php } ?>
                            </div>
                        </div>
                    </div><!--end .section-body -->
                </section>
            </div><!--end #content-->		
            <!-- END CONTENT -->
            <!-- BEGIN MENUBAR-->
            <div id="menubar" class="menubar-inverse">
                <div class="menubar-fixed-panel">
                    <div>
                        <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="expanded">
                        <a href="dashboard.html">
                            <span class="text-lg text-bold text-primary ">Mera School Portal</span>
                        </a>
                    </div>
                </div>
                <div class="menubar-scroll-panel">
                    <!-- BEGIN MAIN MENU -->
                    <?php
                    $this->load->view('include_parent/sidemenu.php');
                    ?>
                    <!-- END MAIN MENU -->
                    <div class="menubar-foot-panel">
                        <small class="no-linebreak hidden-folded">
                            <span class="opacity-75">Copyright &copy; <?php echo date('Y'); ?></span> <strong>Mera School Portal</strong>
                        </small>
                    </div>
                </div><!--end .menubar-scroll-panel-->
            </div><!--end #menubar-->
            <!-- END MENUBAR -->
        </div><!--end #base-->	
        <!-- END BASE -->
        <!-- BEGIN JAVASCRIPT -->
        <?php
        $this->load->view('include_parent/headjs');
        ?>
        <!-- END JAVASCRIPT -->
        <script>
                    var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>/assets/parentjs/notice.js"></script>
    </body>
</html>