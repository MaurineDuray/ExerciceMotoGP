<?php
session_start();
if(!isset($_SESSION['login'])){
    header("LOCATION:index.php");
}

require "../connexion.php";

if(isset($_GET['delete']))
{
    $id=htmlspecialchars($_GET['delete']);
    $req=$bdd->prepare("SELECT * FROM pilote WHERE id=?");
    $req->execute([$id]);
    if(!$donPilote =$req->fetch())
    {
        $reqPilote->closeCursor();
        header("LOCATION:pilotes.php");
    }
    $req->closeCursor();

    unlink("../images/".$donPilote['photo']);

    $delete = $bdd->prepare("DELETE FROM pilote where id=?");
    $delete ->execute([$id]);
    $delete->closeCursor();
    header("LOCATION: pilotes.php?deletesuccess=".$id);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style1.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>
<body>
    <div class="slide">
        <h3 class='ms-5 py-5'>Pilotes list</h3>

        <?php
            if(isset($_GET['add'])){
                echo "<div class='alert alert-success'>Vous avez bien ajouté une nouveau pilote ! </div>";
            }
            if(isset($_GET['update'])&& isset($_GET['id'])){
                echo "<div class='alert alert-warning'>Vous avez bien modifié le pilote n°".$_GET['id']."</div>";
            }
            if(isset($_GET['deletesuccess'])){
                echo "<div class='alert alert-danger'>Vous avez bien supprimé le pilote n°".$_GET['deletesuccess']."</div>";
            }
        ?>
        <a href="dashboard.php" class=" btn btn-warning mx-3"> Retour </a>
        <a href="addPilote.php" class=" btn btn-primary my-3 ">Add a pilote</a>

        <table class="table table-hover mx-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pilote = $bdd->query("SELECT * FROM pilote");
                    
                    while($donPilote = $pilote->fetch()){
                        echo "<tr>";
                            echo "<td>".$donPilote['id']."</td>";
                            echo "<td>".$donPilote['nom']."</td>";
                            echo "<td>".$donPilote['prenom']."</td>";
                            echo "<td>";
                            echo "<a href='piloteUpdate.php?id=".$donPilote['id']."' class='btn btn-warning mx-2'>Modifier</a>";
                            echo "<a href='pilotes.php?delete=".$donPilote['id']."' class='btn btn-danger mx-2'>Supprimer</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                    $pilote->closeCursor();
                    
                    ?>
                     </tbody>
            </table>
    </div>
</body>
</html>