var app = angular.module('notice', []);
app.controller('noticeController', function ($scope, $http) {
//    $scope.type = '';
    $scope.myCount = 0;
    $scope.myPostData = null;
    $scope.myStudentList = null;
    $scope.myStaffList = null;
    $scope.myMessage = "";
    $scope.noticeTitle = "";
    $scope.sectionId = 0;

    $http({
        method: 'POST',
        url: myURL + 'index.php/staff/getallstaff',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.myStaffList = jsondata.stafflist;
        $scope.myDepList = jsondata.department;
        $scope.myDesigList = jsondata.designation;
    });
    $http({
        method: 'POST',
        url: myURL + 'index.php/staff/getallsectionlist',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.mySectionList = jsondata.section;

    });
    $http({
        method: 'POST',
        url: myURL + 'index.php/staff/getstudentlist',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.myAllStuList = jsondata.student_list;


    });
    $scope.getStudentList = function () {
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getstudentlist/' + $scope.sectionId,
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.myStudentList = jsondata.student_list;
        });
    }
    $scope.noticeSend = function () {
        if (confirm('Are you sure you want to send this?')) {
            if ($scope.myCount == 0) {
                alert("Please select atleast 1 " + $scope.type + " to send SMS.");
            } else if ($scope.noticeTitle == null) {
                alert("Please type your title.");
            } else {
                var data = {
                    detail: $scope.myPostData,
                    noticeContent: $scope.myMessage,
                    type: $scope.type,
                    noticeTitle: $scope.noticeTitle
                }
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/sendnotice',
                    data: 'data=' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location = self.location;
                });
            }
        }
    }
    $scope.getCheckedMemberCount = function () {
        var myDetail = null;
        if ($scope.type == null) {
            return 0;
        }
        if ($scope.type == "STAFF") {
            myDetail = $scope.myStaffList;
        } else if ($scope.type == "STUDENT") {
            myDetail = $scope.myStudentList;
        }
        var hint = 0;
        angular.forEach(myDetail, function (key, value) {
            if (value.noticeSend) {
                hint++;
            }
        });
        $scope.myCount = hint;
        $scope.myPostData = myDetail;
        return hint;
    }
    $scope.sendDirect = function (myType) {
        if (confirm('Are you sure you want to send this?')) {
            var data = {
                noticeContent: $scope.myMessage,
                type: $scope.myType,
                noticeTitle: $scope.noticeTitle
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/senddirectnotice',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                alert(jsondata.message);
                window.location = self.location;
            });

        }
    }

    $scope.noticeCancel = function () {
        if (confirm('Are you sure want to cancel ?')) {
            $scope.myMessage = "";
            $scope.noticeTitle = "";
        }
    }
});