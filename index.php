<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>

    <div class="global-container">
        <div class="card login-form">
            
            <h3 class="card-title text-center">Ronan's Library</h3>
            <div class="card-text">
                
                <form method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control form-control-sm" name="username">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control form-control-sm" name="password">
                    </div>

                    <button type="submit" name="submit_button" class="btn btn-block">Login</button>
                    <a href="register.php" class="btn btn-block">Register</a>
                </form>

            </div>
        </div>
    </div>
</body>
</html>

<?php
session_start();
require_once "database.php";
error_reporting(0);

//if user clicks login button
if (isset($_POST['submit_button']))
{
    //if all the fields are filled
    if(!empty($_POST['username']) && !empty($_POST['password']))
    {  
        $name = $_POST["username"]; 
        $password = $_POST["password"];

        $select1 = "SELECT password FROM users WHERE username = '".$name."'";

        $result1=$conn->query($select1);
        $row1=$result1->fetch_assoc();

        $select2 = "SELECT username FROM users WHERE password = '".$password."'";

        $result2=$conn->query($select2);
        $row2=$result2->fetch_assoc();

        //checking if user and password match in each row
        if($name == $row2["username"] && $password == $row1["password"]) 
        { 
            //if they do match do the following and set them session variable to logged in
            echo '<script>alert("LOGGED IN")</script>';
            $_SESSION['authenticated']=true;
            $_SESSION['user']=$name;
            header("location: home.php");
        }

        else
        {
            echo '<script>alert("ERROR: Invalid credentials")</script>';
        }
    }

    else
    {  
        echo '<script>alert("ERROR: All fields are required!")</script>';
    }  
}
?>  