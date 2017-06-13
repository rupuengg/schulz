<?php

/* * ***************************************Parent Portal App Service******************************** */
$route['app/registration'] = "app/applogin_controller/deviceregister";
$route['app/schooldetail'] = "app/applogin_controller/schooldetail";
$route['app/schoolname'] = "app/applogin_controller/getschoollist";
$route['app/login'] = "app/applogin_controller/loginme";
$route['app/homepage'] = "app/apphomepage_controller/loadhomepagedata";
$route['app/marks'] = "app/appacademics_controller";
$route['app/cards'] = "app/appcards_controller/loadcarddata";
$route['app/ccegrade'] = "app/appccegrade_controller/loadccegradedata";
$route['app/homework'] = "app/apphomework_controller/loadhomeworkdata";
$route['app/myhomework'] = "app/apphomework_controller/loadmyhomeworkdata";
$route['app/attendance'] = "app/appattendance_controller/loadattdata";
$route['app/lateattendance'] = "app/applateattendance_controller/loadlateattdata";
$route['app/message'] = "app/appmessage_controller/loadmessagedata";
$route['app/notice'] = "app/appnotice_controller/loadnoticedata";
$route['app/mynotice'] = "app/appnotice_controller/loadmynoticedata";
$route['app/notification'] = "app/appnotification_controller/loadnotificationdata";
$route['app/event'] = "app/appevent_controller/loadeventdata";
$route['app/myevent'] = "app/appevent_controller/loadmyeventdata";
$route['app/examdatesheet'] = "app/appexamdatesheet_controller/loadmyexamdateSheet";
$route['app/mydatesheet'] = "app/appexamdatesheet_controller/getdatesheet";
$route['app/summary'] = "app/appsummary_controller/loadsummarydata";
$route['app/markssummary'] = "app/appsummary_controller/loadstudentmarksdata";
$route['app/getstaffphoto/(:any)/(:any)'] = "app/applogin_controller/getstaffphoto/$1/$2";
$route['app/getstudphoto/(:any)/(:any)'] = "app/applogin_controller/getstudentphoto/$1/$2";

$route['app/subjectdetail'] = "app/appsubjectdetail_controller/subjectdata";
$route['app/exammarksstructure'] = "app/appsubjectdetail_controller/markstructure";

/* * ************************************************Staff Portal App Service********************************** */
$route['app/staffdashboard'] = "staffapp/appdashboard_controller/admindashboardjson";



/*********	END ANDROID APP 	***********************/
