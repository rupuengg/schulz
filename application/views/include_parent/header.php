<?php
$childList = $this->session->userdata('childList');
$cur_adm_no = $this->session->userdata('current_adm_no');
for ($j = 0; $j < count($childList); $j++) {
    if ($childList[$j]['adm_no'] == $cur_adm_no) {
        $currentStudent = array(
            "adm_no" => $childList[$j]['adm_no'],
            "name" => $childList[$j]['firstname'] . ' ' . $childList[$j]['lastname'],
            "class" => $childList[$j]['standard'] . ' ' . $childList[$j]['section']
        );
        $currentname = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($childList[$j]['firstname'] . ' ' . $childList[$j]['lastname']))));
        $this->session->set_userdata(array("current_name" => $currentname));
        $this->session->set_userdata(array("current_class" => $childList[$j]['standard'] . ' ' . $childList[$j]['section']));
    }
}
?>

<header id="header"  class="header-inverse header-fixed">

    <div class="headerbar">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="headerbar-left">
            <ul class="header-nav header-nav-options">
                <li class="header-nav-brand" >
                    <div class="brand-holder">
                        <a href="<?php echo base_url(); ?>">
                            <span class="text-lg text-bold text-primary"><?php echo $this->session->userdata('brand_name'); ?></span>
                        </a>
                    </div>
                </li>
                <li>
                    <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="headerbar-right" >
            <!--            <ul class="header-nav header-nav-options">
                            <li class="dropdown hidden-xs">
                                <a href="javascript:void(0);" class="btn btn-icon-toggle btn-default" data-toggle="dropdown">
                                    <i class="fa fa-bell"></i><sup class="badge style-danger">4</sup>
                                </a>
                                <ul class="dropdown-menu animation-expand">
                                    <li class="dropdown-header">Today's messages</li>
                                    <li>
                                        <a class="alert alert-callout alert-warning" href="javascript:void(0);">
                                            <img class="pull-right img-circle dropdown-avatar" src="../../assets/staff/1.jpg" alt="" />
                                            <strong>Sunil Kumar</strong><br/>
                                            <small>Fee receipt generated</small>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="alert alert-callout alert-info" href="javascript:void(0);">
                                            <img class="pull-right img-circle dropdown-avatar" src="../../assets/staff/2.jpg" alt="" />
                                            <strong>School Admin</strong><br/>
                                            <small>Holiday tomorrow</small>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="alert alert-callout alert-blue" href="javascript:void(0);">
                                            <img class="pull-right img-circle dropdown-avatar" src="../../assets/staff/1.jpg" alt="" />
                                            <strong>Sunil Kumar</strong><br/>
                                            <small>Blue card issued for ...</small>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="javascript:void(0);">View all messages </a></li>
            
                                </ul>end .dropdown-menu 
                            </li>end .dropdown 
            
                        </ul>end .header-nav-options -->
            <ul class="header-nav header-nav-profile">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                        <img src="<?php echo base_url() . "index.php/staff/getstudphoto/" . $cur_adm_no . "/THUMB"; ?>" alt="" />
                        <span class="profile-info">
                            <b><?php echo $this->session->userdata('current_name');
;
?>
                                <small><?php echo $this->session->userdata('current_class');
                                ;
?></small>
                            </b>
                        </span>
                    </a>
                    <ul class="dropdown-menu animation-dock">
                        <li class="dropdown-header">Student List</li>
<?php for ($i = 0; $i < count($childList); $i++) { ?>
                            <li >
                                <a href="<?php echo base_url(); ?>index.php/parent/switchstudent/<?php echo $childList[$i]['adm_no'] ?>" class="alert alert-callout alert-success">
                                    <img src="<?php echo base_url() . "index.php/staff/getstudphoto/" . $childList[$i]['adm_no'] . "/THUMB"; ?>" class="pull-right img-circle dropdown-avatar">
                                    <strong><?php echo $childList[$i]['firstname'] . ' ' . $childList[$i]['lastname'] ?></strong><br>
                                    <small>Section : <?php echo $childList[$i]['standard'] . ' ' . $childList[$i]['section'] ?></small>
                                </a>
                            </li>
<?php } ?>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php/login/resetpassword"><i class="fa fa-fw fa-key text-info"></i> Change Password</a></li>

                    </ul><!--end .dropdown-menu -->
                </li><!--end .dropdown -->
            </ul><!--end .header-nav-profile -->
            <ul class="header-nav header-nav-toggle">
                <li>
                    <a href="<?php echo site_url('login/logout'); ?>"> <button class="btn btn-danger">
                            <i class="fa fa-fw fa-power-off"></i>
                        </button> </a>
                </li>
            </ul><!--end .header-nav-toggle -->
        </div><!--end #header-navbar-collapse -->
    </div>
    <script>var myURL = "<?php echo base_url(); ?>";</script>
</header>