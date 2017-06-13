<?php

/* * **********************************Staffapp Login *********************************************** */
$route['staffapp/registration'] = "staffapp/staffapplogin_controller/deviceregister";
$route['staffapp/login'] = "staffapp/staffapplogin_controller/loginme";

/* * ************************************************Staff Stats Api********************************** */
$route['staffapp/birthday'] = "staffapp/staffapp_dashboardcontroller/getBirthday";
$route['staffapp/todo'] = "staffapp/staffapp_dashboardcontroller/getTodo";
$route['staffapp/homework'] = "staffapp/staffapp_dashboardcontroller/getHomework";
$route['staffapp/examdatesheet'] = "staffapp/staffapp_dashboardcontroller/getExamDateSheet";
$route['staffapp/notice'] = "staffapp/staffapp_dashboardcontroller/getNotice";
$route['staffapp/event'] = "staffapp/staffapp_dashboardcontroller/getEvent";
$route['staffapp/cardcount'] = "staffapp/staffapp_dashboardcontroller/getCardCount";
$route['staffapp/upcomingholiday'] = "staffapp/staffapp_dashboardcontroller/getupcomingholiday";
/* * ************************************************Staff Portal App Service********************************** */
$route['staffapp/staffclass'] = "staffapp/marks_controller/GetStaffClass";
$route['staffapp/subjectexam'] = "staffapp/marks_controller/GetSubjectExam";
$route['staffapp/stusubmark'] = "staffapp/marks_controller/GetStudentSubjectMarks";
/* * ************************************************Staff Portal Attendance App Service********************************** */
$route['staffapp/attendance'] = "staffapp/attendance_controller/GetattData";
$route['staffapp/sectionlist'] = "staffapp/attendance_controller/GetSection";
/* * ************************************************Staff Portal CCE Grades App Service********************************** */

$route['staffapp/ccesection'] = "staffapp/ccegrades_controller/GetcceData";
$route['staffapp/cceentry'] = "staffapp/ccegrades_controller/GetStudentccegradeData";
/* * ************************************************Staff Portal Card App Service********************************** */
$route['staffapp/carddetail'] = "staffapp/staffapp_dashboardcontroller/getCardDet";
/* * ********************************************Staff Homework module********************************************** */
$route['staffapp/hwmain'] = "staffapp/homework_controller/GetHwMainData";
$route['staffapp/classassgmnt'] = "staffapp/homework_controller/GetHwTopics";
$route['staffapp/assgmntdetail'] = "staffapp/homework_controller/GetAssgmntDetail";




/* * **********************Staffapp Admin Dashboard *************************** */
$route['adminapp/dshbrd'] = "staffapp/admindashboard_controller/MainData";
$route['adminapp/notice'] = "staffapp/notice_controller/NoticeGet";
$route['adminapp/noticecount'] = "staffapp/notice_controller/total_staff_stu_count";
$route['adminapp/comingbday'] = "staffapp/admindashboard_controller/getUpcomingBirthday";
$route['adminapp/rcntlylog'] = "staffapp/admindashboard_controller/getrcntlyLogin";
$route['adminapp/library'] = "staffapp/libraryadmin_controller/GetLibData";
$route['adminapp/lateentry'] = "staffapp/lateentry_controller/GetLateEntryData";
$route['adminapp/attendance'] = "staffapp/attendance_controller/getattadmindata";
$route['adminapp/event'] = "staffapp/event_controller/GetEventData";
$route['adminapp/examdatesheet'] = "staffapp/examdatesheet_controller/GetExamdatesheet";
$route['adminapp/noticesend'] = "staffapp/notice_controller/saveNoticeSendDetail";

