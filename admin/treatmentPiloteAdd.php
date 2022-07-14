<?php
session_start();

if(!isset($_SESSION['login'])){
    header ("LOCATION:index.php");
}

if(isset($_POST['name'])){

    $err =0;

    if(empty($_POST['name'])){
       $err=1;

    }else{
         $name = htmlspecialchars($_POST['name']);
    }

    if(empty($_POST['firstname'])){
        $err=2;
    }else{
          $firstname = htmlspecialchars($_POST['firstname']);
    }

    if(empty($_POST['nationality'])){
        $err=3;
    }else{
        $nationality =htmlspecialchars($_POST['nationality']);
    }
    
    if(empty($_POST['year'])){
        $err =4;
    }else{
        $year = htmlspecialchars($_POST['year']);
    }

    if(empty($_POST['number'])){
        $err=5;
    }else{
        $number = htmlspecialchars($_POST['number']);
        if(!is_numeric($number)){
            $err=6;
        }

    }

    if(empty($_POST['moto'])){
        $err=7;
        
    }else{
        $moto = htmlspecialchars($_POST['moto']);
    }


    
    if($err==0){
        $dossier = '../images/';
        $fichier = basename($_FILES['photo']['name']);
        $taille_maxi = 2000000;
        $taille = filesize($_FILES['photo']['tmp_name']);
        $extensions = ['.png', '.gif', '.jpg', '.jpeg'];
        $extension = strrchr($_FILES['photo']['name'], '.');
        if(!in_array($extension, $extensions)) 
        {
            $imgerror = 1;
        }
        if($taille>$taille_maxi) 
        {
            $imgerror = 2;
        }

        if(!isset($imgerror)) 
        {
        
            $fichier = strtr($fichier,
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier); 
            $fichiercplt = rand().$fichier;

            // ../images/12354969monimage.jpg
            if(move_uploaded_file($_FILES['photo']['tmp_name'], $dossier . $fichiercplt)) 
            {
               // tout est ok, insertion dans la bdd
               require "../connexion.php";
               $insert = $bdd->prepare("INSERT INTO pilote (nom,prenom,nationalite,date_naissance,numero,photo,id_moto) VALUES(:name,:firstname,:nationality,:year,:number,:photo,:moto)");
               $insert->execute([
                   ":name"=>$name,
                   ":firstname"=>$firstname,
                   ":nationality"=>$nationality,
                   ":year"=>$year,
                   ":number"=>$number,
                   ":photo"=>$fichiercplt,
                   ":moto"=>$moto
               ]);
               $insert->closeCursor();
               header("LOCATION:pilotes.php?add=success");
            }
            else 
            {
                header("LOCATION:addPilote.php?upload=echec");
            }
        }
        else
        {
            header("LOCATION:addPilote.php?imgerror=".$imgerror);
        }

    } else{
        header("LOCATION:addPilote.php?error=".$err);
    }   

}else{
    header("LOCATION:addPilote.php");
}
?>