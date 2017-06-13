<!DOCTYPE html>
<html lang="en">
    <title>Summary</title>
    <head>
        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="summary" ng-controller="summaryController">
        <!-- BEGIN HEADER-->
        <?php
        $this->load->view('include_parent/header');
        //    print_r( $this->session->userdata('adm_no_list'));
        //     echo $this->session->userdata('logintype');
        ?>

        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body" ng-cloak>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div  ng-repeat="summary in summaryData| orderBy:'-timestamp'">
                                    <div class="alert alert-callout margin-bottom-lg " role="alert" ng-show="'{{summary.type}}'== 'CARD'">
                                        <div class="row">
                                            <div class="col-lg-1 no-padding">
                                                <img src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{summary.data.staff_id}}" . "/THUMB"; ?>" class="img-circle img-responsive width-1">
                                            </div>
                                            <div class="col-lg-11">
                                                Got
                                                <strong>{{summary.data.card_type}} </strong>Card
                                                on <strong> {{summary.data.issue_date| date:'MMM d, y'}}</strong>
                                                <br/>
                                                <p class="no-margin">{{summary.data.remark}}</p>
                                                <a class="text-xs"><i>{{summary.data.staff_name}}</i></a>
                                                <i class="text-xs no-margin pull-right text-primary-dark">{{summary.timestamp}}</i>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="alert" class="alert alert-callout alert-warning margin-bottom-lg" ng-show="'{{summary.type}}'== 'ATTENDANCE'">
                                        <div class="row">
                                            <div class="col-lg-1 no-padding">
                                                <img class="img-circle img-responsive width-1" src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{summary.data.staff_id}}" . "/THUMB"; ?>"/>
                                            </div>
                                            <div class="col-lg-11">
                                                Absent on
                                                <strong>{{summary.data.att_date| date:'MMM d, y'}}</strong><br/>
                                                <p class="no-margin">{{summary.data.reason}}</p>

                                                <a class="text-xs"><i>{{summary.data.staff_name}}</i></a>

                                                <i class="text-xs no-margin pull-right text-primary-dark">{{summary.timestamp}}</i>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="alert" class="alert alert-callout alert-info margin-bottom-lg" ng-show="'{{summary.type}}'== 'MARKS'">
                                        <div class="row">
                                            <div class="col-lg-1 no-padding">
                                                <img class="img-circle img-responsive width-1" src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{summary.data.staff_id}}" . "/THUMB"; ?>">
                                            </div>
                                            <div class="col-lg-11">
                                                <strong>{{summary.data.subject}}</strong><br>
                                                Obtained <strong>{{summary.data.marks}}</strong> out of <strong>{{summary.data.max_marks}}</strong> in <strong>{{summary.data.exam_name}}</strong><br>
                                                <a class="text-xs"><i>{{summary.data.staff_name}}</i></a>
                                                <i class="text-xs no-margin pull-right text-primary-dark">{{summary.timestamp}}</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end .col -->
                            <div class="col-lg-6 col-sm-12">
                                <div class="card" ng-show="cardData.cardcount.length >0">
                                    <div class="card-head card-head-xs style-gray-dark">
                                        <header><?php echo $this->session->userdata('current_name'); ?>'s Card</header>
                                    </div>
                                    <div class="card-body small-padding">
                                        <div class="col-md-3" ng-repeat="stuCard in cardData.cardcount">
                                            <div class="card card-issued-{{stuCard.card_name}} no-margin card-issued-{{stuCard.card_name}}" title="{{ stuCard.card_name | uppercase}} Card">
                                                <!--end .card-head -->
                                                <div class="card-body no-padding">
                                                    <p class="text-xxxl text-center text-ultra-bold no-margin">{{stuCard.count}}</p>      
                                                </div><!--end .card-body -->
                                            </div><!--end .card -->
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-head style-gray-dark card-head-xs">
                                        <!--<header ng-if="">No Data for Subjects</header>-->
                                        <header><?php echo $this->session->userdata('current_name'); ?>'s Subjects</header>
                                    </div>
                                    <div class="tile-text no-padding" ng-show="marksData == []">
                                        <!--<strong></strong>-->
                                        <p class="text-warning text-xs no-margin"><strong>No Subject Entered Yet!! -</strong></p>
                                    </div>
                                    <div class="card-body no-padding" ng-show="marksData != []">
                                        <ul class="list divider-full-bleed">
                                            <li class="tile" ng-repeat="subject in marksData.subject" >
                                                <a href="<?php echo base_url();?>index.php/parent/subjectdetails/{{subject.sub_id}}"  class="tile-content ink-reaction">
                                                    <div class="tile-text no-padding">
                                                        <strong>{{subject.subject_name}}</strong>
                                                        <p class="text-warning text-xs no-margin">Marks Entry done -<span> {{subject.exam}}</span> </p>
                                                    </div>
                                                    <div class="tile-icon" data-placement="left" title="{{subject.staff_name}}" >
                                                        <img alt="" src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{subject.staff_id}}" . "/THUMB"; ?>">
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!--end .col -->
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
        </div><!--end #base-->	
        <?php
        $this->load->view('include_parent/headjs');
        ?>
        <script>var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>/assets/parentjs/summary.js"></script>
    </body>
</html>