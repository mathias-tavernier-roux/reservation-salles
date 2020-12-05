<?php

// Array $pages is used for generate automatically <li> tag for boostrape nav
$pages = [
    'planning' => ['name' => 'Voir Les Créneaux', 'restriction' => 'no'],
    'reservation-form' => ['name' => 'Reserver', 'restriction' => 'connected'],
];
?>

<header>
    <nav id="main_nav" class="navbar navbar-expand-md navbar-dark bg-dark fixed-bottom border-top">
        <a class=" navbar-brand" href="#">Room Manager : Salle Borely</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav container-fluid justify-content-end">
                <?php
                displayBoostrapLiTagMenu($pages, $page_title); // Display html code :li tag for each page
                ?>
                <li><a href="../index.php">Revenir Au Menu Principal</a></li>
            </ul>
        </div>
    </nav>
</header>

<body class="bg-dark">