<?php

/* * ******************************************************** [[ PARENTS PORTAL ]]  ********************************************************************************************************************************* */
/* * ***********************************************************                    *********************************************************************************************************************************** */
/* * ******************************************************** [[ PARENTS PORTAL ]]  ********************************************************************************************************************************* */
/* * ***********************************************************                    *********************************************************************************************************************************** */
/* * *************** __________ACADEMICS_______________******************  */
$route['parent/academics'] = "parent/academics_controller/loadacademics";
/* service url */$route['parent/loadmarks'] = "parent/academics_controller/loadmarks";
/* service url */$route['parent/getgraphdetail'] = "parent/academics_controller/getgraphdatadetail";

/* * *************** __________ LoadAttendance _______________******************  */
$route['parent/attendance'] = "parent/attendance_controller/LoadAttendance";
/* Service url */ $route['parent/getabsentattendance'] = "parent/attendance_controller/attabsentdata";
/* Service url */$route['parent/getattendancesummary'] = "parent/attendance_controller/attsummary";


/* * *************** __________ LoadCards _______________******************  */
$route['parent/cards'] = "parent/cards_controller/LoadCards";
/* service url */$route['parent/carddetail'] = "parent/cards_controller/getloadcarddetails";
/* service url */$route['parent/cardcountdeatils'] = "parent/cards_controller/cardcountdetail";

/* * *************** __________ LoadCCEGrade _______________******************  */
$route['parent/ccegrade'] = "parent/ccegrade_controller/LoadCCEGrade";
/* service url */ $route['parent/getccegrade'] = "parent/ccegrade_controller/getccegrade";
/* service url */$route['parent/getrightccegrade'] = "parent/ccegrade_controller/getrightccegrade";

/* * *************** __________ LoadEvents _______________******************  */
$route['parent/events'] = "parent/events_controller/loadevents";
$route['parent/events/(:any)'] = "parent/events_controller/getmyevents/$1";
/* service url */$route['parent/eventdetail'] = "parent/events_controller/geteventsdetails";


/* * *************** __________ LoadGallery _______________******************  */
$route['parent/gallery'] = "parent/gallery_controller/LoadGallery";

/* * *************** __________ Loadhomepage _______________******************  */
$route['parent/homepage'] = "parent/homepage_controller/Loadhomepage";
/* service url */$route['parent/upcomingnews'] = "parent/homepage_controller/getnewsupdate";
/* service url */$route['parent/getholidays'] = "parent/homepage_controller/getholidaylist";
/* service url */$route['parent/getnotification'] = "parent/homepage_controller/getnotification";

/* * *************** __________ LoadNotice _______________******************  */
$route['parent/notice'] = "parent/notice_controller/LoadNotice";
$route['parent/notice/(:any)'] = "parent/notice_controller/LoadNotice/$1";
/* service url */$route['parent/noticedetail'] = "parent/notice_controller/getnotice";

/* * *************** __________ LoadSummary _______________******************  */
$route['parent/summary'] = "parent/summary_controller/LoadSummary";
/* service url */$route['parent/getallsummarydata'] = "parent/summary_controller/getallsummarydetails";
/* service url */$route['parent/cardcount'] = "parent/summary_controller/getcardcount";
/* service url */$route['parent/studentmark'] = "parent/summary_controller/getstudentmarks";

/* * *************** __________ LoadTardy _______________******************  */
$route['parent/tardy'] = "parent/tardy_controller/LoadTardy";
/* service url */$route['parent/lateattendance'] = "parent/tardy_controller/getlateattendance";
/* service url */$route['parent/gettardysummary'] = "parent/tardy_controller/gettardystatus";


/* * *************** __________HomeWork_______________******************  */
$route['parent/homework'] = "parent/homework_controller/loadhomeworkview";
$route['parent/homework/(:any)'] = "parent/homework_controller/loadhomeworkview/$1";
/* Service url */$route['parent/gethomework'] = "parent/homework_controller/getstudenthomework";

/* * **************************************Switch Student******************************** */
$route['parent/switchstudent/(:any)'] = "parent/switchstudent_controller/switchstudent/$1";


/* * *************** __________ ComingSoon _______________******************  */
$route['parent/comingsoon'] = "parent/comingsoon_controller/ComingSoon";


/* * ***********************___________Library Module__________**************************** */
$route['parent/library'] = "parent/library_controller/loadview";

/***************************************Subject Full Details ***************************************/
$route['parent/subjectdetails/(:any)']="parent/subjectdetail_controller/subjectdata/$1";
/*Service url*/ $route['parent/markstructure']="parent/subjectdetail_controller/markstructure";

/* * *********************_______Exam Datesheet Module_______************************** */
$route['parent/examdatesheet'] = "parent/examdatesheet_controller/loadexamdatesheetview";
$route['parent/examdatesheet/(:any)'] = "parent/examdatesheet_controller/loadexamdatesheetview/$1";
/* Service url */$route['parent/getexamdatesheet'] = "parent/examdatesheet_controller/getdatesheet";

/* * *************************************Message Module*************************************** */
$route['parent/message'] = "parent/message_controller/loadview";
$route['parent/message/(:any)'] = "parent/message_controller/loadview/$1";
/* Service URL */$route['parent/getmessagedetail'] = "parent/message_controller/getmessage";
/* Service URL */$route['parent/sendmessage'] = "parent/message_controller/sendmessage";
/*Service URL*/$route['parent/myupdatemessage']="parent/message_controller/updatedmessage";

/* * ***********************___________Notification Module__________**************************** */
$route['parent/allnotification'] = "parent/notification_controller/allnotification";
/*Service url*/ $route['parent/notificationdata']="parent/notification_controller/notificationdata";

