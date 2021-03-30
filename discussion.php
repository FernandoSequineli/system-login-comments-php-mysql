<?php 
  session_start();
  require_once 'CLASS/comments.php';
  $c = new User("projeto_comentarios", "localhost", "root", "");
  $comments = $c->searchComments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/discussion.css">
  <title>Document</title>
</head>
<body>
  
  <nav>
    <ul>
      <li><a href="index.php">Home</a></li>
      <?php 
        if(isset($_SESSION['id_master']))
        { ?>
            <li><a href="data.php">Data</a></li>
  <?php }
        
        if(isset($_SESSION['id_user']) || isset($_SESSION['id_master']))
        { ?>
          <li><a href="logout.php">Log out</a></li>    
  <?php }else 
        { ?>
         <li><a href="login.php">Login</a></li>
  <?php }
      ?>
    </ul>
  </nav>
    <div id="width-page">
      <section id="content1">
        <h1>What is Lorem Ipsum?</h1>
        <img src="images/image2.jpg">
        <p class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        <p class="text">1. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <p class="text">2. Mauris a leo vel ipsum eleifend vulputate.</p>
        <p class="text">3. Donec et enim ultricies, mollis lectus ut, consequat nisl.</p>
        <p class="text">4. Ut vel odio quis leo ultricies ultrices.</p>

          <?php 
            if(!isset($_SESSION['id_user']))
            { ?>
                <h2>Comments</h2>
      <?php }else
            { ?>
                <h2>Leave your comment</h2>
      <?php } ?>

          <?php 
              if(isset($_SESSION['id_user']))
              { ?>
                  <form method="POST">
                    <img src="images/profile.png">
                    <textarea name="text" placeholder="Join the discussion" maxlength="400"></textarea>
                    <input type="submit" value="POST COMMENT">
                    </form>
        <?php } ?>
        
        <?php 

            if(count($comments) > 0)
            {
                foreach($comments as $v)
                { ?>
                  <div class="comment-area">
                      <img src="images/profile.png">
                      <h3> <?php echo $v['name_people']; ?></h3>
                      
                      <h4>
                          <?php 
                              $date = new DateTime($v['dia']);
                              echo $date->format('d/m/Y');
                              echo " - ";
                              echo $v['horario'];  
                          ?> 
                        <?php 
                          if(isset($_SESSION['id_user']))          
                          {
                              if($_SESSION['id_user'] == $v['fk_id_usuario'])
                              { ?>
                                <a href="discussion.php?id_exc=<?php echo $v['id'];?>">Delete</a>
                        <?php }
                          }elseif (isset($_SESSION['id_master']))
                          { ?>
                              <a href="discussion.php?id_exc=<?php echo $v['id'];?>">Delete</a>
                    <?php } ?>
                    </h4>
                       <p> <?php echo $v['comentarios'];?></p>
                  </div>
        <?php }
            }else
            {
              echo "There are no comments yet";
            }
        ?>    

      </section>
      <section id="content2">
          <div>
              <img src="images/side.jpg">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam placerat, arcu sit amet fringilla fringilla, felis ligula dictum sem, eget convallis neque quam sed mauris. Proin sit amet ante ac lacus rhoncus placerat quis at augue. </p>  
          </div>
      </section>
      <section id="content3">
          <div>
              <h5>Lorem ipsum dolor sit amet.</h5>
              <p>Maecenas tincidunt urna velit, a facilisis urna faucibus sollicitudin. Curabitur ornare semper euismod. Suspendisse posuere arcu eu tellus scelerisque dictum. Pellentesque eu diam nec dui vehicula cursus. Fusce eget purus id nunc ornare aliquam. Nullam egestas lorem quis quam dignissim laoreet. Maecenas sollicitudin vitae ligula et mattis. Sed vehicula non eros sodales rutrum.</p>
          </div>
      </section>
    </div>

</body>
</html>

<?php 

    if(isset($_GET['id_exc']))
    {
        $id_e = addslashes($_GET['id_exc']);

        if(isset($_SESSION['id_master']))
        {
            $c->deleteComent($id_e, $_SESSION['id_master']);

        }elseif (isset($_SESSION['id_user']))
        {
          $c->deleteComent($id_e, $_SESSION['id_user']);
        }
        header("Location: discussion.php");
    }
?>

<?php

    if(isset($_POST['text']))
    {
      $text = addslashes($_POST['text']);
      if(isset($_SESSION['id_master']))
      {
          $c->insertComment($_SESSION['id_master'], $text);
      }elseif(isset($_SESSION['id_user']))
      {
          $c->insertComment($_SESSION['id_user'], $text);
      }
      header("Location: discussion.php");
    }

?>
