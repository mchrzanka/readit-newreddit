<?php
require("./includes/header.php"); ?>


<div style="background-color:#eeeeee; width: 300px; margin: 100px auto; padding: 30px; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; text-align:center;">
    <h2>Login</h2>
    <form autocomplete=" off" action="" method="post" style="display:flex; flex-wrap:wrap;">
        <input type="hidden" id="action" value="login">

        <label for="" style="width:100%; text-align: left;  padding-bottom: 5px;">Username</label>
        <input type="text" id="username" value="" style="width:100%; padding: 10px; border: none; outline: none;">

        <label for="" style="width:100%; text-align: left; padding-top: 20px; padding-bottom: 5px;">Password</label>
        <input type="password" id="password" value="" style="width:100%; padding: 10px; border:none; outline:none;">

        <button type="button" onclick="submitData();" style="width:100%; padding: 10px; margin-top:20px; cursor: pointer;">Login</button>
    </form>
    <br>
    <p>Don't have an account? <a href="register.php" style="color:#7c9982; text-decoration:none;">Register</a></p>
</div>


<?php
require("./includes/footer.php")
?>