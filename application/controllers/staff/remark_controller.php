<?php

/**
 * Description of StudentProfile
 *
 * @author Ashish
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class remark_controller extends MY_Controller {

    public function remark_entry_subject() {
        $page_type = 'SUBJECT';
        $this->load->view("staff/remarks/subject_remark_view", array("page_type" => $page_type));
    }

    public function remark_entry_gen() {
        $page_type = 'GENERAL';
        $this->load->view("staff/remarks/general_remark_view", array("page_type" => $page_type));
    }

    public function loadremarkstudents() {
        $this->load->model('staff/remark_model', 'remarkstudent');
        $staff_id = $this->session->userdata('staff_id');
        $dataoutput = $this->remarkstudent->getStudentData($this->input->post('data'), $staff_id, $this->input->post('page'));
        try {
            echo ($dataoutput);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function loadSectionstudents() {
        $data = json_decode($this->input->post('data'));
        $this->load->model('staff/remark_model', 'remarkstudent');
        $dataoutput = $this->remarkstudent->getStudentListOfSection($data->id);
        try {
            echo ($dataoutput);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function getstaffsubjects() {
        $this->load->model('staff/remark_model', 'remarkstudent');
        $staff_id = $this->session->userdata('staff_id');
        //$staff_id=25;
        $dataoutput = $this->remarkstudent->getstaffsubjectlist($staff_id);
        try {
            echo ($dataoutput);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function savesubjectremark() {
        $this->load->model('staff/remark_model', 'remarkstudent');
        $staff_id = $this->session->userdata('staff_id');
        //$staff_id = 25;
        $deo_id = -1;
        $dataoutput = $this->remarkstudent->savesubjectremarkdata($this->input->post('data'), $deo_id, $staff_id, $this->input->post('page'));
        try {
            if ($dataoutput) {
                echo printCustomMsg("TRUE", "Remark Succesfully Saved", $dataoutput);
            } else {
                echo printCustomMsg("ERRINPUT", "Oops! Something went wrong.", -1);
            };
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function deleteRemark() {
        $this->load->model('staff/remark_model', 'deleteAllRemark');
        $dataoutput = $this->deleteAllRemark->deleteAllRemark($this->input->post('data'));
        try {
            if ($dataoutput) {
                echo printCustomMsg("TRUE", "Remark Succesfully Deleted", $dataoutput);
            } else {
                echo printCustomMsg("ERRINPUT", "Oops! Something went wrong.", -1);
            };
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

    public function loadSectionList() {
        $this->load->model('staff/remark_model', 'remarkstudent');
        $dataoutput = $this->remarkstudent->getSectioList();
        try {
            echo ($dataoutput);
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

}
