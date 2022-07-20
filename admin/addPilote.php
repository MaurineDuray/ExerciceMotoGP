<?php
require "../connexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pilote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style1.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>
<body>
    <div class="slide">
       
        <div class="container"> <h3 class="py-5" >Add a pilote</h3>
        <form action="treatmentPiloteAdd.php" method="POST" enctype="multipart/form-data">
                <div class='my-3'>
                    <label for="name">Name: </label>
                    <input type="text" name="name" id="name" value="" class="form-control">
                </div>

                <div class='my-3'>
                    <label for="firstname">Firtsname: </label>
                    <input type="text" name="firstname" id="firstname" value="" class="form-control">
                </div>
               
                <div class="my-3">
                    <label for="nationality">Nationality: </label>
                    <input type="text" name="nationality" id="nationality" class="form-control"></input>
                </div>

                <div class="my-3">
                    <label for="year">Birthdate: </label>
                    <input type="date" name="year" id="year"  class="form-control" value="">
                </div>

                <div class="my-3">
                    <label for="number">Number: </label>
                    <input type="number" name="number" id="number" class="form-control"></input>
                </div>

                <div class="my-3">
                    <label for="photo">Photo: </label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="200000">
                    <input type="file" name="photo" id="photo" class="form-control">
                </div>

                <div class="my-3">
                    <label for="moto">Moto: </label>
                    <select name="moto" id="moto" class="form-control">
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
                <div class="my-3">
                    <input type="submit" value="Add" class="btn btn-primary">
                    <a href="pilotes.php" class="btn btn-secondary">Return</a>
                </div>
            </form>

            <?php
                if(isset($_GET['error']))
                {
                    echo "<div class='alert alert-danger'>Une erreur est survenue (code error: ".$_GET['error']." )</div>";
                }
                if(isset($_GET['upload']))
                {
                    echo "<div class='alert alert-danger'>Une erreur est survenue lors de l'upload du fichier</div>";
                }
                if(isset($_GET['imgerror']))
                {
                    if($_GET['imgerror']==1)
                    {
                        echo "<div class='alert alert-danger'>L'extension du fichier n'est pas acceptée</div>";
                    }else{
                        echo "<div class='alert alert-danger'>La taille du fichier dépasse la limite autorisée</div>";
                    }
                }
            ?>
            </div>
    </div>
</body>
</html>