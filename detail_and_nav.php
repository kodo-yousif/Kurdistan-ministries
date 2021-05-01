<nav class="main-header navbar navbar-expand navbar-white navbar-light www-3 cf" id="nl_3xat">
    <ul class="navbar-nav dammaxa1">
        <li class="nav-item prevent_opp dammaxa2">
            <a class="nav-link dammaxa3" id="side_toggle" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars dammaxa4"></i></a>
        </li>
    </ul>
    <div style="margin-left:auto;" id="top_nav_user"><img src="./assets/kurstan.png" alt="kurdtan logo" id="k_logo_top"><?php echo $top1; ?></div>
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
                <a href="#" class="d-block"><?php echo $_SESSION['name']; ?></a>
            </div>
        </div>


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item mt-2">
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="nav-link <?php if ($myname == "index.php") {
                                                                                        echo "active";
                                                                                    } ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>

                <?php if ($_SESSION['type'] == "e" && $_SESSION['level'] == "2") { ?>
                    <li class="nav-item mt-2">
                        <a href="buildings/myBuilding.php" class="nav-link <?php if ($myname == "myBuilding.php") {
                                                                                echo "active";
                                                                            } ?>">
                            <i class="nav-icon fas fa-building"></i>
                            <p>
                                My Building
                            </p>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['type'] == "p") { ?>
                    <li class="nav-item menu-close have-child">
                        <a href="#" class="nav-link <?php if ($myname == "minister_list.php" || $myname == "add_minister.php" || $myname == "ministerId.php") {
                                                        echo "active";
                                                    } ?>">
                            <i class="nav-icon fas fa-id-card"></i>
                            <p>
                                Ministers
                                <i class="right fas fa-angle-left sahm-rotate"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview the-child">
                            <?php if ($_SESSION['type'] == "p") { ?>
                                <li class="nav-item">
                                    <a href="/minister/minister_list.php" class="nav-link <?php if ($myname == "minister_list.php") {
                                                                                                echo "active";
                                                                                            } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>See ministers</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($_SESSION['type'] == "p") { ?>
                                <li class="nav-item">
                                    <a href="/minister/add_minister.php" class="nav-link <?php if ($myname == "add_minister.php") {
                                                                                                echo "active";
                                                                                            } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add minister</p>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m") { ?>
                    <li class="nav-item menu-close have-child">
                        <a href="#" class="nav-link <?php if ($myname == "ministry_list.php" || $myname == "add_ministry.php" || $myname == "ministryUpdate.php") {
                                                        echo "active";
                                                    } ?>">
                            <i class="nav-icon fas fa-landmark"></i>
                            <p>
                                Ministries
                                <i class="right fas fa-angle-left sahm-rotate"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview the-child">
                            <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m") { ?>
                                <li class="nav-item">
                                    <a href="/ministries/ministry_list.php" class="nav-link <?php if ($myname == "ministry_list.php") {
                                                                                                echo "active";
                                                                                            } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>See Ministries</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($_SESSION['type'] == "p") { ?>
                                <li class="nav-item">
                                    <a href="/ministries/add_ministry.php" class="nav-link <?php if ($myname == "add_ministry.php") {
                                                                                                echo "active";
                                                                                            } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Ministry</p>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m") { ?>
                    <li class="nav-item menu-close have-child">
                        <a href="#" class="nav-link <?php if ($myname == "addZone.php" || $myname == "seeZone.php") {
                                                        echo "active";
                                                    } ?>">
                            <i class="nav-icon fas fa-globe-americas"></i>
                            <p>
                                zone
                                <i class="right fas fa-angle-left sahm-rotate"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview the-child">
                            <?php if ($_SESSION['type'] == "p"  || $_SESSION['type'] == "m") { ?>
                                <li class="nav-item">
                                    <a href="/zone/addZone.php" class="nav-link <?php if ($myname == "addZone.php") {
                                                                                    echo "active";
                                                                                } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add zone</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($_SESSION['type'] == "p"  || $_SESSION['type'] == "m") { ?>
                                <li class="nav-item">
                                    <a href="/zone/seeZone.php" class="nav-link <?php if ($myname == "seeZone.php") {
                                                                                    echo "active";
                                                                                } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>See zones</p>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m") { ?>
                    <li class="nav-item menu-close have-child">
                        <a href="#" class="nav-link <?php if ($myname == "seeJobs.php" || $myname == "addJobs.php" || $myname == "jobsUpdate.php") {
                                                        echo "active";
                                                    } ?>">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>
                                jobs
                                <i class="right fas fa-angle-left sahm-rotate"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview the-child">
                            <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m") { ?>
                                <li class="nav-item">
                                    <a href="/jobs/addJobs.php" class="nav-link <?php if ($myname == "addJobs.php") {
                                                                                    echo "active";
                                                                                } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add jobs</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m") { ?>
                                <li class="nav-item">
                                    <a href="/jobs/seeJobs.php" class="nav-link <?php if ($myname == "seeJobs.php") {
                                                                                    echo "active";
                                                                                } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>See jobs</p>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m") { ?>
                    <li class="nav-item menu-close have-child">
                        <a href="#" class="nav-link <?php if ($myname == "seeEmployees.php" || $myname == "addEmployees.php" || $myname == "employeesUpdate.php") {
                                                        echo "active";
                                                    } ?>">
                            <i class="nav-icon fas fa-network-wired"></i>
                            <p>
                                employees
                                <i class="right fas fa-angle-left sahm-rotate"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview the-child">
                            <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m") { ?>
                                <li class="nav-item">
                                    <a href="/employees/addEmployees.php" class="nav-link <?php if ($myname == "addEmployees.php") {
                                                                                                echo "active";
                                                                                            } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add employees</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m") { ?>
                                <li class="nav-item">
                                    <a href="/employees/seeEmployees.php" class="nav-link <?php if ($myname == "seeEmployees.php") {
                                                                                                echo "active";
                                                                                            } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>See employees</p>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m") { ?>
                    <li class="nav-item menu-close have-child">
                        <a href="#" class="nav-link <?php if ($myname == "addBuildings.php" || $myname == "seeBuildings.php" || $myname == "buildingUpdate.php") {
                                                        echo "active";
                                                    } ?>">
                            <i class="nav-icon fas fa-building"></i>
                            <p>
                                Buildings
                                <i class="right fas fa-angle-left sahm-rotate"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview the-child">
                            <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m") { ?>
                                <li class="nav-item">
                                    <a href="/buildings/addBuildings.php" class="nav-link <?php if ($myname == "addBuildings.php") {
                                                                                                echo "active";
                                                                                            } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Building</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m") { ?>
                                <li class="nav-item">
                                    <a href="/buildings/seeBuildings.php" class="nav-link <?php if ($myname == "seeBuildings.php") {
                                                                                                echo "active";
                                                                                            } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>See Buildings</p>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['type'] == "p") { ?>
                    <li class="nav-item menu-close have-child">
                        <a href="#" class="nav-link <?php if ($myname == "addAdmin.php" || $myname == "seeAdmin.php" || $myname == "updateAdmin.php") {
                                                        echo "active";
                                                    } ?>">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                Admins
                                <i class="right fas fa-angle-left sahm-rotate"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview the-child">
                            <?php if ($_SESSION['type'] == "p") { ?>
                                <li class="nav-item">
                                    <a href="/admin/addAdmin.php" class="nav-link <?php if ($myname == "addAdmin.php") {
                                                                                        echo "active";
                                                                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Admin</p>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($_SESSION['type'] == "p") { ?>
                                <li class="nav-item">
                                    <a href="/admin/seeAdmin.php" class="nav-link <?php if ($myname == "seeAdmin.php") {
                                                                                        echo "active";
                                                                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>See Admins</p>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m" || ($_SESSION['type'] == "e" && $_SESSION['level'] == "2")) { ?>
                    <li class="nav-item menu-close have-child">
                        <a href="#" class="nav-link <?php if ($myname == "employeeList.php" || $myname == "buildingList.php" || $myname == "ministryList.php") {
                                                        echo "active";
                                                    } ?>">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Statistics
                                <i class="right fas fa-angle-left sahm-rotate"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview the-child">
                            <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m" || ($_SESSION['type'] == "e" && $_SESSION['level'] == "2")) { ?>
                                <li class="nav-item">
                                    <a href="/statistics/employeeList.php" class="nav-link <?php if ($myname == "employeeList.php") {
                                                                                                echo "active";
                                                                                            } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Employees list</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($_SESSION['type'] == "p" || $_SESSION['type'] == "m") { ?>
                                <li class="nav-item">
                                    <a href="/statistics/buildingList.php" class="nav-link <?php if ($myname == "buildingList.php") {
                                                                                                echo "active";
                                                                                            } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Building list</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($_SESSION['type'] == "p") { ?>
                                <li class="nav-item">
                                    <a href="/statistics/ministryList.php" class="nav-link <?php if ($myname == "ministryList.php") {
                                                                                                echo "active";
                                                                                            } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ministry list</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['type'] == "e") { ?>
                    <li class="nav-item mt-2">
                        <a href="statistics/employeeInfo.php" class="nav-link <?php if ($myname == "employeeInfo.php") {
                                                                                    echo "active";
                                                                                } ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>
                                My Info
                            </p>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($_SESSION['type'] == "e") { ?>
                    <li class="nav-item mt-2">
                        <a href="statistics/wallet.php" class="nav-link <?php if ($myname == "wallet.php") {
                                                                            echo "active";
                                                                        } ?>">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>
                                My Wallet
                            </p>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($_SESSION['type'] == "m" || $_SESSION['type'] == "p") { ?>
                    <li class="nav-item mt-2">
                        <a href="ministries/sendSalary.php" class="nav-link <?php if ($myname == "sendSalary.php") {
                                                                                echo "active";
                                                                            } ?>">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>
                                Send salary
                            </p>
                        </a>
                    </li>
                <?php } ?>
                <form method="POST" id="log_out" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="nav-item mt-2">
                    <input type="text" value="yes" name="log_out" hidden />
                    <a href="#" onclick="document.getElementById('log_out').submit();" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Log out
                        </p>
                    </a>
                </form>
            </ul>
        </nav>
    </div>
</aside>