<?php

use Utilities as Utility;

session_start();
require_once('../util/image_utilities.php');
require_once('../util/security.php');

// confirm user is authorized for the page
Utility\Security::checkAuthority('admin');

// user clicked the logout button
if (isset($_POST['logout'])) {
    Utility\Security::logout();
}

// get images directory above current working directory (views)
$dir = getcwd() . '/../images/';
$imgName = '';
// User wants to view the images for the selection
if (isset($_POST['view'])) {
    $imgName = $_POST['image_file'];
}

// User wants to delete the images for the selection
if (isset($_POST['delete'])) {
    $fName = $_POST['image_file'];
    $editFile = Utility\ImageUtilities::DeleteImageFiles($dir, $fName);
    $imgName = '';
}

// User wants to upload a new file
if (isset($_POST['upload'])) {
    $target = $dir . $_FILES['new_file']['name'];
    move_uploaded_file($_FILES['new_file']['tmp_name'], $target);
    Utility\ImageUtilities::ProcessImage($target);
    $imgName = '';
}
?>
<html>
<head>
    <title>Sam Liput Final Practical</title>
</head>
<body>
    <h1>Sam Liput Final Practical</h1>
    <h2>Image File Management</h2>
    <form method="POST">
    <h3>Image Files: <select name="image_file">
        <?php foreach(Utility\ImageUtilities::GetBaseImagesList($dir) as $file) :?>
            <option value="<?php echo $file; ?>"><?php echo $file; ?>
            </option>
        <?php endforeach; ?></select>
        <input type="submit" value="View Images" name="view">
        <input type="submit" value="Delete Image" name="delete">
    </h3>
    </form>
    <h3>Upload Image File:
        <form method="POST" enctype="multipart/form-data">
        <input type="file" name="new_file" id="new_file">
        <input type="submit" value="Upload" name="upload">    
        </form>
    </h3>
    <h4>200px Max Image:</h4>
    <img src="../images/200/<?php echo $imgName; ?>" alt="<?php echo $imgName; ?>">
    <h4>Original Image:</h4>
    <img src="../images/<?php echo $imgName; ?>" alt="<?php echo $imgName; ?>">

    <h3><a href="admin.php">Home</a></h3>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>