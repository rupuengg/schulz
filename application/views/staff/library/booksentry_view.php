<!DOCTYPE html>
<html lang="en">
    <title>Books Entry</title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/angucomplete.css">
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
    <body class="menubar-hoverable header-fixed " ng-app="librarySystem" ng-controller="librarySystemController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content" >
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-lg-12">
                                <div  class="form-group" class="col-lg-12" >
                                    <angucomplete id="book_no"
                                                  placeholder="Search Book"
                                                  pause="20"
                                                  selectedobject="book"
                                                  myCustomScope="myCustomScope"
                                                  url="<?php echo base_url(); ?>index.php/staff/searchbooks?search= "
                                                  datafield="results"
                                                  titlefield="book_name"
                                                  inputclass="form-control form-control-small"/>
                                </div>
                            </div>

                            <!--                            <form class="navbar-search ng-valid ng-dirty ng-valid-parse" role="search">
                            
                                                            <div class="form-group">
                                                                <input ng-model="mySearchInput" class="form-control ng-valid ng-touched ng-dirty ng-valid-parse" name="bookSearch" placeholder="Enter a book name" type="text">
                                                            </div>
                                                            <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                                                        </form>-->

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-head card-head-xs style-primary">
                                        <header>Books entry </header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card card-outlined style-primary height-10">
                                                    <!--                                                    <div class="card-head card-head-xs style-primary">
                                                                                                            <header>Add Books </header>
                                                                                                        </div>end .card-head -->
                                                    <div class="card-body ">
                                                        <form class="form-horizontal" name="myForm" role="form" novalidate>

                                                            <input type="hidden" class="form-control" id="regular13 "  ng-model="book.originalObject.bookdetails.id" >

                                                            <div class="form-group">
                                                                <label for="regular13" class="col-sm-2 control-label">Book No.</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" id="regular13 " ng-model="book.originalObject.book_no" name="bookname" >
                                                                </div>

                                                            </div>

                                                            <div class="form-group">
                                                                <label for="regular13" class="col-sm-2 control-label">Book Name</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" id="regular13" ng-model="book.originalObject.book_name">
                                                                </div>

                                                            </div>
                                                            <div class="form-group">
                                                                <label for="regular13" class="col-sm-2 control-label">Author Name</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"  class="form-control" id="regular13" ng-model="book.originalObject.author_name">
                                                                </div>

                                                            </div>

                                                            <div class="form-group">
                                                                <label for="regular13" class="col-sm-2 control-label">Publisher</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"  class="form-control" id="regular13" ng-model="book.originalObject.publisher">
                                                                </div>

                                                            </div>
                                                            <div class="form-group">
                                                                <label for="regular13" class="col-sm-2 control-label">Quantity</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"  class="form-control" id="regular13" ng-model="book.originalObject.quantity">
                                                                </div>

                                                            </div>

                                                            <div class="form-group" >
                                                                <label for="select13" class="col-sm-2 control-label">Category</label>
                                                                <div class="col-sm-9">
                                                                    <select id="select1" name="select1" class="form-control" ng-model="book.originalObject.category" ng-init="book.originalObject.category = 'Select Category'" >
                                                                        <option value="Select Category">Select Category</option>
                                                                        <option value="Text Books">Text Books</option>
                                                                        <option value="Journals">Journals</option>
                                                                        <option value="Newspaper">Newspaper</option>
                                                                        <option value="Magazines">Magazines</option>

                                                                    </select>
                                                                </div>

                                                            </div>
                                                        </form> 
                                                        <div class="card-actionbar">
                                                            <div class="card-actionbar-row">
                                                                <button class="btn btn-sm btn-primary ink-reaction" ng-click="savebook(book.originalObject)" ng-hide="book.originalObject.searchdata.length > 0">Add</button>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6" ng-show="book.originalObject.searchdata.length > 0">
                                                <div class="card card-outlined style-primary height-10">
                                                    <div class="card-head card-head-xs style-primary ">
                                                        <header>Searched Books Details</header>
                                                    </div><!--end .card-head -->
                                                    <div class="card-body">
                                                        <form class="form-horizontal" name="myForm" role="form" novalidate>
                                                            <div class="form-group">
                                                                <!--<div class="col-sm-8">-->
                                                                <div class="col-sm-12">
                                                                    <label class="col-sm-3 radio-inline radio-styled">
                                                                        <input type="radio" name="QuantityType"  ng-model="addquantity" ng-value="1" ng-init="addquantity = 1"><span>Add</span>
                                                                    </label>
                                                                    <label class="col-sm-3 radio-inline radio-styled">
                                                                        <input type="radio" name="QuantityType" ng-model="addquantity" ng-value="0" ><span>Deduce</span>
                                                                    </label>
                                                                    <div class="form-group">
                                                                        <div class="col-sm-5">
                                                                            <input type="text" class="form-control" name="QuantityType" ng-model="quantity" placeholder="Quantity">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <!--<label for="Quantity" class="col-sm-3 control-label">Quantity</label>-->
                                                                        <div class="col-sm-5">
                                                                            <input type="text" class="form-control" name="QuantityType" ng-model="reason" placeholder="Reason" ng-model="reason">
                                                                        </div>
                                                                        <div class="col-sm-5">
                                                                            <div class="input-group date" id="demo-date">
                                                                                <datepicker date-format="yyyy-MM-dd">
                                                                                    <input type="text" class="form-control" placeholder="Date" ng-model="update_date" />
                                                                                </datepicker>
                                                                                <i class="fa fa-calendar pull-right"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <button class="btn btn-sm btn-primary ink-reaction " ng-click="update(book.originalObject.id, quantity, update_date, reason)">Save</button>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>        
                                                        </form> 
                                                        <div class=" height-5" ng-show="book.originalObject.searchdata!='-1'" style="overflow:scroll; overflow-x: hidden">
                                                            <table class="table table-striped no-margin table-hover">
                                                                <thead>
                                                                    <tr >
                                                                        <th >Book No.</th>
                                                                        <th>Book Name</th>
                                                                        <th>No.of Copies</th>
                                                                        <th>Entry Date</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr ng-repeat="searchObj in book.originalObject.searchdata">
                                                                        <td>{{book.originalObject.book_no}}</td>
                                                                        <td>{{book.originalObject.book_name}}</td>
                                                                        <td>{{searchObj.quantity}}</td>
                                                                        <td>{{searchObj.date}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <span class="text-danger card-foot">Note:( - )sign shows deduction of books </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end .card-body -->

                                        </div>

                                    </div>
                                </div><!--end .card-body -->
                            </div><!--end .card -->
                        </div><!--end .col -->
                        <div class="row">
                            <div class="col-lg-12" >
                                <div class="card card-outlined style-primary height-10">
                                    <div class="card-head card-head-xs style-primary ">
                                        <header>Recently Added Books</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body height-10  scroll">

                                        <div class=" height-8 scroll">
                                            <table class="table table-striped no-margin table-hover">
                                                <thead>
                                                    <tr >
                                                        <th >Book No.</th>
                                                        <th>Book Name</th>
                                                        <th>Author Name</th>
                                                        <th>Publisher</th>
                                                        <th>No.of Copies</th>
                                                        <th>Category</th></tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="books in bookdata">
                                                        <td>{{books.book_no}}</td>
                                                        <td>{{books.book_name}}</td>
                                                        <td>{{books.author_name}}</td>
                                                        <td>{{books.publisher}}</td>
                                                        <td>{{books.quantity}}</td>
                                                        <td>{{books.category}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end .card-body -->
                        </div>
                    </div>

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
<script> var myURL = "<?php echo base_url(); ?>"; </script>

<script src="<?php echo base_url(); ?>assets/myjs/library/library.js"></script>
<script src="<?php echo base_url(); ?>assets/myjs/library/lms_myangucomplete.js"></script>
</body>
</html>
