<!DOCTYPE html>
<html>
    <head>
        <title>Primary Student Report Generation</title>
        <?php  //echo '<pre>'; print_r($reportCardData['part1']['term']);exit; ?>
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
                <td style="width:99%;height: 99%">
                    <table style="width:100%; height: 700px">
                        <tr>
                            <td valign="top" class="mainborder">
                                <table width="99%">
                                    <tr>
                                        <td>
                                            <header style="font-weight: bold;font-size:13px;">Part-I:Academic Performance:Scholastic Performance</header>
                                        </td>
                                    </tr>
                                </table>
                                <table width="99%">
                                    <tr>
                                        <td width="30%">
                                            <table style="width:99%;text-align:center;" border="1" class="allborder">
                                                <tr >
                                                    <th style="height:33px;" >Subjects</th>
                                                 </tr>
                                                
                                                <?php foreach ($reportCardData['part1']['subjectList'] as $row) { ?>
                                              
                                                    <tr>
                                                        <td><?php echo $row['subject_name']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </td>
                                        <?php foreach ($reportCardData['part1']['term'] as $row) { ?>
                                            <td width="35%">
                                                <table style="width:99%;text-align:center;" border="1" class="allborder">
                                                    <tr>
                                                        <th colspan="<?php echo count($row['examList']); ?>"><?php echo $row['term']; ?></th>
                                                    </tr>
                                                    <tr>
                                                        <?php foreach ($row['examList'] as $examVal) { ?>
                                                            <th><?php echo $examVal['exam_name']; ?></th>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php if(!empty($row['marksData'])) { foreach ($row['marksData'] as $gradeVal) {
                                                        ?>
                                                        <tr>
                                                            <?php if(!empty($gradeVal)) { foreach ($gradeVal as $val){ ?>
                                                            <td><?php if($val!='') { echo $val; } else { echo '-'; } ?></td>
                                                            <?php }  } else {  foreach ($row['examList'] as $val){ ?>
                                                             <td>-</td>
                                                            <?php }  } ?>
                                                        </tr>
                                                        <?php  } } 
                                                        else { ?>
                                                        <tr>
                                                             <?php foreach ($row['examList'] as $val){ ?>
                                                            <td>-</td>
                                                              <?php } ?>
                                                        </tr>
                                                        <?php }?>
                                                </table>
                                            </td>
                                        <?php }  ?>

                                        <td>
                                            <table style="width:99%; text-align:center;" border="1" class="allborder">
                                                <tr>
                                                    <th>Final Grades</th>
                                                </tr>
                                                <tr>
                                                    <td>B1</td>
                                                </tr>
                                                <tr>
                                                    <td>B1</td>
                                                </tr>
                                                <tr>
                                                    <td>B1</td>
                                                </tr>
                                                <tr>
                                                    <td>B1</td>
                                                </tr>
                                                <tr>
                                                    <td>B1</td>
                                                </tr>
                                                <tr>
                                                    <td>B1</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <table width="99%">
                                    <tr>
                                        <td width="38%">
                                            <table width="99%">
                                                <tr>
                                                    <td width="36%">
                                                        <table style="width:99%;text-align:center;" border="1" class="allborder">
                                                            <tr>
                                                                <th>.......</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Work Experience</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Art Education</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Physical Education</td>
                                                            </tr>

                                                        </table> 
                                                    </td>
                                                    <td width="70%">
                                                        <table style="width:99%;text-align:center;" border="1" class="allborder">
                                                            <tr>
                                                                <th>Grades</th>
                                                                <th>Descriptive Indicators</th>
                                                            </tr>
                                                            <tr>
                                                                <td>A</td>
                                                                <td>Student's Exhibit Innovative Ideas</td>
                                                            </tr>
                                                            <tr>
                                                                <td>A</td>
                                                                <td>Aesthetic Sensibilities</td>
                                                            </tr>
                                                            <tr>
                                                                <td>A+</td>
                                                                <td>An involvement in physical & Sports activities</td>
                                                            </tr>

                                                        </table> 
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td width="30%">
                                            <table width="94%">
                                                <tr>
                                                    <td width="36%">
                                                        <table style="width:99%;text-align:center;" border="1" class="allborder">
                                                            <tr>
                                                                <th colspan="2">Assessments of Speaking and listening skills in English</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Term-1</td>
                                                                <td>B1</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Term-2</td>
                                                                <td>B1</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Final</td>
                                                                <td>B1</td>
                                                            </tr>
                                                        </table> 
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <?php foreach ($reportCardData['part2'] as $row) { ?>
                                    <table width="99%">
                                        <tr>
                                            <td>
                                                <header style="font-weight: bold;font-size:13px;"><?php echo $row['part']. $row['title']; ?></header>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="56%">
                                        <tr>
                                            <td width="38%">
                                                <table width="99%">
                                                    <tr>
                                                        <td width="35%">
                                                            <table style="width:99%;text-align:center;" border="1" class="allborder">
                                                                <tr>
                                                                    <th>.......</th>
                                                                </tr>
                                                                <?php foreach ($row['details'] as $childRow) { ?>
                                                                    <tr>
                                                                        <td><?php echo $childRow['caption']; ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </table> 
                                                        </td>
                                                        <td width="50%">
                                                            <table style="width:84%;text-align:center;" border="1" class="allborder">
                                                                <tr>
                                                                    <th>Grades</th>
                                                                    <th>Descriptive Indicators</th>
                                                                </tr>
                                                                <?php foreach ($row['details'] as $childRow) { ?>
                                                                    <tr>
                                                                        <td><?php if($childRow['grade']!=null) {  echo $childRow['grade']; } else {echo '-'; }; ?></td>
                                                                        <td><?php if($childRow['di']!=null) {  echo $childRow['di']; } else {echo '-'; }; ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </table> 
                                                        </td>

                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                <?php } $padding=160; $count=0;foreach ($reportCardData['part3'] as $row) {  if($count>0){if($padding==$padding ){
                                    $padding=$padding+80;
                                    } }?>
                                    <table width="99%">
                                        <tr>
                                            <td>
                                                <header style="font-weight: bold;font-size:13px;float: right;margin-top: -464px;position: relative;padding-top: <?php echo $padding; ?>px"><span style="text-align:center"><?php echo $row['part']. $row['title']; ?></span></header>
                                            </td>
                                        </tr>
                                    </table>
                                <table width="56%" style="float: right;margin-right: -79px;margin-top: -450px;padding-top: <?php echo $padding; ?>px">
                                        <tr>
                                            <td width="38%">
                                                <table width="99%">
                                                    <tr>
                                                        <td width="35%">
                                                            <table style="width:99%;text-align:center;" border="1" class="allborder">
                                                                <tr>
                                                                    <th>.......</th>
                                                                </tr>                                                               
                                                                <?php foreach ($row['details'] as $childRow) { ?>
                                                                    <tr>
                                                                        <td><?php echo $childRow['caption']; ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </table> 
                                                        </td>
                                                        <td width="64%">
                                                            <table style="width:84%;text-align:center;" border="1" class="allborder">
                                                                <tr>
                                                                    <th>Grades</th>
                                                                    <th>Descriptive Indicators</th>
                                                                </tr>
                                                                <?php foreach ($row['details'] as $childRow) { ?>
                                                                    <tr>
                                                                        <td><?php if($childRow['grade']!=null) {  echo $childRow['grade']; } else {echo '-'; }; ?></td>
                                                                        <td><?php if($childRow['di']!=null) {  echo $childRow['di']; } else {echo '-'; }; ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </table> 
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                <?php $count++; } ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        <center><a  href="<?php echo base_url() . "index.php/staff/primarycard/".$data['adm_no']."/".$data['section_id']."/".$data['school_code'] ?>">Previous</a></center>
</body>
</html>

