<?php
	// Initialiser la session
	session_start();
	// Vérifiez si l'utilisateur est connecté, sinon modifier son nom d'utilisateur en anonymous
	if(!isset($_SESSION["username"])){
        $_SESSION['username'] = "anonymous";
    }
?>
<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<div class="sucess">
		<?php
        echo "<p>Bienvenue sur La Page de Réservation de La Salle Borely</p>";
        ?>
        <?php
        if($_SESSION['username'] == "anonymous")
            {
                echo "<a href='login.php' class='DC-Button'>Se Connecter</a>";
                echo "<a href='php/plan-load.php' class='DC-Button'>Acceder au planning</a>";
            }
        else
            {
                echo "<a href='php/res-load.php' class='DC-Button'>Acceder au formulaire de reservation</a>";
                echo "<a href='php/plan-load.php' class='DC-Button'>Acceder au planing</a>";
                echo "<a href='profil.php' class='DC-Button'>Modifier Son Mot de Passe</a>";
                echo "<a href='logout.php' class='DC-Button'>Se Deconnecter</a>";
            }
        ?>
		</div>
	</body>
</html>