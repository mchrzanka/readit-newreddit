<?php
session_start();

//I know that the session is started already. This notice seems pointless so I added this code to hide it.
error_reporting(E_ALL ^ E_NOTICE);

require("./includes/header.php");
require("./includes/connect.php");
require './includes/function.php';
if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $id"));
}

//get the comment id from url
$comment_id = $_GET['id'];

$comments_sql = "SELECT * FROM comments WHERE $comment_id = comment_id";

if ($result = $conn->query($comments_sql)) {
    while ($row = mysqli_fetch_array($result)) {
        $comment = htmlspecialchars_decode($row['comment']);
        $comment_date = $row['date'];
    }

}


?>

<!-- create a post form tinymce -->
<div style="width: 50%; margin: 100px auto; ">
    <h1>Edit Your Comment</h1>
    <form action="" id="comment-form">
    <input type="hidden" id="comment_id" value="<?= $comment_id ?>">
        <label for="comment"></label>
        <textarea name="comment" id="comment"><?php
        if (isset($comment)) {
            echo $comment;
        }
        ?></textarea>
        <input type="submit" name="submit"
            style="border: none; outline: none; padding: 10px 30px; background-color: #131313; color: #f1f1f1; transition: .4s; width: 100%; margin-top:20px;">
        <div id="comment_form"></div>
    </form>
    <p class="submit-post hidden">Comment Edited!</p>
</div>




<!-- had to put this script stuff here because it wasn't working in the footer -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>


    tinymce.init({
        selector: 'textarea',
        skin: "snow",
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });


    $(document).ready(function () {
        //MAKE POST FORM SUBMIT. couldn't put in footer for whatever reason.
        //this posts to process.php which updates the sql. I send it the textarea content, the type of action I want this form to take, and the post ID so it can update the correct post. 
        $("#comment-form").on("submit", function (e) {
            var datastring = $("#comment").val();
            var actionType = "edit-comment";
            var commentID = $("#comment_id").val();

            var data = {
                comment: datastring,
                action: actionType,
                commentID: commentID,
            }

            $.ajax({
                type: "POST",
                url: "process.php",
                data: data,
                success: function (response) {
                    if (response == "comment length") {
                        $("#comment_form").html("<h2>Comment must be greater than 10 characters.</h2>");
                    }
                    else {
                        $("#comment_form").html("<h2>Comment Updated!</h2>");
                        //window.location.assign('dashboard.php');
                    }
                }
            })
            e.preventDefault();
        })
    });
</script>

<?php
require("./includes/footer.php")
    ?>