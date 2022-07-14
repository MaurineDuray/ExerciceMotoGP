<?php
require "../connexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Team</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style1.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>
<body>
    <div class="slide">
       
        <div class="container"> <h3 class="py-5" >Add a team</h3>
        <form action="treatmentTeamAdd.php" method="POST" enctype="multipart/form-data">
                <div class='my-3'>
                    <label for="name">Name: </label>
                    <input type="text" name="name" id="name" value="" class="form-control">
                </div>

                <div class='my-3'>
                    <label for="marque">Marque: </label>
                    <input type="text" name="marque" id="marque" value="" class="form-control">
                </div>
               
                <div class="my-3">
                    <label for="sorte">Type: </label>
                    <input type="text" name="sorte" id="sorte" class="form-control"></input>
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