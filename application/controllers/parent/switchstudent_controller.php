<?php

class switchstudent_controller extends MY_Controller {

    public function SwitchStudent($adm_no) {
        $this->session->set_userdata(array("current_adm_no" => $adm_no));
        redirect("parent/homepage");
    }

}
