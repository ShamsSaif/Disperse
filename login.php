<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Datastore\DatastoreClient;

$projectId = 'cloud-computing-a1-270211';
$datastore = new DatastoreClient([
    'projectId' => $projectId
]);

if (isset($_POST['login']))   #it checks whether if the user clicked login button
{
    if (!empty($_POST["userId"]) && !empty($_POST["password"])) #it checks whether if the input fields are empty
    {
        $id = $_POST['userId'];
        $password = $_POST['password'];
        $fullName = $_POST['fullName'];

        $key = $datastore->key('userAccounts', $id);
        $entity = $datastore->lookup($key);

        if ($entity != null && $password == $entity['password']) {
            $_SESSION['userId'] = $id;
            $_SESSION['fullName'] = $entity['fullName'];
            $_SESSION['password'] = $password;
            header('Location: main.php');
        } else {
            echo "<p style=color:red>Invalid userid or password</p>";
        }
    } else {
        echo "<p style=color:red>Fields can not be empty</p>";
    }
} elseif (isset($_POST['signup'])) #it checks whether if the user clicked change button
{
    if (!empty($_POST["fullName"]) && !empty($_POST["userId"]) && !empty($_POST["password"])) #it checks whether if the input fields are empty
    {

        $id = $_POST['userId'];
        $password = $_POST['password'];
        $fullName = $_POST['fullName'];

        $user = $datastore->transaction();
        $key = $datastore->key('userAccounts', $id);
        $entity = $datastore->entity($key, ['userId' => $id, 'password' => $password, 'fullName' => $fullName]);
        $user->insert($entity);
        $user->commit();

        header('location: login.php');
        //echo "<p style=color:green>Sign up successful. Redirecting to login.....</p>";
    } else {
        echo "<p style=color:red>Fields can not be empty</p>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <style>
        body {
            background-image: url('css/pic2.png');
        }
    </style>
</head>

<body>
 <!-- Main Login page -->
    <h1 class="h2">Disperse</h1>
    <br><br><br>

    <!-- Login credentials box -->
    <div class="box">
        <form action="" method="post" id="form">
            <h2 class="h2">User Login</h2>

            <label for="userId" style="color:white">User Id:</label><input type="text" value="" id="userId" name="userId" class="email" />
            <br><br>
            <label for="password" style="color:white">Password:</label><input type="password" value="" id="password" name="password" class="email" />

            <input type="submit" value="login" name="login" class="btn" />
        </form>
        <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;" class="btn2">Sign Up</button>
    </div>
   
    <!-- Signup popup display -->
    <div id="id01" class="modal">
        <form style="background-color:rgba(0, 0, 0, 0.781)" class="modal-content animate" action="" method="post">

            <h2 class="h2">Sign Up</h2>
            <p>Please fill in this form to create an account.</p>
            <hr>
            <label style="color:white" for="fullName">Full Name:</label>
            <input type="text" value="" id="fullName" name="fullName" required />
            <label style="color:white" for="userId">User Id:</label>
            <input type="text" value="" id="userId" name="userId" required />
            <label style="color:white" for="password">Password:</label>
            <input type="password" value="" id="password" name="password" required />
            <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

            <input type="submit" value="Sign Up" name="signup" class="btn2" />
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        </form>
    </div>
</body>

</html>