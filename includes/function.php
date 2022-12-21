<!-- This page uses the scripts in the footer. It uses the same ajax call for multiple things - I just check what the action being sent it, and run a function based on that.  -->

<?php
session_start();
$conn = mysqli_connect("localhost", "mchrzanowski1", "Mrnugget1", "mchrzanowski1_readit");


//LOGGING IN AND REGISTERING STUFF


// IF
if (isset($_POST["action"])) {
    if ($_POST["action"] == "register") {
        register();
    } else if ($_POST["action"] == "login") {
        login();
    } else if ($_POST["action"] == "update-profile") {
        update();
    } else if ($_POST["action"] == "delete-post") {
        deletePost();
    } else if ($_POST["action"] == "delete-comment") {
        deleteComment();
    }
}

// REGISTER
function register()
{
    global $conn;

    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($name) || empty($email) || empty($username) || empty($password)) {
        echo "Please fill out the form.";
        exit;
    }

    $user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($user) > 0) {
        echo "Username is already taken.";
        exit;
    }

    $query = "INSERT INTO users VALUES(NULL, '$name', '$username', '$email', '$password', NULL)";
    mysqli_query($conn, $query);
    echo "Registration Successful";
}

// LOGIN
function login()
{
    global $conn;

    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

    if (mysqli_num_rows($user) > 0) {

        $row = mysqli_fetch_assoc($user);

        if ($password == $row['password']) {
            // echo "Login Successful";
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
        } else {
            echo "Wrong Password";
            exit;
        }
    } else {
        echo "User Not Registered";
        exit;
    }
}

function update()
{
    global $conn;

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $id = $_SESSION["id"];

    //validation
    if (empty($name) || empty($email) || empty($password)) {
        echo "Please fill out the form.";
        exit;
    }

    // Get all the submitted data from the form
    $sql = "UPDATE users 
            SET name = '$name', email = '$email', password = '$password' WHERE $id = id";

    // Execute query
    mysqli_query($conn, $sql);

    echo "User Settings Updated!";
}

function deletePost()
{
    global $conn;

    //var_dump($_POST);
    $postID = $_POST['comment_id'];
    $sql = "DELETE FROM posts WHERE $postID = post_id";
    mysqli_query($conn, $sql);
}

function deleteComment()
{
    global $conn;

    //var_dump($_POST);
    $commentID = $_POST['comment_id'];
    $sql = "DELETE FROM comments WHERE $commentID = comment_id";
    mysqli_query($conn, $sql);
    echo "deleted";
}

function editPost()
{
    echo "edit";
    //var_dump($_POST);
}