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
        $res = $k->query("SELECT t1.name , t1.id , t2.name job_name FROM employees t1 join jobs t2 WHERE t1.job_id = t2.id and t1.name like '%$name%' limit 20;");
    } else if ($_SESSION['type'] == "m") {
        $tempId = $_SESSION['id'];
        $res = $k->query("SELECT t1.name , t1.id , t2.name job_name FROM employees t1 join jobs t2 WHERE t1.job_id = t2.id and t1.name like '%$name%' and t2.ministry_id in(select id from ministry where minister_id ='$tempId') limit 20;");
    }
    $counter = 1;
    $html = "";
    while ($oneRow = $res->fetch_assoc()) {
        $id = $oneRow['id'];
        $name = $oneRow['name'];
        $job_name = $oneRow['job_name'];
        $html .= "
        <tr>
        <td>$counter</td>
        <td>$name</td>
        <td>$job_name</td>
        <td><button onclick=\"window.location.href = 'employeesUpdate.php?id=$id';\" class=\"btn btn-primary btn-sm\">Detail</button></td>
    </tr>
    ";
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
