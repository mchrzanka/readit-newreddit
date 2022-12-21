<!-- I didn't really use this index page, and it logs you out when you go to it. My main page is dashboard.php -->
<?php
require("./includes/header.php");
error_reporting(E_ERROR | E_PARSE);

require './includes/function.php';
if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $id"));
}

?>

<div style="text-align:center;">
    <h1>Reading is What?</h1>
    <h1>Fundamental.</h1>
    <p>Welcome to New-Readit, because the First-Readit was a mess.</p>
</div>

<?php
require("./includes/footer.php")
?>