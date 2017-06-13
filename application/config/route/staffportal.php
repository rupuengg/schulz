<?php

$route['404_override'] = '';
/* * ****************Login Controller************* */
$route['default_controller'] = "login/login_controller";
$route['login/checklogindetail'] = "login/login_controller/checklogindetail";

$route['login/resetpassword'] = "login/login_controller/resetpassword";
/* service url */$route['login/checkresetpassword'] = "login/login_controller/checkresetpassword";


$route['login/changeidpassword'] = "login/login_controller/changeidalso";
/* service url */$route['login/changeuserpassword'] = "login/login_controller/changeidpassword";
$route['login/accountdeactivated'] = "login/login_controller/accountdeactivate";
$route['login/logout'] = "login/login_controller/logout";
//********************Staff Management**********************//
$route['staff/managestaff'] = "staff/staff_controller";
$route['staff/getphoto/(:any)/(:any)'] = "staff/staff_controller/getStaffPhoto/$1/$1";
$route['staff/getstaffmenu/(:any)'] = "staff/staff_controller/getStaffMenu/$1";
/* serviceurl */$route['staff/getallstaff'] = "staff/staff_controller/getstaffdetail";
/* serviceurl */$route['staff/saveallstaff'] = "staff/staff_controller/saveupdatestaffdetail";
/* serviceurl */$route['staff/savestaffprivilege'] = "staff/staff_controller/saveStaffPrivilege";
/* serviceurl */$route['staff/fetchstaffmenu/(:any)'] = "staff/staff_controller/getStaffMenu/$1";
/* serviceurl */$route['staff/uploadpic'] = "staff/staff_controller/profilePictureUpload";

//***************************sms**************************************
$route['staff/smsmodule'] = "staff/sms_controller";
$route['staff/getallsectionlist'] = "staff/sms_controller/getallsection";
/* serviceurl */$route['staff/getstudentlist/(:any)'] = "staff/sms_controller/getallstudent/$1";
/* service url */$route['staff/getstudentlist'] = "staff/sms_controller/getallstudent";
/* service url */$route['staff/sendsmsnow'] = "staff/sms_controller/sendsms";

//******************************Notice*********************************************
$route['staff/noticemodule'] = "staff/notice_controller";
/* service url */$route['staff/sendnotice'] = "staff/notice_controller/getnoticedeatil";
/* service url */$route['staff/senddirectnotice'] = "staff/notice_controller/noticesenddirect";

//****************************grade emtry and summary*****************************
$route['staff/cceentry'] = "staff/grade_controller";
/* service url */$route['staff/getallccenamelist'] = "staff/grade_controller/getccename";
/* service url */$route['staff/getmystudent'] = "staff/grade_controller/getmystudent";
/* service url */$route['staff/savegradedetail'] = "staff/grade_controller/savegradedetail";
/* service url */$route['staff/gradesummary'] = "staff/grade_controller/gradesummaryview";
/* service url */$route['staff/studentgradelist'] = "staff/grade_controller/getgradedetails";

/* * ********************** Attendence************* */
$route['staff/manageattendence'] = "staff/attendence_controller";
/* ServiceUrl */$route['staff/getattendencelist'] = "staff/attendence_controller/getattendence";
/* ServiceUrl */$route['staff/saveattendence'] = "staff/attendence_controller/saveattendencedetail";
/* ServiceUrl */$route['staff/markallattendence'] = "staff/attendence_controller/markallattendencedetail";

/* * ********************** Attendence Summary ************* */
$route['staff/attsummary'] = "staff/attendence_controller/attendencesummaryview";
/* ServiceUrl */$route['staff/getattsummary'] = "staff/attendence_controller/getsummary";

//***********************Manage Event **************************************
$route['staff/manageevent'] = "staff/event_controller/addevent";
$route['staff/myevents'] = "staff/event_controller/loadpage";
/* ServiceUrl */$route['staff/myevents/(:any)'] = "staff/event_controller/loadpage/$1";
/* ServiceUrl */$route['staff/myevents/(:any)/(:any)'] = "staff/event_controller/loadpage/$1/$2";
/* ServiceUrl */$route['staff/staffevent'] = "staff/event_controller/geteventstaff";
/* ServiceUrl */$route['staff/loadeventdetail'] = "staff/event_controller/loadeventdetail";
/* DONE************Manage Section- Add/Delete/update new section (9A,9B etc....) */
$route['staff/managesection'] = "staff/sectionmanagement_controller/addsection";
$route['staff/managesection/(:any)'] = "staff/sectionmanagement_controller/addsection/$1";
/* * ************************ END ***************************** */

/* MODULE : ADMIN3 *************Manage Subject -Add remove delete ******************************** */
$route['staff/managesubject'] = "staff/subjectmanagement_controller/addsubject";
$route['staff/managesubject/(:any)'] = "staff/subjectmanagement_controller/addsubject/$1";
/* * ************************ END MODULE : ADMIN3 ***************************** */

/* DONE * ************* Manage Class Teacher  ************************ */
$route['staff/manageclassteacher'] = "staff/sectionmanagement_controller/addclassteacher";
/* * ******** END Manage Class Teacher  ************************ */

/* DONE ********************Manage Subject teacher *************************** */
$route['staff/subjectteacher'] = "staff/subjectmanagement_controller/managesubjectteacher";
$route['staff/subjectteacher/(:any)'] = "staff/subjectmanagement_controller/managesubjectteacher/$1";
/* * ************************ END ***************************** */

/* DONE *******************Manage CCE ELEMENT LIST -Add remove delete  ************************ */
$route['staff/ccelist'] = "staff/ccemanagement_controller/managecce";
$route['staff/ccelist/(:any)'] = "staff/ccemanagement_controller/managecce/$1";
/* * *********** END CCE ELEMENT  ******************** */

/* DONE  ******************* MANAGE CCE TEACHER ASSIGNMENT  ****************** */
$route['staff/assigncceelement'] = "staff/ccemanagement_controller/managecee_teacher";
$route['staff/assigncceelement/(:any)'] = "staff/ccemanagement_controller/managecee_teacher/$1";
/* * ************************ END ***************************** */

//Manage Combo Management - Add new combo and add subjects to combo
$route['staff/managecombourl'] = "staff/combomanagement_controller/manage_combos";
$route['staff/managecombourl/(:any)'] = "staff/combomanagement_controller/manage_combos/$1";
$route['staff/managecombourl/(:any)/(:any)'] = "staff/combomanagement_controller/manage_combos/$1/$2";
$route['staff/managecombosectionurl'] = "staff/combomanagement_controller/manage_combos";
$route['staff/managecombosectionurl/(:any)'] = "staff/combomanagement_controller/manage_combo_and_assign_to_section/$1";
/* service url */$route['staff/combosectionsave'] = "staff/combomanagement_controller/combosectionsave";
/* service url */$route['staff/combosave'] = "staff/combomanagement_controller/save_combo";

/* * **************************CCE ENTRY MODULE**************************** */
$route['staff/ccegradeentry'] = "staff/ccemanagement_controller/ccegradeentryload";
/* service url */$route['staff/getallccesectionlist'] = "staff/ccemanagement_controller/getallsection";
/* service url */$route['staff/getallccenamelist'] = "staff/ccemanagement_controller/getccename";
/* service url */$route['staff/getmystudent'] = "staff/ccemanagement_controller/getmystudent";
/* service url */$route['staff/savegradedetail'] = "staff/ccemanagement_controller/savegradedetail";

/* * **************************  VIEW CCE GRADE SUMMARY   *************************** */
$route['staff/gradesummary'] = "staff/ccemanagement_controller/gradesummaryview";
/* service url */$route['staff/studentgradelist'] = "staff/ccemanagement_controller/getgradedetails";
//********************Declare Exam Start*********************************

$route['staff/decalareexam'] = "staff/marksentry_controller/declareexam";
/* service url */$route['staff/decalareexam/(:any)'] = "staff/marksentry_controller/declareexam/$1";


//*****************************Marks Entry Start *****************************
$route['staff/marksentry'] = "staff/marksentry_controller";
$route['staff/marksentry/(:any)/(:any)/(:any)'] = "staff/marksentry_controller/index/$1/$2/$3";
/* service url */$route['staff/getmysubjectname'] = "staff/marksentry_controller/getallsubjectlist";
/* service url */$route['staff/getexamlist'] = "staff/marksentry_controller/getexamlist";
/* service url */$route['staff/getexampart'] = "staff/marksentry_controller/getexampart";
/* service url */$route['staff/saveexampart'] = "staff/marksentry_controller/saveexampart";
/* service url */$route['staff/removepart'] = "staff/marksentry_controller/removeexampart";
/* service url */$route['staff/savemarks'] = "staff/marksentry_controller/savemarksdetail";
/* service url */$route['staff/myactualmarks'] = "staff/marksentry_controller/getactualmarks";
/* service url */$route['staff/saveactualmarks'] = "staff/marksentry_controller/saveactualmarks";




/* * *************** ASSIGN COMBO TO STUDENTS ********************** */
$route['staff/assigncombo'] = "staff/combomanagement_controller/AssignSubjectCombo";
/* SeviceURL */$route['staff/combodetails'] = "staff/combomanagement_controller/loadSectiondetails";
/* SeviceURL */$route['staff/sectiondetails'] = "staff/combomanagement_controller/loadCombodetails";
/* SeviceURL */$route['staff/assigncombotostudent'] = "staff/combomanagement_controller/AssignCombo";
/* SeviceURL */$route['staff/deleteCombo'] = "staff/combomanagement_controller/DeleteCombo";
/* * ************************ END ***************************** */
/* * ************Student Profile Start****************** */
$route['staff/studentprofile'] = "staff/student_controller/loadStudentProfilePage";
$route['staff/studentprofile/(:num)'] = "staff/student_controller/loadStudentProfilePage/$1";
$route['staff/getstudphoto/(:any)/(:any)'] = "staff/student_controller/getstudentphoto/$1/$2";
/* SeviceURL */$route['staff/studentprofile/studentDetails'] = "staff/student_controller/getStudentDetails";
/* SeviceURL */$route['staff/studentprofile/issuecards'] = "staff/student_controller/issueCards";
/* * ************Staff Profile Start****************** */
$route['staff/staffprofile/(:any)'] = "staff/staff_controller/loadStaffView/$1";
/* SeviceURL */$route['staff/profiledetails'] = "staff/staff_controller/loadStaffprofile";

/* * ************Student Entry ****************** */
$route['staff/managestudent'] = "staff/student_controller/loadStudentView";
$route['staff/managestudent/(:num)'] = "staff/student_controller/loadStudentView/$1";
/* SeviceURL */$route['staff/getstudentprofile'] = "staff/student_controller/getStudentProfile";
/* SeviceURL */$route['staff/saveprofile'] = "staff/student_controller/saveUpdateStundentDetail";
/* service url */$route['staff/upload'] = "staff/student_controller/profilePictureUpload";
//*****************************Marks Entry Start *****************************
$route['staff/marksentry'] = "staff/marksentry_controller";
/* service url */$route['staff/getmysubjectname'] = "staff/marksentry_controller/getallsubjectlist";
/* service url */$route['staff/getexamlist'] = "staff/marksentry_controller/getexamlist";
/* service url */$route['staff/getexampart'] = "staff/marksentry_controller/getexampart";
/* service url */$route['staff/saveexampart'] = "staff/marksentry_controller/saveexampart";
/* service url */$route['staff/removepart'] = "staff/marksentry_controller/removeexampart";
/* service url */$route['staff/savemarks'] = "staff/marksentry_controller/savemarksdetail";
/* service url */$route['staff/myactualmarks'] = "staff/marksentry_controller/getactualmarks";

//*****************************Publish Marks**********************************
$route['staff/publishmarks'] = "staff/marksentry_controller/publishmarks";
$route['staff/publishmarks/(:any)/(:any)'] = "staff/marksentry_controller/MarksDetails/$1/$2";
/* service url */$route['staff/getmyclass'] = "staff/marksentry_controller/getclasslist";
/* service url */$route['staff/publishmarksdetail'] = "staff/marksentry_controller/publishmarksdetails";
/* service url */$route['staff/savepublishmarks'] = "staff/marksentry_controller/savepublishmarks";
/* service url */$route['staff/lockmarksdetail'] = "staff/marksentry_controller/lockmarksdetails";
/* service url */$route['staff/savelockmarks'] = "staff/marksentry_controller/savelockmarks";

//*****************************Blue Sheet**********************************
$route['staff/bluesheet'] = "staff/marksentry_controller/bluesheet";
/* service url */$route['staff/getstudentmarks'] = "staff/marksentry_controller/getstudentmarks";
/* service url */$route['staff/getblueexamlist'] = "staff/marksentry_controller/getblueexamlist";
/* service url */$route['staff/loadexammarks'] = "staff/marksentry_controller/loadexammarks";

/* * *************************Manage House******************************* */
$route['staff/managehouse'] = "staff/house_controller/housedetails";

/* * ************ REMARK ENTRY MODULE****************** */
$route['staff/remarkentrysub'] = "staff/remark_controller/remark_entry_subject";
$route['staff/remarkentrygen'] = "staff/remark_controller/remark_entry_gen";
/* SeviceURL */$route['staff/getstudentlistofsubject'] = "staff/remark_controller/loadremarkstudents";
/* SeviceURL */$route['staff/getstudentlistofsection'] = "staff/remark_controller/loadSectionstudents";
/* SeviceURL */$route['staff/getstaffsubjectlist'] = "staff/remark_controller/getstaffsubjects";
/* SeviceURL */$route['staff/savesubjectremarkdata'] = "staff/remark_controller/savesubjectremark";
/* SeviceURL */$route['staff/loadSectionList'] = "staff/remark_controller/loadSectionList";
/* SeviceURL */$route['staff/deleteRemark'] = "staff/remark_controller/deleteRemark";

//********************Staff Dashboard Start**********************//
$route['staff/staffdashboard'] = "staff/staff_controller/loadStaffDashboard";
$route['staff/viewtodo'] = "staff/staff_controller/loadtodoview";
$route['staff/mypic'] = "staff/staff_controller/do_upload";
/* SeviceURL */$route['staff/dashboarddatails'] = "staff/staff_controller/loadStaffDetails";
/* SeviceURL */$route['staff/cards'] = "staff/staff_controller/loadCardDetails";
/* SeviceURL */$route['staff/saveTodo'] = "staff/staff_controller/savenewtododata";
/* SeviceURL */$route['staff/deleteTodo'] = "staff/staff_controller/deleteTodoData";
/* SeviceURL */$route['staff/deleteCards'] = "staff/staff_controller/deleteCardData";
/* SeviceURL */$route['staff/issuecardDetails'] = "staff/staff_controller/loadCards";
/* ServiceURL */$route['staff/allstudentnamelist'] = "staff/staff_controller/loadstudentlist";
/* ServiceURL */$route['staff/getalltodolist'] = "staff/staff_controller/getAllTodoList";
/* ServiceURL */$route['staff/viewalltodolist'] = "staff/staff_controller/viewAllTodoList";
/* ServiceURL */$route['staff/todocomplete'] = "staff/staff_controller/todocomplete";


/* * ************Admin Dashboard Start****************** */
$route['staff/admindashboard'] = "staff/admin_controller/loadAdminDashboard";
/* SeviceURL */$route['staff/admindashboarddetails'] = "staff/admin_controller/loadAdminDetails";
/* SeviceURL */$route['staff/updateholiday'] = "staff/admin_controller/updateHolidy";
/* SeviceURL */$route['staff/loadTodayholiday'] = "staff/admin_controller/loadTodayholiday";
/* ServiceURL */$route['staff/examschedule'] = "staff/admin_controller/getexamdateschedule";





/* * *************** holiday ********************** */
$route['staff/manageholiday'] = "staff/holiday_controller/holidayDetail";
$route['staff/holidayterm'] = "staff/holiday_controller/holidayTerm";
/* SeviceURL */$route['staff/termsession'] = "staff/holiday_controller/saveTermSession";
/* SeviceURL */$route['staff/declareholiday'] = "staff/holiday_controller/declargeholiday";
/* SeviceURL */$route['staff/getholidaytermdetail'] = "staff/holiday_controller/getHolidaytermDetail";
/* * *************** staff login/kit generate ********************** */
$route['staff/genstafflogin'] = "login/staffkitgeneration_controller";
/* ServiceUrl */$route['staff/getstaffdetails'] = "login/staffkitgeneration_controller/getallstaff";
/* ServiceUrl */$route['staff/updateactivestatus'] = "login/staffkitgeneration_controller/updateloginstatus";
/* ServiceUrl */$route['staff/resetpwd'] = "login/staffkitgeneration_controller/resetpassword";
/* ServiceUrl */$route['staff/sendsms'] = "login/staffkitgeneration_controller/sendsmsdetails";
/* * *************** student login/kit generate ********************** */
$route['staff/genstudlogin'] = "login/studentkitgeneration_controller";
/* ServiceUrl */$route['staff/getsections'] = "login/studentkitgeneration_controller/getallsections";
/* ServiceUrl */$route['staff/getstudents'] = "login/studentkitgeneration_controller/getallstudents";
/* ServiceUrl */$route['staff/resetpwd'] = "login/studentkitgeneration_controller/resetpassword";
/* ServiceUrl */$route['staff/updateactivestatus'] = "login/studentkitgeneration_controller/updateloginstatus";
/* ServiceUrl */$route['staff/sendsms'] = "login/studentkitgeneration_controller/sendsmsdetails";

/* * *************************Student Section Assign Module ************************************ */
$route['staff/studsectionassign'] = "staff/student_controller/studentsectionassign";
$route['staff/studsectionassign/(:any)'] = "staff/student_controller/studentsectionassign/$1";
/* * *******					END Student Section Assign Module 				********************** */

/* * ***************Module : ADMIN1 -  Staff Parent Message ********************** */
$route['staff/staffparentmessage'] = "staff/staffparentmessage_controller";
/* ServiceUrl */$route['staff/getsubjects'] = "staff/staffparentmessage_controller/getteachersubjects";
/* ServiceUrl */$route['staff/getseclist'] = "staff/staffparentmessage_controller/getallsections";
/* ServiceUrl */$route['staff/getsecbiolist'] = "staff/staffparentmessage_controller/getallsectionstudent";
/* ServiceUrl */$route['staff/getstudfrmsub'] = "staff/staffparentmessage_controller/getstudentfromsubject";
/* ServiceUrl */$route['staff/sendsmschat'] = "staff/staffparentmessage_controller/savesendmessage";
/* ServiceUrl */$route['staff/getsmsdetail'] = "staff/staffparentmessage_controller/getsmsdetails";
/* ServiceUrl */$route['staff/updatestatus'] = "staff/staffparentmessage_controller/updatereadstatus";

/* * *********************************deo modules****************************** */
$route['staff/deo'] = "login/deo_controller";
/* ServiceUrl */$route['staff/getallstaffdata'] = "login/deo_controller/getallstaff";
/* serviceUrl */$route['staff/loginasteacher'] = "login/deo_controller/superlogin";


/* * *******************************************Basic Report Module************************************************ */
$route['staff/housereport'] = "staff/basicreport_controller/housereport";
$route['staff/housereport/(:any)'] = "staff/basicreport_controller/housereport/$1";
$route['staff/latestudentreport'] = "staff/basicreport_controller/latestudentreport";
$route['staff/latestudentreport/(:any)'] = "staff/basicreport_controller/latestudentreport/$1";
$route['staff/absentstudentreport'] = "staff/basicreport_controller/absentstudentreport";
$route['staff/absentstudentreport/(:any)'] = "staff/basicreport_controller/absentstudentreport/$1";
$route['staff/classlistreport'] = "staff/basicreport_controller/classlistreport";
$route['staff/classlistreport/(:any)'] = "staff/basicreport_controller/classlistreport/$1";
$route['staff/cardlistreport'] = "staff/basicreport_controller/cardlistreport";
$route['staff/cardlistreport/(:any)/(:any)/(:any)'] = "staff/basicreport_controller/cardlistreport/$1/$2/$3";
/* * **************************Menu List Module*************************************************************** */

$route['staff/menulist'] = "staff/menulist_controller/menulist";
$route['staff/menulist/(:any)'] = "staff/menulist_controller/menulist/$1";

//***************************************** Master Login Module *********************************************//

$route['staff/masterlogin'] = "login/masterlogin_controller/masterlogin";
$route['staff/masterlogin/(:any)'] = "login/masterlogin_controller/masterlogin/$1";
/* ServiceUrl */$route['staff/getschoollist'] = "login/masterlogin_controller/getschoollist";
/* ServiceUrl */$route['staff/getfullschooldetail'] = "login/masterlogin_controller/getfullschooldetail";
/* ServiceUrl */$route['staff/getallnamelist'] = "login/masterlogin_controller/serachStudent";
/* ServiceUrl */$route['staff/masterloginas'] = "login/deo_controller/superlogin";


/* * *************************************Club Management Module************************************************ */

$route['staff/clubmanagement'] = "staff/clubmanagement_controller/addnewclub";

/* * ****************************Service Url[Add Member Module]***************************************************** */
$route['staff/addmember'] = "staff/clubmanagement_controller/addmember";
$route['staff/addmember/(:any)'] = "staff/clubmanagement_controller/addmember/$1";
$route['staff/addmember/(:any)/(:any)'] = "staff/clubmanagement_controller/addmember/$1/$2";
/* service url */$route['staff/getmemberdetail'] = "staff/clubmanagement_controller/getmemberdetails";

/* service url */$route['staff/saveattdetail'] = "staff/clubmanagement_controller/saveattdetails";


/* * ****************************Sql Report Module ****************************************** */
$route['staff/sqlreport'] = "staff/sqlreport_controller/index";
/* serviceURL */$route['staff/reportdata'] = "staff/sqlreport_controller/getsearchfield";
/* serviceUrl */$route['staff/searchdata'] = "staff/sqlreport_controller/searchreport";
$route['staff/sqlresult'] = "staff/sqlreport_controller/sqlreportresult";

/* * ********************Late attendance entry module******************************** */
$route['staff/lateattendance'] = "staff/attendence_controller/lateattendance";
/* Service url */$route['staff/studentlist'] = "staff/attendence_controller/searchstudent";
/* Service url */$route['staff/saveallattendancedata'] = "staff/attendence_controller/savelatedata";

/* * ******************************School Setting Module*********************************** */
$route['staff/schoolsetting'] = "staff/schoolsetting_controller";
/* ServiceUrl */$route['staff/schoolDeatil'] = "staff/schoolsetting_controller/getschooldetail";
/* ServiceUrl */$route['staff/uploadsklimg'] = "staff/schoolsetting_controller/SchoolPictureUpload";
/* service url */ $route['staff/saveschoolDeatil'] = "staff/schoolsetting_controller/saveschooldeatil";

/* * *****************************************Exam date Sheet Module*********************************** */
$route['staff/examdatesheet'] = "staff/examdatesheet_controller";
/* service url */$route['staff/classlist'] = "staff/examdatesheet_controller/Sectionlist";
/* service url */$route['staff/sectiondata'] = "staff/examdatesheet_controller/sectiondata";
/* service url */$route['staff/savealldata'] = "staff/examdatesheet_controller/savealldata";
/* service url */$route['staff/addexamintable'] = "staff/examdatesheet_controller/addexamintable";
/* * ****************************************************** Homework************************************** */
$route['staff/homework'] = "staff/homework_controller/loadhomework";
$route['staff/homework/(:any)'] = "staff/homework_controller/loadhomework/$1";
$route['staff/assigment'] = "staff/homework_controller/loadassigment";
/* service url */$route['staff/loadsubject'] = "staff/homework_controller/MyStaffData";
/* service url */$route['staff/loadhwdata'] = "staff/homework_controller/loaddata";
/* service url */$route['staff/newhwpost'] = "staff/homework_controller/hwpostdata";
/* service url */$route['staff/fulldetailhw'] = "staff/homework_controller/homeworkdetail";
/* service url */$route['staff/loadstudet'] = "staff/homework_controller/Loadstudetails";
/* service url */$route['upload/(:any)'] = "staff/homework_controller/MyFileUpload/$1";
/* * **********************************************Assigment******************************************* */
$route['staff/assigment'] = "staff/homework_controller/loadassigment";
/* service */$route['staff/loadallsection'] = "staff/homework_controller/loadsectionclass";
/* service url */$route['staff/fullassignmentdetail'] = "staff/homework_controller/fullassignmentdetail";
/* service url */$route['staff/loadsectionstudent'] = "staff/homework_controller/LoadClassStudent";
/* service url */$route['staff/myloadassignment'] = "staff/homework_controller/loaddata";
/* * ********************** Report Card Generation************* */
$route['staff/reportcard'] = "staff/reportcard_controller";
$route['staff/studentreportcard'] = "staff/reportcard_controller/secondrystudentreport";
$route['staff/studentreportcard/(:any)/(:any)/(:any)'] = "staff/reportcard_controller/getSecndryReportCard/$1/$2/$3";
$route['staff/primarycard/(:any)/(:any)/(:any)'] = "staff/reportcard_controller/getreportcardprimary/$1/$2/$3";
$route['staff/secondrycard/(:any)/(:any)/(:any)'] = "staff/reportcard_controller/getreportcardsecondry/$1/$2/$3";
/* service url */$route['staff/geratepdf'] = "staff/reportcard_controller/getreportcardbothsidedata";
/* service url */$route['staff/getstandardsection'] = "staff/reportcard_controller/getstandard";
/* service url */$route['staff/geratestudentreportcard'] = "staff/reportcard_controller/getReportCardPrimary";
/* service url */$route['staff/downloadzip'] = "staff/reportcard_controller/downloadreportcard";
/* service url */$route['staff/downloadzip/(:any)'] = "staff/reportcard_controller/downloadreportcard/$1";

/* * ***************************************************************Staff Attendence*************************** */

$route['staff/staffatt'] = "staff/staff_controller/loadStaffAttView";
/* service url */$route['staff/getstaffattlist'] = "staff/staff_controller/GetAttendence";
/* service url */$route['staff/markallstaff'] = "staff/staff_controller/MarkAllAttendenceDetail";
/* service url */$route['staff/saveattdata'] = "staff/staff_controller/SaveStaffAttData";
/* service url */$route['staff/saveattpresentdata'] = "staff/staff_controller/SaveStaffAttPresntData";


//**************************************Student Id Card ****************************//
$route['staff/idcard'] = "staff/student_controller/loadIdcardview";
$route['staff/idcard/(:any)'] = "staff/student_controller/loadIdcardview/$1";
$route['staff/idcard/(:any)/(:any)'] = "staff/reportcard_controller/getpdfofidcard/$1/$2";
/* * *****************************************studentsummary(sapna)********************************************* */

$route['staff/studentsummary'] = "staff/student_controller/getStudSummaryView";
$route['staff/studentsummary/(:any)'] = "staff/student_controller/getStudSummaryView/$1";
/* service url */$route['staff/getstudentdetail'] = "staff/student_controller/GetStudentsummaryDetail";


/* service url */ $route['checkislogin'] = "login/login_controller/checkstatus";



