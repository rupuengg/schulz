
<!DOCTYPE html>
<html lang="en">
    <title>Bus Entry</title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $deo_staff_id = $this->session->userdata('deo_staff_id');
    $this->load->view('include/headcss');
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
    <body class="menubar-hoverable header-fixed " ng-app="busEntryApp" ng-controller="busEntryController" ng-cloak ng-class="cloak">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-head style-primary card-head-xs">
                                        <header>Bus Entry</header>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" class="form-horizontal" name="busDetailForm" novalidate ng-submit="saveBusDetail()" >
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="regular13">Bus Owner</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="bus_contract_id" id="select1" ng-model="busDetail.bus_contract_id">
                                                        <option value="" selected>Please select Bus Contractor</option>
                                                        <option ng-repeat=" c in contractorDetail" ng-selected="c.id===busDetail.bus_contract_id" value="{{c.id}}" >{{c.name}}</option>
                                                    </select>

                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding" for="regular12">Bus Reg No.<span class="text-danger">*</span></label>

                                                <div class="col-sm-10">
                                                    <input type="text" id="regular13" ng-pattern="/[a-zA-Z0-9^ ]/"  name="bus_reg_no" ng-model="busDetail.bus_reg_no" class="form-control" required><div class="form-control-line"></div>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding" for="password13">Bus Name <span class="text-danger">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="password13" ng-model="busDetail.bus_name" class="form-control"  ng-pattern="/[a-zA-Z0-9^ ]/" required><div class="form-control-line"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding" for="placeholder13">Bus Engine No.</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="regular13" ng-model="busDetail.bus_engine_no" class="form-control" ><div class="form-control-line"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding" for="help13">No. of Seats <span class="text-danger">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="regular13" ng-model="busDetail.no_of_seats" class="form-control" ng-pattern="/[0-9^ ]/" required><div class="form-control-line"></div>
                                                    <span ng-show="busDetail.no_of_seats.length > 2" class="text-danger">* Enter 2 digit number</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding" for="help13">School Bus No.</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="regular13" ng-model="busDetail.school_bus_no" class="form-control" ><div class="form-control-line"></div>
                                                </div>
                                            </div>
                                            <div class="card-actionbar">

                                            </div>
                                            <div class="card-actionbar">
                                                <div class="card-actionbar-row">
                                                    <button class="btn btn-flat btn-primary ink-reaction" type="button" ng-click="changeButtonStataus()">{{uploadbuttonVal}}</button>
                                                    <button class="btn btn-flat btn-primary ink-reaction" type="submit" ng-disabled="busDetailForm.$invalid"  >{{buttonVal}}</button>
                                                    <button class="btn btn-flat btn-primary ink-reaction" type="button" ng-hide="cancelButton == true" ng-click="cancelUpload();">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div><!--end .card-body -->
                                </div>


                            </div>
                            <div class="col-md-6" ng-show="buttonStatus == true">
                                <div class="card">
                                    <div class="card-head style-primary card-head-xs">
                                        <header>Upload Bus Papers</header>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('tms_bus_papers');
                                        $xcrud->columns("id,bus_number,bus_paper");
                                        $xcrud->fields("bus_number");
                                        $xcrud->fields("bus_paper");
                                        $xcrud->change_type('bus_paper', 'file', '', array('not_rename' => true));
                                        //$xcrud->change_type('photo', 'image', '', array('width' => 300)); // resize main image
                                        //$xcrud->change_type('photo', 'image', '', array('width' => 300, 'height' => 300, 'crop' => false));
                                        $xcrud->label("bus_number", "Bus Number");
                                        $xcrud->label("bus_paper", "Upload Paper");
                                        $xcrud->validation_required('bus_number');
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->pass_var("deo_entry_by", $deo_staff_id);
                                        $xcrud->limit(25);

                                        $xcrud->unset_title(TRUE);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(TRUE);
                                        $xcrud->unset_remove(FALSE);
                                        echo $xcrud->render();
                                        ?>
                                    </div><!--end .card-body -->
                                </div>
                            </div>
                            <div class="col-md-6" ng-show="buttonStatus == false">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">

                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> 
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <ul >
                                            <li><span class="text-success"> Total 43 Bus in School</span></li>
                                            <li><span class="text-success">Go 40 Trip in a day</span></li>
                                            <li><span class="text-success">Total 40 Trip in a day</span></li>
                                            <li><span class="text-success">Total 40 Trip in a day</span></li>

                                        </ul>
                                        <hr class="ruler-xxl no-margin padding-top-10 small-padding">
                                        <ul >
                                            <li><span class="text-danger"> Driver not available in  12 trips</span></li>
                                            <li><span class="text-danger"> Conductors not available in  12 trips</span></li>
                                            <li><span class="text-danger"> Seats empty in 5 trips</span></li>
                                            <li><span class="text-danger">Total 40 Trip in a day</span></li>

                                        </ul>
                                    </div>                                    
                                </div><!--end .card-body -->
                            </div>

                        </div><!--end .section-body -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Reg Number</th>
                                                    <th>Name</th>
                                                    <th>Engine No.</th>
                                                    <th>No. Of Seats</th>
                                                    <th>School Bus No.</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="allBus in BusList">
                                                    <td>{{$index + 1}}</td>
                                                    <td>{{allBus.bus_reg_no}}</td>
                                                    <td>{{allBus.bus_name}}</td>
                                                    <td>{{allBus.bus_engine_no}}</td>
                                                    <td>{{allBus.no_of_seats}}</td>
                                                    <td>{{allBus.school_bus_no}}</td>
                                                    <td><a class="btn btn-flat ink-reaction" ng-click="editBusDetail(allBus.id)">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <a class="btn btn-flat ink-reaction" ng-click="deleteBusDetail(allBus.id)">
                                                            <i class="fa fa-trash"></i>
                                                        </a></td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->

                            </div>

                        </div>
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
                    <div class="expanded">
                        <a href="dashboard.html">
                            <span class="text-lg text-bold text-primary ">MATERIAL&nbsp;ADMIN</span>
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
                var bus_detail_edit =<?php echo json_encode($bus_result); ?>;
                        var myURL = "<?php echo base_url(); ?>";
                                var bus_id = "<?php echo $this->uri->segment(3)?>";</script>
            <script src="<?php echo base_url(); ?>/assets/myjs/transport/transport.js?v=<?php echo rand(); ?>"></script>    