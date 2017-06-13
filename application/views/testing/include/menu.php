<ul id="main-menu" class="gui-controls">
    <!-- BEGIN DASHBOARD -->
    <li>
        <a href="dashboard.html" class="active">
            <div class="gui-icon"><i class="md md-home"></i></div>
            <span class="title">Dashboard</span>
        </a>
    </li><!--end /menu-li -->
    <!-- END DASHBOARD -->

    <!-- BEGIN EMAIL -->

    <li class="gui-folder">
        <a>
            <div class="gui-icon"><i class="md md-web"></i></div>
            <span class="title">General</span>
        </a>
        <ul>
            <li><a href="<?php echo base_url(); ?>index.php/testing/company" ><span class="title">My Dashboard</span></a></li>

        </ul>
    </li>
    <?php if ($this->session->userdata('admin_type') == 1) { ?>
        <li class="gui-folder">
            <a>
                <div class="gui-icon"><i class="md md-my-library-books"></i></div>
                <span class="title">School Module</span>
            </a>
            <ul>
                <li><a><span class="title">Customer Care</span></a></li>

            </ul>
        </li>
    <?php } ?>
    <li class="gui-folder">
        <a>
            <div class="gui-icon"><i class="md md-assessment"></i></div>
            <span class="title">Project Testing</span>
        </a>
        <ul>
            <li><a href="<?php echo base_url(); ?>index.php/testing/bugpost" ><span class="title">Post Bug</span></a></li>
            <li><a href="<?php echo base_url(); ?>index.php/testing/testerbugdetail" ><span class="title">Bug details for Tester</span></a></li>
            <li><a href="<?php echo base_url(); ?>index.php/testing/developerbugdetail" ><span class="title">Bug details for Developer</span></a></li>
        </ul>
    </li>
    <li class="gui-folder">
        <a>
            <div class="gui-icon"><i class="md md-toc"></i></div>
            <span class="title">My Activity Report</span>
        </a>
        <ul><li><a href="<?php echo base_url(); ?>index.php/activity/empactivityentry" ><span class="title">Punch Activity</span></a></li></ul>

        <?php if ($this->session->userdata('admin_type') == 1) { ?>
        <li class="gui-folder">
            <a>
                <div class="gui-icon"><i class="md md-recent-actors"></i></div>
                <span class="title">Reports</span>
            </a>
            <ul><li><a href="<?php echo base_url(); ?>index.php/activity/viewactivity" ><span class="title">Employee Activity Report</span></a></li></ul>
        </li>
        <li class="gui-folder">
            <a>
                <div class="gui-icon"><i class="md md-settings"></i></div>
                <span class="title">Master Setting</span>
            </a>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/activity/addemployee" ><span class="title">Employee Management</span></a></li>
                <li><a href="<?php echo base_url(); ?>index.php/testing/manageproject" ><span class="title">Project Master </span></a></li>
                <li><a href="<?php echo base_url(); ?>index.php/activity/addactivity" ><span class="title">Activity Master </span></a></li>
                <li><a href="<?php echo base_url(); ?>index.php/activity/adddesignation" ><span class="title">Designation Master </span></a></li>
                <li><a href="<?php echo base_url(); ?>index.php/activity/userid" ><span class="title">Generate Userid </span></a></li>
            </ul>
        </li>
    <?php } ?>
</ul>
<div class="menubar-foot-panel">
    <small class="no-linebreak hidden-folded">
        <span class="opacity-75">Copyright &copy; 2014</span> <strong>CodeCovers</strong>
    </small>
</div>