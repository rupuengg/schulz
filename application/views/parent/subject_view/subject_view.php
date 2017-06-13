<!DOCTYPE html>
<html lang="en">
    <title>Subject Details</title>
    <head>

        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="subjectdetail" ng-controller="subjectdetail_controller" ng-cloak ng-class="cloak">
        <!-- BEGIN HEADER-->
        <?php
        $this->load->view('include_parent/header');
        ?>
        <script> var data =<?php echo json_encode($subjectData); ?>;</script>
        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body" >

                        <div class="row">

                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="no-padding">
                                        <div class="card">
                                            <div class="card-head card-head-xs style-default-dark text-center">
                                                <header>Declared Exam Of {{subjectname.subject_name}}</header>
                                            </div><!--end .card-head -->
                                            <div class="card-body small-padding">

                                                <div role="alert" class="alert alert-callout  alert-success margin-bottom-lg small-padding" ng-repeat="dexam in dedata" >
                                                    <a ng-click="loadMarkStructure(dexam.id, dexam.exam_name)" > {{dexam.exam_fullname}}</a>
                                                </div>

                                            </div>
                                        </div><!--end .card -->

                                        <div class="card " ng-hide="upexdata == 0">
                                            <div class="card-head card-head-xs style-default-dark text-center">
                                                <header>Upcoming Exam of {{subjectname.subject_name}}</header>
                                            </div><!--end .card-head -->
                                            <div class="card-body small-padding scroll height-6">
                                                <div role="alert" class="alert alert-callout alert-warning margin-bottom-lg small-padding" ng-repeat="upexam in upexdata" >
                                                    Next exam is {{upexam.exam_name}} exam date is {{upexam.publish_date}}.
                                                </div>

                                            </div>
                                        </div><!--end .card -->

                                        <div class="card " ng-hide="homework == 0">
                                            <div class="card-head card-head-xs style-default-dark text-center">
                                                <header>HomeWork of {{subjectname.subject_name}}</header>
                                            </div><!--end .card-head -->
                                            <div class="card-body small-padding scroll height-6">
                                                <div role="alert" class="alert alert-callout alert-warning margin-bottom-lg" ng-repeat="homeworkd in homework">
                                                    <div class="row" >
                                                        <div class="col-lg-1 no-padding">
                                                            <img src="<?php echo base_url() . "/index.php/staff/getphoto/1/THUMB"; ?>" class="img-circle img-responsive width-1">
                                                        </div>
                                                        <div class="col-lg-11">

                                                            <strong>{{homeworkd.type}}</strong><br/>
                                                            <a href="<?php echo base_url(); ?>index.php/parent/homework/1"><p class="no-margin">{{homeworkd.title}}.</p></a><p>Last date of submission is {{homeworkd.submission_last_date}}</p>

                                                            <a class="text-xs"><i>{{homeworkd.staff_name}}</i></a>

                                                            <i class="text-xs no-margin pull-right text-primary-dark">{{homeworkd.timestamp}}</i>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div><!--end .card -->

                                    </div>
                                </div><!--end .col -->
                                <div class="col-lg-6 col-sm-12">
                                    <div class="no-padding">
                                        <div class="card" ng-show="markstructuredata">
                                            <div class="card-head card-head-xs style-default-dark text-center">
                                                <header ng-repeat="dexam in dedata" ng-if="dexam.id == examshortname">Exam Marks Structure of {{dexam.exam_name}}</header>
                                            </div><!--end .card-head -->
                                            <div class="card-body small-padding">
                                                <div class="col-sm-4 " ng-repeat="carddetail in markstructuredata">
                                                    <div class="card card-outlined style-primary-light">
                                                        <div class="card-head card-head-xs">
                                                        </div><!--end .card-head -->
                                                        <div class="card-body no-padding text-center">
                                                            <h3 class="no-margin">{{carddetail.part_name}}</h3>
                                                            <h4>{{carddetail.max_marks}} Marks</h4> 
                                                        </div><!--end .card-body -->
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-body">
                                                <div id="container"></div>
                                            </div><!--end .card-body -->
                                        </div>
                                    </div>
                                </div><!--end .card -->
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
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<script> var myURL = "<?php echo base_url(); ?>";</script>
<script>
    $(function() {
        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: data.graphdata.subjectname,
                enabled: false
            },
            subtitle: {
                enabled: false
            },
            xAxis: {
                categories: data.graphdata.graphexamlist,
                crosshair: true
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: 'Marks Obtained'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.1,
                    borderWidth: 0
                }
            },
            series: [{
                    color: '#01DF01',
                    name: 'Obtained',
                    data: data.graphdata.graphsubjectmark

                }, {
                    color: '#0000FF',
                    name: 'Highest',
                    data: data.graphdata.graphmaxmarklist

                }, {
                    color: '#FF0000',
                    name: 'Average',
                    data: data.graphdata.graphavgmarklist

                }]
        });
    });
</script>
<script src="<?php echo base_url(); ?>/assets/parentjs/subjectdetail.js"></script>
</body>
</html>
