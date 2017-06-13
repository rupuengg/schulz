<?php

class event_model extends CI_Model {

    public function GetEventData($dataObj) {
        $curr_date = date('Y-m-d');
        $dbObj = $this->load->database($dataObj['database'], TRUE);
        $dbObj->select('name,on_date as event_date');
        $dbObj->order_by('on_date');
        $events = $dbObj->get_where('event_details', array('on_date >=' => $curr_date))->result_array();
        $eventArr = array();
        foreach ($events as $event) {
            if (!in_array($event['event_date'], array_column($eventArr, 'event_date'))) {
                $eventArr[] = array('event_date' => $event['event_date'], 'event_list' => array($event['name']));
            } else {
                $key = array_search($event['event_date'], array_column($eventArr, 'event_date'));
                $eventArr[$key]['event_list'][] = $event['name'];
            }
        }
        $upcmng_event = array('upcoming_events'=>$eventArr);
        return $upcmng_event;
    }

}
