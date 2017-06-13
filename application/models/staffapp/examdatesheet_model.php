<?php

class examdatesheet_model extends CI_Model {

    public function examdatesheetData($dataObj,$exam_id) {
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('exam_name');
        $exam_name = $dbObj->get_where('exam_datesheet_details', array('id'=>$exam_id))->row_array();
        $dbObj->select('a.exam_date,a.duration,a.exam_time,b.subject_name');
        $dbObj->from('exam_datesheet_subject_relation as a');
        $dbObj->join('subject_list as b','a.subject_id = b.id');
        $dbObj->where('a.exam_id',$exam_id);
        $exam_details = $dbObj->get()->result_array();
        for($i=0;$i<count($exam_details);$i++){
            $date = date('dS M,Y',strtotime($exam_details[$i]['exam_date']));
            $day = date('l',strtotime($exam_details[$i]['exam_date']));
            $exm_dt = $date.'('.$day.')';
            $end_time = date('H:i',strtotime($exam_details[$i]['exam_time']. " + ".$exam_details[$i]['duration']));
            $strt_time = date('H:i',strtotime($exam_details[$i]['exam_time']));
            $datesheet[] = array('date'=>$exm_dt,'sub_name'=>$exam_details[$i]['subject_name'],'time'=>$strt_time.' to '.$end_time);
        }
        $fnal_arr = array('exam_name'=>'Schedule of '.$exam_name['exam_name'],'examlist_data'=>$datesheet);
        return $fnal_arr;
    }

}