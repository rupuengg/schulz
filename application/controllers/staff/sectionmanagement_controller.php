<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class sectionmanagement_controller extends MY_Controller {

    public function addSection($sectionType = 'ACT') {
        $this->load->view('staff/section_view/addsection', array("sectionType" => $sectionType));
    }

    public function addclassteacher() {
        $this->load->view('staff/section_view/addclassteacher');
    }

}
