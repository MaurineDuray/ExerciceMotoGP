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
  
  
      $req = $bdd->prepare("SELECT * FROM pilote WHERE id=?");
      $req->execute([$id]);

      if(!$don = $req->fetch())
      {
          $req->closeCursor();
          header("LOCATION:pilotes.php");
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
    <title>Update pilote</title>
</head>
<body>
<div class="slide">
<div class="container">
    <h1 class="mb-3 py-5">Modify the pilote : <?= $don['nom'] ?></h1>
      <form action="treatmentUpdatePilote.php?id=<?= $don['id'] ?>" method="POST" enctype="multipart/form-data">
        
      <div class='my-3'>
                    <label for="name">Name: </label>
                    <input type="text" name="name" id="name" value="<?= $don['nom'] ?>" class="form-control">
                </div>

                <div class='my-3'>
                    <label for="firstname">Firtsname: </label>
                    <input type="text" name="firstname" id="firstname" value="<?= $don['prenom'] ?>" class="form-control">
                </div>
               
                <div class="my-3">
                    <label for="nationality">Nationality: </label>
                    <input type="text" name="nationality" id="nationality" class="form-control" value="<?= $don['nationalite'] ?>"></input>
                </div>

                <div class="my-3">
                    <label for="year">Birthdate: </label>
                    <input type="date" name="year" id="year"  class="form-control" value="<?= $don['date_naissance'] ?>">
                </div>

                <div class="my-3">
                    <label for="number">Number: </label>
                    <input type="number" name="number" id="number" class="form-control" value="numero"></input>
                </div>

                <div class="my-3">
                    <label for="photo">Photo: </label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="200000">
                    <input type="file" name="photo" id="photo" class="form-control">
                </div>

                <div class="my-3">
                    <label for="moto">Moto: </label>
                    <select name="moto" id="moto" class="form-control" value="<?= $don['id_moto'] ?>" default="<?= $don['id_moto'] ?>">
                        <?php
                            $moto = $bdd->query("SELECT * FROM moto");
                            while($donMoto = $moto->fetch())
                            {
                                echo '<option value="'.$donMoto['id'].'">'.$donMoto['nom'].'</option>';
                            }
                            $moto->closeCursor();
                        ?>
                    </select>
                </div>
        <div class="form-group">
            <input type="submit" value="Modify" class="btn btn-warning">
        </div>
      </form>
</div>
</div>
</body>
</html>