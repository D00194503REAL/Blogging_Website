<?php


require_once '../configuration.php';

$county = $_POST['county'];
$country = $_POST["country"];
//$county = "lo";
//$country = "Ireland";
//$term="ire";
if (isset($county)) {
    $return_arr = array();
    try {
        $dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception
        
        $statement1 = $dbConnection->prepare("SELECT * FROM counties WHERE name LIKE :county AND country_id = 
(SELECT id from countries WHERE country = :country) ORDER BY name ASC LIMIT 0, 10");
        
        $statement1->bindValue(':county', $county . '%');
        $statement1->bindValue(':country', $country);
        
        $statement1->execute();
      
        $output = '<ul class="list-unstyled" id="countyList">';  
        if($statement1->rowcount() != null )
        {
        while ($row = $statement1->fetch()) {
            
            $output .= '<div id="divv" style="padding: 4px;"><li class="counties">' . $row["name"] . '</li></div>';

        }
        }
        else
        {
            $output .= '<div id="divv" style="padding: 4px;"><li class="counties" disabled selected>County Not Found</li></div>';  
        }  
        }
        
      catch (PDOException $ex) {
        $_SESSION["error_message"] = $ex->getMessage();
        exit();
    }

    $output .= '</ul>';
    echo $output;
}
?>



