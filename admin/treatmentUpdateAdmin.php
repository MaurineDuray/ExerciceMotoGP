<?php
  session_start();


  if(!isset($_SESSION['login']))
  {
      header("LOCATION:index.php");
  }


  if(!isset($_GET['id']))
  {
    header ("LOCATION: admin.php?");
  }
    
    require "../connexion.php";

    $id = htmlspecialchars($_GET['id']);

    
    $req = $bdd->prepare("SELECT * FROM membre WHERE id=?");
    $req->execute([$id]);
    if(!$don = $req->fetch())
    {
        $req->closeCursor();
        header("LOCATION:admin.php?ERRRRRORR");
    }
    $req->closeCursor();


    if(isset($_POST['login']))
    {
        require "../connexion.php";
 
        $err = 0;
        if(empty($_POST['login']))
        {
           $err= 1; 
        }else{
            $login=htmlspecialchars($_POST['login']);
           
            if($login!=$don['login'])
            {
               
                $reqLog = $bdd->prepare("SELECT * FROM membre WHERE login=?");
                $reqLog->execute([$login]);
                if($donLog = $reqLog->fetch())
                {
                   $err=2;
                }
                $reqLog->closeCursor();      
            }
        }
    
        if(empty($_POST['mail']))
        {
            $err=3;

        }else{
            $mail = strip_tags($_POST['mail']); 
        }
    
        if($err==0)
        {
           $update = $bdd->prepare("UPDATE membre SET login=:login, mail=:mail WHERE id=:myid");
           $update->execute([
               ":login"=>$login,
               ":mail"=>$mail,
               ":myid"=>$id
           ]);
           $update->closeCursor();
           header("LOCATION:admin.php?update=success&id=".$id);
            
        }else{
            $_SESSION['errorAddUser'] = $err;
            header("LOCATION:adminUpdate.php?id=".$id);
        }
    
    
      
    
    
    
    }else{
       
        header("LOCATION:admin.php?ERROR");
    }