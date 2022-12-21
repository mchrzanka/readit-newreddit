<!-- This uploads the images to your uploads folder and also the string name to the db -->
<?php
session_start();
var_dump($_SESSION);
$id = $_SESSION["id"];

$message = '';

//moves the uploaded image into the uploads folder on the server.

$imageData = '';
if (isset($_FILES['file']['name'][0])) {
    foreach ($_FILES['file']['name'] as $keys => $values) {
        $fileName = uniqid() . '_' . $_FILES['file']['name'][$keys];

        //if moved into the uploads folder, do the database query to update the img string in the db based on the session id of the user.
        if (move_uploaded_file($_FILES['file']['tmp_name'][$keys], 'uploads/' . $fileName)) {
            $imageData .= '<img src="uploads/' . $fileName . '" class="thumbnail" />';

            $conn = mysqli_connect("localhost", "mchrzanowski1", "Mrnugget1", "mchrzanowski1_readit");

            // Get all the submitted data from the form
            $sql = "UPDATE users SET profile_img = '$fileName' WHERE $id = id";

            // Execute query
            mysqli_query($conn, $sql);
            // echo $fileName;

            $message = "Profile Image Updated!";
        }
    }
}

// echo $imageData;
echo $message;
