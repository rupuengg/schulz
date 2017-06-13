<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style type="text/css">
            table{
            border-collapse: collapse;
            width: 100%;
            border: none;
        }
            td,th{
            font-size: 12px;
            /*padding: 2px;*/
        }
        .leftalign{
            text-align: left;
        }
        .rightalign{
            text-align: right;
        }
        .seperator { border-bottom: 1px solid black; }
        </style>
    </head>
    <body>
        <div style='width: 98%; padding: 0px 15px;'>
            <center>
                <span style="font-weight: bold; font-size: 20px;  "><?php echo $result['scoolname']['school_name']; ?></span>
                <br>
                <?php echo $result['scoolname']['school_address']; ?>
            </center>
            <table>
                <tr>
                    <td>BILL FOR YEAR 2016-2017</td>
                    <td></td>
                    <td  style="float: right">DATED 26/04/2016</td>
                </tr>
                <tr>
                    <td>ADDMISSION NO: <?php echo $result['stdntDetail']['adm_no']; ?></td>
                    <td>NAME: <?php echo $result['stdntDetail']['firstname'].' '. $result['stdntDetail']['lastname'];  ?></td>
                    <td style="float: right">Class: <?php echo $result['stdntDetail']['standard'].'-'. $result['stdntDetail']['section'];  ?></td>
                </tr>                
            </table>
            <hr>
            <span>ANNUAL CHARGES</span>
            <table>
                <?php   $sum = 0; foreach ($result['fee_stracture'] as $details) {  ?>
                <tr>
                    <td><?php echo $details['head_name']; ?></td>
                    <td style="float: right"><?php echo number_format($details['fee_amount'],2); ?></td>
                </tr>
                 <?php $sum = $sum + $details['fee_amount']; } ?>
               
                               
            </table>
            <hr>
            <table>
                <tr>
                    <td>TOTAL FEE</td>
                    <td style="float: right"><?php echo number_format($sum,2) ; ?></td>
                </tr>          
            </table>
            <hr>
            <span>THE AMOUNT TO BE PAID AS PER THE FOLLOWING SCHEDULED </span>
            <table>
                <thead class="seperator">
                    <tr>
                        <th class="leftalign">INSTALLMENT</th>
                        <th class="leftalign">TO BE PAID BETWEEN</th>
                        <th class="leftalign">AMOUNT</th>
                        <th class="leftalign">AMT.REC</th>
                        <th class="leftalign">RECORD ON</th>
                        <th class="leftalign">RECEIPT NO.</th>
                        <th class="leftalign">DOC.NO</th>
                        <th class="rightalign">AMT PAYABLE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result['instDeatil'] as $row) {  ?>
                    <tr>
                        <td style=""><?php echo $row['inst_name']; ?></td>
                        <td><?php echo  date('d M,Y',  strtotime($row['bill_raise_day'])).' - '.date('d M,Y', strtotime($row['bill_due_day'])); ?></td>
                        <td><?php echo $row['ist_amt']; ?></td>
                        <td>1200.00</td>
                        <td>04-Apr,2016</td>
                        <td>6035</td>
                        <td>12456</td>
                        <td class="rightalign"><?php echo number_format($row['ist_amt'],2); ?></td>
                    </tr>
                       <?php } ?>
                </tbody>
            </table>
            
             
            <hr>
              <table>
                <tr>
                    <td>TOTAL AMOUNT PAYABLE WITH THIS FEE</td>
                    <td style="float: right">2,500.00</td>
                </tr>          
            </table>
            <hr>
          
             <table>
                <tr>
                   <td>1. Payment through cheque /D.D in favour of mouunt carmel school</td>
                    </tr>       
            </table> 
             <table>
                <tr>
                   <td>1. Payment through cheque /D.D in favour of mouunt carmel school</td>
                    </tr>       
            </table> 
             <table>
                <tr>
                   <td>1. Payment through cheque /D.D in favour of mouunt carmel school</td>
                    </tr>       
            </table> 
             <table>
                <tr>
                   <td>1. Payment through cheque /D.D in favour of mouunt carmel school</td>
                    </tr>       
            </table> 
             
             
            
        </div>
        <div>
            

        </div>

    </body>
</html>
