<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
require('config.php');
if (isset($_REQUEST['username'], $_REQUEST['password'])) {
    $requete = "SELECT `login` FROM `utilisateurs` ORDER BY `id` DESC";
    $res = mysqli_query($conn, $requete);
    $resultats = mysqli_fetch_all ($res);
    $MAX = count($resultats);
    $MAX = $MAX - 1;
    $VNumber = $MAX;
    for ($number; $VNumber >= 0; $VNumber - 1)
    {
        $number = 0;
        for ($number; isset($resultats[$VNumber][$number]); $number++)
        {
        if ($_REQUEST['username'] == $resultats[$VNumber][$number])
        {
            $message = "Ce Nom D'Utilisateur est deja pris";
            goto error;
        }
        }
        $VNumber = $VNumber - 1;
    }
    // récupérer le nom d'utilisateur et supprimer les antislashes ajoutés par le formulaire
	$username = stripslashes($_REQUEST['username']);
	$username = mysqli_real_escape_string($conn, $username);
	// récupérer le mot de passe et supprimer les antislashes ajoutés par le formulaire
	$password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn, $password);
	//requéte SQL + mot de passe crypté
    $query = "INSERT into `utilisateurs` (login, password) VALUES ('$username','".hash('sha256', $password)."')";
	// Exécute la requête sur la base de données
    $res = mysqli_query($conn, $query);
    
    if($res){
       echo "<div class='sucess'>
             <h3>Vous êtes inscrit avec succès.</h3>
             <p>Cliquez ici pour vous <a href='login.php'>connecter</a></p>
			 </div>";
    }
}else{
?>
<form class="box" action="" method="post">
    <h1 class="box-title">Créer Un Compte</h1>
	<input type="text" class="box-input" name="username" placeholder="Nom d'utilisateur" required />
    <input type="password" class="box-input" name="password" placeholder="Mot de passe" required />
    <input type="submit" name="submit" value="S'inscrire" class="box-button" />
    <p class="box-register">Déjà inscrit? <a href="login.php">Connectez-vous ici</a></p>
    <?php if (! empty($message)) 
    { ?>
    <p class="errorMessage">
    <?php
    error:
    echo $message; }
    ?></p>
</form>
<?php } ?>
</body>
</html>