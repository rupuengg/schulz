<?php

class transport_controller extends MY_Controller {

    public function BusContrator() {
        $this->load->view('staff/transport/bus_contractor.php');
    }

    public function ManageDriver() {
        $this->load->view('staff/transport/driver_view.php');
    }

    public function ManageBusStop() {
        $this->load->view('staff/transport/bus_stop.php');
    }

    public function ManageStudentBus() {
        $this->load->view('staff/transport/manage_student_bus.php');
    }

    public function ManageBusTrip() {
        $this->load->view('staff/transport/manage_bus_trip.php');
    }

    /*     * *******************susmita code of bus entry module****************** */

    public function BusModuleView($id = -1) {
        $this->load->model('staff/transport_model', 'ModelObj');
        $result = $this->ModelObj->getBusDetail($id);
        //echo json_encode($result);
        $this->load->view('staff/transport/busentry.php', array('bus_result' => $result));
    }

    public function SaveBusDetail() {
        if ($this->input->post('bus_id') != "") {
            $data['entry_by'] = $this->session->userdata('staff_id');
            $data['deo_entry_by'] = $this->session->userdata('deo_staff_id');
            $data = json_decode($this->input->post('data'),true);
             $this->load->model('staff/transport_model', 'ModelObj');
            $$id = $this->ModelObj->updateBusEntery($data, $this->input->post('bus_id'));
            if ($id) {
                    echo '{"status":"TRUE","message":"Updated successfully","objId":' . $id . '}';
                } else {
                    echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
                }
        } else {
            $data['entry_by'] = $this->session->userdata('staff_id');
            $data['deo_entry_by'] = $this->session->userdata('deo_staff_id');
            $data = json_decode($this->input->post('data'),true);
             $this->load->model('staff/transport_model', 'ModelObj');
            $id = $this->ModelObj->saveBusEntery($data);
            if ($id > 0) {
                    echo '{"status":"TRUE","message":"Saved successfully","objId":' . $id . '}';
                }elseif ($id === 'invalid') {
                   echo '{"status":"FALSE","message":"School bus no. already assigned..!!"}';
            } 
                else {
                    echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
                }
        }
    }

    public function getBusContractor() {
        $this->load->model('staff/transport_model', 'ModelObj');
        $result = $this->ModelObj->getAllBusContractor();
        echo json_encode($result);
    }

    public function getAllBusList() {
        $this->load->model('staff/transport_model', 'ModelObj');
        $buslist = $this->ModelObj->BusList();

        echo json_encode($buslist);
    }

    public function deleteBusDetail() {
        $id = $this->input->post('data');
        $this->load->model('staff/transport_model', 'ModelObj');
        $result = $this->ModelObj->DeleteBus($id);
        if ($result) {
            echo printCustomMsg("TRUE", "Delete  successfully", null);
        } else {
            echo printCustomMsg("SAVEERR", "Not Delete", null);
        }
    }

    public function countBuspPaper() {
        $bus_id = $this->input->post('data');
        // echo $bus_id;
        $this->load->model('staff/transport_model', 'ModelObj');
        $result = $this->ModelObj->BusPaper($bus_id);
        if ($result) {
            echo printCustomMsg("TRUE", "aa", null);
        } else {
            echo printCustomMsg("SAVEERR", "Na", null);
        }
    }

    /*     * *******************finish******************************************* */

    /*     * *********************************start manoj******************** */

    public function ManageBusDriverRelation($bus_id = 'ALL') {
        $this->load->view('staff/transport/manage_bus_driver.php', array("bus_id" => $bus_id));
    }

    public function getbusdetails() {
        $this->load->model('staff/transport_model', 'modelObj');
        $result1 = $this->modelObj->getBusDetails();
        echo json_encode($result1);
    }

    public function getBusTripDriverdetails() {
        $bus_id = $this->input->post('bus_id');
        $this->load->model('staff/transport_model', 'modelObj1');
        $result2 = $this->modelObj1->getBusTripDriverdetail($bus_id);
        echo json_encode($result2);
    }

    public function searchdriverconductor() {

        $driverName = $this->input->get('search');
        $trip_id = $this->input->get('trip_id');
        $drivertype = $this->input->get('type');
        $this->load->model('staff/transport_model', 'modelObj');
        $searchData = $this->modelObj->GetDriverList($driverName, $drivertype, $trip_id);
        echo json_encode(array("results" => $searchData));
    }

    public function saveBusDriverRelationDetails() {
        $data = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/transport_model', 'modelObj');
        $result = $this->modelObj->saveBusDriverRelationDetail($data);
        if ($result) {
            echo printCustomMsg("TRUE", "data Loaded Successfully", json_encode($result));
        } else {
            echo printCustomMsg("ERRINPUT", "Somethng went wrong");
        }
    }

    public function deleteDriverConductor() {
        $trip_id = $this->input->post('trip_id');
        $drivertype = $this->input->post('driver_type');
        $this->load->model('staff/transport_model', 'modelObj');
        $result = $this->modelObj->deleteDriverConductorModel($trip_id, $drivertype);
        if ($result) {
            echo printCustomMsg("TRUE", "Deleted Successfully", json_encode($result));
        } else {
            echo printCustomMsg("ERRINPUT", "Oops! Something went wrong. Please try again.");
        }
    }

    /***********************************finish*********************/

    public function GetAllBusDetails() {
        $this->load->model('staff/transport_model', 'objtransportBusData');
        $busdata = $this->objtransportBusData->GetAllBusDetails();
        echo json_encode($busdata);
    }

    public function SaveNewTrip() {
        try {
            $this->load->model('staff/transport_model', 'objTripData');
            if ($this->input->post('trip_id') != '') {
                $id = $this->objTripData->UpdateTrip($this->input->post('data'), $this->input->post('bus_id'), $this->input->post('trip_id'));
                if ($id) {
                    echo '{"status":"TRUE","message":"Updated successfully","objId":' . $id . '}';
                } else {
                    echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
                }
            } else {
                $id = $this->objTripData->SaveNewTrip($this->input->post('data'), $this->input->post('bus_id'));

                if ($id) {
                    echo '{"status":"TRUE","message":"Saved successfully","objId":' . $id . '}';
                } else {
                    echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
                }
            }
        } catch (Exception $exc) {
            echo '{"status":"ERROR","message":"' . $exc->getMessage() . '"}';
        }
    }

    public function GetBusTrip() {
        $this->load->model('staff/transport_model', 'objtransportBusTrip');
        $tripdata = $this->objtransportBusTrip->GetBusTrips($this->input->post('data'));
        echo json_encode($tripdata);
    }

    public function GetTripDetail() {
        $this->load->model('staff/transport_model', 'objtransportTrip');
        $trip = $this->objtransportTrip->GetTripdetail($this->input->post('data'), $this->input->post('bus_id'));
        echo json_encode($trip);
    }

    public function BusDetails() {
        $this->load->model('staff/transport_model', 'objtransportBusData');
        $busdata = $this->objtransportBusData->GetTripBusDetails($this->input->post('data'));
        echo json_encode($busdata);
    }

    public function SerachStop() {
        $stopName = $this->input->get('search');
        $this->load->model('staff/transport_model', 'objtransportStopData');
        $searchData = $this->objtransportStopData->GetStopIdForRequest($stopName);
        echo json_encode(array("results" => $searchData));
    }

    public function SaveAllStop() {
        $trip = $this->input->post('trip');
        $data = json_decode($this->input->post('data'), True);
        $this->load->model('staff/transport_model', 'objtransportstopData');
        foreach ($data[stopDeatils] as $res) {
            $id = $this->objtransportstopData->SaveStop($data[tripId], $res);
        }
        if ($id) {
            echo '{"status":"TRUE","message":"Saved successfully","objId":' . $id . '}';
        } else {
            echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
        }
    }

    public function RemoveTrip() {
        $data = json_decode($this->input->post('data'), True);
        $this->load->model('staff/transport_model', 'objRemoveStop');
        $delid = $this->objRemoveStop->RemoveStop($data);
        if ($delid) {
            echo printCustomMsg("TRUE", "Trip Succesfully Deleted", $delid);
        } else {
            echo printCustomMsg("ERRINPUT", "Oops! Something went wrong.", -1);
        }
    }

    /**********************manage student Bus trip**************************/

    public function GetSectionList() {
        $this->load->model('core/core', 'objtransportSectionData');
        $section = $this->objtransportSectionData->GetAllSection();
        echo json_encode($section);
    }

    public function GetAllTripDetail() {
        $tripName = $this->input->get('search');
        $adm_no = $this->input->get('adm_no');
        $this->load->model('staff/transport_model', 'objtransportTripData');
        $tripdata = $this->objtransportTripData->GetAllTripDetail($tripName, $adm_no);
        echo json_encode(array("results" => $tripdata));
    }

    public function GetAllStudent() {
        $adm_no = $this->input->get('search');
        $this->load->model('staff/transport_model', 'objtransportstudentData');
        $studentdata = $this->objtransportstudentData->GetAllStudentDetail($adm_no);
        echo json_encode(array("results" => $studentdata));
    }

    public function SaveStudentTrip() {
        $data = json_decode($this->input->post('data'), true);
        $this->load->model('staff/transport_model', 'objtransportstudentData');
        $id = $this->objtransportstudentData->saveStudentTrip($data);
        if ($id) {
            echo '{"status":"TRUE","message":"Saved successfully","objId":' . $id . '}';
        } else {
            echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
        }
    }

    public function GetIssuedStudentList() {
        $this->load->model('staff/transport_model', 'objtransportSectionData');
        $section = $this->objtransportSectionData->GetAllIssuedStudent();
        echo json_encode($section);
    }

    public function RemoveIssuedTrip() {
        $data = json_decode($this->input->post('data'), True);
        $type = $this->input->post('type');
        $this->load->model('staff/transport_model', 'objRemoveIssuedTrip');
        $delid = $this->objRemoveIssuedTrip->RemoveIssuedTripData($data, $type);
        if ($delid) {
            echo '{"status":"TRUE","message":"Deleted successfully","objId":' . $delid . '}';
        } else {
            echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
        }
    }

    public function GetAllStudentSectionWise() {
        $data = $this->input->post('data');
        $this->load->model('staff/transport_model', 'objIssuedTrip');
        $tripstudentdata = $this->objIssuedTrip->GetAllStudentdata($data);
        echo json_encode($tripstudentdata);
    }

    public function SaveStudentTripBySection() {
        $data = json_decode($this->input->post('data'), True);
        $this->load->model('staff/transport_model', 'objtransportstudentData');
        $id = $this->objtransportstudentData->saveStudentTripBySection($data);
        if ($id) {
            echo '{"status":"TRUE","message":"Saved successfully","objId":' . $id . '}';
        } else {
            echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
        }
    }

    public function RemoveIssuedTripSectionWise() {
        $data = json_decode($this->input->post('data'), True);
        $this->load->model('staff/transport_model', 'objRemoveIssuedSectionTrip');
        $delid = $this->objRemoveIssuedSectionTrip->RemoveIssuedTripSectionWiseData($data);
        if ($delid) {
            echo '{"status":"TRUE","message":"Deleted successfully","objId":' . $delid . '}';
        } else {
            echo '{"status":"FALSE","message":"Oops! Something went wrong. Please try again."}';
        }
    }

    /**************************Report module*************************/

    public function GenerateReport() {
        $this->load->view('staff/transport/generate_report.php');
    }

    public function BusWiseStudentReport($busName = -1) {
        $this->load->model('staff/transportreport_model', 'modelObj');
        $busList = $this->modelObj->GetBusStudentList();
        $this->load->view('staff/transport_report_view/bus_wise_student_report', array("busList" => $busList, "bus_id" => $busName));
    }

    public function GetAllTrip() {
        $this->load->model('staff/transport_model', 'modelObj');
        $tripList = $this->modelObj->GetAllTripData();
        echo json_encode($tripList);
    }

    public function GetBusStops() {
        $this->load->model('staff/transport_model', 'modelObj');
        $stopList = $this->modelObj->GetAllBusStop();
        echo json_encode($stopList);
    }

}

?>