<?php
require("connexion.php");

if(isset($_GET['id'])){
    $id=htmlspecialchars($_GET['id']);
    $req=$bdd->prepare("SELECT * FROM moto  WHERE id=?");
    $req->execute([$id]);
    if(!$don = $req->fetch())
    {
        $req->closeCursor();
        header("LOCATION:index.php");
    }
    $req->closeCursor();

}else{
    header("LOCATION:index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MotoGP-Exercice</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
  
        <nav>
            <p>MotoGP</p>
            <ul>
                
                <li><a href="index.php#home">HOME</a></li>
                <li><a href="index.php#ecuries">TEAMS</a></li>
                <li><a href="admin/index.php" style="color:yellow">ADMIN</a></li>
            </ul>
        </nav>

        <div class="slide" id="presPilote">


<div class="image" id="motoimg">
  <?php 
  echo '<img  src="images/'.$don["image"].'" alt="">';
  ?>
   
</div>
<div class="desc">
    <?php
        echo '<p>'.$don["id"].'</p>';
        echo '<h4>'.$don["nom"].'</h4>';
        echo '<h4>'.$don["marque"].'</h4>';
        echo '<p>'.$don["type"].'</p>';
        echo '<Br>';
       

    ?>
  
  <h3>LES PILOTES</h3>
                <div class="tableaupilote">
                    <?php
                       
                       $pilotes = $bdd->prepare("SELECT * FROM pilote WHERE id_moto=?");
                       $pilotes->execute([$id]);
                       while($donPilotes = $pilotes->fetch())
                       {
                           
                               echo "<a href='pilote.php?id=".$donPilotes['id']."'>".$donPilotes['nom']." ".$donPilotes['prenom']."</a><br>";
                              
                                   

                       }
                       $pilotes->closeCursor();
                    ?>
                </div>   
    
    <a href="index.php#ecuries" id='back'> <  Retour</a>
</div>

</div>

        </div>
    <footer>
        &copy;copyrightPHP-Epse2022
    </footer>
</body>
</html>