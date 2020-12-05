<?php
// Require functions and classes when needed
require 'shared/function.php';
spl_autoload_register('classLoader');


//DB Settings;
$dsn = 'mysql:host=localhost;dbname=reservationsalles';
$username = 'root';
$password = '';


// Session initialisation
session_start();
if (!isset($_SESSION['user'])) {
    $_SESSION['connected'] = FALSE;
} else {
    $_SESSION['connected'] = TRUE;
}

// DB connexion
try {
    $db = new PDO($dsn, $username, $password);
    try {
        $userManager = new UsersManager($db);
        $reservartionsManager = new ReservationsManager($db);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
