<?php

session_start();

if (isset($_POST['query'])) 
    {
$_SESSION['query'] = $_POST['query'];
if (isset($_POST['radio1'])) 
    {
$_SESSION['radio1'] = $_POST['radio1'];
    }
 else {
        $_SESSION['radio1'] = "content";
    }
    }
