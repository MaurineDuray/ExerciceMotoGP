<?php
  session_start();


  if(!isset($_SESSION['login']))
  {
      header("LOCATION:index.php");
  }


  if(isset($_GET['id']))
  {
   
    $id = htmlspecialchars($_GET['id']);

    require "../connexion.php";
    $pilote = $bdd->prepare("SELECT * FROM pilote WHERE id=?");
    $pilote->execute([$id]);
    if(!$donPilote = $pilote->fetch())
    {
        $pilote->closeCursor();
        header("LOCATION:pilotes.php");
    }
    $pilote->closeCursor();

    
    $err = 0;

    if(empty($_POST['name']))
    {
        $err=1;
    }else{
        $name = htmlspecialchars($_POST['name']);
    }

    if(empty($_POST['firstname']))
    {
        $err=2;
    }else{
        $firstname= htmlspecialchars($_POST['firstname']);
    }

    if(empty($_POST['nationality']))
    {
        $err=3;
    }else{
        $nationality = htmlspecialchars($_POST['nationality']);
        
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

    if($err==0)
    {
        // 2 options: soit il y a une image soit il n'y a pas d'image 
        if(empty($_FILES['photo']['tmp_name']))
        {
            $update = $bdd->prepare("UPDATE pilote SET nom=:name, prenom=:firstname, nationalite=:nationality,date_naissance=:birthdate, numero=:number, id_moto=:moto WHERE id=:myid");
            $update->execute([
                ":name"=>$name,
                ":firstname"=>$firstname,
                ":birthdate"=>$year,
                ":nationality"=>$nationality,
                ":number"=>$number,
                ":moto"=>$moto,
                ":myid"=>$id
            ]);
            $update->closeCursor();
            header("LOCATION:pilotes.php?update=success&id=".$id);
        }else{
             // traitement de l'image car il y en a une
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
            if($taille>$taille_maxi) // on teste la taille de notre fichier
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

              
                if(move_uploaded_file($_FILES['photo']['tmp_name'], $dossier . $fichiercplt)) 
                {
                   
                unlink("../images/".$donPilote['photo']);
                  
                   $update = $bdd->prepare("UPDATE pilote SET nom=:name, prenom=:firstname, nationalite=:nationality,date_naissance=:birthdate, numero=:number, id_moto=:moto, photo=:photo WHERE id=:myid");
                    $update->execute([
                        ":name"=>$name,
                        ":firstname"=>$firstname,
                        ":birthdate"=>$year,
                        ":nationality"=>$nationality,
                        ":number"=>$number,
                        ":moto"=>$moto,
                        ":photo"=>$fichiercplt,
                        ":myid"=>$id
                   ]);
                   $update->closeCursor();
                   header("LOCATION:pilotes.php?update=success&id=".$id);
                }
                else 
                {
                    header("LOCATION:piloteUpdate.php?id=".$id."&upload=echec");
                }
            }
            else
            {
                header("LOCATION:piloteUpdate.php?id=".$id."&imgerror=".$imgerror);
            }
            


        }


       

    }else{
        header("LOCATION:piloteUpdate.php?id=".$id."&error=".$err);
    }


  }else{
      /* redirection si le formulaire n'a pas été envoyé */
      header("LOCATION:pilotes.php");
  }