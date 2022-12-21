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

//get the post id from url
$post_id = $_GET['id'];

//get the post info to input into the edit form
$sql = "SELECT * FROM posts WHERE $post_id = post_id";


if ($result = $conn->query($sql)) {
    while ($row = mysqli_fetch_array($result)) {
        $post = htmlspecialchars_decode($row['post']);
        $date = $row['date'];
        $post_id = $row['post_id'];
        $category = $row['category'];
    }
}


?>

<!-- create a post form tinymce -->
<div style="width: 50%; margin: 100px auto; ">
    <h1>Edit Your Post</h1>
    <form action="" id="post-form">
        <fieldset
            style="display:flex; flex-wrap:wrap; gap:10px; width: 100%; margin-bottom: 10px; border: none; outline: none;">
            <input type="hidden" id="post_id" value="<?= $post_id ?>">
            <label for="categories" style="width:100%;">Choose a Category:</label>
            <select name="categories" id="categories" form="categoriesform" style="width:50%; padding: 10px;">
                <option selected="true">
                    <?php
                if (isset($category)) {
                    echo $category;
                }
                ?>
                </option>
                <option value="Cats">Cats</option>
                <option value="Video games">Video games</option>
                <option value="Funny">Funny</option>
                <option value="Educational">Educational</option>
                <option value="Cute">Cute</option>
                <option value="Controversial">Controversial</option>
            </select>
        </fieldset>


        <label for="comment"></label>
        <textarea name="comment" id="comment"><?php
        if (isset($post)) {
            echo $post;
        }
        ?></textarea>
        <input type="submit" name="submit" style="border: none; outline: none; padding: 10px 30px; background-color: #131313; color: #f1f1f1; transition: .4s; width: 100%; margin-top:20px;">
        <div id="comment_form"></div>
    </form>
    <p class="submit-post hidden">Post submitted!</p>
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
        $("#post-form").on("submit", function (e) {
            var datastring = $("#comment").val();
            var actionType = "edit-post";
            var postID = $("#post_id").val();

            var data = {
                comment: datastring,
                selectedCat: $("#categories").val(),
                action: actionType,
                postID : postID,
            }

            $.ajax({
                type: "POST",
                url: "process.php",
                data: data,
                success: function (response) {
                    if (response == "empty category") {
                        $("#comment_form").html("<h2>Please select a category.</h2>");
                    } else  if (response == "comment length") {
                        $("#comment_form").html("<h2>Post must be greater than 10 characters.</h2>");
                    } 
                    else {
                        $("#comment_form").html("<h2>Post Updated!</h2>");
                      //  window.location.assign('make-post.php');
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