<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class gallery_controller extends MY_Controller {


    public function LoadGallery() {
        $this->load->view('parent/gallery_view/gallery.php');
    }

}
