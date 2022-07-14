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
    $moto = $bdd->prepare("SELECT * FROM moto WHERE id=?");
    $moto->execute([$id]);
    if(!$donMoto = $moto->fetch())
    {
        $moto->closeCursor();
        header("LOCATION:teams.php");
    }
    $moto->closeCursor();

    
    $err = 0;

    if(empty($_POST['name']))
    {
        $err=1;
    }else{
        $name = htmlspecialchars($_POST['name']);
    }

    if(empty($_POST['marque']))
    {
        $err=2;
    }else{
        $marque= htmlspecialchars($_POST['marque']);
    }

    

    if(empty($_POST['sorte'])){
        $err =4;
    }else{
        $type = htmlspecialchars($_POST['sorte']);
    }

   

    if($err==0)
    {
        
        if(empty($_FILES['image']['tmp_name']))
        {
            $update = $bdd->prepare("UPDATE moto SET nom=:name, marque=:marque, type=:type  WHERE id=:myid");
            $update->execute([
                ":name"=>$name,
                ":marque"=>$marque,
                ":type"=>$type,
               
                ":myid"=>$id
            ]);
            $update->closeCursor();
            header("LOCATION:teams.php?update=success&id=".$id);
        }else{
             // traitement de l'image car il y en a une
            $dossier = '../images/';
            $fichier = basename($_FILES['image']['name']);
            $taille_maxi = 2000000;
            $taille = filesize($_FILES['image']['tmp_name']);
            $extensions = ['.png', '.gif', '.jpg', '.jpeg'];
            $extension = strrchr($_FILES['image']['name'], '.');
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

              
                if(move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $fichiercplt)) 
                {
                   
                unlink("../images/".$donMoto['image']);
                  
                $update = $bdd->prepare("UPDATE moto SET nom=:name, marque=:marque, type=:type, image=:image  WHERE id=:myid");
                $update->execute([
                    ":name"=>$name,
                    ":marque"=>$marque,
                    ":type"=>$type,
                    ":image"=>$fichiercplt,
                    ":myid"=>$id
                   ]);
                   $update->closeCursor();
                   header("LOCATION:teams.php?update=success&id=".$id);
                }
                else 
                {
                    header("LOCATION:motoUpdate.php?id=".$id."&upload=echec");
                }
            }
            else
            {
                header("LOCATION:motoUpdate.php?id=".$id."&imgerror=".$imgerror);
            }
            


        }


       

    }else{
        header("LOCATION:motoUpdate.php?id=".$id."&error=".$err);
    }


  }else{
     
      header("LOCATION:teams.php");
  }