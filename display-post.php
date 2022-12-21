<?php
session_start();
require("./includes/header.php");

//get the post id from url
$post_id = $_GET['id'];

if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $id"));
}

//checks if there's a session set for a person having a profile image, so that they are allowed to make posts and comments
if (isset($_SESSION["profileImg"])) {
    $profileImg = $_SESSION["profileImg"];
}

//get the post info to input into the edit form
$posts_sql = "SELECT * FROM posts INNER JOIN users ON posts.user_id= users.id WHERE $post_id = post_id";

//grab the comments from the db that belong to this post
$comments_sql = "SELECT * FROM comments INNER JOIN users ON comments.user_id = users.id WHERE $post_id = post_id";

//grab posts loop
if ($result = $conn->query($posts_sql)) {
    while ($row = mysqli_fetch_array($result)) {
        $post = htmlspecialchars_decode($row['post']);
        $date = $row['date'];
        $post_id = $row['post_id'];
        $category = $row['category'];
        $username = $row['username'];
    }
}

//this variable keeps track of whether or not there are any comments for the post in the db. Later on in my code I check it to display a "no comments available" msg
$commentResult = false;

//grab comments loop
if ($result = $conn->query($comments_sql)) {
    while ($row = mysqli_fetch_array($result)) {
        $comment = htmlspecialchars_decode($row['comment']);
        $comment_date = $row['date'];
        //$comment_id = $row['comment_id'];
        $username = $row['username'];
        $user_id = $row['id'];

        $commentResult = true;
    }

}

?>

<!-- displays individual post -->
<div style="text-align: center; max-width: 500px; margin: 100px auto;">
    <div style="background-color: #EEEAE5; padding:20px; border-radius:8px;">
        <div style="display:flex; width: 100%; justify-content:space-between;">
            <p>Post By: <?= $username ?>
            </p>
            <p>Date Posted: <?= $date ?>
            </p>
        </div>
        <div style="text-align: left;">
            <p>Category: <?= $category ?>
            </p>
        </div>
        <div style="margin-top: 40px;">
            <p>
                <?= $post ?>
            </p>
        </div>
    </div>

    <!-- comment text area -->
    <!-- check if a person is logged in to leave a comment -->
    <div class="<?php echo ($profileImg == true) ? "hidden" : "show" ?>" style="margin: 100px auto; text-align:center;">
        <h2>Please Create a Profile to Comment.</h2>
    </div>


    <!-- insert a comment form -->
    <div class="<?php echo ($profileImg == true) ? "show" : "hidden" ?>" style="width: 100%; margin: 100px auto; ">
        <h1>Leave a Comment</h1>
        <form action="" id="comment-form">
            <input type="hidden" id="post_id" value="<?= $post_id ?>">
            <input type="hidden" id="user_id" value="<?= $id ?>">
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
        <p class="submit-post hidden">Comment submitted!</p>
    </div>


    <!-- display all comments for this post -->
    <h1>Comments</h1>
    <div>
        <?php if ($commentResult):
            if ($result = $conn->query($comments_sql)) {
                while ($row = mysqli_fetch_array($result)) {
                    $comment = htmlspecialchars_decode($row['comment']);
                    $comment_date = $row['date'];
                    $comment_id = $row['comment_id'];
                    $username = $row['username'];
                    $user_id = $row['id'];
                    $crud_id = $comment_id;

                    $commentResult = true; ?>

        <div style="border-bottom: 1px solid #131313; padding: 20px;">
            <div style="display:flex; width: 100%; justify-content:space-between;">
                <p>Date Posted: <?= $comment_date ?>
                </p>
                <p>Posted By: <?= $username ?>
                </p>
            </div>
            <div>
                <p>
                    <?= $comment ?>
                    <!-- <?= $comment_id ?> -->
                </p>
            </div>
            <div>
                <!-- if this comment belongs to the currently logged in user, show the delete/edit buttons -->
                <?php if ($id == $user_id): ?>
                <div>
                    <form autocomplete=" off" id="theForm" action="" method="post" style="display:flex; width: 100%; justify-content:space-between; gap: 20px;">
                        <!-- <input type="hidden" id="action" name="edit-btn" value="edit-post"> -->
                        <div style="width:100%;">
                            <input type="hidden" id="comment_id" value="<?= $comment_id ?>">
                            <a href="<?php echo BASE_URL ?>edit-comment.php?id=<?= $comment_id ?>">
                                <button type="button" name="edit-btn" onclick=""
                                    style="width: 50%; border:none; outline:none; color:#f1f1f1; padding: 10px; cursor: pointer; background-color: #7c9982;">Edit</button>
                            </a>
                        </div>
                        <div style="width:100%;">
                            <input type="hidden" id="action" value="delete-comment">
                            <input type="hidden" id="comment_id" value="<?= $comment_id ?>">
                            <!-- had to make a new function to pass in the unique id of the comment to delete, otherwise it would delete the first comment with "comment-id" as the id and whatever value of the first one. -->
                            <button type="button" name="actionDelete" onclick="submitCrud(<?= $crud_id ?>);" 
                                style="width: 50%; border:none; outline:none; color:#f1f1f1; padding: 10px; cursor: pointer; background-color: #a71f13;">Delete</button>
                        </div>
                    </form>
                </div>
                <?php else: ?>
                <p style="display:none;"></p>
                <?php endif ?>

            </div>
        </div>
        <?php
                }
            }
        ?>
    </div>
    <?php else: ?>
    <p style="margin: 0 auto;">There are no comments to show.</p>
    <?php endif ?>




<!-- 
    SCRIPT STUFF -->


    <!-- had to put this script stuff here because it wasn't working in the footer -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            skin: "snow",
            height: "300",
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });


        $(document).ready(function () {
            //MAKE POST FORM SUBMIT. couldn't put in footer for whatever reason
            $("#comment-form").on("submit", function (e) {

                var datastring = $("#comment").val();
                var actionType = "submit-comment";
                var postID = $("#post_id").val();
                var userID = $("#user_id").val();

                var data = {
                    comment: datastring,
                    action: actionType,
                    postID: postID,
                    userID: userID,
                }

                // alert(datastring);
                //alert(userID);

                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: data,
                    success: function (response) {
                        if (response == "comment length") {
                            $("#comment_form").html("<h2>Comment must be greater than 10 characters.</h2>");
                        }
                        else {
                            $("#comment_form").html("<h2>Comment submitted!</h2>");
                            window.location.assign("display-post.php?id=" + postID);
                        }
                    }
                })
                e.preventDefault();
            })
        });



    </script>

</div>
<?php
require("./includes/footer.php")
    ?>