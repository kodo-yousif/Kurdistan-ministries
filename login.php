<?php
require 'db_connect.php';

if (isset($_SESSION['type'])) {
    header('location: index.php');
}

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
        <nav class="main-header navbar navbar-expand navbar-white navbar-light www-3 cf" id="nl_3xat">
            <ul class="navbar-nav dammaxa1">
                <li class="nav-item prevent_opp dammaxa2">
                    <a class="nav-link dammaxa3" id="side_toggle" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars dammaxa4"></i></a>
                </li>
            </ul>
            <div style="margin-left:auto;" id="top_nav_user"><img src="./assets/kurstan.png" alt="kurdtan logo" id="k_logo_top">Log in</div>
            <ul class="navbar-nav" style="margin-left:auto;">
                <li class="nav-item">
                    <a id="max_shasha" class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i id="arrow_screen" class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index3.html" class="brand-link">
                <img style="background:white;" src="./assets/kurstan.png" alt="Kurdistan logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">KURDISTAN</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item mt-2">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-sign-in-alt"></i>
                                <p>
                                    Logn in
                                </p>
                            </a>
                        </li>
                    </ul>
                    <!-- <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-close have-child">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Starter Pages
                                    <i class="right fas fa-angle-left sahm-rotate"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview the-child">
                                <li class="nav-item">
                                    <a href="#" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Active Page</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Inactive Page</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item mt-2">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Simple Link
                                </p>
                            </a>
                        </li>
                    </ul> -->
                </nav>
            </div>
        </aside>

        <div class="content-wrapper cf" id="main_content">

            <div id="login_card" class="shadow p-3 mb-5 bg-white rounded">
                <img class="png_shadow_c" src="./assets/kurstan.png" alt="kurdistan logo">
                </img>
                </br>
                <form id="login_form" method="POST" action="log_sub.php" onsubmit="form_log_in_submited(event)">
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text remove_border"><i class="fas fa-user l_i_logo"></i></div>
                        </div>
                        <input name="email" type="email" class="form-control l_i_input" placeholder="Email">
                    </div>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text remove_border"><i class="fas fa-lock l_i_logo"></i></div>
                        </div>
                        <input name="password" type="password" class="form-control l_i_input" placeholder="Password">
                    </div>
                    <div class="super_text_left text-danger" id="login_errors">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Login <i class="fas fa-sign-in-alt"></i></button>
                </form>
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
</body>

</html>