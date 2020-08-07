<?php
    $db=new mysqli('localhost','root','','jwellerystore');

    if($db-> connect_error)
    {
        die("db error".$db->connect_error);
    }

    else{
        //echo "db succcessful";
    }


?>