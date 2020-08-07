<?php

$con=new mysqli ('localhost','root','','theia');

if ($con->connect_error)
{
    die("db error".$con->connect_error);
}

else{
    //echo "db successful";
}
?>