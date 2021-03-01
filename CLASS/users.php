<?php 
    
Class User{
  
  private $pdo;
  
  //Constructor  
  public function __construct($dbname, $host, $user, $pass)
    {
      try {
        
        $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user,$pass);

      }catch (PDOException $e) 
      {
        echo "Error in DB: ".$e->getMessage();        
      }catch(Exception $e) 
      {
        echo "Error: ".$e->getMessage();
      }
    }

    //Register
    public function register($name, $email, $pass)
    {
      //check if email is alredy exists before register
      $cmd = $this->pdo->prepare("SELECT id FROM users WHERE email = :e");
      $cmd->bindValue(":e", $email);
      $cmd->execute();
      if($cmd->rowCount()>0)
      {
          return false;
      }else 
      {
          $cmd = $this->pdo->prepare("INSERT INTO users (name, email, pass) values (:n, :e, :p)");
          $cmd->bindValue(":n",$name);
          $cmd->bindValue(":e",$email);
          $cmd->bindValue(":p",md5($pass));
          $cmd->execute();
          return true;
      }
    }

    //login
    public function login($email, $pass)
    {
      $cmd = $this->pdo->prepare("SELECT * FROM users WHERE email = :e AND pass = :p");
      $cmd->bindValue(":e", $email);
      $cmd->bindValue(":p", md5($pass));
      $cmd->execute();
      if($cmd->rowCount() >0)
      {
          $data = $cmd->fetch();
          session_start();
          if($data['id'] == 1)
          {
              $_SESSION['id_master'] = $data['id'];
          }else
          {
              $_SESSION['id_user'] = $data['id'];
          }
          return true;
      }else 
      {
        return false;
      }
    }
  
    public function searchData($id){

      $cmd = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
      $cmd->bindValue(":id", $id);
      $cmd->execute();
      $data = $cmd->fetch();
      return $data;
    }


    public function searchAllUsers()
    {
        $cmd = $this->pdo->prepare(
          "SELECT users.id, users.name, users.email, 
            COUNT(comments.id) AS 'quantidade'
            FROM users
            LEFT JOIN comments
            ON users.id = comments.fk_id_usuario
            GROUP BY users.id");
        $cmd->execute();
        $data = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $data; 
    }
}
?>