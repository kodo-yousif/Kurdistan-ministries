<?php
if (!isset($_SESSION['type']) && !isset($_SESSION['id']) && !isset($_SESSION['level']) && !isset($_SESSION['name'])) {
    header('Location: ..login.php');
}
