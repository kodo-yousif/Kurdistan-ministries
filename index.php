<?php

require 'db.php';
require 'secure.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['log_out']) && $_POST['log_out'] == "yes") {
    session_destroy();
    header("location: login.php");
    exit();
}

$updated = FALSE;

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['updatePass']) && $_POST['updatePass'] == "yes") {
    if (
        isset($_POST['pass1']) && !strlen($_POST['pass1']) < 8 &&
        isset($_POST['pass2']) && !strlen($_POST['pass2']) < 8 &&
        isset($_POST['pass3']) && !strlen($_POST['pass3']) < 8 &&
        $_POST['pass3'] == $_POST['pass2']
    ) {
        $password = $k->real_escape_string(md5($_POST['pass1']));
        $newpassword = $k->real_escape_string(md5($_POST['pass2']));
        $id = $k->real_escape_string($_SESSION['id']);
        if ($_SESSION['type'] == "p") {
            $k->query("update president set password = '$newpassword' where id = '$id' and password = '$password';");
            $updated = TRUE;
        } else if ($_SESSION['type'] == "m") {
            $k->query("update minister set password = '$newpassword' where id = '$id' and password = '$password';");
            $updated = TRUE;
        } else if ($_SESSION['type'] == "e") {
            $k->query("update employees set password = '$newpassword' where id = '$id' and password = '$password';");
            $updated = TRUE;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['check']) && $_POST['check'] == "yes") {

    if (!isset($_POST['email'])) {
        send_error("there should be email.");
    }

    if (strlen($_POST['email']) == 0) {
        send_error("there should be email.");
    }
    if (!isset($_POST['id'])) {
        send_error("there should be id.");
    }

    if (strlen($_POST['id']) == 0) {
        send_error("there should be id.");
    }

    $email = $k->real_escape_string($_POST['email']);
    $id = $k->real_escape_string($_REQUEST['id']);

    if ($_SESSION['type'] == "p") {
        $res = $k->query("SELECT id FROM president Where email = '$email' and id<>'$id';");

        if ($res->num_rows !== 0) {
            send_error("email used before try new email.");
        }

        header('Content-Type: application/json');
        echo json_encode(array("error" => FALSE));
        exit();
        
    } else if ($_SESSION['type'] == "m") {
        $res = $k->query("SELECT id FROM minister Where email = '$email' and id<>'$id';");

        if ($res->num_rows !== 0) {
            send_error("email used before try new email.");
        }

        header('Content-Type: application/json');
        echo json_encode(array("error" => FALSE));
        exit();
    } else if ($_SESSION['type'] == "e") {
        $res = $k->query("SELECT id FROM employees Where email = '$email' and id<>'$id';");

        if ($res->num_rows !== 0) {
            send_error("email used before try new email.");
        }

        header('Content-Type: application/json');
        echo json_encode(array("error" => FALSE));
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['checkPass']) && $_POST['checkPass'] == "yes") {
    if (isset($_POST['pass']) && !strlen($_POST['pass']) < 8) {
        $password = $k->real_escape_string(md5($_POST['pass']));
        $id = $k->real_escape_string($_SESSION['id']);

        if ($_SESSION['type'] == "p") {
            $res = $k->query("select * from president where id = '$id' and password = '$password'");

            while ($data = $res->fetch_assoc()) {
                header('Content-Type: application/json');
                echo json_encode(array("error" => FALSE));
                exit();
            }
        } else if ($_SESSION['type'] == "m") {
            $res = $k->query("select * from minister where id = '$id' and password = '$password'");

            while ($data = $res->fetch_assoc()) {
                header('Content-Type: application/json');
                echo json_encode(array("error" => FALSE));
                exit();
            }
        } else if ($_SESSION['type'] == "e") {
            $res = $k->query("select * from employees where id = '$id' and password = '$password'");

            while ($data = $res->fetch_assoc()) {
                header('Content-Type: application/json');
                echo json_encode(array("error" => FALSE));
                exit();
            }
        }

        header('Content-Type: application/json');
        echo json_encode(array("m" => "pasword incorect", "error" => TRUE));
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['updateMe']) && $_POST['updateMe'] == "yes") {
    if (isset($_POST['name']) && strlen($_POST['name']) != 0 && isset($_POST['email']) && strlen($_POST['email']) != 0) {
        $name = $k->real_escape_string($_POST['name']);
        $email = $k->real_escape_string($_POST['email']);
        $id = $_SESSION['id'];
        if ($_SESSION['type'] == "p") {
            $k->query("update president set name = '$name' , email = '$email' where id = '$id';");
            $updated = TRUE;
        } else if ($_SESSION['type'] == "m") {
            $k->query("update minister set name = '$name' , email = '$email' where id = '$id';");
            $updated = TRUE;
        } else if ($_SESSION['type'] == "e") {
            $k->query("update employees set name = '$name' , email = '$email' where id = '$id';");
            $updated = TRUE;
        }
    }
}

if ($_SESSION['type'] == "p") {
    $currentId = $_SESSION['id'];
    $res = $k->query("select id ,name , email from president where id = $currentId");

    while ($data = $res->fetch_assoc()) {
        $name = $data['name'];
        $id = $data['id'];
        $email = $data['email'];
    }
} else if ($_SESSION['type'] == "m") {
    $currentId = $_SESSION['id'];
    $res = $k->query("select id ,name , email from minister where id = $currentId");

    while ($data = $res->fetch_assoc()) {
        $name = $data['name'];
        $id = $data['id'];
        $email = $data['email'];
    }
} else if ($_SESSION['type'] == "e") {
    $currentId = $_SESSION['id'];
    $res = $k->query("select id ,name , email from employees where id = $currentId");

    while ($data = $res->fetch_assoc()) {
        $name = $data['name'];
        $id = $data['id'];
        $email = $data['email'];
    }
}

function send_error($message)
{
    header('Content-Type: application/json');
    echo json_encode(array("m" => $message, "error" => TRUE));
    exit();
}

require "end.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kurdstan Ministries</title>
    <link rel="icon" href="./assets/kurstan.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/layout.css" />
</head>

<body class="sidebar-mini sidebar-closed sidebar-collapse">
    <div class="wrapper">

        <?php
        $top1 = "Home";
        $myname = basename($_SERVER["SCRIPT_FILENAME"], '.php') . ".php";
        require "detail_and_nav.php"; ?>

        <div class="content-wrapper cf" id="main_content">
            <div class="p-2">
                <div class="card mb-5 ml-auto mr-auto " style="max-width: 500px; box-shadow: 2px 2px 7px rgb(95, 95, 95) ;">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Welcom <?php if ($_SESSION['type'] == "p") {
                                                                echo "admin";
                                                            } else if ($_SESSION['type'] == "m") {
                                                                echo "minister";
                                                            } else if ($_SESSION['type'] == "w") {
                                                                echo "Mr/Mrs";
                                                            } ?>: <?php echo $name; ?></h5>
                        <form id="updatePresident" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Name:</span><br />
                                    <input value="<?php echo $name; ?>" placeholder="Enter Name here." name="name" type="text" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Email:</span><br />
                                    <input value="<?php echo $email; ?>" placeholder="Enter Email here." type="email" name="email" class="form-control">
                                </div>
                                <input hidden value="yes" name="updateMe" type="text" />
                                <input hidden id="submitingMe" type="submit" />

                            </div>
                            <div style="display: flex; width: 100%; justify-content: center; flex-direction: column;">
                                <button id="addmm" style="width: 77px; position: relative; left: 50%; transform: translate(-50%,0%);" type="button" class="btn btn-sm btn-primary ml-5 mr-auto mb-2">update</button>
                                <button type="button" style="width: 77px;position: relative; left: 50%; transform: translate(-50%,0%);" onclick="$('#passModal').modal('show');" class="btn btn-sm btn-danger ml-auto mr-auto mb-2">Password</button>
                                <?php if ($_SESSION['type'] == "e") { ?><a href="statistics/employeeInfo.php" type="button" style="width: 77px;position: relative; left: 50%; transform: translate(-50%,0%);" class="btn btn-sm btn-success ml-auto mr-auto mb-2">My info</a><?php } ?>
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


    <script src="./helper/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="./script/layout.js"></script>
    <script src="./script/login.js"></script>

    <div class="modal fade" id="mymodal" style="position: absolute; z-index: 102320;" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Alert</h5>
                    <button type="button" class="close cross_modal" data-dismiss="modal" aria-label="Close">
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
    <div class="modal fade" id="mymodal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Select Minister</h5>
                    <button type="button" class="close cross_modal2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modal_body2" class="modal-body">
                    <input onkeyup="inputChange(this);" style="max-width: 300px;" placeholder="search by full name" type="text" class="form-control ml-auto mr-auto mb-3">
                    <table class='table table-hover table-sm'>
                        <thead class='thead-dark'>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>name</th>
                                <th scope='col'>Select</th>
                            </tr>
                        </thead>
                        <tbody id="table_minister_select">
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button id="close_modal2" type="button" class="btn btn-danger" data-dismiss="modal">Cancle</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="promptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Alert</h5>
                    <button id="cross_modalP" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="prompt_body" class="modal-body">
                    You are sure to delete this ministry?
                </div>
                <div class="modal-footer">
                    <button id="yes_prompt_modal" onclick="deleteMe()" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                    <button id="cancle_prompt_modal" type="button" class="btn btn-primary" data-dismiss="modal">Cancle</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="passModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Change password</h5>
                    <button type="button" class="close cross_k" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updatePass" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <span style="margin-bottom: 100px;">old password:</span><br />
                                <input placeholder="Enter old password here." name="pass1" type="password" class="form-control">
                            </div>

                            <div class="col-12 mb-3">
                                <span style="margin-bottom: 100px;">new password:</span><br />
                                <input placeholder="Enter new password here." name="pass2" type="password" class="form-control">
                            </div>
                            <div class="col-12 mb-3">
                                <span style="margin-bottom: 100px;">new password again:</span><br />
                                <input placeholder="Enter re enter new password here." name="pass3" type="password" class="form-control">
                            </div>
                            <input hidden value="yes" name="updatePass" type="text" />
                        </div>
                        <div style="display: flex; width: 100%; justify-content: center; flex-direction: column;">
                            <button onclick="yallaPass()" style="width: 77px; position: relative; left: 50%; transform: translate(-50%,0%);" type="button" class="btn btn-sm btn-primary ml-5 mr-auto mb-2">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancle_k" data-dismiss="modal">Cancle</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function yallaPass() {
            let form = document.forms.updatePass;
            let form_data = new FormData(form);

            if (!form_data.get("pass1")) {
                err_m("please enter old password.");
                return;
            }


            if (!form_data.get("pass2")) {
                err_m("please enter new password.");
                return;
            }

            if (!form_data.get("pass3")) {
                err_m("please enter new password again.");
                return;
            }

            if (form_data.get("pass2") != form_data.get("pass3")) {
                err_m("both new passwords must be the same.");
                return;
            }

            if (form_data.get("pass1").length < 8 || form_data.get("pass2").length < 8 || form_data.get("pass3").length < 8) {
                err_m("all passwords must be 8 characters or more");
                return;
            }

            $.post("<?php echo $_SERVER['PHP_SELF']; ?>", {
                pass: form_data.get("pass1"),
                checkPass: "yes"
            }, function(r) {
                if (r.error) {
                    err_m(r.m);
                } else {
                    document.getElementById("updatePass").submit();
                }
            })


        }

        function err_m(s) {
            $("#modal_body").text(s);
            $("#mymodal").modal("show");
        }

        function deposit() {
            if (!$("#depo_input").val()) {
                err_m("enter deposit money.");
                return;
            } else if (parseInt($("#depo_input").val()) % 250 != 0) {
                err_m("enter money that money%250 == 0.");
                return;
            } else if (parseInt($("#depo_input").val()) < 1) {
                err_m("enter money must be posative number.");
                return;
            }

            $.post("ministryUpdate.php", {
                id: <?php echo $id; ?>,
                money: parseInt($("#depo_input").val()),
                deposit: "yes"
            }, function() {
                window.location.reload();
            })
        }

        function withdraw() {
            if (!$("#withdraw_input").val()) {
                err_m("enter withdraw money.");
                return;
            } else if (parseInt($("#withdraw_input").val()) % 250 != 0) {
                err_m("enter money that money%250 == 0.");
                return;
            } else if (parseInt($("#withdraw_input").val()) < 1) {
                err_m("enter money must be posative number.");
                return;
            }

            $.post("ministryUpdate.php", {
                id: <?php echo $id; ?>,
                money: parseInt($("#withdraw_input").val()),
                withdraw: "yes"
            }, function() {
                window.location.reload();
            })


        }

        function deleteMe() {
            $.post("ministryUpdate.php", {
                id: <?php echo $id; ?>,
                delete: "yes"
            }, () => {
                window.location.href = "ministry_list.php"
            })
        }

        function ministrySelect(id) {
            $("#idOf_minister_id").val(id);
            $("#minister_name").text($(`#rowName-${id}`).text());
            $("#mymodal2").modal("hide");
        }

        function inputChange(i) {
            $.post("searchMinsterName.php", {
                name: i.value
            }, function(r) {
                if (r.error) {
                    err_m(r.m);
                } else {
                    $("#table_minister_select").html(r.m);
                    $("#mymodal2").modal("show");
                }
            });
        }

        $(() => {

            $("#cancle_prompt_modal").on("click", function() {
                $("#promptModal").modal("hide");
            })

            $("#cross_modalP").on("click", function() {
                $("#promptModal").modal("hide");
            })

            $(".cancle_k").on("click", function() {
                $("#passModal").modal("hide");
            })

            $(".cross_k").on("click", function() {
                $("#with").modal("hide");
                $("#depo").modal("hide");
            })
            <?php if ($updated) {
                if ($_SESSION['type'] == "p") {
                    $table_name_info = "president";
                } else if ($_SESSION['type'] == "m") {
                    $table_name_info = "minister";
                } else if ($_SESSION['type'] == "e") {
                    $table_name_info = "your account has been";
                } ?>
                setTimeout(() => {
                    err_m("<?php echo $table_name_info; ?> updated successfully.")
                }, 1000);
            <?php } ?>
            $("#close_modal").on("click", function() {
                $("#mymodal").modal("hide");
            })

            $(".cross_modal").on("click", function() {
                $("#mymodal").modal("hide");
            })
            $(".close_modal2").on("click", function() {
                $("#mymodal2").modal("hide");
            })

            $("#cross_modal2").on("click", function() {
                $("#mymodal2").modal("hide");
            })

            $("#addmm").on("click", function() {
                let form = document.forms.updatePresident;
                let form_data = new FormData(form);

                if (!form_data.get("name")) {
                    err_m("please enter Name.");
                    return;
                }


                if (!form_data.get("email")) {
                    err_m("please enter a minister.");
                    return;
                }

                s = {
                    email: form_data.get('email'),
                    check: "yes",
                    id: <?php echo $_SESSION['id']; ?>
                }

                $.post("<?php echo $_SERVER['PHP_SELF']; ?>", s, function(r) {
                    if (r.error) {
                        err_m(r.m);
                    } else {
                        document.getElementById("updatePresident").submit();
                    }
                })
            });
        })
    </script>

</body>

</html>