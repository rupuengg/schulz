function in_array(needle, haystack, argStrict) {
    var key = '',
            strict = !!argStrict;
    if (strict) {
        for (key in haystack) {
            if (haystack[key] === needle) {
                return true;
            }
        }
    } else {
        for (key in haystack) {
            if (haystack[key] == needle) {
                return true;
            }
        }
    }
    return false;
}

var app = angular.module('reportCard', ['blockUI']);
app.config(function (blockUIConfig) {
    blockUIConfig.autoInjectBodyBlock = false;
});
app.controller('reportCardController', ['$scope', '$http', 'blockUI','$location', '$anchorScroll', function ($scope, $http, blockUI, $location, $anchorScroll) {       
        blockUI.start();
        $scope.sectionId = 0;
        $scope.type = null;
        $scope.myCount = 0;
        $scope.myPostData = null;
        $scope.myStudentList = null;
        $scope.myStaffList = null;
        $scope.myMessage = "";
        $scope.noticeTitle = "";

        $scope.showDownoad = function () {
            if ($scope.standard <= 10)
            {
                return true;
            } else
            {
                return false;
            }
        };
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
        $scope.getCheckedMemberCount = function () {
            var myDetail = null;
            $scope.myArry = [];
            myDetail = $scope.myStudentList;

            var hint = 0;
            $.each(myDetail, function (key, value) {
                if (value.noticeSend) {
                    $scope.myArry.push(value);
                    hint++;
                }
            });
//            console.log($scopemyArr);

            $scope.myCount = hint;
            $scope.myPostData = myDetail;
            return hint;
        }

        $scope.checkAll = function () {
            $scope.selectedAll = true;
            $scope.showdiv = true;  
            angular.forEach($scope.myStudentList, function (myAllStudentList) {
                myAllStudentList.noticeSend = $scope.selectedAll;
            });
        };

        $scope.genrate = function () {
            var showbuttn = true;
        }

        $scope.getStudentList = function () {
            
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getstudentlist/' + $scope.sectionId,
                data: '',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.myStudentList = jsondata.student_list;
                $scope.studenttotal = $scope.myStudentList.length;
            });

            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getstandardsection',
                data: 'data=' + $scope.sectionId,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.standard = jsondata.standard;
                $scope.section = jsondata.section;
            });
        }

        $scope.genrateReportCard = function (studentarray, mycount, status) {
           
            if($scope.standard> 10){
                $scope.division = 'SENIOR';
            }else{
                $scope.division = 'JUNIOR';
            }
            if (studentarray[mycount] != null) {
                var studentListObj = studentarray[mycount];
                var data = {
                    adm_no: studentListObj.adm_no,
                    section_id: $scope.sectionId,
                    school_code: schoolCode,
                    division: $scope.division
                }
//                console.log($scope.myStudentList[mycount]); return false;
                $scope.myStudentList[mycount].imageloader=true;
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/geratepdf',
                    data: "data=" + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.myStudentList[mycount].imageloader=false;
                    if (jsondata.type == 'SUCCESS' || jsondata.type == 'ALLREADY') {
//                        console.log($scope.myStudentList); return false;
                        $scope.myStudentList[mycount].imagedone=true;
                        $scope.myStudentList[mycount].imagecross=false;
                        if (mycount < studentarray.length) {
                            mycount++;
                            if (mycount > 10) {
                                var scroll_position = (mycount - 8);
                                $anchorScroll();
                            }
                            $scope.genrateReportCard(studentarray, mycount, status);
                            
                            
                        } else {
                            $scope.myStudentList[mycount].imagedone=false;
                        $scope.myStudentList[mycount].imagecross=true;
                            console.log('All report card genrated.');
                        }
                    } else {
                        $scope.myStudentList[mycount].imagedone=false;
                        $scope.myStudentList[mycount].imagecross=true;
                        console.log('report card not genrated');
                    }
                    
                    
                });
            } else {
                $scope.showdiv = false;
                var studentdata = {
                    array_data: studentarray,
                    section_id: $scope.sectionId,
                    type: status,
                };
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/downloadzip',
                    data: "data=" + encodeURIComponent(angular.toJson(studentdata)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
//                console.log(JSON.stringify(jsondata.value));
                    if (jsondata.type == 'DOWNLOAD') {
                        window.location.href = myURL + 'assets/temp/' + jsondata.value + '/downloadall.zip';
                    } else {
                        alert(jsondata.message);
                    }

                });
            }
        }

        $scope.dwnld = function (studentObj) {
            var stu_data = {
                adm_no: studentObj.adm_no,
                section_id: studentObj.section_id,
                school_code: schoolCode
            };
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/downloadzip/' + stu_data['adm_no'],
                data: "data=" + encodeURIComponent(angular.toJson(stu_data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata.type == 'DOWNLOAD') {
                    window.location.href = myURL + 'assets/temp/' + jsondata.value + '/downloadall.zip';
                } else {
                    alert(jsondata.message);
                }

            });
        }

        $scope.gerateStudentReportCard = function (studentObj) {
            if($scope.standard> 10){
                $scope.division = 'SENIOR';
            }else{
                $scope.division = 'JUNIOR';
            }
            var data = {
                adm_no: studentObj.adm_no,
                section_id: studentObj.section_id,
                school_code: schoolCode,
                division:$scope.division
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/geratepdf',
                data: "data=" + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata.type == 'SUCCESS' || jsondata.type == 'ALLREADY') {
                    console.log('report card genrated');
                } else {
                    console.log('report card not genrated');
                }

            });
        }




    }]);