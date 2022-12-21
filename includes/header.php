<?php
require("./includes/connect.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/css/styles.css">
    <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/uw0es9ucux2hjfvfqdqthz2lremic9yij99ujrxaekzrwse5/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <title>Readit</title>

    <style>
        nav img {
            height: 3rem;
        }

        nav {
            display: flex;
            align-items: center;
            width: 100%;
            justify-content: space-between;
            padding: 10px;
            flex-wrap: wrap;
        }

        nav div:nth-of-type(2) {
            display: flex;
            width: 40%;
            justify-content: space-around;
            font-size: 18px;
        }

        nav a {
            text-decoration: none;
            color: #131313;
            padding: 10px;
            transition: .4s;
        }

        .nav-links a:hover {
            font-size: 21px;
            transition: .4s;
        }

        .login-button {
            color: #f1f1f1;
            background-color: #7c9982;
            padding: 10px 30px;
            margin-right: 10px;
            transition: .4s;
        }

        .logout-button {
            color: #f1f1f1;
            background-color: #a71f13;
            padding: 10px 30px;
            margin-right: 10px;
            transition: .4s;
        }

        .search {
            width: 100%;
            text-align: center;
            padding-top: 20px;
        }

        .search input {
            width: 400px;
            padding: 10px;
            border: none;
            border-bottom: 1px solid #131313;
        }

        .search input:focus {
            outline: 1px solid #131313;
            border-bottom: none;
        }

        .search button {
            border: none;
            outline: none;
            padding: 10px 30px;
            background-color: #131313;
            color: #f1f1f1;
            transition: .4s;
        }

        .search button:hover,
        .logout-button:hover,
        .login-button:hover {
            cursor: pointer;
            font-size: 21px;
            transition: .4s;
        }

        .profile-pic-success,
        .update-user-success {
            text-align: center;
        }

        .hidden {
            display: none;
        }

        .show {
            display: block;
        }

        .post-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .post {
            border: 1px solid black;
            padding: 20px;
            width: 40%;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div><a class="" href="<?php echo BASE_URL ?>index.php"><img src="<?php echo BASE_URL ?>assets/imgs/nook-logo.png" alt="" class="nook-logo" /></a></div>


            <div class="nav-links">
                <a href="<?php echo BASE_URL ?>dashboard.php">Home</a>

                <?php if (isset($_SESSION['login'])) : ?>
                    <a href="<?php echo BASE_URL ?>make-post.php">Create Post</a>
                <?php else : ?>
                    <p style="display:none;"></p>
                <?php endif ?>

                <a href="<?php echo BASE_URL ?>make-post.php">Categories</a>
                <a href="<?php echo BASE_URL ?>make-post.php">Popular</a>
            </div>
            <div>
                <?php if (isset($_SESSION['login'])) : ?>
                    <a href="<?php echo BASE_URL ?>edit-profile.php">My Profile</a>
                <?php else : ?>
                    <a href="<?php echo BASE_URL ?>register.php">Create Profile</a>
                <?php endif ?>
                <?php if (isset($_SESSION['login'])) : ?>
                    <a href="<?php echo BASE_URL ?>logout.php" class="logout-button">Logout</a>
                <?php else : ?>
                    <a href="<?php echo BASE_URL ?>login.php" class="login-button">Login</a>
                <?php endif ?>
            </div>

            <div class="search">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit">Submit</button>
            </div>
        </nav>
    </header>