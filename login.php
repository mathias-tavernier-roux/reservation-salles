<?php
require('config.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
if (isset($_POST['username'])){
	$username = stripslashes($_REQUEST['username']);
	$username = mysqli_real_escape_string($conn, $username);
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($conn, $password);
	$query =  "SELECT * FROM `utilisateurs` WHERE login='$username' and password='".hash('sha256', $password)."'";
	$result = mysqli_query($conn,$query) or die(mysql_error());
	$acc = mysqli_fetch_array($result);
            // si il y a un résultat, mysqli_num_rows() nous donnera alors 1
            // si mysqli_num_rows() retourne 0 c'est qu'il a trouvé aucun résultat
            if(mysqli_num_rows($result) == 0) {
                $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
            } 
            else {
                // on ouvre la session avec $_SESSION et on redéfini toutes les infos du user (utlise pour la page profil, pour péremplir le form)
                $_SESSION['id'] = $acc[0];
                $_SESSION['username'] = $acc[1];
                $_SESSION['user'] = $acc[0];
                $_SESSION['password'] = $acc[2];
                //on redirige sur la page index.php quand c'est terminer.
                header ('location:index.php');
            }
}
?>
<form class="box" action="" method="post" name="login">
<h1 class="box-title">Connexion</h1>
<input type="text" class="box-input" name="username" placeholder="Nom d'utilisateur">
<input type="password" class="box-input" name="password" placeholder="Mot de passe">
<input type="submit" value="Connexion " name="submit" class="box-button">
<p class="box-register">Vous êtes nouveau ici? <a href="register.php">S'inscrire</a></p>
<?php if (! empty($message)) { ?>
    <p class="errorMessage"><?php echo $message; ?></p>
<?php } ?>
</form>
</body>
</html>