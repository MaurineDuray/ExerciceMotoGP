<?php
session_start();
if(!isset($_SESSION['login'])){
    header("LOCATION:index.php");
}

require "../connexion.php";

if(isset($_GET['delete']))
{
    $id=htmlspecialchars($_GET['delete']);
    $req=$bdd->prepare("SELECT * FROM membre WHERE id=?");
    $req->execute([$id]);
    if(!$donMembre =$req->fetch())
    {
        $reqMembre->closeCursor();
        header("LOCATION:admin.php");
    }
    $req->closeCursor();

    
    $delete = $bdd->prepare("DELETE FROM membre where id=?");
    $delete ->execute([$id]);
    $delete->closeCursor();
    header("LOCATION: admin.php?deletesuccess=".$id);
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
        <h3 class='ms-5 py-5'>Admin list</h3>
            <?php
            if(isset($_GET['deletesuccess'])){
                echo "<div class='alert alert-danger'>Vous avez bien supprimé l'admin n°".$_GET['deletesuccess']."</div>";
            }
            if(isset($_GET['update'])&& isset($_GET['id'])){
                echo "<div class='alert alert-warning'>Vous avez bien modifié l'admin' n°".$_GET['id']."</div>";
            }
            if(isset($_GET['add'])){
                echo "<div class='alert alert-success'>Vous avez bien ajouté un nouvel admin ! </div>";
            }
            ?>
        <a href="dashboard.php" class=" btn btn-warning mx-3"> Retour </a>
        <a href="addAdmin.php" class=" btn btn-primary my-3">Add an admin</a>
        <table class="table table-hover mx-3 pb-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Login</th>
                        <th>Mail</th>
                        
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $admin = $bdd->query("SELECT * FROM membre");
                    
                    while($donAdmin = $admin->fetch()){
                        echo "<tr>";
                            echo "<td>".$donAdmin['id']."</td>";
                            echo "<td>".$donAdmin['login']."</td>";
                            echo "<td>".$donAdmin['mail']."</td>";
                            echo "<td>";
                            echo "<a href='adminUpdate.php?id=".$donAdmin['id']."' class='btn btn-warning mx-2'>Modifier</a>";
                            echo "<a href='admin.php?delete=".$donAdmin['id']."' class='btn btn-danger mx-2'>Supprimer</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                    $admin->closeCursor();
                    
                    ?>
                     </tbody>
            </table>
    </div>
</body>
</html>