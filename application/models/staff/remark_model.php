<?php

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

class remark_model extends CI_Model {

    public function getStudentData($jsondata, $staff_id, $page_type) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $input = json_decode($jsondata, TRUE);
        if ($page_type == 'SUBJECT') {
            $sub_id = $input['subject_id'];
        }
        $sec_id = $input['section_id'];
        $dbObj->select('adm_no,firstname,lastname,profile_pic_path');
        $dbObj->where('section_id', $sec_id);
        $objstddata = $dbObj->get("biodata")->result_array();
        for ($i = 0; $i < count($objstddata); $i++) {
            $adm_no = $objstddata[$i]['adm_no'];
            if ($page_type == 'SUBJECT') {
                $dbObj->select("id,remark, DATE_FORMAT(timestamp, '%M %D, %Y') as timestamp", FALSE);
                $dbObj->from('remark');
                //$dbObj->join('staff_details', 'staff_details.id = remark.entry_by');CONCAT(staff_details.staff_fname,staff_details.staff_lname) as staffname
                $dbObj->where('adm_no', $adm_no);
                $dbObj->where('subject_id', $sub_id);
                $dbObj->where('remark_type', 'SUBJECT');
                //$str = " SELECT a.id,a.remark,a.timestamp,concat(b.staff_fname,' ',b.staff_lname) as staffname FROM remark as a,staff_details as b WHERE a.remark_type='SUBJECT' AND a.entry_by=b.id AND a.adm_no=$adm_no AND a.subject_id=$sub_id";
            } else {
                $dbObj->select("id,remark, DATE_FORMAT(timestamp, '%M %D, %Y') as timestamp", FALSE);
                $dbObj->from('remark');
                //$dbObj->join('staff_details', 'staff_details.id = remark.entry_by');
                $dbObj->where('adm_no', $adm_no);
                $dbObj->where('remark_type', 'GENERAL');
                //$str = " SELECT a.id,a.remark,a.timestamp,concat(b.staff_fname,' ',b.staff_lname) as staffname FROM remark as a,staff_details as b WHERE a.remark_type='GENERAL' AND a.entry_by=b.id AND a.adm_no=$adm_no";
            }
            $objstddata[$i]['remarkDetail'] = $dbObj->get()->result_array();
        }
        $out = json_encode($objstddata);
        return $out;
    }

    public function getstaffsubjectlist($staff_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $str = "SELECT a.`section_id`,a.`subject_id`,concat( b.`standard`,' ',b.`section`) as class, c.subject_name as subject FROM `subject_staff_relation` as a,section_list as b, subject_list as c WHERE a.section_id=b.id and c.id=a.subject_id and a.staff_id=" . $staff_id . " AND b.status=1";
        $objstddata = $dbObj->query($str)->result_array();
        $out = json_encode($objstddata);
        return $out;
    }

    public function getSectioList() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id as section_id,upper(standard) as standard,section,order');
        $dbObj->order_by('order');
        $dbObj->where_in('status', 1);
        $objstddata = $dbObj->get('section_list')->result_array();
        $out = json_encode($objstddata);
        return $out;
    }

    public function getStudentListOfSection($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('adm_no,firstname,lastname,profile_pic_path');
        $objstddata = $dbObj->get_where('biodata', array("section_id" => $id))->result_array();
        $out = json_encode($objstddata);
        return $out;
    }

    public function savesubjectremarkdata($jsondata, $deo_id, $staff_id, $page_type) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $input = json_decode($jsondata, TRUE);
        $data_insert = array();
        if ($page_type == 'SUBJECT') {
            $data_insert[] = array(
                'subject_id' => $input['subject_id'],
                'adm_no' => $input['adm_no'],
                'remark' => $input['remark_filled'],
                'remark_type' => 'SUBJECT',
                'deo_entry_by' => $deo_id,
                'entry_by' => $staff_id,
            );
            
        } else {
            $data_insert[] = array(
                'adm_no' => $input['adm_no'],
                'remark' => $input['remark_filled'],
                'remark_type' => 'GENERAL',
                'deo_entry_by' => $deo_id,
                'entry_by' => $staff_id,
            );
        }
        $dbObj->insert_batch('remark', $data_insert);
        $array = array('adm_no'=>$input['adm_no'],'id' => $dbObj->insert_id(), 'remark' => $input['remark_filled'], 'timestamp' => date('F d,Y'));
        return $array;
    }

    public function deleteAllRemark($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->delete('remark', array("id" => $id));
        return TRUE;
    }

}
