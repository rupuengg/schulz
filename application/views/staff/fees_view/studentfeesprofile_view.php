
<!DOCTYPE html>
<html lang="en">
    <title>
        Student Fees relation 
    </title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote9fec.css?1422823374" />

    <body class="menubar-hoverable header-fixed " ng-app="student" ng-controller="studControl" ng-cloak>


        <?php $this->load->view('include/header'); ?>
        <!-- BEGIN BASE-->
        <div id="base">
            <!-- BEGIN CONTENT-->
            <!-- BEGIN OFFCANVAS -->

            <div class="offcanvas">
                <div  id="offcanvas-demo-right" class="offcanvas-pane style-primary-bright width-12 ">
                    <div class="offcanvas-head">
                        <header>Customize Fees  </header>
                        <div class="offcanvas-tools">

                            <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                <i class="md md-close"></i>
                            </a>
                        </div>
                    </div>
                    <div style="height: 440.083px;" class="nano has-scrollbar"><div style="right: -13px;" tabindex="0" class="nano-content"><div class="offcanvas-body">
                                <form role="form" class="form-horizontal ng-valid ng-dirty">

                                    <lr class="ng-scope" ng-repeat="FeeDetailObj in feesDetails">
                                        <h3 class="ng-binding">{{FeeDetailObj.category_name}}  </h3>


                                        <div class="form-group" ng-repeat="objDetail in FeeDetailObj.sub">
                                            <div class="col-sm-9">
                                                <div class="checkbox checkbox-styled ng-scope">
                                                    <label>
                                                        <input class="ng-valid ng-dirty" ng-model="objDetail.status" ng-change="CheckStatusData(FeeDetailObj, $index)" type="checkbox">
                                                        <span class="ng-binding">{{objDetail.head_name}}</span>
                                                    </label>
                                                </div>

                                            </div><!--end .col -->
                                        </div><!--end .form-group -->


                                    </lr>



                            </div></div><div style="display: none;" class="nano-pane"><div style="height: 427px; transform: translate(0px, 0px);" class="nano-slider"></div></div></div>
                    <div>

                    </div>
                </div>

            </div>

            <div id="content">
                <section>
                    <div class="section-body contain-lg">

                        <div class="section-body contain-lg">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-bordered style-primary">
                                        <div class="card-head card-head-xs">
                                            <header>Student Fees Relation </header>
                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright">
                                            <div class="row">
                                                <div class="card-body col-sm-12">


                                                    <div class="card tabs-right style-default-light">

                                                        <div class="card-body tab-content style-default-bright">
                                                            <div class="tab-pane active" id="summary">	

                                                                <div class="col-sm-4">                                                     
                                                                    <div class="myNewClass" style="width: 30%;min-height: 50px;">
                                                                        <img src="<?php echo base_url(); ?>index.php/staff/getstudphoto/<?php echo $details['studentdetail']['adm_no']; ?>/THUMB" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="myNewClass textalign" style="width: 70%">  
                                                                        <dl class="dl-horizontal">
                                                                             <?php  if (isset($details['studentdetail']['adm_no'])) { ?>
                                                                                 <dt>Adm.No</dt>
                                                                                 <dd >
                                                                                     <strong>: </strong><?php echo $details['studentdetail']['adm_no'];
                                                                                } else {
                                                                                    echo '';
                                                                                }
                                                                                ?></dd>
                                                                                  <?php  if (isset($details['studentdetail']['firstname'])) { ?>
                                                                                 <dt>Name</dt>
                                                                                 <dd >
                                                                                    <strong>: </strong><?php echo $details['studentdetail']['firstname'] . ' ' . $details['studentdetail']['lastname'];
                                                                                } else {
                                                                                    echo '';
                                                                                }
                                                                                ?></dd>
                                                                              <?php  if (isset($details['details']['sectionDetail']['standard'])) { ?>
                                                                                 <dt>Class</dt>
                                                                                 <dd >
                                                                                    <strong>: </strong><?php echo $details['details']['sectionDetail']['standard'] . ' ' . $details['details']['sectionDetail']['section'];
                                                                                } else {
                                                                                    echo '';
                                                                                }
                                                                                ?></dd>
                                                                               <?php  if (isset($details['details']['sectionDetail']['standard'])) { ?>
                                                                                 <dt>Class teacher</dt>
                                                                                 <dd>
                                                                                    <strong>: </strong><?php echo $details['details']['staffdetail']['salutation'] . ' ' . $details['details']['staffdetail']['staff_fname'] . ' ' . $details['details']['staffdetail']['staff_lname'];
                                                                                } else {
                                                                                    echo '';
                                                                                }
                                                                                ?></dd>
                                                                                 </dl>

                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div><!--end .card -->
                                                   </div>
                                                 </div>
                                            <div class="row" >

                                                <div class="card-body col-sm-12">
                                                    <div class="col-sm-3">
                                                    
                                                        <div class="form-group">
                                                            <select  name="select1" class="form-control" ng-model="selectdclass"  ng-show="'<?php echo isset($details['details']['sectionDetail']); ?>'==false " ng-init="selectdclass = 'NA'" ng-change="GetFeeStracture()">
                                                                <option value="NA" >Select class</option>
                                                                <option  value="{{standard.id}}" ng-repeat="standard in class">{{standard.standard}}{{standard.section}}</option>
                                                            </select>
                                                            <label for="select1"></label>
                                                        </div>
                                                      

                                                    </div> 
                                                    <div class="col-sm-4 " ng-show="selectdclass !='NA'|| '<?php echo isset($details['details']['sectionDetail']); ?>'==true">
                                                        <div class="form-group">
                                                            <a  class="btn ink-reaction btn-primary-dark" href="#offcanvas-demo-right" data-toggle="offcanvas"><i class="fa fa-plus"></i>&nbsp;&nbsp;Customize Fees student structure </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 " ng-show="selectdclass !='NA'|| '<?php echo isset($details['details']['sectionDetail']); ?>'==true">
                                                        <div class="form-group ">   
                                                            <p><button type="button" class="btn btn-block ink-reaction btn-info" ng-click="classfeessetting(<?php
                                                                                if (isset($details['details']['classid']['id'])) {
                                                                                    echo $details['details']['classid']['id'];
                                                                                } else {
                                                                                    echo 'selectdclass';
                                                                                }
                                                                                ?>)">class fee setting</button></p>
                                                        </div>
                                                    </div>


                                                </div> 

                                            </div>

                                            <div class="row">
                                                <div class="card-body col-sm-12">
                                                    <div class=" col-sm-12" >
                                                        <div class="card card-no-margin" ng-repeat="FeeDetailObj in feesDetails"  ng-if="FeeDetailObj.table_length > '0'">

                                                            <div class="card-head card-head-xs  style-gray-bright">
                                                                <header>{{FeeDetailObj.category_name}}</header>
                                                            </div><!--end .card-head -->
                                                            <div class="card-body" >
                                                                <div class="col-sm-12">
                                                                    <form name="digit" novalidate>

                                                                        <table class="table table-bordered no-margin table-condensed" >
                                                                            <thead>
                                                                                <tr>

                                                                                    <th>Fees </th>
                                                                                    <th>Amount</th>
                                                                                    <th>Refund type</th>
                                                                                    <th>Mandatory type</th>

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr ng-repeat="objDetail in FeeDetailObj.sub" ng-show="objDetail.mandatory_type == 'YES'">

                                                                                    <td>{{objDetail.head_name}}</td>
                                                                                    <td>{{objDetail.feesAmount}}</td>
                                                                                    <td>{{objDetail.refund_type}}</td>
                                                                                    <td>{{objDetail.mandatory_type}}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>

                                                                    </form>
                                                                </div>
                                                            </div><!--end .card-body -->
                                                        </div><!-- end card repeat-->

                                                    </div> 

                                                </div>


                                            </div>
                                            
                                            
                                           
                                            <div class="row" ng-show="selectdclass != 'NA' || '<?php echo isset($details['details']['sectionDetail']); ?>'==true" >
                                                <div class="col-sm-1 pull-right ">
                                                    <div class="section-floating-action-row">

                                                        <button type="button" class="btn ink-reaction btn-floating-action btn-lg btn-success" ng-click="saveStudentData(<?php if (isset($details['studentdetail']['adm_no'])) { ?>
                                                                                 
                                                                                    <?php echo $details['studentdetail']['adm_no'];
                                                                                } else {
                                                                                    echo '';
                                                                                } ?>)"><i class="fa fa-save"></i></button>

                                                    </div>
                                                </div>
                                            </div>
                                            

                                        </div><!--end .card -->
                                    </div><!--end .col -->

                                </div>
                            </div><!--end .row -->
                        </div><!--end .section-body -->
                </section>
            </div><!--end .section-body -->

        </div><!--end #content-->		
        <!-- END CONTENT -->

        <!-- BEGIN MENUBAR-->
        <div id="menubar" class="menubar-inverse ">
            <div class="menubar-scroll-panel">
                    <?php $this->load->view('include/menu'); ?>
            </div><!--end .menubar-scroll-panel-->
        </div><!--end #menubar-->
        <!-- END MENUBAR -->
         <?php
           $this->load->view('include/headjs');
           ?>
        <script>
             var myURL = "<?php echo base_url(); ?>"
            var classid = "<?php if (isset($details['details']['classid']['id'])) {
                                          echo $details['details']['classid']['id']; } else { echo '';  }
                                          ?>"
                  
        </script>
        <script src="<?php echo base_url(); ?>assets/myjs/feesmgmt/fees.js?v=<?php echo rand(); ?>"></script>


    </body>
</html>

