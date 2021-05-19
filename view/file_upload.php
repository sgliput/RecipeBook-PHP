<?php

use Utilities as Utility;

session_start();
require_once('../util/file_utilities.php');
require_once('../util/security.php');

// confirm user is authorized for the page
Utility\Security::checkAuthority('tech');

// user clicked the logout button
if (isset($_POST['logout'])) {
    Utility\Security::logout();
}

// get text_files directory above current working directory (views)
$dir = getcwd() . "/..";
$viewFile = '';
$editFile = '';

// User selected to view file contents
if (isset($_POST['view'])) {
    $fName = $_POST['fileChosen'];
    $viewFile = Utility\FileUtilities::GetFileContents($dir . $fName);
    $editFile = '';
}

// User is loading a file to edit
if (isset($_POST['edit'])) {
    $fName = $_POST['fileChosen'];
    $editFile = Utility\FileUtilities::GetFileContents($dir . $fName);
    $viewFile = '';
}

// User wants to save edited file contents
if (isset($_POST['save'])) {
    $fName = $_POST['fileChosen'];
    $content = $_POST['editFile'];
    Utility\FileUtilities::WriteFile($dir . $fName, $content);
    $editFile = '';
    $viewFile = '';
}

// User wants to create a new file
if (isset($_POST['create'])) {
    $fName = $_POST['newFileName'];
    $content = $_POST['createFile'];
    Utility\FileUtilities::WriteFile($dir . $fName, $content);
    $editFile = '';
    $viewFile = '';
}
?>
<html>
<head>
    <title>Sam Liput Final Practical</title>
</head>
<body>
    <h1>Sam Liput Final Practical</h1>
    <h2>Manage Incident Text Files</h2>
    <form method="POST">
    <ul>
        <?php foreach(Utility\FileUtilities::GetFileList($dir) as $file) : ?>
        <li><?php echo $file?></li>
        <?php endforeach; ?>
    </ul>
    <h3>View Log File: <select name="fileChosen">
            <?php foreach(Utility\FileUtilities::GetFileList($dir) as $file) : ?>
                <option value="<?php echo $file; ?>"><?php echo $file; ?>
                </option>
            <?php endforeach; ?></select>
            <input type="submit" value="View File" name="view">
            <input type="submit" value="Edit File" name="edit">
            <input type="submit" value="Save Edits" name="save">
            <br />
            <input type="text" name="newFileName">
            <input type="submit" value="Create File" name="create" 
                <?php if ((strlen($viewFile) > 0) || (strlen($editFile) > 0)){ ?> disabled <?php } ?>>

    </h3>
    <?php if (strlen($viewFile) > 0): ?>
    <textarea id="viewFile" name="ViewFile" rows="15" cols="50" disabled>
        <?php echo $viewFile ?></textarea>
    <?php elseif ((strlen($editFile) > 0)): ?>
    <textarea id="editFile" name="editFile" rows="15" cols="50">
        <?php echo $editFile ?></textarea>
    <?php else: ?>
    <textarea id="createFile" name="createFile" rows="15" cols="50">
        </textarea>
    <?php endif; ?>

    <h3><a href="tech.php">Home</a></h3>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>