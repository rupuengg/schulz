var app = angular.module('StudentProfile', ['blockUI', 'ngImgCrop', '720kb.datepicker'])
        .controller('BasicProfile', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
                var method = 'POST';
                var url = base_url + 'index.php/staff/getstudentprofile';
                $scope.myrelation = {};
                $scope.type = type;
                if (type === 'NEW') {
                    $scope.data = {};
                    $scope.data.basicdata = {};
                    $scope.data.basicdata.adm_no = admno;
                    $scope.data.basicdata.profile_pic_path = base_url + 'index.php/staff/getstudphoto/' + admno + '/THUMB';
                } else {
                    $http({
                        method: method,
                        url: url,
                        data: 'data=' + encodeURIComponent(admno),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (data, status) {
                        $scope.data = data;
                        $scope.data.basicdata.profile_pic_path = base_url + 'index.php/staff/getstudphoto/' + $scope.data.basicdata.adm_no + '/THUMB';
                    }).error(function (data, status) {
                        $scope.data = data || "Request failed";
                        $scope.status = status;
                        console.log($scope.data.medical.blood_group);
                    });
                }
                $scope.selected = 0;
                $scope.selectedRelation = function (relationName) {
                    $scope.selected = relationName;
                }
                $scope.getFeesDetail = function (admno) {
                    window.open(base_url + 'index.php/staff/studntfeesprofile/' + admno);
                }
                $scope.saveData = function () {
                    var dobYear = $scope.data.basicdata.dob_date.split("-");
                    var adYear = $scope.data.basicdata.ad_date.split("-");
                    var dob_year = parseInt(dobYear[2]);
                    var ad_year = parseInt(adYear[2]);
                    $scope.data.basicdata.profile_pic_path = $scope.tempPicPath;
                    if (dob_year <= ad_year - 3) {
                        var method = 'POST';
                        var url = base_url + 'index.php/staff/saveprofile';
                        $http({method: method, url: url, data: 'data=' + encodeURIComponent(angular.toJson($scope.data)) + '&type=' + type + '&school=' + school + '&sessionyear=' + sessionyear, headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
                                .success(function (data, status) {
                                    alert(data.message);
                                    if (type === 'NEW') {
                                        window.location.replace(base_url + 'index.php/staff/managestudent/' + admno);
                                    } else {
                                        window.location.replace(base_url + 'index.php/staff/managestudent');
                                    }
                                })
                                .error(function (data, status) {
                                    alert('Oop!! Something Went wrong.');
                                });
                    } else {
                        alert("Date of birth must be less than 3 years from date of admission");
                        return false;
                    }
                };
                
                $scope.changeRelation = function () {
                    alert($scope.basicdata.relation);
                };

                $scope.cancel = function () {
                    if (type === 'NEW') {
                        if (confirm('Are you sure want to cancel ?')) {
                            window.location.replace(base_url + 'index.php/staff/managestudent');
                        }
                    } else {
                        if (confirm('Are you sure want to cancel ?')) {
                            window.location.replace(base_url + 'index.php/staff/managestudent/' + admno);
                        }
                    }
                };
                

                /******************** new pulgin for croping*******************/
                $scope.enableCrop = true;
                $scope.size = 'medium';
                $scope.type = 'circle';
                $scope.imageDataURI = '';
                $scope.resImageDataURI = '';
                $scope.resImgFormat = 'image/png';
                $scope.resImgQuality = 1;
                $scope.selMinSize = 100;
                $scope.resImgSize = 200;
                //$scope.aspectRatio=1.2;
                $scope.onChange = function ($dataURI) {
                    console.log('onChange fired');
                };
                $scope.onLoadBegin = function () {
                    console.log('onLoadBegin fired');
                };
                $scope.onLoadDone = function () {
                    console.log('onLoadDone fired');
                };
                $scope.onLoadError = function () {
                    console.log('onLoadError fired');
                };
                var handleFileSelect = function (evt) {
                    var file = evt.currentTarget.files[0];
                    var reader = new FileReader();
                    reader.onload = function (evt) {
                        $scope.$apply(function ($scope) {
                            $scope.imageDataURI = evt.target.result;
                        });
                    };
                    reader.readAsDataURL(file);
                };
                $scope.FinalImage = function () {
                    var data = {
                        image: $scope.resImageDataURI,
                        adm_no: admno
                    }
                    $http({
                        method: 'POST',
                        url: base_url + 'index.php/staff/upload',
                        data: "data=" + encodeURIComponent(angular.toJson(data)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        if (jsondata.type == 'UPLOAD') {
                            $scope.tempPicPath = jsondata.value;
                            $scope.data.basicdata.profile_pic_path_thumbnail = jsondata.value;
                            $scope.data.basicdata.profile_pic_path = base_url + jsondata.value;
                            document.getElementById("fileInput").value = "";
                        } else {
                            alert(jsondata.message);
                        }
                    });
                }
                angular.element(document.querySelector('#fileInput')).on('change', handleFileSelect);


            }
        ]);

var app = angular.module('StudentDetails', ['blockUI'])
        .controller('StudentProfileDetails', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
                $http({
                    method: 'POST',
                    url: base_url + 'index.php/staff/studentprofile/studentDetails',
                    data: 'data=' + std_id,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.data = jsondata;
                });
                $scope.issueBluecard = function (todo1, event) {
                    var data = '{"adm_no": "' + std_id + '", "todoname": "' + todo1 + '","card_type":"' + event.target.id + '", "entryby":"' + login + '"}';
                    $http({
                        method: 'POST',
                        url: 'issuecards',
                        data: 'data=' + data,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        alert(jsondata.message);
                        window.location = base_url + 'index.php/staff/studentprofile/' + std_id;
                    });
                }
            }
        ]);
