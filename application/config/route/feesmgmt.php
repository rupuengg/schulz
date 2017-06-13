<?php

/* * ****************Fee Management************ */
/* service url*/$route['staff/feemgmt'] = "staff/feesmgmt_controller";


/* * ****************class wise fee headsetting   Nitin************ */
$route['staff/classrel'] = "staff/feesmgmt_controller/showClassRelation";
/* service url*/$route['staff/getclassdata'] = "staff/feesmgmt_controller/showData";
/* service url*/$route['staff/getfeesdata'] = "staff/feesmgmt_controller/getFeesData";
/* service url*/$route['staff/savefeesdetails'] = "staff/feesmgmt_controller/saveDetails";




/* * ****************Fee Installment   Nitin************ */
$route['staff/feesinstallment'] = "staff/feesmgmt_controller/showFeesInstallment";
/* service url*/$route['staff/getinstallment'] = "staff/feesmgmt_controller/getInstallment";
/* service url*/$route['staff/savedetails'] = "staff/feesmgmt_controller/saveInstlmntDetail";

/* * ****************student Fees relation   Nitin************ */
$route['staff/studntfeesprofile/(:any)'] = "staff/feesmgmt_controller/showStudentFeesProfile/$1";
/* service url*/$route['staff/custmizfees'] = "staff/feesmgmt_controller/customizeFees";
/* service url*/$route['staff/classrel/(:any)'] = "staff/feesmgmt_controller/showClassRelation/$1";
/* service url*/$route['staff/save'] ="staff/feesmgmt_controller/saveStudentData" ;

/* * ****************student fees entry   Nitin************ */
$route['staff/studentfeesentry'] = "staff/feesreceipt_controller/showStudentFeeEntry";
$route['staff/slctedstdntDetls'] = "staff/feesreceipt_controller/selectedStudentDetails";
$route['staff/paymntdetail'] = "staff/feesreceipt_controller/savePaymentDetails";
$route['staff/viewinstlmnt'] = "staff/feesreceipt_controller/viewInstlmntDetails";
$route['staff/fine'] = "staff/feesreceipt_controller/totalFineAmount";

/* * ****************student fee receipt   Nitin************ */
$route['staff/studentfeereceipt/(:any)'] = "staff/feesreceipt_controller/showStudentFeeReceipt/$1";

/* * **************** Fee Management SAPNA************ */
/* service */$route['staff/feemgmt'] = "staff/feesmgmt_controller";
$route['staff/headsetting']="staff/feesmgmt_controller/loadheadsettingview";
$route['selectcategory']="staff/feesmgmt_controller/fetchmainhead";
$route['headsetting/(:any)']="staff/feesmgmt_controller/loadheadsettingview/$1";


/******************Bank List Management SAPNA************* */
$route['banklist']="staff/feesreceipt_controller/loadbanklistview";

/* * ****************Late fine Management SAPNA************* */
$route['staff/latefine']="staff/feesreceipt_controller/latefineview";