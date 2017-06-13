<!DOCTYPE html>
<html lang="en">
    <title>CCE Grade</title>
    <head>

        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="ccegrade" ng-controller="ccegradeController">
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
                                <div class="col-lg-6 col-sm-12" ng-show="gradeData == 0" >
                                    <div class="text-center text-warning" style="margin-top: 16%;" >
                                        <i class="fa fa-wrench fa-15x"></i><br/>
                                        <p class="text-xxl text-ultra-bold">No Data Found Yet...</p> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12" ng-show="gradeData != 0">
                                    <div class="no-padding">
                                        <div role="alert" class="alert alert-callout alert-success margin-bottom-lg" ng-repeat="ccedetail in gradeData| orderBy:'-timestamp'">
                                            <div class="row" >
                                                <div class="col-lg-1 no-padding">
                                                    <img class="img-circle img-responsive width-1" src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{ccedetail.data.staff_id}}" . "/THUMB"; ?>"/>
                                                </div>
                                                <div class="col-lg-11">
                                                    <strong>{{ccedetail.data.cce_name}}: TERM {{ccedetail.data.term}} - Grade {{ccedetail.data.grade}}</strong><br/>
                                                    <blockquote class="text-sm small-padding no-margin">
                                                        <p class="no-margin">{{ccedetail.data.di}}</p>
                                                        <footer><a><i>- {{ccedetail.data.staff_name}}</i></a></footer>
                                                    </blockquote>
                                                    <i class="text-xs no-margin pull-right text-primary-dark">{{ccedetail.timestamp}}</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end .col -->



                                <div data-toggle="" class="btn-group margin-bottom-lg" ng-show="gradeData != 0" >
                                    <label class="btn btn-primary">
                                        <input type="radio" ng-model="term" value="1" ng-click="myClick()">Term-I
                                    </label>
                                    <label class="btn ink-reaction btn-primary">
                                        <input type="radio" ng-model="term" value="2" ng-click="myClick()">Term-II
                                    </label>
                                </div><!--end .btn-group -->
                                <div class="col-lg-6 col-sm-12" ng-show="rightGradeData != 0">
                                    <div class="no-padding">
                                        <div class="panel-group" id="accordion2">
                                            <div class="card panel" ng-repeat="ccedetailRight in rightGradeData">
                                                <div class="card-head card-head-xs" data-toggle="collapse" data-parent="#accordion2" data-target="#accordion2-{{$index}}" style="background: {{ccedetailRight.data.color}}">
                                                    <header>{{ccedetailRight.data.cce_name}} - <span class="pull-right"> {{ccedetailRight.data.grade}} </span></header>
                                                    <div class="tools">

                                                        <a class="btn btn-icon-toggle btn-xs"><i class="fa fa-angle-down"></i></a>
                                                    </div>
                                                </div>
                                                <div id="accordion2-{{$index}}" class="collapse">
                                                    <div class="card-body small-padding style-primary-light">
                                                        <p class="text-lg ">{{ccedetailRight.data.grade}}</p>
                                                        <blockquote class="text-sm small-padding no-margin">
                                                            <p class="no-margin">{{ccedetailRight.data.di}}</p>
                                                            <footer>{{ccedetailRight.data.staff_name}}</footer>
                                                        </blockquote>
                                                        <i class="text-xs no-margin pull-right text-primary-dark">{{ccedetailRight.timestamp}}</i>
                                                    </div>
                                                </div>
                                            </div><!--end .panel -->


                                        </div><!--end .panel-group -->
                                    </div>

                                </div><!--end .col -->
                            </div>
                        </div>

                    </div><!--end .section-body -->
                </section>

            </div><!--end #content-->		

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
            </div>   </div> <?php
        $this->load->view('include_parent/headjs');
        ?>
        <script>
                    var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>/assets/parentjs/ccegrade.js"></script>


    </body>
</html>