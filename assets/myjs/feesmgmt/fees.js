
/*************************** fee installment nitin******************/
var feesinstallment = angular.module('feeinstlmnt', []);
feesinstallment.controller('instlmntcontroller', ['$scope', '$http', function ($scope, $http) {

        $scope.proceed = function () {
            if (parseInt($scope.billraisedate) < parseInt($scope.billenddate)) {
                var data = {
                    shortcode: $scope.installmentname,
                    billraisedate: $scope.billraisedate,
                    billenddate: $scope.billenddate,
                }
                $scope.showdiv = true;
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/getinstallment',
                    data: "data=" + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    if (jsondata.type == 'SAVERROR') {
                        alert(jsondata.message);
                    } else {
                        $scope.instllmntDetail = jsondata;
                    }
                });
            } else {
                alert('please select no. greater than bill raise date');
                return false;
            }
        }

        $scope.saveInstlmntDetail = function (shortcode) {
            if (confirm("Do you want to save details?")) {
                var data = {
                    shortcode: shortcode,
                    instllmntData: $scope.instllmntDetail
                }

                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/savedetails',
                    data: "data=" + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);

                });
            } else {
                return false;
            }
        }
    }]);


/***************************  classwise fee headsetting  nitin******************/

var classwseFeestting = angular.module('fee', []);
classwseFeestting.controller('feeController', ['$scope', '$http', function ($scope, $http) {

        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getclassdata',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.standardName = jsondata.standardName;
            $scope.feesName = jsondata.feesName;
        });
        $scope.selectfees = function () {
            var data = {
                class_id: $scope.selectstandard,
                category_id: $scope.category_id,
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getfeesdata',
                data: "data=" + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.feesdetail = jsondata.feesdetail;
                $scope.feesname = jsondata.feesname;
                $scope.isAnyCheckedStatus = true;

                $scope.isCopySetting = true;
                $scope.changeName = true;
                angular.forEach($scope.feesdetail, function (value, key) {
                    if (value.hasOwnProperty("status")) {
                        $scope.isAnyCheckedStatus = false;
                        $scope.isCopySetting = false;
                        $scope.changeName = false;
                    }
                });
            });
        }

        $scope.checkStatus = function (data) {
            if (data.status && data.feesAmount != '' && data.feesAmount != undefined) {
                $scope.isAnyCheckedStatus = false;
                $scope.isCopySetting = false;
            } else {
                $scope.isAnyCheckedStatus = true;
                $scope.isCopySetting = true;
            }
        }
        $scope.save = function (class_id, msg) {
            if (confirm(msg)) {
                var data = {
                    class_id: class_id,
                    feeData: $scope.feesdetail
                }


                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/savefeesdetails',
                    data: "data=" + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}

                }).success(function (jsondata) {
                    alert(jsondata.message);
                    $scope.isCopySetting = false;
                    $scope.showdrpdwn = false;

                });
            } else {
                return false;
            }
        }

        $scope.markFees = function (category_id) {
            $scope.category_id = category_id;
        }

        $scope.validateamount = function (amount) {
            if (parseInt(amount.feesAmount) > 0 && amount.feesAmount != "")
            {
                amount.myErr = 'false';
                if (amount.status) {
                    $scope.isAnyCheckedStatus = false;
                    $scope.isCopySetting = false;

                }


            } else {
                amount.myErr = 'true';
                $scope.isAnyCheckedStatus = true;
                $scope.isCopySetting = true;

            }

        }

    }]);
/*************************** student fees relation nitin******************/

var studentdetails = angular.module('student', [])
studentdetails.controller('studControl', ['$scope', '$http', function ($scope, $http) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getallsectionlist',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.class = jsondata.section;
        });
        if (classid > 0) {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/custmizfees',
                data: "data=" + encodeURIComponent(angular.toJson(classid)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.feesDetails = jsondata;
            });
        }

        $scope.classfeessetting = function (selectdclass) {
            window.location = myURL + 'index.php/staff/classrel/' + selectdclass;
        }

        $scope.CheckStatusData = function (categoryname, index) {
            angular.forEach($scope.feesDetails, function (value, key) {
                if (value.id == categoryname.id) {
                    if (value.sub[index].status) {
                        value.sub[index].mandatory_type = 'YES';
                        value.table_length = (value.table_length + 1);
                    } else {
                        value.sub[index].mandatory_type = 'NO';
                        value.table_length = (value.table_length - 1);
                    }
                }

            });
        }
        $scope.GetFeeStracture = function () {
            if ($scope.selectdclass != 'NA') {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/custmizfees',
                    data: "data=" + encodeURIComponent(angular.toJson($scope.selectdclass)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.feesDetails = jsondata;
                });
            } else {
                alert('Select valid class first then try again..');
                return false;
            }

        }


        $scope.saveStudentData = function (adm_no) {
            if (confirm("Do you want to save details?")) {
                var data = {
                    adm_no: adm_no,
                    head_id: $scope.feesDetails,
                    clssid: $scope.selectdclass,
                }
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/save',
                    data: "data=" + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}

                }).success(function (jsondata) {
                    if (jsondata.type == 'SAVE') {
                        alert(jsondata.message);
                        window.location = myURL + 'index.php/staff/managestudent/' + adm_no;
                    }
                });

            } else {
                return false;
            }
        }

    }]);

/***************************student fees entry nitin******************/

var studentfeesentry = angular.module('feesentry', ["ngTouch", "angucomplete-alt"]);
studentfeesentry.controller('feeentrycontrller', ['$scope', '$http', function ($scope, $http) {
        $scope.InstlDetail = false;
        $scope.showInstltable = false;
        $scope.stdnDetail = 'TRUE';
        $scope.selectedStudentObject = null;

        $scope.selectedStdntObj = function (Obj) {
            $scope.selectedStudentObject = Obj;
            $scope.InstlDetail = true;
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/slctedstdntDetls',
                data: "data=" + encodeURIComponent(angular.toJson(Obj.originalObject.adm_no)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}

            }).success(function (jsondata) {
                $scope.StdntDetails = jsondata;
                $scope.InstDet = jsondata.instDeatil;
                $scope.stdnDetail = 'FALSE';

            });
        }

        function GetbalAmt(myIndex, myamount) {
            myamount = parseFloat(myamount) + parseFloat($scope.InstDet[myIndex].balance);
            myIndex = myIndex - 1;
            if (myIndex >= 0) {
                GetbalAmt(myIndex, myamount);
            } else {
                $scope.FinalBalAmt = myamount;
            }
        }

        $scope.PayInstlmnt = function (myIndex, blnceamnt, instId, instDueDate) {

            if (myIndex >= 0) {
                GetbalAmt(myIndex, 0);

            }

            $scope.index = myIndex
            $scope.Insid = instId;
            var dt1 = instDueDate.split('-');
            var dt2 = $scope.details.date.split('-');
            var date1 = new Date(dt1[0], dt1[1] - 1, dt1[2]);
            var date2 = new Date(dt2[2], dt2[1] - 1, dt2[0]);
            var millisecondsPerDay = 1000 * 60 * 60 * 24;
            var millisBetween = date2.getTime() - date1.getTime();
            var days = millisBetween / millisecondsPerDay;
            var fineDays = days - 1;
            $scope.fne = fineDays;

            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/fine',
                data: "data=" + encodeURIComponent(angular.toJson(fineDays)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}

            }).success(function (jsondata) {

                $scope.fine = jsondata.totalfine;
                $scope.tempfine = $scope.fine;

                GettooltipAmnts(myIndex);

            });


        }

        $scope.viewInstlmnt = function (adm_no, Instlname, instAmnt, InstId) {

            $scope.showInstltable = true
            $scope.Instlname = Instlname;
            var data = {
                adm_no: adm_no,
                installmntId: InstId
            };

            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/viewinstlmnt',
                data: "data=" + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}

            }).success(function (jsondata) {

                $scope.tempinstadet = jsondata;

                angular.forEach($scope.tempinstadet, function (value, key) {

                    value.balance = instAmnt - value.amount;

                    instAmnt = value.balance;
                })

                $scope.viewInstlDetls = $scope.tempinstadet;
            });
        }

        var tempAmt = 0;
        function GetInstlbalAmt(instIndex, FinalBalAmt, myAmnt) {

            angular.forEach($scope.InstDet, function (value, key) {
                if (instIndex >= key) {

                    tempAmt = parseFloat(myAmnt) - parseFloat(value.balance);
                    if (tempAmt > 0) {
                        value.balance = 0;
                        myAmnt = tempAmt;

                    } else {
                        value.balance = tempAmt * -1;

                        return false;
                    }
                }
            });


        }

        $scope.SavePayDetails = function (instIndex, adm_no, instId, tempfine, FinalBalAmt) {
            if ($scope.fine > tempfine) {
                alert(' fine should not exceed actual fine ');
                return false;
            } else {
                if (confirm("Do you want to pay ?")) {
                    if ($scope.pymnt == 'cash') {
                        if ($scope.details.amount == '') {
                            alert('Please enter the amount first then try again..');
                            return false;
                        }
                    } else {
                        if ($scope.details.amount == '' || $scope.details.chequenumbr == '') {
                            alert('Please enter the full cheque details then try again ...');
                            return false;
                        }
                    }
                    var data = {
                        data: $scope.details,
                        adm_no: adm_no,
                        payment_mode: $scope.pymnt,
                        InstllmntId: instId,
                    }

                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/staff/paymntdetail',
                        data: "data=" + encodeURIComponent(angular.toJson(data)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}

                    }).success(function (jsondata) {
                        if (jsondata.type == 'SAVE') {
                            alert(jsondata.message);
                            $scope.selectedStdntObj($scope.selectedStudentObject);
                            $('#simpleModal').modal("hide");
                            $scope.details.amount = "";
                            $scope.details.bankname = "";
                            $scope.details.chequenumbr = "";
                        } else {
                            alert(jsondata.message);
                        }

                    });

                } else {
                    return false;
                }
            }

        }
        function GetLastPaidAmt(instIndex, payamnt) {
            angular.forEach($scope.InstDet, function (value, key) {
                if (instIndex >= key)
                    if (value.balance != 0 && value.balance != value.ist_amt) {
                        value.pay_amt = payamnt;
                    }

            })
        }

        function GettooltipAmnts(myIndex) {
            switch (myIndex) {
                case 0:
                    $scope.tootltipAmnt = [$scope.InstDet[0].balance];
                    $scope.instNmne = $scope.InstDet[0].inst_name;
                    break;
                case 1:
                    var finaltotalAmnt = [$scope.InstDet[0].balance, $scope.InstDet[1].balance];
                    $scope.tootltipAmnt = finaltotalAmnt.join('+');
                    var Instlname = [$scope.InstDet[0].inst_name, $scope.InstDet[1].inst_name];
                    $scope.instNmne = Instlname.join(',');
                    break;
                case 2:
                    var finaltotalAmnt = [$scope.InstDet[0].balance, $scope.InstDet[1].balance, $scope.InstDet[2].balance];
                    $scope.tootltipAmnt = finaltotalAmnt.join('+');
                    var Instlname = [$scope.InstDet[0].inst_name, $scope.InstDet[1].inst_name, $scope.InstDet[2].inst_name];
                    $scope.instNmne = Instlname.join(',');
                    break;
                case 3:
                    var finaltotalAmnt = [$scope.InstDet[0].balance, $scope.InstDet[1].balance, $scope.InstDet[2].balance, $scope.InstDet[3].balance];
                    $scope.tootltipAmnt = finaltotalAmnt.join('+');
                    var Instlname = [$scope.InstDet[0].inst_name, $scope.InstDet[1].inst_name, $scope.InstDet[2].inst_name, $scope.InstDet[3].inst_name];
                    $scope.instNmne = Instlname.join(',');
                    break;
                case 4:
                    var finaltotalAmnt = [$scope.InstDet[0].balance, $scope.InstDet[1].balance, $scope.InstDet[2].balance, $scope.InstDet[3].balance, $scope.InstDet[4].balance];
                    $scope.tootltipAmnt = finaltotalAmnt.join('+');
                case 5:
                    var finaltotalAmnt = [$scope.InstDet[0].balance, $scope.InstDet[1].balance, $scope.InstDet[2].balance, $scope.InstDet[3].balance, $scope.InstDet[4].balance, $scope.InstDet[5].balance];
                    $scope.tootltipAmnt = finaltotalAmnt.join('+');
                    break;
                case 6:
                    var finaltotalAmnt = [$scope.InstDet[0].balance, $scope.InstDet[1].balance, $scope.InstDet[2].balance, $scope.InstDet[3].balance, $scope.InstDet[4].balance, $scope.InstDet[5].balance, $scope.InstDet[6].balance];
                    $scope.tootltipAmnt = finaltotalAmnt.join('+');
                    break;
                case 7:
                    var finaltotalAmnt = [$scope.InstDet[0].balance, $scope.InstDet[1].balance, $scope.InstDet[2].balance, $scope.InstDet[3].balance, $scope.InstDet[4].balance, $scope.InstDet[5].balance, $scope.InstDet[6].balance, $scope.InstDet[7].balance];
                    $scope.tootltipAmnt = finaltotalAmnt.join('+');
                    break;
                case 8:
                    var finaltotalAmnt = [$scope.InstDet[0].balance, $scope.InstDet[1].balance, $scope.InstDet[2].balance, $scope.InstDet[3].balance, $scope.InstDet[4].balance, $scope.InstDet[5].balance, $scope.InstDet[6].balance, $scope.InstDet[7].balance, $scope.InstDet[8].balance];
                    $scope.tootltipAmnt = finaltotalAmnt.join('+');
                    break;
                case 9:
                    var finaltotalAmnt = [$scope.InstDet[0].balance, $scope.InstDet[1].balance, $scope.InstDet[2].balance, $scope.InstDet[3].balance, $scope.InstDet[4].balance, $scope.InstDet[5].balance, $scope.InstDet[6].balance, $scope.InstDet[7].balance, $scope.InstDet[8].balance, $scope.InstDet[9].balance];
                    $scope.tootltipAmnt = finaltotalAmnt.join('+');
                    break;
                case 10:
                    var finaltotalAmnt = [$scope.InstDet[0].balance, $scope.InstDet[1].balance, $scope.InstDet[2].balance, $scope.InstDet[3].balance, $scope.InstDet[4].balance, $scope.InstDet[5].balance, $scope.InstDet[6].balance, $scope.InstDet[7].balance, $scope.InstDet[8].balance, $scope.InstDet[9].balance, $scope.InstDet[10].balance];
                    $scope.tootltipAmnt = finaltotalAmnt.join('+');
                    break;
                default:
                    var finaltotalAmnt = [$scope.InstDet[0].balance, $scope.InstDet[1].balance, $scope.InstDet[2].balance, $scope.InstDet[3].balance, $scope.InstDet[4].balance, $scope.InstDet[5].balance, $scope.InstDet[6].balance, $scope.InstDet[7].balance, $scope.InstDet[8].balance, $scope.InstDet[9].balance, $scope.InstDet[10].balance, $scope.InstDet[11].balance];
                    $scope.tootltipAmnt = finaltotalAmnt.join('+');
                    break;
            }
        }

    }]);

/***************************classwise head setting sapna******************/


var app = angular.module('head_app', []);
app.controller('head_controller', ['$scope', '$http', function ($scope, $http) {

        $http({
            method: 'POST',
            url: baseURL + 'index.php/selectcategory',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.category = jsondata;
        })
        $scope.postback = function () {
            if ($scope.categoryval == 'NA') {

                alert('id not selected');
                window.location = baseURL + 'index.php/headsetting';
            } else {
                window.location = baseURL + 'index.php/headsetting/' + $scope.categoryval;
            }


        }

    }]);

