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

if (isset($_SESSION['id']) &&  strlen($_SESSION['id']) != 0) {
    $id = $k->real_escape_string($_SESSION['id']);

    $res = $k->query("SELECT 
        t1.id , t1.created_date, t1.name , t1.email , t1.kids , t1.bones , t1.bank , t1.level , t1.married , t1.gender ,
        (t2.start_salary + if(t1.married = 'yes', t2.married_bones , 0 ) + (t1.kids * t2.per_kid) +
        (t1.bones + t2.bones ) + (t1.level*t2.per_level) + (t2.per_month * TIMESTAMPDIFF(MONTH, t1.created_date ,CURRENT_TIMESTAMP ))+
        if(t1.zone_id = t3.zone_id , 0 , t2.outside_zone) ) as 'nextMONTH', 
        TIMESTAMPDIFF(MONTH, t1.created_date ,CURRENT_TIMESTAMP ) as 'months',
        t5.id ministry_id , t5.name  ministry_name ,
        t1.job_id , t2.name job_name ,
        t1.building_id , t3.name building_name ,
        t1.zone_id , t4.name zone_name
        from
        employees t1 join 
        jobs t2 join 
        building t3 join 
        zone t4 JOIN
        ministry t5 
        WHERE
        t1.job_id = t2.id and 
        t1.building_id = t3.id and 
        t1.zone_id = t4.id and 
        t3.ministry_id = t5.id and t1.id = '$id';");


    if ($res->num_rows == 0) {
        header("location: ../index.php");
    }

    while ($data = $res->fetch_assoc()) {
        $id = $data['id'];
        $next = $data['nextMONTH'];
        $created_date = $data['created_date'];
        $name = $data['name'];
        $email = $data['email'];
        $kids = $data['kids'];
        $months = $data['months'];
        $bones = $data['bones'];
        $bank = $data['bank'];
        $level = $data['level'];
        $married = $data['married'];
        $gender = $data['gender'];
        $ministry_id = $data['ministry_id'];
        $ministry_name = $data['ministry_name'];
        $building_id = $data['building_id'];
        $building_name = $data["building_name"];
        $zone_id = $data['zone_id'];
        $zone_name = $data['zone_name'];
        $job_id = $data['job_id'];
        $job_name = $data['job_name'];
    }
} else {
    header("location: ../index.php");
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
        $top1 = "see Info";
        $myname = basename($_SERVER["SCRIPT_FILENAME"], '.php') . ".php";
        require "../full_nav.php"; ?>

        <div class="content-wrapper cf" id="main_content">
            <div class="container" style="align-content: center;">

                <div class="card mb-5 ml-auto mr-auto mt-4" style="box-shadow: 2px 2px 7px rgb(95, 95, 95) ;">
                    <div class="card-body ">
                        <h5 class="card-title mb-4">Welcom: <?php if ($gender == "male") {
                                                                echo "Mr. ";
                                                            } else {
                                                                echo "Mrs. ";
                                                            }
                                                            echo $name; ?> </h5>

                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">Name:</span><br />
                                <input disabled value="<?php echo $name ?>" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">Email:</span><br />
                                <input disabled value="<?php echo $email ?>" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">bank:</span><br />
                                <input disabled value="<?php echo $bank ?>" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">Job:</span><br />
                                <input disabled value="<?php echo $job_name ?>" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">Next months salary:</span><br />
                                <input disabled value="<?php echo number_format($next) ?>" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">kids:</span><br />
                                <input disabled value="<?php echo $kids ?>" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">bones:</span><br />
                                <input disabled value="<?php echo $bones ?>" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">level:</span><br />
                                <input disabled value="<?php echo $level ?>" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">Married:</span><br />
                                <input disabled value="<?php echo $married ?>" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">Gender:</span><br />
                                <input disabled value="<?php echo $gender ?>" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">Ministry:</span><br />
                                <input disabled value="<?php echo $ministry_name ?>" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">Zone:</span><br />
                                <input disabled value="<?php echo $zone_name ?>" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">Building:</span><br />
                                <input disabled value="<?php echo $building_name ?>" type="text" class="form-control">
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">Start Date:</span><br />
                                <input disabled value="<?php echo $created_date ?>" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 p-2 mb-3">
                                <span style="margin-bottom: 100px;">Months worked:</span><br />
                                <input disabled value="<?php echo $months ?>" type="text" class="form-control">
                            </div>


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

    <script src="../helper/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../script/layout.js"></script>
    <script src="../script/login.js"></script>

</body>

</html>