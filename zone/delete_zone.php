<?php

require '../db.php';
require '../secure.php';

if ((!$_SESSION['type'] == "p" || $_SESSION['type'] == "m")) {
    header("location: ../index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id']) && strlen($_POST['id']) !== 0) {

    $id = $k->real_escape_string($_POST['id']);

    $k->query("DELETE FROM zone WHERE id = $id");

    if (strlen($k->error) == 0) {
        header('Content-Type: application/json');
        echo json_encode(array("error" => FALSE));
    } else {
        send_error("this id not exsits.");
    }
}

function send_error($message)
{
    header('Content-Type: application/json');
    echo json_encode(array("m" => $message, "error" => TRUE));
    exit();
}
require "../end.php";
