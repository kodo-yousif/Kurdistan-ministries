<?php

require '../db.php';
require '../secure.php';

if (!($_SESSION['type'] == "p" || $_SESSION['type'] == "m")) {
    header("location: ../index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['name'])) {

    $name = $k->real_escape_string($_POST['name']);

    if ($_SESSION['type'] == "p") {
        $res = $k->query("SELECT
        t3.name as building_name,
        t5.name as ministry_name ,
        SUM(
            t2.start_salary + 
            if( t1.married = 'yes', t2.married_bones , 0 ) + (t1.kids * t2.per_kid) + (t1.bones + t2.bones ) +
            (t1.level*t2.per_level) + (t2.per_month * TIMESTAMPDIFF(MONTH, t1.created_date ,CURRENT_TIMESTAMP ))+
            if(t1.zone_id = t3.zone_id , 0 , t2.outside_zone)  
        ) as salary
        FROM 
        employees t1 join 
        jobs t2 join 
        building t3 join 
        zone t4 join 
        ministry t5  
            WHERE 
            t1.job_id = t2.id and
            t1.building_id = t3.id and
            t1.zone_id = t4.id and
            t3.ministry_id = t5.id and 
            t3.name like '%$name%'
            group by t4.id
             limit 20;");
    } else {
        $tempV = $_SESSION['id'];
        $res = $k->query("SELECT
        t3.name as building_name,
        t5.name as ministry_name ,
        SUM(
            t2.start_salary + 
            if( t1.married = 'yes', t2.married_bones , 0 ) + (t1.kids * t2.per_kid) + (t1.bones + t2.bones ) + 			(t1.level*t2.per_level) + (t2.per_month * TIMESTAMPDIFF(MONTH, t1.created_date ,CURRENT_TIMESTAMP ))+ 		if(t1.zone_id = t3.zone_id , 0 , t2.outside_zone)  
        ) as salary
        FROM 
        employees t1 join 
        jobs t2 join 
        building t3 join 
        zone t4 join 
        ministry t5  
            WHERE 
            t1.job_id = t2.id and
            t1.building_id = t3.id and
            t1.zone_id = t4.id and
            t3.ministry_id = t5.id and 
            t5.minister_id = '$tempV' and 
            t3.name like '%$name%'
            group by t4.id
             limit 20;");
    }
    $counter = 1;
    $html = "";
    while ($oneRow = $res->fetch_assoc()) {

        $name = $oneRow['building_name'];
        $ministry_name = $oneRow['ministry_name'];

        $salary = number_format($oneRow['salary']);

        $html .= "<tr>
        <td>$counter</td>
        <td>$name</td>
        <td> $ministry_name</td>
        <td>$salary</td>
    </tr>";

        $counter++;
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
