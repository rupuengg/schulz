<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class comingsoon_controller extends MY_Controller {

    public function ComingSoon() {
        $this->load->view('parent/comingsoon.php');
    }

}
