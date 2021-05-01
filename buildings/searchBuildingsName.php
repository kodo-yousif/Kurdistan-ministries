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
        $res = $k->query("SELECT t1.id 'id' , t1.name 'building_name' , t2.name 'ministry_name' from building t1 join ministry t2 where t1.ministry_id = t2.id and t1.name like '%$name%';");
    } else {
        $tempV = $_SESSION['id'];
        $res = $k->query("SELECT t1.id 'id' , t1.name 'building_name' , t2.name 'ministry_name' from building t1 join ministry t2 where t2.minister_id = '$tempV' and t1.ministry_id = t2.id and t1.name like '%$name%';");
    }
    $counter = 1;
    $html = "";
    while ($oneRow = $res->fetch_assoc()) {
        $id = $oneRow['id'];
        $name = $oneRow['building_name'];
        $ministry_name = $oneRow['ministry_name'];
        $html .= "<tr>
        <td>$counter</td>
        <td>$name</td>
        <td> $ministry_name</td>
        <td><button onclick=\"window.location.href = 'buildingUpdate.php?id=$id';\" class=\"btn btn-primary btn-sm\">Detail</button></td>
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
