<?php

/* * *************** Testing  ********************** */
$route['testing/manageproject'] = "testing/projectmanagement_controller/addprojects";
$route['testing/developerbugdetail'] = "testing/projectmanagement_controller/developerbugdetails";
$route['testing/developerbugdetail/(:any)'] = "testing/projectmanagement_controller/developerbugdetails/$1";
$route['testing/developerbugdetail/(:any)'] = "testing/projectmanagement_controller/developerbugdetails/$1/$2";
$route['testing/testerbugdetail'] = "testing/projectmanagement_controller/testerbugdetails";
$route['testing/testerbugdetail/(:any)'] = "testing/projectmanagement_controller/testerbugdetails/$1";
$route['testing/testerbugdetail/(:any)'] = "testing/projectmanagement_controller/testerbugdetails/$1/$2";
$route['testing/manageproject/(:any)'] = "testing/projectmanagement_controller/addprojects/$1";
/* ServiceUrl */$route['testing/updatestatus'] = "testing/projectmanagement_controller/updatebugstatusdeveloper";
/* ServiceUrl */$route['testing/updatestatustester'] = "testing/projectmanagement_controller/updatebugstatustester";
/* ServiceUrl */$route['testing/updatestatuspending'] = "testing/projectmanagement_controller/updatebugpendingstatustester";
$route['testing/company'] = "testing/projectmanagement_controller/testingmain";
$route['testing/bugpost'] = "testing/bugpost_controller/bugpostnow";
$route['testing/bugpost/(:any)'] = "testing/bugpost_controller/bugpostnow/$1";
$route['testing/bugpost/(:any)'] = "testing/bugpost_controller/bugpostnow/$1/$2";
$route['testing/bugpost/(:any)'] = "testing/bugpost_controller/bugpostnow/$1/$2/$3";
/* ServiceUrl */$route['testing/saveremark'] = "testing/projectmanagement_controller/saveremarkmessage";


