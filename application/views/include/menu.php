<ul id="main-menu" class="gui-controls">
    <?php
    $urlData = explode("/", uri_string());
    $myFinalURL=array();
    $uriString="";
    for($i=0; $i<2; $i++) {
        $myFinalURL[]=$urlData[$i]; 
    }
    if(count($myFinalURL)>0){
        $uriString=  implode("/", $myFinalURL);
       
    }
    foreach ($this->session->userdata('staffMenu') as $value) {
        $childCount = checkSelectedChildMenu($value['childDetail'],$uriString);
        if ($childCount['count'] > 0) {
            if ($childCount['count'] == 1) {

                foreach ($value['childDetail'] as $value1) {
                    if ($value1['selected']) {
                        ?>
                        <li class="expanding">
                            <a class="<?php echo $childCount['selectedClass']; ?>" href="<?php echo base_url() . $value1['page_url']; ?>">
                                <div class="gui-icon"><i class="md <?php echo $value['class']; ?>"></i></div>
                                <span class="title"><?php echo $value1['childcaption']; ?></span>
                            </a>
                        </li>

                        <?php
                    }
                }
                ?>

                <?php
            } else {
                ?>
                <li class="gui-folder">
                    <a class="<?php echo $childCount['selectedClass']; ?>">
                        <div class="gui-icon"><i class="md <?php echo $value['class']; ?>"></i></div>
                        <span class="title"><?php echo $value['menuname']; ?></span>
                    </a>
                    <!--start submenu -->
                    <ul>
                        <?php
                        foreach ($value['childDetail'] as $value) {
                            if ($value['selected']) {
                                ?>
                                <li><a href="<?php echo base_url() . $value['page_url']; ?>" ><span class="title"><?php echo $value['childcaption']; ?></span></a></li>

                                <?php
                            }
                        }
                        ?>


                    </ul><!--end /submenu -->
                </li>
                <?php
            }
        }
    }

    function checkSelectedChildMenu($childDetail,$uriString) {
        $count = 0;
        $selectedClass="";
        foreach ($childDetail as $value) {
            if ($value['selected']) {
               
                if($value['page_url']=="index.php/$uriString"){
                 $selectedClass='active';
                }
                $count++;
            }
        }
        return array("count"=>$count,"selectedClass"=>$selectedClass);
    }
    ?>
    <!--end /menu-li -->

</ul>
<div class="menubar-foot-panel">
    <small class="no-linebreak hidden-folded">
        <span class="opacity-75">Copyright &copy; <?php echo date('Y') ?></span> <a target="_blank" href="http://www.invetechsolutions.com/"><strong>Invetech Solutions</strong></a>
    </small>
</div>