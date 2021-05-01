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
$error = False;
$message = "name used before";
$added = FALSE;

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['check']) && $_POST['check'] == "yes") {

    if (!isset($_POST['name'])) {
        send_error("there should be name.");
    }

    if (strlen($_POST['name']) == 0) {
        send_error("there should be name.");
    }
    if (!isset($_POST['ministry'])) {
        send_error("there should be name.");
    }

    if (strlen($_POST['ministry']) == 0) {
        send_error("there should be name.");
    }

    if (!isset($_POST['zone'])) {
        send_error("there should be name.");
    }

    if (strlen($_POST['zone']) == 0) {
        send_error("there should be name.");
    }

    $name = $k->real_escape_string($_POST['name']);
    $ministry = $k->real_escape_string($_POST['ministry']);
    $zone = $k->real_escape_string($_POST['zone']);

    $res = $k->query("SELECT id FROM building Where name = '$name' and ministry_id = '$ministry' and zone_id = '$zone';");
    if ($res->num_rows !== 0) {
        send_error("name used before try new name.");
    }

    header('Content-Type: application/json');
    echo json_encode(array("error" => FALSE));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['for_adding']) && $_POST['for_adding'] == "yes") {

    if (
        isset($_POST['name']) && strlen($_POST['name']) != 0 &&
        isset($_POST['ministry_id']) && strlen($_POST['ministry_id']) != 0 &&
        isset($_POST['zone_id']) && strlen($_POST['zone_id']) != 0 &&
        isset($_POST['bank']) && strlen($_POST['bank']) != 0
    ) {
        $name = $k->real_escape_string($_POST['name']);
        $ministry_id = $k->real_escape_string($_POST['ministry_id']);
        $zone_id = $k->real_escape_string($_POST['zone_id']);
        $bank = $k->real_escape_string($_POST['bank']);

        $res = $k->query("SELECT * FROM building Where name = '$name' and ministry_id = '$ministry_id' and zone_id = '$zone_id';");

        if ($res->num_rows !== 0) {
            $error = TRUE;
            $message = "name used before";
        }

        if (!$error) {

            $k->query("insert building (name , ministry_id , zone_id , bank ) values ('$name','$ministry_id','$zone_id','$bank'); ");
            if (!$k->error) {
                $added = TRUE;
            }
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
        $top1 = "Add building";
        $myname = basename($_SERVER["SCRIPT_FILENAME"], '.php') . ".php";
        require "../full_nav.php"; ?>

        <div class="content-wrapper cf" id="main_content">
            <!-- <a href="#" data-toggle="modal" data-target="#mymodal">yalla</a> -->

            <div class="container" style="align-content: center;">

                <div class="card mb-5 ml-auto mr-auto mt-4" style="max-width: 500px; box-shadow: 2px 2px 7px rgb(95, 95, 95) ;">
                    <div class="card-body ">
                        <h5 class="card-title mb-4">Add new Building</h5>
                        <form id="add_ministry" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Name:</span><br />
                                    <input placeholder="Enter Name here." name="name" type="text" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Bank:</span><br />
                                    <input placeholder="Enter amount of money here." value="0" type="number" name="bank" class="form-control">
                                </div>
                                <div class="col-12 mb-3 position-relative">
                                    <span style="margin-bottom: 100px;">Ministry: <span id="minister_name" class="text-primary"></span> </span>
                                    <input hidden id="idOf_ministry_id" type="text" name="ministry_id" class="form-control">
                                    <input hidden value="yes" name="for_adding" type="text" />
                                    <button id="select_minister" type="button" class="btn btn-sm btn-primary position-absolute mr-3" style="right: 0px;">Select</button>
                                </div>
                                <div class="col-12 mb-3 position-relative">
                                    <span style="margin-bottom: 100px;">Zone: <span id="zone_name" class="text-primary"></span> </span>
                                    <input hidden id="idOf_zone_id" type="text" name="zone_id" class="form-control">
                                    <button id="select_zone" type="button" class="btn btn-sm btn-primary position-absolute mr-3" style="right: 0px;">Select</button>
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
    <div class="modal fade" id="mymodal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Select <span id="changableSelect"></span>:</h5>
                    <button id="cross_modal2" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modal_body2" class="modal-body">
                    <input id="searchPlaceZone_Ministry" onkeyup="inputChange(this);" style="max-width: 300px;" placeholder="search by full name" type="text" class="form-control ml-auto mr-auto mb-3">
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

        function ministrySelect(id) {
            $("#idOf_ministry_id").val(id);
            $("#minister_name").text($(`#rowName-${id}`).text());
            $("#mymodal2").modal("hide");
            $("#searchPlaceZone_Ministry").val("");
        }

        function zoneSelect(id) {
            $("#idOf_zone_id").val(id);
            $("#zone_name").text($(`#rowName-${id}`).text());
            $("#mymodal2").modal("hide");
            $("#searchPlaceZone_Ministry").val("");
        }

        let zone = false;

        function inputChange(i) {
            if (zone) {
                $.post("searchZoneName.php", {
                    name: i.value
                }, function(r) {
                    if (r.error) {
                        err_m(r.m);
                    } else {
                        $("#table_minister_select").html(r.m);
                        $("#mymodal2").modal("show");
                    }
                });
            } else {
                $.post("searchMinistryName.php", {
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

        }

        $(() => {


            $("#select_minister").on("click", function() {
                zone = false;
                $("#changableSelect").text("Ministry");
                $.post("searchMinistryName.php", {
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

            $("#select_zone").on("click", function() {
                zone = true;
                $("#changableSelect").text("Zone");
                $.post("searchZoneName.php", {
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

            <?php if ($added) { ?>
                setTimeout(() => {
                    err_m("building added successfully.")
                }, 1000);
            <?php } ?>

            <?php if ($error) { ?>
                setTimeout(() => {
                    err_m("<?php echo $message; ?>");
                }, 1000);
            <?php } ?>
            $("#close_modal").on("click", function() {
                $("#mymodal").modal("hide");
            })

            $("#cross_modal").on("click", function() {
                $("#mymodal").modal("hide");
                $("#searchPlaceZone_Ministry").val("");

            })
            $("#close_modal2").on("click", function() {
                $("#mymodal2").modal("hide");
                $("#searchPlaceZone_Ministry").val("");

            })

            $("#cross_modal2").on("click", function() {
                $("#mymodal2").modal("hide");
                $("#searchPlaceZone_Ministry").val("");

            })
            $("#addmm").on("click", function() {

                let form = document.forms.add_ministry;
                let form_data = new FormData(form);

                if (!form_data.get("name")) {
                    err_m("please enter Name.");
                    return;
                }
                if (!form_data.get("bank") || form_data.get("bank").length == 0 ||
                    parseInt(form_data.get("bank")) % 250 != 0 || parseInt(form_data.get("bank")) < 0) {
                    err_m("please enter money in corect form for bank money must be money%250 ==0 and be positive .");
                    return;
                }

                if (!form_data.get("ministry_id")) {
                    err_m("please select a ministry.");
                    return;
                }
                if (!form_data.get("zone_id")) {
                    err_m("please select a zone.");
                    return;
                }
                let s = {
                    name: form_data.get("name"),
                    ministry: parseInt(form_data.get("ministry_id")),
                    check: "yes",
                    zone: parseInt(form_data.get("zone_id"))
                }

                $.post("<?php echo $_SERVER['PHP_SELF']; ?>", s, function(r) {
                    if (r.error) {
                        err_m(r.m);
                    } else {
                        document.getElementById("add_ministry").submit();
                    }
                });

            });
        });
    </script>
</body>

</html>