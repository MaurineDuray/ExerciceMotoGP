<?php
session_start();

if(!isset($_SESSION['login'])){
    header ("LOCATION:index.php");
}

if(isset($_POST['login'])){

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
        
    


    if($err==0){
        require "../connexion.php";

        $insert = $bdd-> prepare("INSERT INTO membre (login,mdp,mail) VALUES (:login,:mdp,:mail)");
        $insert -> execute([
            ':login'=>$login,
            ':mdp'=>$password,
            ':mail'=>$mail
        ]);
        $insert->closeCursor();
        header("LOCATION:admin.php?add=success");
    }else{
        header("LOCATION:admin.php?error=".$err);
    }
}else{
    header("LOCATION:addAdmin.php");
}
?>