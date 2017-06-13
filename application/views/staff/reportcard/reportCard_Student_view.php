
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <title>Student Report Generation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            table{
                border-collapse: collapse;
                width: 100%;
                border: none;
            }
            td,th{
                font-size: 12px;
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
            .boldtext{
                text: bold;
            }
        </style>
    </head>
    <body>
       
        <header style="text-align: center; font-weight: bold; text-decoration: underline;">SESSION <?php echo $primary['schoolData']['school_session']; ?></header>
        <table style="width:99%">
            <tr>
                <td width="37%">
                    <table>
                        <tr>
                            <td>Student's Name: <?php echo $primary['stuData']['firstname'] . ' ' . $primary['stuData']['lastname']; ?></td>

                        </tr>
                        <tr>
                            <td>Class: <?php echo $primary['stuData']['standard'] . '(' . $primary['stuData']['section'] . ')'; ?></td>


                        </tr>
                        <tr>
                            <td>Admission no: <?php echo $primary['stuData']['adm_no']; ?></td>

                        </tr>
                        <tr>
                            <td>DOB: <?php echo date('jS F, Y', strtotime($primary['stuData']['dob_date'])); ?></td>

                        </tr>
                    </table>
                </td>
                <td width="43%">
                    <table>
                        <tr>
                            <td>Father's Name: <?php echo $primary['stuData']['father']['g_name']; ?></td>
                        </tr>
                        <tr>
                            <td>Mother's Name: <?php echo $primary['stuData']['mother']['g_name']; ?></td>
                        </tr>
                        <tr>
                            <td>Address: <?php echo $primary['stuData']['address1'] . $primary['stuData']['address2'] . ', ' . $primary['stuData']['city']; ?></td>
                        </tr>
                        <tr>
                            <td>Phone no: <?php echo $primary['stuData']['mobile_no_for_sms']; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="500px" valign="top">
                    <table style='width: 99%;'>
                        <tr>
                            <td>
                                <table border='1' class="allborder">
                                    <tr>
                                        <th>Personality Profile</th>
                                        <th style="width:55px;">Mid Terms</th>
                                        <th style="width:55px;">Final Terms</th>
                                    </tr>
                                    <?php foreach ($primary['cce'] as $grade) { ?>
                                        <tr>
                                            <td><?php echo $grade['caption']; ?></td>
                                            <td class="centeralign"><?php echo $grade['grade']; ?></td>
                                            <td class="centeralign"><?php
                                                echo $grade['grade'];
                                            }
                                            ?></td>

                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table border='1' class="allborder">
                                    <tr>
                                        <td style="width:183px;">Attendance</td>
                                        <td class="centeralign" colspan="2">(<?php
                                            $stuatt = $primary['attData']['TERM1']['studentattendnc'] + $primary['attData']['TERM2']['studentattendnc'];
                                            $totatt = $primary['attData']['TERM1']['totattndnc'] + $primary['attData']['TERM2']['totattndnc'];
                                            echo $primary['attData']['TERM1']['studentattendnc'] + $primary['attData']['TERM2']['studentattendnc'];
                                            ?>/<?php echo $primary['attData']['TERM1']['totattndnc'] + $primary['attData']['TERM2']['totattndnc']; ?>) <?php echo number_format(($stuatt / $totatt) * 100, 2); ?>%</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table border='1' class="allborder">
                                    <tr>
                                        <th colspan="2">Remarks</th>
                                    </tr>
                                    <tr>
                                        <td>Half-Yearly</td>
                                        <td style="width:250px;"></td>
                                    </tr>
                                    <tr>
                                        <td>Final Exam</td>
                                        <td style="width:250px;"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table border='1' class="allborder">
                                    <tr>
                                        <th colspan="6">Supplementry</th>
                                    </tr>
                                    <tr>
                                        <th class="tablelabel">S.no</th>
                                        <th style="width:140px;">Subject</th>
                                        <th>Marks</th>
                                        <th>35%</th>
                                        <th>60%</th>
                                        <th>100%</th>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td  valign="top">
                    <table style = "width: 99%;">
                        <tr>
                            <td>
                                <table border='1' class="allborder">

                                    <tr>
                                        <th rowspan="2">Subjects</th>
                                        <?php foreach ($primary['term'][0]['examList'] as $exam) { ?>
                                            <th colspan="<?php if(isset($exam['part'])) { echo count($exam['part']); } ?>" ><?php
                                                echo $exam['exam_name'];
                                            }
                                            ?></th>
                                        <th rowspan="2">Total</th>
                                    </tr>
                                    <tr class="centeralign">
                                        <?php
                                        foreach ($primary['term'][0]['examList'] as $ename) {
                                           if(isset($ename['part'])) { foreach ($ename['part'] as $pname) {
                                                ?>
                                                <th><?php
                                                    echo $pname['part_name'];
                                                }
                                        } }
                                            ?></th>
                                    </tr>
                                    <?php foreach ($primary['subjectlist'] as $row => $key) { ?>
                                        <tr class="centeralign">

                                            <td ><?php echo $key['subject_name']; ?></td>
                                            <?php
                                            $sum = 0;
                                            if(!empty($primary['term'][0]['marksData'][$row])){
                                            foreach ($primary['term'][0]['marksData'][$row] as $val) {
                                                ?>
                                                <td ><?php
                                                    echo $val;
                                                    $sum = $sum + $val;
                                                    ?></td>
                                            <?php }  } else { foreach ($primary['term'][0]['examList'] as $ename) { ?>
                                                <td >-</td>
                                                 <?php }  } ?>
                                            <td><b><?php echo $sum; ?></b></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                    </table>
            <center> <img src="<?php echo base_url(); ?>/assets/img/graphimported.jpg" alt="No Image Uploaded Yet" width="600px" height="300px"/></center>
        </td>
    </tr>
</table> 
</body>
</html>

