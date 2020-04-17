<?php
/* Smarty version 3.1.34-dev-7, created on 2020-04-17 13:26:21
  from '/home/forz/Projects/wildcloud/includes/Smarty/templates/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e99925dcc1e44_84637990',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '81c8ea96c1d42fc5112bc0f27958612af2a717ce' => 
    array (
      0 => '/home/forz/Projects/wildcloud/includes/Smarty/templates/index.tpl',
      1 => 1587122779,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e99925dcc1e44_84637990 (Smarty_Internal_Template $_smarty_tpl) {
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
    <?php echo '<script'; ?>
 src=""><?php echo '</script'; ?>
>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <form action="elogin.php" class="" method="post">
                    <img src="" alt="" class="mb-4" width="" height="">
                    <h1 class="">Please Sign In</h1>Hello, <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
!
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
</html><?php }
}
