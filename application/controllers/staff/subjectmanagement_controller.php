<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class subjectmanagement_controller extends MY_Controller {

    public function addSubject($class = '-1') {
        $this->load->model('core/core', 'dbobj');
        $classList = $this->dbobj->getClassList();

        $this->load->view('staff/subject_view/mgtsubject', array("class" => $class, "myclassarr" => $classList));
    }

    public function managesubjectteacher($section_id = -1) {
        $this->load->model('core/core', 'dbobj');
        $section_list = $this->dbobj->getSectionlist();
        $standard = $this->dbobj->GetStandardFromSection_id($section_id);
        if ($section_id == -1) {
            
        } else {

            $this->load->model('core/subject', 'submodel');
            $this->submodel->fillSubjectTeacherMasterData($section_id);
        }
        $this->load->view('staff/subject_view/subjectteacherassign', array("section_id" => $section_id, "section_list" => $section_list,"standard"=>$standard));
    }

}
