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
        $res = $k->query("select t1.id 'id' , t1.name 'name', t2.name 'ministry_name' from jobs t1 join ministry t2 where t1.name like '%$name%' and t1.ministry_id = t2.id;");
    } else if ($_SESSION['type'] == "m") {
        $tempId = $_SESSION['id'];
        $res = $k->query("select t1.id 'id' , t1.name 'name', t2.name 'ministry_name' from jobs t1 join ministry t2 where t1.name like '%$name%' and t1.ministry_id = t2.id and t2.minister_id = '$tempId' ;");
    }

    $counter = 1;
    $html = "";
    while ($oneRow = $res->fetch_assoc()) {
        $id = $oneRow['id'];
        $name = $oneRow['name'];
        $ministry_name = $oneRow['ministry_name'];
        $html .= "<tr>
        <td>$counter</td>
        <td>$name</td>
        <td> $ministry_name</td>
        <td><button onclick=\"window.location.href = 'jobsUpdate.php?id=$id';\" class=\"btn btn-primary btn-sm\">Detail</button></td>
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
