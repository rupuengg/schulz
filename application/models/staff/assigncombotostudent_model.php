<?php

class assigncombotostudent_model extends CI_Model {

    public function getsectionlist() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $given_sec = ['A', 'B', 'C', 'D'];
        $dbObj->select('id,standard,section');
        $dbObj->group_by('order');
        $dbObj->where_in('section', $given_sec);
        $details = $dbObj->get_where("section_list")->result_array();
        $details_new = array_filter($details);
        return $details_new;
    }

    public function getCombolist($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $query1 = "SELECT a.`combo_name`,b.`combo_id` FROM `combo_section_relation` as b, `combo_details` as a WHERE b.`section_id` = $id AND a.`id` = b.`combo_id`";
        $combo_id = $dbObj->query($query1)->result_array();
        $dataArray = array();
        for ($i = 0; $i < count($combo_id); $i++) {
            $subjectArray = array();
            $c_id = $combo_id[$i]['combo_id'];
            $query2 = "SELECT a.`subject_name` FROM `combo_subject_relation` as b, `subject_list` as a WHERE b.`combo_id` = '$c_id' AND a.`id` = b.`subject_id`";
            $subject = $dbObj->query($query2)->result_array();
            $subjectArray = $subject;
            $subjectArray['comboid'] = $combo_id[$i]['combo_id'];
            $subjectArray['comboname'] = $combo_id[$i]['combo_name'];
            $dataArray[] = array_merge($dataArray, $subjectArray);
        }
        return $combo_id;
    }

    public function getStudentlist($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('adm_no,firstname,lastname,profile_pic_path,combo_id');
        $details = $dbObj->get_where("biodata", array("section_id" => $id))->result_array();
        for ($k = 0; $k < count($details); $k++) {
            $adm_no = $details[$k]['adm_no'];
            $combo_id = $details[$k]['combo_id'];
            if (($combo_id) != '-1') {
                $details[$k]['assign'] = 'Assigned';
                $details[$k]['display'] = true;
                $dbObj->select('combo_name,combo_desp');
                $comboname = $dbObj->get_where("combo_details", array("id" => $combo_id))->result_array();
                if (!empty($comboname)) {
                    $details[$k]['combo'] = $comboname[0]['combo_name'];
                    $details[$k]['displaycombo'] = $comboname[0]['combo_desp'];
                } else {
                    $details[$k]['combo'] = '';
                    $details[$k]['displaycombo'] = '';
                }
            } else {
                $details[$k]['assign'] = 'Not Assigned';
                $details[$k]['display'] = FALSE;
            }
        }

        return $details;
    }

    public function getSubjectList($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $query = "SELECT a.`id` FROM `combo_subject_relation` as b, `subject_list` as a WHERE b.`combo_id` = '$id' AND a.`id` = b.`subject_id`";
        $subject = $dbObj->query($query)->result_array();
        return $subject;
    }

    public function assignComboTo() {
        $dataArray = json_decode($this->input->post('data'), TRUE);
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $comboid = $this->input->post('comboid');
        $entry_by = $this->input->post('entry_by');
        $this->load->model('staff/assigncombotostudent_model', 'objStaffdetail');
        for ($i = 0; $i < count($dataArray); $i++) {
            if (isset($dataArray[$i]['checked'])) {
                $admno = $dataArray[$i]['adm_no'];
                $subjectid = $this->objStaffdetail->getSubjectList($comboid);
                $dbObj->delete('student_subject_relation', array('adm_no' => $admno));
                for ($k = 0; $k < count($subjectid); $k++) {
                    $subject = $subjectid[$k]['id'];
                    $data_insert[] = array(
                        'adm_no' => $admno,
                        'subject_id' => $subject,
                        'entry_by' => $entry_by
                    );
                }
                $dbObj->insert_batch('student_subject_relation', $data_insert);
                try {
                    
                } catch (Exception $err) {
                    echo $dbObj->last_query();
                }
            }
            $dbObj->update('biodata', array('combo_id' => $comboid), array('adm_no' => $admno));
        }
        
    }

    public function DeleteComboTo() {
        $admno = $this->input->post('data');
        $dbObject = $this->load->database($this->session->userdata('database'), TRUE);
        if ($dbObject->delete('student_subject_relation', array('adm_no' => $admno))) {
            $dbObject->update('biodata', array('combo_id' => '-1'), array('adm_no' => $admno));
            echo 'Combo Successfully Deleted!';
        } else {
            echo 'Oops! Something went wrong.';
        };
    }

}
