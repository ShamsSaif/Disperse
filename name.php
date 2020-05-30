<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Datastore\DatastoreClient;

$projectId = 'cloud-computing-a1-270211';
$datastore = new DatastoreClient([
    'projectId' => $projectId
]);

if (isset($_POST['password']))  #it checks whether if the user clicked change button
{
    if (!empty($_POST["new_pass"]) && !empty($_POST["old_pass"])) #it checks whether if the input field is empty
    {
        if (isset($_POST["new_pass"])) {

            if ($_POST['old_pass'] == $_SESSION['password']) {
                $update = $datastore->transaction();
                $key = $datastore->key('userAccounts', $_SESSION['userId']);
                $entity = $update->lookup($key);
                $entity['password'] = $_POST['new_pass'];
                $update->update($entity);
                $update->commit();
                header('Location: login.php');
            }
            else{
                echo "<h3 style=color:red>Incorrect current password</h3>";
            } 
        }
    } else {
        echo "<h3 style=color:red>Password fields can not be empty</h3>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/main.css">

</head>

<body>
    <!-- MenuBar -->
    <div id="ul">
        <ul>
            <div id="li">
                <li><a href="login.php">Logout</a></li>
                <li><a class="active" href="name.php">Account</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="main.php">Home</a></li>
            </div>
        </ul>
    </div>
    <!-- User account form display -->
    <h3 style="color:#526bf5d5">Account details for <?php echo $_SESSION["fullName"]; ?></h3>
    <img src="css/img_avatar1.png" alt="Avatar" class="avatar"  width="200" height="300">
    <h5>Full Name: <?php echo $_SESSION["fullName"]; ?></h5>
    <h5>User Name: <?php echo $_SESSION["userId"]; ?></h5>
    <h5>To change password click the Update Password button</h5>
    <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;" class="btn">Update Password</button>
    
    <!-- User password change popup form -->
    <div id="id01" class="modal">
        <form class="modal-content animate" action="" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                <img src="css/img_avatar1.png" alt="Avatar" class="avatar">
            </div>
            
            <label style="color:white" for="old_pass">Old password:</label><input type="password" value="" id="old_pass" name="old_pass" required />
            <label style="color:white" for="new_pass">New password:</label><input type="password" value="" id="new_pass" name="new_pass" required />
                <br><br>
                <input type="submit" value="Confirm" name="password" class="btn"/>
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        </form>
    </div>
</body>

</html>