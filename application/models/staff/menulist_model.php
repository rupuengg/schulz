<?php

class menulist_model extends CI_Model {

    public function GetMenuList() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('menuid,menucaption');
        $menuList = $dbObj->get('staff_main_menu_list')->result_array();
        return $menuList;
    }

}
