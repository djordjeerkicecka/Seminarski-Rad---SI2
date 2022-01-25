<?php
    session_start();
    session_unset();
    session_destroy();

    include "Utility/utilityFunctions.php";

    if(isset($_GET["error"])){
        PrintErrorMessage($_GET["error"]);
    }
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Welcome</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="Bootstrap/CSS/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="Styles/style.css">

  </head>
  <body>
    <section class="section-login bg-dark">
        <h1 class="section-title text-center text-white">Please Log In</h1>
        

        <form class="form-user text-white mx-auto" action="LogicLayer/login.php" method="post">
            <div class="form-row">
                <label class="form-label" for="loginUsername">Username: </label>
                <input class="form-text" type="text" name="loginUsername" id="loginUsername" required>
            </div>

            <div class="form-row">
                <label class="form-label" for="loginPassword">Password: </label>
                <input class="form-text" type="password" name="loginPassword" id="loginPassword" required>
            </div>
        
            <div class="form-row">
                <input class="btn btn-primary" name="submitLogin" type="submit" value="Log In">
            </div>
            <div class="form-row">
                </div>
        </form>

        <form action="LogicLayer/login-guest.php" method="post">
            <div class="form-row">
                <input class="btn btn-primary" name="submitGuest" type="submit" value="View As Guest">
            </div>
        </form>
    </section>

  </body>
</html>