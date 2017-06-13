
<!DOCTYPE html>
<html lang="en">
    <title>
        student fees entry 
    </title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/autocomplete/angucomplete-alt.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/autocomplete/fonts/bariol/bariol.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote9fec.css?1422823374" />

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote9fec.css?1422823374" />

    <body class="menubar-hoverable header-fixed" ng-app="feesentry" ng-controller="feeentrycontrller" ng-cloak>
        <!--<body class="menubar-hoverable header-fixed ">-->
        <?php $this->load->view('include/header'); ?>
        <!-- BEGIN BASE-->
        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content">
                <!-- BEGIN SIMPLE MODAL MARKUP --> 
                <div class="modal fade" id="simpleModal"  role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true"> 
                    <div class="modal-dialog"> 
                        <div class="modal-content"> 
                            <div class="modal-header"> 
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
                                <h4 class="modal-title" id="simpleModalLabel">Fees Payment Mode </h4> 
                            </div> 
                            <div class="modal-body"> 
                                <div class="radio radio-styled">
                                    <label>
                                        <input type="radio" value="cash"  ng-init="pymnt = 'cash'" ng-model="pymnt" ng-checked="true" >
                                        <span>Cash</span>
                                    </label>
                                    <label>
                                        <input type="radio" value="cheque/dd"  ng-model="pymnt" >
                                        <span>DD/Cheque</span>
                                    </label>
                                </div>
                                <div class="row"  >
                                    <div class="form-group">
                                        <div class="col-sm-3">
                                            <label id="tooltip1" data-toggle="tooltip" data-placement="bottom" data-trigger ="hover" data-original-title="{{instNmne}}" class="control-label">Installmnt Amount</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" ng-model = "FinalBalAmt" id="tooltip1" data-toggle ="tooltip" data-placement="bottom" data-trigger ="hover" data-original-title="{{tootltipAmnt}}" class="form-control " readonly><div class="form-control-line"></div>

                                        </div>
                                    </div> 
                                </div>
                                <form name="paydetail" nonvalidate>
                                    <div class="row"  >
                                        <div class="form-group" >
                                            <div class="col-sm-3">
                                                <label  class="control-label">Paid Amount</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text"  ng-model="details.amount" ng-init="details.amount = ''" name="paidamnt" ng-pattern ="/^[0-9]{1,9}$/" class="form-control"  required><div class="form-control-line"></div>
                                                <span class="text-danger"  ng-show="paydetail.paidamnt.$error.pattern">please enter number only!</span>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="row" ng-hide="fine == 0" >
                                        <div class="form-group" >
                                            <div class="col-sm-3">
                                                <label  class="control-label">Fine</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" ng-model = "fine"  class="form-control"><div class="form-control-line"></div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="form-group" ng-show="pymnt == 'cheque/dd'" >
                                            <div class="col-sm-3">
                                                <label class="control-label">Bank Name</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" ng-model = "details.bankname"  class="form-control" ><div class="form-control-line"></div>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-show="pymnt == 'cheque/dd'"  >
                                            <div class="col-sm-3">
                                                <label  class="control-label">DD/cheque No.</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" ng-model="details.chequenumbr" ng-init="details.chequenumbr = ''" class="form-control" ><div class="form-control-line"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  >
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label  class="control-label">Date</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" ng-model="details.date" ng-init="details.date = '<?php echo date("d-m-Y"); ?>'" class="form-control" placeholder="Date"><div class="form-control-line"></div>
                                            </div>
                                        </div> 

                                    </div>
                                </form>

                            </div>
                            <div class="modal-footer"> 
                                <button type="button" class="btn btn-primary" ng-disabled="!paydetail.$valid" ng-click="SavePayDetails(index, StdntDetails.stdntDetail.adm_no, Insid, tempfine, FinalBalAmt)">pay</button> 
                            </div> 


                        </div><!-- /.modal-content --> 
                    </div><!-- /.modal-dialog --> 
                </div><!-- /.modal --> 
                <!-- END SIMPLE MODAL MARKUP -->


                <section>
                    <div class="section-body contain-lg">

                        <div class="section-body contain-lg">

                            <div class="col-sm-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs text-center">
                                        <header>STUDENT FEES ENTRY </header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="card card-outlined style-primary height-6">
                                                    <div class="card-body">

                                                        <form class="form-horizontal ng-valid ng-dirty" role="form">

                                                            <div class="form-group">
                                                                <label for="default14" class="col-sm-2 control-label">Search Student</label>
                                                                <div class="col-sm-5">
                                                                    <div  angucomplete-alt id="studentName" placeholder="Select student name" pause="50" selected-object="selectedStdntObj" remote-url="<?php echo base_url(); ?>index.php/staff/allstudentnamelist?studentname={{student.adm_no}}&search= " remote-url-data-field="results" title-field="firstname,lastname" minlength="1" input-class="form-control form-control-small width-5" match-class="highlight"> </div>
                                                                </div>
                                                            </div>

                                                        </form>

                                                    </div><!--end .card-body -->

                                                </div><!--end .card -->
                                            </div>
                                            <div class="col-lg-4" ng-show="stdnDetail == 'FALSE'">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card card-outlined style-primary">
                                                            <div class="card-body small-padding">
                                                                <img class="col-md-offset-4 img-circle width-2" src="<?php echo base_url(); ?>index.php/staff/getstudphoto/{{StdntDetails.stdntDetail.adm_no}}/THUMB" alt="">



                                                            </div><!--end .card-body -->
                                                            <div class="card-body height-3 small-padding style-primary-bright " >
                                                                <h4 class="ng-hide" >No data Found</h4>
                                                                <dl class="dl-horizontal" >
                                                                    <dt>Admission No:</dt>
                                                                    <dd>{{StdntDetails.stdntDetail.adm_no}}</dd>
                                                                    <dt>Student Name:</dt>
                                                                    <dd>{{StdntDetails.stdntDetail.firstname}} {{StdntDetails.stdntDetail.lastname}}</dd>
                                                                    <dt>Class:</dt>
                                                                    <dd>{{StdntDetails.stdntDetail.standard}} {{StdntDetails.stdntDetail.section}}</dd>
                                                                </dl>
                                                            </div><!--end .card-body -->
                                                        </div><!--end .card -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row margin-bottom-xxl"  ng-show="InstDet.length > 0">
                                            <div class="col-sm-12">
                                                <div class="col-sm-8">
                                                    <form name="digit" novalidate>
                                                        <table class="table table-bordered no-margin">
                                                            <thead>

                                                                <tr>
                                                                    <th>Sr.</th>
                                                                    <th>Inst.Name</th>
                                                                    <th>Date</th>
                                                                    <th>Inst.Amt</th>
                                                                    <th>Due date</th>
                                                                    <th>Last paid amt.</th>
                                                                    <th>Bal.Amt</th>
                                                                    <th>Action</th>


                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr ng-repeat="InstllmntDet in StdntDetails.instDeatil" >
                                                                    <td>{{$index + 1}}</td>
                                                                    <td>{{InstllmntDet.inst_name}}</td>
                                                                    <td>{{InstllmntDet.bill_raise_day|date:'dd-MMM,yyyy'}}</td>
                                                                    <td>{{InstllmntDet.ist_amt}}</td>
                                                                    <td>{{InstllmntDet.bill_due_day|date:'dd-MMM,yyyy'}}</td>
                                                                    <td>{{InstllmntDet.pay_amt}}</td>
                                                                    <td>{{InstllmntDet.balance}}</td>
                                                                    <td><a href="#" ng-disabled="InstllmntDet.pay_amt == 'Not paid Yet..!!'" ng-click="viewInstlmnt(StdntDetails.stdntDetail.adm_no, InstllmntDet.inst_name, InstllmntDet.ist_amt, InstllmntDet.id)" title="view"><i  class="md md-pageview"></i></a> <a  ng-hide="InstllmntDet.balance == 0 || InstllmntDet.date < -2"  ng-click="PayInstlmnt($index, InstllmntDet.balance, InstllmntDet.id, InstllmntDet.bill_due_day)"  title="Pay" href ="#simpleModal" data-target="#simpleModal" data-toggle="modal" ><i class="md md-payment"></i></a> </td>
                                                                </tr>


                                                            </tbody>
                                                        </table>

                                                    </form>
                                                </div>
                                                <div class="col-sm-4" ng-show="StdntDetails.fee_stracture.length > 1">
                                                    <div class="card">
                                                        <div class="card-head">
                                                            <header>Fee Structure</header>
                                                        </div>


                                                        <form name="digit" novalidate>
                                                            <table class="table table-bordered no-margin">
                                                                <thead>

                                                                    <tr>
                                                                        <th>Sr.</th>
                                                                        <th>FeesName</th>
                                                                        <th>Amount</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr ng-repeat="feeDetail in StdntDetails.fee_stracture" >
                                                                        <td>
                                                                            {{$index + 1}}

                                                                        </td>
                                                                        <td>{{feeDetail.head_name}}</td>

                                                                        <td>{{feeDetail.yearly_fee_amount}} </td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>

                                                        </form>

                                                    </div>

                                                </div>


                                            </div>
                                        </div>


                                        <div class="row" ng-show="showInstltable" >

                                            <div class="col-sm-12">
                                                <div class="col-sm-12">
                                                    <form name="digit" novalidate>
                                                        <table class="table table-bordered no-margin">
                                                            <thead>
                                                                </tr>
                                                                <tr>
                                                                    <th>Sr.</th>
                                                                    <th>Installment name</th>
                                                                    <th>Paid Date</th>
                                                                    <th>Payment Type</th>
                                                                    <th>Paid Amount</th>
                                                                    <th>Balance</th>
                                                                    <th>fee receipt</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr ng-repeat="viewInstlmnt in viewInstlDetls" >
                                                                    <td>{{$index + 1}}</td>
                                                                    <td>{{Instlname}}</td>
                                                                    <td>{{viewInstlmnt.paid_date|date:'dd-MMM,yyyy'}}</td>
                                                                    <td>{{viewInstlmnt.payment_mode}}</td>
                                                                    <td>{{viewInstlmnt.amount}}</td>
                                                                    <td>{{viewInstlmnt.balance}}</td>


                                                                    <td>6035</td>

                                                                </tr>







                                                            </tbody>
                                                        </table>

                                                    </form>
                                                </div>

                                            </div>

                                        </div>


                                    </div>


                                </div><!--end .card -->
                            </div><!--end .col -->


                        </div>
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


        <?php
        $this->load->view('include/headjs');
        ?>
        <script> var myURL = "<?php echo base_url(); ?>";</script>

        <script src="<?php echo base_url(); ?>assets/js/autocomplete/angucomplete-alt.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular-touch.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/myjs/feesmgmt/fees.js?v=<?php echo rand(); ?>"></script>




    </body>
</html>
