<?php

class menulist_controller extends MY_Controller {

    public function MenuList($menuId = -1) {
        $this->load->model('staff/menulist_model', 'modelObj');
        $menuList = $this->modelObj->GetMenuList();
        $this->load->view('staff/menulist/menulist_view',array("menuList"=>$menuList,"menuId"=>$menuId));
    }

}
