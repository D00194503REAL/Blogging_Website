<?php

/* * ************************ You need to set the values below to match your project ************************ */
$GLOBALS['user_liked'] = false;
// localhost website and localhost database
try {


    $localHostSiteFolderName = "AndreaWebsite";

    $localhostDatabaseName = "blogUsers";
    $localHostDatabaseHostAddress = "localhost";
    $localHostDatabaseUserName = "root";
    $localHostDatabasePassword = "";



// remotely hosted website and remotely hosted database       /* you will need to get the server details below from your host provider */
    $serverWebsiteName = "http://students.ie/D00123456"; /* use this address if hosting website on the college students' website server */

    $serverDatabaseName = "D00123456";
    $serverDatabaseHostAddress = "mysql02.comp.dkit.ie";         /* use this address if hosting database on the college computing department database server */
    $serverDatabaseUserName = "D00123456";
    $serverDatabasePassword = "ABCD";




    $useLocalHost = true;      /* set to false if your database is NOT hosted on localhost */



    /*     * ******************************* WARNING                                 ******************************** */
    /*     * ******************************* Do not modify any code BELOW this point ******************************** */

    if ($useLocalHost == true) {
        $siteName = "http://localhost/" . $localHostSiteFolderName;
        $dbName = $localhostDatabaseName;
        $dbHost = $localHostDatabaseHostAddress;
        $dbUsername = $localHostDatabaseUserName;
        $dbPassword = $localHostDatabasePassword;
    } else {  // using remote host
        $siteName = $serverWebsiteName;
        $dbName = $serverDatabaseName;
        $dbHost = $serverDatabaseHostAddress;
        $dbUsername = $serverDatabaseUserName;
        $dbPassword = $serverDatabasePassword;
    }
    
    
} catch (Exception $ex) {
    $_SESSION["error_message"] = $ex->getMessage();
    header("location: index.php");
    exit();
}
?>