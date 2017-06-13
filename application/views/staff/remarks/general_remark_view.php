<!DOCTYPE html>
<html lang="en">
    <title>
        Remark Entry
    </title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed ">
        <?php $this->load->view('include/header'); ?>
        <div id="base" ng-app="generalRemarkEntry" ng-cloak ng-class="cloak">
            <div id="content" ng-controller="generalRemrkcontroller">
                <section>
                    <div class="section-body contain-lg">
                        <div class="card-body style-default-bright">
                            <div class="row" >
                                <div class="col-md-12">                                    
                                    <div class="card">
                                        <div aria-label="Justified button group" role="group" class="btn-group btn-group-justified">
                                            <a role="button" href="<?php echo base_url(); ?>index.php/staff/remarkentrysub" class="btn <?php if ($page_type == 'SUBJECT') { ?> btn-primary-bright <?php } else { ?> btn-default-bright<?php } ?>">Remark Entry Subject</a>
                                            <a role="button" href="<?php echo base_url(); ?>index.php/staff/remarkentrygen" class="btn <?php if ($page_type == 'GENERAL') { ?> btn-primary-bright <?php } else { ?> btn-default-bright<?php } ?>">Remark Entry General</a>
                                        </div><!--end .card-head -->                                        
                                    </div><!--end .card -->
                                    <div class="card">
                                        <div class="card card-bordered style-primary" >                                                                             
                                            <div class="card-head card-head-sm">
                                                <header><i class="fa fa-fw fa-tag"></i>General Remarks Entry</header>
                                            </div><!--end .card-head -->
                                        </div>
                                        <div class="card-body style-default-bright">
                                           
                                                <div class="col-xs-12">
                                                    <div class="form-group">
									<select id="select1" ng-change="mySectionStudent()" ng-model="mySelectedData" ng-app ng-init="mySelectedData = 'NA'" class="form-control" required="" aria-required="true">
										 <option value="NA">Please Select Section</option>
                                                                                 <option value='{{tempData}}' ng-repeat="tempData in data" value="">{{tempData.standard}} {{tempData.section}}</option>
                                                                        </select>
						    </div>
                                                </div>
                                       
                                            <div class="col-xs-7" ng-show="mySelectedData!='NA'">
                                                <table class="table table-condensed no-margin">
                                                    <thead class="style-primary">
                                                        <tr>
                                                            <th>Profile Pic</th>
                                                            <th>Name</th>
                                                            <th>Remarks</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="std in secdata">
                                                            <td><img class="img-circle width-1" src="<?php echo base_url().'index.php/staff/getstudphoto/{{std.adm_no}}/THUMB' ?>" alt=""></td>
                                                            <td>{{std.adm_no}}. {{std.firstname}} {{std.lastname}}</td>
                                                            <td><textarea type="text" ng-blur="myFocusStudentout()" ng-focus="myFocusStudentEvent(std)" ng-model="std.remark_filled" class="form-control" id="regular13"></textarea></td>
                                                            <td> <button idd="{{mySelectedData.subject_id}}" style="width: 60px;" ng-click="mysaveclick(std, 2)" type="button" class="btn btn-block ink-reaction btn-primary">Save</button></td>
                                                        </tr>
                                                </table>
                                            </div>
                                            <div ng-show="showstddetail" class="col-lg-5 col-sm-7">
                                                <div class="card">
                                                    <div class="card-head card-head-xs style-primary">
                                                        <header><img alt="" src="<?php echo base_url().'index.php/staff/getstudphoto/{{selectedstd.adm_no}}/THUMB' ?>" class="img-circle width-1">{{selectedstd.adm_no}}. {{selectedstd.firstname}} {{selectedstd.lastname}}</header>
                                                    </div>
                                                    <!--end .card-head -->
                                                    <div class="card-body">
                                                        <div class="tab-pane" id="activity" ng-show="selectedstd.remarkDetail.length>0">
                                                            <ul class="timeline collapse-lg timeline-hairline">
                                                                <li ng-repeat="ss in selectedstd.remarkDetail"class="timeline-inverted">
                                                                    <div class="timeline-circ circ-xl style-primary"><i class="md md-event"></i></div>
                                                                    <div class="timeline-entry">
                                                                        <div class="card style-default-light">
                                                                            <div class="card-body small-padding">
                                                                                <div class="card-head">
                                                                                    <header>Remark</header>
                                                                                    <div class="tools">
                                                                                        <div class="btn-group">
                                                                                            <a class="btn btn-icon-toggle btn-close"><i class="md md-close" id="{{ss.id}}" ng-click="deleteRemark($event)"></i></a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!--{{ss.staffname}}-->
                                                                                <div class="card-body small-padding">
                                                                                <div class="text-medium">
                                                                                    {{ss.remark}}<br>
                                                                                    <small>{{ss.timestamp}}</small>
                                                                                        
                                                                                    </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                    </div><!--end .timeline-entry -->
                                                                </li>
                                                            </ul>
                                                        </div><!--end .card -->
                                                          <div ng-show="selectedstd.remarkDetail.length==0" class="alert alert-danger" role="alert" ng-show="selectedstd.remarkDetail.length==0">
								<strong>No remarks found in database.</strong> 
							</div>
                                                    </div>
                                                </div><!--end .card-body -->
                                            </div><!--end .card -->
                                        </div>
                                    </div>
                                </div>
                            </div><!--end .row -->
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
            ?>
            <script>
                var page_type = "<?php echo $page_type; ?>";
                var base_url = "<?php echo base_url(); ?>";</script>
            <script src="<?php echo base_url(); ?>assets/myjs/RemarkEntry.js"></script>
