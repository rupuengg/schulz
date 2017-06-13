<?php

class marksentry_model extends CI_Model {

    public function GetAllSubjectName($staff_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $query = "SELECT c.`subject_name`,c.`id` as sub_id,a.`standard`,a.`section`,a.`id` as section_id FROM `subject_staff_relation` as b ,`section_list` as a,`subject_list` as c WHERE  b.`staff_id`='$staff_id' AND c.`id`= b.`subject_id`AND a.`id`=b.`section_id` AND a.`status`='1'";
        return $dbObj->query($query)->result_array();
    }

    public function GetMyExamList($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('DISTINCT(standard)');
        $standard = $dbObj->get_where('section_list', array('id' => $data['section_id']))->row_array();
        dx:
        $dbObj->select('id,exam_name,subject_id,section_id,max_marks,exam_master_id');
        $result = $dbObj->get_where('exam_settings', array('section_id' => $data['section_id'], 'subject_id' => $data['sub_id']))->result_array();
        if (count($result) > 0) {
            return $result;
        } else {
            $standard = $standard['standard'];
            $subId = $data['sub_id'];
            $sectionId = $data['section_id'];
            $query = "INSERT INTO exam_settings (exam_master_id, subject_id, section_id,exam_name,max_marks) SELECT id,$subId,$sectionId, exam_name, max_marks FROM exam_master_list where class='$standard'";
            $dbObj->query($query);
            $lastInsertId = $dbObj->insert_id();
            if ($lastInsertId) {
                goto dx;
            } else {
                return -1;
            }
        }
    }

    public function GetMyExamPart($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('sum(max_marks) as total');
        $sum = $dbObj->get_where('exam_parts_details', array('exam_id' => $dataObj->id))->result_array();

        $sum_mrk = (int) $sum[0]['total'];
        $max = (int) $dataObj->max_marks;
        if ($sum[0]['total'] < $dataObj->max_marks) {
            $output['status'] = 'TRUE';
            $output['sum'] = (int) $sum[0]['total'];
            $output['remaining_mrk'] = ($max - $sum_mrk);
        } else {
            $output['status'] = 'FLASE';
            $output['sum'] = '0';
            $output['remaining_mrk'] = ($max - $sum_mrk);
        }
        $dbObj->select('id,exam_id,part_name,max_marks');
        $output['part_detail'] = $dbObj->get_where('exam_parts_details', array('exam_id' => $dataObj->id))->result_array();
//        print_r($output);
//        exit;
        $dbObj->select('adm_no,firstname as fname,lastname as lname,profile_pic_path_thumbnail as pic');
        $studentList = $dbObj->get_where('biodata', array('section_id' => $dataObj->section_id))->result_array();
//        print_r($studentList);
//        exit;
        for ($i = 0; $i < count($studentList); $i++) {
            $allmarks = array();
            for ($j = 0; $j < count($output['part_detail']); $j++) {
                $part_id = $output['part_detail'][$j]['id'];
                $max_mrk = $output['part_detail'][$j]['max_marks'];
                $dbObj->select('marks as mrk,exam_part_id as pid');
                $marks = $dbObj->get_where('exam_marks_details', array('adm_no' => $studentList[$i]['adm_no'], 'exam_part_id' => $part_id))->result_array();
//                print_r($marks);
//                exit;
                $singlemark = array();
                if (count($marks) > 0) {
                    $singlemark['mrk'] = $marks[0]['mrk'];
                    $singlemark['pid'] = $part_id;
                    $singlemark['max_mrk'] = $max_mrk;
                } else {
                    $singlemark['mrk'] = '';
                    $singlemark['pid'] = $part_id;
                    $singlemark['max_mrk'] = $max_mrk;
                }

                $allmarks[$j] = $singlemark;
            }
            $studentList[$i]['marks'] = $allmarks;
        }
        $output['studentDetail'] = $studentList;
        $dbObj->select('lock_date as ldate');
        $lastdate = $dbObj->get_where('exam_marks_entry_lock', array('exam_master_id' => $dataObj->exam_master_id))->result_array();
        $cur_date = date('Y-m-d');
        if (count($lastdate) > 0) {
            $ldate = $lastdate[0]['ldate'];
            if ($ldate > $cur_date) {
                $output['lock_date'] = 'TRUE';
            } else {
                $output['lock_date'] = 'FALSE';
            }
        } else {
            $output['lock_date'] = 'FALSE';
        }

//        echo '<pre>';
//        print_r($output);
//        exit;
        return $output;
    }

    public function SaveMyExamPart($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $myArrdata = array('exam_id' => $dataObj->master_id, 'part_name' => $dataObj->detail->part_name, 'max_marks' => $dataObj->detail->max_marks, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
        $dbObj->insert('exam_parts_details', $myArrdata);
        $last_insert_id = $dbObj->insert_id();
        if ($last_insert_id) {
            return $last_insert_id;
        } else {
            return -1;
        }
    }

    public function RemoveMyExamPart($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id');
        $examPartId = $dbObj->get_where('exam_parts_details', array('id' => $data['id'], 'entry_by' => $this->session->userdata('staff_id')))->row_array();

        if (!empty($examPartId)) {
            $dbObj->select('id');
            $Id = $dbObj->get_where('exam_marks_details', array('exam_part_id' => $examPartId['id'], 'entry_by' => $this->session->userdata('staff_id')))->row_array();
            if (!empty($Id)) {

                $dbObj->where('exam_part_id', $examPartId['id']);
                $dbObj->delete('exam_marks_details');
            }
        }
        $dbObj->where('id', $data['id']);
        return $dbObj->delete('exam_parts_details');
    }

    public function SaveMyMarksDetail($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        foreach ($dataObj->studentDetail as $stuData) {
            foreach ($stuData->marks as $stuMrk) {
                if ($stuMrk->mrk != 0 && $stuMrk->mrk != '') {
                    $myNewArry = array('adm_no' => $stuData->adm_no, 'marks' => $stuMrk->mrk, 'exam_part_id' => $stuMrk->pid, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
                    $dbObj->where('adm_no', $stuData->adm_no);
                    $dbObj->where('exam_part_id', $stuMrk->pid);
                    $dbObj->delete('exam_marks_details');
                    $dbObj->insert('exam_marks_details', $myNewArry);
                }
            }
        }
        $last_insert_id = $dbObj->insert_id();
        if ($last_insert_id) {
            return $last_insert_id;
        } else {
            return -1;
        }
    }

    public function GetMyActualMarks($dataObj) {

        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('adm_no,firstname as fname,lastname as lname,profile_pic_path_thumbnail as pic');
        $studentList = $dbObj->get_where('biodata', array('section_id' => $dataObj->sec_id))->result_array();
        for ($i = 0; $i < count($studentList); $i++) {
            $dbObj->select('adm_no,marks as mrk,exam_part_id as pid,max_marks as max_mrk');
            $actualMrks = $dbObj->get_where('exam_marks_actual_details', array('adm_no' => $studentList[$i]['adm_no'], 'exam_part_id' => $dataObj->pid))->result_array();
            $singlemark = array();
            if (count($actualMrks) > 0) {
                $singlemark['mrk'] = $actualMrks[0]['mrk'];
            } else {
                $singlemark['mrk'] = '';
            }
            $studentList[$i]['marks'] = $singlemark;
        }
//        $studentList['pid'] = $dataObj->pid;
//        $studentList['max_mrk'] = $dataObj->pmax_mrk;
        return array('studentList' => $studentList, 'pid' => $dataObj->pid, 'max_mrk' => $dataObj->pmax_mrk);
    }

    public function SaveMyActualMarks($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
//        print_r($data);
//        exit;
        foreach ($data['detail']['studentList'] as $stuData) {
            foreach ($stuData['marks'] as $stuMrk) {
                if ($stuMrk != 0 && $stuMrk != '') {
                    $myNewArry = array('adm_no' => $stuData['adm_no'], 'marks' => $stuMrk, 'max_marks' => $data['out_mrk'], 'exam_part_id' => $data['pid'], 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
                    $dbObj->where('adm_no', $stuData['adm_no']);
                    $dbObj->where('exam_part_id', $data['pid']);
                    $dbObj->delete('exam_marks_actual_details');
                    $dbObj->insert('exam_marks_actual_details', $myNewArry);
                }
                $avg_mrk = round((($data['max_mrk'] * $stuMrk) / $data['out_mrk']));

                if ($avg_mrk != 0 && $avg_mrk != '') {
                    $myTempNewArry = array('adm_no' => $stuData['adm_no'], 'marks' => $avg_mrk, 'exam_part_id' => $data['pid'], 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
                    $dbObj->where('adm_no', $stuData['adm_no']);
                    $dbObj->where('exam_part_id', $data['pid']);
                    $dbObj->delete('exam_marks_details');
                    $dbObj->insert('exam_marks_details', $myTempNewArry);
                }
            }
        }
        $last_insert_id = $dbObj->insert_id();
        if ($last_insert_id) {
            return $last_insert_id;
        } else {
            return -1;
        }
    }

    //**************************************Publish Marks Module Function**************************

    public function MyPublishMarksDetails($class) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,exam_name');
        $examList = $dbObj->get_where('exam_master_list', array('class' => $class))->result_array();
        for ($i = 0; $i < count($examList); $i++) {
            $dbObj->select("publish_date as pdate, publish_time as ptime");
            $pub_details = $dbObj->get_where('exam_publish_marks', array('exam_master_id' => $examList[$i]['id']))->result_array();
            if (count($pub_details) > 0) {
                $examList[$i]['pdate'] = date('d-m-Y', strtotime($pub_details[0]['pdate']));
                $examList[$i]['ptime'] = date('c', strtotime($pub_details[0]['ptime']));
            } else {
                $examList[$i]['pdate'] = date('d-m-Y');
//                $examList[$i]['ptime']=date('h:i');
            }
//            echo $dbObj->last_query();
        }

        return $examList;
    }

    public function SaveMyPublishMarks($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dataObj1 = json_encode($dataObj);
        $dataObj2 = json_decode($dataObj1, TRUE);
        foreach ($dataObj2 as $val) {
            if ($val['pdate'] != '') {
                $mytime = date("H:i:s ", strtotime($val['ptime']));
                $mydate = date("Y-m-d", strtotime($val['pdate']));
                $myTempNewArry = array('exam_master_id' => $val['id'], 'publish_date' => $mydate, 'publish_time' => $mytime, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
                $dbObj->where('exam_master_id', $val['id']);
                $dbObj->delete('exam_publish_marks');
                $dbObj->insert('exam_publish_marks', $myTempNewArry);
            }
        }
//        echo $dbObj->last_query();
        $last_insert_id = $dbObj->insert_id();
        if ($last_insert_id) {
            return $last_insert_id;
        } else {
            return -1;
        }
    }

    public function MyLockMarksDetails($class) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,exam_name');
        $lockexamList = $dbObj->get_where('exam_master_list', array('class' => $class))->result_array();
        for ($i = 0; $i < count($lockexamList); $i++) {
            $dbObj->select('lock_date as ldate');
            $lock_details = $dbObj->get_where('exam_marks_entry_lock', array('exam_master_id' => $lockexamList[$i]['id']))->result_array();
            if (count($lock_details) > 0) {
                $lockexamList[$i]['ldate'] = date('d-m-Y', strtotime($lock_details[0]['ldate']));
            } else {
                $lockexamList[$i]['ldate'] = date('d-m-Y');
            }
        }
        return $lockexamList;
    }

    public function SaveMyLockMarks($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dataObj1 = json_encode($dataObj);
        $dataObj2 = json_decode($dataObj1, TRUE);
        foreach ($dataObj2 as $val) {
            if ($val['ldate'] != '') {
                $mydate = date("Y-m-d", strtotime($val['ldate']));
                $myTempNewArry = array('exam_master_id' => $val['id'], 'lock_date' => $mydate, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
                $dbObj->where('exam_master_id', $val['id']);
                $dbObj->delete('exam_marks_entry_lock');
                $dbObj->insert('exam_marks_entry_lock', $myTempNewArry);
            }
        }
        $last_insert_id = $dbObj->insert_id();
        if ($last_insert_id) {
            return $last_insert_id;
        } else {
            return -1;
        }
    }

//**********************************************BlueSheet Module Function******************************
    public function GetMyNewExamList($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,exam_name');
        $result = $dbObj->get_where('exam_master_list', array('class' => $dataObj->standard))->result_array();
        return $result;
    }

    public function GetAllSubjectList($dataObj, $selectedExam) {
        $newData = json_encode($selectedExam);
        $newData1 = json_decode($newData);
        $newArr = array();
        for ($a = 0; $a < count($newData1); $a++) {
            if (!empty($newData1[$a]->loadresult)) {
                $newArry[] = $newData1[$a]->id;
            }
        }
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->distinct();
        $dbObj->select('subject_list.id as sub_id,subject_list.subject_name');
        $dbObj->from('subject_list');
        $dbObj->join('combo_subject_relation', 'subject_list.id=combo_subject_relation.subject_id');
        $dbObj->join('combo_section_relation', 'combo_subject_relation.combo_id=combo_section_relation.combo_id');
        $dbObj->where('combo_section_relation.section_id', $dataObj->id);
        $subjectList = $dbObj->get()->result_array();
        $partId = array();
        $finalArr = array();
        $temExamArr = array();
        $nn = 0;
        $ss = 0;
        $colspan = 0;
        for ($i = 0; $i < count($subjectList); $i++) {
            $examList1 = array();
            for ($p = 0; $p < count($newArry); $p++) {
                $dbObj->select('id,exam_name');
                $dbObj->order_by('order_by');
                $examList = $dbObj->get_where('exam_settings', array('subject_id' => $subjectList[$i]['sub_id'], 'section_id' => $dataObj->id, 'exam_master_id' => $newArry[$p]))->result_array();

                for ($j = 0; $j < count($examList); $j++) {
                    $dbObj->select('id as pid,part_name as pname,max_marks');
                    $partDetails = $dbObj->get_where('exam_parts_details', array('exam_id' => $examList[$j]['id']))->result_array();

                    if (count($partDetails) > 0) {
                        $examList[$j]['part'] = $partDetails;
                        for ($m = 0; $m < count($partDetails); $m++) {
                            $colspan++;
                            $partId[$ss]['id'] = $partDetails[$m]['pid'];
                            $partId[$ss]['pname'] = $partDetails[$m]['pname'];
                            $partId[$ss]['max_mrk'] = $partDetails[$m]['max_marks'];
                            $ss = $ss + 1;
                        }
                    } else {
                        $examList[$j]['part'] = 'No Exam Declare';
                        $partId[$ss]['id'] = 'No Declare';
                        $partId[$ss]['pname'] = 'NA';
                        $partId[$ss]['max_mrk'] = '-';
                        $ss = $ss + 1;
                        $colspan++;
                    }
                    $examList1[] = $examList;
                    $temExamArr[$nn]['ename'] = $examList[$j]['exam_name'];
                    $temExamArr[$nn]['colspan'] = count($partDetails);
                    $subjectList[$i]['exam'] = $examList1;
                    $nn = $nn + 1;
                }
            }
            $subjectList[$i]['colspan'] = $colspan;
            $colspan = 0;
        }

        $student = $this->GetStuMarks($dataObj, $partId);
        $finalArr['subjectList'] = $subjectList;
        $finalArr['studentList'] = $student;
        $finalArr['part'] = $partId;
        $finalArr['examLis'] = $temExamArr;
        return $finalArr;
    }

    public function GetStuMarks($dataObj, $partId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('adm_no,firstname as fname,lastname as lname');
        $stuRecord = $dbObj->get_where('biodata', array('section_id' => $dataObj->id))->result_array();
        for ($i = 0; $i < count($stuRecord); $i++) {
            $marksTempArr = array();
            $ii = 0;
            for ($j = 0; $j < count($partId); $j++) {
                $dbObj->select('exam_part_id as id,marks');
                $marks = $dbObj->get_where('exam_marks_details', array('adm_no' => $stuRecord[$i]['adm_no'], 'exam_part_id' => $partId[$j]['id']))->result_array();

                if (count($marks) > 0) {
                    $marks['pid'] = $marks[0]['id'];
                    $marks['marks'] = $marks[0]['marks'];
                } else {
                    $marks['pid'] = $partId[$j]['id'];
                    $marks['marks'] = '-';
                }
                $marksTempArr[$ii] = $marks;
                $ii = $ii + 1;
            }
            $stuRecord[$i]['marks'] = $marksTempArr;
        }
        return $stuRecord;
    }

}
