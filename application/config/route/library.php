<?php

/* * ******************************Library Mangement System(LMS)Modules************************************* */

/* * ******************************************Add Books**************************************** */
$route['staff/addbooks'] = "staff/library_controller/addbooks";

/* serviceURL */$route['staff/savebook'] = "staff/library_controller/savebookdetails";
/* serviceURL */$route['staff/viewbooks'] = "staff/library_controller/recentlyaddedbooks";
/* serviceURL */$route['staff/searchbooks'] = "staff/library_controller/searchbookdetails";
/* serviceURL */$route['staff/bookquantitydetail'] = "staff/library_controller/getsearchresults";
/* serviceURL */$route['staff/update'] = "staff/library_controller/updatebookquantities";

/* * ********************************Isssue Book************************************************* */
$route['staff/issuebooks'] = "staff/library_controller/issuebooks";

/* serviceURL */$route['staff/bookdata'] = "staff/library_controller/loadbookdetails";
/* serviceURL */$route['staff/studentdata'] = "staff/library_controller/loadstudentdetails";
/* serviceURL */$route['staff/issuedata'] = "staff/library_controller/issuebookdetails";
/* serviceURL */$route['staff/recentissuebook'] = "staff/library_controller/recentissuebooks";
/* serviceURL */$route['staff/searchstudents'] = "staff/library_controller/searchstudentdetails";

/* * ************************************Return Books******************************************** */

$route['staff/returnbooks'] = "staff/library_controller/returnbooks";
$route['staff/returnbooks/(:any)'] = "staff/library_controller/returnbooks/$1";

/* serviceURL */$route['staff/studentinfo'] = "staff/library_controller/loadstudentinfos";
/* serviceURL */$route['staff/savechangebook'] = "staff/library_controller/savechangesbooks";
/* serviceURL */$route['staff/recentlyreturn'] = "staff/library_controller/recentlyissuedbooks";

/* * ***************************************Fine Setting****************************************** */
  $route['staff/finesetting'] = "staff/library_controller/bookfine";
  
/* serviceURL */$route['staff/fineinfo'] = "staff/library_controller/getfinedetails";
/* serviceURL */$route['staff/finedata'] = "staff/library_controller/savefinedetails";


/**********************LMS-Module-book issue report module*********************************/
$route['staff/issuebookreport'] = "staff/library_controller/total_issued_book";
$route['staff/issuebookreport/(:any)'] = "staff/library_controller/total_issued_book/$1";

/**********************LMS-Module-defaulter report module**************************/
$route['staff/defaulterreport/(:any)'] = "staff/library_controller/defaulter_status/$1";
$route['staff/defaulterreport'] = "staff/library_controller/defaulter_status";

/**********************LMS-Module-lost book  report module***********************************/
$route['staff/lostbookreport'] = "staff/library_controller/lost_book_report";
$route['staff/lostbookreport/(:any)'] = "staff/library_controller/lost_book_report/$1";


/**********************LMS-Module-book centric  report module**********************************/
$route['staff/bookcentricreport'] = "staff/library_controller/book_centric_report";
/* serviceURL */$route['staff/getbookissuedetail'] = "staff/library_controller/getbookissuedetail";

/**********************LMS-Module-student centric  report module**********************************/
$route['staff/studentcentricreport'] = "staff/library_controller/student_centric_report";
/* serviceURL */$route['staff/getstudentdetail'] = "staff/library_controller/getstudentdetail";


/**********************LMS-Module-total fine collection report module*****************************/

$route['staff/finecollection'] = "staff/library_controller/total_fine_collection";
/* serviceURL */$route['staff/getfinedetail'] = "staff/library_controller/getfinedetail";
  


