<!DOCTYPE html>
<html lang="en">
    <title>Transport Report</title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
    $this->load->view('include/headcss');
    $trip_id=$this->uri->segment(3);
    $stop_id=$this->uri->segment(3);
    ?>

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote9fec.css?1422823374" />
    <style>
        .myProButtons{
            position: relative;
            float: right;
            margin-left: 5px
        }
        .decorateMe{
            text-decoration: underline;
        }
    </style>
    <body class="menubar-hoverable header-fixed " ng-app="reportApp" ng-controller="reportAppController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head">
                                        <ul data-toggle="tabs" class="nav nav-tabs">
                                            <li class="active"><a href="#first1">Bus Trip Report</a></li>
                                            <li class=""><a href="#second1">Bus Driver Trip Report</a></li>
                                            <li class=""><a href="#third1">Bus Stop Report </a></li>
                                        </ul>
                                    </div><!--end .card-head -->
                                    <div class="card-body tab-content">
                                        <div id="first1" class="tab-pane active">
                                            <div class="col-md-8">
                                                <div class="card card-bordered style-primary">
                                                    <div class="card-head style-primary card-head-xs">
                                                        <div class="tools">
                                                        </div>
                                                        <header><i class="fa fa-fw fa-tag"></i>Trip Wise Student Report</header>
                                                    </div><!--end .card-head -->
                                                    <div class="card-body style-default-bright">
                                                        <div class="form-group">
                                                            <select id="dd_section_type" ng-model="selectBusno" class="my-select" ng-change="selectBusNo()">
                                                                <option value="">Select Trip</option>
                                                                <option value="{{trip.id}}" ng-selected="{{'<?php echo $this->uri->segment(3) ?>' === trip.id}}" ng-repeat="trip in tripDetail">{{trip.trip_name}}</option>

                                                            </select>
                                                        </div>
                                                        <?php
                                                        
                                                             $this->load->library('loadxcrud');
                                                             echo Xcrud::load_css();
                                                              if ($trip_id != null) {
                                                            $xcrud = Xcrud::get_instance();
                                                            $xcrud->table('tms_bus_student_relation');
                                                            $xcrud->where('trip_id=', $trip_id);
                                                            $xcrud->join('adm_no', 'biodata', 'adm_no');
                                                            $xcrud->join('biodata.section_id', 'section_list', 'id');
                                                            $xcrud->relation('adm_no', 'biodata', 'adm_no', array("firstname", "lastname"));
                                                            $xcrud->relation('section_id', 'section_list', 'id', array("class"=>"standard", "section"));
                                                            $xcrud->columns("biodata.adm_no,adm_no,trip_type,section_list.standard,section_list.section");
                                                            $xcrud->unset_title();
                                                            $xcrud->limit(25);
                                                            $xcrud->unset_edit(TRUE);
                                                            $xcrud->unset_add(TRUE);
                                                            $xcrud->unset_view(TRUE);
                                                            $xcrud->unset_print(FALSE);
                                                            $xcrud->unset_csv(FALSE);
                                                            $xcrud->unset_search(TRUE);
                                                            $xcrud->unset_remove(TRUE);
                                                            echo $xcrud->render();
                                                              }
                                                  
                                                        ?>
                                                    </div><!--end .card-body -->
                                                </div><!--end .card -->
                                            </div>
                                             <div class="col-md-4">
                                               <div class="card card-bordered style-primary">
                                                   <div class="card-head style-primary card-head-xs">
                                                       <div class="tools">

                                                       </div>
                                                       <header><i class="fa fa-fw fa-tag"></i> How to Generate Trip Wise Student Report?</header>

                                                   </div><!-end .card-head ->
                                                   <div class="card-body style-default-bright">
                                                       Please select a trip,it will generate a list of Students that is assigned for that particular trip.


                                                   </div>                                    </div><!--end .card-body ->
                                           </div><!--end .card ->
                                        </div>

                                    </div><!--end .card-body -->
                                </div>
                                           
                                        </div>
                                      
                                        <div id="second1" class="tab-pane">
                                             <div class="col-md-8">
                                                <div class="card card-bordered style-primary">
                                                    <div class="card-head style-primary card-head-xs">
                                                        <div class="tools">
                                                        </div>
                                                        <header><i class="fa fa-fw fa-tag"></i>Trip Wise Driver Report</header>
                                                    </div><!--end .card-head -->
                                                    <div class="card-body style-default-bright">
                                                        <div class="form-group">
                                                           <select id="dd_section_type" ng-model="selectBusno" class="my-select" ng-change="selectBusNo()">
                                                                <option value="">Select trip</option>
                                                                <option value="{{trip.id}}" ng-selected="{{'<?php echo $this->uri->segment(3) ?>' === trip.id}}" ng-repeat="trip in tripDetail">{{trip.trip_name}}</option>

                                                            </select>
                                                        </div>
                                                         <?php
                                                        if($trip_id!=''){
                                                        $xcrud1 = Xcrud::get_instance();
                                                        $xcrud1->table('tms_bus_driver_relation');
                                                        $xcrud1->where('trip_id=',$trip_id);
                                                        $xcrud1->join('driver_id','tms_bus_driver_details','id'); 
                                                        $xcrud1->columns("tms_bus_driver_details.name,tms_bus_driver_details.address,tms_bus_driver_details.mobile_no,tms_bus_driver_details.licence_valid_upto");
                                                        $xcrud1->unset_title();
                                                        $xcrud1->limit(25);
                                                        $xcrud1->unset_edit(TRUE);
                                                        $xcrud1->unset_add(TRUE);
                                                        $xcrud1->unset_view(TRUE);
                                                        $xcrud1->unset_print(FALSE);
                                                        $xcrud1->unset_csv(FALSE);
                                                        $xcrud1->unset_search(TRUE);
                                                        $xcrud1->unset_remove(TRUE);
                                                        echo $xcrud1->render();
                                                        }
                                                        ?>
                                                    </div><!--end .card-body -->
                                                </div><!--end .card -->
                                            </div>
                                               <div class="col-md-4">
                                               <div class="card card-bordered style-primary">
                                                   <div class="card-head style-primary card-head-xs">
                                                       <div class="tools">

                                                       </div>
                                                       <header><i class="fa fa-fw fa-tag"></i> How to Generate Trip Wise Driver Report?</header>

                                                   </div><!-end .card-head ->
                                                   <div class="card-body style-default-bright">
                                                       Please select a trip,it will generate detail of driver who are assigned for that particular trip.


                                                   </div>                                    </div><!--end .card-body ->
                                           </div><!--end .card ->
                                        </div>

                                    </div><!--end .card-body -->
                                </div>
                                           
                                        </div>
                                       <div id="third1" class="tab-pane">
                                            
                                           <div class="col-md-8">
                                                <div class="card card-bordered style-primary">
                                                    <div class="card-head style-primary card-head-xs">
                                                        <div class="tools">
                                                        </div>
                                                        <header><i class="fa fa-fw fa-tag"></i>Stop Wise Student Report</header>
                                                    </div><!--end .card-head -->
                                                    <div class="card-body style-default-bright">
                                                       <div class="form-group">
                                                    <select id="dd_section_type" ng-model="selectStopName" class="my-select" ng-change="selectStop()">
                                                        <option value="">Select Stop</option>
                                                        <option ng-repeat="stop in stoplist" value="{{stop.id}}" ng-selected="{{'<?php echo $this->uri->segment(3) ?>' === stop.id}}" >{{stop.stop_name}}</option>

                                                    </select>
                                                </div>
                                                <?php
                                                if($stop_id!=''){
                                                $xcrud2 = Xcrud::get_instance();
                                                $xcrud2->table('tms_bus_stop_trip_relation');
                                                $xcrud2->where('stop_id=',$stop_id);
                                                $xcrud2->join('trip_id', 'tms_bus_student_relation', 'trip_id');
                                                $xcrud2->join('tms_bus_student_relation.adm_no', 'biodata', 'adm_no');
                                                //$xcrud2->relation('tms_bus_student_relation.adm_no', 'biodata', 'adm_no', array("name"=>"firstname", "lastname"));
                                                $xcrud2->columns("biodata.adm_no,biodata.firstname,biodata.lastname");
                                                $xcrud2->unset_title();
                                                $xcrud2->limit(25);
                                                $xcrud2->unset_edit(TRUE);
                                                $xcrud2->unset_add(TRUE);
                                                $xcrud2->unset_view(TRUE);
                                                $xcrud2->unset_print(FALSE);
                                                $xcrud2->unset_csv(FALSE);
                                                $xcrud2->unset_search(TRUE);
                                                $xcrud2->unset_remove(TRUE);
                                                echo $xcrud2->render();
                                                }
                                                ?>
                                                    </div><!--end .card-body -->
                                                </div><!--end .card -->
                                            </div>
                                           <div class="col-md-4">
                                               <div class="card card-bordered style-primary">
                                                   <div class="card-head style-primary card-head-xs">
                                                       <div class="tools">

                                                       </div>
                                                       <header><i class="fa fa-fw fa-tag"></i> How to Generate Stop Wise Student Report?</header>

                                                   </div><!-end .card-head ->
                                                   <div class="card-body style-default-bright">
                                                       Please select a stop,it will generate a list of students who are assigned for that particular stop.


                                                   </div>                                    </div><!--end .card-body ->
                                           </div><!--end .card ->
                                        </div>

                                    </div><!--end .card-body -->
                                </div>


                            </div>
                        </div><!--end .section-body -->

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
                var myURL = "<?php echo base_url(); ?>";
                        function changeURL(element) {
                        if (element.value == '') {
                        } else {
                        window.location = "<?php echo base_url(); ?>index.php/staff/buswisestudentreport/" + element.value;
                        }
                        }
            </script>
            <script src="<?php echo base_url(); ?>/assets/myjs/transport/transport.js?v=<?php echo rand(); ?>"></script>