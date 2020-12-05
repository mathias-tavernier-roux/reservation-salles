<?php
session_start();
$username = $_SESSION['id'];
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
require('config.php');
if (isset($username, $_REQUEST['password']))
{
    // récupérer le mot de passe et supprimer les antislashes ajoutés par le formulaire
	$password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn, $password);
    $password = hash('sha256', $password);
	//requéte SQL + mot de passe crypté
    $query = "UPDATE `utilisateurs` SET `password`='$password' WHERE `id`='$username'";
	// Exécute la requête sur la base de données
    $res = mysqli_query($conn, $query);
    if($res)
    {
       echo "<div class='sucess'>
             <h3>Votre Mot de Passe A été Modifié Avec Succés</h3>
             <p>Cliquez ici pour vous <a href='login.php'>Reconnecter</a></p>
			 </div>";
    }
}else{
?>
<form class="box" action="" method="post">
    <h1 class="box-title">Modifier Ses Informations</h1>
    <input type="password" class="box-input" name="password" placeholder="Mot de passe" required />
    <input type="submit" name="submit" value="Modifier" class="box-button" />
    <p class="box-register">Déjà inscrit? <a href="login.php">Connectez-vous ici</a></p>
</form>
<?php } ?>
</body>
</html>