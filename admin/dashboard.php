<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }

    /* déconnexion de l'utilisateur */
    if(isset($_GET['deco']))
    {
        session_destroy();
        header("LOCATION:index.php?decosuccess=ok");
    }

    require "../connexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MotoGP-Dashboard</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
<nav>
            <p>MotoGP</p>
            <ul>
                
                <li><a href="#home">HOME</a></li>
                <li><a href="#ecuries">TEAMS</a></li>
                <li><a href="dashboard.php?deco=ok" style="color:yellow">DECONNEXION</a></li>
            </ul>
        </nav>
    <div class="slide" id="board">
        
        <div class="slide" id="dash">
            <h3>Welcome on dashboard </h3><br>
            
            <div class="categories">
                
                <a href="admin.php"> ADMIN </a>
                <a href="pilotes.php"> PILOTES </a>
                <a href="teams.php"> TEAMS </a><br>
                
            </div>
        </div>
        <footer>
        &copy;copyrightPHP-Epse2022
    </footer>
    </div>
    
</body>
</html>