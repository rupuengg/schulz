var app = angular.module('sqlreport', ['blockUI']);
app.controller('sqlreportController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.sqlresult = '';
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/reportdata',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.sqlReport = jsondata;
        });
        $scope.type = '';
        $scope.wherecolm = [];

        $scope.selectcolm = [];

        $scope.getWheredData = function (mydata, type) {
            if (type == 'YES') {
                $scope.wherecolm.push(mydata);
            }
            else {
                $scope.indexsing = $scope.wherecolm.indexOf(mydata);
                $scope.wherecolm.splice($scope.indexsing, 1);
            }
        }
        $scope.getSelectData = function (mydata, type) {
            if (type == 'YES') {
                $scope.selectcolm.push(mydata);

            }
            else {
                $scope.indexsingSelectColm = $scope.selectcolm.indexOf(mydata);
                $scope.selectcolm.splice($scope.indexsingSelectColm, 1);
            }
        }
        $scope.searchButton = function () {
            if ($scope.selectcolm == '') {
                alert('Please select atleast one field from column name');
                return false;
            }
            var data = {
                select: $scope.selectcolm,
                where: $scope.sqlReport.fields
            };
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/searchdata',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.sqlresult = jsondata;
            });
        }

    }]);

