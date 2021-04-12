
<?php 
  session_start();
  if(!isset($_SESSION['id_master'])){
    header("Location: index.php");
  }
  require_once 'CLASS/users.php';
  $us = new User("projeto_comentarios", "localhost", "root", "");
  $data = $us->searchAllUsers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/data.css">
  <title>Document</title>
</head>
<body>

  <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="discussion.php"></a>Discussion</li>
        <li><a href="logout.php">Log out</a></li>
      </ul>
  </nav>

  <table>
    <tr id="title">
        <td>ID</td>
        <td>NAME</td>
        <td>EMAIL</td>
        <td>COMMENTS</td>
    </tr>

    <?php 
      if(count($data) > 0)
      {
          foreach($data as $v)
          { ?>

            <tr>
                <td><?php echo $v['id'] ?></td>
                <td><?php echo $v['name'] ?></td>
                <td><?php echo $v['email'] ?></td>
                <td><?php echo $v['quantidade'] ?></td>
            </tr>

   <?php }
      }else
      {
         echo "No users registered yet";
      }
    ?>   
  </table>
</body>
</html>
