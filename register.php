<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
    <title>REGISTER</title>
</head>
<body>

    <div class="global-container">
        <div class="card login-form" class="card-reg">
            
            <h3 class="card-title text-center">Ronan's Library</h3>
            <div class="card-text">
                
                <form method="post">
                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control form-control-sm" name="username">
                            </div>

                            <div class="form-group">
                                <label for="fname">First name</label>
                                <input type="text" class="form-control form-control-sm" name="fname">
                            </div>

                            <div class="form-group">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control form-control-sm" name="surname">
                            </div>

                            <div class="form-group">
                                <label for="password">Password (6 characters)</label>
                                <input type="password" class="form-control form-control-sm" name="password">
                            </div>

                            <div class="form-group">
                                <label for="password">Confirm Password</label>
                                <input type="password" class="form-control form-control-sm" name="password2">
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="phone">Phone number</label>
                                <input type="text" class="form-control form-control-sm" title="Must have 9 digits" name="phone" >
                            </div>

                            <div class="form-group">
                                <label for="address1">Address line 1</label>
                                <input type="text" class="form-control form-control-sm" name="address1">
                            </div>

                            <div class="form-group">
                                <label for="address2">Address line 2</label>
                                <input type="text" class="form-control form-control-sm" name="address2">
                            </div>

                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control form-control-sm" name="city">
                            </div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-block">Register</button>
                    <br>
                    <div class="login-link">
                        <p>back to <a href="index.php">login</a></p>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>
</hmtl>

<?php
//connect to db
require_once "database.php";

if (isset($_POST['username']) && isset($_POST['fname']) && isset($_POST['surname']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['phone']) && isset($_POST['address1']) && isset($_POST['address2']) && isset($_POST['city']))
{
    //getting values entered by user
    $valid = TRUE;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password2'];
    $fname = $_POST['fname'];
    $surname = $_POST['surname'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];

    //checking if username exists
    $sql = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($conn,$sql) or die("Query unsuccessful") ;

    //error checking
    if (empty($username) || empty($password) || empty($password_confirm) || empty($fname) || empty($surname) || empty($address1) || empty($address2) || empty($city) || empty($phone))
    {
        echo '<script>alert("ERROR: Not all fields are filled!")</script>';
        $valid = FALSE;
    }

    elseif (mysqli_num_rows($result) > 0)
    {
        echo '<script>alert("ERROR: Username already exists!")</script>';
        $valid = FALSE;
    }

    elseif ($password != $password_confirm || strlen($password) < 6)
    {
        echo '<script>alert("ERROR: password is invalid!")</script>';
        $valid = FALSE;
    }

    elseif (!is_numeric($phone) || strlen($phone) != 10)
    {
        echo '<script>alert("ERROR: phone number is invalid!")</script>';
        $valid = FALSE;
    }

    //if fields are filled correctly
    if ($valid)
    {
        //add to users table
        $sql= "INSERT INTO users VALUES ('$username', '$password','$fname','$surname','$address1','$address2','$city','$phone')";

        if ($conn->query($sql) === TRUE)
        {
            echo '<script>alert("You have now registered, now login!")</script>';
            header("Location: index.php");
        }

        else
        {
            echo "Error: " . $sql. "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
