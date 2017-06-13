<?php

function removesubjectothergroups($primary, $xcrud) {
    $db = Xcrud_db::get_instance();
    $query1 = 'delete from subject_staff_relation where subject_id=' . $db->escape($primary);
    $query2 = 'delete from combo_subject_relation where subject_id=' . $db->escape($primary);
    $query3 = 'delete from student_subject_relation where subject_id=' . $db->escape($primary);
    $db->query($query1);
    $db->query($query2);
    $db->query($query3);
}

function getstaffname($staff_id) {
    $db = Xcrud_db::get_instance();
    $query = 'SELECT `staff_fname`,`staff_lname` FROM `staff_details` WHERE id=' . $staff_id;
    $db->query($query);
    $result = $db->result();
    if (count($result) > 0) {
        return ($result[0]['staff_fname'] . ' ' . $result[0]['staff_lname']);
    } else {
        return 'NA';
    }
}

function checkclassteacherfirst($postdata, $primary, $xcrud) {

    $classteacherid = $postdata->get('class_teacher_id');
    $db = Xcrud_db::get_instance();
    $query = 'SELECT `id`,`standard`,`section` FROM `section_list` WHERE class_teacher_id=' . $classteacherid;
    $db->query($query);
    $result = $db->result();
    if (count($result) > 0) {
        $classs = $result[0]['standard'] . ' ' . $result[0]['section'];
        $str = getstaffname($classteacherid) . ' is already a class teacher of class ' . $classs . '. Please select any other teacher.';

        $xcrud->set_exception('class_teacher_id', $str, 'error');
    }
}

function myBeforeInsrtmsg($postdata, $xcrud) {
    $stop_name = $postdata->get('stop_name');
    if ($stop_name === '') {
        $str = 'Please enter Stop name....!! ';
        $xcrud->set_exception('stop_name', $str, 'error');
    }
}
