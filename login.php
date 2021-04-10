<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css?v=<?php echo time();?>">
  <title>Document</title>
</head>
<body>
  <span>Welcome :)</span>
  <form method="POST">
    <h1>Access you account</h1>
    <img src="images/email.png">
    <input type="email" name="email" maxlength="40">
    <img src="images/padlock.png">
    <input type="password" name="pass">
    <input type="submit" value="Login">
    <a href="sign_up.php">Register now!</a>
  </form>
</body>
</html>

<?php

  if(isset($_POST['email']))
  {
      $email = htmlentities(addslashes($_POST['email']));
      $pass = htmlentities(addslashes($_POST['pass']));
      if(!empty($email) && !empty($pass))
      {
          require_once 'CLASS/users.php';

          $us = new User("projeto_comentarios", "localhost", "root", "");
          if($us->login($email, $pass))
          {
              header("Location: index.php");
          }else
          { ?>
              <p class="msg">Email and/or password incorrects</p>
     <?php }

      }else
      { ?>
         <p class="msg">Fill all the fields!</p>
    <?php } 
  }
?>
