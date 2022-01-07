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
    <title>SEARCH</title>
</head>
<body class="d-flex flex-column min-vh-100">

    <?php
    session_start();
    require_once "database.php";
    if (!isset($_SESSION["authenticated"]))
    {
        //if the value was not set, you redirect the user to your login page
        header("location: index.php");
        exit;
    }
    
    include 'header.php';
    ?>

    <div class="container" style="margin-top: 50px;">
        <div class="row">

            <div class="col">

                <div class="global-container-search">
                    <div class="card form-search">
                        
                        <h3 class="card-title text-center">Search by Author or/and Title</h3>
                        <div class="card-text">
                            
                            <form method="post"> 

                                <div class="form-group">
                                    <label for="title">Book title:</label>
                                    <input type="text" class="form-control form-control-sm" name="title">
                                </div>

                                <div class="form-group">
                                    <label for="author">Author:</label>
                                    <input type="text" class="form-control form-control-sm" name="author">
                                </div>

                                <br>

                                <button type="submit" name="submit_button" class="btn btn-block">search</button>

                            </form>

                        </div>
                    </div>
                </div>

            </div>

            <div class="col">

                <div class="global-container-search" style="margin-bottom: 50px;">
                    <div class="card form-search">
                        
                        <h3 class="card-title text-center">Search by Category</h3>
                        <div class="card-text">
                            
                            <form method="post"> 

                                <label for="category">Category:</label>
                                <select class="form-control form-control-sm" name="category">
                                    <option disabled selected>-- Select Category --</option>
                                    <?php
                                        //getting all categories
                                        $sql = "SELECT categoryDescription From categories";  // Use select query here 
                                        $res = $conn->query($sql) or die($conn->error);

                                        while($row = $res->fetch_assoc())
                                        {
                                            echo "<option value='". $row['categoryDescription'] ."'>" .$row['categoryDescription'] ."</option>";
                                            // displaying data in option menu
                                        }	
                                    ?>  
                                </select>    
                                <br>
                                <button type="submit" name="submit_button_cat" class="btn btn-block">search</button>

                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php
    error_reporting(0);

    //searching by author
    if (!empty($_POST["author"]) && empty($_POST["title"]))
    {
        $search_value = $_POST["author"];        
        $sql = "SELECT * FROM books WHERE author LIKE '%$search_value%'";
    }

    //searching by title
    else if (empty($_POST["author"]) && !empty($_POST["title"]))
    {
        $search_value = $_POST["title"]; 
        $sql = "SELECT * FROM books WHERE title LIKE '%$search_value%'";
    }

    //searching by title and author
    else if (!empty($_POST["author"]) && !empty($_POST["title"]))
    {
        $title = $_POST["title"];
        $author = $_POST["author"];
        
        $sql = "SELECT * FROM books WHERE title LIKE '%$title%' AND author LIKE '%$author%'";
    }  

    //searching by category
    else if (isset($_POST["submit_button_cat"]))
    {
        $search_value = $_POST["category"];
        $sql = "SELECT * FROM books JOIN categories ON books.categoryID = categories.categoryID WHERE categoryDescription ='$search_value'";
    }

    //display everything if nothing is filled
    else if (empty($_POST["author"]) && empty($_POST["title"]))
    {
        $sql = "SELECT * FROM books";
    }

    $res = $conn->query($sql) or die($conn->error);
    $count = 0;

    while($row = $res->fetch_assoc())
    {
        //displaying table
        //only display the table header once
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
                        <th>Click to Reserve</th>
                    </tr>
                </thead>
                <tbody>';
        }
        
        //if book isnt reserved, disiaply a reserve button
        if ($row['reserved'] == "N")
        {
            echo '
            <tr>
                <td>' . $row['ISBN']  . '</td>'.'
                <td>' . $row['title']  . '</td>'.'
                <td>' . $row['author']  . '</td>'.'
                <td>' . $row['edition']  . '</td>'.'
                <td>' . $row['year']  . '</td>'.'
                <td>' . $row['categoryID']  . '</td>'.'
                <td>' . $row['reserved']  . '</td>'.'
                <td><button value="' . $row['ISBN'] . '" name="reserve_button" style="border: none; background-color: #ffffff00;">reserve</button></td>'.'
            </tr>';
        }

        else
        {
            echo '
            <tr>
                <td>' . $row['ISBN']  . '</td>'.'
                <td>' . $row['title']  . '</td>'.'
                <td>' . $row['author']  . '</td>'.'
                <td>' . $row['edition']  . '</td>'.'
                <td>' . $row['year']  . '</td>'.'
                <td>' . $row['categoryID']  . '</td>'.'
                <td>' . $row['reserved']  . '</td>'.'
                <td></td>'.'
            </tr>';
        }


        $count = 1;
    }

    echo'
    </tbody>
    </table>
    </div>
    </form>
    ';

    //if user clicks reserve button
    if (isset($_POST["reserve_button"]))
    {
        $ISBN_reserve = $_POST["reserve_button"];
        $date = date("Y-m-d");
        $user = $_SESSION['user'];

        //change the book to be reserved
        $sql2 = "UPDATE books SET reserved = 'Y' WHERE ISBN = '$ISBN_reserve'";
        

        if ($conn->query($sql2) === TRUE)
        {
            //insert users details into reserved table
            $sql3 = "INSERT INTO reserved VALUES ('$ISBN_reserve', '$user', '$date')";

            if ($conn->query($sql3) === TRUE)
            {
                echo '<script>alert("BOOK RESERVED")</script>';
            }

        }
    }
    
    $conn->close();
    include 'footer.php';
?>


</body>
</html>