<?php

require '../db.php';
require 'secure.php';
if ($_SESSION['type'] != "p") {
    header("location: ../index.php");
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['log_out']) && $_POST['log_out'] == "yes") {
    session_destroy();
    header("location: ../login.php");
    exit();
}

$updated = FALSE;

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['updatePass']) && $_POST['updatePass'] == "yes") {
    if (
        isset($_POST['pass']) && !strlen($_POST['pass']) < 8 &&
        isset($_POST['id']) && strlen($_POST['id']) != 0
    ) {
        $password = $k->real_escape_string(md5($_POST['pass']));
        $id = $k->real_escape_string($_POST['id']);
        $k->query("update minister set password = '$password' where id = '$id';");
        $updated = TRUE;
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
    $res = $k->query("SELECT id FROM minister Where email = '$email' and id<>'$id';");

    if ($res->num_rows !== 0) {
        send_error("email used before try new email.");
    }

    header('Content-Type: application/json');
    echo json_encode(array("error" => FALSE));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['updateMe']) && $_POST['updateMe'] == "yes") {

    if (isset($_POST['name']) && strlen($_POST['name']) != 0 && isset($_POST['email']) && strlen($_POST['email']) != 0) {
        $name = $k->real_escape_string($_POST['name']);
        $email = $k->real_escape_string($_POST['email']);
        $id = $k->real_escape_string($_POST['id']);

        $k->query("update minister set name = '$name' , email = '$email' where id = '$id';");

        $updated = TRUE;
    }
}


$currentId;
if (isset($_REQUEST['id']) && strlen($_REQUEST['id']) != 0) {
    $currentId = $k->real_escape_string($_REQUEST['id']);
    $res = $k->query("select id ,name , created_at , email from minister where id = $currentId");

    while ($data = $res->fetch_assoc()) {
        $name = $data['name'];
        $id = $data['id'];
        $created_at = $data['created_at'];
        $email = $data['email'];
    }
} else {
    header("location: seeAdmin.php");
}

$zhmardni_ministry = 1;
$minitry_table_rows = $k->query("select name , id from ministry where minister_id = '$currentId';");


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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/layout.css" />
</head>

<body class="sidebar-mini sidebar-closed sidebar-collapse">
    <div class="wrapper">

        <?php
        $top1 = "Update minister";
        $myname = basename($_SERVER["SCRIPT_FILENAME"], '.php') . ".php";
        require "../full_nav.php"; ?>

        <div class="content-wrapper cf" id="main_content">
            <div class="p-2">

                <div class="card mb-5 ml-auto mr-auto " style="max-width: 500px; box-shadow: 2px 2px 7px rgb(95, 95, 95) ;">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Welcom minister: <?php echo $name; ?></h5>
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
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Started At:</span><br />
                                    <input value="<?php echo $created_at; ?>" type="text" disabled class="form-control">
                                </div>
                                <input hidden value="yes" name="updateMe" type="text" />
                                <input hidden value="<?php echo $id; ?>" name="id" type="text" />
                                <input hidden id="submitingMe" type="submit" />

                            </div>
                            <div style="display: flex; width: 100%; justify-content: center; flex-direction: column;">
                                <button id="addmm" style="width: 77px; position: relative; left: 50%; transform: translate(-50%,0%);" type="button" class="btn btn-sm btn-primary ml-5 mr-auto mb-2">update</button>
                                <button type="button" style="width: 77px;position: relative; left: 50%; transform: translate(-50%,0%);" onclick="$('#passModal').modal('show');" class="btn btn-sm btn-danger ml-auto mr-auto mb-2">Password</button>
                            </div>
                        </form>

                        <?php if ($minitry_table_rows->num_rows != 0) { ?>
                            <h5 class="mt-2">Minister Of:</h5>
                            <table class="table table-hover table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">name</th>
                                        <th scope="col">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($getData = $minitry_table_rows->fetch_assoc()) { ?>
                                        <tr>
                                            <th scope="row"><?php echo $zhmardni_ministry; ?></th>
                                            <td><?php echo $getData['name']; ?></td>
                                            <td><a class="btn btn-sm btn-primary" href="../ministries/ministryUpdate.php?id=<?php echo $getData['id']; ?>">Detail</a></td>
                                        </tr>
                                </tbody> <?php $zhmardni_ministry++;
                                        } ?>
                            </table> <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <footer class="main-footer cf" style="text-align:center;">
            <strong>Copyright &copy; 2021 <a href="https://kodoyousif.com">Kodo Yousif</a>.</strong>
        </footer>
    </div>


    </div>

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
                                <span style="margin-bottom: 100px;">new password:</span><br />
                                <input placeholder="Enter new password here." name="pass" type="password" class="form-control">
                                <input hidden value="<?php echo $id; ?>" name="id" type="text" />
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
    <script src="../helper/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="../script/layout.js"></script>
    <script src="../script/login.js"></script>


    <script>
        function yallaPass() {
            let form = document.forms.updatePass;
            let form_data = new FormData(form);

            if (!form_data.get("pass")) {
                err_m("please enter new password.");
                return;
            }

            if (form_data.get("pass").length < 8) {
                err_m("password must be 8 character length or more.");
                return;
            }

            document.getElementById("updatePass").submit();

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
            <?php if ($updated) { ?>
                setTimeout(() => {
                    err_m("minister updated successfully.")
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
                    id: <?php echo $id; ?>
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