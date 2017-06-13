var app = angular.module('examDateSheet', ['blockUI', '720kb.datepicker']);
app.controller('examDateSheetController', function($scope, $http, blockUI) {
    $scope.classtandard = 0;
    $scope.subject = 0;
    $scope.tempArrSubject = [];
    $scope.temp='';
    $http({
        method: 'POST',
        url: myURL + 'index.php/staff/classlist',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function(jsondata) {

        $scope.classlist = jsondata;

    });
    $scope.sectiondata = function()
    {
        var data = {
            class: $scope.classtandard
        };
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/sectiondata',
            data: 'data=' + encodeURIComponent(angular.toJson(data)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(jsondata) {

            $scope.sectiondetaildata = jsondata.sectiondetail;
            $scope.subjectdetaildata = jsondata.subjectdetail;
            $scope.examdetail = jsondata.examdetail;

        });
    }
    $scope.addexamintable = function(temp)
    {
        var data = {
            sub_id: $scope.subject,
            subexamdate: temp.subjectexamDate,
            time: temp.time,
            duration: temp.timeduration
        }
        $scope.tempArrSubject.push(data);
    }

    $scope.savealldata = function()
    {
        var count = 0;
        $.each($scope.sectiondetaildata, function(key, value) {
            if (value.checked) {
                count++;
            }
        });
        if (count == $scope.sectiondetaildata.length)
        {
            $scope.section_type = 'ALL';
        }
        else {
            $scope.section_type = 'PARTIAL';
        }
        var myData = {
            sectionList: $scope.sectiondetaildata,
            sectionType: $scope.section_type,
            examData: $scope.examData,
            subjectList: $scope.tempArrSubject
        }
        if (confirm('Are you sure to publish this examdatesheet?'))
        {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/savealldata',
                data: 'data=' + encodeURIComponent(angular.toJson(myData)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(jsondata) {
                alert(jsondata.message);
            });
        }
        else {
            return false;
        }

    }
    
    $scope.removeRow = function(index){	
        $scope.tempArrSubject.splice(index, 1);	
    }
});