<?php
/*
Une page permettant de voir le planning de la salle (planning.php) :
Sur cette page on voit le planning de la semaine avec l’ensemble des
réservations effectuées. Le planning se présente sous la forme d’un
tableau avec les jours de la semaine en cours. Dans ce tableau, il y a en
colonne les jours et les horaires en ligne. Sur chaque réservation, il est
écrit le nom de la personne ayant réservé la salle ainsi que le titre. Si un
utilisateur clique sur une réservation, il est amené sur une page dédiée.

Les réservations se font du lundi au vendredi et de 8h et 19h. Les créneaux
ont une durée fixe d’une heure.

*/

$page_title =  'Planning';
$msgAlert = [];

require 'shared/initialize.php';

include 'shared/head.php';
include 'shared/header.php';

// Get or define starting date for week calendar
if (!isset($_SESSION['dateFocus'])) {
    $dateFocus = new Datetime('now');
    $_SESSION['dateFocus'] = $dateFocus;
} else {
    $dateFocus = $_SESSION['dateFocus'];
}

// Reservation form handling
if (isset($_POST['previous-week'])) {
    $dateFocus->sub(new DateInterval('P7D'));
}
if (isset($_POST['previous-day'])) {
    $dateFocus->sub(new DateInterval('P1D'));
}
if (isset($_POST['next-day'])) {
    $dateFocus->add(new DateInterval('P1D'));
}
if (isset($_POST['next-week'])) {
    $dateFocus->add(new DateInterval('P7D'));
}

?>


<!-- Main HTML content goes here -->
<body class="bg-dark"
<main class="container-fluid bg-dark">
    <div class="row">
        <h1 class="rmy-1 bg-dark text-light col-12 text-center">
            <form method="POST">
                <button class="btn" name="previous-week" type="submit"><img src='../img/chevron-left.svg' alt='previous'><img src='../img/chevron-left.svg' alt='previous'></button>
                <button class="btn" name="previous-day" type="submit"><img src='../img/chevron-left.svg' alt='previous'></button>
                <?php echo $page_title; ?>
                <button class="btn" name="next-day" type="submit"> <img src='../img/chevron-right.svg' alt='next'> </button>
                <button class="btn" name="next-week" type="submit"> <img src='../img/chevron-right.svg' alt='next'><img src='../img/chevron-right.svg' alt='next'> </button>

            </form>
        </h1>
        <?php displayAlert($msgAlert); ?>
    </div>
    <div class="row overflow-auto">
        <?php displayHtmlTable($dateFocus, $reservartionsManager); ?>
    </div>

</main>
<!-- Main HTML content stop there -->

<?php
include 'shared/footer.php';
