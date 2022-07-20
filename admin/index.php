<?php
    session_start();

    // test si déjà connecté
    if(isset($_SESSION['login']))
    {
        header("LOCATION:dashboard.php");
    } 

    if(isset($_POST['login']))
    {
        if(empty($_POST['login']) OR empty($_POST['password']))
        {
            $error="Veuillez remplir correctement le formulaire";
        }else{
            require "../connexion.php";
            $login = htmlspecialchars($_POST['login']);
            $req = $bdd->prepare("SELECT * FROM membre WHERE login=?");
            $req->execute([$login]);
            if(!$don = $req->fetch())
            {
                $error="Votre Login n'existe pas";
            }else{
                if(password_verify($_POST['password'], $don['mdp']))
                {
                    $_SESSION['login']=$don['login'];
                    $req->closeCursor();
                    header("LOCATION:dashboard.php");
                }else{
                    $error="Votre mot de passe ne correspond pas";
                }
            }
            $req->closeCursor();

        }
    
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MotoGP-Admin</title>
    <link rel="stylesheet" href="style1.css">
</head>

<body>
        <nav>
            <p>MotoGP</p>
            <ul>
                
                <li><a href="../index.php#home">HOME</a></li>
                <li><a href="../index.php#ecuries">TEAMS</a></li>
                <li><a href="admin/index.php" style="color:yellow">ADMIN</a></li>
            </ul>
        </nav>
    <div class="slide" id="connexion">
        <div class="formulaire">
            <h3>Welcome </h3>
            <h3> Admin MotoGP</h3>
           
            <form action="index.php" method="POST"> <h4>Connexion</h4>
                <label for="login" id="login"> Login :</label>
                <input type="text" name="login" id="login" placeholder="login">

                <label for="password" id="password">  Password: </label>
                <input type="password" name="password" id="password" placeholder="your password">

                <input type="submit" value="CONNECT" id="send">

                <?php
                        if(isset($error))
                        {
                            echo "<div class='alert alert-danger'>".$error."</div>";
                        }
                ?>
            </form>
        </div>
        
        <footer>
            &copy;copyrightPHP-Epse2022
        </footer>
    </div>
    
</body>
</html>