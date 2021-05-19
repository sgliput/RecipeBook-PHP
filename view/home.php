<?php
// errors occur if I don't alias these namespaces
use Controllers as Controller;
use Utilities as Utility;

session_start();
require_once('../controller/user.php');
require_once('../controller/user_controller.php');
require_once('../util/security.php');

// confirm user is authorized for the page
Utility\Security::checkAuthority('admin');

// user clicked the logout button
if (isset($_POST['logout'])) {
    Utility\Security::logout();
}

if (isset($_POST['update'])) {
    // update button pressed for a user
    if (isset($_POST['userNoUpd'])) {
        header('Location: ./add_update_user.php?userNo=' . $_POST['userNoUpd']);
    }
    unset($_POST['update']);
    unset($_POST['userNoUpd']);
}

if (isset($_POST['delete'])) {
    // delete button pressed for a user
    if (isset($_POST['userNoDel'])) {
        Controller\UserController::deleteUser($_POST['userNoDel']);
    }
    unset($_POST['delete']);
    unset($_POST['userNoDel']);
}
?>
<html>
<head>
    <title>Sam Liput Final Practical</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body>
    <h1>Sam Liput Final Practical</h1>
    <h2>Manage User Accounts</h2>
    <h2><a href="./add_update_user.php">Add User</a></h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Hire Date</th>
            <th>E-Mail Address</th>
            <th>Extension</th>
            <th>Level</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach (Controller\UserController::getAllUsers() as $user) : ?>
        <tr>
            <td><?php echo $user->getUserId(); ?></td>
            <td><?php echo $user->getFirstName(); ?></td>
            <td><?php echo $user->getLastName(); ?></td>
            <td><?php echo $user->getHireDate(); ?></td>
            <td><?php echo $user->getEMail(); ?></td>
            <td><?php echo $user->getExtension(); ?></td>
            <td><?php echo $user->getUserLevel()->getLevelName(); ?></td>
            <td><form method="POST">
                <input type="hidden" name="userNoUpd"
                    value="<?php echo $user->getUserNo(); ?>" />
                <input type="submit" value="Update" name="update" />
            </form></td>
            <td><form method="POST">
                <input type="hidden" name="userNoDel"
                    value="<?php echo $user->getUserNo(); ?>" />
                <input type="submit" value="Delete" name="delete" />
            </form></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h3><a href="admin.php">Home</a></h3>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>