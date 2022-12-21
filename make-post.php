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

if (isset($_SESSION["profileImg"])) {
    $profileImg = $_SESSION["profileImg"];
}
?>


<!-- this message appears if the user doesn't have a profile picture set -->
<div class="<?php echo ($profileImg == true) ? "hidden" : "show" ?>" style="margin: 100px auto; text-align:center;">
    <h2>Please Upload a Profile Image Before Trying to Make a Post</h2>
</div>



<!-- create a post form tinymce -->
<div class="<?php echo ($profileImg == true) ? "show" : "hidden" ?>" style="width: 50%; margin: 100px auto; ">
    <h1>Create a Post</h1>
    <form action="" id="post-form">
        <fieldset
            style="display:flex; flex-wrap:wrap; gap:10px; width: 100%; margin-bottom: 10px; border: none; outline: none;">
            <label for="categories" style="width:100%;">Choose a Category:</label>
            <select name="categories" id="categories" form="categoriesform" style="width:50%; padding: 10px;">
                <option selected="true" disabled="disabled">Please Select</option>
                <option value="Cats">Cats</option>
                <option value="Video games">Video games</option>
                <option value="Funny">Funny</option>
                <option value="Educational">Educational</option>
                <option value="Cute">Cute</option>
                <option value="Controversial">Controversial</option>
            </select>
        </fieldset>


        <label for="comment"></label>
        <textarea name="comment" id="comment"></textarea>
        <input type="submit" name="submit" style="border: none;
            outline: none;
            padding: 10px 30px;
            background-color: #131313;
            color: #f1f1f1;
            transition: .4s;
            width: 100%; margin-top:20px;">
        <div id="comment_form"></div>
    </form>
    <p class="submit-post hidden">Post submitted!</p>
</div>



<!-- displays all of YOUR posts -->

<div style="text-align: center;">
    <h1>All of YOUR Posts</h1>
    <?php
    $list = "SELECT * FROM posts WHERE $id= user_id ORDER BY date DESC";
    if ($result = $conn->query($list)) {
        echo "<div class=\"post-container\">";
        while ($row = mysqli_fetch_array($result)) {
            $post = htmlspecialchars_decode($row['post']);
            $date = $row['date'];
            $post_id = $row['post_id'];
            $category = $row['category'];
    ?>



    <div class="post">
        <p>
            <?= $post ?>
        </p>
        <p>Date Posted: <?= $date ?>
        </p>
        <p>Category: <?= $category ?></p>

        <div>
            <form autocomplete=" off" id="theForm" action="" method="post" style="display:flex; width:100%; justify-content: space-between; gap: 20px;">
                <div style="width:100%;">
                    <!-- <input type="hidden" id="action" name="edit-btn" value="edit-post"> -->
                    <input type="hidden" id="post_id" value="<?= $post_id ?>">
                    <a href="<?php echo BASE_URL ?>edit-post.php?id=<?= $post_id ?>">
                        <button type="button" name="edit-btn" onclick=""
                            style="width: 50%; border:none; outline:none; color:#f1f1f1; padding: 10px; cursor: pointer; background-color: #7c9982;">Edit</button>
                            </a>
                </div>
                <div style="width:100%;">
                    <input type="hidden" id="action" value="delete-post">
                    <input type="hidden" id="post_id" value="<?= $post_id ?>">
                    <button type="button" name="actionDelete" onclick="submitCrud(<?= $post_id ?>);"
                        style="width: 50%; border:none; outline:none; color:#f1f1f1; padding: 10px; cursor: pointer; background-color: #a71f13;">Delete</button>
                </div>
            </form>
        </div>
    </div>
    <?php
        }
        echo "";
    } else {
        echo $conn->error;
    }
    echo "</div>";
    ?>
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
        //MAKE POST FORM SUBMIT. couldn't put in footer for whatever reason
        $("#post-form").on("submit", function (e) {
           
            var datastring = $("#comment").val();
            //alert(datastring);

            var data = {
                comment : datastring,
                selectedCat: $("#categories").val(),
            }

            
            
            //alert(datastring);

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
                        $("#comment_form").html("<h2>Post submitted!</h2>");
                        window.location.assign('make-post.php');
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