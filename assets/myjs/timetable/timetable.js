var groupApp = angular.module('groupApp', ['blockUI']);
groupApp.controller('groupController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {

        $scope.selection = [];
        $scope.toggleSelection = function toggleSelection(group_name) {
            var idx = $scope.selection.indexOf(group_name);
            // is currently selected
            if (idx > -1) {
               $scope.selection.splice(idx, 1);
            }

            // is newly selected
            else {
                $scope.selection.push(group_name);
            }
        };
        $scope.savegroup = function () {
            var data = {
                group_name: $scope.group_name,
                group_classes: $scope.selection

            }
            if (confirm('Are you sure, you want to save?')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/savegroup',
                    data: 'data=' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location = self.location;
                });
            }
        }

        $scope.selectionteachers = [];
        $scope.toggleSelectionTeachers = function toggleSelectionTeachers(group_name) {
            var idx = $scope.selectionteachers.indexOf(group_name);
            // is currently selected
            if (idx > -1) {
                $scope.selectionteachers.splice(idx, 1);
            }

            // is newly selected
            else {
                $scope.selectionteachers.push(group_name);
            }
//            console.log($scope.selectionteachers);
        };
        $scope.saveassignteachers = function () {
            var data = {
                group_id: $scope.group_id,
                staff_id: $scope.selectionteachers
            }
            if (confirm('Are you sure, you want to assign this teacher to this group?')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/saveassignteachers',
                    data: 'data=' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    if (jsondata.status == "TRUE")
                    {
                        alert(jsondata.message);
                        window.location = self.location;
                    }

                });
            }
        }


        $scope.addgroupstaffs = function (groupId) {
            $scope.group_id = groupId;
            $scope.returndiv = 'true';
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/addgroupstaffs',
                data: 'data=' + encodeURIComponent(angular.toJson(groupId)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.assignedteachers = jsondata;
            });
        }

        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getgroupdetails',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.groupdata = jsondata;
        });
        $scope.deletegroup = function (index, objId) {

            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/deletegroup',
                data: 'data=' + encodeURIComponent(angular.toJson(objId)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                alert(jsondata.message);
                $scope.groupdata.splice(index, 1);
            });
        }

        $scope.classArray = ['Nur', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
    }]);
/**********************manage period module*************/
var PeriodApp = angular.module('PeriodApp', ['blockUI']);
PeriodApp.controller('periodController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.periodArray = [0];
        $scope.indexNo = 0;
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getgrouplist',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.grouList = jsondata;
        });
        $scope.selectClassGroup = function () {
            window.location.assign(myURL + "index.php/staff/manageperiod/" + $scope.groupId);
        }
        if (group_id != '') {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getperiodlist/' + group_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata) {
                    $scope.periodData = jsondata;
                    $scope.indexNo = $scope.periodData.length;
                }
            });
        }
        $scope.addAnotherRow = function () {
            this.review = {};
            $scope.periodArray.push(this.review);
        }
        $scope.removePeriod = function (index) {
            $scope.periodArray.splice(index, 1);
        }

        $scope.tempArray = [];
        $scope.savePeriod = function (periodObj) {
            if (periodObj.period_name == null || periodObj.end_time == null || periodObj.start_time == null || periodObj.period_type == null) {
                alert('Please fill the form correctly');
                return false;
            } else if (periodObj.end_time <= periodObj.start_time) {
                alert('Please provide end time more than start time');
                return false;
            }
            else {
                if (confirm('Are you want to Save')) {
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/staff/saveperioddetail/' + group_id,
                        data: 'data=' + encodeURIComponent(angular.toJson(periodObj)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        alert(jsondata.message);
                        window.location = self.location;
                    });
                }
            }
        }

        $scope.removePeriodData = function (index, ObjId) {
            if (confirm('Are you want to Delete')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/deleteperioddetail',
                    data: 'data=' + encodeURIComponent(angular.toJson(ObjId)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    console.log(jsondata);
                    alert(jsondata.message);
                    $scope.periodData.splice(index, 1);
                });
            }
        }

    }]);
/********class wise time table**************************/
var classtimetableApp = angular.module('classtimetableApp', ['blockUI']);
classtimetableApp.controller('classtimetableController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.weekArray = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Satarday'];
        $scope.showable = false;
        $scope.showsubject = false;
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getgrouplist',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.groupList = jsondata;
        });
        if (group_id != '') {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getsection/' + group_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.sectionList = jsondata;
            });
        }

        $scope.selectClassGroup = function () {
            window.location.assign(myURL + "index.php/staff/classwisetimetable/" + $scope.groupId);
        }
        $scope.selectSection = function () {
            if ($scope.sectionId != '') {
                window.location.href = myURL + 'index.php/staff/getclasstimetable/' + group_id + '/' + $scope.sectionId;
            }
        }

        if (section_id != '') {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getsubjectlist/' + section_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.subjectList = jsondata;
            });
        }

        $scope.showSubjectList = function (weekday, periodId) {
            $scope.showable = true;
            $scope.weekday = weekday;
            $scope.periodId = periodId;
        }
        $scope.showSubjet = function (weekday, periodId) {
            $scope.showsubject = true;
            $scope.weekday = weekday;
            $scope.periodId = periodId;
        }

        $scope.tempArray = [];
        $scope.assignSubjectTeacher = function (dataObj) {
            var data = {
                section_id: section_id,
                period_id: $scope.periodId,
                week_day_name: $scope.weekday,
                subject_id: dataObj['subject_id'],
                teacher_id: dataObj['teacher_id']
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/assignsubjectteacher',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                alert(jsondata.message);
                $scope.showable = false;
                $scope.showsubject = false;
                window.location = self.location;
            });
        }
    }]);
/*****************Substitute time table*********************/
var substituteTimetableApp = angular.module('substituteTimetableApp', ['blockUI', '720kb.datepicker']);
substituteTimetableApp.controller('substituteTimetableController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.perioddata = [];
        $scope.subjectsectionlist = [];
        $scope.substituteteachers = [];
        $scope.mydate = mydate;
        $scope.getdate = function () {
            window.location = myURL + 'index.php/staff/substitutetimetable/' + mydate;
        }

        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/loadabsentteachers',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.absentteachers = jsondata;
        });

        $scope.setteacher = function (teacherId, index) {
            var data = {
                staff_id: teacherId,
                arrange_date: $scope.mydate
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/loadteachersubjects',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.perioddata[index] = jsondata.periodDetail;
                $scope.subjectsectionlist[index] = jsondata.substitutedata;
                $scope.substituteteachers[index] = jsondata.staffList;
            });
        }

        $scope.savesubstitutedetails = function (dataObj,absetTeacherId) {
           
            var data = {
                teacher_id: dataObj.id,
                substitute_date: curr_date,
                absent_teacher_id: absetTeacherId,
                subject_id: dataObj.subject_id,
                section_id: dataObj.section_id,
                period_id: dataObj.period_id,
                week_day_name: dataObj.week_day_name
            }
            if (confirm('Are you sure, you want to save?')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/savesubstitutedetails',
                    data: 'data=' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                });
            }
        }
        $scope.periodArray = [{}];
        $scope.addAnotherRow = function () {
//            this.review = {};
            $scope.periodArray.push({});
        }


    }]);
/*****************************************Working Hours**************************************************/
var WorkingHoursApp = angular.module('WorkingHoursApp', ['blockUI']);
WorkingHoursApp.controller('WorkingHoursController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.worksetting = '';
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getworkinghour',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            if (jsondata == -1) {
                $scope.worksetting.working_days = '';
                $scope.worksetting.working_hours = '';
            } else {
                $scope.worksetting = jsondata;
            }

        });
        $scope.saveworkinghour = function () {
            if (confirm('Are you sure, you want to save working hours setting?')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/saveworkinghour',
                    data: 'data=' + encodeURIComponent(angular.toJson($scope.worksetting)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                });
            }
        }


    }]);