<?php


    switch($page){

        case "store":
        include "pages/store.php";
        break

        case "admin":
        include "pages/admin.php";
        break

        case "add":
        include "pages/add.php";
        break
        
        case "delete":
        include "pages/delete.php";
        break

        case "newuser":
        include "pages/newuser.php";
        break

        case "thankyou":
        include "pages/thankyou.php";
        break

        case "update":
        include "pages/update.php";
        break

        default:
        //include "index.php";
        break
    }

?>