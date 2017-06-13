<!DOCTYPE html>
<html lang="en">
    <title>Message</title>
    <head>
        <?php
        $this->load->view('include_parent/headcss');
        ?>
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin" ng-app="message" ng-controller="messageController">
        <!-- BEGIN HEADER-->
        <?php
        $this->load->view('include_parent/header');
        ?>
        <script>
                    var staffId =<?php echo json_encode($staff_id); ?>;
                    var myMessage =<?php echo json_encode($myMessageDeatil); ?>;        </script>
        <div id="base">
            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-lg-7 col-sm-12">
                                    <div class="col-md-12">
                                        <div class="card card-outlined style-gray-dark">
                                            <div class="card-body no-padding">
                                                <ul class="list  divider-full-bleed">
                                                    <li class="tile" ng-repeat="unreadmessageObj in messageDeatil.unread | orderBy:'-timestamp'" ng-show="messageDeatil.unread != 0">
                                                        <a class="tile-content ink ink-reaction">
                                                            <div class="tile-icon">
                                                                <img alt="" src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{unreadmessageObj.staff_id}} " . "/THUMB"; ?>">
                                                            </div>
                                                            <div class="tile-text">
                                                                {{unreadmessageObj.staff_name}}<span ng-show="unreadmessageObj.classTeacher == 'YES'">(Class Teacher)</span>
                                                                <small>Total: {{unreadmessageObj.total}} || Unread: {{unreadmessageObj.unread}} || <span ng-show="unreadmessageObj.subjectList != - 1"> Subject Teacher: {{unreadmessageObj.subjectList}}</span></small>
                                                                <small><span ng-show="unreadmessageObj.clubName != - 1">Club Incharge: {{unreadmessageObj.clubName}} || </span><span ng-show="unreadmessageObj.eventName != - 1">Event Incharge: {{unreadmessageObj.eventName}} </span></small>
                                                            </div>
                                                        </a>
                                                        <a class="btn btn-flat btn-success ink ink-reaction" href="<?php echo base_url(); ?>index.php/parent/message/{{unreadmessageObj.staff_id}}" >
                                                            <i class="fa fa-comment"></i>
                                                        </a>
                                                    </li>
                                                    <li class="tile" ng-repeat="readmessageObj in messageDeatil.read" ng-show="messageDeatil.read != 0">
                                                        <a class="tile-content ink ink-reaction">
                                                            <div class="tile-icon">
                                                                <img alt="" src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{readmessageObj.staff_id}} " . "/THUMB"; ?>">
                                                            </div>
                                                            <div class="tile-text">
                                                                {{readmessageObj.staff_name}}<span ng-show="readmessageObj.classTeacher == 'YES'">(Class Teacher)</span>
                                                                <small>Total: {{readmessageObj.total}} || Unread: {{readmessageObj.unread}} || <span ng-show="readmessageObj.subjectList != - 1"> Subject Teacher: {{readmessageObj.subjectList}}</span></small>
                                                                <small><span ng-show="readmessageObj.clubName != - 1">Club Incharge: {{readmessageObj.clubName}} || </span><span ng-show="readmessageObj.eventName != - 1">Event Incharge: {{readmessageObj.eventName}} </span></small>
                                                            </div>
                                                        </a>
                                                        <a class="btn btn-flat btn-success ink ink-reaction" href="<?php echo base_url(); ?>index.php/parent/message/{{readmessageObj.staff_id}}" >
                                                            <i class="fa fa-comment"></i>
                                                        </a>
                                                    </li>
                                                    <li class="tile" ng-show="messageDeatil.read != 0 && messageDeatil.unread != 0">
                                                        <div class="tile-text">
                                                            <strong>&nbsp; No message for now!!!</strong>
                                                        </div>
<!--                                                        <a class="tile-content ink ink-reaction">
                                                            <div class="tile-icon">
                                                                <img alt="" src="<?php echo base_url() . "/index.php/staff/getphoto/" . "{{readmessageObj.staff_id}} " . "/THUMB"; ?>">
                                                            </div>
                                                            <div class="tile-text">
                                                                {{readmessageObj.staff_name}}<span ng-show="readmessageObj.classTeacher == 'YES'">(Class Teacher)</span>
                                                                <small>Total: {{readmessageObj.total}} || Unread: {{readmessageObj.unread}} || <span ng-show="readmessageObj.subjectList != - 1"> Subject Teacher: {{readmessageObj.subjectList}}</span></small>
                                                                <small><span ng-show="readmessageObj.clubName != - 1">Club Incharge: {{readmessageObj.clubName}} || </span><span ng-show="readmessageObj.eventName != - 1">Event Incharge: {{readmessageObj.eventName}} </span></small>
                                                            </div>
                                                        </a>
                                                        <a class="btn btn-flat btn-success ink ink-reaction" href="<?php echo base_url(); ?>index.php/parent/message/{{readmessageObj.staff_id}}" >
                                                            <i class="fa fa-comment"></i>
                                                        </a>-->
                                                    </li>
                                                </ul>
                                            </div><!--end .card-body -->
                                        </div><!--end .card -->

                                    </div>
                                </div><!--end .col -->
                                <?php if ($staff_id > 0) { ?>
                                    <div class="col-lg-5 col-sm-12">
                                        <div class="col-md-12">
                                            <div class="card ">
                                                <div class="card-head card-head-xs style-gray-dark">
                                                    <header><img class="img-circle width-1" src="<?php echo base_url() . "/index.php/staff/getphoto/" . $staff_id . "/THUMB"; ?>" alt="">&nbsp;&nbsp;<?php echo $staff_name; ?></header>
                                                </div><!--end .card-head -->
                                                <div class="card-body small-padding col-lg-12">
                                                    <form role="form" class="form-horizontal" name="mySmsForm" novalidate>
                                                        <div class="form-group no-margin">
                                                            <div>
                                                                <div class="input">
                                                                    <input type="text" class="form-control" ng-model="messageContent" ng-keydown="$event.keyCode == 13 && SendMessage('<?php echo $staff_id; ?>')">
                                                                </div>
                                                            </div>
                                                        </div><!--end .form-group -->
                                                    </form>
                                                </div>
                                                <div class="card-body small-padding height-9 scroll style-default-light">
                                                    <ul class="list-chats"  ng-show="myMessageDetail!=-1">
                                                        <li ng-repeat="mymessageObj in myMessageDetail" ng-class="{'chat-left': mymessageObj.sender === 'STAFF'}">
                                                            <div class="chat">
                                                                <div class="chat-avatar"><img  ng-show="mymessageObj.sender == 'STAFF'" class="img-circle" src="<?php echo base_url() . "/index.php/staff/getphoto/" . $staff_id . "/THUMB"; ?>" alt="" />
                                                                    <img  ng-show="mymessageObj.sender == 'STUDENT'" class="img-circle" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . $this->session->userdata('current_adm_no') . "/THUMB"; ?>" alt="" />
                                                                </div>
                                                                <div class="chat-body ">
                                                                    {{mymessageObj.message}}
                                                                    <small ng-show="mymessageObj.sender == 'STAFF'">{{mymessageObj.staff_read_timestamp}}</small>
                                                                    <small ng-show="mymessageObj.sender == 'STUDENT'">{{mymessageObj.student_read_timestamp}}<i class="md-done" ng-class="{'md-done-all': mymessageObj.staff_read_status === 'READ'}"></i></small>

                                                                </div>
                                                            </div><!--end .chat -->
                                                        </li>
                                                    </ul>
                                                </div><!--end .card-body -->
                                            </div><!--end .card -->
                                        </div>
                                    </div><!--end .col -->
                                <?php } ?>
                            </div>
                        </div>
                    </div><!--end .section-body -->
                </section>
            </div><!--end #content-->		
            <!-- END CONTENT -->
            <!-- BEGIN MENUBAR-->
            <div id="menubar" class="menubar-inverse">
                <div class="menubar-fixed-panel">
                    <div>
                        <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="expanded">
                        <a href="dashboard.html">
                            <span class="text-lg text-bold text-primary ">Mera School Portal</span>
                        </a>
                    </div>
                </div>
                <div class="menubar-scroll-panel">
                    <!-- BEGIN MAIN MENU -->
                    <?php
                    $this->load->view('include_parent/sidemenu.php');
                    ?>
                    <!-- END MAIN MENU -->
                    <div class="menubar-foot-panel">
                        <small class="no-linebreak hidden-folded">
                            <span class="opacity-75">Copyright &copy; <?php echo date('Y'); ?></span> <strong>Mera School Portal</strong>
                        </small>
                    </div>
                </div><!--end .menubar-scroll-panel-->
            </div><!--end #menubar-->
            <!-- END MENUBAR -->
        </div><!--end #base-->	
        <!-- END BASE -->
        <!-- BEGIN JAVASCRIPT -->
        <?php
        $this->load->view('include_parent/headjs');
        ?>
        <!-- END JAVASCRIPT -->
        <script>var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>/assets/parentjs/message.js"></script>
    </body>
</html>