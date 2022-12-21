<?php
require("./includes/header.php");

require './includes/function.php';
if (isset($_SESSION["id"])) {
    header("Location: dashboard.php");
}
?>

<div class="register-form" style="background-color:#eeeeee; width: 300px; margin: 100px auto; padding: 30px; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; text-align:center;">
    <h2>Register</h2>
    <form autocomplete="off" action="" method="post" style="display:flex; flex-wrap:wrap;">
        <input type="hidden" id="action" value="register">

        <label for="name" style="width:100%; text-align: left;  padding-bottom: 5px;">Name</label>
        <input type="text" id="name" value="" style="width:100%; padding: 10px; border: none; outline: none;">

        <label for="email" style="width:100%; text-align: left;  padding-top:20px; padding-bottom: 5px;">Email</label>
        <input type="text" id="email" value="" style="width:100%; padding: 10px; border: none; outline: none;">

        <label for="username" style="width:100%; text-align: left;  padding-top:20px; padding-bottom: 5px;">Username</label>
        <input type="text" id="username" value="" style="width:100%; padding: 10px; border: none; outline: none;">

        <label for="password" style="width:100%; text-align: left;  padding-top:20px; padding-bottom: 5px;">Password</label>
        <input type="password" id="password" value="" style="width:100%; padding: 10px; border: none; outline: none;">

        <button type="button" onclick="submitData();" style="width:100%; padding: 10px; margin-top:20px; cursor: pointer;">Register</button>
    </form>
    <br>
    <p>Already have an account? <a href="login.php" style="color:#7c9982; text-decoration:none;">Login</a></p>
</div>

<?php
require("./includes/footer.php")
?>