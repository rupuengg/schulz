var graphData = '';
var app = angular.module('academics', ['blockUI']);
app.controller('academicsController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {

        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/loadmarks',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.marksData = jsondata;

            $http({
                method: 'POST',
                url: myURL + 'index.php/parent/getgraphdetail',
                data: '',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                graphData = jsondata;

                $(function () {
                    $('#container').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Marks Obtained',
                            enabled: false
                        },
                        subtitle: {
                            enabled: false
                        },
                        xAxis: {
                            categories: graphData.subject_list,
                            crosshair: true
                        },
                        credits: {
                            enabled: false
                        },
                        exporting: {
                            enabled: false
                        },
                        yAxis: {
                            min: 0,
                            max: 100,
                            title: {
                                text: 'Marks Obtained'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.1,
                                borderWidth: 0
                            }
                        },
                        series: [{
                                color: '#01DF01',
                                name: 'Obtained',
                                data: graphData.obtain_marks

                            }, {
                                color: '#0000FF',
                                name: 'Highest',
                                data: graphData.max_marks

                            }, {
                                color: '#FF0000',
                                name: 'Average',
                                data: graphData.avg_marks

                            }]
                    });
                });

            });
        });

    }]);

