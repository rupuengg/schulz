var app = angular.module('ParentStaffApp', []);
app.controller('ParentStaffAppController', function ($scope, $http) {

    $scope.base_url = myURL;
    $scope.staff_id = staff_id;

    $scope.getSubjects = function () {
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getsubjects',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.mySubjectList = jsondata.subjectList;
            $scope.myModeSubject = true;
            $scope.myModeSection = false;
            $scope.myStudTeacherList = null;
            $scope.mySSList = null;
            $scope.section_id = null;
            $scope.myStudTeacherList = null;
            $scope.mySmsStudent = null;
        });
    }
    $scope.getSections = function () {
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getseclist',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.mySectionList = jsondata.sectionList;
            $scope.myModeSection = true;
            $scope.myModeSubject = false;
            $scope.myStudTeacherList = null;
            $scope.mySSList = null;
            $scope.mainStudSubList = null;
            $scope.mySmsStudent = null;
        });
    }
    $scope.getSectionStudent = function () {
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getsecbiolist',
            data: 'section_id=' + encodeURIComponent(angular.toJson($scope.section_id)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.mySSList = jsondata.myStudentList;
            $scope.myStudTeacherList = null;
            $scope.mainStudSubList = null;
            $scope.myTempSubject = true;
            $scope.myTempSection = false;
            $scope.myTempStudTeacher = false;
        });
    }
    $scope.getSubjectStudent = function () {
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getstudfrmsub',
            data: 'subject_id=' + encodeURIComponent(angular.toJson($scope.subject_id)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.mySSList = jsondata.myStudSubList;
            $scope.subject_id = null;
            $scope.myStudTeacherList = null;
            $scope.myTempSection = true;
            $scope.myTempSubject = false;
            $scope.myTempStudTeacher = false;
        });
    }

    $scope.getStudFrmSec = function () {
        $scope.mySmsStudent = null;
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getsecbiolist',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.mySSList = jsondata.StudListTeacher;
            $scope.mainStudSubList = null;
            $scope.myTempStudTeacher = true;
            $scope.myTempSection = false;
            $scope.myTempSubject = false;
            $scope.myModeSubject = false;
            $scope.myModeSection = false;
            $scope.mySmsStudent = null;
            $scope.section_id = null;
        });
    }
    $scope.SendChatMsg = function (adm_no) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/sendsmschat',
            data: 'data=' + encodeURIComponent(angular.toJson($scope.myChatMessage)) + '&adm_no=' + encodeURIComponent(angular.toJson(adm_no)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.mainSmsDetails = jsondata.mySmsTempDetails;
            $scope.myChatMessage = null;
        });
    }

    $scope.SmsDetail = function (AdmObj) {
        $scope.mySmsStudent = AdmObj;
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getsmsdetail',
            data: 'adm_no=' + encodeURIComponent(angular.toJson($scope.mySmsStudent.adm_no)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.mainSmsDetails = jsondata.mySmsDetails;
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/updatestatus',
                data: 'adm_no=' + encodeURIComponent(angular.toJson($scope.mySmsStudent.adm_no)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {

            });
        });
    }

    $scope.cancelSms = function () {
        $scope.myChatMessage = null;
    }

});
