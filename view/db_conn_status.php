<?php

use Models as Model;
use Utilities as Utility;

session_start();
require_once('../model/database.php');
require_once('../util/security.php');

// confirm user is authorized for the page
Utility\Security::checkAuthority('tech');

// user clicked the logout button
if (isset($_POST['logout'])) {
    Utility\Security::logout();
}

// set error reporting to errors only
error_reporting(E_ERROR);

// create an instance of the Database class
$db = new Model\Database();
?>

<html>
<head>
    <title>Sam Liput Final Practical</title>
</head>

<body>
    <h1>Sam Liput Final Practical</h1>
    <h1>Database Connection Status</h1>
    <?php if (strlen($db->getDbError())) : ?>
        <h2><?php echo $db->getDbError(); ?></h2>
        <?php else : ?>
        <ul>
            <li><?php echo "Database Name: "
                . $db->getDbName(); ?></li>
            <li><?php echo "Database User: "
                . $db->getDbUser(); ?></li>
            <li><?php echo "Database User Password: "
                . $db->getDbUserPw(); ?></li>
        </ul>
        <h2><?php echo "Connection Successful" ?></h2>
    <?php endif; ?>
    <h3><a href="tech.php">Home</a></h3>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>