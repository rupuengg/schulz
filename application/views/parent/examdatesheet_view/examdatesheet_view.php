<!DOCTYPE html>
<html lang="en">
    <title>Exam Datesheet</title>
    <head>
        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <script>
        var data = <?php echo json_encode($examDateSheet); ?>;
    </script>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="examdatesheet" ng-controller="examdatesheetController">
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
                                <div class="text-center text-warning" style="margin-top: 16%;" ng-show="datesheetData == 0">
                                    <i class="fa fa-wrench fa-15x"></i><br/>
                                    <p class="text-xxl text-ultra-bold">No Exam Datesheet Declare Yet...</p> 
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="no-padding">
                                        <div role="alert" class="alert alert-callout alert-warning margin-bottom-lg small-padding" ng-repeat="dateSheet in datesheetData" ng-show="dateSheet.exam_publish_date <= '<?php echo date("Y-m-d"); ?>'">
                                            <div class="row">
                                                <div class="col-lg-11">
                                                    <p class="no-margin">{{dateSheet.exam_name}} from {{dateSheet.start_date| date:'MMM d, y'}}  to  {{dateSheet.end_date| date:'MMM d, y'}} 
                                                        <br><b><a href="<?php echo base_url(); ?>index.php/parent/examdatesheet/{{dateSheet.id}}">Click Here to view datesheet</a></b></p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end .col -->
                                <?php if ($examDateSheet != 0) { ?>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="card" >
                                            <h3 class="text-center text-bold">Exam Datesheet</h3>
                                            <table class="table table-condensed no-margin table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Subject Name</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Duration</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="myDate in dateSheetNew">
                                                        <td>{{myDate.subject_name}}</td>
                                                        <td>{{myDate.examDate}}</td>
                                                        <td>{{myDate.exam_time}}</td>
                                                        <td>{{myDate.duration}}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
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
        <!-- END JAVASCRIPT -->
        <script>
                    var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>/assets/parentjs/examdatesheet.js"></script>
    </body>
</html>