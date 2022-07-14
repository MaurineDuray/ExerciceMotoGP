<?php
require("connexion.php");
if(isset($_GET['id'])){
    $id=htmlspecialchars($_GET['id']);
    $req=$bdd->prepare("SELECT * FROM pilote  WHERE id=?");
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
    <title><?= $don['nom']?></title>
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


        <div class="image">
          <?php 
          echo '<img src="images/'.$don["photo"].'" alt="">';
          ?>
           
        </div>
        <div class="desc">
            <?php
                echo '<h4>'.$don["nom"].'</h4>';
                echo '<h4>'.$don["prenom"].'</h4>';
                echo ' <p>'.$don["date_naissance"].'</p>';
                echo ' <p>Pays: '.$don["nationalite"].'</p>';
                
                $pilotes = $bdd->prepare("SELECT moto.nom from moto inner join pilote on pilote.id_moto=moto.id where id_moto=? limit 1");
                       $pilotes->execute([$id]);
                       while($donPilotes = $pilotes->fetch())
                       {
                           
                               echo "<a href='team.php?id=".$don['id_moto']."'>".$donPilotes['nom']."</a><br>";
                              
            
                       }
                       $pilotes->closeCursor();


               
               

            ?>
           
            
            <a href="index.php#ecuries" id='back'> <  Retour</a>
        </div>
        
    </div>
    <footer>
        &copy;copyrightPHP-Epse2022
    </footer>
</body>
</html>