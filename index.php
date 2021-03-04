<?php 
    require_once 'CLASS/users.php';
    session_start();
    if(isset($_SESSION['id_user']))
    {

      $us = new User("projeto_comentarios", "localhost", "root", "");
      $information = $us->searchData($_SESSION['id_user']);
    }elseif(isset($_SESSION['id_master']))
    {

      $us = new User("projeto_comentarios", "localhost", "root", "");
      $information = $us->searchData($_SESSION['id_master']);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">
  <title>Comments System</title>
</head>
<body>
  <nav>
    <ul>
      <?php  
              if(isset($_SESSION['id_master']))
              {  ?>
                <li><a href="data.php">Data</a></li>
        <?php }  ?>


      <li><a href="discussion.php">Discussions</a></li>
      <?php 
              if(isset($information))
              { ?>
                <li><a href="logout.php">Log out</a></li>
      <?php   }else
              { ?>
                <li><a href="login.php">Login</a></li>
      <?php   } ?>
                
    </ul>
  </nav>
  <?php 
      if(isset($_SESSION['id_master']) || isset($_SESSION['id_user']))
      { ?>
          <h2>
              <?php 
              echo "Hello! ";
              echo $information['name'];
              echo ", Welcome!";
              ?>
          </h2>
      <?php }
  ?>
  <div id="index">
    <h5>Project Comments ;)</h5>
    <img src="images/image1.jpg">
  </div>
  
  
</body>
</html>
