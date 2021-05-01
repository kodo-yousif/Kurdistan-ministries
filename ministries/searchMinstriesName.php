<?php

require '../db.php';
require '../secure.php';

if (!($_SESSION['type'] == "p" || $_SESSION['type'] == "m")) {
    header("location: ../index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['name']) && strlen($_POST['name']) !== 0) {

    $name = $k->real_escape_string($_POST['name']);

    if ($_SESSION['type'] == "p") {
        $res = $k->query("select ministry.id as 'id' ,ministry.name as 'ministry_name', minister.name as 'minister_name' from ministry join minister where minister.id = ministry.minister_id and ministry.name like '%$name%';");
    } else {
        $tempId = $_SESSION['id'];
        $res = $k->query("select ministry.id as 'id' ,ministry.name as 'ministry_name', minister.name as 'minister_name' from ministry join minister where minister.id = ministry.minister_id and ministry.minister_id = '$tempId' and ministry.name like '%$name%';");
    }




    $counter = 1;
    $html = "";
    while ($oneRow = $res->fetch_assoc()) {
        $id = $oneRow['id'];
        $ministry_name = $oneRow['ministry_name'];
        $minister_name = $oneRow['minister_name'];
        $html .= "<tr id=\"rowId-$id\">
    <td>$ministry_name</td>
    <td>$minister_name</td>
    <td><button onclick=\"window.location.href = 'ministryUpdate.php?id=$id';\" class=\"btn btn-primary btn-sm\">Detail</button></td>
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
