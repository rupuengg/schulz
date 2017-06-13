<?php

/* * ******************************Group Wise Settings************************************* */
$route['staff/groupwisesettings'] = "staff/timetable_controller/groupwisesettings";
$route['staff/groupwisesettings/(:any)'] = "staff/timetable_controller/groupwisesettings/$1";
/* serviceURL */$route['staff/getgroup'] = "staff/timetable_controller/getgroups";
/* serviceURL */$route['staff/savegroup'] = "staff/timetable_controller/savegroups";
/* serviceURL */$route['staff/assignteachers'] = "staff/timetable_controller/assignteachers";
/* serviceURL */$route['staff/saveassignteachers'] = "staff/timetable_controller/saveassignteachers";
/* serviceURL */$route['staff/addgroupstaffs'] = "staff/timetable_controller/addgroupstaffs";
/* serviceURL */$route['staff/getgroupdetails'] = "staff/timetable_controller/getgroupdetails";
/* serviceURL */$route['staff/deletegroup'] = "staff/timetable_controller/deletegroups";

/* * ******************************Working Hours Settings************************************* */
$route['staff/workinghours'] = "staff/timetable_controller/workinghours";
/* serviceURL */$route['staff/getworkinghour'] = "staff/timetable_controller/getworkinghours";
/* serviceURL */$route['staff/saveworkinghour'] = "staff/timetable_controller/saveworkinghours";


/* * *********************manage period module****************** */
$route['staff/manageperiod'] = "staff/timetable_controller/manageperiod";
$route['staff/manageperiod/(:any)'] = "staff/timetable_controller/manageperiod/$1";
/* ServiceUrl */$route['staff/getgrouplist'] = "staff/timetable_controller/getgrouplist";
/* ServiceUrl */$route['staff/saveperioddetail/(:any)'] = "staff/timetable_controller/saveperioddetail/$1";
/* ServiceUrl */$route['staff/getperiodlist/(:any)'] = "staff/timetable_controller/getperiodlist/$1";
/* ServiceUrl */$route['staff/deleteperioddetail'] = "staff/timetable_controller/deleteperioddetail";
/* * *******************class wise time table************************* */
$route['staff/classwisetimetable'] = "staff/timetable_controller/classwisetimetable";
$route['staff/classwisetimetable/(:any)'] = "staff/timetable_controller/classwisetimetable/$1";
$route['staff/classwisetimetable/(:any)/(:any)'] = "staff/timetable_controller/classwisetimetable/$1/$2";
/* ServiceUrl */$route['staff/getsection/(:any)'] = "staff/timetable_controller/getsection/$1";
/* ServiceUrl */$route['staff/getsubjectlist/(:any)'] = "staff/timetable_controller/getsubjectlist/$1";
/* ServiceUrl */$route['staff/getclasstimetable/(:any)/(:any)'] = "staff/timetable_controller/getclasstimetable/$1/$2";
/* ServiceUrl */$route['staff/assignsubjectteacher'] = "staff/timetable_controller/assignsubjectteacher";

/* * ******************************Substitute Time Table************************************* */

$route['staff/substitutetimetable'] = "staff/timetable_controller/substitutetimetable";
$route['staff/substitutetimetable/(:any)'] = "staff/timetable_controller/substitutetimetable/$1";

$route['staff/getsubstituteteacher'] = "staff/timetable_controller/getstaffperiod";

/* serviceURL */$route['staff/loadabsentteachers'] = "staff/timetable_controller/loadabsentteachers";
/* serviceURL */$route['staff/getsubstituteteachers'] = "staff/timetable_controller/getsubstituteteachers";
/* serviceURL */$route['staff/loadteachersubjects'] = "staff/timetable_controller/loadteachersubjects";

/* serviceURL */$route['staff/loadteachersubjects'] = "staff/timetable_controller/loadteachersubjects";

/* serviceURL */$route['staff/loadsubstituteteachers'] = "staff/timetable_controller/loadsubstituteteachers";
/* serviceURL */$route['staff/getperioddetails/(:any)'] = "staff/timetable_controller/getperioddetails/$1";

/* serviceURL */$route['staff/savesubstitutedetails'] = "staff/timetable_controller/savesubstitutedetails";

