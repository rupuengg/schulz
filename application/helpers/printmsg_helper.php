<?php

function printCustomMsg($type, $msg = null, $value = -1) {
    $array = array();
    if ($msg == null) {
        switch ($type) {
            case "TRUE":
                $array['message'] = "Data Load Successfully";
                $array['result'] = "TRUE";
                break;
            case "TRUESAVE":
                $array['message'] = "Data Save Successfully";
                $array['result'] = "TRUE";
                break;
            case "TRUEUPDATE":
                $array['message'] = "Data Updated Successfully";
                $array['result'] = "TRUE";
                break;
            case "ERRLOAD":
                $array['message'] = "Problem in Data Load ";
                $array['result'] = "ERR";
                break;
            case "ERRINPUT":
                $array['message'] = "Problem in Input please contact to admin";
                $array['result'] = "ERR";
                break;
            case "TRUESAVEERR":
                $array['message'] = "Data Not Save Successfully";
                $array['result'] = "ERR";
                break;

            default:
                break;
        }
    } else {
        $array['type'] = $type;
        $array['message'] = $msg;
        $array['result'] = $type;
    }
    $array['value'] = $value;
    return json_encode($array);
}

function changedateformate($date) {
    if ($date == "" || $date == "0000-00-00") {
        return $date;
    } else {
        $date_arr = explode("-", $date);
        $date_time = $date_arr[2] . "-" . $date_arr[1] . "-" . $date_arr[0];
        // $date_time = date("Y-m-d", mktime(0, 0, 0, $date_arr[1], $date_arr[0], $date_arr[2]));
        //$date_time=mktime(0, 0, 0, $date_arr[0], $date_arr[1], $date_arr[2]);
        return $date_time;
    }
}

// function array_column($records, $key) {
//     $myTempArr = array();
//     foreach ($records as $value) {
//         $myTempArr[] = $value[$key];
//     }
//     return $myTempArr;
// }

function ChangeMydateFormat($myDate) {
    return date('jS M,Y', strtotime($myDate));
}


function curl_browse($url, $POSTVARS = array()){
   $user_agent = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/51.0.2704.79 Chrome/51.0.2704.79 Safari/537.36";
   $ch = curl_init($url);
   if(!empty($POSTVARS)){
       curl_setopt($ch, CURLOPT_POST ,true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($POSTVARS));
   }

   curl_setopt($ch, CURLOPT_USERAGENT, $user_agent); 
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);

   curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);  // RETURN THE CONTENTS OF THE CALL
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   $Rec_Data = curl_exec($ch);
   curl_close($ch);
   return $Rec_Data;
}

function convertHtmlToPdf($url){
   return  "http://FreeHTMLtoPDF.com/?convert=$url&action=save&orientation=landscape";
}