var app = angular.module('manageStaff', ['blockUI', 'ngImgCrop', '720kb.datepicker']);
app.controller('staffController', function ($scope, $http, blockUI) {
    $scope.mainStaff = {};
    $scope.myMode = "SAVE";
    $scope.myStaffList = null;
    $scope.mainStaff.profile_pic_path = myURL + 'index.php/staff/getphoto/-1/THUMB';
    $scope.salutation = "Mr";
    $http({
        method: 'POST',
        url: myURL + 'index.php/staff/getallstaff',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.staffLoad = true;
        $scope.myStaffList = jsondata.stafflist;
        $scope.myDepList = jsondata.department;
        $scope.myDesigList = jsondata.designation;
    });
    $scope.editStaffDetail = function (myStaffListObj, index) {
        if (confirm('Are you sure to edit selected staff ?')) {
            if (myStaffListObj.salutation != '') {
                $scope.salutation = myStaffListObj.salutation;
            }
            $scope.myMode = "UPDATE";
            $scope.mainStaff = myStaffListObj;
            $scope.tempPath = $scope.mainStaff.profile_pic_path;
            $scope.mainStaff.profile_pic_path = myURL + 'index.php/staff/getphoto/' + myStaffListObj.id + '/THUMB';
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/fetchstaffmenu/' + $scope.mainStaff.id,
                data: '',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.mainStaff.menuDetail = jsondata;

            });

        }
    };
    $scope.myimageupld = false;
    $scope.cancelStaff = function () {
        if (confirm('Are you sure want to cancel ?')) {
            $scope.myMode = "SAVE";
            $scope.mainStaff = [];
            $scope.myimageupld = true;
            $scope.myimagepath = myURL + 'index.php/staff/getphoto/-1/THUMB';
            

        }
    }
    
    $scope.setSalutation = function (salutation) {
        $scope.salutation = salutation;
        $scope.mainStaff.salutation = salutation;
    }
    $scope.saveStaffDetail = function ($error) {
        var curentYr = currentDate.split('-');
        var dob = $scope.mainStaff.dob_date.split('-');
        var doj = $scope.mainStaff.date_of_joining.split('-');
        var bseLineDate = parseInt(curentYr[2]);
        var dobnew = parseInt(dob[2]);
        var myVar = $scope.mainStaff.date_of_joining > currentDate;
        if (!$scope.myForm.$valid) {
            alert("Please correct the form error then try to save it.");
            return false;
        }
        if (dobnew > bseLineDate - 12) {
            alert('Please enter the valid date of birth (at least 12 yr difference) then try to save it..');
            return false;
        }
//        if (myVar) {
//            alert("Please enter correct date of joining then try to save it.");
//            return false;
//        }
        if (confirm('Are you sure want to save staff detail ?')) {
            delete $scope.mainStaff['menuDetail'];
            $scope.mainStaff.profile_pic_path = $scope.tempProfilePicpath;
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/saveallstaff',
                data: 'data=' + angular.toJson($scope.mainStaff) + '&random=' + rand,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                toastr.success(jsondata.message);
                if ($scope.myMode == "SAVE" && jsondata.type == 'SAVE') {
                    $scope.mainStaff.profile_pic_path = jsondata.value.path;
                    $scope.mainStaff.id = jsondata.value.id;
                    $scope.myStaffList.push($scope.mainStaff);
                    $scope.mainStaff = null;
                    $scope.myMode = "SAVE";
                    $scope.myimageupld = true;
                    $scope.myimagepath = myURL + 'index.php/staff/getphoto/-1/THUMB';
                 
                } else if (jsondata.type == 'UPDATE') {
                    angular.forEach($scope.myStaffList, function (value, key) {
                        if (value.id === jsondata.value.id) {
                            if (jsondata.value.path) {
                                value.profile_pic_path = myURL+jsondata.value.path;
                            }
                        }
                    });
                } else {
                    console.log('error in backend');
                    return false;
                }
            });
        }
    }
    $scope.savePriviledge = function () {
        if (confirm('Are you sure want to save staff priviledge ?')) {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/savestaffprivilege',
                data: 'data=' + angular.toJson($scope.mainStaff),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                alert(jsondata.message);

            });

        }
    }
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
        //console.log('onChange fired');
    };
    $scope.onLoadBegin = function () {
        //  console.log('onLoadBegin fired');
    };
    $scope.onLoadDone = function () {
        //  console.log('onLoadDone fired');
    };
    $scope.onLoadError = function () {
        // console.log('onLoadError fired');
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
            randm_no: rand
        }
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/uploadpic',
            data: "data=" + encodeURIComponent(angular.toJson(data)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            if (jsondata.type == 'UPLOAD') {
                $scope.tempProfilePicpath = jsondata.value;
                if (!($scope.mainStaff.id == 'undefined')) {
                    angular.forEach($scope.myStaffList, function (matchvalue) {
                        if (matchvalue.id == $scope.mainStaff.id) {
                            matchvalue.profile_pic_path = myURL + jsondata.value;
                        }
                    });
                }
                $scope.mainStaff.profile_pic_path = myURL + jsondata.value;
                $scope.tempPath = $scope.mainStaff.profile_pic_path;
                document.getElementById("fileInput").value = "";
                $("#simpleModal").modal('hide');
            } else {
                alert(jsondata.message);
            }
        });
    }
    angular.element(document.querySelector('#fileInput')).on('change', handleFileSelect);
});