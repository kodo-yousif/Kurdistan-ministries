<?php

require 'db.php';

if (isset($_SESSION['type'])) {
    header('Content-Type: application/json');
    echo json_encode(array("error" => FALSE));
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_SESSION['type'])) {
    if (!isset($_POST['email']) || strlen($_POST['email']) == 0) {
        send_error("Please enter Email.");
    } else if (!isset($_POST['password']) || strlen($_POST['password']) == 0) {
        send_error("Please enter Password.");
    } else if (strlen($_POST['password']) < 8) {
        send_error("Password should be 8 or more charachter.");
    }

    $email = $k->real_escape_string($_POST['email']);
    $pass = $k->real_escape_string(md5($_POST['password']));
    $res = $k->query("SELECT * FROM president Where email = '$email' and password = '$pass';");

    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $_SESSION['type'] = "p";
        $_SESSION['id'] = $row['id'];
        $_SESSION['level'] = "100";
        $_SESSION['name'] = $row['name'];
        header('Content-Type: application/json');
        echo json_encode(array("error" => FALSE));
        exit();
    }

    $res = $k->query("SELECT * FROM minister Where email = '$email' and password = '$pass';");
    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $_SESSION['type'] = "m";
        $_SESSION['id'] = $row['id'];
        $_SESSION['level'] = "100";
        $_SESSION['name'] = $row['name'];
        header('Content-Type: application/json');
        echo json_encode(array("error" => FALSE));
        exit();
    }

    $res = $k->query("SELECT * FROM employees Where email = '$email' and password = '$pass';");
    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $_SESSION['type'] = "e";
        $_SESSION['id'] = $row['id'];
        $_SESSION['level'] = $row['level'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['building'] = $row['building_id'];
        header('Content-Type: application/json');
        echo json_encode(array("error" => FALSE));
        exit();
    }
    send_error("User not found.");

    // $email = "kodo.00257248@gmail.com";
    // $name = "kodoyousif";
    // $q = $k->prepare('SELECT * FROM president Where email = ""?"" and name = ""?"" ;');
    // $q->bind_param("sss", $email, $name);
    // $q->execute();


}

function send_error($message)
{
    header('Content-Type: application/json');
    echo json_encode(array("m" => $message, "error" => TRUE));
    exit();
}

require "../end.php";
