var app = angular.module('assigmentApp', ['blockUI', 'angularFileUpload', '720kb.datepicker']);
app.controller('assigmentAppController', ['$scope', '$http', 'blockUI', 'FileUploader', function ($scope, $http, blockUI, FileUploader) {
        $scope.base_url = myURL;
        $scope.subject_id = '';
        $scope.section_id = '';
        $scope.holidaytype = 'NO';
        $scope.selectcolm = [];
        $scope.type = 'no';
        $scope.types = 'no';
        $scope.postHW = 'no';
        $scope.homeworkType = 'ASSIGNMENT';
        $scope.tempArr = [];
        $scope.importFile = [];
        $scope.fileNameArr = [];
        $scope.attechmentLength = 0;
        $scope.details = function () {
            $("div#manage").removeClass("col-md-12");
            $("div#manage").addClass("col-md-6");
            $scope.type = 'yes';
            $scope.postHW = 'no';
        };
        
        $scope.managedetails = function () {
            $("div#managedetails").removeClass("col-md-12");
            $("div#managedetails").addClass("col-md-6");
            $scope.types = 'yes';
        };
        
        $scope.postNewAssignment = function () {
            $("div#manage").removeClass("col-md-12");
            $("div#manage").addClass("col-md-6");
            $scope.postHW = 'yes';
            $scope.type = 'no';
        };
        
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/loadallsection',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.sectiondata = jsondata;
        });

        var data = {
            homeworkType: $scope.homeworkType,
            holidaytype: $scope.holidaytype
        }
        
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/myloadassignment',
            data: 'data=' + encodeURIComponent(angular.toJson(data)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.assignmentdata = jsondata;
        });

        $scope.loadsectionstudent = function () {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/loadsectionstudent',
                data: 'data=' + encodeURIComponent(angular.toJson($scope.mysection_id)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.allstddata = jsondata;
            });
        }
        $scope.GetCountSelectedStudent = function (std) {
            if (std.selectStudent == true) {
                $scope.selectcolm.push(std);
                console.log($scope.selectcolm);
            } else {
                $scope.selectcolm.pop(std);
            }
        }
        
        $scope.postdata = function () {
            if($scope.selectcolm.length == 0){
                alert('Please select students for assignment....!!! ');
                 return false;
            }
            
             if (confirm('Do you really want to save??')) {
                angular.forEach($scope.uploader.queue, function (value, key) {
                    $scope.fileNameArr.push(value.file.name);
                });
                var data = {
                    title: $scope.title,
                    date: $scope.postdate,
                    lastsubmissiondate: $scope.lastsubmitdate,
                    holidaytype: $scope.holidaytype,
                    homeworkType: $scope.homeworkType,
                    studentDeatils: $scope.selectcolm,
                    uploadhint: uploadhint,
                    importFiles: $scope.fileNameArr
                };
               
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/newhwpost',
                    data: 'data=' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location = self.location;
                });
            }
        }
        $scope.assignmentfulldetail = function (assignmentId) {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/fullassignmentdetail',
                data: 'data=' + encodeURIComponent(angular.toJson(assignmentId)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
//                console.log(jsondata);exit;
                $scope.assignmentfull = jsondata;
                $scope.type = 'yes';
                $scope.postHW = 'no';
            });
        }
        
        $scope.GetAllAssignList = function (assignmentType) {
            $scope.title = '';
            $scope.postdate = '';
            $scope.lastsubmitdate = '';
            var data = {
                homeworkType: $scope.homeworkType,
                holidaytype: $scope.holidaytype
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/myloadassignment',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.assignmentdata = jsondata;
                $scope.postHW = 'no';
                $scope.type = 'no';
                $scope.assignmentfull = null;
            });
        }



        var uploader = $scope.uploader = new FileUploader({
            url: myURL + 'index.php/upload/' + uploadhint
        });

        // FILTERS

        uploader.filters.push({
            name: 'customFilter',
            fn: function (item /*{File|FileLikeObject}*/, options) {
                return this.queue.length < 10;
            }
        });

        // CALLBACKS

        uploader.onWhenAddingFileFailed = function (item /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
        };
        uploader.onAfterAddingFile = function (fileItem) {
            console.info('onAfterAddingFile', fileItem);
        };
        uploader.onAfterAddingAll = function (addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
            $scope.attechmentLength = addedFileItems.length;
        };
        uploader.onBeforeUploadItem = function (item) {
            console.info('onBeforeUploadItem', item);
        };
        uploader.onProgressItem = function (fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
        };
        uploader.onProgressAll = function (progress) {
            console.info('onProgressAll', progress);
        };
        uploader.onSuccessItem = function (fileItem, response, status, headers) {
            console.info('onSuccessItem', fileItem, response, status, headers);
        };
        uploader.onErrorItem = function (fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
        };
        uploader.onCancelItem = function (fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
        };
        uploader.onCompleteItem = function (fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
        };
        uploader.onCompleteAll = function () {
            console.info('onCompleteAll');
        };

    }]);


