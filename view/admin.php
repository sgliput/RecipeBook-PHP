<?php
use Utilities as Utility;
session_start();
require_once('../util/security.php');

// confirm user is authorized for the page
Utility\Security::checkAuthority('admin');

// user clicked the logout button
if (isset($_POST['logout'])) {
    Utility\Security::logout();
}
?>
<html>
<head>
    <title>Sam Liput Final Practical</title>
</head>

<body>
    <h1>Sam Liput Final Practical</h1>
    <h2>Administrator Options</h2>

    <ul>
        <li>
            <h3><a href="./display_users.php">Manage Users</a></h3>
        </li>
        <li>
            <h3><a href="./image_upload.php">Manage Images</a></h3>
        </li>

    </ul>    
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>