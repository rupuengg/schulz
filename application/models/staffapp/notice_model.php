<?php

class notice_model extends CI_Model {

     public function GetNotice($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('notice_content,entry_by,timestamp');
        $dbObj->limit(5);
        $dbObj->order_by('timestamp','DESC');
        $notice_data = $dbObj->get('notice_details')->result_array();
        $fin_arr = array();
        $this->load->model('staffapp/staffapp_core', 'coreObj');
        for ($i = 0; $i < count($notice_data); $i++) {
            $staffName = $this->coreObj->GetImportentDetails($notice_data[$i]['entry_by'], $dataObj['database']);
            $notice_date = date('dS M Y', strtotime($notice_data[$i]['timestamp']));
            $fin_arr[] = array('notice_desc' => $notice_data[$i]['notice_content'], 'sender' => 'By ' . $staffName['staff_fname'].' '. $staffName['staff_lname'], 'send_date' => $notice_date);
        }
        return $fin_arr;
    }

    public function GetStaffNoticeCount($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('count(id) as staff_count');
        $dbObj->where('status', 'ACTIVE');
        $notice_Staff_count = $dbObj->get('staff_details')->row_array();
        $dbObj->select('count(adm_no) as student_count');
        $notice_Student_count = $dbObj->get('biodata')->row_array();
        $fin_arr = array('staff_count' => $notice_Staff_count['staff_count'], 'student_count' => $notice_Student_count['student_count']);
        return $fin_arr;
    }

    public function saveNoticeSendDetail($dataObj, $postDataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $data = array('title' => $postDataObj['notice_title'],
            'notice_content' => $postDataObj['notice_msg'],
            'notice_type' => strtoupper($postDataObj['notice_type']),
            'entry_by' => $postDataObj['staff_id'],
            'deo_entry_by' => -1,);
        $dbObj->insert('notice_details',$data);
        $lastInsertId = $dbObj->insert_id();
        $staffId = $this->getstaffId($dbObj);
        if (empty($staffId)) {
            return -1;
        }
        $admNo = $this->getAdmno($dbObj);
        if (empty($admNo)) {
            return -1;
        }
        $insertStaffNoticeRelation = array();
        $insertStudentNoticeRelation = array();
        switch (strtoupper($postDataObj['notice_type'])) {
            case 'SCHOOL':
                foreach ($staffId as $val) {
                    $insertStaffNoticeRelation[] = array('notice_id' => $lastInsertId, 'notice_to_id' => $val['id'], 'notice_type' => strtoupper($postDataObj['notice_type']), 'entry_by' => $postDataObj['staff_id'], 'deo_entry_by' => -1);
                }
                foreach ($admNo as $row) {
                    $insertStudentNoticeRelation[] = array('notice_id' => $lastInsertId, 'notice_to_id' => $row['adm_no'], 'notice_type' => strtoupper($postDataObj['notice_type']), 'entry_by' => $postDataObj['staff_id'], 'deo_entry_by' => -1);
                }
                if (count($insertStaffNoticeRelation) > 0 && count($insertStudentNoticeRelation) > 0) {
                    $dbObj->insert_batch('notice_relation', $insertStaffNoticeRelation);
                    $dbObj->insert_batch('notice_relation', $insertStudentNoticeRelation);
                    $lstInsertId = $dbObj->insert_id();
                    return $lstInsertId;
                } else {
                    return -1;
                }
                break;
            case 'ALLSTAFF':
                foreach ($staffId as $val) {
                    $insertStaffNoticeRelation[] = array('notice_id' => $lastInsertId, 'notice_to_id' => $val['id'], 'notice_type' => strtoupper($postDataObj['notice_type']), 'entry_by' => $postDataObj['staff_id'], 'deo_entry_by' => -1);
                }

                if (count($insertStaffNoticeRelation) > 0) {
                    $dbObj->insert_batch('notice_relation', $insertStaffNoticeRelation);
                    $lstInsertId = $dbObj->insert_id();
                    return $lstInsertId;
                } else {
                    return -1;
                }
                break;

            case 'ALLSTUDENT':
                foreach ($admNo as $row) {
                    $insertStudentNoticeRelation[] = array('notice_id' => $lastInsertId, 'notice_to_id' => $row['adm_no'], 'notice_type' => strtoupper($postDataObj['notice_type']), 'entry_by' => $postDataObj['staff_id'], 'deo_entry_by' => -1);
                }
                if (count($insertStudentNoticeRelation) > 0) {
                    $dbObj->insert_batch('notice_relation', $insertStudentNoticeRelation);
                    $lstInsertId = $dbObj->insert_id();
                    return $lstInsertId;
                } else {
                    return -1;
                }
                break;

            default:
                return 'INVALIDTYPE';
                break;
        }
    }

    public function getstaffId($dbObj) {
        $dbObj->select('id');
        $data = $dbObj->get_where('staff_details', array('status' => 'ACTIVE'))->result_array();
        if (!empty($data)) {
            return $data;
        } else {
            return -1;
        }
    }

    public function getAdmno($dbObj) {
        $dbObj->select('a.adm_no');
        $dbObj->from('biodata as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->where('b.status', 1);
        $data = $dbObj->get()->result_array();
        if (!empty($data)) {
            return $data;
        } else {
            return -1;
        }
    }

}
