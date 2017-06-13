<?php
$route['parent/academics'] = "parent/main_controller/LoadAcademics";
$route['parent/attendance'] = "parent/main_controller/LoadAttendance";
$route['parent/cards'] = "parent/main_controller/LoadCards";
$route['parent/ccegrade'] = "parent/main_controller/LoadCCEGrade";
$route['parent/events'] = "parent/main_controller/LoadEvents";
$route['parent/gallery'] = "parent/main_controller/LoadGallery";
$route['parent/homepage'] = "parent/main_controller/Loadhomepage";
$route['parent/notice'] = "parent/main_controller/LoadNotice";
$route['parent/summary'] = "parent/main_controller/LoadSummary";
$route['parent/tardy'] = "parent/main_controller/LoadTardy";
?>

<ul id="main-menu" class="gui-controls">
    <!-- BEGIN DASHBOARD -->
    <li>
        <a href=<?php echo base_url(); ?>index.php/parent/homepage>
            <div class="gui-icon"><i class="md md-home"></i></div>
            <span class="title">Home</span>
        </a>
    </li><!--end /menu-li -->
    <li>
        <a href=<?php echo base_url(); ?>index.php/parent/summary>
            <div class="gui-icon"><i class="md md-dashboard"></i></div>
            <span class="title">Summary</span>
        </a>
    </li><!--end /menu-li -->
    <!-- BEGIN EMAIL -->
    <li class="gui-folder">
        <a>
            <div class="gui-icon"><i class="md md-book"></i></div>
            <span class="title">Academics</span>
        </a>
        <!--start submenu -->
        <ul>
            <li><a href=<?php echo base_url(); ?>index.php/parent/homework ><span class="title">Homework</span></a></li>
            <li><a href=<?php echo base_url(); ?>index.php/parent/academics><span class="title">Marks</span></a></li>
            <li><a href=<?php echo base_url(); ?>index.php/parent/ccegrade><span class="title">Grades</span></a></li>
        </ul><!--end /submenu -->
    </li><!--end /menu-li -->

    <li class="gui-folder">
        <a>
            <div class="gui-icon"><i class="md md-alarm"></i></div>
            <span class="title">Attendance</span>
        </a>
        <!--start submenu -->
        <ul>
            <li>
                <a href=<?php echo base_url(); ?>index.php/parent/attendance>
                    <span class="title">Complete Attendance</span></a></li>

            <li>
                <a href=<?php echo base_url(); ?>index.php/parent/tardy>
                    <span class="title">Late Attendance</span></a></li>
        </ul><!--end /submenu -->
    </li><!--end /menu-li -->
    <!-- END EMAIL -->

    <!-- BEGIN DASHBOARD -->
    <li>
        <a href=<?php echo base_url(); ?>index.php/parent/cards>
            <div class="gui-icon"><i class="md md-credit-card"></i></div>
            <span class="title">Cards</span>
        </a>
    </li><!--end /menu-li -->
    <li>
        <a href=<?php echo base_url(); ?>index.php/parent/events>
            <div class="gui-icon"><i class="md md-event"></i></div>
            <span class="title">Events</span>
        </a>
    </li><!--end /menu-li -->
    <li class="hide">
        <a href="" >
            <div class="gui-icon"><i class="md md-home"></i></div>
            <span class="title">Home Work</span>
        </a>
    </li><!--end /menu-li -->
    <li>
        <a href="comingsoon" >
            <div class="gui-icon"><i class="md md-image"></i></div>
            <span class="title">Gallery</span>
        </a>
    </li><!--end /menu-li -->
    <li>
        <a href=<?php echo base_url(); ?>index.php/parent/notice>
            <div class="gui-icon"><i class="fa fa-bullhorn"></i></div>
            <span class="title">Notice</span>
        </a>
    </li><!--end /menu-li -->

    <li>
        <a href=<?php echo base_url(); ?>index.php/parent/message >
            <div class="gui-icon"><i class="md md-chat"></i></div>
            <span class="title">My Messages</span>
        </a>
    </li><!--end /menu-li -->
    <li>
        <a href=<?php echo base_url(); ?>index.php/parent/allnotification >
            <div class="gui-icon"><i class="md md-notifications"></i></div>
            <span class="title">Notification</span>
        </a>
    </li><!--end /menu-li -->
    <li>
        <a href=<?php echo base_url(); ?>index.php/parent/examdatesheet>
            <div class="gui-icon"><i class="fa fa-calendar"></i></div>
            <span class="title">Exam Date Sheet</span>
        </a>
    </li><!--end /menu-li -->
    <!-- END DASHBOARD -->


</ul><!--end .main-menu -->