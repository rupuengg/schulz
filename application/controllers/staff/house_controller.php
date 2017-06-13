<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class house_controller extends MY_Controller {

    public function HouseDetails() {

        $this->load->view('staff/house/house_view.php');
    }
}
