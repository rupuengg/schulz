<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class transport_model extends CI_Model {
    /*     * ******************* bus entry module****************** */

    public function getAllBusContractor() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $allBusContractor = $dbObj->get('tms_bus_contract_details')->result_array();
        return $allBusContractor;
    }

    public function saveBusEntery($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('school_bus_no', $data['school_bus_no']);
        $dbObj->from('tms_bus_details');
        $bus_no = $dbObj->get()->row_array();
         if(empty($bus_no)){
             $saveBus = $dbObj->insert('tms_bus_details', $data);
        if ($dbObj->affected_rows() > 0) {
            return $dbObj->insert_id();
        } else {
            return -1;
        }
        }else{
            return 'invalid';
        }
       
    }

    public function updateBusEntery($data, $id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('id', $id);
        $updateBus = $dbObj->update('tms_bus_details', $data);
        if ($dbObj->affected_rows() > 0) {
            return $dbObj->insert_id();
        } else {
            return false;
        }
    }

    public function BusList() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $allbusList = $dbObj->get('tms_bus_details')->result_array();
        return $allbusList;
    }

    public function getBusDetail($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('*');
        $getbus = $dbObj->get_where('tms_bus_details', array('id' => $id))->row_array();
        return $getbus;
    }

    public function DeleteBus($id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('id', $id);
        return $dbObj->delete('tms_bus_details');
    }

    public function BusPaper($bus_id) {
        $dbObj->where('bus_number', $bus_id);
        $dbObj->from('tms_bus_paper');
        return $dbObj->count_all_results();
    }

    /*     * *******************bus driver module************ */

    public function getBusDetails() {
        $myFinalArr = array();
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $resultBus = $dbObj->get('tms_bus_details')->result_array();
        $resultrip = $dbObj->get('tms_bus_trip_details')->result_array();
        $myFinalArr = array("busdetail" => $resultBus, "totaltrip" => count($resultrip));
        return $myFinalArr;
    }

    public function getDriver($driverid) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('name');
        $driverName = $dbObj->get_where('tms_bus_driver_details', array('id' => $driverid))->result_array();
        return $driverName['0']['name'];
    }

    public function getBusTripDriverdetail($bus_id) {
        $finalArray = array();
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.id as bus_id,a.bus_reg_no as bus_reg_no,a.school_bus_no as school_bus_no,a.bus_name bus_name,b.id as trip_id,b.trip_name as trip_name');
        $dbObj->from('tms_bus_details a');
        $dbObj->join('tms_bus_trip_details b', 'a.id=b.bus_id');
        if ($bus_id != 'ALL') {
            $dbObj->where('a.id', $bus_id);
        }
        $resultBus = $dbObj->get()->result_array();
        foreach ($resultBus as $val) {
            $dbObj->select('*');
            $dbObj->from('tms_bus_driver_relation');
            $dbObj->where('trip_id', $val['trip_id']);
            $arrResult = $dbObj->get()->result_array();
            if (count($arrResult) > 0) {
                $finalArray[] = array("bus_detail" => $val['school_bus_no'] . ' | ' . $val['bus_reg_no'] . ' | ' . $val['bus_name'], "trip_id" => $val['trip_id'], "trip_name" => $val['trip_name'], "driver_name" => $this->getDriver($arrResult[0]['driver_id']), "conductor_name" => $this->getDriver($arrResult[0]['conductor_id']));
            } else {
                $finalArray[] = array("bus_detail" => $val['school_bus_no'] . ' | ' . $val['bus_reg_no'] . ' | ' . $val['bus_name'], "trip_id" => $val['trip_id'], "trip_name" => $val['trip_name'], "driver_name" => '', "conductor_name" => '');
            }
        }
        
        return $finalArray;
    }

    public function GetDriverList($driverName, $drivertype, $trip_id) {
        $arrFinal = array();
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,name');
        $dbObj->like('name', $driverName);
        $driverDetail = $dbObj->get_where('tms_bus_driver_details', array('driver_type' => $drivertype))->result_array();
        $arrFinal = array(array("id" => $driverDetail[0]['id'], "trip_id" => $trip_id, "driver_type" => $drivertype, "name" => $driverDetail[0]['name']));
        return $arrFinal;
    }

    public function deleteDriverConductorModel($trip_id, $drivertype) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        if (trim($drivertype) == 1) {
            $dbObj->where('trip_id', $trip_id);
            $dbObj->update('tms_bus_driver_relation', array("driver_id" => ''));
        } else {
            $dbObj->where('trip_id', $trip_id);
            $dbObj->update('tms_bus_driver_relation', array("conductor_id" => ''));
        }
        if ($dbObj->affected_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function saveBusDriverRelationDetail($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $entryby = $this->session->userdata('staff_id');
        $deostaffid = $this->session->userdata('deo_staff_id');
        $myArr = array();
        $resultbusdriver = $dbObj->get_where('tms_bus_driver_relation', array('trip_id' => trim($data['trip_id'])))->result_array();
        if (count($resultbusdriver) > 0) {
            if (trim($data['driver_type']) == 1) {
                $dbObj->where('trip_id', $data['trip_id']);
                $dbObj->update('tms_bus_driver_relation', array("driver_id" => $data['id'], "entry_by" => $entryby, "deo_entry_by" => $deostaffid));
            } else {
                $dbObj->where('trip_id', $data['trip_id']);
                $dbObj->update('tms_bus_driver_relation', array("conductor_id" => $data['id'], "entry_by" => $entryby, "deo_entry_by" => $deostaffid));
            }
        } else {
            if (trim($data['driver_type']) == 1) {
                $myArr = array("trip_id" => $data['trip_id'], "driver_id" => $data['id'], "conductor_id" => '', "entry_by" => $entryby, "deo_entry_by" => $deostaffid);
            } else {
                $myArr = array("trip_id" => $data['trip_id'], "driver_id" => '', "conductor_id" => $data['id'], "entry_by" => $entryby, "deo_entry_by" => $deostaffid);
            }
            $dbObj->insert('tms_bus_driver_relation', $myArr);
        }
        if ($dbObj->affected_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }

    /*     * **************************Bus Trip Details*************************************** */

    public function GetAllBusDetails() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $bus = $dbObj->get('tms_bus_details')->result_array();
        return $bus;
    }

    public function GetTripdetail($id, $bus_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('id', $id);
        $dbObj->where('bus_id', $bus_id);
        $trip = $dbObj->get('tms_bus_trip_details')->result_array();
        foreach ($trip as $key => $value) {
          $trip[$key]['trip_time']=date('c',strtotime($trip[$key]['trip_time'])); 

}
        
        return $trip;
    }

    public function SaveNewTrip($NewTripData, $bus_id) {
      $NewTripData = json_decode($NewTripData, TRUE);      
        $NewTripData['bus_id'] = $bus_id;
        $NewTripData['entry_by'] = $this->session->userdata('staff_id');
        $NewTripData['deo_entry_by'] = $this->session->userdata('deo_staff_id'); 
//       
        $NewTripData['trip_time']=date('H:i:s',strtotime($NewTripData['trip_time'])); 
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->insert('tms_bus_trip_details', $NewTripData);
        return $dbObj->insert_id();
    }

    public function UpdateTrip($NewTripData, $bus_id, $trip_id) {
        $NewTripData = json_decode($NewTripData, TRUE);
        $NewTripData['bus_id'] = $bus_id;
        $NewTripData['trip_time']=date('H:i:s',strtotime($NewTripData['trip_time']));
        $NewTripData['entry_by'] = $this->session->userdata('staff_id');
        $NewTripData['deo_entry_by'] = $this->session->userdata('deo_staff_id');
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('id', $trip_id);
        $dbObj->update('tms_bus_trip_details', $NewTripData);
        return $dbObj->affected_rows();
    }

    public function GetTripBusDetails($bus_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('id', $bus_id);
        $busDetail = $dbObj->get('tms_bus_details')->row_array();
        $tripList = $this->getBusTrips($busDetail['id']);
        $busDetail['tripDetail'] = $tripList;
        return $busDetail;
    }

    public function GetBusTrips($bus_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('bus_id', $bus_id);
        $bustrip = $dbObj->get('tms_bus_trip_details')->result_array();
        for ($i = 0; $i < count($bustrip); $i++) {
            $stopList = $this->getTripStopNameList($bustrip[$i]['id']);
            $bustrip[$i]['stopList'] = $stopList;
        }
        return $bustrip;
    }

    public function GetTripStopNameList($tripid) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('stop_name,arrival_time');
        $dbObj->from('tms_bus_stop_details a');
        $dbObj->join('tms_bus_stop_trip_relation b', 'b.stop_id=a.id');
        $dbObj->where('b.trip_id', $tripid);
        $query = $dbObj->get();
        //return $dbObj->last_query();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function GetStopIdForRequest($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id as stopId,stop_name as stop');
        $dbObj->like('stop_name', $data);
        $result = $dbObj->get('tms_bus_stop_details')->result_array();
        return $result;
    }

    public function SaveStop($trip_id, $data) {
        $stopdata = array();
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $stopdata['trip_id'] = $trip_id;
        $stopdata['stop_id'] = $data['stopId'];
        $stopdata['arrival_time'] = date('H:i:s',strtotime($data['time'])); 
        $stopdata['entry_by'] = $this->session->userdata('staff_id');
        $stopdata['deo_entry_by'] = $this->session->userdata('deo_staff_id');
        $dbObj->insert('tms_bus_stop_trip_relation', $stopdata);
        return $dbObj->insert_id();
    }

    public function RemoveStop($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->delete('tms_bus_trip_details', array('id' => $data['tripId']));
        $dbObj->delete('tms_bus_stop_trip_relation', array('trip_id' => $data['tripId']));
        return TRUE;
    }

    /*     * ******************manage student bus trip********************* */

    public function GetAllTripDetail($data, $adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id as tripId,trip_name as trip');
        $dbObj->like('trip_name', $data);
        $trip = $dbObj->get('tms_bus_trip_details')->result_array();
        for ($i = 0; $i < count($trip); $i++) {
            $trip[$i]['adm_no'] = $adm_no;
        }
        return $trip;
    }

    public function GetAllStudentDetail($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('adm_no as studentId,firstname as name');
        $dbObj->like('adm_no', $data);
        $student = $dbObj->get('biodata')->result_array();
        return $student;
    }

    public function saveStudentTrip($data) {
        $finaldata = array();
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $finaldata['adm_no'] = $data['student'][1]['studentId'];
        $finaldata['trip_id'] = $data['student'][0]['tripId'];
        $finaldata['trip_type'] = $data['tripStatus'];
        $finaldata['entry_by'] = $this->session->userdata('staff_id');
        $finaldata['deo_entry_by'] = $this->session->userdata('deo_staff_id');
        $dbObj->insert('tms_bus_student_relation', $finaldata);
        return $dbObj->insert_id();
    }

    public function GetAllIssuedStudent() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('*');
        $dbObj->from('tms_bus_student_relation a');
        $dbObj->join('biodata b', 'b.adm_no=a.adm_no');
        $dbObj->join('tms_bus_trip_details c', 'c.id=a.trip_id');
        $dbObj->join('tms_bus_details as d', 'd.id=c.bus_id');
        $query = $dbObj->get();
        
        if ($query->num_rows() != 0) {
            //print_r($query->result_array()); exit;
            return $query->result_array();
        } else {
            return '-1';
        }
    }

    public function RemoveIssuedTripData($data, $type) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->delete('tms_bus_student_relation', array('adm_no' => $data, "trip_type" => $type));
        return TRUE;
    }

    public function GetAllStudentdata($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('section_id', $data);
        $student = $dbObj->get('biodata')->result_array();

        for ($i = 0; $i < count($student); $i++) {
            $comingTrip = $this->getComingTrip($student[$i]['adm_no']);
            $goingTrip = $this->getGoingTrip($student[$i]['adm_no']);
            $student[$i]['comingTrip'] = $comingTrip;
            $student[$i]['goingTrip'] = $goingTrip;
        }
//        print_r($student); exit;
        return $student;
    }

    public function getComingTrip($adm_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('*');
        $dbObj->from('tms_bus_trip_details a');
        $dbObj->join('tms_bus_student_relation b', 'b.trip_id=a.id');
        $dbObj->join('tms_bus_details as d', 'd.id=a.bus_id');
        $dbObj->where('b.adm_no', $adm_id);
        $dbObj->where('b.trip_type', 'COMING');
        $query = $dbObj->get();
        if ($query->num_rows() != 0) {
              return $query->result_array();
        } else {
            return false;
        }
    }

    public function getGoingTrip($adm_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('*');
        $dbObj->from('tms_bus_trip_details a');
        $dbObj->join('tms_bus_student_relation b', 'b.trip_id=a.id');
        $dbObj->join('tms_bus_details as c', 'c.id=a.bus_id');
        $dbObj->where('b.adm_no', $adm_id);
        $dbObj->where('b.trip_type', 'GOING');
        $query = $dbObj->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function saveStudentTripBySection($data) {
        $finaldata = array();
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $finaldata['adm_no'] = $data['student']['adm_no'];
        $finaldata['trip_id'] = $data['student']['tripId'];
        $finaldata['trip_type'] = $data['tripStatus'];
        $finaldata['entry_by'] = $this->session->userdata('staff_id');
        $finaldata['deo_entry_by'] = $this->session->userdata('deo_staff_id');
        $dbObj->insert('tms_bus_student_relation', $finaldata);
        //print_r($dbObj->insert_id());exit;
        return $dbObj->insert_id();
    }

    public function RemoveIssuedTripSectionWiseData($data) {
//        print_r($data); exit;
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->delete('tms_bus_student_relation', array('id' => $data));
        return TRUE;
    }

    /*     * *************************Report Module*************************** */

    public function GetBusStudentList() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,bus_name');
        $busList = $dbObj->get('tms_bus_details')->result_array();
        return $busList;
    }

    public function GetAllBusStop() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $stopList = $dbObj->get('tms_bus_stop_details')->result_array();
        return $stopList;
    }

    public function GetAllTripData() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $tripList = $dbObj->get('tms_bus_trip_details')->result_array();
        return $tripList;
    }

}
