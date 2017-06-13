<!DOCTYPE html>
<html lang="en">
    <title>Staff Dashboard</title>
    <?php
    $lastlogin = $this->session->userdata('last_activity');
    $timezone = +5.3;
    $change = gmdate("jS M,H:i", $lastlogin + 3600 * ($timezone + date("I")));
    $staff_id = $this->session->userdata('staff_id');
    $presentstudent = array();
    $totalstudent = array();
    $subjectname = array();
    for ($k = 0; $k < count($subject); $k++) {
        $subjectname[] = $subject[$k]['standard'] . '' . $subject[$k]['section'] . ' ' . $subject[$k]['sbject'];
        $totalstudent[] = $subject[$k]['totalstudent'];
        $presentstudent[] = $subject[$k]['presentstudent'];
    }
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style type="text/css">
        .myProButtons{
            /*position: relative;*/
            float: left;
            margin-left: 5px


        }
        .btn-pink {
            color: #ffffff;
            background-color: pink;
            border-color: pink;
        }



    </style>
    <body class="menubar-hoverable header-fixed ">
        <?php $this->load->view('include/header'); ?>
        <div id="base" ng-app="staffDetails">
            <div id="content" ng-controller="staffDetailsController" ng-cloak ng-class="ng-cloak">
                <div class="offcanvas">

                    <!-- BEGIN OFFCANVAS DEMO LEFT -->
                    <div id="offcanvas-demo-right" class="offcanvas-pane width-10">
                        <div class="offcanvas-head text-center btn-{{bgColor}} ">
                            <header>Issue {{type}} Card</header>
                            <div class="offcanvas-tools">
                                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <div angucomplete-alt id="studentName" placeholder="Search Name Here" pause="50" selected-object="testObj" remote-url="<?php echo base_url(); ?>index.php/staff/allstudentnamelist?search= " remote-url-data-field="results" title-field="firstname,lastname" minlength="1" input-class="form-control form-control-small" match-class="highlight">
                                    </div>
                                </div>
                                <div class="form-group floating-label">
                                    <textarea name="textarea2" ng-model="cardReason" id="textarea2" class="form-control" rows="3" placeholder="Reason"></textarea>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-sm-12">
                                    <p><button id="{{type}}" class="btn btn-block ink-reaction btn-{{bgColor}}" type="button" ng-click="issueBluecard(cardReason, testObj.originalObject.adm_no, $event)">Issue {{type}} Card</button></p>
                                </div><!--end .col -->
                            </div>

                            <div class="card">
                                <div class="card-body no-padding">

                                    <ul class="list divider-full-bleed">
                                        <li class="tile btn btn-default-light" ng-repeat=" cardsblue in data.card.BLUE">
                                            <a   href="<?php echo base_url(); ?>index.php/staff/studentprofile/{{cardsblue.adm_no}}" class="tile-content ink-reaction" >

                                                <div title="Admission No: {{cardsblue.adm_no}}&#013Name: {{cardsblue.firstname}} {{cardsblue.lastname}}&#013For: {{cardsblue.remarks}}&#013total {{data.card.BLUE.length}} cards">
                                                    {{cardsblue.adm_no}} {{cardsblue.firstname}} {{cardsblue.lastname| limitTo:4}}{{cardsblue.lastname.length >4?'.....':''}}
                                                </div>
                                            </a>
                                            <a class="btn btn-flat ink-reaction">
                                                <i class="fa fa-trash" id="{{cardsblue.id}}" ng-click="deleteCards($event)"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!--end .card-body--> 
                            </div>
                        </div>
                    </div>
                    <div id="offcanvas-demo-left" class="offcanvas-pane style-primary width-10">
                        <div class="offcanvas-head">
                            <header><span>Schedule of {{examName}}</span></header>
                            <div class="offcanvas-tools">
                                <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                    <i class="md md-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="offcanvas-body">
                            <h5 ng-show="myExamSchedule == -1">No Datesheet Available</h5>
                            <div class="col-lg-12" ng-show="myExamSchedule != -1">
                                <div class="card">
                                    <div class="card-body no-padding style-primary">
                                        <div class="table-responsive no-margin">
                                            <table class="table table-striped no-margin style-primary">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Subject Name</th>
                                                        <th> Date</th>
                                                        <th> Time</th>
                                                        <th>Duration</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="examDate in myExamSchedule">
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{examDate.subject_name}}</td>
                                                        <td>{{examDate.exam_date}}</td>
                                                        <td>{{examDate.exam_time}}</td>
                                                        <td>{{examDate.duration}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div><!--end .table-responsive -->
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div>
                        </div>
                    </div>
                    <!-- END OFFCANVAS DEMO LEFT -->

                </div><!--end .offcanvas-->

                <!-- BEGIN PROFILE HEADER -->
                <section class="full-bleed">
                    <div class="section-body style-default-dark force-padding text-shadow" ng-cloak>
                        <div class="img-backdrop" style="background-image: url('http://www.meraschoolportal.com/school/assets/img/SLIDER.jpg')"></div>
                        <div class="overlay overlay-shade-top stick-top-left height-3"></div>
                        <div class="row">
                            <div class="col-md-3 col-xs-5" >
                                <form id="uploadForm" action="<?php echo base_url(); ?>index.php/staff/mypic" method="POST" enctype="multipart/form-data" >
                                    <a onMouseOver="show_sidebar()" onMouseOut="hide_sidebar()" href="javascript:void(0)"  ><div id="sidebar" class="upload_hover img-circle" ng-hide="hideType == 'TRUE'" >Upload <i class="fa fa-camera"></i></div>
                                        <!--<img class="img-circle border-white border-xl img-responsive auto-width" src="<?php echo base_url() . "/index.php/staff/getphoto/" . $this->session->userdata('staff_id') . "/full"; ?>" alt="">-->
                                        <img class="img-circle border-white border-xl img-responsive img-custom-size" src="<?php echo base_url() . "/index.php/staff/getphoto/" . $this->session->userdata('staff_id') . "/full"; ?>" alt="" ng-click="uploadDikhao()"></a>
                                    <?php if ($this->session->userdata('deo_staff_id') == -1) { ?>   
                                        <input id="userfile" type="file" name="userfile" multiple="multiple" ng-show="hideType == 'TRUE'" style="display:none"/>
                                    <?php } ?>
                                </form>
                                <h3 class="logonamecentr" ><?php echo $this->session->userdata('staff_name') ?></h3> 


                            </div><!--end .col -->
                            <?php if (isset($error) and $error != '') { ?>
                                <div id="toast-container" class="toast-bottom-left" aria-live="polite" role="alert"><div class="toast toast-error" style="overflow: hidden; height: 43.2283979545046px; padding-top: 10.8070994886261px; margin-top: 7.20473299241743px; padding-bottom: 10.8070994886261px; margin-bottom: 0px;"><div class="toast-message"><?php echo ($error['error']); ?></div></div></div>

                            <?php } ?>
                            <div class="col-md-9 col-xs-7">
                                <a class="ink-reaction" href="#offcanvas-demo-right" ng-click="type = 'Red';
                                            bgColor = 'danger'" data-toggle="offcanvas">
                                    <div class="width-2 text-center pull-right" style="background-color: #FF0000;transform: rotate(-21deg)">
                                        <strong class="text-xl">{{cardCount.RED.length}}</strong><br>
                                        <span class="text-light opacity-75">Cards</span>
                                    </div>
                                </a>
                                <a class="ink-reaction" href="#offcanvas-demo-right" ng-click="type = 'Pink';
                                            bgColor = 'pink'" data-toggle="offcanvas">
                                    <div class="width-2 text-center pull-right" style="background-color: #F52887;transform: rotate(-21deg)">
                                        <strong class="text-xl">{{cardCount.PINK.length}}</strong><br>
                                        <span class="text-light opacity-75">Cards</span>
                                    </div>
                                </a>
                                <a class="ink-reaction" href="#offcanvas-demo-right" ng-click="type = 'Yellow';
                                            bgColor = 'yellow-warning'" data-toggle="offcanvas">
                                    <div class="width-2 text-center pull-right" style="background-color: #FFFF00;transform: rotate(-21deg)">
                                        <strong class="text-xl">{{cardCount.YELLOW.length}}</strong><br>
                                        <span class="text-light opacity-75">Cards</span>
                                    </div>
                                </a>
                                <a class="ink-reaction" href="#offcanvas-demo-right" ng-click="type = 'Blue';
                                            bgColor = 'info'" data-toggle="offcanvas">
                                    <div class="width-2 text-center pull-right" style="background-color: #0000FF;transform: rotate(-21deg)">
                                        <strong class="text-xl">{{cardCount.BLUE.length}}</strong><br>
                                        <span class="text-light opacity-75">Cards</span>
                                    </div>
                                </a>

                            </div><!--end .col -->
                        </div><!--end .row -->
                        <div class="overlay overlay-shade-bottom stick-bottom-left force-padding text-right">
                            <h3><span class="pull-right" style="margin-right: 25px">Last Login: <?php echo $change; ?></span></h3>
                            <!--<a style="margin-right: 25px" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Contact me"><i class="fa fa-clock-o"></i>Last Login:<strong>{{data.lastlogin}}</strong></a>3px-->

                        </div>
                    </div><!--end .section-body -->

                </section>


                <!-- END PROFILE HEADER  -->
                <?php if ($this->session->userdata('is_staff_classteacher') == 'YES') { ?>
                    <section >
                        <div class="section-body" >
                            <p class="myProButtons" style=" font-size: 21px;top: -2px; margin-right: 8px;">Things You Can Do : </p>
                            <button onclick="javascript:window.location = '<?php echo base_url(); ?>index.php/staff/manageattendence';" title="" data-placement="left" data-toggle="tooltip" class="btn btn-primary btn-raised style-primary-light" type="button"><?php echo $this->session->userdata('staff_classteacher_class') ?>-Attendance</button>
                            <button onclick="javascript:window.location = '<?php echo base_url(); ?>index.php/staff/marksentry';" title="" data-placement="left" data-toggle="tooltip" class="btn btn-primary btn-raised style-primary-light" type="button">Marks Entry</button>
                            <button onclick="javascript:window.location = '<?php echo base_url(); ?>index.php/staff/ccegradeentry';" title="" data-placement="left" data-toggle="tooltip" class="btn btn-primary btn-raised style-primary-light" type="button">CC Entry</button>
                            <button onclick="javascript:window.location = '<?php echo base_url(); ?>index.php/staff/remarkentrysub';" title="" data-placement="left" data-toggle="tooltip" class="btn btn-primary btn-raised style-primary-light" type="button">Remarks Entry</button>


                        </div>
                    </section>
                <?php } else { ?>
                    <section >
                        <div class="section-body" >
                            <p class="myProButtons"></p>
                            <p class="myProButtons"></p>
                            <p class="myProButtons"></p>
                            <p class="myProButtons"></p>
                            <p class="myProButtons"></p>
                        </div>
                    </section>
                <?php } ?>
                <section>
                    <div class="section-body no-margin">
                        <div class="row">
                             <?php //if($widgetstatus[0]['status'] == 1) { ?>
                            <div class="col-md-6">
                                <div class="card ">
                                    <div class="card-head">
                                        <header></header>
                                        <!--                                        <div class="tools">
                                                                                    <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                                                                </div>-->
                                    </div>
                                    <div id="myGraph" class="nano has-scrollbar" style="height: 350px;"><div class="nano-content" tabindex="0" style="right: -15px;"><div class="card-body no-padding height-9 scroll" style="height: auto;">
                                            </div></div><div class="nano-pane"><div class="nano-slider" style="height: 234px; transform: translate(0px, 0px);"></div></div></div>
                                    <?php // } ?>
                                </div>
                            </div>
                            
                            <?php //if($widgetstatus[1]['status'] == 1) { ?>
                            <div class="col-md-3" >
                                <div class="card style-default-light">
                                    <div class="card-head">
                                        <!--                                        <div class="tools">
                                                                                    <div class="btn-group">
                                                                                        <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                                                                    </div>
                                        
                                                                             </div>-->
                                        <div class="row">  
                                            <header>Todo's </header>
                                            <a  class="text-centered viewlink" href="<?php echo base_url(); ?>index.php/staff/viewtodo">View</a>
                                        </div> 
                                        <form name="todo">
                                            <div class="form-group col-md-8 floating-label">
                                                <input class="form-control" type="text" maxlength="20" placeholder="add new todo here" name="Subject1" id="Subject1" ng-model="todotask.task_name" class="ng-pristine ng-valid ng-touched" required>
                                                <span >{{20 - todotask.task_name.length}}  characters remaining</span>
                                            </div>
                                            <div class="form-group col-md-2 floating-label">
                                                <button type="button" class="btn btn-sm btn-success pull-right" style="margin-top: 7px;" id='newtask' ng-click="addTodo()">Add</button>

                                            </div>
                                        </form>

                                    </div><!--end .card-head -->

                                    <div class="card-body myscroll" style="height: 282px;">
                                        <ul class="list divider-full-bleed"> 
                                            <li class="tile" ng-show="TodoList.length == 0">
                                                <div class="tile-content">
                                                    <div class="tile-text">
                                                        No Entry Found
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="chkboxsml tile"   ng-show="TodoList.length > 0" ng-repeat="todolistObj in TodoList" style="{{todolistObj.todo_class}}">
                                                <div class="checkbox checkbox-styled tile-text ">
                                                    <label>
                                                        <input type="checkbox"   id="mycheck{{$index}}" ng-click="todocomplete($index)" >
                                                        <span class="text-sm strikethrough" style="overflow:hidden"  class="chkbxleftspacelow" title='{{todolistObj.task_name}}'>{{todolistObj.task_name| limitTo: 15}}{{todolistObj.task_name.length > 15 ? '...' : ''}}</span>
                                                    </label>
                                                </div>

                                                <a class="btn  btn-icon-toggle btn-default-light closeicon">
                                                    <i class="md md-close" id="{{todolistObj.id}}" ng-click="deletetodo($index)"></i>

                                                </a>
                                            </li>

                                        </ul>						

                                    </div><!--end .card-body -->
                                </div><!--end .card -->

                            </div>
                            <?php //} ?>
                            
                             <?php //if($widgetstatus[2]['status'] == 1) { ?>
                            <div class="col-md-3" >
                                <div class="card style-default-light">
                                    <div class="card-head">
                                        <header>My Event</header>
                                        <!--                                        <div class="tools">
                                                                                    <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                                                                </div>-->

                                    </div>
                                    <!--end .card-head -->


                                    <div class="nano myscroll" style="height: 350px;"><div  tabindex="0" style="right: -15px;"><div class="card-body no-padding " style="height: auto;">
                                                <ul class="list">
                                                    <?php if (empty($event)) { ?>
                                                        <li class="tile" >
                                                            <a class="btn btn-flat btn-info ink-reaction">
                                                                <i class="md md-event"></i>
                                                            </a>
                                                            <a class="tile-content ink-reaction" href="#2">
                                                                <div class="tile-text">
                                                                    No Entry Found
                                                                </div>

                                                            </a>
                                                        </li>

                                                        <?php
                                                    } else {
                                                        for ($i = 0; $i < count($event); $i++) {
                                                            ?>
                                                            <li class="tile">
                                                                <a class="btn btn-flat ink-reaction">
                                                                    <i class="md md-event"></i>
                                                                </a>
                                                                <a class="tile-content ink-reaction" target="_blank" href="<?php echo base_url() . 'index.php/staff/myevents/' . $event[$i]['id'] ?>">
                                                                    <div class="tile-text">
                                                                        <?php echo $event[$i]['name'] . ' ' . '(' . $event[$i]['totalteam'] . ')' ?>

                                                                    </div>

                                                                </a>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div></div><div ><div  style="height: 234px; transform: translate(0px, 0px);"></div></div></div><!--end .card-body -->
                                </div><!--end .card -->
                            </div>

                             <?php //} ?>
                        </div><!--end .row -->
                        <div class="row">
                             <?php //if($widgetstatus[3]['status'] == 1) { ?>
                            <div class="col-md-6" >

                                <div class="card style-default-light">
                                    <div class="card-head">
                                        <!--                                        <div class="tools">
                                                                                    <div class="btn-group">
                                                                                        <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                                                                    </div>
                                        
                                                                                </div>-->
                                        <header>Notices</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body myscroll" style="height: 350px;">
                                        <ul class="list divider-full-bleed">   
                                            <?php if (empty($notice)) { ?>
                                                <li class="tile">
                                                    <div class="tile-content">
                                                        <div class="tile-text">
                                                            No Entry Found
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            } else {
                                                for ($i = 0; $i < count($notice); $i++) {
                                                    ?>
                                                    <li class="tile">
                                                        <div class="tile-content ">
                                                            <div class="tile-text" >
                                                                <h5>Staff Notice:</h5> <span data-original-title="Tittle :<?php echo $notice[$i]['title'] ?>" data-placement="top" data-toggle="tooltip"><?php echo substr($notice[$i]['title'], 0, strrpos(substr($notice[$i]['title'], 0, 50), ' ')) . '...'; ?></span>
                                                                <div data-original-title="Notice : <?php echo $notice[$i]['notice_content'] ?>" data-placement="top" data-toggle="tooltip">
                                                                    <h7><?php echo substr($notice[$i]['notice_content'], 0, strrpos(substr($notice[$i]['notice_content'], 0, 60), ' ')) . '...'; ?></h7>
                                                                </div>  
                                                                <small><?php echo $notice[$i]['timestamp'] ?></small>
                                                            </div>
                                                            <div class="tile-icon">
                                                                <img title="By -<?php echo $notice[$i]['staff_fname'] . ' ' . $notice[$i]['staff_lname'] ?>"  alt="" src="<?php echo base_url() ?>index.php/staff/getphoto/1/full">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </ul>						

                                    </div><!--end .card-body -->
                                </div><!--end .card -->

                            </div>
                             <?php //} ?>
                            
                             <?php //if($widgetstatus[4]['status'] == 1) { ?>
                            <div class="col-md-3">
                                <div class="card style-default-light">
                                    <div class="card-head">
                                        <header>My Homework</header>
                                        <!--                                        <div class="tools">
                                                                                    <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                                                                </div>-->
                                    </div><!--end .card-head -->
                                    <div class="nano myscroll" style="height: 350px;">
                                        <div  tabindex="0" style="right: -15px;">
                                            <div class="card-body no-padding " style="height: auto;">
                                                <ul class="list" data-sortable="true">
                                                    <?php if ($homeworkList == -1) { ?>
                                                        <li class="tile" >
                                                            <a class="btn btn-flat btn-info ink-reaction">
                                                                <img src="<?php echo base_url(); ?>assets/img/a.png" width=28px>
                                                            </a>

                                                            <a class="tile-content ink-reaction" href="">
                                                                <div class="tile-text">
                                                                    No Entry Found
                                                                </div>

                                                            </a>
                                                        </li>

                                                        <?php
                                                    } else {
                                                        for ($i = 0; $i < count($homeworkList); $i++) {
                                                            ?>
                                                            <li class="tile" >
                                                                <a class="btn btn-flat btn-info ink-reaction">
                                                                    <img src="<?php echo base_url(); ?>assets/img/hw.png" width=28px>
                                                                </a>
                                                                <a href="<?php
                                                                if ($homeworkList[$i]['type'] == 'HOMEWORK') {
                                                                    echo base_url() . 'index.php/staff/homework/' . $homeworkList[$i]['id'];
                                                                } else {
                                                                    echo base_url() . 'index.php/staff/assigment/' . $homeworkList[$i]['id'];
                                                                }
                                                                ?>" class="tile-content ink-reaction" target="_blank">
                                                                    <div class="tile-text no-padding text-sm">
                                                                        <p><small><?php echo $homeworkList[$i]['class'] . ' ' . $homeworkList[$i]['title'] ?></small>
                                                                            <small>Submission date: <strong><?php echo $homeworkList[$i]['submission_last_date'] ?></strong></small></p>

                                                                    </div>

                                                                </a>
                                                            </li> 
                                                            <?php
                                                        }
                                                    }
                                                    ?>


                                                </ul>
                                            </div></div><div ><div  style="height: 234px; transform: translate(0px, 0px);"></div></div></div><!--end .card-body -->
                                </div><!--end .card -->
                            </div>
 <?php //} ?>
                            
                             <?php //if($widgetstatus[5]['status'] == 1) { ?>
                            <div class="col-md-3">
                                <div class="card style-default-light">
                                    <div class="card-head">
                                        <header>Birthdays</header>
                                        <!--                                        <div class="tools">
                                                                                    <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                                                                </div>-->
                                    </div><!--end .card-head -->
                                    <div class="nano myscroll" style="height: 350px;">
                                        <div  tabindex="0" style="right: -15px;">
                                            <div style="height: 543px;" >
                                                <div style="right: -13px;" tabindex="0" >
                                                    <div  style="height: 1440px;">
                                                        <div  tabindex="0" style="right: -13px;">
                                                            <div class="card-body no-padding " style="height: auto;">
                                                                <ul class="list">
                                                                    <?php for ($i = 0; $i < count($birthday); $i++) { ?>
                                                                        <li class="tile" >
                                                                            <span class="btn btn-flat btn-danger">
                                                                                <i class="fa fa-birthday-cake"></i>
                                                                            </span>
                                                                            <a href="<?php
                                                                            if ($birthday[$i]['type'] == 'STUDENT') {
                                                                                echo base_url();
                                                                                ?>index.php/staff/studentprofile/<?php echo $birthday[$i]['adm_no'] ?><?php } else { ?><?php echo base_url() ?>index.php/staff/staffprofile/ <?php echo $birthday[$i]['id'] ?> <?php } ?>" class="tile-content ink-reaction">
                                                                                <div class="tile-text">
                                                                                    <p class="text-sm"  ><?php echo $birthday[$i]['firstname'] . ' ' . $birthday[$i]['lastname'] ?></p>
                                                                                    <small><?php echo $birthday[$i]['type'] ?>: <strong><?php echo $birthday[$i]['day'] ?></strong></small>
                                                                                </div>

                                                                                <div class="tile-icon">
                                                                                    <img alt="" src="<?php
                                                                                    if ($birthday[$i]['type'] == 'STUDENT') {
                                                                                        echo base_url() . "index.php/staff/getstudphoto/" . $birthday[$i]['adm_no'] . "/THUMB"
                                                                                        ?><?php } else { ?><?php echo base_url() . "index.php/staff/getphoto/" . $birthday[$i]['id'] . " /THUMB"; ?> <?php } ?>">
                                                                                </div>
                                                                            </a>
                                                                        </li> 
                                                                    <?php }
                                                                    ?>


                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <?php // } ?>
                        </div>
                        <div class="row">
 <?php //if($widgetstatus[6]['status'] == 1) { ?>
                            <div class="col-md-4">
                                <div class="card style-default-light">
                                    <div class="card-head">
                                        <header>Exam Datesheet</header>
                                        <!--                                        <div class="tools">
                                                                                    <a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
                                                                                </div>-->
                                    </div><!--end .card-head -->
                                    <div style="height:350px;" class="nano myscroll">
                                        <div style="right: -15px;" tabindex="0">
                                            <div  style="height: 543px;">
                                                <div  tabindex="0" style="right: -13px;">
                                                    <div style="height: auto;" class="card-body no-padding ">
                                                        <ul class="list" style="line-height:7px">

                                                            <?php if ($examDatesheet == -1) { ?>
                                                                <li class="tile">
                                                                    <div class="tile-content">

                                                                        <div class="tile-text">No Entry Found</div>
                                                                    </div>

                                                                </li>
                                                                <?php
                                                            } else {
                                                                for ($i = 0; $i < count($examDatesheet); $i++) {
                                                                    ?>
                                                                    <li class="tile">
                                                                        <a class="btn btn-flat btn-info ink-reaction">
                                                                            <span style="font-size:24px; line-height: 0px; ">&bullet;</span>
                                                                        </a>
                                                                        <a class="tile-content ink-reaction pull-left" href="#offcanvas-demo-left" data-toggle="offcanvas" ng-click="examSchedule(examName = '<?php echo $examDatesheet[$i]['exam_name']; ?>',<?php echo $examDatesheet[$i]['id']; ?>)">
                                                                            <div class="tile-text">
                                                                                <p class="text-sm "><?php echo $examDatesheet[$i]['exam_name'] . '(' . 'class ' . $examDatesheet[$i]['standard'] . ')'; ?></p>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>



                                                        </ul>
                                                    </div></div><div  style="display: none;"><div  style="height: 530px; transform: translate(0px, 0px);"></div></div></div></div><div ><div style="height: 234px; transform: translate(0px, 0px);"></div></div></div><!--end .card-body -->
                                </div><!--end .card -->
                            </div>
                             <?php //} ?>
                        </div>
                    </div>
                </section>
            </div>
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
                    <!-- BEGIN MAIN MENU -->
                    <?php $this->load->view('include/menu'); ?>
                    <!--end .main-menu -->
                    <!-- END MAIN MENU -->
                </div><!--end .menubar-scroll-panel-->
            </div>
        </div>
        <!--<div class="tile-icon">-->
        <?php
        $this->load->view('include/headjs');
        ?>
        <script type="text/javascript">
            document.getElementById('sidebar').style.visibility = "hidden";
            function show_sidebar()
            {
                document.getElementById('sidebar').style.visibility = "visible";
            }

            function hide_sidebar()
            {
                document.getElementById('sidebar').style.visibility = "hidden";
            }
            $('#sidebar').on('click', function () {
                $('#userfile').trigger('click');
            });
            document.getElementById('userfile').onchange = function () {
                document.getElementById('uploadForm').submit();
            };
        </script>
        <script>
            var staff_id = "<?php echo $staff_id; ?>";
            var base_url = "<?php echo base_url(); ?>";</script>
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
        <script src="<?php echo base_url(); ?>assets/myjs/staffprofile.js?v=<?php echo rand(); ?>"></script>
        <script src="<?php echo base_url(); ?>/assets/js/autocomplete/angucomplete-alt.js"></script>
        <script src="<?php echo base_url(); ?>/assets/js/angular-touch.min.js"></script>
        <script>
            $(function () {
                $('#myGraph').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Student Strength of My Subjects'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        categories:<?php echo json_encode($subjectname); ?>,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'student'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y: 1f}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                            name: 'Present',
                            data: <?php echo str_replace('"', '', json_encode($presentstudent)); ?>,
                        }, {
                            name: 'Total',
                            data: <?php echo str_replace('"', '', json_encode($totalstudent)); ?>,
                        }]
                });
            });
        </script>
    </body>
</html>
