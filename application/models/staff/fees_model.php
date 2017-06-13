<?php

class fees_model extends CI_Model {
    /*     * ****************classwise fee setting   Nitin************ */

    public function getIdStandard() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,standard');
        $dbObj->order_by('order_by', 'ASC');
        $result = $dbObj->get('master_class_list')->result_array();
        return $result;
    }

    public function getFeesName() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,category_name');
        $result = $dbObj->get('fee_main_head_category')->result_array();
        return $result;
    }

    public function getFeesData($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,head_name');
        $result = $dbObj->get_where('fee_head_setting', array("main_head_id" => $data['category_id']))->result_array();
        foreach ($result as $key => $details) {
            $amountResult = $this->getFeeAmountFromClassId($data['class_id'], $details['id']);

            if (!empty($amountResult)) {
                $result[$key]['feesAmount'] = $amountResult['fee_amount'];

                $result[$key]['status'] = true;
            }
        }
        return $result;
    }

    public function getFeeAmountFromClassId($class_id, $headSubId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('fee_amount');
        $result = $dbObj->get_where('fee_head_class_relation', array("class_id" => $class_id, "head_id" => $headSubId))->row_array();
        return $result;
    }

    public function saveFeesData($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        foreach ($data['feeData'] as $details) {
            if (isset($details['status'])) {
                if ($details['status'] == 1) {
                    if (isset($details['feesAmount'])) {
                        $dbObj->select('*');
                        $getmatchData = $dbObj->get_where('fee_head_class_relation', array("head_id" => $details['id'], "class_id" => $data['class_id']))->row_array();

                        if ($getmatchData) {

                            $myarray = array(
                                'head_id' => $details['id'],
                                'class_id' => $data['class_id'],
                                'fee_amount' => $details['feesAmount']
                            );
                            $dbObj->where('head_id', $details['id']);
                            $dbObj->where('class_id', $data['class_id']);
                            $updateresult = $dbObj->update('fee_head_class_relation', $myarray);
                        } else {
                            $myarray2[] = array(
                                'head_id' => $details['id'],
                                'class_id' => $data['class_id'],
                                'fee_amount' => $details['feesAmount']
                            );
                        }
                    }
                }
            }
        }
        if (!empty($myarray2)) {
            $result = $dbObj->insert_batch('fee_head_class_relation', $myarray2);
            if ($dbObj->insert_id() > 0) {
                return $result;
            } else {
                return -1;
            }
        }
    }

    public function showUnselectFees($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id as main_id,category_name as main_cat_name');
        $getresult = $dbObj->get('fee_main_head_category')->result_array();
        $tempArr = array();
        if (!empty($getresult)) {
            foreach ($getresult as $categoryname) {
                $dbObj->select('a.id');
                $dbObj->from('fee_head_class_relation as a');
                $dbObj->join('fee_head_setting as b', 'a.head_id=b.id');
                $dbObj->where("a.class_id", $data['class_id']);
                $dbObj->where("b.main_head_id", $categoryname['main_id']);
                $result = $dbObj->get()->result_array();
                if (empty($result)) {
                    if (!in_array($categoryname['main_id'], array_column($tempArr, 'main_id'))) {
                        $tempArr[] = array('main_id' => $categoryname['main_id'], 'main_cat_name' => $categoryname['main_cat_name']);
                    }
                }
            }
        } else {
            return $getresult;
        }
        return $tempArr;
    }

    /*     * ******************************** Fees installment nitin ************************************************ */

    public function getInstallmentName() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('name,short_code');
        $result = $dbObj->get('fee_installment_master_list')->result_array();
        return $result;
    }

    public function getAllInstallmentList($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $month_names = array("April", "May", "June", "July", "August", "September", "October", "November", "December", "January", "February", "March");
        switch ($data['shortcode']) {
            case 'MOY':
                $result = $this->getInstFinalArray($month_names, 1, $data['billraisedate'], $data['billenddate']);
                break;
            case 'QUY':
                $result = $this->getInstFinalArray($month_names, 3, $data['billraisedate'], $data['billenddate']);

                break;
            case 'HAY':

                $result = $this->getInstFinalArray($month_names, 6, $data['billraisedate'], $data['billenddate']);
                break;
            default:
                $result[] = array(
                    'int_name' => 'installment1',
                    'month_list' => implode(',', $month_names),
                    'billstart' => date('jS M,Y', strtotime($data['billraisedate'] . '-' . $month_names[0] . '-' . date('Y'))),
                    'billend' => date('jS M,Y', strtotime($data['billenddate'] . '-' . $month_names[0] . '-' . date('Y')))
                );
                break;
        }
        return $result;
    }

    public function getInstFinalArray($month, $size, $billraise, $billend) {
        $tempArr = array_chunk($month, $size);
        $year = date('Y');
        foreach ($tempArr as $key => $val) {
            $tempMonth = array();
            $final[$key]['int_name'] = 'Installment' . ($key + 1);
            $final[$key]['billstart'] = '';
            foreach ($val as $monthkey => $row) {
                if ($row == 'January') {
                    $year++;
                }
                if ($final[$key]['billstart'] == '') {
                    $final[$key]['billstart'] = date('Y-m-d', strtotime($billraise . '-' . $row . '-' . $year));
                    $final[$key]['billend'] = date('Y-m-d', strtotime($billend . '-' . $row . '-' . $year));
                }
                $tempMonth[] = $row;
            }

            $final[$key]['month_list'] = implode(',', $tempMonth);
        }

        return $final;
    }

    public function saveInstlmntData($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id');
        $getInstallmentId = $dbObj->get('fee_installment_setting')->result_array();
        if (!empty($getInstallmentId)) {
            $deleteResult = $this->dltePrviousInstlmntData($getInstallmentId, $data['shortcode']);
        }
        foreach ($data['instllmntData'] as $key => $details) {
            $insertData = array('code' => $data['shortcode'], 'inst_name' => $details['int_name'], 'bill_raise_day' => date('Y-m-d', strtotime($details['billstart'])),
                'bill_due_day' => date('Y-m-d', strtotime($details['billend'])));
            $result = $dbObj->insert('fee_installment_setting', $insertData);
            $installmentId = $dbObj->insert_id();
            if ($installmentId > 0) {
                $monthResult = $this->getSaveInstlmntMnth($installmentId, date('Y', strtotime($details['billend'])), $details['month_list']);
                if ($monthResult == -1) {
                    return -1;
                }
            } else {
                return -1;
            }
        }
        if ($installmentId > 0) {
            return $installmentId;
        } else {
            return -1;
        }
    }

    public function getSaveInstlmntMnth($installmentId, $year, $monthlist) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);

        $month = explode(",", $monthlist);
        foreach ($month as $monthName) {
            $mnthDetail[] = array(
                'inst_id' => $installmentId,
                'month_no' => date('n', strtotime($monthName)),
                'year' => $year,
            );
        }
        $dbObj->insert_batch('fee_installment_month_relation', $mnthDetail);
        if ($dbObj->insert_id() > 0) {

            return $dbObj->insert_id();
        } else {
            return -1;
        }
    }

    public function dltePrviousInstlmntData($getInstallmentId, $intallmentCode) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);

        foreach ($getInstallmentId as $value) {

            $result = $dbObj->delete('fee_installment_month_relation', array('inst_id' => $value['id']));
        }

        $result = $dbObj->empty_table('fee_installment_setting');
        if ($dbObj->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*     * ******************************** student fees relation nitin************************************************ */

    public function getStudentDetails($admno) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('adm_no,firstname,lastname,section_id');
        $studentDetail = $dbObj->get_where('biodata', array('adm_no' => $admno))->row_array();
        if ($studentDetail['section_id'] != -1) {
            $sectionDetail = $this->getSectionDetail($studentDetail['section_id']);

            return array('studentdetail' => $studentDetail, 'details' => $sectionDetail);
        } else {
            return array('studentdetail' => $studentDetail, 'details' => -1);
        }
    }

    public function getSectionDetail($sectionid) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('standard,section,class_teacher_id');
        $sectionDetail = $dbObj->get_where('section_list', array('id' => $sectionid))->row_array();
        $this->load->model('core/core', 'objstaff');
        $staffdetail = $this->objstaff->getStaffDetail($sectionDetail['class_teacher_id']);
        $classid = $this->objstaff->getClassId($sectionDetail['standard']);
        return array('sectionDetail' => $sectionDetail, 'staffdetail' => $staffdetail, 'classid' => $classid);
    }

    public function getStudentFeesStructure($sectionId) {
        $classId = $this->GetStandardBySectionId($sectionId);
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,category_name');
        $result = $dbObj->get('fee_main_head_category')->result_array();
        foreach ($result as $key => $value) {
            $dbObj->select('id,head_name,refund_type,upper(mandatory_type) as mandatory_type');
            $getFeesdetail = $dbObj->get_where('fee_head_setting', array('main_head_id' => $value['id']))->result_array();
            if (!empty($getFeesdetail)) {
                $count = 1;
                $mandtorystatus = 0;
                foreach ($getFeesdetail as $headkey => $details) {
                    $dbObj->select('fee_amount');
                    $getAmount = $dbObj->get_where('fee_head_class_relation', array('head_id' => $details['id'], 'class_id' => $classId, 'fee_amount >' => 0))->row_array();
                    if (!empty($getAmount)) {
                        $getFeesdetail[$headkey]['feesAmount'] = $getAmount['fee_amount'];
                        if ($getFeesdetail[$headkey]['mandatory_type'] == 'YES') {
                            $mandtorystatus += $count;
                            $getFeesdetail[$headkey]['status'] = true;
                        } else {
                            $mandtorystatus += 0;
                            $getFeesdetail[$headkey]['status'] = false;
                        }
                    } else {
                        unset($getFeesdetail[$headkey]);
                    }
                }
                $result[$key]['table_length'] = "$mandtorystatus";
            }
            if (!empty($getFeesdetail)) {
                $result[$key]['sub'] = $getFeesdetail;
            } else {
                unset($result[$key]);
            }
        }

        return $result;
    }

    public function GetStandardBySectionId($section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.id,a.standard');
        $dbObj->from('master_class_list as a');
        $dbObj->join('section_list as b', 'a.standard=b.standard');
        $dbObj->where('b.status', '1');
        $dbObj->where('a.id', $section_id);
        $classArr = $dbObj->get()->row_array();
        return $classArr['id'];
    }

    public function saveStudentData($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        if ($data['clssid'] != 'NA') {
            $update = $this->updateBiodataTable($data);
        }
        $dbObj->select('adm_no');
        $admnoId = $dbObj->get_where('fee_student_relation', array('adm_no' => $data['adm_no']))->result_array();
        if (!empty($admnoId)) {
            $deleteData = $this->dltPrvsAdmnoData($data['adm_no']);
        }
        foreach ($data['head_id'] as $key => $value) {
            foreach ($value['sub'] as $details) {
                if ($details['status'] == true) {

                    $myinsert[] = array('adm_no' => $data['adm_no'], 'head_id' => $details['id']);
                }
            }
        }
        $dbObj->insert_batch('fee_student_relation', $myinsert);
        if ($dbObj->insert_id() > 0) {
            return $dbObj->insert_id();
        } else {
            return -1;
        }
    }

    public function updateBiodataTable($data) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $array = array('section_id' => $data['clssid']);
        $dbObj->where('adm_no', $data['adm_no']);
        $dbObj->update('biodata', $array);
        if ($dbObj->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function dltPrvsAdmnoData($admno) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->delete('fee_student_relation', array('adm_no' => $admno));
        if ($dbObj->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*     * ******************************** student fees receipt nitin************************************************ */

    public function StdntDetail($admno) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.adm_no,a.firstname,a.lastname,a.section_id,b.standard,b.section,c.salutation,c.staff_fname,c.staff_lname');
        $dbObj->join('section_list as b', 'a.section_id = b.id');
        $dbObj->join('staff_details as c', 'b.class_teacher_id = c.id');
        $result = $dbObj->get_where('biodata as a', array('adm_no' => $admno, 'b.status' => '1'))->row_array();
        return $result;
    }

    public function getStudentFeeReceipt($Admno) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $Schoolname = $this->getSchoolName();
        $studentDetail = $this->StdntDetail($Admno);
        $monthly = 0;
        $annualy = 0;
        $dbObj->select('head_id');
        $result = $dbObj->get_where('fee_student_relation', array('adm_no' => $Admno))->result_array();
        foreach ($result as $value) {
            $dbObj->select('a.main_head_id,a.id,a.head_name,b.fee_amount,c.code');
            $dbObj->join('fee_head_class_relation as b', 'a.id = b.head_id', 'left');
            $dbObj->join('fee_main_head_category as c', 'c.id = a.main_head_id', 'left');
            $getResult = $dbObj->get_where('fee_head_setting as a', array('a.id' => $value['head_id']))->row_array();
            if ($getResult['code'] == 'MON') {
                $getResult['head_name'] = $getResult['head_name'] . ' @ Rs ' . $getResult['fee_amount'] . ' P.M  for 12 months';
                $getResult['fee_amount'] = $getResult['fee_amount'] * 12;
                $monthly = $monthly + $getResult['fee_amount'];
            } elseif ($getResult['code'] == 'QTY') {
                $getResult['head_name'] = $getResult['head_name'] . '@ Rs ' . $getResult['fee_amount'] . ' P.Q  for 12 months';
                $getResult['fee_amount'] = $getResult['fee_amount'] * 3;
                $monthly = $monthly + $getResult['fee_amount'];
            } else {
                $annualy = $annualy + $getResult['fee_amount'];
            }
            $myArr[] = $getResult;
        }
        $instlmntArray = $this->getInstallment();
        $installment_amount = $monthly / count($instlmntArray);
        foreach ($instlmntArray as $key => $val) {
            $instlmntArray[$key]['ist_amt'] = $monthly;
            if ($key == 0) {
                $instlmntArray[$key]['ist_amt'] = $instlmntArray[$key]['ist_amt'] + $annualy;
            }
        }
        return array('fee_stracture' => $myArr, 'instDeatil' => $instlmntArray, 'stdntDetail' => $studentDetail, 'scoolname' => $Schoolname);
    }

    public function getInstallment() {

        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,inst_name,bill_raise_day,bill_due_day');
        $result = $dbObj->get('fee_installment_setting')->result_array();
        return $result;
    }

    public function getSchoolName() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('school_name,school_address');
        $result = $dbObj->get('school_setting')->row_array();
        return $result;
    }

    /*     * ******************************** student fees entry nitin************************************************ */

    public function getStudntDetails($adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.adm_no,a.firstname,a.lastname,a.section_id,b.standard,b.section');
        $dbObj->join('section_list as b', 'a.section_id = b.id', 'left');
        $studentDetail = $dbObj->get_where('biodata as a', array('adm_no' => $adm_no))->row_array();
        return $studentDetail;
    }

    public function getStdnFeesEntryDetail($adm_no) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('core/core','coreObj');
        $studentDetail = $this->getStudntDetails($adm_no);
        $class_id=$this->coreObj->getClassId($studentDetail['standard']);
        $monthly = 0;
        $annualy = 0;
        $qtrly = 0;
        $dbObj->select('head_id');
        $result = $dbObj->get_where('fee_student_relation', array('adm_no' => $adm_no))->result_array();
    
        if (empty($result)) {
            $myArr[] = array();
        } else {
            foreach ($result as $value) {
                $dbObj->select('a.main_head_id,a.id,a.head_name,b.fee_amount,c.code');
                $dbObj->join('fee_head_class_relation as b', 'a.id = b.head_id', 'left');
                $dbObj->join('fee_main_head_category as c', 'c.id = a.main_head_id', 'left');
                $getResult = $dbObj->get_where('fee_head_setting as a', array('a.id' => $value['head_id'],'b.class_id'=>$class_id['id']))->row_array();
                if ($getResult['code'] == 'MON') {
                    $getResult['head_name'] = $getResult['head_name'] . ' @ Rs ' . $getResult['fee_amount'] . ' P.M  for 12 months';
                    $getResult['yearly_fee_amount'] = $getResult['fee_amount'] * 12;
                    $monthly = $monthly + $getResult['fee_amount'];
                } elseif ($getResult['code'] == 'QTY') {
                    $getResult['head_name'] = $getResult['head_name'] . '@ Rs ' . $getResult['fee_amount'] . ' P.Q  for 12 months';
                    $getResult['yearly_fee_amount'] = $getResult['fee_amount'] * 4;
                    $qtrly = $qtrly + $getResult['fee_amount'];
                } else {
                    $getResult['yearly_fee_amount'] = $getResult['fee_amount'];
                    $annualy = $annualy + $getResult['fee_amount'];
                }
                $myArr[] = $getResult;
            }
        }
        $instlmntArray = $this->getInstallment();
        $counter = 0;
        foreach ($instlmntArray as $key => $val) {
            if ($counter < 4) {
                $instlmntArray[$key]['ist_amt'] = $monthly + $qtrly;
            } else {
                $instlmntArray[$key]['ist_amt'] = $monthly;
            }
            if ($key == 0) {
                $instlmntArray[$key]['ist_amt'] = $instlmntArray[$key]['ist_amt'] + $annualy;
            }
            $lastPaidId = $this->getStudentLastPaymentid($adm_no, $dbObj);

            $paidAmt = $this->getInstlmntPaidAmount($adm_no, $instlmntArray[$key]['id'], $lastPaidId);
            if ($paidAmt == -1) {
                $instlmntArray[$key]['pay_amt'] = 'Not paid Yet..!!';
                $instlmntArray[$key]['balance'] = $instlmntArray[$key]['ist_amt'];
            } else {
                $instlmntArray[$key]['pay_amt'] = $paidAmt['lst_pay_amt'];
                $balance = $instlmntArray[$key]['ist_amt'] - $paidAmt['amt_paid'];
                $instlmntArray[$key]['balance'] = $balance;
            }


            $date = date_diff(date_create(date("Y-m-d")), date_create($instlmntArray[$key]['bill_due_day']));
            $dateArry = explode("+ -", $date->format("%R%a"));
            foreach ($dateArry as $datecalculate) {
                $instlmntArray[$key]['date'] = $datecalculate;
            }
            $counter++;
        }


        return array('fee_stracture' => $myArr, 'instDeatil' => $instlmntArray, 'stdntDetail' => $studentDetail);
    }

    public function getStudentLastPaymentid($adm_no, $dbObj) {
        $dbObj->order_by('timestamp', 'DESC');
        $result = $dbObj->get_where('fee_payment_details', array('adm_no' => $adm_no))->row_array();
        if (!empty($result)) {
            return $result['id'];
        }
    }

    public function getInstlmntPaidAmount($adm_no, $installmentid, $lastPaidId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.amount_paid,b.id,b.amount');
        $dbObj->order_by('b.timestamp', 'DESC');
        $dbObj->from('fee_payment_details as a');
        $dbObj->join('fee_payment_installment_details as b', 'a.id=b.paid_id');
        $dbObj->where('a.adm_no', $adm_no);
        //$dbObj->where('a.id', $lastPaidId);
        $dbObj->where('b.installment_id', $installmentid);
        $paymentId = $dbObj->get()->result_array();
//        echo $dbObj->last_query();
        $sum = 0;

        if (!empty($paymentId)) {
            foreach ($paymentId as $row) {
                $sum = $sum + $row['amount'];
            }
            return array('amt_paid' => $sum, 'lst_pay_amt' => $paymentId[0]['amount']);
        } else {
            return -1;
        }
    }

    public function savePaymentDetails($paydetail) {
        $instDetails = $this->getStdnFeesEntryDetail($paydetail['adm_no']);

        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $staff_id = $this->session->userdata('staff_id');
        $deo_staff_id = $this->session->userdata('deo_staff_id');
        if ($paydetail['data']['amount'] == '') {
            return -1;
        } else {
            $myarray = array(
                'adm_no' => $paydetail['adm_no'],
                'payment_mode' => $paydetail['payment_mode'],
                'amount_paid' => $paydetail['data']['amount'],
                'paid_date' => date('Y-m-d', strtotime($paydetail['data']['date'])),
                'entry_by' => $staff_id,
                'deo_entry_by' => $deo_staff_id,
            );

            $dbObj->insert('fee_payment_details', $myarray);
            $lastInsertId = $dbObj->insert_id();
            if ($lastInsertId <= 0) {
                return -1;
            }
            if ($paydetail['payment_mode'] == 'cheque/dd') {
                $bankArray = array(
                    'paid_id' => $lastInsertId,
                    'cheque_no' => $paydetail['data']['chequenumbr'],
                    'cheq_date' => date('Y-m-d', strtotime($paydetail['data']['date'])),
                    'bank_name' => $paydetail['data']['bankname'],
                    'entry_by' => $staff_id,
                    'deo_entry_by' => $deo_staff_id,
                );
                $dbObj->insert('fee_payment_cheque_detail', $bankArray);
            }
            $myPaidAmt = $paydetail['data']['amount'];
            foreach ($instDetails['instDeatil'] as $instObj) {
                if ($instObj['id'] <= $paydetail['InstllmntId']) {
                    if ($instObj['balance'] > 0) {
                        if ($myPaidAmt > 0) {
                            $newTempAmt = $myPaidAmt - $instObj['balance'];
                            if ($newTempAmt > 0) {
                                $instPaidAmt = $instObj['balance'];
                                $myPaidAmt = $newTempAmt;
                            } else {
                                $instPaidAmt = $myPaidAmt;
                                $myPaidAmt = 0;
                            }
                            $InstallmntArray[] = array(
                                'paid_id' => $lastInsertId,
                                'installment_id' => $instObj['id'],
                                'amount' => $instPaidAmt,
                                'entry_by' => $staff_id,
                                'deo_entry_by' => $deo_staff_id,
                            );
                        }
                    }
                }
            }
            $dbObj->insert_batch('fee_payment_installment_details', $InstallmntArray);
            if ($dbObj->insert_id() > 0) {
                return $dbObj->insert_id();
            } else {
                return -1;
            }
        }
    }

    public function viewInstlmntDetails($data) {

        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id');
        $result = $dbObj->get_where('fee_payment_details', array('adm_no' => $data['adm_no']))->result_array();

        foreach ($result as $value) {
            $dbObj->select('a.paid_id,b.payment_mode,b.paid_date,a.amount,c.cheque_no,c.cheq_date,c.bank_name');
            $dbObj->join('fee_payment_details as b', 'a.paid_id = b.id', 'left');
            $dbObj->join('fee_payment_cheque_detail as c', 'b.id = c.paid_id', 'left');
            $getInstlDetails = $dbObj->get_where('fee_payment_installment_details as a', array('a.installment_id' => $data['installmntId'], 'a.paid_id' => $value['id']))->row_array();
            if (!empty($getInstlDetails)) {
                $temp[] = $getInstlDetails;
            }
        }

        return $temp;
    }

    public function totalFineAmount($fineDays) {

        if ($fineDays > 0) {
            $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
            $dbObj->select('fine_amount');
            $fineAmnt = $dbObj->get('fee_late_fine_setting')->row_array();
            $totalFine = ($fineAmnt['fine_amount']) * ($fineDays);
            return array('totalfine' => $totalFine);
        } else {
            return array('totalfine' => 0);
        }
    }

    /*     * ********************************  fees management sapna************************************************ */

    public function selectmainhead() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('category_name,id');
        $dbObj->from('fee_main_head_category');
        $category_name = $dbObj->get()->result_array();
        return $category_name;
    }

}
