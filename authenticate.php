<!--

    Description: Authentication script.

-->

<?php 

    define('ADMIN_LOGIN','user'); 
    define('ADMIN_PASSWORD','123'); 

    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) 
          || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN) 
          || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) { 
        header('HTTP/1.1 401 Unauthorized'); 
        header('WWW-Authenticate: Basic realm="World of Mirrors"'); 
        exit("Access Denied: Username and password required."); 
    } 
   
?>