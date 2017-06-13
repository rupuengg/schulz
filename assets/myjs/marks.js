var app = angular.module('marks', ['blockUI']);
app.controller('marksController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.examPart = '';
        $scope.myExamParts = null;
        $scope.master_id = '';
        $scope.myMasterMarks = '';
        $scope.myErrorMessage = '';
        $scope.examPart.part_name = '';
        $scope.type = '';
        $scope.classID = 0;
        $scope.noticeMessage = '';
        $scope.mySubjectList = allSubjctList.subjectlist;
        $scope.mrkEntryValidation = /^[0-9]{1,7}$|^[AB]{2}$|^[ab]{2}$|^[ex]{2}$|^[EX]{2}$|^[ml]{2}$|^[ML]{2}$|^[0-9]{1,7}(\.[0-9]+)?$/;
        $scope.getExamName = function () {

            $scope.noticeMessage = '';
            var data = {
                detail: JSON.parse($scope.classID)
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getexamlist',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata == -1) {
                    $scope.noticeMessage = "No Exam Declare Yet..";
                } else {
                    $scope.myExamList = jsondata;

                }
                $scope.master_id = '';
            });
        }

        $scope.getExamPartData = function (mydata) {

            $scope.master_id = mydata;
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getexampart',
                data: 'data=' + encodeURIComponent(angular.toJson(mydata)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.myExamParts = jsondata.examPart;
                $scope.total = $scope.myExamParts.status;
            });
        }

        if (subId != -1 && sectionId != -1 && examId != -1) {
            angular.forEach($scope.mySubjectList, function (value, key) {
                if (value.section_id == sectionId && value.sub_id == subId) {
                    $scope.classID = value;

                }

            });
            $scope.myExamList = examlist;
            angular.forEach($scope.myExamList, function (value, key) {
                if (value.section_id == sectionId && value.subject_id == subId && value.id == examId) {
                    $scope.data = value;
                }

            });
            $scope.getExamPartData($scope.data);
        }

        $scope.getExamPart = function (mydata) {

            window.location = myURL + 'index.php/staff/marksentry/' + mydata.subject_id + '/' + mydata.section_id + '/' + mydata.id;
        }

        $scope.checkMax = function () {

            if ($scope.examPart.max_marks == undefined) {
                $scope.examPart.max_marks = 0;
            }
            $scope.examPart.max_marks = parseFloat($scope.examPart.max_marks) > parseFloat($scope.myExamParts.remaining_mrk) ? parseFloat($scope.myExamParts.remaining_mrk) : parseFloat($scope.examPart.max_marks);
        }

        $scope.saveExamPart = function () {
            if (confirm("Do you want to save exam details?")) {
                $scope.myMasterMarks = $scope.master_id.max_marks;
                if ($scope.total == 'TRUE') {
                    $scope.totalmarks = parseInt($scope.myExamParts.sum) + parseInt($scope.examPart.max_marks);
                    if ($scope.myMasterMarks >= $scope.totalmarks) {
                        var data = {
                            detail: $scope.examPart,
                            master_id: $scope.master_id.id
                        }
                        $http({
                            method: 'POST',
                            url: myURL + 'index.php/staff/saveexampart',
                            data: 'data=' + encodeURIComponent(angular.toJson(data)),
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).success(function (jsondata) {
                            alert(jsondata.message);
                            $scope.examPart.id = jsondata.value;
                            $scope.myExamParts.part_detail.push($scope.examPart);
                            $scope.myExamParts.sum = $scope.totalmarks;
                            $scope.myExamParts.remaining_mrk = parseInt($scope.myExamParts.remaining_mrk) - parseInt($scope.examPart.max_marks);
                            if ($scope.myExamParts.remaining_mrk == 0) {
                                $scope.total = 'FALSE';
                            }
                            $scope.examPart = null;
                            $scope.myExamList = examlist;
                            angular.forEach($scope.myExamList, function (value, key) {
                                if (value.section_id == sectionId && value.subject_id == subId && value.id == examId) {
                                    $scope.data = value;
                                }

                            });
                            $scope.getExamPartData($scope.data);


                        });
                    } else {
                        alert("Already Declare All Exam..");
                        $scope.examPart.max_marks = '';
                        return false;
                    }
                } else {
                    alert('No marks remainings for add exam...!!!');
                    return false;
                }
            } else {
                return false;
            }
        }
        $scope.removeExamPart = function (examPart, index) {
            if (confirm("Do you want to remove exam?")) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/removepart',
                    data: 'data=' + encodeURIComponent(angular.toJson(examPart)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    $scope.myExamParts.part_detail.splice(index, 1);
                    $scope.myExamParts.remaining_mrk = parseInt($scope.myExamParts.remaining_mrk) + parseInt(examPart.max_marks);
                    $scope.myExamList = examlist;
                    angular.forEach($scope.myExamList, function (value, key) {
                        if (value.section_id == sectionId && value.subject_id == subId && value.id == examId) {
                            $scope.data = value;
                        }

                    });
                    $scope.getExamPartData($scope.data);
                });
            } else {
                return false;
            }
        }

        $scope.checkValidteMaxmarks = function (index1, index2) {

            if ($scope.myExamParts.studentDetail[index1].marks[index2].mrk > 0) {

                $scope.myExamParts.studentDetail[index1].marks[index2].mrk = parseFloat($scope.myExamParts.studentDetail[index1].marks[index2].mrk) > parseFloat($scope.myExamParts.studentDetail[index1].marks[index2].max_mrk) ? parseFloat($scope.myExamParts.studentDetail[index1].marks[index2].max_mrk) : parseFloat($scope.myExamParts.studentDetail[index1].marks[index2].mrk);
            }
        }


        $scope.validateMarks = function (marks) {

            var isValidMarkes = ((/^[a-zA-Z0-9]{1,7}$/.test(marks.mrk) | /^[0-9]{1,7}(\.[0-9]+)?$/.test(marks.mrk))) ? true : false;
            if ((isValidMarkes == false && marks.mrk != '')) {
                marks.xx = 'true';
                $scope.myErrorMessage = "Input Valid marks";
                return false;
            }

            if (marks.mrk == '' || marks.mrk == 'ab' || marks.mrk == 'ex' || marks.mrk == 'ml' || marks.mrk == 'AB' || marks.mrk == 'EX' || marks.mrk == 'ML' || ((parseFloat(marks.mrk) > 0) && (parseFloat(marks.mrk) <= parseFloat(marks.max_mrk)))) {
                marks.xx = '';
                $scope.myErrorMessage = "";

            } else {
                marks.xx = 'true';
                $scope.myErrorMessage = "Input Valid marks";

            }


        }
        $scope.saveMarksDetail = function () {
            if (confirm("Do you want to save marks details?")) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/savemarks',
                    data: 'data=' + encodeURIComponent(angular.toJson($scope.myExamParts)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location = self.location;
                });
            } else {
                return false;
            }
        }

        $scope.getMyActualMark = function (myActualMrks) {
            var data = {
                sec_id: $scope.master_id.section_id,
                pid: myActualMrks.id,
                pmax_mrk: myActualMrks.max_marks
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/myactualmarks',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.myActualMarks = jsondata;
                $('a#cmdOpenCanvas').trigger("click");
            });
        }

        $scope.chkValidteActualMrks = function (index) {

            if ($scope.myActualMarks.studentList[index].marks.mrk > 0) {

                $scope.myActualMarks.studentList[index].marks.mrk = parseFloat($scope.myActualMarks.studentList[index].marks.mrk) > parseFloat($scope.outOfMarks) ? parseFloat($scope.outOfMarks) : parseFloat($scope.myActualMarks.studentList[index].marks.mrk);
            }
        }

        $scope.validateActualMarks = function (marksNew) {
            var isvalidateActualMarks = ((/^[a-zA-Z0-9]{1,7}$/.test(marksNew.mrk) | /^[0-9]{1,7}(\.[0-9]+)?$/.test(marksNew.mrk))) ? true : false;
            if ((isvalidateActualMarks == false && marksNew.mrk != '')) {
                marksNew.outOf = 'true';
                $scope.myErrorMessage = "Input Valid marks";
                return false;
            }
            if (marksNew.mrk == '' || marksNew.mrk == 'ab' || marksNew.mrk == 'ex' || marksNew.mrk == 'ml' || marksNew.mrk == 'AB' || marksNew.mrk == 'EX' || marksNew.mrk == 'ML' || ((parseFloat(marksNew.mrk) > 0) && (parseFloat(marksNew.mrk) <= parseFloat($scope.outOfMarks)))) {
                marksNew.outOf = '';
                $scope.myErrorMessage = "";
            } else {
                marksNew.outOf = 'true';
                $scope.myErrorMessage = "Input Valid marks";
            }
        }

        $scope.saveActualMrks = function (meraMarks) {

            if (confirm("Do you want to save actual marks details?")) {
                var data = {
                    max_mrk: meraMarks.max_mrk,
                    pid: meraMarks.pid,
                    out_mrk: $scope.outOfMarks,
                    detail: meraMarks
                }

                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/saveactualmarks',
                    data: 'data=' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    location.reload();
                });
            } else {
                return false;
            }
        }
    }]);