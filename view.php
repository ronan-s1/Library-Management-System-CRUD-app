<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>HOME</title>
</head>
<body class="d-flex flex-column min-vh-100">

<?php include 'header.php';?>

<?php
session_start();
require_once "database.php";
if (!isset($_SESSION['authenticated']))
{
    //if the value was not set, you redirect the user to your login page
    header("location: index.php");
    exit;
}

?>

<div class="h3-reserve"><h3>Your Reserved Books</h3></div>

<?php
//showing each row in the books table if the current user has reserved that book
$user = $_SESSION['user'];
$sql = "SELECT * FROM books WHERE ISBN IN (SELECT ISBN FROM reserved JOIN users WHERE reserved.username = '$user')";
$res = $conn->query($sql) or die($conn->error);
$count = 0;

while($row = $res->fetch_assoc())
{
    //display table
    if ($count == 0)
    {
        echo '
        <div class="container"> 
        <form method="post">
        <table class="table table-striped" style="margin-top: 50px; margin-bottom: 80px;">
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Edition</th>
                    <th>Year</th>
                    <th>CategoryID</th>
                    <th>Reserved</th>
                    <th>Click to Delete Reservation</th>
                </tr>
            </thead>
            <tbody>';
    }
    
    echo '
    <tr>
    <td>' . $row['ISBN']  . '</td>'.'
    <td>' . $row['title']  . '</td>'.'
    <td>' . $row['author']  . '</td>'.'
    <td>' . $row['edition']  . '</td>'.'
    <td>' . $row['year']  . '</td>'.'
    <td>' . $row['categoryID']  . '</td>'.'
    <td>' . $row['reserved']  . '</td>'.'
        <td><button value="' . $row['ISBN'] . '" name="delete_button" style="border: none; background-color: #ffffff00;">delete</button></td>'.'
    </tr>';

    $count = 1;

}

echo'
</tbody>
</table>
</div>
</form>
';

//if user clicks delete button
if (isset($_POST["delete_button"]))
{
    $ISBN_delete = $_POST["delete_button"];
    $user = $_SESSION['user'];

    //change the book to being not reserved in books table
    $sql2 = "UPDATE books SET reserved = 'N' WHERE ISBN = '$ISBN_delete'";

    if ($conn->query($sql2) === TRUE)
    {
        //delete book from users table
        $sql3 = "DELETE FROM reserved WHERE ISBN = '$ISBN_delete'";

        if ($conn->query($sql3) === TRUE)
        {
            echo '<script>alert("BOOK DELETED FROM RESERVED")</script>';
        }

    }
}

$conn->close();
?>

<?php include 'footer.php';?>

</body>

</html>