
<!DOCTYPE html>
<html lang="en">
    <title>Send SMS</title>
    <?php
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
    <body class="menubar-hoverable header-fixed " ng-app="sms" ng-controller="smsController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs style-primary">
                                        <header><i class="fa fa-fw fa-tag"></i>Send SMS</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="row text-center">

                                                        <p class="myProButtons"  style="float: left"><button ng-click="type = 'STAFF';smsContent=true;" type="button" class="btn btn-block ink-reaction " ng-class="type=='STAFF'?'btn-info':''">Send SMS to Staff</button></p>
                                                        <p class="myProButtons"  style="float: left"><button ng-click="type = 'STUDENT';smsContent=true;" type="button" class="btn btn-block ink-reaction " ng-class="type=='STUDENT'?'btn-info':''">Send SMS To Parent</button></p>

                                                    </div><!--end .row -->
                                                </div>
                                            </div><!--end .card-body -->
                                        </div>
                                        <div class='row'>
                                            <div class="col-md-8" ng-show="smsContent">
                                                <div class="card">
                                                   <div class="card-head card-head-xs style-gray-light">
                                                        <header>SMS Content</header>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <textarea maxlength="160" name="message" ng-model="message" class="form-control control-6-rows"  spellcheck="false"></textarea>
                                                            </div><!--end .form-group -->
                                                            <span ><b>{{160 - message.length}}</b> Character Remaining </span>
                                                            <br>
                                                            <span >Total <b> {{getCheckedMemberCount() + ' '}} </b> Selected to send SMS.</span>
                                                        </div>
                                                        <p class="myProButtons"><button ng-disabled="getCheckedMemberCount() == 0 || message.length == 0" ng-click="smsSend()" type="button" class="btn btn-sm ink-reaction btn-info">Send</button></p>
                                                        <p class="myProButtons"><button ng-click="cancelMessage()" type="button" class="btn btn-sm ink-reaction btn-danger">Cancel</button></p>
                                                    </div><!--end .card-body -->
                                                </div>
                                            </div> 
                                            <div class="col-md-4" ng-show="type == 'STUDENT'" >
                                                <div class="card">
                                                    <div class="card tabs-left style-default-light">
                                                        <div style="margin: 0px" class="form-group floating-label">
                                                            <select ng-model="sectionId" ng-change="getStudentList()"  name="select2" class="form-control">
                                                                <option value="0">Select Class</option>
                                                                <option ng-repeat="mySection in mySectionList"value="{{mySection.id}}">{{mySection.standard + ' ' + mySection.section}}</option>
                                                            </select>

                                                        </div>
                                                        <form  style="width:100%" class="navbar-search expanded" role="search">
                                                            <div class="form-group">
                                                                <input type="text" ng-model="mySearchInput"  class="form-control" name="contactSearch" placeholder="Enter your keyword">
                                                            </div>
                                                            <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                                                        </form>
                                                        <ul style="height: 300px;overflow: auto" class="list ui-sortable" data-sortable="true">
                                                            <li class="tile ui-sortable-handle" ng-show="sectionId != 0">
                                                                <div class="checkbox checkbox-styled tile-text">
                                                                    <label>
                                                                        <input ng-model="selectAll" ng-click="smsSendAllParent()" type="checkbox" >
                                                                        <span>
                                                                            Select All
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <li class="tile ui-sortable-handle" ng-repeat="myAllStudentList in myStudentList| filter:mySearchInput" >
                                                                <div class="checkbox checkbox-styled tile-text">
                                                                    <label>
                                                                        <input ng-model="myAllStudentList.smsSend" type="checkbox">
                                                                        <span style="padding-left: 25px">
                                                                            <img style="width: 25px" class=" width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{myAllStudentList.adm_no}}/THUMB"; ?>" alt="">
                                                                            <a href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{myAllStudentList.adm_no}}">{{ myAllStudentList.adm_no + ' . ' + myAllStudentList.firstname + ' ' + myAllStudentList.lastname}}</a>
                                                                        </span>
                                                                    </label>
                                                                </div>

                                                            </li>
                                                        </ul>
                                                    </div><!--end .card-body -->

                                                </div><!--end .card -->
                                            </div>
                                            <div class="col-md-4" ng-show="type == 'STAFF'">
                                                <div class="card">
                                                    <div class="card tabs-left style-default-light">                                                       
                                                        <form  style="width:100%" class="navbar-search expanded" role="search">
                                                            <div class="form-group">
                                                                <input type="text" ng-model="mySearchInput"  class="form-control" name="contactSearch" placeholder="Enter your keyword">
                                                            </div>
                                                            <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                                                        </form>
                                                        <ul style="height: 300px;overflow: auto" class="list ui-sortable" data-sortable="true">

                                                            <li class="tile ui-sortable-handle">
                                                                <div class="checkbox checkbox-styled tile-text">
                                                                    <label>
                                                                        <input ng-model="selectAllStaff" ng-click="smsSendAllStaff()" type="checkbox" >
                                                                        <span>
                                                                            Select All
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <li class="tile ui-sortable-handle" ng-repeat="myAllStaffList in myStaffList| filter:mySearchInput">
                                                                <div class="checkbox checkbox-styled tile-text">
                                                                    <label>
                                                                        <input ng-model="myAllStaffList.smsSend" type="checkbox" >
                                                                        <span style="padding-left: 25px">
                                                                            <img style="width: 25px" class=" width-1" src="<?php echo base_url() . "index.php/staff/getphoto/" . "{{myAllStaffList.id}}" . "/THUMB"; ?>" alt="">
                                                                            {{ myAllStaffList.staff_fname + '  ' + myAllStaffList.staff_lname}}
                                                                        </span>
                                                                    </label>
                                                                </div>

                                                            </li>
                                                        </ul>

                                                    </div><!--end .card-body -->

                                                </div><!--end .card -->
                                            </div>

                                        </div>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->


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
        var myURL = "<?php echo base_url(); ?>";

    </script>
    <script src="<?php echo base_url(); ?>/assets/myjs/sms.js?v=<?php echo rand(); ?>"></script>
    <script src="<?php echo base_url(); ?>/assets/myjs/managestaff.js?v=<?php echo rand(); ?>"></script>
