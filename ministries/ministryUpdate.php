<?php

require '../db.php';
require '../secure.php';

if (!($_SESSION['type'] == "p" || $_SESSION['type'] == "m")) {
    header("location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['log_out']) && $_POST['log_out'] == "yes") {
    session_destroy();
    header("location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['deposit']) && $_POST['deposit'] == "yes") {
    $id = $k->real_escape_string($_REQUEST['id']);
    $money = $k->real_escape_string($_REQUEST['money']);

    $k->query("update ministry set bank = bank - $money where id='$id';");
    header('Content-Type: application/json');
    echo json_encode(array("m" => "done.", "error" => FALSE));
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['withdraw']) && $_POST['withdraw'] == "yes") {
    $id = $k->real_escape_string($_REQUEST['id']);
    $money = $k->real_escape_string($_REQUEST['money']);

    $k->query("update ministry set bank = bank + $money where id='$id';");
    header('Content-Type: application/json');
    echo json_encode(array("m" => "done.", "error" => FALSE));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete']) && $_POST['delete'] == "yes") {
    $id = $k->real_escape_string($_REQUEST['id']);
    $k->query("delete from ministry where id='$id';");
    header('Content-Type: application/json');
    echo json_encode(array("m" => "done.", "error" => FALSE));
    exit();
}

if (isset($_REQUEST['id']) &&  strlen($_REQUEST['id']) != 0) {
    $id = $k->real_escape_string($_REQUEST['id']);
    if ($_SESSION['type'] == "p") {
        $res = $k->query("select m1.name , m1.bank , m1.created_at , m1.id , m1.minister_id , m2.name minister_name from ministry m1 join minister m2 where m1.id = $id and m1.minister_id = m2.id ; ");
    } else {
        $tempId = $_SESSION['id'];
        $res = $k->query("select m1.name , m1.bank , m1.created_at , m1.id , m1.minister_id , m2.name minister_name from ministry m1 join minister m2 where m1.minister_id = '$tempId' and m1.id = $id and m1.minister_id = m2.id ; ");
    }

    $minister_id;
    $name;
    $created_at;
    $id;
    $bank;
    $minister_name;
    while ($data = $res->fetch_assoc()) {
        $name = $data['name'];
        $bank = $data['bank'];
        $created_at = $data['created_at'];
        $id = $data['id'];
        $minister_id = $data['minister_id'];
        $minister_name = $data['minister_name'];
    }

    if (!isset($name) && !isset($email) && strlen($name) == 0 && strlen($email) == 0) {
        header("location: ministry_list.php");
    }
} else {
    header("location: ministry_list.php");
}
$added = FALSE;

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['check']) && $_POST['check'] == "yes") {

    if (!isset($_POST['name'])) {
        send_error("there should be name.");
    }

    if (strlen($_POST['name']) == 0) {
        send_error("there should be name.");
    }

    $name = $k->real_escape_string($_POST['name']);

    $res = $k->query("SELECT * FROM ministry Where name = '$name' and id <> $id;");

    if ($res->num_rows !== 0) {
        send_error("name used before try new name.");
    }

    header('Content-Type: application/json');
    echo json_encode(array("error" => FALSE));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['for_adding']) && $_POST['for_adding'] == "yes") {

    if (
        isset($_POST['name']) && isset($_POST['minister_id'])
        && strlen($_POST['name']) != 0 && strlen($_POST['minister_id']) != 0
    ) {
        $name = $k->real_escape_string($_POST['name']);
        $minister_id = $k->real_escape_string($_POST['minister_id']);
        $k->query("update ministry set  name = '$name' , minister_id = '$minister_id' where id='$id' ;");
        if (!$k->error) {
            header('location: ministry_list.php');
            $added = TRUE;
        }
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
        $top1 = "Update ministry";
        $myname = basename($_SERVER["SCRIPT_FILENAME"], '.php') . ".php";
        require "../full_nav.php"; ?>

        <div class="content-wrapper cf" id="main_content">
            <div class="container pt-3" style="align-content: center;">

                <div class="card mb-5 ml-auto mr-auto " style="max-width: 500px; box-shadow: 2px 2px 7px rgb(95, 95, 95) ;">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Ministry: <?php echo $name; ?></h5>
                        <form id="add_ministry" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Name:</span><br />
                                    <input value="<?php echo $name; ?>" placeholder="Enter Name here." name="name" type="text" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Bank:</span><br />
                                    <input disabled type="number" value="<?php echo $bank; ?>" class="form-control disabled">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Started At:</span><br />
                                    <input disabled type="text" value="<?php echo $created_at; ?>" class="form-control disabled">
                                </div>
                                <div class="col-12 mb-3 position-relative">
                                    <span style="margin-bottom: 100px;">minister: <span id="minister_name" class="text-primary"><?php echo $minister_name; ?></span> </span>
                                    <input hidden value="<?php echo $minister_id; ?>" id="idOf_minister_id" type="text" name="minister_id" class="form-control">
                                    <input hidden value="yes" name="for_adding" type="text" />
                                    <input hidden value="<?php echo $id; ?>" name="id" type="text" />
                                    <button id="select_minister" type="button" class="btn btn-sm btn-primary position-absolute mr-3" style="right: 0px;">Select</button>
                                </div>
                            </div>
                            <div style="display: flex; width: 100%; justify-content: center; flex-direction: column;">
                                <button id="addmm" style="width: 77px;" type="button" class="btn btn-sm btn-primary ml-auto mr-auto mb-2">update</button>
                                <button type="button" style="width: 77px;" onclick="$('#promptModal').modal('show');" class="btn btn-sm btn-danger ml-auto mr-auto mb-2">delete</button>
                                <button type="button" style="width: 77px;" onclick="$('#with').modal('show');" class="btn btn-secondary ml-auto btn-sm mr-auto mb-2">deposit</button>
                                <button type="button" style="width: 77px;" onclick="$('#depo').modal('show');" class="btn btn-sm btn-secondary ml-auto mr-auto mb-2">withdraw</button>
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

    <div class="modal fade" id="mymodal" style="position: absolute; z-index: 102320;" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
    <div class="modal fade" id="mymodal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Select Minister</h5>
                    <button id="cross_modal2" type="button" class="close" data-dismiss="modal" aria-label="Close">
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
    <div class="modal fade" id="with" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Alert</h5>
                    <button type="button" class="close cross_k" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deposit:<br />
                    <input type="number" value="0" id="withdraw_input" class="form-control disabled">

                </div>
                <div class="modal-footer">
                    <button onclick="withdraw()" type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-secondary cancle_k" data-dismiss="modal">Cancle</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="depo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Alert</h5>
                    <button type="button" class="close cross_k" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Withdraw:<br />
                    <input type="number" value="0" id="depo_input" class="form-control disabled">

                </div>
                <div class="modal-footer">
                    <button onclick="deposit()" type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-secondary cancle_k" data-dismiss="modal">Cancle</button>
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
            $("#select_minister").on("click", function() {

                $.post("searchMinsterName.php", {
                    name: ""
                }, function(r) {
                    if (r.error) {
                        err_m(r.m);
                    } else {
                        $("#table_minister_select").html(r.m);
                        $("#mymodal2").modal("show");
                    }
                });

                $("#mymodal2").modal("show");
            });

            $("#cancle_prompt_modal").on("click", function() {
                $("#promptModal").modal("hide");
            })

            $("#cross_modalP").on("click", function() {
                $("#promptModal").modal("hide");
            })

            $(".cancle_k").on("click", function() {
                $("#with").modal("hide");
                $("#dep").modal("hide");
            })

            $(".cross_k").on("click", function() {
                $("#with").modal("hide");
                $("#depo").modal("hide");
            })
            <?php if ($added) { ?>
                setTimeout(() => {
                    err_m("ministry updated successfully.")
                }, 1000);
            <?php } ?>
            $("#close_modal").on("click", function() {
                $("#mymodal").modal("hide");
            })

            $("#cross_modal").on("click", function() {
                $("#mymodal").modal("hide");
            })
            $("#close_modal2").on("click", function() {
                $("#mymodal2").modal("hide");
            })

            $("#cross_modal2").on("click", function() {
                $("#mymodal2").modal("hide");
            })

            $("#addmm").on("click", function() {

                let form = document.forms.add_ministry;
                let form_data = new FormData(form);

                if (!form_data.get("name")) {
                    err_m("please enter Name.");
                    return;
                }


                if (!form_data.get("minister_id")) {
                    err_m("please select a minister.");
                    return;
                }
                let s = {
                    name: form_data.get("name"),
                    check: "yes",
                    id: <?php echo $id; ?>
                }

                $.post("ministryUpdate.php", s, function(r) {
                    if (r.error) {
                        err_m(r.m);
                    } else {
                        document.getElementById("add_ministry").submit();
                    }
                });

            });
        })
    </script>

</body>

</html>