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

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['sendmoney']) && $_POST['sendmoney'] == "yes") {
    if (isset($_POST['id']) && strlen($_POST['id']) != 0) {
        $id = $k->real_escape_string($_POST['id']);

        if ($_SESSION['type'] == "p") {
            $total = $k->query("SELECT      
            SUM(
                t2.start_salary + 
                if( t1.married = 'yes', t2.married_bones , 0 ) + (t1.kids * t2.per_kid) + (t1.bones + t2.bones ) + 			(t1.level*t2.per_level) + (t2.per_month * TIMESTAMPDIFF(MONTH, t1.created_date ,CURRENT_TIMESTAMP ))+ 		if(t1.zone_id = t3.zone_id , 0 , t2.outside_zone)  
            ) as 'salary'
            FROM 
            employees t1 join 
            jobs t2 join 
            building t3 join 
            zone t4 join 
            ministry t5 join 
            minister t6
                WHERE 
                t1.job_id = t2.id and
                t1.building_id = t3.id and
                t1.zone_id = t4.id and
                t3.ministry_id = t5.id and 
                t5.minister_id = t6.id and
                t5.id = '$id'
                group by t5.id");
        } else {
            $tempId = $_SESSION['id'];
            $total = $k->query("SELECT      
            SUM(
                t2.start_salary + 
                if( t1.married = 'yes', t2.married_bones , 0 ) + (t1.kids * t2.per_kid) + (t1.bones + t2.bones ) + 			(t1.level*t2.per_level) + (t2.per_month * TIMESTAMPDIFF(MONTH, t1.created_date ,CURRENT_TIMESTAMP ))+ 		if(t1.zone_id = t3.zone_id , 0 , t2.outside_zone)  
            ) as 'salary'
            FROM 
            employees t1 join 
            jobs t2 join 
            building t3 join 
            zone t4 join 
            ministry t5 join 
            minister t6
                WHERE 
                t1.job_id = t2.id and
                t1.building_id = t3.id and
                t1.zone_id = t4.id and
                t3.ministry_id = t5.id and 
                t5.minister_id = t6.id and
                t5.id = '$id' and 
                t6.id = '$tempId'
                group by t5.id");
        }

        if ($total->num_rows != 1) {
            send_error("server error");
        }

        $money;
        while ($getM = $total->fetch_assoc()) {
            $money = $getM['salary'];
        }
        // send_error($money);

        $k->query("update ministry set bank = bank - '$money' where ministry.id = '$id';");
        $k->query("    UPDATE employees t1  join 
        building t3 join
        jobs t2 
        set 
        t1.bank = t1.bank + (t2.start_salary + if(t1.married = 'yes', t2.married_bones , 0 ) + (t1.kids * t2.per_kid) +
        (t1.bones + t2.bones ) + (t1.level*t2.per_level) + (t2.per_month * TIMESTAMPDIFF(MONTH, t1.created_date ,CURRENT_TIMESTAMP ))+
        if(t1.zone_id = t3.zone_id , 0 , t2.outside_zone) )
        WHERE 
        t3.id = t1.building_id and 
        t1.job_id = t2.id and t3.ministry_id = '$id'");
        send_error("done");
    }
}

$page;
if (isset($_GET['page'])) {
    $page = (int) $_GET['page'] - 1;
} else {
    $page = 0;
}

$number = $k->real_escape_string($page);

$number = $page * 20;


if ($_SESSION['type'] == "p") {
    $res = $k->query("SELECT      
    t5.name as ministry_name ,
    SUM(
        t2.start_salary + 
        if( t1.married = 'yes', t2.married_bones , 0 ) + (t1.kids * t2.per_kid) + (t1.bones + t2.bones ) + 			(t1.level*t2.per_level) + (t2.per_month * TIMESTAMPDIFF(MONTH, t1.created_date ,CURRENT_TIMESTAMP ))+ 		if(t1.zone_id = t3.zone_id , 0 , t2.outside_zone)  
    ) as 'salary' , t5.id as 'id'
    FROM 
    employees t1 join 
    jobs t2 join 
    building t3 join 
    zone t4 join 
    ministry t5 join 
    minister t6
        WHERE 
        t1.job_id = t2.id and
        t1.building_id = t3.id and
        t1.zone_id = t4.id and
        t3.ministry_id = t5.id and 
        t5.minister_id = t6.id
        group by t5.id
        limit $number,20");
} else {
    $tempId = $_SESSION['id'];
    $res = $k->query("SELECT      
    t5.name as ministry_name ,
    SUM(
        t2.start_salary + 
        if( t1.married = 'yes', t2.married_bones , 0 ) + (t1.kids * t2.per_kid) + (t1.bones + t2.bones ) + 			(t1.level*t2.per_level) + (t2.per_month * TIMESTAMPDIFF(MONTH, t1.created_date ,CURRENT_TIMESTAMP ))+ 		if(t1.zone_id = t3.zone_id , 0 , t2.outside_zone)  
    ) as 'salary' , t5.id as 'id'
    FROM 
    employees t1 join 
    jobs t2 join 
    building t3 join 
    zone t4 join 
    ministry t5 join 
    minister t6
        WHERE 
        t1.job_id = t2.id and
        t1.building_id = t3.id and
        t1.zone_id = t4.id and
        t3.ministry_id = t5.id and 
        t5.minister_id = t6.id and 
        t5.minister_id = '$tempId'
        group by t5.id
        limit $number,20");
}
$number++;


if ($_SESSION['type'] == "p") {
    $num_all = $k->query("SELECT      
    t5.id as 'id'
    FROM 
    employees t1 join 
    jobs t2 join 
    building t3 join 
    zone t4 join 
    ministry t5 join 
    minister t6
        WHERE 
        t1.job_id = t2.id and
        t1.building_id = t3.id and
        t1.zone_id = t4.id and
        t3.ministry_id = t5.id and 
        t5.minister_id = t6.id
        group by t5.id");
} else {
    $tempId = $_SESSION['id'];
    $num_all = $k->query("SELECT      
    t5.id as 'id'
    FROM 
    employees t1 join 
    jobs t2 join 
    building t3 join 
    zone t4 join 
    ministry t5 join 
    minister t6
        WHERE 
        t1.job_id = t2.id and
        t1.building_id = t3.id and
        t1.zone_id = t4.id and
        t3.ministry_id = t5.id and 
        t5.minister_id = t6.id and 
        t5.minister_id = '$tempId'
        group by t5.id");
}
$num_all_rows_save = $num_all->num_rows;

$num_pages = ceil($num_all_rows_save / 20);


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
        $top1 = "Ministry list";
        $myname = basename($_SERVER["SCRIPT_FILENAME"], '.php') . ".php";
        require "../full_nav.php"; ?>

        <div class="content-wrapper cf">
            <div class="pt-2 pb-2">
                <div class="card ml-2 mr-2 " style="box-shadow: 1px 1px 3px rgb(110, 110, 110) ;">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-4">Send salary</h5>
                        <div class="row text-center">
                            <div class="col-md-6 col-sm-12">
                                <input onkeyup="inputChange(this);" style="max-width: 300px;" placeholder="search by name" type="text" class="form-control ml-auto mr-auto mb-3">
                            </div>
                            <div id="page_search" class="col-md-6 col-sm-12 mb-3">
                                Page:
                                <?php if (isset($_REQUEST['page']) && (int) $_REQUEST['page'] > 1) { ?>
                                    <button onclick="goToPage(<?php echo (int) $_REQUEST['page'] - 1; ?>)" style="line-height: 1.5; transform: translateY(-2px);" class="btn btn-secondary btn-sm">prev</button>
                                <?php } ?>
                                <select class="form-control-sm" style="width: auto; display: inline;" onchange="pageChange(this)">
                                    <?php for ($pagevalue = 1; $pagevalue <= $num_pages; $pagevalue++) { ?>
                                        <option <?php if (isset($_REQUEST['page'])) {
                                                    if ($_REQUEST['page'] == $pagevalue) {
                                                        echo "selected";
                                                    }
                                                } else {
                                                    if ($pagevalue == 1) {
                                                        echo "selected";
                                                    }
                                                } ?> value="<?php echo $pagevalue; ?>"><?php echo $pagevalue; ?></option>
                                    <?php } ?>
                                </select>
                                <?php if (!isset($_REQUEST['page']) && $num_pages > 1) { ?>
                                    <button onclick="goToPage(2)" style="line-height: 1.5; transform: translateY(-2px);" class="btn btn-secondary btn-sm">prev</button>
                                <?php } else if (isset($_REQUEST['page']) && (int) $_REQUEST['page'] < $num_pages) { ?>
                                    <button onclick="goToPage(<?php echo (int) $_REQUEST['page'] + 1; ?>)" style="line-height: 1.5; transform: translateY(-2px);" class="btn btn-secondary btn-sm">prev</button>
                                <?php } ?>
                            </div>
                        </div>
                        <table class="table table-hover table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Ministry</th>
                                    <th scope="col">Salary</th>
                                    <th scope="col">Send</th>

                                </tr>
                            </thead>
                            <tbody id="table_body">

                                <?php while ($fetch = $res->fetch_assoc()) { ?>
                                    <tr id="rowId-<?php echo $fetch['id']; ?>">
                                        <td><?php echo $fetch['ministry_name'] ?></td>
                                        <td><?php echo number_format($fetch['salary']); ?></td>
                                        <td><button onclick="sendMoney(<?php echo $fetch['id']; ?>)" class="btn btn-primary btn-sm">Send Salary</button></td>
                                    </tr>
                                <?php $number++;
                                } ?>

                            </tbody>
                        </table>
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
                    <button id="close_modal" type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
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
                    Are you sure to SEND salary?
                    <input id="ministry_id_for_salary_send" value="" hidden />
                </div>
                <div class="modal-footer">
                    <button id="yes_prompt_modal" onclick="superSend()" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                    <button id="cancle_prompt_modal" type="button" class="btn btn-primary" data-dismiss="modal">Cancle</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../helper/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../script/layout.js"></script>
    <script src="../script/login.js"></script>
    <script>
        function err_m(s) {
            $("#modal_body").text(s);
            $("#mymodal").modal("show");
        }

        function pageChange(selected) {
            window.location.href = `<?php echo $_SERVER['PHP_SELF'] ?>?page=${selected.value}`;
        }

        function goToPage(n) {
            window.location.href = `<?php echo $_SERVER['PHP_SELF']; ?>?page=${n}`;
        }

        function superSend() {

            s = {
                id: $("#ministry_id_for_salary_send").val(),
                sendmoney: "yes"
            }

            $.post("<?php echo $_SERVER['PHP_SELF'] ?>", s, function(r) {
                $("#promptModal").modal("hide");
                err_m(r.m);
            });



        }

        function sendMoney(id) {
            $("#promptModal").modal("show");
            $("#ministry_id_for_salary_send").val("" + id);
        }

        function inputChange(i) {
            if (i.value == "") {
                const urlParams = new URLSearchParams(window.location.search);
                const page = urlParams.get('page');
                if (page) {
                    window.location.href = `<?php echo $_SERVER['PHP_SELF']; ?>?page=${page}`;
                } else {
                    window.location.href = `<?php echo $_SERVER['PHP_SELF']; ?>`;
                }
            }
            $("#page_search").remove();
            $.post("searchMinstriesName2.php", {
                name: i.value
            }, function(r) {
                if (r.error) {
                    err_m(r.m);
                } else {
                    $("#table_body").html(r.m);
                }
            });
        }

        let Id;

        function deleteId(id) {

        }

        $(() => {

            $("#close_modal").on("click", function() {
                $("#mymodal").modal("hide");
            })
            $("#cancle_prompt_modal").on("click", function() {
                $("#promptModal").modal("hide");
            })

            $("#cross_modalP").on("click", function() {
                $("#promptModal").modal("hide");
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