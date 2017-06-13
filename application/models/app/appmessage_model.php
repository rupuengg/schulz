<?php

class appmessage_model extends CI_Model {

    public function GetMessagseDeatils() {
        $jsonArrMessage = '{"messages":[{"teacher_pic":"jdhdf/djfhdf/ghi.jpg","teacher_id":"5","teacher_name":"K.C.Thomas","staff_detail":"Total:3||Unread:0||Subject Teacher:English,Science||Club Incharge:Go Green||Event Incharge:Table Tennis Friendly Matches,AShishs,quiz,carrom board,chess"}],"staff_information":[{"teacher_name":"K.C.Thomas","teacher_pic":"jdhdf/djfhdf/ghi.jpg"}],"chat_detail":[{"teacher_pic":"jdhdf/djfhdf/ghi.jpg","sender_type":"Staff","chat_content":"this message for you regarding upcoming football match meet me today at 4 pm","chat_time":"0000-00-00 00:00:00"},{"student_pic":"jdhdf/djfhdf/ghi.jpg","sender_type":"Student","chat_content":"vbnnvbjb","chat_time":"0000-00-00 00:00:00"}]}';
        return $jsonArrMessage;
    }

    public function GetMessageDetails($dataObj) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $this->load->model('app/appparent_core', 'coreObj');
        $messageSendStaffId = $this->GetStaffIdSendMessage($dataObj['adm_no'], $dbObj);
        $classTeacher = $this->GetClassTeacherId($dataObj['section_id'], $dbObj);
        $subjectList = $this->GetStaffIdSubjectList($dataObj['section_id'], $dbObj);
        $cardIssueStaff = $this->GetStaffIdCardIssue($dataObj['adm_no'], $dbObj);
        $clubIncharge = $this->GetClubInchargeId($dataObj['adm_no'], $dbObj);
        $eventIncharge = $this->GetEventInchargeId($dataObj['adm_no'], $dbObj);
        $staffIdList = array_unique(array_merge($subjectList, $cardIssueStaff, $classTeacher, $clubIncharge, $eventIncharge, $messageSendStaffId));
        $arrUnread = array();
        $arrRead = array();
        foreach ($staffIdList as $row) {
            if ($row > 0) {
                $tempArrStaffDeatil = array();
                if ($row == $classTeacher[0]) {
                    $ctStatus = 'YES';
                } else {
                    $ctStatus = 'NO';
                }
                $staffNameDeatil = $this->coreObj->GetStaffName($row, $dbObj);
                $unreadStatus = $this->GetUnreadMsg($row, $dataObj['adm_no'], $dbObj);
                $totalmessage = $this->GetTotalMsg($row, $dataObj['adm_no'], $dbObj);
                $subjectName = $this->GetSubjectName($row, $dataObj['section_id'], $dbObj);
                $clubName = $this->GetClubName($row, $dbObj);
                $eventName = $this->GetEventName($row, $dbObj);
                if ($unreadStatus['unreadmsg'] > 0) {
                    $tempArrStaffDeatil = array('staff_id' => $row,
                        'unread' => $unreadStatus['unreadmsg'],
                        'timestamp' => $unreadStatus['intime'],
                        'total' => $totalmessage['totalmsg'],
                        'subjectList' => $subjectName,
                        'clubName' => $clubName,
                        'eventName' => $eventName,
                        'classTeacher' => $ctStatus,
                        'staff_name' => $staffNameDeatil['name'],
                        'staff_pic' => $staffNameDeatil['profilePic']);

                    $arrUnread[] = $tempArrStaffDeatil;
                } else {
                    $tempArrStaffDeatil = array('staff_id' => $row,
                        'unread' => $unreadStatus['unreadmsg'],
                        'total' => $totalmessage['totalmsg'],
                        'subjectList' => $subjectName,
                        'clubName' => $clubName,
                        'eventName' => $eventName,
                        'classTeacher' => $ctStatus,
                        'staff_name' => $staffNameDeatil['name'],
                        'staff_pic' => $staffNameDeatil['profilePic']);
                    $arrRead[] = $tempArrStaffDeatil;
                }
            }
        }
        $arrFinalMessage = array();
        $arrFinalMessage['unread'] = $arrUnread;
        $arrFinalMessage['read'] = $arrRead;
        return $arrFinalMessage;
    }

    public function GetStaffIdSendMessage($adm_no, $dbObj) {
        $dbObj->select('staff_id');
        $staffId = $dbObj->get_where('staff_student_message', array('adm_no' => $adm_no))->result_array();
        if (!empty($staffId)) {
            foreach ($staffId as $row) {
                $onlystaffIdList[] = $row['staff_id'];
            }
            return $onlystaffIdList;
        } else {
            $staffId[0]['staff_id'] = 0;
            return $staffId;
        }
    }

    public function GetUnreadMsg($staff_id, $adm_no, $dbObj) {
        $dbObj->select('count(student_read_status)as unreadmsg,max(timestamp)as intime');
        $countResult = $dbObj->get_where('staff_student_message', array('staff_id' => $staff_id, 'adm_no' => $adm_no, 'student_read_status' => 'UNREAD'))->row_array();
        return $countResult;
    }

    public function GetTotalMsg($staff_id, $adm_no, $dbObj) {
        $dbObj->select('count(staff_id)as totalmsg');
        $countResult = $dbObj->get_where('staff_student_message', array('staff_id' => $staff_id, 'adm_no' => $adm_no))->row_array();
        return $countResult;
    }

    public function GetMyMessage($staff_id) {
        $student_read_timestamp = date('Y-m-d h:i:s');
        $this->load->model('app/appparent_core', 'coreObj');
        $dataObj = $this->coreObj->GetImportentDetails();
        $data = array('student_read_status' => 'READ', 'student_read_timestamp' => $student_read_timestamp);
        $dbObj->update('staff_student_message', $data, array('adm_no' => $dataObj['adm_no'], 'staff_id' => $staff_id, 'student_read_status' => 'UNREAD'));
        $dbObj->select('message,staff_read_status,staff_read_timestamp,sender,student_read_timestamp');
        $dbObj->order_by('timestamp', 'desc');
        $myMessage = $dbObj->get_where('staff_student_message', array('adm_no' => $dataObj['adm_no'], 'staff_id' => $staff_id))->result_array();
        return $myMessage;
    }

    public function SendMessages($messageContent, $dataObj) {
        $student_read_timestamp = date('Y-m-d H:i:s');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $inserData = array('sender' => 'STUDENTH', 'student_read_timestamp' => $student_read_timestamp, 'adm_no' => $this->session->userdata('current_adm_no'), 'staff_id' => $messageContent->staff_id, 'message' => $messageContent->message, 'student_read_status' => 'READ', 'staff_read_status' => 'UNREAD', 'entry_by' => $this->session->userdata('user_id'), 'deo_entry_by' => -1);
        $dbObj->insert('staff_student_message', $inserData);
        $insertId = $dbObj->insert_id();
        if ($insertId > 0) {
            return $insertId;
        } else {
            return -1;
        }
    }

    public function GetStaffIdSubjectList($section_id, $dbObj) {
        $dbObj->distinct();
        $dbObj->select('staff_id');
        $staffIdList = $dbObj->get_where('subject_staff_relation', array('section_id' => $section_id))->result_array();
        $onlystaffIdList = array();
        if (!empty($staffIdList)) {
            foreach ($staffIdList as $row) {
                $onlystaffIdList[] = $row['staff_id'];
            }
        }
        return $onlystaffIdList;
    }

    public function GetClubInchargeId($adm_no, $dbObj) {
        $dbObj->select('a.incharge_id as staff_id');
        $dbObj->from('club_details as a');
        $dbObj->join('club_member as b', 'a.id=b.club_id');
        $dbObj->where('b.adm_no', $adm_no);
        $clubInchargeId = $dbObj->get()->result_array();
        if (!empty($clubInchargeId)) {
            foreach ($clubInchargeId as $row) {
                $onlystaffIdList[] = $row['staff_id'];
            }
            return $onlystaffIdList;
        } else {
            $clubInchargeId[0] = 0;
            return $clubInchargeId;
        }
    }

    public function GetEventInchargeId($adm_no, $dbObj) {
        $dbObj->select('a.incharge_staff_id as staff_id');
        $dbObj->from('event_details as a');
        $dbObj->join('event_volunteer_student as b', 'a.id=b.event_id');
        $dbObj->join('event_team_member as c', 'b.event_id=c.event_id');
        $dbObj->where('b.volunteer_adm_id', $adm_no);
        $dbObj->or_where('c.adm_no', $adm_no);
        $eventInchargeId = $dbObj->get()->result_array();
        if (!empty($eventInchargeId)) {
            foreach ($eventInchargeId as $row) {
                $onlystaffIdList[] = $row['staff_id'];
            }
            return $onlystaffIdList;
        } else {
            $eventInchargeId[0] = 0;
            return $eventInchargeId;
        }
    }

    public function GetStaffIdCardIssue($adm_no, $dbObj) {
        $dbObj->select('entry_by');
        $cardIssueStaffId = $dbObj->get_where('cards_details', array('adm_no' => $adm_no))->result_array();
        if (!empty($cardIssueStaffId)) {
            foreach ($cardIssueStaffId as $row) {
                $onlystaffIdList[] = $row['entry_by'];
            }
            return $onlystaffIdList;
        } else {
            return $cardIssueStaffId[0] = 0;
        }
    }

    Public Function GetClassTeacherId($section_id, $dbObj) {
        $dbObj->select('class_teacher_id as staff_id');
        $classTeachrId = $dbObj->get_where('section_list', array('id' => $section_id, 'status' => 1))->result_array();
        if (!empty($classTeachrId)) {
            return array($classTeachrId[0]['staff_id']);
        }
    }

    public function GetClubName($staff_id, $dbObj) {
        $dbObj->select('name');
        $clubName = $dbObj->get_where('club_details', array('incharge_id' => $staff_id))->result_array();
        $clubNameString = '';
        if (!empty($clubName)) {
            foreach ($clubName as $row) {
                $arrTemp[] = $row['name'];
            }
            $clubNameString = implode(',', $arrTemp);
        }
        return $clubNameString;
    }

    public function GetEventName($staff_id, $dbObj) {
        $dbObj->select('name');
        $eventName = $dbObj->get_where('event_details', array('incharge_staff_id' => $staff_id))->result_array();
        $eventNameString = '';
        if (!empty($eventName)) {
            foreach ($eventName as $row) {
                $arrTemp[] = $row['name'];
            }
            $eventNameString = implode(',', $arrTemp);
        } 
        return $eventNameString;
    }

    public function GetSubjectName($staff_id, $section_id, $dbObj) {
        $dbObj->select('a.subject_name');
        $dbObj->from('subject_list as a');
        $dbObj->join('subject_staff_relation as b', 'a.id=b.subject_id');
        $dbObj->where('b.staff_id', $staff_id);
        $dbObj->where('b.section_id', $section_id);
        $subjectNameList = $dbObj->get()->result_array();
        $subjectNameString = '' ;
        if (!empty($subjectNameList)) {
            foreach ($subjectNameList as $row) {
                $arrTemp[] = $row['subject_name'];
            }
            $subjectNameString = implode(',', $arrTemp);
        }
            return $subjectNameString;
    }

}
