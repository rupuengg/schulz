<!DOCTYPE html>
<html lang="en">
    <title>Publish Marks</title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <script> var publishList=<?php if(empty($publishList)){ echo json_encode(-1);}else{ echo json_encode($publishList);}?>; </script>
    <script> var lockList=<?php if(empty($lockList)){ echo json_encode(-1);}else{ echo json_encode($lockList);}?>; </script>
    <body class="menubar-hoverable header-fixed " ng-app="publishmarks" ng-controller="publishMarksController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">

            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="card">
                            <div class="card-head">
                                <ul class="nav nav-tabs nav-justified" data-toggle="tabs">
                                    <li class="<?php echo !isset($tabname)||$tabname=='PUBLISHMARKS'?'active':'';?>"><a href="#publishmark"  >PUBLISH MARKS</a></li>
                                    <li class="<?php echo isset($tabname)&&$tabname=='LOCKMARKS'?'active':'';?>"><a href="#lockmark" >LOCK MARKS</a></li>
                                </ul>
                            </div><!--end .card-head -->
                            <div class="card-body tab-content">
                                <div class="tab-pane <?php echo !isset($tabname)||$tabname=='PUBLISHMARKS'?'active':'';?>" id="publishmark" >	
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card card-bordered style-primary">
                                                <div class="card-head card-head-xs">
                                                    <header><i class="fa fa-fw fa-tag"></i> Publish Marks</header>


                                                    <!--end .tools -->
                                                </div><!--end .card-head -->
                                                <div class="card-body style-default-bright">
                                                    <div class="tools">
                                                        <form role="search" >
                                                            <div class="form-group">
                                                                <select ng-model="myClassId"   ng-change="publishMarksDetail('PUBLISHMARKS')" style="position: relative;float: left;;  margin-top: 5px;width: 200px" class="form-control" id="sel1">
                                                                    <option value="0">Select Class</option>
                                                                    <option ng-repeat="allClassList in myclassList" value="{{allClassList.standard}}"  ng-selected="allClassList.standard =='<?php if(isset($classid)) echo $classid?$classid:'0';  ?>'">{{allClassList.standard}}{{allClassList.section}}</option>                                                        
                                                                </select>
                                                            </div>
                                                        </form>
                                                    </div><!--end .tools -->
                                                    <div class="col-xs-12" ng-show="myPublishList.length > 0">
                                                        <form  novalidate>
                                                            <table class="table table-condensed no-margin">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Exam Name</th>
                                                                        <th>Date & Time</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <tr ng-repeat="myAllPublishList in myPublishList" >
                                                                        <td>{{myAllPublishList.exam_name}}</td>
                                                                        <td> 
                                                                <datepicker date-format="dd-MM-yyyy">
                                                                    <input type="text" class="form-control" ng-model="myAllPublishList.pdate" placeholder="Publish Date" />
                                                                </datepicker>
                                                                </td>
                                                                <td><uib-timepicker  ng-change="changed()" ng-model="myAllPublishList.ptime" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></uib-timepicker></td>

                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </form>
                                                        <p ng-show="myPublishList.length != 0" class="myProButtons" style="float: right;width: 100px;"><button ng-disabled="publishMarks.$invalid" type="button" ng-click="savePublishMarks(myPublishList, date)" class="btn btn-sm ink-reaction btn-info">Save All</button></p>
                                                    </div><!--end .col -->
                                                </div><!--end .col -->

                                            </div>
                                        </div><!--end .row -->
                                        <div class="col-md-4">
                                            <div class="card card-bordered style-primary">
                                                <div class="card-head card-head-xs">
                                                    <div class="tools">

                                                    </div>
                                                    <header><i class="fa fa-fw fa-tag"></i> How to publish marks?</header>
                                                </div><!--end .card-head -->
                                                <div class="card-body style-default-bright" style="text-align: justify">
                                                    Select a class from the drop-down list. All the declared exam of that standard/class are displayed.

                                                    Declare the date and time for publishing marks  .<br>

                                                    <b>  You can not delete any of the publishing date  if any activity has been done it .</b>

                                                </div>                                    </div><!--end .card-body -->
                                        </div><!--end .card -->
                                    </div><!--end .section-body -->  
                                </div>
                                <div class="tab-pane <?php echo isset($tabname)&&$tabname=='LOCKMARKS'?'active':'';?>" id="lockmark">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card card-bordered style-primary">
                                                <div class="card-head card-head-xs">
                                                    <header><i class="fa fa-fw fa-tag"></i> Lock Marks</header>

                                                    <!--end .tools -->
                                                </div><!--end .card-head -->
                                                <div class="card-body style-default-bright">
                                                    <div class="tools">
                                                        <form role="search" >
                                                            <div class="form-group">
                                                                <select ng-model="lockClassId" ng-change="lockMarksDetail('LOCKMARKS')" style="position: relative;float: left;;  margin-top: 5px;width: 200px" class="form-control" id="sel1">
                                                                    <option value="0">Select Class</option>
                                                                    <option ng-repeat="allClassList in myclassList" value="{{allClassList.standard}}"  ng-selected="allClassList.standard =='<?php if(isset($classid)) echo $classid?$classid:'0';  ?>'">{{allClassList.standard}}{{allClassList.section}}</option>                                                        
                                                                </select>
                                                            </div>
                                                        </form>
                                                    </div><!--end .tools -->
                                                    <div class="col-xs-12" ng-show="myLockList.length > 0" >
                                                        <form name="urlForm" novalidate>
                                                            <table class="table table-condensed no-margin" >
                                                                <thead>
                                                                    <tr>
                                                                        <th>Exam Name</th>
                                                                        <th>Date</th>                                                                    
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <tr ng-repeat="allMyLockList in myLockList">
                                                                        <td>{{allMyLockList.exam_name}}</td>
                                                                        <td> 
                                                                <datepicker date-format="dd-MM-yyyy">
                                                                    <input type="text" class="form-control" ng-model="allMyLockList.ldate" placeholder="Lock Date" />
                                                                </datepicker>

                                                                </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </form>
                                                        <p ng-show="myLockList.length != 0" class="myProButtons" style="float: right;width: 100px;"><button ng-disabled="!urlForm.$valid" type="button" ng-click="saveLockMarks(myLockList)" class="btn btn-sm ink-reaction btn-info">Save All</button></p>
                                                    </div><!--end .col -->
                                                </div><!--end .col -->

                                            </div>
                                        </div><!--end .row -->
                                        <div class="col-md-4">
                                            <div class="card card-bordered style-primary">
                                                <div class="card-head card-head-xs">
                                                    <div class="tools">

                                                    </div>
                                                    <header><i class="fa fa-fw fa-tag"></i> How to lock marks?</header>
                                                </div><!--end .card-head -->
                                                <div class="card-body style-default-bright" style="text-align: justify">
                                                    Select a class from the drop-down list. All the declared exam of that standard/class are displayed.

                                                    Declare the date and time for lock marks .<br>

                                                    <b> You can not delete any of the lock date  if any activity has been done it.</b>

                                                </div>                                    </div><!--end .card-body -->
                                        </div><!--end .card -->
                                    </div><!--end .section-body --> 
                                </div>
                            </div><!--end .card-body -->
                        </div><!--end .card -->
                    </div>
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

        </div>
        <?php
        $this->load->view('include/headjs');
        ?>
        <script src="<?php echo base_url(); ?>assets/js/ui-bootstrap.min.js"></script>       
        <script>var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>/assets/myjs/publishmarks.js"></script>
