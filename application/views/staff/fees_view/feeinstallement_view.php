
<!DOCTYPE html>
<html lang="en">
    <title>
        Fees Installments 
    </title>
    <?php
    $this->load->view('include/headcss');
    ?>

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/summernote/summernote9fec.css?1422823374" />

    <body class="menubar-hoverable header-fixed " ng-app="feeinstlmnt" ng-controller="instlmntcontroller" ng-cloak ng-class="cloak">
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
                                            <header>Fees Installments</header>
                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright">
                                            <div class="row">
                                                <div class="card-body col-sm-12">
                                                    <form class="form">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <select  name="select1" class="form-control" ng-model="installmentname" ng-change="Selectinstllmnt" ng-init="installmentname = 'NA'">
                                                                    <option value="NA">Select Installement name </option>
                                                                    <?php foreach ($showname as $details) { ?>
                                                                        <option value='<?php echo $details['short_code'] ?>' ><?php echo $details['name'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <label for="select1">Installement name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3" ng-hide="installmentname == 'NA'"  >
                                                            <div class="form-group">
                                                                <select   name="select1" class="form-control" ng-model="billraisedate" ng-init="billraisedate = 'NA1'">
                                                                    <option value="NA1" >Select Bill raise day</option>
                                                                    <?php for ($i = 1; $i <= 31; $i++) { ?>
                                                                        <option value='<?php echo $i; ?>' ><?php echo $i; ?></option>
                                                                    <?php } ?>

                                                                </select>
                                                                <label for="select1">Bill raise day</label>
                                                            </div>

                                                        </div>
                                                        <div class="col-sm-3"  ng-hide="billraisedate == 'NA1'" >
                                                            <div class="form-group">
                                                                <select   name="select1" class="form-control" ng-model="billenddate" ng-init="billenddate = 'NA2'">
                                                                    <option value="NA2" >Select Bill day</option>
                                                                    <?php for ($i = 1; $i <= 31; $i++) { ?>
                                                                        <option value='<?php echo $i; ?>' ><?php echo $i; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <label for="select1">Bill end day</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2" ng-hide="billenddate == 'NA2'">
                                                            <div class="form-group"  >   
                                                                <p><button type="button" ng-click="proceed()" class="btn btn-block ink-reaction btn-primary" >Proceed</button></p>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="card body col-sm-12" ng-show="instllmntDetail.length >0">

                                                    <table class="table table-striped no-margin">
                                                        <thead>
                                                            <tr>
                                                                <th>Installement name</th>
                                                                <th>Bill raise day</th>
                                                                <th>Bill end day</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr ng-repeat="InstallmntObj in instllmntDetail">
                                                                <td>{{InstallmntObj.int_name}}</br>
                                                                    ({{InstallmntObj.month_list}})</td>

                                                                <td>{{InstallmntObj.billstart|date:'MMM d, y'}}</td>

                                                                <td>{{InstallmntObj.billend|date:'MMM d, y'}}</td>

                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="card-body col-sm-12" ng-show="instllmntDetail.length > 0"> 
                                                    <div class="col-sm-2" >
                                                        <div class="form-group" >   
                                                            <p><button type="button" class="btn btn-block ink-reaction btn-primary" ng-click="saveInstlmntDetail(installmentname)">SAVE</button></p>
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


        <?php
        $this->load->view('include/headjs');
        ?>
        <script>
            var myURL = "<?php echo base_url(); ?>";
        </script>

        <script src="<?php echo base_url(); ?>assets/myjs/feesmgmt/fees.js?v=<?php echo rand(); ?>"></script>


    </body>
</html>
