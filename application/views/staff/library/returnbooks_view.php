<!DOCTYPE html>
<html lang="en">
    <title>Return Book</title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style type="text/css">
        @media (min-width: 769px) {
            .dl-horizontal-custom dt {
                float: left;
                width: 100px;
                clear: left;
                text-align: left;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .dl-horizontal-custom dd {
                margin-left: 120px;
            }
        }
    </style>
    <body class="menubar-hoverable header-fixed " ng-class="cloak" ng-app="ReturnBook" ng-controller="ReturnBookController" ng-cloak>
        <?php $this->load->view('include/header');
        ?>
        <script>
                    var adm_no = '<?php echo $adm_no; ?>';
                    var StudentData = '<?php echo json_encode($studentBookDetail); ?>';
                    var FineData = '<?php echo json_encode($finedata); ?>';
        </script>
        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="card">
                                    <div class="card-head card-head-xs style-primary">
                                        <header>Return Book</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-12">
                                                    <div class="card card-outlined style-primary">
                                                        <div class="card-body">                                                        
                                                            <form class="form-horizontal" role="form">
                                                                <div class="form-group">
                                                                    <label for="default14" class="col-sm-1 control-label" style=" white-space: nowrap" >Admission No</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" class="form-control" id="default14" placeholder="Admission No" ng-model="admno" ng-model-onblur  ng-change="studentinfo(admno)">
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <h4  class="small-padding" ng-show="bookinfo == -1">No Entry Found</h4>
                                                    <div class="card card-outlined style-primary" ng-show="bookinfo != -1 && bookinfo != ''">
                                                        <div class="card-body small-padding  height-8 scroll">
                                                            <table class="table table-striped no-margin table-condensed table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Book No</th>
                                                                        <th>Book Name</th>
                                                                        <th>Issued Date</th>
                                                                        <th>Due Date</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr ng-repeat=" books in bookinfo">
                                                                        <td>{{$index + 1}}</td>
                                                                        <td>{{books.book_id}}</td>
                                                                        <td>{{books.book_name}}</td>
                                                                        <td>{{books.issue_date}}</td>
                                                                        <td>{{books.due_date}}</td>
                                                                        <td><button  class="btn ink-reaction btn-raised btn-xs btn-primary" type="button" ng-click="returnbook(books)">Return</button></td>

                                                                    </tr>
                                                                </tbody>
                                                            </table>  
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4" ng-show="returndiv == 'true'">
                                                    <div class="card card-outlined style-primary">

                                                        <div class="card-body">
                                                            <div class="form-horizontal" role="form">
                                                                <div class="form-group">
                                                                    <label for="disabled15" class="col-sm-4 control-label">Book No.</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" id="disabled15" placeholder="Book No." disabled="" ng-model="mybookdetail.book_id"><div class="form-control-line"></div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="disabled15" class="col-sm-4 control-label">Book Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="disabled15" placeholder="Book Name" disabled="" ng-model="mybookdetail.book_name"><div class="form-control-line"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="disabled15" class="col-sm-4 control-label">Issue Date </label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="disabled15" placeholder="Issue Date" disabled="" ng-model="mybookdetail.issue_date"><div class="form-control-line"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="disabled15" class="col-sm-4 control-label">Due Date </label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="disabled15" placeholder="Due Date" disabled="" ng-model="mybookdetail.due_date"><div class="form-control-line"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="Firstname5" class="col-sm-4 control-label"> Late Fine</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" id="Firstname5" placeholder="Late Fine"  ng-model="mybookdetail.fine_amount" > <span class="text-danger">*Fine calculated as Due Days  ({{finedetail.due_days + ' days * ' + ' &#8377;' + finedetail.fine_per_day}})</span><div class="form-control-line"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="Firstname5" class="col-sm-4 control-label"> Return Type</label>
                                                                        <div class="col-sm-8">


                                                                            <label class="radio-inline radio-styled">
                                                                                <input type="radio" name="ReturnType" checked="" ng-model="mybookdetail.returntype" ng-value=0 ng-init="mybookdetail.returntype = '0'"><span>Return</span>
                                                                            </label>
                                                                            <label class="radio-inline radio-styled">
                                                                                <input type="radio" name="ReturnType" ng-model="mybookdetail.returntype" value=1><span>Lost</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="groupcheckbox17" class="col-sm-4 control-label">Other Charges</label>
                                                                        <div class="col-sm-8">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">
                                                                                    <input type="checkbox" ng-model="extracharges" >
                                                                                </span>
                                                                                <div class="input-group-content">

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6" ng-show="extracharges == true">
                                                                        <div class="form-group">
                                                                            <label for="Firstname5" class="col-sm-4 control-label">Reason</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="Firstname5" placeholder="Reason"  ng-model="mybookdetail.reason"><div class="form-control-line"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6" ng-show="extracharges == true">
                                                                        <div class="form-group">
                                                                            <label for="Firstname5" class="col-sm-4 control-label">Amount</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="Firstname5"  placeholder="Amount" ng-model="mybookdetail.extraamount"><div class="form-control-line"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div><!--end .card-body -->
                                                            <div class="card-actionbar">
                                                                <div class="card-actionbar-row">
                                                                    <button type="submit" class="btn btn-flat btn-primary ink-reaction" ng-click="savechangebook()">Save </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--                                                    <div class="card-actionbar">
                                                                                                            <div class="card-actionbar-row">
                                                                                                                <button class="btn btn-primary" data-toggle="modal" data-target="#simpleModal" data-backdrop="static">Return</button>
                                                                                                            </div>
                                                                                                        </div>-->
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div><!--end .card-body -->
                            </div><!--end .card -->
                            <div class="col-lg-12 col-sm-12" ng-show="recentlyissuedbook.length > 0">
                                <div class="card">
                                    <div class="card-head card-head-xs style-primary">
                                        <header>Recently Return Book Details</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding  height-10">
                                        <table class="table table-striped no-margin table-condensed table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Return By</th>
                                                    <th>Book Title</th>
                                                    <th>Return Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat=" issue in recentlyissuedbook">

                                                    <td>{{$index + 1}}</td>
                                                    <td><a class="tile-content ink ink-reaction" href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{issue.adm_no}}">{{issue.name}}</a></td>
                                                    <td>{{issue.book_name}}</td>
                                                    <td>{{issue.return_date}}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                        </div><!--end .col -->

                    </div>
                    <!--<div class="row">-->


                    <!--</div>-->
            </div>
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
<script> var myURL = "<?php echo base_url(); ?>";</script>

<script src="<?php echo base_url(); ?>assets/myjs/library/library.js"></script>
<script>
    function changeURL(element) {
        if (element.value == '') {
        } else {
            window.location = "<?php echo base_url(); ?>index.php/staff/returnbooks/" + element.value;
        }
    }
</script>
</body>
</html>
