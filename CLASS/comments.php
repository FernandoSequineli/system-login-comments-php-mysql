<?php 
date_default_timezone_set('Europe/Dublin');    
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

    public function searchComments()
      {
          $cmd = $this->pdo->prepare
          (
            "SELECT *, 
            (SELECT name FROM users WHERE id = fk_id_usuario) as name_people 
            FROM comments ORDER BY dia DESC");
          $cmd->execute();
          $data = $cmd->fetchAll(PDO::FETCH_ASSOC);
          return $data;
          //id, comentario, dia, horario, name_people   

      }
      
    public function deleteComent($id_coment, $id_user) 
    {
        if($id_user == 1) //adm
        {
            $cmd = $this->pdo->prepare("DELETE FROM comments WHERE id = :id_c");
            $cmd->bindValue(":id_c", $id_coment);
            $cmd->execute();
        }else 
        {
            $cmd = $this->pdo->prepare("DELETE FROM comments WHERE id = :id_c AND fk_id_usuario = :id_user");
            $cmd->bindValue(":id_c", $id_coment);
            $cmd->bindValue(":id_user", $id_user);
            $cmd->execute();
        }

    } 

    public function insertComment($id_people, $comment)
    {
        $cmd = $this->pdo->prepare("INSERT INTO comments (comentarios, dia, horario, fk_id_usuario) VALUES (:c, :d, :h, :fk)");
        $cmd->bindValue(":c",$comment);
        $cmd->bindValue(":d",date('Y-m-d'));
        $cmd->bindValue("h",date('H:i'));
        $cmd->bindValue(":fk",$id_people);
        $cmd->execute();

    }
}
  ?>