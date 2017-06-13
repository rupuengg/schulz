var app = angular.module('homeworkApp', ['blockUI', 'angularFileUpload', '720kb.datepicker']);
app.controller('homeworkAppController', ['$scope', '$http', 'blockUI', 'FileUploader', function ($scope, $http, blockUI, FileUploader) {

        $scope.subject_id = '';
        $scope.section_id = '';
        $scope.holidaytype = 'NO';
        $scope.tempArr = [];
        $scope.importFile = [];
        $scope.fileNameArr = [];
        $scope.type = 'no';
        $scope.types = 'no';
        $scope.attechmentLength = 0;
        $scope.postHW = 'no';
        $scope.homeworkType = 'HOMEWORK';
        $scope.resultdata = [];
        $scope.hmwrktypeclass1 = 'active';
        $scope.hmwrktypeclass2 = '';
        
        $scope.details = function () {
            $("div#manage").removeClass("col-md-12");
            $("div#manage").addClass("col-md-6");
            $scope.type = 'yes';
            $scope.postHW = 'no';
        };
        $scope.managedetails = function (adm_no) {
            $("div#managedetails").removeClass("col-md-12");
            $("div#managedetails").addClass("col-md-6");
            $scope.types = 'yes';
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/loadstudet',
                data: 'data=' + encodeURIComponent(angular.toJson(adm_no)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.studhw = jsondata.stu_hwtitle;
                $scope.name = jsondata.stu_name;
            });
        };
        $scope.postHomework = function () {
            $("div#manage").removeClass("col-md-12");
            $("div#manage").addClass("col-md-6");
            $scope.postHW = 'yes';
            $scope.type = 'no';
            $scope.fulldeatil = 'no';
        };
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/loadsubject',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.stddata = jsondata;

        });
        
        $scope.loadhwdata = function (myData) {
            $scope.subject_id = myData.subject_id;
            $scope.section_id = myData.id;
            var data = {
                subject_id: myData.subject_id,
                section_id: myData.id,
                holidaytype: $scope.holidaytype,
                homeworkType: $scope.homeworkType
            };

            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/loadhwdata',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.resultdata = jsondata;
            });
        };
        
        $scope.postdata = function () {
            angular.forEach($scope.uploader.queue, function (value, key) {
                $scope.fileNameArr.push(value.file.name);
            });
            var data = {
                title: $scope.title,
                date: $scope.postdate,
                lastsubmissiondate: $scope.submitdate,
                subject_id: $scope.subject_id,
                section_id: $scope.section_id,
                holidaytype: $scope.holidaytype,
                homeworkType: $scope.homeworkType,
                uploadhint: uploadhint,
                importFiles: $scope.fileNameArr
            };

            $scope.tempArr.push(data);
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/newhwpost',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata.type == "SAVE") {
                    var pushData = {
                        id: jsondata.value, title: $scope.title, hw_date: $scope.postdate
                    }
                    $scope.resultdata.push(pushData);
                    $scope.title = "";
                    $scope.uploader.clearQueue();

                }
            });

        };

        $scope.details = function (id) {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/fulldetailhw',
                data: 'data=' + encodeURIComponent(angular.toJson(id)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.studentdata = jsondata;
                $scope.subject_id = jsondata.hwfulldetail.subject_id;
                $scope.section_id = jsondata.hwfulldetail.section_id;
                $scope.hmwrktype  = jsondata.hwfulldetail.homewrktype;
                $scope.hmwrktypeclass1 = $scope.hmwrktype=="DAILY"?"active":"";
                $scope.hmwrktypeclass2 = $scope.hmwrktype=="HOLIDAY"?"active":"";
                $scope.fulldeatil = 'yes';
                $scope.postHW = 'no';
                var mydata = {subject_id:$scope.subject_id,id:$scope.section_id};
                $scope.loadhwdata(mydata);


            });

        };


        $scope.reload = function (type) {

            $scope.studentdata = 0;
            $scope.fulldeatil = 'no';
            $scope.postHW = 'no';
            $scope.holidaytype = type;
            $scope.subject_id = '';
            $scope.section_id = '';
        };

//        $scope.reloadholiday = function () {
//            $scope.studentdata = 0;
//            $scope.fulldeatil = 'no';
//            $scope.postHW = 'no';
//            $scope.holidaytype = 'YES';
//            $scope.subject_id = '';
//            $scope.section_id = '';
//        };

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
        if (postHw_id != '') {
            $scope.details(postHw_id);
            
        }

    }]);

