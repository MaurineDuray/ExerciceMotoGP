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
    
    <div class="slide" id="board">
        
        <div class="slide" id="dash">
            <h3>Welcome on dashboard </h3><br>
            <div class="categories">
                
                <a href="admin.php"> ADMIN </a>
                <a href="pilotes.php"> PILOTES </a>
                <a href="teams.php"> TEAMS </a>
            </div>
        </div>
        <footer>
        &copy;copyrightPHP-Epse2022
    </footer>
    </div>
    
</body>
</html>