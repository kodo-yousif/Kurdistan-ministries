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
            <div style="margin-left:auto;" id="top_nav_user"><img src="./assets/kurstan.png" alt="kurdtan logo" id="k_logo_top">Not Found</div>
            <ul class="navbar-nav" style="margin-left:auto;">
                <li class="nav-item">
                    <a id="max_shasha" class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i id="arrow_screen" class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index.php" class="brand-link">
                <img style="background:white;" src="./assets/kurstan.png" alt="Kurdistan logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">KURDISTAN</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="./assets/classy.jpg" class="img-circle elevation-2" alt="temp">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Not Found</a>
                    </div>
                </div>
            </div>
        </aside>

        <div class="content-wrapper cf" id="main_content">
            <div class="p-2">
                <div class="card mb-5 ml-auto mr-auto " style="max-width: 500px; box-shadow: 2px 2px 7px rgb(95, 95, 95) ;">
                    <div class="card-body p-4 text-center">
                        <h5 class="ml-auto mr-auto mb-4">Page not found</h5>
                        <img class="ml-auto mr-auto" src="assets/404.png" alt="Not Found image">
                        <br />
                        <a href="index.php" class="btn btn btn-warning">Home</a>
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