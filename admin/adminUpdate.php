<?php

session_start();
    // si la session n'existe pas, redirection vers formulaire
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }

    if(!isset($_GET['id'])){
        header("LOCATION:admin.php");
    }

    require "../connexion.php";

    $id = htmlspecialchars($_GET['id']);

    $req = $bdd->prepare("SELECT * FROM membre where id=?");
    $req->execute([$id]);
    if(!$donMembre = $req->fetch()){
        $req->closeCursor();
        header ("LOCATION: admin.php");
    
    }
    $req->closeCursor();



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style1.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>
<body>
    <div class="slide">
        <div class="container">
        <h3 class="py-5" >Update an admin</h3>
        <form action="treatmentUpdateAdmin.php" method="POST">
        <div class='my-3'>
                    <label for="login">Login:  </label>
                    <input type="text" name="login" id="login" value="<?php echo $donMembre['login'] ?>" class="form-control">
                </div>
                <div class='my-3'>
                    <label for="password"> Password : </label>
                    <input type="password" name="password" id="password" value="<?php echo $donMembre['mdp']?>" class="form-control">
                </div>
                <div class='my-3'>
                    <label for="mail"> Mail : </label>
                    <input type="mail" name="mail" id="mail" value="<?php echo $donMembre['mail']?>" class="form-control">
                </div>
                <div class="my-3">
                    <input type="submit" value="Modify" class="btn btn-primary">
                    <a href="admin.php" class="btn btn-secondary">Return</a>
                </div>
        </form>
    </div>
    </div>
</body>
</html>