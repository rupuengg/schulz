<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class schoolsetting_controller extends MY_Controller {

    public function Index() {
        $this->load->view('staff/school_setting/schoolsetting_view');
    }

    public function GetSchoolDetail() {
        $this->load->model('staff/schoolsetting_model', 'modelObj');
        $result = $this->modelObj->GetSchoolDetails();
        echo json_encode($result);
    }

    public function SaveSchoolDeatil() {
        $dataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staff/schoolsetting_model', 'modelObj');
        $result = $this->modelObj->SaveSchoolDetails($dataObj);
        if ($result) {
            echo printCustomMsg("TRUE", "Setting Saved Successfully", $result);
        } else {
            echo printCustomMsg("ERR", "Setting Not Save.", $result);
        }
    }

    public function SchoolPictureUpload() {
        $data = json_decode($this->input->post('data'), true);
        $encodedImageData = str_replace(' ', '+', $data['image']);
        $encodedImageData = str_replace('data:image/png;base64,', '', $data['image']);
        $decodedImageData = base64_decode($encodedImageData);
        $uploadDirPath = 'files/school/' . $data['school_code'] . '/';
        $filePath = 'files/school/' . $data['school_code'] . '/' . $data['skul_affl_no'] . '.png';
        if (!is_dir($uploadDirPath)) {
            mkdir($uploadDirPath, 0755, TRUE);
        }
        $files = glob('files/school/' . $data['school_code'] . '/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
        try {
            if (file_put_contents($filePath, $decodedImageData)) {
                echo printCustomMsg('UPLOAD', 'Image upload successfully.', $filePath);
            } else {
                echo printCustomMsg('UPLOADERROR', 'Image not upload successfully.', -1);
            }
        } catch (Exception $exe) {
            echo printCustomMsg('ERR', NULL, $exe->getMessage());
        }
    }

}
