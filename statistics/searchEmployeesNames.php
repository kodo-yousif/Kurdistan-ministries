<?php

require '../db.php';
require '../secure.php';

if (!($_SESSION['type'] == "p" || $_SESSION['type'] == "m" || ($_SESSION['type'] == "e" && $_SESSION['level'] == "2"))) {
    header("location: ../index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['name'])) {

    $name = $k->real_escape_string($_POST['name']);

    if ($_SESSION['type'] == "p") {

        $res = $k->query(" SELECT 
        (t2.start_salary + if(t1.married = 'yes', t2.married_bones , 0 ) + (t1.kids * t2.per_kid) +
        (t1.bones + t2.bones ) + (t1.level*t2.per_level) + (t2.per_month * TIMESTAMPDIFF(MONTH, t1.created_date ,CURRENT_TIMESTAMP ))+
        if(t1.zone_id = t3.zone_id , 0 , t2.outside_zone) ) as 'next',
        t1.name , t1.id , t2.name job_name 
        FROM employees t1  join 
        building t3 join
        jobs t2 WHERE 
        t3.id = t1.building_id and 
        t1.name like '%$name%' and
        t1.job_id = t2.id 
        limit 20;");
    } else if ($_SESSION['type'] == "m") {
        $tempId = $_SESSION['id'];
        $res = $k->query("SELECT (t2.start_salary + if(t1.married = 'yes', t2.married_bones , 0 ) + (t1.kids * t2.per_kid) +
        (t1.bones + t2.bones ) + (t1.level*t2.per_level) + (t2.per_month * TIMESTAMPDIFF(MONTH, t1.created_date ,CURRENT_TIMESTAMP ))+
        if(t1.zone_id = t3.zone_id , 0 , t2.outside_zone) ) as 'next', t1.name , t1.id , t2.name job_name FROM employees t1  join building t3 join jobs t2 WHERE t3.id = t1.building_id and t1.name like '%$name%' and t1.job_id = t2.id and t2.ministry_id in(select id from ministry where minister_id ='$tempId') limit 20;");
    } else if ($_SESSION['type'] == "e" && $_SESSION['level'] == "2") {
        $build_id_s = $_SESSION['building'];
        $res = $k->query("SELECT (t2.start_salary + if(t1.married = 'yes', t2.married_bones , 0 ) + (t1.kids * t2.per_kid) +
    (t1.bones + t2.bones ) + (t1.level*t2.per_level) + (t2.per_month * TIMESTAMPDIFF(MONTH, t1.created_date ,CURRENT_TIMESTAMP ))+
    if(t1.zone_id = t3.zone_id , 0 , t2.outside_zone) ) as 'next', t1.name , t1.id , t2.name job_name FROM 
    employees t1 join jobs t2 join building t3
    WHERE t1.job_id = t2.id and t1.name like '%$name%' and t3.id = t1.building_id and t1.building_id = '$build_id_s'
    limit 20;");
    }

    $counter = 1;
    $html = "";
    while ($oneRow = $res->fetch_assoc()) {
        $id = $oneRow['id'];
        $name = $oneRow['name'];
        $job_name = $oneRow['job_name'];
        $next = number_format($oneRow['next']);
        $html .= "
        <tr>
        <td>$name</td>
        <td>$job_name</td>
        <td>$next</td>
        <td><button onclick=\"window.location.href = '../employees/employeesUpdate.php?id=$id';\" class=\"btn btn-primary btn-sm\">Detail</button></td>
    </tr>
    ";
    }

    header('Content-Type: application/json');
    echo json_encode(array("m" => $html, "error" => FALSE));
    exit();
} else {
    send_error("there is no name.");
}

function send_error($message)
{
    header('Content-Type: application/json');
    echo json_encode(array("m" => $message, "error" => TRUE));
    exit();
}
require "../end.php";
