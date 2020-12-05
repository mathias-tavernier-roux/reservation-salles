<?php
/*
Une page permettant de voir une réservation (reservation.php)
Cette page affiche le nom du créateur, le titre de l’événement, la
description, l’heure de début et de fin. Pour savoir quel évènement afficher,
vous devez récupérer l’id de l’événement en utilisant la méthode get. (ex :
http://localhost/reservationsalles/evenement/?id=1) Seuls les personnes
connectées peuvent accéder aux événements.
*/


$page_title = 'Reservation details';
// $msgAlert = [];

require 'shared/initialize.php';
redirect($_SESSION['connected']);

include 'shared/head.php';
include 'shared/header.php';

// GET event id to display
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $reservation = $reservartionsManager->get($id);
} else {
    header('Location: planning.php');
}



?>


<!-- Main HTML content goes here -->
<main class="container-fluid bg-dark text-light ">
    <h1 class="my-3 col-12 text-center"><?php echo $page_title; ?></h1>
    <div class="col-12 text-center">
        <?php // displayAlert($msgAlert); 
        ?>
    </div>
    <div class="d-flex justify-content-center m-5">
        <div class="card bg-secondary" style="width: 18rem;">
            <div class="card-body">
                <h1 class="card-title"><?php echo $reservation->titre() ?></h1>
                <hr>
                <h6 class="card-subtitle mb-2"><?php echo Reservation::dateFromStringToDateTimeObject($reservation->debut())->format('l d Y')  ?>
                    from <?php echo Reservation::dateFromStringToDateTimeObject($reservation->debut())->format('H')  ?> to <?php echo Reservation::dateFromStringToDateTimeObject($reservation->fin())->format('H')  ?> </h6>
                <h6 class="card-subtitle mb-2 text-muted">booked by <?php echo $reservation->login() ?></h6>
                <hr>
                <p class="card-text"><?php echo $reservation->description() ?></p>
                <hr>
                <a href="planning.php" class="card-link btn btn-primary">Back to planning</a>
            </div>
        </div>
    </div>
</main>
<!-- Main HTML content stop there -->

<?php
include 'shared/footer.php';
