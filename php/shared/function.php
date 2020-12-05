<?php
function classLoader($class)
{
    // Used with spl_autoload_register() for require classes when needed
    require 'class/' . $class . '.php';
}

/** Display html msg alert styled with bootstrap
 * take array as parameter:
 *  - first parameter, match to message alert to display
 *  - second parameter, type of alert ('success','warning' ...)
 */
function displayAlert(array $msgAlert)
{

    if (!empty($msgAlert)) {
        echo '<div class="alert alert-' . $msgAlert[1] . '" role="alert">';
        echo $msgAlert[0];
        echo '</div>';
    }
}

/** Echo html table code for a week that start from date (DateTime) passed as argument
 *  Display events which are planned.
 */
function displayHtmlTable(DateTime $inpuDate, ReservationsManager $reservationsManager)
{
    $date = clone $inpuDate;

    // Construction array for days
    $D = ['']; // First element of array is en empty string, used for first column table construction
    $D[] = clone $date;
    for ($i = 1; $i <= 6; $i++) {
        $D[] = clone $date->add(new DateInterval('P1D'));
    }

    // Get reservation list for week 
    $reservationsList = $reservationsManager->getByDate($D[1], $D[7]);

    // Construction array for hours
    for ($i = 8; $i <= 19; $i++) {
        $hour = $i . ':00';
        if (strlen($hour) == 4) {
            $hour = '0' . $hour;
        }
        $H[] = $hour;
    }


    // Construction HTML code
    echo '<table class="table table-striped table-dark table-sm table-bordered m"><thead><tr>';
    foreach ($D as $day) {
        if (empty($day)) {
            echo '<th scope="col"></th>';
        } else {
            echo '<th scope="col" class="text-center">' . $day->format('D j') . '</th>';
        }
    }
    echo '</tr></thead><tbody>';
    foreach ($H as $hour) {
        echo '<tr>';
        foreach ($D as $day) {
            if (empty($day)) {
                echo "<th scope=\"row\">$hour</th>";
            } else {
                // Create a variable wich contain a string matching to the current cell date time
                $currentDateTime = $day->format('Y/m/d') . ' ' . $hour;

                $html = '';

                // Check for each reservation of the current display week has to be in the current cell date time
                foreach ($reservationsList as $reservation) {
                    if (isDateInBetween($currentDateTime, [$reservation->debut(), $reservation->fin()])) {
                        $html .= '<a class="text-decoration-none" href=reservation.php?id=' . $reservation->id() . ' >';
                        $html .= '<div class="alert alert-primary m-0 p-1 reservation" role="alert">' . $reservation->titre() . '<br />';
                        $html .= '<small class="text-muted">booked by <span class="badge badge-primary">' . $reservation->login() . '</span></small></div>';
                        $html .= '</a>';
                    };
                }
                if (empty($html)) {
                    echo "<td>";
                } else {
                    echo "<td class=\"bg-transparent text-center\">$html";
                }

                echo "</td>";
            }
        }
        echo '</tr>';
    }

    echo '</tbody></table>';
}


/** Redirection if user is not connected */
function redirect(bool $connected)
{
    if (!$connected) {
        header('Location: ../login.php');
    }
}

/** Check if a date is in between a date interval */
function isDateInBetween($date, array $interval)
{
    $date = Reservation::dateFromStringToDateTimeObject($date);
    $intStartDate = Reservation::dateFromStringToDateTimeObject($interval[0]);
    $intEndDate = Reservation::dateFromStringToDateTimeObject($interval[1]);

    if (($intStartDate <= $date) && ($date < $intEndDate)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/** Generate automotically html code <li> tag for boostrap,
 * depending of restriction visibility and user identified
 */
function displayBoostrapLiTagMenu(array $pages, string $active_page)
{

    foreach ($pages as $page => $info) {
        // Check restriction and if user is connected, return an authorisation 
        $display = ($info['restriction'] == "no")
            || ($_SESSION['connected'] && $info['restriction'] == "connected")
            || (!$_SESSION['connected'] && $info['restriction'] == "disconnected") ? TRUE : FALSE;


        if ($display) {
            // Return a <li> tage with appropriate name, filename, and classes dependend if it's the current page
            $htmlcode = '<li class="nav-item ';
            if ($active_page == $info['name']) {
                $htmlcode .= ' active';
            };
            $htmlcode .= '">';
            $htmlcode .= '<a class="nav-link text-center px-4" href="' . $page . '.php">' . $info['name'] . ' ';
            if ($active_page == $info['name']) {
                $htmlcode .= '<span class="sr-only">(current)</span>';
            };
            $htmlcode .= '</a></li>';

            echo $htmlcode;
        }
    }
}

/**  Display a log out button if user connected or a log in button if disconnected */
function displayLogInOutButton($connected)
{

    if ($connected) {
        // Form is handle in initialize.php because of redirection with header()
        $html = '<form method="POST" class="d-flex">';
        $html .=    '<a class="btn btn-secondary" href="session_destroy.php">';
        $html .=        '<img class="icon" src="../img/account-logout.svg" alt="icon log-out">';
        $html .=    '</a>';
        $html .= '</form>';
    } else {
        $html  = '<div class="d-flex justify-content-center">';
        $html .=    '<a class="btn btn-primary" href="connexion.php" role="button">';
        $html .=        '<img class="icon" src="../img/account-login.svg" alt="icon log-in">';
        $html .=    '</a>';
        $html .= '</div>';
    }
    echo $html;
}
