<?php
  session_start();

  /* security */
  if(!isset($_SESSION['login']))
  {
      header("LOCATION:index.php");
  }

  /* tester si formulaire envoyé ou non */
  if(isset($_GET['id']))
  {
    // viens de l'input type hidden
    $id = htmlspecialchars($_GET['id']);

    // vérification dans la bdd si l'oeuvre existe 
    require "../connexion.php";
    $membre = $bdd->prepare("SELECT * FROM membre WHERE id=?");
    $membre->execute([$id]);
    if(!$donMembre = $membre->fetch())
    {
        $membre->closeCursor();
        header("LOCATION:admin.php");
    }
    $membre->closeCursor();



    $err =0;

    if(empty($_POST['login'])){
       $err=1;

    }else{
         $login = htmlspecialchars($_POST['login']);
    }

    if(empty($_POST['password'])){
        $err=2;
    }else{
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    }

    if(empty($_POST['mail'])){
        $err=3;
    }else{
        $mail =  htmlspecialchars($_POST['mail']);
    }
   

    if($err==0)
    {
      
            $update = $bdd->prepare("UPDATE membre SET login=:login, mdp=:password, mail=:mail WHERE id=:myid");
            $update->execute([
                ":login"=>$login,
                ":password"=>$password,
                ":mail"=>$mail,
            
                ":myid"=>$id
            ]);
            $update->closeCursor();
            header("LOCATION:admin.php?update=success&id=".$id);
        
            

    }else{
        header("LOCATION:adminUpdate.php?id=".$id."&error=".$err);
    }


  }else{
      /* redirection si le formulaire n'a pas été envoyé */
      header("LOCATION:admin.php");
  }