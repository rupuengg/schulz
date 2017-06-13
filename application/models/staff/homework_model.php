<?php

class homework_model extends CI_Model {

    public function TeacherSubjectList() {
        $staff_id = $this->session->userdata('staff_id');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.subject_id,b.section,b.standard,c.subject_name,b.id');
        $dbObj->from('subject_staff_relation as a');
        $dbObj->join('section_list as b', 'a.section_id=b.id');
        $dbObj->join('subject_list as c', 'a.subject_id=c.id');
        $dbObj->where('a.staff_id', $staff_id);
        $dbObj->where('b.status =', 1);
        $result = $dbObj->get()->result_array();
        return $result;
    }

    public function Loadhwmodel($myInputArr) {
        $staff_id = $this->session->userdata('staff_id');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        if ($myInputArr['homeworkType'] == 'HOMEWORK') {
            $dbObj->select('id,title,hw_date');
            $result = $dbObj->get_where('homework_master_list', array("entry_by" => $staff_id, "subject_id" => $myInputArr['subject_id'], "section_id" => $myInputArr['section_id'], "holiday" => $myInputArr['holidaytype'], "type" => $myInputArr['homeworkType']))->result_array();
            if (!empty($result)) {
                for ($i = 0; $i < count($result); $i++) {
                    $result[$i]['hw_date'] = date('d-M-Y', strtotime($result[$i]['hw_date']));
                }
                return $result;
            } else {
                return array();
            }
        } else if ($myInputArr['homeworkType'] == 'ASSIGNMENT') {
            $dbObj->select('id,title,hw_date');
            $result = $dbObj->get_where('homework_master_list', array("entry_by" => $staff_id, "holiday" => $myInputArr['holidaytype'], "type" => $myInputArr['homeworkType']))->result_array();
            if (!empty($result)) {
                for ($i = 0; $i < count($result); $i++) {
                    $result[$i]['hw_date'] = date('d-M-Y', strtotime($result[$i]['hw_date']));
                }
                return $result;
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    }

    public function PostHomework($mypostArr) {

        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $staff_id = $this->session->userdata('staff_id');
        $newPostDate = date("Y-m-d", strtotime($mypostArr['date']));
        $newSubDate = date("Y-m-d", strtotime($mypostArr['lastsubmissiondate']));
        if ($mypostArr['homeworkType'] == 'ASSIGNMENT') {
            $data = array("type" => $mypostArr['homeworkType'], "title" => $mypostArr['title'], "hw_date" => $newPostDate, "submission_last_date" => $newSubDate, "subject_id" => -1, "section_id" => -1, "holiday" => $mypostArr['holidaytype'], "entry_by" => $staff_id, "deo_entry_by" => $this->session->userdata('deo_staff_id'));
           
            $dbObj->insert('homework_master_list', $data);
            $hw_id = $dbObj->insert_id();
            if (!empty($mypostArr['importFiles'])) {
                foreach ($mypostArr['importFiles'] as $values) {
                    $dbObj->update('files_details', array('status' => 'TRUE'), array('upload_hint' => $mypostArr['uploadhint'], 'file_name' => $values));
                    $dbObj->update('homework_master_list', array('staff_uploadhint' => $mypostArr['uploadhint']), array('id' => $hw_id));
                }
            }
            if ($hw_id > 0) {
                $insertArr = array();
                for ($i = 0; $i < count($mypostArr['studentDeatils']); $i++) {
                    $insertArr[] = array("hw_id" => $hw_id, "adm_no" => $mypostArr['studentDeatils'][$i]['adm_no'], 'hw_submit_status' => "NO","entry_by" => $staff_id, "deo_entry_by" => $this->session->userdata('deo_staff_id'));
                }
                $dbObj->insert_batch('homework_student_relation', $insertArr);
                $last_id = $dbObj->insert_id();
                if ($last_id > 0) {
                    return $hw_id;
                } else {
                    return -1;
                }
            } else {
                return -1;
            }
        } else if ($mypostArr['homeworkType'] == 'HOMEWORK') {
            $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
            $data = array("type" => $mypostArr['homeworkType'], "title" => $mypostArr['title'], "hw_date" => $newPostDate, "submission_last_date" => $newSubDate, "subject_id" => $mypostArr['subject_id'], "section_id" => $mypostArr['section_id'], "holiday" => $mypostArr['holidaytype'], "entry_by" => $staff_id, "deo_entry_by" => $this->session->userdata('deo_staff_id'));
            $dbObj->insert('homework_master_list', $data);
            $hw_id = $dbObj->insert_id();
            if (!empty($mypostArr['importFiles'])) {
                foreach ($mypostArr['importFiles'] as $values) {
                    $dbObj->update('files_details', array('status' => 'TRUE'), array('upload_hint' => $mypostArr['uploadhint'], 'file_name' => $values));
                    $dbObj->update('homework_master_list', array('staff_uploadhint' => $mypostArr['uploadhint']), array('id' => $hw_id));
                }
            }
//            echo $hw_id;exit;
            if ($hw_id > 0) {
                $insertArr = array();
                $dbObj->select('adm_no');
                $StudentArr = $dbObj->get_where('biodata', array("section_id" => $mypostArr['section_id']))->result_array();
                for ($i = 0; $i < count($StudentArr); $i++) {
                    $insertArr[] = array("hw_id" => $hw_id, "adm_no" => $StudentArr[$i]['adm_no'], 'hw_submit_status' => "NO", "entry_by" => $staff_id, "deo_entry_by" => $this->session->userdata('deo_staff_id'));
                }
                $dbObj->insert_batch('homework_student_relation', $insertArr);
                $last_id = $dbObj->insert_id();
                if ($last_id > 0) {
                    return $hw_id;
                } else {
                    return -1;
                }
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    }

    public function HwDetail($hw_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,title,hw_date,submission_last_date,section_id,staff_uploadhint,subject_id');
        $hwresult = $dbObj->get_where('homework_master_list', array('id' => $hw_id))->row_array();
        $dbObj->select('holiday');
        $hmewrktype = $dbObj->get_where('homework_master_list',array('id'=>$hw_id))->row_array();
        if(strtoupper($hmewrktype['holiday']) == 'YES'){
            $hwresult['homewrktype'] = 'HOLIDAY';
        }else{
             $hwresult['homewrktype'] = 'DAILY';
        }
        if ($hwresult['staff_uploadhint']) {
            $hwresult['attcmnt_stats'] = 'true';
            $attachmnt_files = $this->getattchmnt($dbObj, $hwresult['staff_uploadhint']);
            $hwresult['upload_files'] = $attachmnt_files;
        } else {
            $hwresult['attcmnt_stats'] = 'false';
            $hwresult['upload_files'] = array();
        }
        $hwresult['date'] = date('d-M-Y', strtotime($hwresult['hw_date']));
        $hwresult['submissionlast_date'] = date('d-M-Y', strtotime($hwresult['submission_last_date']));
        $dbObj->select('count(adm_no)');
        $totalst_no = $dbObj->get_where('biodata', array('section_id' => $hwresult['section_id']))->row_array();
        $dbObj->select('count(adm_no)');
        $hwstd = $dbObj->get_where('homework_student_relation', array('hw_id' => $hw_id, 'hw_submit_status' => "YES"))->row_array();
//        print_r($hwstd);
//        exit;
        $totalnotdonhwstd = ($totalst_no['count(adm_no)'] - $hwstd['count(adm_no)']);
        $hwresult['totalstd'] = $totalst_no['count(adm_no)'];
        $hwresult['totaldonstd'] = $hwstd['count(adm_no)'];
        $hwresult['notdonstd'] = $totalnotdonhwstd;
        $stddetail = $this->stddetail($dbObj, $hw_id);
        $FinalArr = array();
        $FinalArr['hwfulldetail'] = $hwresult;
        $FinalArr['stddetail'] = $stddetail;
//        print_r($FinalArr);exit();
        return $FinalArr;
    }

    public function getattchmnt($dbObj, $uploadhint) {
//        print_r($uploadhint);exit;
        $dbObj->select('file_name,file_path');
        $allresult = $dbObj->get_where('files_details', array('upload_hint' => $uploadhint, 'status' => 'TRUE'))->result_array();
        return $allresult;
    }

    public function stddetail($dbObj, $hw_id) {
        $dbObj->select('a.adm_no,a.hw_submit_status,a.timestamp,b.firstname,b.lastname,c.section,c.standard');
        $dbObj->from('homework_student_relation as a');
        $dbObj->join('biodata as b', 'a.adm_no=b.adm_no');
        $dbObj->join('section_list as c', 'b.section_id=c.id');
        $dbObj->where('a.hw_id', $hw_id);
        $allresult = $dbObj->get()->result_array();
        return $allresult;
    }

    public function StudeltAll($stdsection_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('adm_no,firstname,lastname');
        $dbObj->from('biodata');
        $dbObj->where('section_id', $stdsection_id);
        $result = $dbObj->get()->result_array();
        return $result;
    }

    public function GetFullAssignmentDetail($hw_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('title,type,hw_date,submission_last_date,staff_uploadhint');
        $assignmentfull = $dbObj->get_where('homework_master_list', array('id' => $hw_id))->row_array();
        if ($assignmentfull['staff_uploadhint']) {
            $assignmentfull['attcmnt_stats'] = 'true';
            $attachmnt_files = $this->getattchmnt($dbObj, $assignmentfull['staff_uploadhint']);
            $assignmentfull['upload_files'] = $attachmnt_files;
        } else {
            $assignmentfull['attcmnt_stats'] = 'false';
            $assignmentfull['upload_files'] = array();
        }
        $countworkdone = $this->CountDoneAssignmentStudent($hw_id);
        $counttotalassign = $this->CountTotalAssign($hw_id);
        $countworknotdone = $counttotalassign - $countworkdone;
        $getallassignstudent = $this->GetAllAssignStudent($hw_id);
        $assignmentfull['workdone'] = $countworkdone;
        $assignmentfull['totalassign'] = $counttotalassign;
        $assignmentfull['worknotdone'] = $countworknotdone;
        $assignmentfull['hw_date'] = date('d-M-Y', strtotime($assignmentfull['hw_date']));
        $assignmentfull['submission_last_date'] = date('d-M-Y', strtotime($assignmentfull['submission_last_date']));
        $finalAssignmentArr = array();
        $finalAssignmentArr['fulldetail'] = $assignmentfull;
        $finalAssignmentArr['StudentDetail'] = $getallassignstudent;
        if (!empty($finalAssignmentArr)) {
           
            return $finalAssignmentArr;
        } else {
            return -1;
        }
    }

    public function CountDoneAssignmentStudent($hw_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(adm_no) as count');
        $result = $dbObj->get_where('homework_student_relation', array('hw_id' => $hw_id, 'hw_submit_status' => "YES"))->row_array();
        return $result['count'];
    }

    public function CountTotalAssign($hw_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('count(adm_no) as count');
        $result = $dbObj->get_where('homework_student_relation', array('hw_id' => $hw_id))->row_array();
        return $result['count'];
    }

    public function GetAllAssignStudent($hw_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.firstname,a.lastname,a.adm_no,b.hw_submit_status,c.section,c.standard');
        $dbObj->from('biodata as a');
        $dbObj->join('homework_student_relation as b', 'a.adm_no=b.adm_no');
        $dbObj->join('section_list as c', 'a.section_id=c.id');
        $dbObj->where('b.hw_id', $hw_id);
        $result = $dbObj->get()->result_array();
        return $result;
    }

    public function Getstuddet($adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $name = $this->getname($adm_no, $dbObj);
        $dbObj->select('hw_id,hw_submit_status,timestamp');
        $stu_hwlist = $dbObj->get_where('homework_student_relation', array('adm_no' => $adm_no))->result_array();
        for ($i = 0; $i < count($stu_hwlist); $i++) {
            $hw_id = $stu_hwlist[$i]['hw_id'];
            $dbObj->select('title,type,hw_date,submission_last_date');
            $stu_hwtitle[] = $dbObj->get_where('homework_master_list', array('id' => $hw_id))->row_array();
            $stu_hwtitle[$i]['hw_submit_status'] = $stu_hwlist[$i]['hw_submit_status'];
            $stu_hwtitle[$i]['hw_date'] = date('d-M-Y', strtotime($stu_hwtitle[$i]['hw_date']));
            if ($stu_hwtitle[$i]['hw_submit_status'] == 'YES') {
                $stu_hwtitle[$i]['timestamp'] = date('d-M-Y', strtotime($stu_hwlist[$i]['timestamp']));
                $stu_hwtitle[$i]['hw_submit_status'] = "Submitted";
            } else {
                $stu_hwtitle[$i]['timestamp'] = "-";
                $stu_hwtitle[$i]['hw_submit_status'] = "Not Submitted";
            }
        }
        $stu_name = $adm_no . "." . $name['firstname'] . " " . $name['lastname'];
        $finalarr = array('stu_hwtitle' => $stu_hwtitle, 'stu_name' => $stu_name);
        return $finalarr;
    }

    public function getname($adm_no, $dbObj) {
        $dbObj->select('firstname,lastname');
        $stu_name = $dbObj->get_where('biodata', array('adm_no' => $adm_no))->row_array();
        return $stu_name;
    }

    public function MyFileUploads($path, $filename, $file_type, $upload_hint) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data = array('file_name' => $filename, 'file_path' => $path, 'file_type' => $file_type, 'upload_hint' => $upload_hint, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
        $dbObj->insert('files_details', $data);
        $insrt_id = $dbObj->insert_id();
        return $insrt_id;
    }

}
