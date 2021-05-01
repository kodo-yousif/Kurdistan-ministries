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

    if (!isset($_POST['email'])) {
        send_error("there should be name.");
    }

    if (strlen($_POST['email']) == 0) {
        send_error("there should be name.");
    }

    $email = $k->real_escape_string($_POST['email']);

    $res = $k->query("SELECT id FROM employees Where email = '$email';");

    if ($res->num_rows !== 0) {
        send_error("email used before try new email.");
    }

    header('Content-Type: application/json');
    echo json_encode(array("error" => FALSE));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['for_adding']) && $_POST['for_adding'] == "yes") {

    if (
        isset($_POST['name']) && strlen($_POST['name']) != 0 &&
        isset($_POST['pass']) && strlen($_POST['pass']) != 0 &&
        isset($_POST['email']) && strlen($_POST['email']) != 0 &&
        isset($_POST['job_id']) && strlen($_POST['job_id']) != 0 &&
        isset($_POST['married']) && strlen($_POST['married']) != 0 &&
        ($_POST['married'] == "yes" || $_POST['married'] == "no") &&
        isset($_POST['level']) && strlen($_POST['level']) != 0 &&
        ($_POST['level'] == "1" || $_POST['level'] == "2") &&
        isset($_POST['gender']) && strlen($_POST['gender']) != 0 &&
        ($_POST['gender'] == "female" || $_POST['gender'] == "male") &&
        isset($_POST['building_id']) && strlen($_POST['building_id']) != 0 &&
        isset($_POST['bank']) && strlen($_POST['bank']) != 0 &&
        isset($_POST['kids']) && strlen($_POST['kids']) != 0 &&
        isset($_POST['ministry_id']) && strlen($_POST['ministry_id']) != 0 &&
        isset($_POST['zone_id']) && strlen($_POST['zone_id']) != 0 &&
        isset($_POST['bones']) && strlen($_POST['bones']) != 0
    ) {
        $name = $k->real_escape_string($_POST['name']);
        $email = $k->real_escape_string($_POST['email']);
        $level = $k->real_escape_string($_POST['level']);
        $bones = $k->real_escape_string($_POST['bones']);
        $kids = $k->real_escape_string($_POST['kids']);
        $gender = $k->real_escape_string($_POST['gender']);
        $married = $k->real_escape_string($_POST['married']);
        $pass = $k->real_escape_string(md5($_POST['pass']));
        $job_id = $k->real_escape_string($_POST['job_id']);
        $zone_id = $k->real_escape_string($_POST['zone_id']);
        $building_id = $k->real_escape_string($_POST['building_id']);
        $bank = $k->real_escape_string($_POST['bank']);

        $res = $k->query("SELECT * FROM employees Where email = '$email';");

        if ($res->num_rows !== 0) {
            $error = TRUE;
            $message = "name used before";
        }

        if (!$error) {
            $k->query("insert employees (name , email , password , kids , bones , bank , level , married ,
            gender  , zone_id , building_id , job_id ) values ('$name','$email','$pass','$kids' ,
             '$bones' , '$bank' , '$level' , '$married' , '$gender' , '$zone_id' , '$building_id' , '$job_id' );");
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
        $top1 = "Add employee";
        $myname = basename($_SERVER["SCRIPT_FILENAME"], '.php') . ".php";
        require "../full_nav.php"; ?>

        <div class="content-wrapper cf" id="main_content">
            <!-- <a href="#" data-toggle="modal" data-target="#mymodal">yalla</a> -->

            <div class="container" style="align-content: center;">

                <div class="card mb-5 ml-auto mr-auto mt-4" style="max-width: 500px; box-shadow: 2px 2px 7px rgb(95, 95, 95) ;">
                    <div class="card-body ">
                        <h5 class="card-title mb-4">Add new Employee</h5>
                        <form id="add_ministry" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Name:</span><br />
                                    <input placeholder="Enter Name here." name="name" type="text" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Email:</span><br />
                                    <input placeholder="Enter Email here." name="email" type="email" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Password:</span><br />
                                    <input placeholder="Enter password here." type="password" name="pass" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">kids:</span><br />
                                    <input placeholder="Enter kids here." value="0" type="number" name="kids" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">bones:</span><br />
                                    <input placeholder="Enter bones here." value="0" type="number" name="bones" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">bank:</span><br />
                                    <input placeholder="Enter bank money here." value="0" type="number" name="bank" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">level:</span><br />
                                    <select name="level" class="form-control">
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Married:</span><br />
                                    <select name="married" class="form-control">
                                        <option value="yes">yes</option>
                                        <option value="no" selected>no</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Gender:</span><br />
                                    <select name="gender" class="form-control">
                                        <option value="male">male</option>
                                        <option value="female" selected>female</option>
                                    </select>
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
                                <div class="col-12 mb-3 position-relative">
                                    <span style="margin-bottom: 100px;">Building: <span id="building_name" class="text-primary"></span> </span>
                                    <input hidden id="idOf_building_id" type="text" name="building_id" class="form-control">
                                    <button id="select_building" type="button" class="btn btn-sm btn-primary position-absolute mr-3" style="right: 0px;">Select</button>
                                </div>
                                <div class="col-12 mb-3 position-relative">
                                    <span style="margin-bottom: 100px;">Job: <span id="job_name" class="text-primary"></span> </span>
                                    <input hidden id="idOf_job_id" type="text" name="job_id" class="form-control">
                                    <button id="select_job" type="button" class="btn btn-sm btn-primary position-absolute mr-3" style="right: 0px;">Select</button>
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
            $("#idOf_job_id").val("");
            $("#job_name").text("");
            $("#idOf_building_id").val("");
            $("#building_name").text("");
            $("#idOf_ministry_id").val(id);
            $("#minister_name").text($(`#rowName-${id}`).text());
            $("#mymodal2").modal("hide");
            $("#searchPlaceZone_Ministry").val("");
        }

        function jobSelect(id) {
            $("#idOf_job_id").val(id);
            $("#job_name").text($(`#rowName-${id}`).text());
            $("#mymodal2").modal("hide");
            $("#searchPlaceZone_Ministry").val("");
        }

        function buildingSelect(id) {
            $("#idOf_building_id").val(id);
            $("#building_name").text($(`#rowName-${id}`).text());
            $("#mymodal2").modal("hide");
            $("#searchPlaceZone_Ministry").val("");
        }

        function zoneSelect(id) {
            $("#idOf_zone_id").val(id);
            $("#zone_name").text($(`#rowName-${id}`).text());
            $("#mymodal2").modal("hide");
            $("#searchPlaceZone_Ministry").val("");
        }

        let zone = 1;

        function inputChange(i) {
            if (zone == 1) {
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
            } else if (zone == 0) {
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
            } else if (zone == 3) {
                $.post("searchMinistryBuildingsName.php", {
                    name: i.value,
                    ministry: $("#idOf_ministry_id").val()
                }, function(r) {
                    if (r.error) {
                        err_m(r.m);
                    } else {
                        $("#table_minister_select").html(r.m);
                        $("#mymodal2").modal("show");
                    }
                });
            } else {
                $.post("searchMinistryJobsName.php", {
                    name: i.value,
                    ministry: $("#idOf_ministry_id").val()
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
                zone = 0;
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
                zone = 1;
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

            $("#select_job").on("click", function() {
                zone = 2;
                if ($("#idOf_ministry_id").val() && $("#idOf_ministry_id").val().length > 0) {
                    $("#changableSelect").text("Zone");
                    $.post("searchMinistryJobsName.php", {
                        name: "",
                        ministry: $("#idOf_ministry_id").val()
                    }, function(r) {
                        if (r.error) {
                            err_m(r.m);
                        } else {
                            $("#table_minister_select").html(r.m);
                            $("#mymodal2").modal("show");
                        }
                    });

                    $("#mymodal2").modal("show");
                } else {
                    err_m("please select a ministry then job.")
                }
            });

            $("#select_building").on("click", function() {
                zone = 3;
                if ($("#idOf_ministry_id").val() && $("#idOf_ministry_id").val().length > 0) {
                    $("#changableSelect").text("Building");
                    $.post("searchMinistryBuildingsName.php", {
                        name: "",
                        ministry: $("#idOf_ministry_id").val()
                    }, function(r) {
                        if (r.error) {
                            err_m(r.m);
                        } else {
                            $("#table_minister_select").html(r.m);
                            $("#mymodal2").modal("show");
                        }
                    });

                    $("#mymodal2").modal("show");
                } else {
                    err_m("please select a ministry then job.")
                }
            });

            <?php if ($added) { ?>
                setTimeout(() => {
                    err_m("employee added successfully.")
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
                if (!form_data.get("email")) {
                    err_m("please enter Email.");
                    return;
                }

                if (!form_data.get("pass")) {
                    err_m("please enter Password.");
                    return;
                } else if (form_data.get("pass").length < 8) {
                    err_m("Password length must be 8 or more.");
                    return;
                }

                if (!form_data.get("kids") || form_data.get("kids").length == 0 ||
                    parseInt(form_data.get("bank")) < 0) {
                    err_m("please enter money in corect form.");
                    return;
                }
                if (!form_data.get("bones") || form_data.get("bones").length == 0 ||
                    parseInt(form_data.get("bones")) % 250 != 0 || parseInt(form_data.get("bones")) < 0) {
                    err_m("please enter money in corect form for bones money must be money%250 ==0 and be positive .");
                    return;
                }
                if (!form_data.get("bank") || form_data.get("bank").length == 0 ||
                    parseInt(form_data.get("bank")) % 250 != 0 || parseInt(form_data.get("bank")) < 0) {
                    err_m("please enter money in corect form for bank money must be money%250 ==0 and be positive .");
                    return;
                }
                if (!form_data.get("level")) {
                    err_m("please enter level and must be 1 or 2.");
                    return;
                }
                if (form_data.get(!("level") == "1" || form_data.get("level") == "1")) {
                    err_m("please select a level.");
                    return;
                }
                if (!form_data.get("married")) {
                    err_m("please select a married type.");
                    return;
                }

                if (form_data.get(!("married") == "yes" || form_data.get("married") == "no")) {
                    err_m("please select a married type.");
                    return;
                }
                if (!form_data.get("gender")) {
                    err_m("please select a married type.");
                    return;
                }
                if (form_data.get(!("gender") == "male" || form_data.get("gender") == "female")) {
                    err_m("please select a gender type.");
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

                if (!form_data.get("job_id")) {
                    err_m("please select a job.");
                    return;
                }
                let s = {
                    email: form_data.get("email"),
                    check: "yes",
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