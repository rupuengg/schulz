<?php
/****************Bus contractor***********/
$route['staff/buscontract'] = "staff/transport_controller/buscontrator";

/********************* Bus Entry Module******************/
$route['staff/busmodule'] = "staff/transport_controller/busmoduleview";
$route['staff/busmodule/(:any)'] = "staff/transport_controller/busmoduleview/$1";
/* ServiceUrl */$route['staff/getbuscontractor'] = "staff/transport_controller/getbuscontractor";
/* ServiceUrl */$route['staff/savebusdetail'] = "staff/transport_controller/savebusdetail";
/* ServiceUrl */$route['staff/getallbuslist'] = "staff/transport_controller/getallbuslist";
/* ServiceUrl */$route['staff/deletebusdetail'] = "staff/transport_controller/deletebusdetail";
/* ServiceUrl */$route['staff/countbuspaper'] = "staff/transport_controller/countbuspaper";
/********************Bus Stop Module*************/
$route['staff/busstop'] = "staff/transport_controller/managebusstop";
/***********Driver Entry Module**********************/
$route['staff/drivermodule'] = "staff/transport_controller/managedriver";
/************************Bus Trip Manage Module*****************/
$route['staff/managebustrip'] = "staff/transport_controller/managebustrip";
/*serviceUrl*/$route['staff/managebustrip/(:any)'] = "staff/transport_controller/managebustrip/$1";
/*serviceUrl*/$route['staff/managebustrip/(:any)/(:any)']="staff/transport_controller/managebustrip/$1/$2";
/*serviceUrl*/$route['staff/getallbusdetails'] = "staff/transport_controller/getallbusdetails";
/*serviceUrl*/$route['staff/savenewtrip'] = "staff/transport_controller/savenewtrip";
/*serviceUrl*/$route['staff/getbustrip'] = "staff/transport_controller/getbustrip";
/*serviceUrl*/$route['staff/gettripdetail'] = "staff/transport_controller/gettripdetail";
/*serviceUrl*/$route['staff/busdetails'] = "staff/transport_controller/busdetails";
/* ServiceUrl */$route['staff/saveallstop']="staff/transport_controller/saveallstop";
/* ServiceUrl */$route['staff/removetrip']="staff/transport_controller/removetrip";
/* ServiceUrl */$route['staff/getallstoplist']="staff/transport_controller/serachStop";
/* ServiceUrl */$route['staff/getalltripdetail']="staff/transport_controller/getalltripdetail";

/*******************Bus/Driver Manage Module *********/
$route['staff/managebusdriver'] = "staff/transport_controller/managebusdriverrelation";
$route['staff/managebusdriver/(:any)'] = "staff/transport_controller/managebusdriverrelation/$1";
/* ServiceUrl */$route['staff/getallbusdetail'] = "staff/transport_controller/getbusdetails";
/* ServiceUrl */$route['staff/getbustripdriverdetail'] = "staff/transport_controller/getbustripdriverdetails";
/* ServiceUrl */$route['staff/getalldriverlist']="staff/transport_controller/searchdriverconductor";
/* ServiceUrl */$route['staff/savebusdriverrelation']="staff/transport_controller/savebusdriverrelationDetails";
/* ServiceUrl */$route['staff/deletebusdriverconductor']="staff/transport_controller/deletedriverconductor";


/***********************Manage Bus Student Moduloe**************/
$route['staff/managestudentbus'] = "staff/transport_controller/managestudentbus";
$route['staff/managestudentbus/(:any)'] = "staff/transport_controller/managestudentbus/$1";
/* ServiceUrl */$route['staff/getissuedstudentlist']="staff/transport_controller/getissuedstudentlist";
/* ServiceUrl */$route['staff/removeissuedtrip']="staff/transport_controller/removeissuedtrip";
/* ServiceUrl */$route['staff/savestudenttripbysection']="staff/transport_controller/savestudenttripbysection";
/* ServiceUrl */$route['staff/removeissuedtripsectionwise']="staff/transport_controller/removeissuedtripsectionwise";
/* ServiceUrl */$route['staff/getallstudent']="staff/transport_controller/getallstudent";
/* ServiceUrl */$route['staff/savestudenttrip']="staff/transport_controller/savestudenttrip";
/* ServiceUrl */$route['staff/getsectionlist']="staff/transport_controller/getsectionlist";
/* ServiceUrl */$route['staff/getallstudentsectionwise']="staff/transport_controller/getallstudentsectionwise";


/**************************report module*************************/
$route['staff/generatereport'] = "staff/transport_controller/generatereport";
$route['staff/generatereport/(:any)'] = "staff/transport_controller/generatereport/$1";
/* ServiceUrl */$route['staff/getbusstops'] = "staff/transport_controller/getbusstops";
/* ServiceUrl */$route['staff/getalltrip'] = "staff/transport_controller/getalltrip";
