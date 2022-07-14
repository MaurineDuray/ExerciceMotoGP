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

    if(empty($_POST['marque'])){
        $err=2;
    }else{
          $marque = htmlspecialchars($_POST['marque']);
    }


    if(empty($_POST['sorte'])){
        $err=3;
        
    }else{
        $type = htmlspecialchars($_POST['sorte']);
    }


    
    if($err==0){
        $dossier = '../images/';
        $fichier = basename($_FILES['image']['name']);
        $taille_maxi = 200000;
        $taille = filesize($_FILES['image']['tmp_name']);
        $extensions = ['.png', '.gif', '.jpg', '.jpeg'];
        $extension = strrchr($_FILES['image']['name'], '.');
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
            if(move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $fichiercplt)) 
            {
               // tout est ok, insertion dans la bdd
               require "../connexion.php";
               $insert = $bdd->prepare("INSERT INTO moto (nom,marque,type,image) VALUES(:name,:marque,:type,:image)");
               $insert->execute([
                   ":name"=>$name,
                   ":marque"=>$marque,
                   ":type"=>$type,
                   ":image"=>$fichiercplt  //attention attention !!!!! mettre fichier $fichiercplt et as $image !!!!!
               ]);
               $insert->closeCursor();
               header("LOCATION:teams.php?add=success");
            }
            else 
            {
                header("LOCATION:addTeam.php?upload=echec");
            }
        }
        else
        {
            header("LOCATION:addTeam.php?imgerror=".$imgerror);
        }

    } else{
        header("LOCATION:addTeam.php?error=".$err);
    }   

}else{
    header("LOCATION:addTeam.php");
}
?>