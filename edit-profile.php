<?php
session_start();

include "includes/connect.php";

//I know that the session is started already. This notice seems pointless so I added this code to hide it.
error_reporting(E_ALL ^ E_NOTICE);

require("./includes/header.php");

require './includes/function.php';
if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $id"));

    // echo $id;
    // var_dump($user);

    $profileImg = mysqli_fetch_row(mysqli_query($conn, "SELECT profile_img FROM users WHERE id = $id"));


    $img = $profileImg[0];
    // echo $profileImg[0];

    //if there's an image being returned from the db, then set the session to be true so that I can check it on the posts and comments page
    if ($img) {
        $_SESSION['profileImg'] = true;
    }
}

?>

<div style="text-align:center; margin-top: 40px;">
    <h1>Welcome to Your Profile.</h1>
    <p>Please set your profile picture if you haven't already.</p>
    <p>You will need one to make a post.</p>
</div>

<!-- profile images -->
<div style="margin: 100px auto 0 auto; display:flex; padding: 0px 20px; justify-content: space-between; max-width: 1000px;">

    <div style="width: 40%;">
        <h2 style="text-align:center;">Your Profile Picture</h2>

        <img src="uploads/<?php echo $img ?>" alt="Your profile picture" style="height: 428px; width: 100%; background-color:#666; object-fit:cover;">
        </img>
    </div>

    <div style="width: 45%;">
        <h2 style="text-align:center;">Upload Profile Picture</h2>

        <!-- WEBCAM IT DOESN'T WORK BECAUSE OF HTTPS BUT THEORETICALLY IT WOULD WORK-->
        <div class=" webcam" style="height: 250px; width: 100%; background-color: blue;">
            <video id="webCam" autoplay playsinline style="background-color:#eeeeee; width: 100%; height: 250px;"></video>
            <canvas id="canvas"></canvas>
            <!-- <a download onClick="takePicture()" style="padding: 20px; background-color: orange; color:#131313; text-decoration:none; text-align: center;">SNAP</a> -->
        </div>

        <div style="text-align:center; font-size: 18px;">
            <p>OR</p>
        </div>

        <!-- DROP FILES, WORKS -->
        <div id="ddArea" class="upload-box" style="border: 2px dashed #ccc; text-align:center; background-color: #eeeeee; font-size: 18px; padding: 50px;">
            Drag and Drop Files or
            <span style="color:#7c9982; cursor: pointer;">
                Select File(s)
            </span>
        </div>
        <!-- shows the thumbnail of the image you selected -->
        <!-- <div id="showThumb"></div> -->
        <input type="file" class="d-none" id="selectfile" multiple style="display:none;" />
    </div>

</div>

<!-- success message when you upload a file -->
<p class="profile-pic-success hidden">Profile Picture Updated!</p>
</div>


<!-- form for user to update their credentials -->
<div>
    <h2 style="text-align:center; margin-top: 200px">Update User Settings</h2>
    <form autocomplete=" off" action="" method="post" style="display:flex; flex-wrap:wrap; width: 50%; margin: 0 auto; padding-top: 20px;">
        <input type="hidden" id="action" value="update-profile">

        <label for="name" style="width:100%; text-align: left;  padding-bottom: 5px;">Name</label>
        <input type="text" id="name" value="" style="width:100%; padding: 10px; border: 1px solid #131313; outline: none;">

        <label for="email" style="width:100%; text-align: left;  padding-bottom: 5px; padding-top: 20px;">Email</label>
        <input type="text" id="email" value="" style="width:100%; padding: 10px; border: 1px solid #131313; outline: none;">


        <label for="password" style="width:100%; text-align: left; padding-top: 20px; padding-bottom: 5px;">Password</label>
        <input type="password" id="password" value="" style="width:100%; padding: 10px; border: 1px solid #131313; outline:none;">

        <button type="button" onclick="submitData();" style="width:30%; padding: 10px; margin:20px auto; cursor: pointer;">Update Settings</button>
    </form>

    <!-- success message when you update user info -->
    <p class="update-user-success hidden">Settings Updated!</p>
</div>

<?php
require("./includes/footer.php")
?>