<?php
require("connexion.php");
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
                
                <li><a href="#home">HOME</a></li>
                <li><a href="#ecuries">TEAMS</a></li>
                <li><a href="admin/index.php" style="color:yellow">ADMIN</a></li>
            </ul>
        </nav>
        <div class="slide" id="home">
            
            <div id="title">
                <h1>MotoGP</h1>
                <h6>- Exercice PHP -</h6>
            </div>
            <div class="scroll">
                <p> \/ Scroll more</p>
            </div>
        </div>
        <div class="slide" id="ecuries">
            
            <div class="pilote">
                <h3>LES PILOTES</h3>
                <div class="tableau">
                    <?php
                        $pilote=$bdd->query("SELECT * FROM pilote");
                        while($donPilote=$pilote->fetch()){
                            
                            echo"<a href='pilote.php?id=".$donPilote['id']."'>".$donPilote['nom']." ".$donPilote['prenom']."</a>";
                            
                        }
                        $pilote->closeCursor();
                    ?>
                </div>    
            </div>

            <div class="teams">
                <h3>LES TEAMS</h3>
                <div class="tableau">
                    <?php
                        $moto=$bdd->query("SELECT * FROM moto");
                        while($donMoto=$moto->fetch()){
                            
                            echo"<a href=team.php?id=".$donMoto['id']."'>".$donMoto['nom']."</a>";
                            
                            
                        }
                        $pilote->closeCursor();
                    ?>
                </div>
            </div>
            <footer>
                 &copy;copyrightPHP-Epse2022
            </footer>
        </div>
    
    
</body>
</html>