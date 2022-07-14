<?php
    session_start();
    // si la session n'existe pas, redirection vers formulaire
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }

      // tester si il y a le get id dans l'URL
      if(!isset($_GET['id']))
      {
          header("LOCATION:pilotes.php");
      }
      require "../connexion.php";
  
      // récup les données qui corresponde à l'id
      $id = htmlspecialchars($_GET['id']);
  
  
      $req = $bdd->prepare("SELECT * FROM moto WHERE id=?");
      $req->execute([$id]);

      if(!$don = $req->fetch())
      {
          $req->closeCursor();
          header("LOCATION:teams.php");
      }
      $req->closeCursor();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="style1.css">
    <title>Update team</title>
</head>
<body>
<div class="slide">
<div class="container">
    <h1 class="mb-3 py-5">Modify the team : <?= $don['nom'] ?></h1>
      <form action="treatmentUpdateTeam.php?id=<?= $don['id'] ?>" method="POST" enctype="multipart/form-data">
        
      <div class='my-3'>
                    <label for="name">Name: </label>
                    <input type="text" name="name" id="name" value="<?=$don['nom']?>" class="form-control">
                </div>

                <div class='my-3'>
                    <label for="marque">Marque: </label>
                    <input type="text" name="marque" id="marque" value="<?=$don['marque']?>" class="form-control">
                </div>
               
                <div class="my-3">
                    <label for="sorte">Type: </label>
                    <input type="text" name="sorte" id="sorte" class="form-control " value="<?=$don['type']?>"></input>
                </div>


                <div class="my-3">
                    <label for="image">Image: </label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="200000">
                    <input type="file" name="image" id="image" class="form-control">
                </div>

               
                <div class="my-3">
                    <input type="submit" value="Add" class="btn btn-primary">
                    <a href="teams.php" class="btn btn-secondary">Return</a>
                </div>
      </form>
</div>
</div>
</body>
</html>