<?php
$s_code = $this->session->userdata('school_code');
$sessionyear = str_replace("-", "_", '2014-2015'); //$this->session->userdata('session_year');
?>
<!DOCTYPE html>
<html lang="en">
    <title>Student Entry</title>
    <?php $this->load->view('include/headcss'); ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style>
        label.myLabel input[type="file"] {
            position: fixed;
            top: -1000px;
        }
        body {
            font-size: 12px;
            font-family: Helvetica, Arial;
            background: white;
            margin: 0;
            padding: 0;

        }
        /*        a {
                    text-decoration: underline;
                    color: blue;
                    cursor: pointer;
                }*/
        hr {
            border: none;
            height: 1px;
            width: 80%;
            background: rgba(0,0,0,.3);
            margin: 40px auto;
        }
        .result-datauri {
            width: 300px;
            height: 100px;
            font-size: 11px;
            line-height: 15px;
            padding: 5px;
            border: 1px solid black;
            clear: both;
            display: block;
            margin: 20px auto;
        }
    </style>

    <body class="menubar-hoverable header-fixed ">
        <!-- BEGIN HEADER-->
        <?php $this->load->view('include/header'); ?>

        <!-- END HEADER-->
        <!-- BEGIN BASE-->
        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content">
                <!--<form name="myform">-->
                <section>
                    <div class="section-body contain-lg">
                        <!-- BEGIN FORM WIZARD -->
                        <div class="row">
                            <!-- BEGIN LAYOUT RIGHT ALIGNED -->

                            <div class="col-md-12" ng-app="StudentProfile"  ng-controller="BasicProfile" ng-cloak>
                                <div class="card card-underline">
                                    <div  class="modal fade" id="simpleModal" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" ng-click="imageDataURI = ''" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="simpleModalLabel">Upload image</h4>
                                                </div>
                                                <div class="modal-body height-8" >
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

                                    <div class="card-head">
                                        <ul class="nav nav-tabs pull-right" ng-hide="type == 'NEW'" data-toggle="tabs">
                                            <li class="active"><a href="#first2">GENERAL</a></li>
                                            <?php if ($type == 'UPDATE') { ?>
                                                <li><a href="#second2">GUARDIAN</a></li>
                                                <li><a href="#third2">MEDICAL</a></li>
                                                <li><a href="#" ng-click="getFeesDetail(data.basicdata.adm_no)">FEES DETAILS</a></li>
                                            <?php } ?>
                                            <!--                                            <li><a href="#third2">ACADEMIC</a></li>
                                                                                        <li><a href="#third2">LOGIN</a></li>-->
                                        </ul>
                                        <header >{{type == 'NEW'? 'New Admission' : data.basicdata.adm_no + "." + data.basicdata.firstname + " " + data.basicdata.lastname}}</header>
                                    </div>
                                    <div class="card-body tab-content">
                                        <div class="tab-pane active" id="first2">
                                            <div class="row">
                                                <form name="bacsicForm" novalidate>
                                                    <div class="col-sm-3 text-center"  >
                                                        <img  ng-src="{{data.basicdata.profile_pic_path}}" style="width: 200px; height: 200px; margin:10px;">
                                                        <button class="btn btn-danger" data-toggle="modal" data-target="#simpleModal">Upload</button>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="form floating-label">
                                                            <div class="row">
                                                                <div class="col-sm-2">
                                                                    <div class="form-group">
                                                                        <input ng-model="data.basicdata.adm_no" type="text" class="form-control input-sm" readonly>
                                                                        <label for="City" class="control-label">Admission No</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <input ng-model="data.basicdata.firstname" ng-pattern="/^[a-zA-Z_]+( [a-zA-Z_]+)*$/" type="text" class="form-control input-sm" required>
                                                                        <label for="State" class="control-label">First Name<span class="text-danger">*</span></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <input ng-model="data.basicdata.middlename" ng-pattern="/^[a-zA-Z_]+( [a-zA-Z_]+)*$/" type="text"  class="form-control input-sm" >
                                                                        <label for="State" class="control-label">Middle Name</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <input ng-model="data.basicdata.lastname" ng-pattern="/^[a-zA-Z_]+( [a-zA-Z_]+)*$/" type="text" class="form-control input-sm">
                                                                        <label for="State" class="control-label">Last Name</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <div class="col-sm-12">
                                                                                <label class="radio-inline radio-styled radio-primary">
                                                                                    <input ng-init="data.basicdata.sex = 'M'" type="radio" name="sex" value="M" ng-model="data.basicdata.sex"><span>Male</span>
                                                                                </label>
                                                                                <label class="radio-inline radio-styled radio-primary">
                                                                                    <input type="radio" name="sex" value="F" ng-model="data.basicdata.sex"><span>Female</span>
                                                                                </label>
                                                                            </div><!--end .col -->
                                                                        </div><!--end .form-group -->
                                                                    </div>
                                                                </div><!--end .form-group -->
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <datepicker date-format="dd-MM-yyyy">
                                                                            <input type="text" class="form-control input-sm" ng-model="data.basicdata.dob_date" ng-init="data.basicdata.dob_date = '<?php echo date('d-m-Y'); ?>'" readonly/>
                                                                        </datepicker>
                                                                        <label for="State" class="control-label">Date of Birth</label>
                                                                        <div class="text-danger" ng-show="date('d-m-Y', strtotime(data.basicdata.dob_date)) > data.basicdata.ad_date">Wrong Entry</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <datepicker date-format="dd-MM-yyyy">
                                                                            <input type="text" class="form-control input-sm" ng-model="data.basicdata.ad_date" ng-init="data.basicdata.ad_date = '<?php echo date('d-m-Y'); ?>'" readonly/>
                                                                        </datepicker>
                                                                        <label for="State" class="control-label">Date of Admission</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <input type="email" name="e_mail" ng-model="data.basicdata.e_mail" class="form-control input-sm" required>
                                                                        <span class="text-danger" ng-show="bacsicForm.$error.email">Not a valid email!</span>
                                                                        <label for="State" class="control-label">Email ID<span class="text-danger">*</span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <input type="text" ng-model="data.basicdata.address1" class="form-control input-sm">
                                                                        <label for="State" class="control-label">Address Line 1</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <input type="text" ng-model="data.basicdata.address2" class="form-control input-sm">
                                                                        <label for="State" class="control-label">Address Line 2</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <input type="text" ng-model="data.basicdata.city" name="city" class="form-control input-sm" required>
                                                                        <label for="State" class="control-label">City<span class="text-danger">*</span></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <input type="text" ng-model="data.basicdata.state" class="form-control input-sm">
                                                                        <label for="State" class="control-label">State</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">

                                                                    <div class="form-group">
                                                                        <input type="text" ng-model="data.basicdata.pin_code" name="pin_code" class="form-control input-sm" ng-init="data.basicdata.pin_code = ''" ng-pattern="/^[0-9 \s]+$/" maxlength="6" minlength="6" required>
                                                                        <span ng-show="data.basicdata.pin_code != ''"><span class="text-danger" ng-show="data.basicdata.pin_code.length != 6">Not a valid pincode!</span></span>
                                                                        <label for="State" class="control-label">Pincode<span class="text-danger">*</span></label>
                                                                    </div>

                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <input type="text" ng-init="data.basicdata.country = 'India'" ng-model="data.basicdata.country" class="form-control input-sm">
                                                                        <label for="State" class="control-label">Country</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="row pull-right">
                                                    <button ng-click="cancel()"class="btn ink-reaction btn-danger" type="button">Cancel</button>
                                                    <button  ng-click="saveData()" ng-disabled="!bacsicForm.$valid"  class="btn ink-reaction btn-primary" type="button">Save </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="second2">
                                            <div class="row">
                                                <form name="relationForm" >
                                                    <div class="col-sm-3">
                                                        <ul class="nav nav-pills nav-stacked">
                                                            <li ng-repeat="relation in data.relations" ng-click="selectedRelation($index)" ng-class="{active: $index == selected}">
                                                                <a href="javascript:void(0)">{{ relation.relation | uppercase }}</a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="col-sm-9">
                                                        <div class="form floating-label hide" ng-repeat="relationObj in data.relations" ng-class="{show: $index == selected}">

                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group" ng-class="relationForm['g_name' + {{$index}} ].$error.pattern == true?'has-error':''">
                                                                        <input type="text" name="g_name{{$index}}" ng-model="relationObj.g_name" ng-pattern="/^[a-zA-Z_]+( [a-zA-Z_]+)*$/" class="form-control input-sm" ng-required="{{relationObj.validation}}" >
                                                                        <label for="City" class="control-label">Name<span class="text-danger" ng-if="relationObj.validation === 'required'">*</span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <input type="text" name="g_quali{{$index}}" ng-model="relationObj.g_quali" class="form-control input-sm">
                                                                        <label for="State" class="control-label">Qualification</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <input type="text"  name="g_occp{{$index}}" ng-model="relationObj.g_occp"  class="form-control input-sm">
                                                                        <label for="State" class="control-label">Occupation</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <input type="text"  name="g_desig{{$index}}" ng-model="relationObj.g_desig"  class="form-control input-sm">
                                                                        <label for="State" class="control-label">Designation</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <input type="text" name="g_dept{{$index}}" ng-model="relationObj.g_dept"  class="form-control input-sm">
                                                                        <label for="State" class="control-label">Department</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <textarea type="text" name="g_home_add{{$index}}" ng-model="relationObj.g_home_add"  class="form-control input-sm"></textarea>
                                                                        <label for="State" class="control-label">Home Address</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <textarea type="text" name="g_office_add{{$index}}" ng-model="relationObj.g_office_add"  class="form-control input-sm"></textarea>
                                                                        <label for="State" class="control-label">Office Address</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group" ng-class="relationForm['g_mob' + {{$index}} ].$error.pattern == true?'has-error':''" >
                                                                        <input type="text" name="g_mob{{$index}}" ng-pattern="/^[0-9]+$/" ng-model="relationObj.g_mob" maxlength="10" minlength="10"  class="form-control input-sm" ng-required="{{relationObj.validation}}">
                                                                        <label for="State" class="control-label">Mobile No<span class="text-danger" ng-if="relationObj.validation === 'required'">*</span></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <input type="email" name="g_mail{{$index}}" ng-model="relationObj.g_mail"  class="form-control input-sm">
                                                                        <label for="State" class="control-label">Email ID</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="row">
                                                    <div class="pull-left"> <label class="margin-50"><h4 class="h1-blue">Father & Mother fields are mandatory<span class="text-danger">*</span></h4></label></div>
                                                   <div class="pull-right">
                                                    <button ng-click="cancel()"class="btn ink-reaction btn-danger" type="button">Cancel</button>
                                                    <button id="cmdSave" ng-click="saveData()" ng-disabled="!relationForm.$valid || data.relations[0].g_name == '' || data.relations[1].g_name == '' || data.relations[0].g_mob == '' || data.relations[1].g_mob == ''"  class="btn ink-reaction btn-primary" type="button">Update</button>
                                                    
                                                   </div>
                                                 </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="third2">
                                            <div class="form floating-label">
                                                <div class="row">
                                                    <form name="medicalForm">
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <select ng-model="data.medical.blood_group" ng-init="data.medical.blood_group = ''" class="form-control input-sm">
                                                                    <option value="">Select Group</option>
                                                                    <?php
                                                                    $bloodGrp = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');
                                                                    foreach ($bloodGrp as $row) {
                                                                        ?>
                                                                        <option  value="<?php echo $row; ?>" ng-selected="data.medical.blood_group === '<?php echo $row; ?>'"><?php echo $row; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <label>Blood Group</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="text" ng-model="data.medical.height" ng-pattern="/^[0-9]{1,7}(\.[0-9]+)?$/" class="form-control input-sm">
                                                                <label for="City" class="control-label">Height<span class="text-danger">*</span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="text" ng-model="data.medical.weight" ng-pattern="/^[0-9]{1,7}(\.[0-9]+)?$/" class="form-control input-sm">
                                                                <label class="control-label">Weight<span class="text-danger">*</span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="text" ng-model="data.medical.teeth" ng-pattern="/^[0-9]{1,7}$/" class="form-control input-sm">
                                                                <label class="control-label">Teeth</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="text" ng-model="data.medical.vision_left" ng-pattern="/^[0-9]{1,7}(\.[0-9]+)?$/" class="form-control input-sm">
                                                                <label class="control-label">Vision Left</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="text" ng-model="data.medical.vision_right" ng-pattern="/^[0-9]{1,7}(\.[0-9]+)?$/" class="form-control input-sm">
                                                                <label class="control-label">Vision Right</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="text" ng-model="data.medical.hygiene" ng-pattern="/^[0-9]{1,7}$/" class="form-control input-sm">
                                                                <label class="control-label">Hygiene</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="text" ng-model="data.medical.allergies" ng-pattern="/^[0-9]{1,7}$/" class="form-control input-sm">
                                                                <label class="control-label">Allergies</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="text" ng-model="data.medical.medication" class="form-control input-sm">
                                                                <label class="control-label">Medication</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="text" ng-model="data.medical.physician_name" class="form-control input-sm">
                                                                <label class="control-label">Physician Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="text" ng-model="data.medical.physician_phone" ng-pattern="/^[0-9]{10,10}$/" class="form-control input-sm">
                                                                <label class="control-label">Physician Contact<span class="text-danger">*</span></label>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="row">
                                                    <div class="row pull-right">
                                                        <button ng-click="cancel()"class="btn ink-reaction btn-danger" type="button">Cancel</button>
                                                        <button id="cmdSave" ng-click="saveData()" ng-disabled="!medicalForm.$valid || data.medical.height == ''|| data.medical.weight == ''|| data.medical.physician_phone==''" class="btn ink-reaction btn-primary" type="button">Update</button>
                                                    </div>
                                                </div>                                              
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end .card -->

                            </div><!--end .col -->
                            <!-- END LAYOUT RIGHT ALIGNED -->
                        </div><!--end .row -->
                        <!-- END FORM WIZARD -->
                    </div><!--end .section-body -->
                </section>
            </div><!--end #content-->		
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
                    <!-- BEGIN MAIN MENU -->
                    <?php $this->load->view('include/menu'); ?>
                    <!--end .main-menu -->
                    <!-- END MAIN MENU -->
                </div><!--end .menubar-scroll-panel-->
            </div><!--end #menubar-->
            <!-- END BASE -->
            <!-- BEGIN JAVASCRIPT -->
        </div>
        <?php
        $this->load->view('include/headjs');
        ?>
        <script>
            var admno = "<?php echo $admno; ?>";
            var school = "<?php echo $s_code; ?>";
            var type = "<?php echo $type; ?>";
            var sessionyear = "<?php echo $sessionyear; ?>";
            var base_url = "<?php echo base_url(); ?>";
        </script>
        <script src="<?php echo base_url(); ?>assets/myjs/studentprofile.js?v=<?php echo rand(); ?>"></script>
    </body>
</html>