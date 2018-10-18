<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Registration</title>
    </head>
    <body>

        <?php
        /* Read posted data */
        require_once "error_messages.php";  // contains a list of error messages that can be assigned to $_SESSION["error_message"]

        $token = ltrim(rtrim(filter_input(INPUT_POST, "token", FILTER_SANITIZE_STRING)));

        $name = ltrim(rtrim(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING)));

        $email = $_SESSION["email"];

        $password = ltrim(rtrim(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING)));

        $confirmPassword = ltrim(rtrim(filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_STRING)));

        $country = ltrim(rtrim(filter_input(INPUT_POST, "country", FILTER_SANITIZE_STRING)));

        $county = ltrim(rtrim(filter_input(INPUT_POST, "county", FILTER_SANITIZE_STRING)));

        $town = ltrim(rtrim(filter_input(INPUT_POST, "town", FILTER_SANITIZE_STRING)));

        $countryVisited = "-";

        $townVisited = "-";

        $description = ltrim(rtrim(filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING)));
        
        $date = "--/--/----";

        /* Validate input data */


        /* Connect to the database */
        require_once 'configuration.php';
        require_once 'functions.php';



        /* Connect to the database */
        $dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception

        registerNewUser($dbConnection, $email, $token, $password, $name, $country, $county, $town, $description);

        /* get user id */
        $query = "SELECT id FROM users WHERE email = :email";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->execute();


        if ($statement->rowCount() > 0) {
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $row) {
                $_SESSION["user_id"] = $row->id;  
                
                 
                
                
            }
            header("location: index.php");
        }
        ?>        
    </body>
</html>