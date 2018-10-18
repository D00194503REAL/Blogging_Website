<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Example</title> 
<link href="login_and_registration.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<div id="dkit_container"> 

<main>
    <?php
    /* Show error message for any user input errors if this form was previously submitted */
    if (isset($_SESSION["error_message"]))
    {
        echo "<div class='error_message'><p>" . $_SESSION["error_message"] . "<br>Please input data again.</p></div>";
        unset($_SESSION["error_message"]);
    }
    ?>

<form id="dkit_forgot_password_form" action="forgot_password_transaction.php" method="post">

<label for="email">Email: </label>
<input type="email" id = "email" name = "email" required autofocus><br>

<label for="confirmEmail">Confirm Email: </label>
<input type="email" id = "confirmEmail" name = "confirmEmail" required><br>

<input type="submit" value="Request new password">
</form>
</main>
 
</div> <!-- dkit_container -->
</body>
</html>