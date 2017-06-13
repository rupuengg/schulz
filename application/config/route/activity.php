<?php
/**********************Activity module*********************************/
$route['activity/addproject'] = "activity/activity_controller/projectyentry";
$route['activity/addactivity'] = "activity/activity_controller/activityentry";
$route['activity/empactivityentry'] = "activity/activity_controller/empactivityentry";
$route['activity/empactivityentry/(:any)'] = "activity/activity_controller/empactivityentry/$1";
$route['activity/viewactivity'] = "activity/activity_controller/viewactivity";
$route['activity/viewactivity/(:any)/(:any)/(:any)'] = "activity/activity_controller/viewactivity/$1/$2/$3";
$route['activity/addemployee'] = "activity/activity_controller/addemployee";
$route['activity/adddesignation'] = "activity/activity_controller/adddesignation";
$route['activity/addrm'] = "activity/activity_controller/adddrm";
$route['activity/userid']="activity/activity_controller/userid";
/* Service url */$route['activity/emplist'] = "activity/activity_controller/emplist";
/* Service url */$route['activity/totalhour'] = "activity/activity_controller/totalhour";
$route['activity/nightservice']="activity/service_controller/informationofactivity";
$route['activity/morningservice']="activity/service_controller/reminderofactivity";

