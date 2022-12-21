<!-- This page takes care of anything that uses tinymce. This includes creating posts and comments, and editing posts and comments. -->

<?php
session_start();
include './includes/connect.php';
$comment = $_POST['comment'];
$id = $_SESSION["id"];


if (isset($_POST['selectedCat'])) {
    $category = $_POST['selectedCat'];
}

if (isset($_POST['userID'])) {
    $user_id = $_POST['userID'];
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

if(isset($_POST['postID'])){
  $post_id = $_POST['postID'];  
}

if(isset($_POST['commentID'])){
    $comment_id = $_POST['commentID'];  
  }


if (strlen($comment) < 10) {
    echo 'comment length';
} else if (isset($category) && empty($category)) {
    echo "empty category";
} else {

    $htmlspecialchar = htmlspecialchars($comment, ENT_QUOTES);

    if (isset($action) && $action == "edit-post") {

        // Get all the submitted data from the form
        $sql = "UPDATE posts SET post = '$htmlspecialchar', category = '$category' WHERE $post_id = post_id";

        // Execute query
        mysqli_query($conn, $sql);

        echo "post updated";
    } else if (isset($action) && $action == "submit-comment") {

        // Get all the submitted data from the form
        $sql = "INSERT INTO comments(comment, post_id, user_id) VALUES ('$htmlspecialchar', '$post_id', $user_id)";
        // Execute query
        mysqli_query($conn, $sql);

        echo "comment submitted";
    } else if (isset($action) && $action == "edit-comment") {

        // // Get all the submitted data from the form
        $sql = "UPDATE comments SET comment = '$htmlspecialchar' WHERE $comment_id = comment_id";

        // Execute query
        mysqli_query($conn, $sql);

        echo "comment updated";
    }  else {

        $sql = "INSERT INTO posts(post, category, user_id) VALUES ('$htmlspecialchar', '$category', $id)";

        if ($conn->query($sql)) {
            echo "Post inserted successfully.";
        } else {
            echo $conn->error;
        }

    }

} ?>