<?php
require_once('./util/security.php');
session_start();
Utilities\Security::checkHTTPS();

$_SESSION['working_dir'] = getcwd();

header('Location: view/login.php');