
<!DOCTYPE html>
<html lang="en">
    <title>
        Classwise Head Setting 
    </title>
    <?php
    $this->load->view('include/headcss');
    $showsave = array();
    ?>

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote9fec.css?1422823374" />
    
    <body class="menubar-hoverable header-fixed " ng-app="fee" ng-controller="feeController" ng-cloak>
        <!--<body class="menubar-hoverable header-fixed ">-->
        <?php $this->load->view('include/header'); ?>

        <!-- BEGIN BASE-->
        <div id="base">
           

            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body contain-lg">

                        <div class="section-body contain-lg">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-bordered style-primary">
                                        <div class="card-head card-head-xs">
                                            <header>Classwise head Setting</header>
                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright">
                                            <div class="row">
                                                <div class="card-body col-sm-12">
                                                    <form class="form">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">      
                                                                <select  name="select1" class="form-control" ng-model="selectstandard" ng-init="selectstandard = '<?php if($selectedclass!=null) { echo  $selectedclass;  } else { echo 'NA'; }  ?>'" ng-change="selectfees()">
                                                                    <option value="NA" >Select class</option>
                                                                    <option  value="{{x.id}}" ng-repeat="x in standardName" ng-selected="x.id === '<?php echo $selectedclass; ?>'">{{x.standard}}</option>
                                                                </select>
                                                                <label for="select1">Class</label>
                                                               
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6" ng-show="selectstandard != 'NA'" >
                                                            <div class="form-group">
                                                                <select   name="select1" class="form-control" ng-model="category_id"  ng-init="category_id = 'NA2'" ng-change ="selectfees()">
                                                                    <option value="NA2" >Select Fees</option>
                                                                    <option value="{{x.id}}" ng-repeat="x in feesName" >{{x.category_name}}</option>
                                                                </select>
                                                                <label for="select1">Fees</label>
                                                            </div>

                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class=" card-body col-sm-12" ng-hide="category_id == 'NA2'">
                                                    <div class="col-sm-7" >
                                                        <form name="digit" novalidate>
                                                            <table class="table table-bordered no-margin">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr.</th>
                                                                        <th>Fees</th>
                                                                        <th>Amount</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr ng-repeat="feeDetailObj in feesdetail">
                                                                        <td><div class="checkbox checkbox-inline checkbox-styled" >
                                                                                <label>
                                                                                    <input type="checkbox" ng-model ="feeDetailObj.status" ng-change="checkStatus(feeDetailObj)"><span></span>
                                                                                </label>
                                                                            </div></td>
                                                                        <td>{{feeDetailObj.head_name}}</td>

                                                                        <td>

                                                                            <input type="text" name="amount" class="form-control" id="placeholder2" ng-keyup="validateamount(feeDetailObj)" ng-model="feeDetailObj.feesAmount" ng-pattern="/^[0-9]+$/" required>
                                                                            <span ng-show="feeDetailObj.myErr == 'true'" class="text-danger">please enter number only</span> 

                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </form>
                                                    </div>
                                                    <div class="col-sm-5" ng-hide="feesname.length == 0">
                                                        <div class="card card-bordered style-primary" >
                                                            <div class="card-head card-head-xs">
                                                                <header>Non declared fees Yet!</header>
                                                            </div>
                                                            <div class="card-body style-default-bright" >
                                                                <ul class="list divider-full-bleed" >
                                                                    <li class="tile" ng-repeat="feesNameObj in feesname"  ng-show="feesNameObj.main_id != category_id">
                                                                        <a class="tile-content ink-reaction">
                                                                            <div class="tile-icon">
                                                                                <i class="md md-alarm-on"></i>
                                                                            </div>
                                                                            <div class="tile-text"> {{feesNameObj.main_cat_name}}</div>
                                                                        </a>
                                                                        <a class="btn btn-flat ink-reaction">
                                                                            <button type="button"  ng-click="markFees(feesNameObj.main_id);selectfees()" class="btn ink-reaction btn-raised btn-sm btn-primary">Mark</button>
                                                                        </a>
                                                                    </li>
                                                                </ul> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="card-body col-sm-12">

                                                    <div class="col-sm-2" ng-hide="category_id == 'NA2'">
                                                        <div class="form-group">   
                                                            <p><button type="button" class="btn btn-block ink-reaction btn-primary" ng-disabled="isCopySetting" ng-click="showdrpdwn = true" ng-model="copysetting" ng-init="setting = 'NA2'" >COPY SETTING</button></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2" ng-hide="category_id == 'NA2'">
                                                        <div class="form-group">   
                                                            <p><button type="button" class="btn btn-block ink-reaction btn-primary" ng-disabled="isAnyCheckedStatus "  ng-click="save(selectstandard, 'Are you want to save details?')"><span ng-show ="changeName != false">SAVE</span><span ng-show="changeName == false">UPDATE</span></button></p>  
                                                        </div>
                                                    </div>   
                                                </div>
                                            </div>

                                            <div class="row" >
                                                <div class="card-body col-sm-12" ng-hide="category_id == 'NA2'" >
                                                    <div class="col-sm-4" ng-init="showdrpdwn = false" ng-show="showdrpdwn">
                                                        <div class="form-group">
                                                            <select   name="select1" class="form-control" ng-init="setting = 'Select Class'" ng-model="setting" ng-change="save(setting, 'Are you want to save copy details?')">
                                                                <option value="Select Class">Select Class</option>
                                                                <option value="{{x.id}}"  ng-repeat ="x in standardName" >{{x.standard}}</option>
                                                            </select>
                                                            <label for="select1"></label>
                                                        </div>
                                                    </div>
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
                <div class="menubar-foot-panel">
                    <small class="no-linebreak hidden-folded">
                        <span class="opacity-75">Copyright &copy; 2014</span> <strong>CodeCovers</strong>
                    </small>
                </div>
            </div><!--end .menubar-scroll-panel-->
        </div><!--end #menubar-->
        <!-- END MENUBAR -->

        <!-- BEGIN OFFCANVAS RIGHT -->
        <?php
        $this->load->view('include/headjs');
        ?>
        <script>
                    var myURL = "<?php echo base_url(); ?>";
        </script>
        <script src="<?php echo base_url(); ?>assets/myjs/feesmgmt/fees.js?v=<?php echo rand(); ?>"></script>
        <!--<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.0-rc.3/angular-resource.min.js"></script>-->

    </body>
</html>
