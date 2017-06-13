
var app = angular.module('RemarkEntry', []);

app.controller('maincontroller', ['$scope', '$http', function ($scope, $http) {
        $scope.showstddetail = false;
        var method = 'POST';
        var url = 'getstaffsubjectlist';
        $http({method: method, url: url, data: '', headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).
                success(function (data, status) {
                    $scope.data = data;
                }).
                error(function (data, status) {
                    alert("problem in ajax section");
                });
        //SAVE CLICK BUTTON
        $scope.myChangeEvent = function () {
            $scope.selectedstd = '';
            var method = 'POST';
            var url = 'getstudentlistofsubject';
            $http({method: method, url: url, data: 'data=' + $scope.mySelectedData + '&page=' + page_type, headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).
                    success(function (data, status) {
                        $scope.stddata = data;
                    }).
                    error(function (data, status) {
                        alert("problem in ajax");
                    });
        }

        $scope.mysaveclick = function (ss, subid) {
            var dd = jQuery.parseJSON($scope.mySelectedData);
            var tempData = JSON.stringify(ss);
            var myVal = jQuery.parseJSON(tempData);
            if (myVal.remark_filled == undefined) {
                alert('Please Enter Remark!');
                return false;
            } else {
                if (myVal.remark_filled == "") {
                    alert('Please Enter Remark!');
                    return false;
                } else {
                    myVal.subject_id = (dd.subject_id);
                    var method = "POST";
                    var url = "savesubjectremarkdata";
                    $http({method: method, url: url, data: 'data=' + JSON.stringify(myVal) + '&page=' + page_type, headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).
                            success(function (data, status) {
                                alert(data.message);
                                angular.forEach($scope.stddata, function (val, key) {
                                    if (val.adm_no == data.value.adm_no) {
                                        val.remarkDetail.push({'id': data.value.id, 'remark': data.value.remark, 'timestamp': data.value.timestamp});
                                    }
                                });

                            });
                }
            }
        }
        $scope.deleteRemark = function (event, index) {
            if (confirm('Are you sure want to delete ?')) {
                $http({
                    method: "POST",
                    url: "deleteRemark",
                    data: 'data=' + event.target.id,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).
                        success(function (data, status) {
                            alert(data.message);
                            $scope.selectedstd.remarkDetail.splice(index, 1);

                        });
            }
        }

        //REMARK ENTRY AREA FOCUS FUNCTION TO LOAD COMMENTS
        $scope.myFocusEvent = function (ss) {
            $scope.showstddetail = true;
            $scope.selectedstd = ss;
        }
//DROP DOWN OF SUBJECT AND CLASS BOX
    }
]);
var app = angular.module('generalRemarkEntry', []);
app.controller('generalRemrkcontroller', ['$scope', '$http', function ($scope, $http) {
        $scope.showstddetail = false;
        var method = 'POST';
        var url = 'loadSectionList';
        $http({
            method: method, url: url, data: 'data=', headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).
                success(function (data, status) {
                    $scope.data = data;
                }).
                error(function (data, status) {
                    alert("problem in loading section");
                });
        $scope.mySectionStudent = function () {
            $scope.selectedstd = '';
            var method = 'POST';
            var url = 'getstudentlistofsubject';
            $http({method: method, url: url, data: 'data=' + $scope.mySelectedData + '&page=' + page_type, headers: {'Content-Type': 'application/x-www-form-urlencoded'}}
            ).
                    success(function (data, status) {
                        $scope.secdata = data;
                    }).
                    error(function (data, status) {
                        alert("problem in ajax");
                    });
        }
        $scope.mysaveclick = function (ss, subid) {
            var dd = jQuery.parseJSON($scope.mySelectedData);
            var tempData = JSON.stringify(ss);
            var myVal = jQuery.parseJSON(tempData);
            if (myVal.remark_filled == undefined) {
                alert('Please Enter Remark!');
                return false;
            } else {
                if (myVal.remark_filled == "") {
                    alert('Please Enter Remark!');
                    return false;
                } else {
                    myVal.subject_id = (dd.subject_id);
                    var method = "POST";
                    var url = "savesubjectremarkdata";
                    $http({method: method, url: url, data: 'data=' + JSON.stringify(myVal) + '&page=' + page_type, headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).
                            success(function (data, status) {
                                alert(data.message);
                                angular.forEach($scope.secdata, function (val, key) {
                                    if (val.adm_no == data.value.adm_no) {
                                        val.remarkDetail.push({'id': data.value.id, 'remark': data.value.remark, 'timestamp': data.value.timestamp});
                                    }
                                });
                            });
                }
            }
        }
        $scope.myFocusStudentEvent = function (ss) {
            $scope.showstddetail = true;
            $scope.selectedstd = ss;
        }
        $scope.myFocusStudentout = function () {
            $scope.showsecdetail = false;
        }

        $scope.deleteRemark = function (event,index) {
            if (confirm('Are you sure want to delete ?')) {
                $http({
                    method: "POST",
                    url: "deleteRemark",
                    data: 'data=' + event.target.id,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).
                        success(function (data, status) {
                            alert(data.message);
                            $scope.selectedstd.remarkDetail.splice(index, 1);
                        });
            }
        }
    }
]);

