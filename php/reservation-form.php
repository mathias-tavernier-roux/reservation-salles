<?php
/*
Un formulaire de réservation de salle (reservation-form.php)
Ce formulaire contient les informations suivantes : titre, description, date de
début, date de fin.
Votre site doit avoir une structure html correcte et un design soigné à l’aide
de css. Vous avez la liberté de choisir un thème à l’image de votre groupe.
*/


$page_title =  'Reservation';
$msgAlert = [];

require 'shared/initialize.php';
redirect($_SESSION['connected']);

include 'shared/head.php';
include 'shared/header.php';


// Reservation form handling
if (isset($_POST['reservartion-form'])) {
    $reservationData = ['id_utilisateur' => $_SESSION['user']]; //Add user id in array needed for reservation construction
    foreach ($_POST as $key => $value) {
        $reservationData[$key] = $value;
    }
    try {
        $reservation = new Reservation($reservationData);
        $reservation->checkDateConsistency(); //Check date anteriority
    } catch (Exception $e) {
        $msgAlert = [$e->getMessage(), 'danger'];
        unset($reservation);
    }

    if (isset($reservation)) { // If a reservation has been successfully created, has to be added in DB
        try {
            $reservartionsManager->add($reservation);
            $msgAlert = ['Reservation successfully added, want to <a href="planning.php"> see the planning</a> or book an other room ?', 'success'];
        } catch (Exception $e) {
            $msgAlert = [$e->getMessage(), 'danger'];
        }
    }
}


?>


<!-- Main HTML content goes here -->
<main class="container-fluid bg-dark text-light ">
    <div class="row d-flex justify-content-center ">

        <h1 class="my-3 col-12 text-center"><?php echo $page_title; ?></h1>

        <form method="POST" class="">
            <?php displayAlert($msgAlert); ?>
            <div class="form-group">
                <label for="titre">Title</label>
                <input id="titre" type="text" name="titre" class="form-control" placeholder="Event title" required>
            </div>
            <div class="form-group">
                <label for="debut">Start</label>
                <input id="debut" type="datetime-local" name="debut" class="form-control" placeholder="YYYY/MM/DD --:--" required>
            </div>
            <div class="form-group">
                <label for="fin">End</label>
                <input id="fin" type="datetime-local" name="fin" class="form-control" placeholder="YYYY/MM/DD --:--" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" placeholder="Event description" required></textarea>
            </div>
            <button type="submit" name="reservartion-form" class="btn btn-primary float-right">Submit</button>
        </form>
    </div>
</main>
<!-- Main HTML content stop there -->

<?php
include 'shared/footer.php';
