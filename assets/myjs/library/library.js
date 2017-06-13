var app = angular.module('librarySystem', ['lms_myangucomplete', '720kb.datepicker']);
app.controller('librarySystemController', function ($scope, $http) {

    $http({
        method: 'POST',
        url: myURL + 'index.php/staff/viewbooks',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.bookdata = jsondata;
    });

    $scope.savebook = function (bookdetails) {
        if (confirm('Are you sure, you want to save ?')) {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/savebook',
                data: 'data=' + encodeURIComponent(angular.toJson(bookdetails)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}

            }).success(function (jsondata) {
                alert(jsondata.message);
                window.location = self.location;
            });
        }
    }


    $scope.update = function (book_id, quantity, update_date, reason) {
        if ($scope.addquantity == 0)
        {
            var updatequantity = '-' + quantity;
        }
        else {
            var updatequantity = quantity;
        }
        var data = {
            book_id: book_id,
            quantity: updatequantity,
            update_date: update_date,
            reason: reason
        }
        
        var mydate = update_date.split("-");
        var pushdate = mydate[2] + '-' + mydate[1] + '-' + mydate[0];
        var mypushdata = {book_id: book_id,
            quantity: updatequantity,
            date: pushdate,
            }
        
        
        if (confirm('Are you sure, you want save changes?')) {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/update',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                alert(jsondata.message);
                $scope.book.originalObject.searchdata.push(mypushdata);
                
            });
        }

    }
});

var app1 = angular.module('IssueBook', [])
        .controller('IssueBookController', function ($scope, $http) {
          
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/recentissuebook',
                data: '',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.issuebookdata = jsondata;
            });

            $scope.bookdata = function (bookno) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/bookdata',
                    data: 'data=' + encodeURIComponent(angular.toJson(bookno)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.bookdetail = jsondata;
                });
            }
            $scope.studentdata = function (admission_no) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/studentdata',
                    data: 'data=' + encodeURIComponent(angular.toJson(admission_no)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.studentdetail = jsondata;
                });
            }
            $scope.issuebook = function () {
                var data = {
                    studentadm_no: $scope.studentdetail.adm_no,
                    bookid: $scope.bookdetail.book_no
                }
                if (confirm('Are you sure, you want to issue this book?')) {
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/staff/issuedata',
                        data: 'data=' + encodeURIComponent(angular.toJson(data)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        alert(jsondata.message);
                        window.location = self.location;
                    });
                }
            }
        });

var app = angular.module('ReturnBook', [])
        .controller('ReturnBookController', function ($scope, $http) {
            $scope.bookinfo = '';
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/recentlyreturn',
                data: '',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.recentlyissuedbook = jsondata;
            });

            $scope.studentinfo = function (admno) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/studentinfo',
                    data: 'data=' + encodeURIComponent(angular.toJson(admno)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.bookinfo = jsondata.studentdetail;
                    $scope.finedetail = jsondata.finedetail;
                });
            }
            if (StudentData != null && FineData != null) {
                if (adm_no == -1) {
                    $scope.admno = '';
                }
                else {
                    $scope.admno = adm_no;
                }
                $scope.studentinfo($scope.admno);
            }
            $scope.returnbook = function (bookdetail) {
                $scope.returndiv = 'true';
                $scope.mybookdetail = bookdetail;
                $scope.mybookdetail.extraamount = 0;
                $scope.mybookdetail.reason = '';

            }

            $scope.savechangebook = function () {
                var data = {
                    returndata: $scope.mybookdetail,
                    adm_no: $scope.admno

                }
                if (confirm('Are you sure, you want to save changes?')) {
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/staff/savechangebook',
                        data: 'data=' + encodeURIComponent(angular.toJson(data)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        alert(jsondata.message);
                        window.location = self.location;
                    });
                }
            }
        });

var app = angular.module('FineSettings', [])
        .controller('FineSettingsController', function ($scope, $http) {

            $scope.fine = '';
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/fineinfo',
                data: '',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata == -1) {
                    $scope.fine.due_days = '';
                    $scope.fine.fine_per_day = '';
                } else {
                    $scope.fine = jsondata;
                }

            });
            $scope.savefinedata = function () {
                if (confirm('Are you sure, you want to save this fine setting?')) {
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/staff/finedata',
                        data: 'data=' + encodeURIComponent(angular.toJson($scope.fine)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        alert(jsondata.message);
                    });
                }
            }
        });