<?php

//session_start();

include_once("../common/inclusioni.php");

$secureimage= new Securimage();

if(isset($_POST['submit'])){
    /*
        if($secureimage->check($_POST['security_code']) ==true || (defined('ENV_DEVEL'))){
            connectDB();
        }
        else{
            $esito = _("Codice di sicureza errato");
        }
    */
}   

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css"/>
    <script src=""></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <form action="elogin.php" class="" method="post">
                    <img src="" alt="" class="mb-4" width="" height="">
                    <h1 class="">Please Sign In</h1>
                    <label for="inputEmail" class="sr-only">Email Address</label>
                    <input id="inputEmail" placeholder="Email Address" type="email" name="email" required="" autofocus="" class="form-control">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input id="inputPassword" type="password" placeholder="Password" required="" name="password" class="form-control"><br>
                    <img id="captcha" src="../includes/securimage/securimage_show.php" alt="CAPTCHA Image" />
                    <input type="text" name="captcha_code" size="10" maxlength="6" />
                    <a href="#" onclick="document.getElementById('captcha').src='../includes/securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
                    <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Sign In</button>
                    <p class="mt-5 mb-3 text-muted">©</p>
                    
                </form>
            </div>
        </div>
    </div>
</body>
</html>