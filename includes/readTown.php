<?php

require_once '../configuration.php';

$town = $_POST['town'];
if (isset($town)) {
    $return_arr = array();
    try {
        $dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception
        
       $statement1 = $dbConnection->prepare("SELECT townName FROM towns WHERE townName LIKE '". $town ."%' LIMIT 0,6");
        
        $statement1->execute();

        $output = '<ul class="list-unstyled" id="townList">'; 
        if($statement1->rowcount() != null )
        {
        while ($row = $statement1->fetch()) {
            
            $output .= '<div id="divv" style="padding: 4px;"><li class="town">' . $row["townName"] . '</li></div>';

        }
        }
        else
        {
            $output .= '<div id="divv" style="padding: 4px;"><li class="towns" disabled selected>Town Not Found</li></div>';  
        }  
    } catch (PDOException $ex) {
        $_SESSION["error_message"] = $ex->getMessage();
        exit();
    }


    echo $output;
}
?>



