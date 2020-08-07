


<?php include('app_logic.php'); ?>

<html>
<head>
    <link href="css/loginstyle1.css" rel="stylesheet">
   <style>
   </style>
    
    
    </head>
<body>
    
             <div class="boxs">
                <p style="font-size:20px ; padding:5% ; text-align:center; font-family:Verdana,sans-serif; color:white">
                      RECOVER YOUR PASSWORD!</p><br><br><br><br>
                    <?php include('messages.php'); ?>
                <form class="login" method="post" action="enter_email.php">
                <input type="email" name="email" placeholder="ENTER YOUR E-MAIL HERE" />
                    <br><br><br><br>
                   
                        <input type="submit" name="reset-password" value="SUBMIT" class=""/>
                </form>
                    </div>
    
    <div class="s1"></div>
    <div class="s"></div>
    </body>


</html>