
<!DOCTYPE html>
<html lang="en">
    <title> View All Todo's </title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="todoDetails" ng-controller="todoDetailsController" class="ng-cloak" >
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak ng-class="cloak">
                        <div class="card">
                            <div class="card-head card-head-sm style-primary">
                                <header><i class="fa fa-th-list" ></i> View All Todo's </header>
                            </div><!--end .card-head -->

                            <div class="panel-group" id="accordion7">
                                <div ng-repeat="i in TodoList|orderBy:'status' ">
                                    <div  ng-show="i.status == 'COMPLETED'" class="card panel">
                                        <div class="card-head collapsed style-success" data-toggle="collapse" data-parent="#accordion7" >
                                            <header class="pull-left">{{i.task_name}} </header> 
                                            <strong><a id="{{todolist.id}}" class="btn btn-flat ink-reaction btn-default-dark pull-right" ng-click="deletetodo($index)">
                                                    <i class="md md-delete"  ></i>
                                                </a></strong>
                                            <header class="pull-right">COMPLETED</header>

                                        </div>

                                    </div><!--end .panel -->
                                    <div class="card panel" ng-show="i.status == 'PENDING'">
                                        <div class="card-head collapsed style-danger" data-toggle="collapse" data-parent="#accordion7" data-target="#acc{{$index}}">
                                            <header class="pull-right">PENDING</header>
                                            <header class="pull-left">{{i.task_name}}</header>
                                        </div>
                                    </div><!--end .panel -->
                                </div>
                            </div><!--end .panel-group -->
                        </div><!--end .card-body -->
                    </div><!--end .card -->
            </div><!--end .col -->

        </section>
    </div><!--end .section-body -->
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
<script>var base_url = "<?php echo base_url(); ?>";</script>
<script src="<?php echo base_url(); ?>/assets/myjs/todo.js"></script>
