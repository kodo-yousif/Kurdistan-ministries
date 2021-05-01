<?php

require '../db.php';
require '../secure.php';

if (!($_SESSION['type'] == "p" || $_SESSION['type'] == "m")) {
    header("location: ../index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['name']) && strlen($_POST['name']) !== 0) {

    $name = $k->real_escape_string($_POST['name']);

    $res = $k->query("select name , id from zone where name like '%$name%';");




    $counter = 1;
    $html = "";
    while ($oneRow = $res->fetch_assoc()) {
        $id = $oneRow['id'];
        $name = $oneRow['name'];
        $html .= "<tr id=\"rowId-$id\">
        <th scope=\"row\">$counter</th>
        <td>$name</td>
        <td><button onclick=\"deleteId($id)\" class=\"btn btn-danger btn-sm\">Delete</button></td>
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
