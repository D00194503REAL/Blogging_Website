<?php

require_once '../configuration.php';
$term = $_POST['query'];
//$term="ire";
if (isset($term)) {
    $return_arr = array();
    try {
        $dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception
        
        $statement1 = $dbConnection->prepare('SELECT country FROM countries WHERE country LIKE :term');

        $statement1->execute(array('term' => $term . '%'));

        $output = '<ul class="list-unstyled" id="countryList">';
        if ($statement1->rowcount() != null) {
            while ($row = $statement1->fetch()) {
                //   $return_arr[] = $row['country];
                $output .= '<div id="divv" style="padding: 4px;"><li class="countries">' . $row["country"] . '</li></div>';
            }
        } else {
            $output .= '<div id="divv" style="padding: 4px;"><li class="countries" disabled selected>Country Not Found</li></div>';
        }
    } catch (PDOException $ex) {
        $_SESSION["error_message"] = $ex->getMessage();
        $output .= "</ul>";
        echo $output;
        exit();
    }

    $output .= '</ul>';
    echo $output;
}
?>



