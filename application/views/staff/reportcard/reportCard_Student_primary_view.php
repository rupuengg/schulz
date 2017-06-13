<!DOCTYPE html>
<html>
    <head>
        <title>Primary Student Report Generation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            table1{
                border-collapse: collapse;
                width: 100%;
                border: none;
            }
            td,th{
                font-size: 10px;
            }
            .maintableborder{
                border-collapse: solid;
                width: 100%;
                border: none;
            }
            mycell{
                width:30px;
            }
            .centeralign{
                text-align: center;
            }
            .tablelabel{
                width: 30px;
            }
            .allborder{
                border-collapse: collapse;
                border: 1px solid #000;
            }
            .mainborder{
                border-collapse: collapse;
                border: 2px solid #000;
            }
            .boldtext{
                text: bold;
            }
        </style>
    </head>

    <body>

        <!--<header style="text-align: center; font-weight: bold; text-decoration: underline;">SESSION 2014-15</header>-->
        <table style="width:99%">
            <tr>
                <td style="width:50%;height: 99%">
                    <table style="width:99%; height: 700px">
                        <tr>
                            <td valign="top" class="mainborder">
                                <table style="width:99%">
                                    <tr>
                                        <td style="width:50%;text-align: center">
                                            <header style="font-weight: bold; text-decoration: underline;">Scholastic Areas</br>(Grading on 9 point scale)</header>
                                            <table class="allborder" border="1" align="center" style="width:80%;">
                                                <tr>
                                                    <th>Grades</th>
                                                    <th>Marks Range</th>
                                                    <th>Grades Point</th>
                                                </tr>
                                                <?php foreach ($primary['marksGrade'] as $row) { ?>
                                                    <tr>
                                                        <th><?php echo $row['grade']; ?></th>
                                                        <th><?php echo $row['marks_range']; ?></th>
                                                        <th><?php echo $row['grade_point']; ?></th>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </td>
                                        <td style="width:50%;text-align: center" valign="top">
                                            <header style="font-weight: bold; text-decoration: underline;">Co-Scholastic Areas</br>(Grading on 5 point scale)</header>
                                            <table class="allborder" border="1" align="center" style="width:80%;">
                                                <tr>
                                                    <th>Grades</th>
                                                    <th>Grades Point</th>
                                                </tr>
                                                <tr>
                                                    <td>A</td>
                                                    <td>4.1-5.0</td>
                                                </tr>
                                                <tr>
                                                    <td>B</td>
                                                    <td>3.1-4.0</td>
                                                </tr>
                                                <tr>
                                                    <td>C</td>
                                                    <td>2.1-3.0</td>
                                                </tr>
                                                <tr>
                                                    <td>D</td>
                                                    <td>1.1-2.0</td>
                                                </tr>
                                                <tr>
                                                    <td>E</td>
                                                    <td>0-1.0</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <table style="width:100%">
                                    <tr >
                                        <td style="width:100%;" id="container">

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width:50%;height: 99%">
                    <table style="width:99%; height: 700px">
                        <tr>
                            <td valign="top" class="mainborder">
                                <table style="padding-top: 15px;width:99%">
                                    <tr>
                                        <td style="width:99%;text-align: center">
                                            <img src="<?php echo base_url() . $primary['schoolData']['brand_logo_path']; ?>" width="200px" height="80px"/>
                                        </td>
                                    </tr>
                                </table>
                                <table style="width:99%">
                                    <tr>
                                        <td style="width:99%;padding-top:10px;">
                                            <header style="text-decoration: underline;font-weight: bold;text-align:center;font-size:20px;"><?php echo $primary['schoolData']['school_name']; ?></header>
                                            <table align="left" style="padding-left:50px;width:99%;">
                                                <tr>
                                                    <td style="padding-top: 20px">Affiliation No:<?php echo $primary['schoolData']['school_affiliation_no']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Complete Address:<?php echo $primary['schoolData']['school_address']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Email Id:<?php echo $primary['schoolData']['email_id']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Phone No:<?php echo $primary['schoolData']['school_phone']; ?></td>
                                                </tr>
                                            </table>
                                            <header style="font-weight: bold;text-align:center;font-size:15px;">Class- <?php echo $primary['stuData']['standard']; ?></br>Session: <?php echo $primary['schoolData']['school_session']; ?></header>
                                            <table align="left" style="padding-left:50px;width:99%;">
                                                <tr style="padding-top: 20px">
                                                    <td>Name: <?php echo $primary['stuData']['firstname'] . ' ' . $primary['stuData']['lastname']; ?></td>
                                                    <td>Class: <?php echo $primary['stuData']['standard'] . '(' . $primary['stuData']['section'] . ')'; ?></td>
                                                    <td>House: <?php echo $primary['stuData']['house']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Admission No: <?php echo $primary['stuData']['adm_no']; ?></td>
                                                    <td>Date of Birth: <?php echo date('jS F, Y', strtotime($primary['stuData']['dob_date'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">Residential Address:  <?php echo $primary['stuData']['address1'] . $primary['stuData']['address2'] . ',' . $primary['stuData']['city']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Board Registration No: ______________</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Mother's Name: <?php echo $primary['stuData']['father']['g_name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Father's Name: <?php echo $primary['stuData']['mother']['g_name']; ?></td>
                                                </tr>
                                            </table>
                                            <!--<header style="padding-left:50px;text-decoration: underline;font-weight: bold;text-align:left;font-size:12px;">Health Status</header>-->
                                            <table align="left" style="padding-left:50px;width:99%;">
                                                <tr>
                                                    <th style="text-align: left;font-size:14px;padding-top: 20px">Health</th>
                                                </tr>
                                                <tr>
                                                    <td>Height: <?php echo $primary['stuData']['medicalDetail']['height']; ?></td>
                                                    <td>Weight: <?php echo $primary['stuData']['medicalDetail']['weight']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Blood Group: <?php echo $primary['stuData']['medicalDetail']['blood_group']; ?></td>
                                                    <td>Vision(L): <?php echo $primary['stuData']['medicalDetail']['vision_left']; ?>/6</td>
                                                    <td>Vision(R): <?php echo $primary['stuData']['medicalDetail']['vision_right']; ?>/6</td>
                                                </tr>
                                                <tr>
                                                    <td>Teeth: Good Dental Hygiene</td>
                                                    <td>Oral Hygiene:<?php echo $primary['stuData']['medicalDetail']['hygiene']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Specific Ailments,if any:</td>
                                                </tr>
                                            </table>
                                            <table align="left" style="padding-left:50px;width:99%;">
                                                <tr>
                                                    <th style="text-align: left;font-size:14px;padding-top: 10px">Attendance</th>
                                                    <th style="padding-top: 10px">Term-I</th>
                                                    <th style="padding-top: 10px">Term-II</th>
                                                </tr>
                                                <tr>
                                                    <td>Total Attendance of the Student</td>
                                                    <td align="center"><?php echo $primary['attData']['TERM1']['studentattendnc']; ?></td>
                                                    <td align="center"><?php echo $primary['attData']['TERM2']['studentattendnc']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Working Days</td>
                                                    <td align="center"><?php echo $primary['attData']['TERM1']['totattndnc']; ?></td>
                                                    <td align="center"><?php echo $primary['attData']['TERM2']['totattndnc']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left;font-size:14px;padding-top: 85px">Class Teacher: <?php echo $primary['cls_tech_name']; ?></td>
                                                    <td style="text-align: right;font-size:14px;padding-top: 85px">Principal:  <?php echo $primary['princi']; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
    <center><a href="<?php echo base_url() . "index.php/staff/secondrycard/" . $primary['stuData']['adm_no'] . "/" . $primary['stuData']['section_id'] . "/" . $school_code ?>">Next</a></center>
    <?php
    $this->load->view('include_parent/headjs');
    ?>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <script>
        $(function () {
            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Performance Analysis',
                    enabled: false
                },
                subtitle: {
                    enabled: false
                },
                xAxis: {
                    categories: ['English', 'Math', 'Computer', 'Science', 'Hindi'],
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
                        text: 'Performance Analysis'
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
                        data: [70, 85, 85, 82, 67]

                    }, {
                        color: '#0000FF',
                        name: 'Highest',
                        data: [90, 95, 99, 96, 99]

                    }, {
                        color: '#FF0000',
                        name: 'Average',
                        data: [60, 69, 75, 80, 73]

                    }]
            });
        });/* graph data end*/
    </script>
</body>
</html>

