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
        $res = $k->query("select name , id from ministry where name like '%$name%' limit 10;");
    } else if ($_SESSION['type'] == "m") {
        $tempId = $_SESSION['id'];
        $res = $k->query("select name , id from ministry where name like '%$name%' and minister_id = '$tempId' limit 10;");
    }


    $counter = 1;
    $html = "";
    while ($oneRow = $res->fetch_assoc()) {
        $id = $oneRow['id'];
        $name = $oneRow['name'];
        $html .= "<tr>
        <th scope=\"row\">$counter</th>
        <td id=\"rowName-$id\">$name</td>
        <td><button onclick=\"ministrySelect($id)\" class=\"btn btn-primary btn-sm\">Select</button></td>
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
