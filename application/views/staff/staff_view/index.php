
<!DOCTYPE html>
<html lang="en">
    <title>
        Manage Staff 
    </title>
    <?php
    $this->load->view('include/headcss');
    $random = '';
    ?>

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote9fec.css?1422823374" />
    <style>
        .myProButtons{
            position: relative;
            float: right;
            margin-left: 5px;
            width:80%
        }
    </style>
    <body class="menubar-hoverable header-fixed " ng-app="manageStaff" ng-controller="staffController" ng-cloak ng-class="cloak">
        <?php $this->load->view('include/header'); ?>

        <!-- BEGIN BASE-->
        <div id="base">
            <!-- BEGIN OFFCANVAS LEFT -->
            <div class="offcanvas">



                <!-- BEGIN OFFCANVAS DEMO LEFT -->
                <div id="offcanvas-demo-left" class="offcanvas-pane width-6">
                    <div class="offcanvas-head">
                        <header>Left off-canvas</header>
                        <div class="offcanvas-tools">
                            <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                <i class="md md-close"></i>
                            </a>
                        </div>
                    </div>

                    <div class="offcanvas-body">
                        <p>
                            An off-canvas can hold any content you want.
                        </p>
                        <p>
                            Close this off-canvas by clicking on the backdrop or press the close button in the upper right corner.
                        </p>
                        <p>&nbsp;</p>
                        <h4>Some details</h4>
                        <ul class="list-divided">
                            <li><strong>Width</strong><br/><span class="opacity-75">240px</span></li>
                            <li><strong>Height</strong><br/><span class="opacity-75">100%</span></li>
                            <li><strong>Body scroll</strong><br/><span class="opacity-75">disabled</span></li>
                            <li><strong>Background color</strong><br/><span class="opacity-75">Default</span></li>
                        </ul>
                    </div>
                </div>
                <!-- END OFFCANVAS DEMO LEFT -->

            </div><!--end .offcanvas-->
            <!-- END OFFCANVAS LEFT -->

            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body contain-lg">

                        <div class="section-body contain-lg">
                            <div class="row">
                                <div class="col-md-12">
                                    <div  class="modal fade" id="simpleModal" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" ng-click="imageDataURI = ''" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="simpleModalLabel">Upload image</h4>
                                                </div>
                                                <div class="modal-body height-9">
                                                  <form ng-show="enableCrop">
                                                        <label for="fileInput">Select Image:</label>
                                                        <input type="file" id="fileInput" />
                                                    </form>
                                                    <div>
                                                        <button class="btn btn-xs ink-reaction btn-danger" ng-click="imageDataURI = ''">Reset Image</button>
                                                    </div>
                                                    <div>
                                                        <button class="btn btn-xs ink-reaction btn-success" ng-click="FinalImage()">Done Image</button>
                                                    </div>
                                                    <div ng-if="enableCrop" class="cropArea" ng-class="{'big':size == 'big', 'medium':size == 'medium', 'small':size == 'small'}">
                                                        <img-crop image="imageDataURI"
                                                                  result-image="$parent.resImageDataURI"
                                                                  change-on-fly="changeOnFly"
                                                                  area-type="{{type}}"
                                                                  area-min-size="selMinSize"
                                                                  result-image-format="{{resImgFormat}}"
                                                                  result-image-quality="resImgQuality"
                                                                  result-image-size="resImgSize"
                                                                  on-change="onChange($dataURI)"
                                                                  on-load-begin="onLoadBegin()"
                                                                  on-load-done="onLoadDone()"
                                                                  on-load-error="onLoadError()"
                                                                  ></img-crop>
                                                    </div>
                                                </div>

                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    <div class="card card-bordered style-primary">
                                        <div class="card-head card-head-xs">

                                            <header><i class="fa fa-fw fa-tag"></i>Staff Entry</header>


                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright">

                                            <div class='row'>

                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card tabs-left style-default-light">
                                                            <p style="margin-top: 5px;font-weight: bold" ng-cloak>&nbsp;&nbsp;Total {{myStaffList.length}} Staff Found in Database</p>
                                                            <form  style="width:100%" class="navbar-search expanded" role="search">

                                                                <div class="form-group">
                                                                    <input ng-model="mySearchInput" type="text" class="form-control" name="contactSearch" placeholder="Enter your keyword">
                                                                </div>
                                                                <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                                                            </form>
                                                            <ul ng-show="staffLoad" ng-init="staffLoad = false" style="height: 450px;overflow: auto" class="list ui-sortable" data-sortable="true">
                                                                <li ng-cloak ng-repeat="myStaffListObj in myStaffList| orderBy:'staff_fname' | filter:mySearchInput" class="tile">
                                                                    <a href="<?php echo base_url(); ?>index.php/staff/staffprofile/{{myStaffListObj.id}}" class="tile-content ink-reaction">
                                                                        <div class="tile-icon">
                                                                            <img alt="" ng-src="{{myStaffListObj.profile_pic_path}}">
                                                                        </div>
                                                                        <div class="tile-text">{{myStaffListObj.staff_fname + ' ' + myStaffListObj.staff_lname}}</div>
                                                                    </a>
                                                                    <a ng-click="editStaffDetail(myStaffListObj, $index)" class="btn btn-flat ink-reaction">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            <ul ng-show="!staffLoad"  style="height: 450px;overflow: auto" class="list ui-sortable" data-sortable="true">
                                                                <center><img src="<?php echo base_url() . "/assets/img/modules/materialadmin/ajax-loader.gif" ?>"/></center>
                                                            </ul>
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">

                                                                <div class="col-md-8">
                                                                    <form class="form" name="myForm" novalidate>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <div ng-class="myForm.staff_fname.$valid == false ? 'has-error' : ''" class="input-group-content ">
                                                                                    <input required="string"  name="staff_fname" ng-pattern="/^[A-Za-z \s]+$/" ng-model="mainStaff.staff_fname" type="text" class="form-control" id="doublegroupbutton9" value="">
                                                                                    <input  ng-model="mainStaff.id" style="display: none" type="text" class="form-control" id="doublegroupbutton9" value="">
                                                                                    <label for="doublegroupbutton9">First Name</label>
                                                                                        <span  ng-show="myForm.staff_fname.$error.required" id="Name1-error" class="help-block">Please Enter Staff Name.</span>
                                                                                </div>
                                                                                <div class="input-group-btn">
                                                                                    <button type="button" class="btn btn-default" tabindex="-1" >{{salutation}}</button>
                                                                                    <button type="button" class="btn ink-reaction btn-info dropdown-toggle" data-toggle="dropdown" tabindex="-1" aria-expanded="false">
                                                                                        <span class="caret"></span>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu pull-right" role="menu">
                                                                                        <li><a ng-click="setSalutation('Mr')" href="#">Mr</a></li>
                                                                                        <li><a ng-click="setSalutation('Ms')" href="#">Ms</a></li>
                                                                                        <li><a ng-click="setSalutation('Mrs')" href="#">Mrs</a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div><!--end .input-group -->
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input ng-model="mainStaff.staff_lname" type="text" class="form-control" id="password1">
                                                                            <label for="password1">Last Name</label>
                                                                        </div>
                                                                        <div class="form-group" ng-class="myForm.staff_landline.$valid == false ? 'has-error' : ''">
                                                                            <input ng-model="mainStaff.staff_landline" name="staff_landline" type="tex" ng-pattern="/^[0-9]+$/"  maxlength="13" class="form-control" id="password1">
                                                                            <label for="password1">Land Line</label>
                                                                             <span  ng-show="!myForm.staff_landline.$valid" id="Name1-error" class="help-block">Please Enter valid only.</span>
                                                                        </div>
                                                                        <div class="form-group" ng-class="myForm.mobile_no_for_sms.$valid == false ? 'has-error' : ''">
                                                                            <input required  name="mobile_no_for_sms" type="text" ng-model="mainStaff.mobile_no_for_sms" minlength="10"  maxlength="10" ng-pattern="/^[0-9]+$/" class="form-control" id="password1" >
                                                                            <label for="password1">Mobile No</label>
                                                                            <span  ng-show="!myForm.mobile_no_for_sms.$valid" id="Name1-error" class="help-block">Please Enter valid 10 digit mobile no.</span>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <select ng-cloak ng-model="mainStaff.designation" ng-app ng-init="mainStaff.designation = 'NA'" name="select1" class="form-control">
                                                                                <option value="NA" >Select Designation</option>
                                                                                <option ng-repeat="myTempDesig in myDesigList" value="{{myTempDesig.id}}">{{myTempDesig.name}}</option>

                                                                            </select>
                                                                            <label for="select1">Designation</label>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <select ng-cloak ng-model="mainStaff.department" ng-app ng-init="mainStaff.department = 'NA2'"  name="select1" class="form-control">
                                                                                <option value="NA2" >Select Department</option>
                                                                                <option  ng-repeat="myTempDept in myDepList" value="{{myTempDept.id}}">{{myTempDept.name}}</option>

                                                                            </select>
                                                                            <label for="select1">Department</label>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input  ng-model="mainStaff.e_mail"  type="text" class="form-control" id="help1" >
                                                                            <label>Email</label>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input  ng-model="mainStaff.qualification" type="text" class="form-control" id="help1" >
                                                                            <label for="help1">Qualification</label>

                                                                        </div>
                                                                        <div class="form-group control-width-normal">
                                                                            <div class="input-group date datepickerMe">
                                                                                <div class="input-group-content">
                                                                                    <label>Date of Birth</label>

                                                                                    <datepicker date-format="dd-MM-yyyy" date-max-limit="<?php echo date('Y-m-d') ?>">
                                                                                        <input ng-model="mainStaff.dob_date" type="text" class="form-control input-sm" ng-init="mainStaff.dob_date = '<?php echo date('d-m-Y'); ?>'"/>
                                                                                    </datepicker>


                                                                                </div>
                                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                            </div>
                                                                            <div class="form-group control-width-normal">
                                                                                <div class="input-group date datepickerMe" >
                                                                                    <div class="input-group-content">
                                                                                        <label>Date of Joining</label>
                                                                                        <datepicker date-format="dd-MM-yyyy" date-max-limit="<?php echo date('Y-m-d') ?>">
                                                                                            <input ng-model="mainStaff.date_of_joining" type="text" class="form-control input-sm" ng-init="mainStaff.date_of_joining = '<?php echo date('d-m-Y'); ?>'"/>
                                                                                        </datepicker>
                                                                                        <!--<input ng-model="mainStaff.date_of_joining" type="text" class="form-control">-->

                                                                                    </div>
                                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="select1">Status</label>
                                                                                <select ng-model="mainStaff.status" ng-app ng-init="mainStaff.status = 'NA3'" name="select1"  class="form-control">
                                                                                    <option  value="NA3">Select Status</option>
                                                                                    <option  value="ACTIVE">Active</option>
                                                                                    <option  value="DEACTIVE">Deactive</option>

                                                                                </select>

                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="textarea1">Address</label>
                                                                                <textarea ng-model="mainStaff.staff_add"  name="textarea1" id="textarea1" class="form-control" rows="3" placeholder="" >{{mainStaff.staff_add}}</textarea>


                                                                            </div>

                                                                    </form>
                                                                </div></div>
                                                            <div class="col-sm-4">
                                                                <div class="card-body" >
                                                                    <img  ng-show="myimageupld" style="height: 141px;margin-bottom: -5px;
                                                                          width: 161px;" ng-src="{{myimagepath}}" alt="">
                                                                    <img  ng-show="mainStaff.profile_pic_path" style="height: 141px;margin-bottom: -5px;
                                                                          width: 161px;" ng-src="{{mainStaff.profile_pic_path}}" alt="">
                                                                    <button type="button" data-toggle="modal" ng-click="<?php $random = mt_rand(1000,9999); ?>" data-target="#simpleModal" class="btn ink-reaction btn-raised btn-xs btn-primary">Upload Picture</button>
                                                                    <br><br>
                                                                    <p ng-click="saveStaffDetail(myForm.$error)" class="myProButtons" style="float: left"><button type="button" class="btn btn-block ink-reaction btn-info">{{myMode}}</button></p>
                                                                    <p ng-click="cancelStaff()" class="myProButtons" style="float: left"><button type="button" class="btn btn-block ink-reaction btn-danger">Cancel</button></p>
                                                                    <a ng-show="myMode == 'UPDATE'" class="btn btn-raised ink-reaction btn-accent-dark" href="#offcanvas-demo-color2" data-toggle="offcanvas" data-backdrop="true">Save Privilege</a>


                                                                </div><!-- .card-body -->

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div><!--end .card-body -->
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
<div ng-show="mainStaff != null" class="offcanvas">
    <div id="offcanvas-demo-color2" class="offcanvas-pane style-accent-dark width-8">
        <div class="offcanvas-head">


        </div>

        <div class="offcanvas-body">
            <form  role="form" class="form-horizontal">
                <a class="btn btn-block ink-reaction btn-info ng-binding" ng-click="savePriviledge()">Save Privilege</a>
                <lr ng-repeat="mainMenuObj in mainStaff.menuDetail">
                    <h3>{{$index + 1}}.{{mainMenuObj.menuname}}</h3>
                    <div class="form-group">
                        <div class="col-sm-9">
                            <div ng-repeat="childMenuObj in mainMenuObj.childDetail" class="checkbox checkbox-styled">
                                <label>
                                    <input ng-model="childMenuObj.selected" type="checkbox" value="">
                                    <span>{{childMenuObj.childcaption}}</span>
                                </label>
                            </div>

                        </div><!--end .col -->
                    </div><!--end .form-group -->

            </form>
        </div>
    </div>
</div>
</body>
</html>
<?php
$this->load->view('include/headjs');
?>
<script>
    (function ($, ng) {
        'use strict';
        var $val = $.fn.val; // save original jQuery function
        // override jQuery function
        $.fn.val = function (value) {
            // if getter, just return original
            if (!arguments.length) {
                return $val.call(this);
            }
            // get result of original function
            var result = $val.call(this, value);
            // trigger angular input (this[0] is the DOM object)
            ng.element(this[0]).triggerHandler('input');
            // return the original result
            return result;
        }
    })(window.jQuery, window.angular);
    var myURL = "<?php echo base_url(); ?>";
    var currentDate="<?php echo date('d-m-Y'); ?>";
</script>



<!--<script>

    $('.datepickerMe').datepicker({autoclose: true, todayHighlight: true, format: "dd-mm-yyyy"});
</script>-->
<script> var rand = <?php echo $random; ?> </script>
<script src="<?php echo base_url(); ?>/assets/myjs/managestaff.js?a=<?php echo rand(); ?>"></script>

