<?php
session_start();
require("./includes/header.php");

?>

<!-- displays all posts -->

<div style="text-align: center; margin-top: 100px;">
    <h1>All Posts</h1>
    <?php

    $allPosts = "SELECT * FROM posts 
    INNER JOIN users ON posts.user_id= users.id
    ORDER BY date DESC";
    if ($result = $conn->query($allPosts)) {
        echo "<div class=\"post-container\">";
        while ($row = mysqli_fetch_array($result)) {
            $post = htmlspecialchars_decode($row['post']);
            $date = $row['date'];
            $post_id = $row['post_id'];
            $category = $row['category'];
            $username = $row['username'];
    ?>
            <div class="post">
                <div style="display:flex; width: 100%; justify-content:space-between;">
                    <p>Post By: <?= $username ?></p>
                    <p>Date Posted: <?= $date ?></p>
                </div>
                <div style="text-align: left;">
                    <p>Category: <?= $category ?></p>
                </div>
                <div style="margin-top: 40px;">
                    <p><?= $post ?></p>
                </div>
                <div>
                    <form autocomplete=" off" id="theForm" action="" method="post">
                        <!-- <input type="hidden" id="action" name="edit-btn" value="edit-post"> -->
                        <input type="hidden" id="post_id" value="<?= $post_id ?>">
                        <a href="<?php echo BASE_URL ?>display-post.php?id=<?= $post_id ?>">
                            <button type="button" name="edit-btn" onclick="" style="width: 50%; border:none; outline:none; color:#131313; padding: 10px; cursor: pointer; background-color: #facdca;">Read More</button>
                        </a>
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

<?php
require("./includes/footer.php")
?>