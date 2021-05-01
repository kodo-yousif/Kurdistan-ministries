<?php

require '../db.php';
require '../secure.php';
$error = False;
$message = "name used before";
$added = FALSE;
if (!($_SESSION['type'] == "p" || $_SESSION['type'] == "m")) {
    header("location: ../index.php");
    exit();
}




if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete']) && $_POST['delete'] == "yes") {
    if (isset($_POST['id'])) {
        $id = $k->real_escape_string($_POST['id']);
        $k->query("delete from jobs where id = '$id';");
        if (!$k->error) {
            header('Content-Type: application/json');
            echo json_encode(array("m" => "done", "error" => FALSE));
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['for_adding']) && $_POST['for_adding'] == "yes") {

    if (
        isset($_POST['name']) && strlen($_POST['name']) != 0 &&
        isset($_POST['ministry_id']) && strlen($_POST['ministry_id']) != 0 &&
        isset($_POST['start_salary']) && strlen($_POST['start_salary']) != 0 &&
        isset($_POST['bones']) && strlen($_POST['bones']) != 0 &&
        isset($_POST['per_kid']) && strlen($_POST['per_kid']) != 0 &&
        isset($_POST['per_month']) && strlen($_POST['per_month']) != 0 &&
        isset($_POST['per_level']) && strlen($_POST['per_level']) != 0 &&
        isset($_POST['married_bones']) && strlen($_POST['married_bones']) != 0 &&
        isset($_POST['outside_zone']) && strlen($_POST['outside_zone']) != 0
    ) {
        $name = $k->real_escape_string($_POST['name']);
        $ministry_id = $k->real_escape_string($_POST['ministry_id']);
        $start_salary = $k->real_escape_string($_POST['start_salary']);
        $bones = $k->real_escape_string($_POST['bones']);
        $per_kid = $k->real_escape_string($_POST['per_kid']);
        $per_month = $k->real_escape_string($_POST['per_month']);
        $per_level = $k->real_escape_string($_POST['per_level']);
        $married_bones = $k->real_escape_string($_POST['married_bones']);
        $outside_zone = $k->real_escape_string($_POST['outside_zone']);
        $id = $k->real_escape_string($_REQUEST['id']);

        $res = $k->query("SELECT * FROM jobs Where name = '$name' and ministry_id = '$ministry_id' and id <> '$id';");
        // echo "SELECT * FROM jobs Where name = '$name' and ministry_id = '$ministry_id' and id <> '$id';";
        // exit();
        if ($res->num_rows > 0) {
            $error = TRUE;
            $message = "name used before";
        }

        if (!$error) {
            $k->query("update jobs set name = '$name' , ministry_id='$ministry_id' , start_salary = '$start_salary' ,
         bones = '$bones' , per_kid = '$per_kid' , per_month = '$per_month' , per_level = '$per_level' ,
          married_bones = '$married_bones' , outside_zone = '$outside_zone' where id='$id' ;");
            if (!$k->error) {
                $added = TRUE;
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['log_out']) && $_POST['log_out'] == "yes") {
    session_destroy();
    header("location: ../login.php");
    exit();
}

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

    $name = $k->real_escape_string($_POST['name']);
    $ministry = $k->real_escape_string($_POST['ministry']);
    $id = $k->real_escape_string($_POST['id']);

    $res = $k->query("SELECT * FROM jobs Where name = '$name' and ministry_id = '$ministry' and id <> '$id';");

    if ($res->num_rows > 0) {
        send_error("this name used bofore.");
    }




    header('Content-Type: application/json');
    echo json_encode(array("error" => FALSE));
    exit();
}
if (isset($_REQUEST['id']) &&  strlen($_REQUEST['id']) != 0) {
    $id = $k->real_escape_string($_REQUEST['id']);


    if ($_SESSION['type'] == "p") {
        $res = $k->query("select t1.name , t1.ministry_id , t1.start_salary , t1.bones , t1.per_kid , t1.per_month , t1.per_level , t1.married_bones , t1.outside_zone , t2.name 'ministry_name' from jobs t1 join ministry t2 where t1.id = $id and t1.ministry_id = t2.id");
    } else if ($_SESSION['type'] == "m") {
        $tempId = $_SESSION['id'];
        $res = $k->query("select t1.name , t1.ministry_id , t1.start_salary , t1.bones , t1.per_kid , t1.per_month , t1.per_level , t1.married_bones , t1.outside_zone , t2.name 'ministry_name' from jobs t1 join ministry t2 where t1.id = $id and t1.ministry_id = t2.id and t2.minister_id= '$tempId'");
    }

    if ($res->num_rows == 0) {
        header("location: seeJobs.php");
    }

    while ($data = $res->fetch_assoc()) {
        $name = $data['name'];
        $ministry_id = $data['ministry_id'];
        $start_salary = $data['start_salary'];
        $bones = $data['bones'];
        $per_kid = $data['per_kid'];
        $per_month = $data['per_month'];
        $per_level = $data['per_level'];
        $married_bones = $data['married_bones'];
        $outside_zone = $data['outside_zone'];
        $ministry_name = $data['ministry_name'];
    }
} else {
    header("location: seeJobs.php");
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
        $top1 = "Update job";
        $myname = basename($_SERVER["SCRIPT_FILENAME"], '.php') . ".php";
        require "../full_nav.php"; ?>

        <div class="content-wrapper cf" id="main_content">
            <!-- <a href="#" data-toggle="modal" data-target="#mymodal">yalla</a> -->

            <div class="container" style="align-content: center;">

                <div class="card mb-5 ml-auto mr-auto mt-4" style="max-width: 500px; box-shadow: 2px 2px 7px rgb(95, 95, 95) ;">
                    <div class="card-body ">
                        <h5 class="card-title mb-4">update job: <?php echo $name; ?></h5>
                        <form id="add_ministry" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Name:</span><br />
                                    <input value="<?php echo $name; ?>" placeholder="Enter Name here." name="name" type="text" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Start salary:</span><br />
                                    <input value="<?php echo $start_salary; ?>" placeholder="Enter start salary here." value="0" type="number" name="start_salary" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Bones:</span><br />
                                    <input value="<?php echo $bones; ?>" placeholder="Enter Bones here." value="0" type="number" name="bones" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Per Kid:</span><br />
                                    <input value="<?php echo $per_kid; ?>" placeholder="Enter Per kid here." value="0" type="number" name="per_kid" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Per Month:</span><br />
                                    <input value="<?php echo $per_month; ?>" placeholder="Enter Per Month here." value="0" type="number" name="per_month" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Per Level:</span><br />
                                    <input value="<?php echo $per_level; ?>" placeholder="Enter Per Level here." value="0" type="number" name="per_level" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Married bones:</span><br />
                                    <input value="<?php echo $married_bones; ?>" placeholder="Enter married bones here." value="0" type="number" name="married_bones" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <span style="margin-bottom: 100px;">Outside Zone:</span><br />
                                    <input value="<?php echo $outside_zone; ?>" placeholder="Enter outside zone here." value="0" type="number" name="outside_zone" class="form-control">
                                </div>
                                <input hidden value="<?php echo $id; ?>" type="text" name="id">
                                <div class="col-12 mb-3 position-relative">
                                    <span style="margin-bottom: 100px;">ministry: <span id="minister_name" class="text-primary"><?php echo $ministry_name; ?></span> </span>
                                    <input hidden value="<?php echo $ministry_id; ?>" id="idOf_ministry_id" type="text" name="ministry_id" class="form-control">
                                    <input hidden value="yes" name="for_adding" type="text" />
                                    <button id="select_minister" type="button" class="btn btn-sm btn-primary position-absolute mr-3" style="right: 0px;">Select</button>
                                </div>
                            </div>
                            <div style="display: flex; width: 100%; justify-content: center; flex-direction: column;">
                                <button id="addmm" style="width: 77px;" type="button" class="btn btn-sm btn-primary ml-auto mr-auto mb-2">update</button>
                                <button type="button" style="width: 77px;" onclick="$('#promptModal').modal('show');" class="btn btn-sm btn-danger ml-auto mr-auto mb-2">delete</button>
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
    <div class="modal fade" id="promptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Alert</h5>
                    <button type="button" class="close cross_modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="prompt_body" class="modal-body">
                    You are sure to delete this job?
                </div>
                <div class="modal-footer">
                    <button onclick="deleteMe()" type="button" class="btn btn-danger yes_prompt_modal" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-primary cancle_prompt_modal" data-dismiss="modal">Cancle</button>
                </div>
            </div>
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

        function deleteMe() {
            $.post("<?php echo $_SERVER['PHP_SELF']; ?>", {
                id: <?php echo $id; ?>,
                delete: "yes"
            }, () => {
                window.location.href = "seeJobs.php"
            })
        }

        function ministrySelect(id) {
            $("#idOf_ministry_id").val(id);
            $("#minister_name").text($(`#rowName-${id}`).text());
            $("#mymodal2").modal("hide");
        }

        function inputChange(i) {
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

        $(() => {


            $("#select_minister").on("click", function() {

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

            <?php if ($added) { ?>
                setTimeout(() => {
                    err_m("job updated successfully.")
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

            $(".cancle_prompt_modal").on("click", function() {
                $("#promptModal").modal("hide");
            })

            $(".cross_modal").on("click", function() {
                $("#promptModal").modal("hide");
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
                if (!form_data.get("start_salary") || form_data.get("start_salary").length == 0 ||
                    parseInt(form_data.get("start_salary")) % 250 != 0 || parseInt(form_data.get("start_salary")) < 0) {
                    err_m("please enter money in corect form for start salary must be money%250 ==0 and be positive .");
                    return;
                }

                if (!form_data.get("bones") || form_data.get("bones").length == 0 ||
                    parseInt(form_data.get("bones")) % 250 != 0 || parseInt(form_data.get("bones")) < 0) {
                    err_m("please enter money in corect form for bones must be money%250 ==0 and be positive .");
                    return;
                }
                if (!form_data.get("per_kid") || form_data.get("per_kid").length == 0 ||
                    parseInt(form_data.get("per_kid")) % 250 != 0 || parseInt(form_data.get("per_kid")) < 0) {
                    err_m("please enter money in corect form for per kid must be money%250 ==0 and be positive .");
                    return;
                }
                if (!form_data.get("per_month") || form_data.get("per_month").length == 0 ||
                    parseInt(form_data.get("per_month")) % 250 != 0 || parseInt(form_data.get("per_month")) < 0) {
                    err_m("please enter money in corect form for per month must be money%250 ==0 and be positive .");
                    return;
                }
                if (!form_data.get("per_level") || form_data.get("per_level").length == 0 ||
                    parseInt(form_data.get("per_level")) % 250 != 0 || parseInt(form_data.get("per_level")) < 0) {
                    err_m("please enter money in corect form for per level must be money%250 ==0 and be positive .");
                    return;
                }
                if (!form_data.get("married_bones") || form_data.get("married_bones").length == 0 ||
                    parseInt(form_data.get("married_bones")) % 250 != 0 || parseInt(form_data.get("married_bones")) < 0) {
                    err_m("please enter money in corect form for married bones zone must be money%250 ==0 and be positive .");
                    return;
                }
                if (!form_data.get("outside_zone") || form_data.get("outside_zone").length == 0 ||
                    parseInt(form_data.get("outside_zone")) % 250 != 0 || parseInt(form_data.get("outside_zone")) < 0) {
                    err_m("please enter money in corect form for outside zone must be money%250 ==0 and be positive .");
                    return;
                }

                if (!form_data.get("ministry_id")) {
                    err_m("please select a ministry.");
                    return;
                }
                let s = {
                    name: form_data.get("name"),
                    ministry: parseInt(form_data.get("ministry_id")),
                    check: "yes",
                    id: "<?php echo $id; ?>"
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