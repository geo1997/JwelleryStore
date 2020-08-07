<?php
if($_POST['x'])
{
    $x=$_POST["x"];
    $y=$_POST["y"];
    $operation=$_POST["operation"];

    switch($operation)
    {
        case 'add':
            $z=$x+$y;
            $res=$x."+".$y."=";
            break;
        
        case 'sub':
            $z=$x-$y;
            $res=$x."-".$y."=";
            break;
        
        default:
        break;

    }

    echo "Answer :".$res.$z."!";
 
}
?>