<!DOCTYPE html>
<html lang="en">
    <title>Cards</title>
    <head>

        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="card" ng-controller="cardController">
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

                                <div class="col-lg-6">



                                    <div class="no-padding" ng-show="cardData!=0">
                                        <div class="alert alert-callout alert-margin-bottom-lg" role="alert" ng-repeat="cardDetails in cardData | orderBy:'-timestamp'">
                                                <div class="row">
                                                    <div class="col-lg-1 no-padding">
                                                        <img src="<?php echo base_url()."/index.php/staff/getphoto/"."{{cardDetails.data.staff_id}}"."/THUMB"; ?>" class="img-circle img-responsive width-1">
                                                    </div>
                                                    <div class="col-lg-11">
                                                        Got
                                                        <strong>{{cardDetails.data.card_type}} Card</strong>
                                                        on <strong>{{cardDetails.data.issue_date| date:'MMM d, y'}}</strong>
                                                        <br/>
                                                        <p class="no-margin">{{cardDetails.data.remark}}</p>
                                                        <a class="text-xs"><i>-{{cardDetails.data.staff_name}}</i></a>
                                                        <i class="text-xs no-margin pull-right text-primary-dark">{{cardDetails.timestamp}}</i>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                </div><!--end .col -->
                                <div class="col-lg-6">

                                    <div class="card">
                                        <div class="card-head card-head-xs style-gray-dark">
                                            <header><?php echo $this->session->userdata('current_name'); ?>'s Card</header>
                                        </div>
                                        <div class="card-body small-padding">
                                            <div class="col-md-3" ng-repeat="cardCount in cardCountData.cardcount">
                                                <div class="card card-issued-{{cardCount.card_name}} no-margin u7">
                                                    <!--end .card-head -->
                                                    <div class="card-body no-padding">
                                                        <p class="text-xxxl text-center text-ultra-bold no-margin">{{cardCount.count}}</p>      
                                                    </div><!--end .card-body -->
                                                </div><!--end .card -->
                                            </div>
                                        </div>
                                    </div>




                                    <div class="card">
                                        <div class="card-head style-gray-dark card-head-xs">
                                            <header>Card issued by Teachers</header>
                                        </div>
                                        <div class="card-body no-padding">
                                            <ul class="list divider-full-bleed">
                                                <li class="tile" ng-repeat="staffCount in cardCountData.staffcount">
                                                        <a href="#2" class="tile-content ink-reaction">
                                                            <div class="tile-text">{{staffCount.staff_name}} ({{staffCount.count}} Card)</div>
                                                        </a>                                                       
                                                    </li>
                                            </ul>
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
                    <?php
                    $this->load->view('include_parent/sidemenu.php');
                    ?>
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
        <script> var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>/assets/parentjs/card.js"></script>
    </body>
</html>