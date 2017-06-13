<!DOCTYPE html>
<html lang="en">
    <title>Library</title>
    <head>
        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin">
        <!-- BEGIN HEADER-->
        <?php
        $this->load->view('include_parent/header');
        ?>
        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body">
                        <div class="row">
                            <div class="row">
                                <!--                                <div class="text-center text-warning" style="margin-top: 16%;" ng-show="homeworkData == -1">
                                                                    <i class="fa fa-wrench fa-15x"></i><br/>
                                                                    <p class="text-xxl text-ultra-bold">No Data Found Yet...</p> 
                                                                </div>-->
                                <div class="col-lg-6 col-sm-12">
                                    <div class="no-padding">
                                        <div class="card">
                                            <div class="card-body no-padding">
                                                <ul class="list divider-full-bleed">
                                                    <li class="tile style-danger margin-bottom-lg">
                                                        <a class="tile-content ink-reaction" href="#2">

                                                            <div class="tile-text">Computer Science</div>
                                                        </a>

                                                    </li>
                                                    <li class="tile style-danger margin-bottom-lg">
                                                        <a class="tile-content ink-reaction"  href="#2">

                                                            <div class="tile-text">History</div>
                                                        </a>

                                                    </li>
                                                    <li class="tile style-success margin-bottom-lg">
                                                        <a class="tile-content ink-reaction"  href="#2">

                                                            <div class="tile-text">Mathematics</div>
                                                        </a>

                                                    </li>
                                                    <li class="tile style-success margin-bottom-lg">
                                                        <a class="tile-content ink-reaction"  href="#2">
                                                            <div class="tile-text">G.K</div>
                                                        </a>

                                                    </li>
                                                </ul>
                                            </div><!--end .card-body -->
                                        </div> 
                                    </div>
                                </div><!--end .col -->
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-body small-padding style-primary-bright">
                                            <h4 class="text-center">Book Detail</h4>
                                            <dl class="dl-horizontal  text-center ">
                                                <dt>Book Number :</dt>
                                                <dd>12125</dd>
                                                <dt>Book Title:</dt>
                                                <dd>Computer Networks</dd>
                                                <dt>Date Of Issue:</dt>
                                                <dd>12-09-2015</dd>
                                                <dt>Date Of Return:</dt>
                                                <dd>27-09-2015</dd>
                                                <dt>Fine Amount:</dt>
                                                <dd>0.0 Rs.</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div><!--end .col -->
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
    </body>
</html>