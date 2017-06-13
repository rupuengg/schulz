/**********************bus contractor module*************/
var busContract = angular.module('busContractApp', ['blockUI']);
busContract.controller('busContractController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {


    }]);

/****************bus stop module***********************/
var busStopApp = angular.module('busStopApp', ['blockUI']);
busStopApp.controller('busStopController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {


    }]);

/*************susmita code for bus module*************/
var busEntryApp = angular.module('busEntryApp', ['blockUI']);
busEntryApp.controller('busEntryController', ['$scope', '$http', 'blockUI', '$interval', function ($scope, $http, blockUI, $interval) {
        if (bus_detail_edit != '') {

            $scope.busDetail = bus_detail_edit;
        }
        //all bus detail on pageload
        autoLoad();
        function autoLoad() {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getallbuslist',
                data: 'data=' + encodeURIComponent(angular.toJson($scope.busDetail)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.BusList = jsondata;
            });
        }
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getbuscontractor',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.contractorDetail = jsondata;
        });

        /////////////////////////////////////////
        $scope.buttonStatus = false;
        $scope.changeButtonStataus = function () {
            $scope.buttonStatus = true;
        }
        $scope.cancelUpload = function () {
            window.location.assign(myURL + 'index.php/staff/busmodule');
        }
        if (bus_id != '') {
            $scope.buttonVal = "Update";
            $scope.uploadbuttonVal = "Total Uploads";
            $scope.cancelButton = false;
            $scope.buttonStatus = true;
        } else {
            $scope.buttonVal = "Save";
            $scope.uploadbuttonVal = "Uploap Papers";
            $scope.BusList = [];
            $scope.cancelButton = true;
        }
        $scope.saveBusDetail = function () {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/savebusdetail',
                data: 'data=' + encodeURIComponent(angular.toJson($scope.busDetail)) + '&bus_id=' + bus_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                alert(jsondata.message);
                if (bus_id == '') {
                    $scope.BusList.push($scope.busDetail);
                    $scope.myIndex = null;
                    $scope.busDetail = null;
                }
                $scope.myIndex = null;
                $scope.busDetail = null;
                autoLoad();
            });

        }

        $scope.editBusDetail = function (id) {
            $scope.busDetail = $scope.BusList[id];
            $scope.myIndex = id;
            window.location.assign(myURL + 'index.php/staff/busmodule/' + id);
        }
        ////////////////////delete bus detail
        $scope.deleteBusDetail = function (index) {
            $scope.busDetail = [];
            var chk = confirm("Are you sure want to delete this bus detail ?");
            if (chk == true) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/deletebusdetail',
                    data: 'data=' + index,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    autoLoad();
                });
            }
            else {
                return false;
            }

        }
    }]);

/*****************code for driver module******************/
var driverEntryApp = angular.module('driverEntryApp', ['blockUI']);
driverEntryApp.controller('driverEntryController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {


    }]);
/******************************finish***************************/
/**************************bus driver relation module***********/
var busDriverApp = angular.module('busDriverApp', ["ngTouch", "angucomplete-alt"]);
busDriverApp.controller('busDriverController', ['$scope', '$http', function ($scope, $http) {
        $scope.bustripdetails = null;
        $scope.selectBusno = bus_id;
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getallbusdetail',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.busdetails = jsondata;

        });

        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getbustripdriverdetail',
            data: 'bus_id=' + encodeURIComponent(bus_id),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.bustripdetails = jsondata;

        });

        $scope.changedBusNo = function () {
            window.location.assign(myURL + "index.php/staff/managebusdriver/" + $scope.selectBusno);
        }

        $scope.editDriverConductor = function (busdetail, type, index) {
            if (type == 1) {
                var driverType = 'Driver'
            }
            else {
                var driverType = 'Conductor'
            }
            if (confirm('Do you want to edit the ' + angular.lowercase(driverType) + ' record of ' + busdetail + '?')) {
                if (type == 1) {
                    $scope.bustripdetails[index].driver_name = null;
                } else {
                    $scope.bustripdetails[index].conductor_name = null;
                }
            }
        }

        $scope.deleteDriverConductor = function (busdetail, name, trip_id, type, index) {
            if (type == 1) {
                var driverType = 'Driver'
            }
            else {
                var driverType = 'Conductor'
            }
            if (confirm('Do you want to remove the ' + angular.lowercase(driverType) + ' ' + name + ' from  ' + busdetail + '?')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/deletebusdriverconductor',
                    data: 'trip_id=' + encodeURIComponent(trip_id) + '&driver_type=' + encodeURIComponent(type),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    if (type == 1) {
                        $scope.bustripdetails[index].driver_name = null;
                    } else {
                        $scope.bustripdetails[index].conductor_name = null;
                    }
                });
            }
        }

        $scope.selectedDriver = function (finalObj) {
            if (finalObj.description.driver_type == 1) {
                var driver = 'driver';
            } else {
                var driver = 'conductor';
            }
            if (confirm('Do you want to add/save ' + finalObj.description.name + ' as a bus ' + angular.lowercase(driver + '?'))) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/savebusdriverrelation',
                    data: 'data=' + encodeURIComponent(angular.toJson(finalObj.description)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location = self.location;
                });

            }
        }

    }]);


/*******************************Manage bus trip module***********************/
var busTripApp = angular.module('busTripApp', ["ngTouch", "ui.bootstrap", "angucomplete-alt"]);
busTripApp.controller('busTripController', ['$scope', '$http', function ($scope, $http) {
        $scope.hstep = 1;
        $scope.mstep = 5;
        $scope.tripDetail = {};
        if (trip_id == '') {
            $scope.tripDetail.trip_time = new Date();
        }

        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getallbusdetails',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.busDetail = jsondata;
        });


        $scope.selectBus = function () {
            if ($scope.tripDetail.bus_id != '') {
                window.location.href = myURL + 'index.php/staff/managebustrip/' + $scope.tripDetail.bus_id;
                $scope.showTripMessage = true;

            }
        }

        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/gettripdetail',
            data: 'data= ' + trip_id + '&bus_id=' + bus_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.trip = jsondata;
            $scope.tripDetail = $scope.trip[0];
        });

        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/busdetails',
            data: 'data= ' + bus_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.busTripDetail = jsondata.tripDetail;
        });

        $scope.saveTripDetail = function () {
//            console.log(trip_id);
            if (trip_id == '') {
                if (confirm('Are you sure want to Save')) {
                    var data = {
                        trip_name: $scope.tripDetail.trip_name,
                        trip_time: $scope.tripDetail.trip_time
                    }
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/staff/savenewtrip',
                        data: 'data= ' + encodeURIComponent(angular.toJson(data)) + '&bus_id=' + bus_id,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        alert(jsondata.message);
                        window.location.href = myURL + 'index.php/staff/managebustrip/' + bus_id + '/' + jsondata.objId;
                    });
                }
            } else {

                if (confirm('Are you sure want to Update?')) {
                    var data = {
                        trip_name: $scope.tripDetail.trip_name,
                        trip_time: $scope.tripDetail.trip_time
                    }
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/staff/savenewtrip',
                        data: 'data= ' + encodeURIComponent(angular.toJson(data)) + '&bus_id=' + bus_id + '&trip_id=' + trip_id,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        alert(jsondata.message);
                        window.location.href = myURL + 'index.php/staff/managebustrip/' + bus_id + '/' + trip_id;
                    });
                }
            }
        }

        $scope.tempArray = [];
        $scope.selectedObject = function (selectObj) {
            $scope.Stop = selectObj.description;
            var addToArray = true;
            for (var i = 0; i < $scope.tempArray.length; i++) {
                if ($scope.tempArray[i].stopId === $scope.Stop.stopId) {
                    addToArray = false;
                }
            }
            if (addToArray) {
                $scope.tempArray.push($scope.Stop);
            }
        }

        $scope.addReachtime = function (time) {
            $scope.Stop['time'] = time;
        }
        $scope.stopArray = [0];
        $scope.addAnotherStop = function () {
            this.review = {};
            $scope.stopArray.push(this.review);
        }

        $scope.removeStop = function (index) {
            $scope.stopArray.splice(index, 1);

        }
        $scope.saveAllStop = function () {
//            console.log($scope.tempArray);
            var data = {
                tripId: trip_id,
                stopDeatils: $scope.tempArray
            }
            if (confirm('Are you sure want to Save')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/saveallstop',
                    data: 'data= ' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location.href = myURL + 'index.php/staff/managebustrip/' + bus_id + '/' + trip_id;
                });
            }
        }

        $scope.editTrip = function (bus, trip) {
            window.location.href = myURL + 'index.php/staff/managebustrip/' + bus + '/' + trip;
            $scope.buttonStatus = true;
        }

        $scope.removeTrip = function (bus, trip) {
            var data = {
                tripId: trip,
                busId: bus
            }
            if (confirm('Are you sure want to Delete')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/removetrip',
                    data: 'data= ' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location.href = myURL + 'index.php/staff/managebustrip/' + bus;
                });
            }
        }
    }]);

/********************manage student bus trip**************************/
var app = angular.module('studentBusTripApp', ["ngTouch", "angucomplete-alt"]);
app.controller('studentBusController', ['$scope', '$http', function ($scope, $http) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getsectionlist',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.sectionList = jsondata;
        });
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getissuedstudentlist',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.StudentTripData = jsondata;
        });
        $scope.tempArray = [];
        $scope.selectedObject = function (selectObj) {
            $scope.student = selectObj.description;
            $scope.tempArray.push($scope.student);
        }
        $scope.saveStudentBus = function () {

            if ($scope.tempArray == '') {
                alert('Please fill the information first,then try again..');
            } else if ($scope.tripStatus == undefined) {
                alert('Please select the type first,then try again..');
            }
            else {
                var data = {
                    student: $scope.tempArray,
                    tripStatus: $scope.tripStatus
                }
                if (confirm('Are you sure want to Save')) {
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/staff/savestudenttrip',
                        data: 'data= ' + encodeURIComponent(angular.toJson(data)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        alert(jsondata.message);
                        $scope.tempArray = '';
                        $scope.tripStatus = null;
                        window.location = self.location;
                    });
                }
            }
        }

        $scope.removeStudentTrip = function (dataObj) {
            if (confirm('Are you sure want to Delete')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/removeissuedtrip',
                    data: 'data= ' + encodeURIComponent(angular.toJson(dataObj.adm_no)) + '&type=' + dataObj.trip_type,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location = self.location;
                });
            }
        }

        $scope.selectSection = function () {
            if ($scope.sectionId != '') {
                window.location.href = myURL + 'index.php/staff/managestudentbus/' + $scope.sectionId;
            }
        }
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getallstudentsectionwise',
            data: 'data= ' + section,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.studentDetail = jsondata;
        });

        $scope.selectedObjectcoming = function (selectObj) {
            $scope.comingTrip = selectObj.description;
            var data = {
                student: $scope.comingTrip,
                tripStatus: 'COMING'
            }
            
            if (confirm('Are you sure want to Save')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/savestudenttripbysection',
                    data: 'data= ' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location = self.location;
                });
            }

        }

        $scope.selectedObjectgoing = function (selectObj) {
            $scope.outTrip = selectObj.description;
            var data = {
                student: $scope.outTrip,
                tripStatus: 'GOING'
            }
            if (confirm('Are you sure want to Save')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/savestudenttripbysection',
                    data: 'data= ' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location = self.location;
                });
            }

        }

        $scope.removeComingTrip = function (index) {
//            console.log(index); return false;
            if (confirm('Are you sure want to Delete')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/removeissuedtripsectionwise',
                    data: 'data= ' + encodeURIComponent(angular.toJson(index)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location = self.location;
                });
            }
        }

        $scope.removeOutTrip = function (index) {
            if (confirm('Are you sure want to Delete')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/removeissuedtripsectionwise',
                    data: 'data= ' + encodeURIComponent(angular.toJson(index)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location = self.location;
                });
            }
        }

        $scope.cancel = function () {
            if (confirm('Are you sure want to cancel')) {
                window.location = self.location;
            }
        };

    }]);



/*****************************report module*****************************/
var reportApp = angular.module('reportApp', ['blockUI']);
reportApp.controller('reportAppController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getalltrip',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.tripDetail = jsondata;
        });

        $scope.selectBusNo = function () {
            window.location.assign(myURL + "index.php/staff/generatereport/" + $scope.selectBusno);
        }
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getbusstops',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.stoplist = jsondata;

        });

        $scope.selectStop = function () {
            window.location.assign(myURL + "index.php/staff/generatereport/" + $scope.selectStopName);
        }
    }]);