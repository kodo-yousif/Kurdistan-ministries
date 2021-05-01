<?php

require '../db.php';
require 'secure.php';

if ($_SESSION['type'] != "p") {
    header("location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['log_out']) && $_POST['log_out'] == "yes") {
    session_destroy();
    header("location: ../login.php");
    exit();
}

$added = FALSE;

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['check']) && $_POST['check'] == "yes") {

    if (!isset($_POST['name'])) {
        send_error("there should be name.");
    }

    if (strlen($_POST['name']) == 0) {
        send_error("there should be name.");
    }

    if (!isset($_POST['email'])) {
        send_error("there should be email.");
    }
    if (strlen($_POST['email']) == 0) {
        send_error("there should be name.");
    }
    $name = $k->real_escape_string($_POST['name']);
    $email = $k->real_escape_string($_POST['email']);


    $res = $k->query("SELECT * FROM minister Where email = '$email';");

    if ($res->num_rows !== 0) {
        send_error("emaile used before try new email.");
    }

    $res = $k->query("SELECT * FROM minister Where name = '$name';");

    if ($res->num_rows !== 0) {
        send_error("name used before try new name.");
    }

    header('Content-Type: application/json');
    echo json_encode(array("error" => FALSE));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['for_adding']) && $_POST['for_adding'] == "yes") {

    if (
        isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pass1']) && isset($_POST['pass2'])
        && strlen($_POST['name']) != 0 &&  strlen($_POST['email']) != 0 &&
        strlen($_POST['pass1']) != 0 && strlen($_POST['pass2']) != 0 && strlen($_POST['pass2']) == strlen($_POST['pass1'])
    ) {
        $name = $k->real_escape_string($_POST['name']);
        $email = $k->real_escape_string($_POST['email']);
        $pass = $k->real_escape_string(md5($_POST['pass1']));

        $k->query("insert into minister (name , email , password ) values ('$name','$email','$pass');");
        $added = TRUE;
    }
}
function send_error($message)
{
    header('Content-Type: application/json');
    echo json_encode(array("m" => $message, "error" => TRUE));
    exit();
}

require "../end.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kurdstan Ministries</title>
    <link rel="icon" href="../assets/kurstan.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/layout.css" />
</head>

<body class="sidebar-mini sidebar-closed sidebar-collapse">
    <div class="wrapper">
        <?php
        $top1 = "Add ministry";
        $myname = basename($_SERVER["SCRIPT_FILENAME"], '.php') . ".php";
        require "../full_nav.php"; ?>

        <div class="content-wrapper cf" id="main_content">
            <!-- <a href="#" data-toggle="modal" data-target="#mymodal">yalla</a> -->

            <div class="container" style="align-content: center;">

                <div class="card mb-5 ml-auto mr-auto " style="max-width: 500px; box-shadow: 2px 2px 7px rgb(95, 95, 95) ;">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Add new Minister</h5>
                        <form id="add_minister" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Name:</span><br />
                                    <input placeholder="Enter Name here." name="name" type="text" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Email:</span><br />
                                    <input placeholder="Enter Email here." type="email" name="email" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Password:</span><br />
                                    <input placeholder="Enter Password here." name="pass1" type="password" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Password:</span><br />
                                    <input placeholder="Enter Password here." name="pass2" type="password" class="form-control">
                                    <input hidden value="yes" name="for_adding" type="text" />
                                </div>
                                <button id="addmm" type="button" class="btn btn-primary ml-auto mr-auto">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <footer class="main-footer cf" style="text-align:center;">
            <strong>Copyright &copy; 2021 <a href="https://kodoyousif.com">Kodo Yousif</a>.</strong>
        </footer>
    </div>


    </div>

    <div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Alert</h5>
                    <button id="cross_modal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modal_body" class="modal-body">
                </div>
                <div class="modal-footer">
                    <button id="close_modal" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../helper/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../script/layout.js"></script>
    <script src="../script/login.js"></script>
    <script>
        function err_m(s) {
            $("#modal_body").text(s);
            $("#mymodal").modal("show");
        }

        $(() => {

            <?php if ($added) { ?>
                setTimeout(() => {
                    err_m("minister added successfully.")
                }, 1000);
            <?php } ?>
            $("#close_modal").on("click", function() {
                $("#mymodal").modal("hide");
            })

            $("#cross_modal").on("click", function() {
                $("#mymodal").modal("hide");
            })
            $("#addmm").on("click", function() {

                let form = document.forms.add_minister;
                let form_data = new FormData(form);

                if (!form_data.get("name")) {
                    err_m("please enter Name.");
                    return;
                }

                if (!form_data.get("email")) {
                    err_m("please enter Email.");
                    return;
                }
                if (!form_data.get("pass1")) {
                    err_m("please enter Password on both fields.");
                    return;
                } else if (!form_data.get("pass2")) {
                    err_m("please enter Password on both fields.");
                    return;
                } else if (form_data.get("pass2") !== form_data.get("pass1")) {
                    err_m("both Passwords must be the same.");
                    return;
                } else if (form_data.get("pass1").length < 8) {
                    err_m("Password length must be 8 or more.");
                    return;
                }
                let s = {
                    name: form_data.get("name"),
                    email: form_data.get("email"),
                    check: "yes"
                }

                $.post("<?php echo $_SERVER['PHP_SELF'] ?>", s, function(r) {
                    if (r.error) {
                        err_m(r.m);
                    } else {
                        document.getElementById("add_minister").submit();
                    }
                });

            });
        });
    </script>
</body>

</html>