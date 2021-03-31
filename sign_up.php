<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/sign_up.css?version=1">
  <title>Document</title>
</head>
<body>

  <form method="POST">
    <h1>Sign-up</h1>
    <label for="name">NAME</label>
    <input type="text" name="name" id="name" maxlength="40">
    <label for="email">EMAIL</label>
    <input type="email" name="email" id="email" maxlength="40">
    <label for="pass">PASSWORD</label>
    <input type="password" name="pass" id="pass">
    <label for="confPass">CONFIRM PASSWORD</label>
    <input type="password" name="confPass" id="confPass">
    <input type="submit" value="Sign-up">
  </form>

</body>
</html>

<!--==================== PHP ======================-->
<?php

if(isset($_POST['name']))
{
    $name = htmlentities(addslashes($_POST['name']));
    $email = htmlentities(addslashes($_POST['email']));
    $pass = htmlentities(addslashes($_POST['pass']));
    $confPass = htmlentities(addslashes($_POST['confPass']));

    if(!empty($name) && !empty($email) && !empty($pass) && !empty($confPass))
    {
        if($pass == $confPass)
        {
            require_once 'CLASS/users.php';

            $us = new User("projeto_comentarios", "localhost", "root", "");
            if($us->register($name, $email, $pass))
            { ?>
             <p class="msg">Registered successfuly <a href="login.php">Login</a></p> 
      <?php }else 
            { ?>
              <p class="msg">Email alredy registered</p>
      <?php }

        }else
        { ?>
            <p class="msg">passwords does not match!</p>
      <?php }  

    }else
        { ?>
        <p class="msg">fill all the fields!</p>
  <?php }
}
?>
