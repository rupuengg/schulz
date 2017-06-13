<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class combomanagement_controller extends MY_Controller {

    public function manage_combos($class = NULL, $combo_id = NULL) {
        $combo_name = '';
        $combosubjects = '';
        $classsubjects = '';
        $this->load->model('core/core', 'ObjModel');
        $classList = $this->ObjModel->getClassList();
        $page_type = 'COMBOONLY';
        if ($combo_id != NULL) {
            $this->load->model('core/combo', 'objCombo');
            $comboname = $this->objCombo->getComboName($combo_id);
            $combo_name = $comboname[0]['combo_name'];
            $combosubjects = $this->objCombo->getComboSubjects($combo_id);
            $classsubjects = $this->objCombo->getClassSubjects($class);
        }
        $this->load->view('staff/combo_view/mgtcombo', array("pagetype" => $page_type, "class" => $class, "myclassarr" => $classList, "combo_id" => $combo_id, "combo_name" => $combo_name, "combosubjects" => $combosubjects, "classsubjects" => $classsubjects));
    }

    public function manage_combo_and_assign_to_section($class = '-1', $section_id = '-1') {
        $classsubjects = '';
        $combosinclass = '';
        $combosinsection = '';

        $this->load->model('core/core', 'objModel');
        $classList = $this->objModel->getClassList();
        $section_list = $this->objModel->getSectionlistfromclass($class);
        $this->load->model('core/combo', 'objcombo');
        $combosinclass = $this->objcombo->getcombosinclass($class);
        if ($section_id != -1) {
            $combosinsection = $this->objcombo->getcombosinsection($section_id);
        }

        $page_type = 'COMBOSECTION';
        $this->load->view('staff/combo_view/mgtcombo', array("pagetype" => $page_type, "class" => $class, "section_list" => $section_list, "combo_id" => '-1', "myclassarr" => $classList, "section_id" => $section_id, "comboinclass" => $combosinclass, "comboinsection" => $combosinsection));
    }

    public function combosectionsave() {
        $this->load->model('core/combo', 'objcombosave');
        $classList = $this->objcombosave->combosectionsave($this->input->post('data'));
    }

    public function save_combo() {
        $this->load->model('core/combo', 'objcombo');
        $classList = $this->objcombo->savecombodata($this->input->post('data'));
    }

    // Adarsh Module Assign Combo to student
    public function AssignSubjectCombo() {
        $this->load->view('staff/combo_view/assigncombo_view', array("data" => 1));
    }

    public function loadSectiondetails() {
        $this->load->model('staff/assigncombotostudent_model', 'objStaffdetail');
        $section = $this->objStaffdetail->getsectionlist();
        $output = array();
        $output['section'] = $section;
        try {
            echo json_encode($output);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function loadCombodetails() {
        $sectionid = $this->input->post('data');
        $this->load->model('staff/assigncombotostudent_model', 'objStaffdetail');
        $section = $this->objStaffdetail->getCombolist($sectionid);
        $student = $this->objStaffdetail->getStudentlist($sectionid);
        $output = array();
        $output['combo'] = $section;
        $output['student'] = $student;
        try {
            echo json_encode($output);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function AssignCombo() {
        $this->load->model('staff/assigncombotostudent_model', 'objStaffdetail');
        $assign = $this->objStaffdetail->assignComboTo();
        try {
            echo json_encode($assign);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function DeleteCombo() {
        $this->load->model('staff/assigncombotostudent_model', 'objStaffdetail');
        $delete = $this->objStaffdetail->DeleteComboTo();
    }

}
