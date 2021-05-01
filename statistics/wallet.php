<?php

require '../db.php';
require '../secure.php';

if (!($_SESSION['type'] == "e")) {
    header("location: ../index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['log_out']) && $_POST['log_out'] == "yes") {
    session_destroy();
    header("location: ../login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['withdraw']) && $_POST['withdraw'] == "yes") {
    if (!isset($_POST['money'])) {
        send_error("there should be name.");
    }

    if (strlen($_POST['money']) == 0) {
        send_error("there should be name.");
    }

    if ((int) $_POST['money'] < 0) {
        send_error("money must be greater than 0 to withdraw.");
    }

    $money = $k->real_escape_string($_POST['money']);
    $id = $k->real_escape_string($_SESSION['id']);
    $res = $k->query("select bank from employees where id = '$id';");

    if ($res->num_rows == 0) {
        send_error("no user found");
    }
    $bankMoney = 0;
    while ($row = $res->fetch_assoc()) {
        $bankMoney = (int) $row['bank'];
    }

    if ($k->error) {
        send_error("server error");
    }

    if ((int) $money > $bankMoney) {
        send_error("cant be done you dont have this amount in your bank.");
    }

    $k->query("update employees set bank = bank - $money where id = '$id';");

    if ($k->error) {
        send_error("server error sorry.");
    }

    header('Content-Type: application/json');
    echo json_encode(array("error" => FALSE));
    exit();
}



if (isset($_SESSION['id']) &&  strlen($_SESSION['id']) != 0) {
    $id = $k->real_escape_string($_SESSION['id']);

    $res = $k->query(" Select bank from employees where id = '$id';");


    if ($res->num_rows == 0) {
        header("location: ../index.php");
    }

    while ($data = $res->fetch_assoc()) {
        $bank = $data['bank'];
    }
} else {
    header("location: ../index.php");
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
        $top1 = "Wallet";
        $myname = basename($_SERVER["SCRIPT_FILENAME"], '.php') . ".php";
        require "../full_nav.php"; ?>

        <div class="content-wrapper cf" id="main_content">
            <div class="container" style="align-content: center;">

                <div class="card mb-5 ml-auto mr-auto mt-4" style="max-width: 500px; box-shadow: 2px 2px 7px rgb(95, 95, 95) ;">
                    <div class="card-body ">
                        <h5 class="card-title mb-4">Your wallet:</h5>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <span style="margin-bottom: 100px;">Bank:</span><br />
                                <input value="<?php echo $bank; ?>" disabled type="number" class="form-control">
                            </div>
                        </div>
                        <div style="display: flex; width: 100%; justify-content: center; flex-direction: column;">
                            <button type="button" onclick="$('#with').modal('show');" class="btn btn-warning ml-auto mr-auto mb-2">Withdraw</button>
                        </div>

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
    <div class="modal fade" id="with" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Alert</h5>
                    <button type="button" id="cross_k" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Withdraw:<br />
                    <input type="number" value="0" id="withdraw_input" class="form-control disabled">

                </div>
                <div class="modal-footer">
                    <button onclick="withdraw()" type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>
                    <button type="button" id="cancle_k" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
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

        function withdraw() {
            if (!$("#withdraw_input").val()) {
                err_m("enter withdraw money.");
                return;
            } else if (parseInt($("#withdraw_input").val()) % 250 != 0) {
                err_m("enter money that money%250 == 0.");
                return;
            } else if (parseInt($("#withdraw_input").val()) < 0) {
                err_m("enter money must be posative number.");
                return;
            }

            $.post("<?php echo $_SERVER['PHP_SELF']; ?>", {
                money: parseInt($("#withdraw_input").val()),
                withdraw: "yes"
            }, function(r) {
                if (r.error) {
                    err_m(r.m);
                } else {
                    window.location.reload();
                }
            })


        }

        $(() => {
            $("#cross_modal").on("click", function() {
                $("#mymodal").modal("hide");
            });
            $("#close_modal").on("click", function() {
                $("#mymodal").modal("hide");
            });
            $("#cross_k").on("click", function() {
                $("#with").modal("hide");
            });
            $("#cancle_k").on("click", function() {
                $("#with").modal("hide");
            });
        })
    </script>
</body>

</html>