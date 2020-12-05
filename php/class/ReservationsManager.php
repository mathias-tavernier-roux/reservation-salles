<?php
class ReservationsManager
{
    protected $_db;

    public function __construct($db)
    {
        // link to db expected
        $this->_db = $db;
    }

    // C(RUD)

    // Create reservation in db
    public function add(Reservation $reservation)
    {
        if (!$this->checkIfAvailable($reservation)) {
            throw new Exception('Reservation manager: Room is already booked. You can <a href="planning.php">check the planning here</a>.');
        }
        $query = 'INSERT INTO `reservations`(`titre`, `description`, `debut`, `fin`, `id_utilisateur`) ';
        $query .= "VALUES ('" . $reservation->titre() . "','" . $reservation->description() . "','" . $reservation->debut() . "','" . $reservation->fin() . "'," . $reservation->id_utilisateur() . ")";
        $q = $this->_db->exec($query);
        if (!$q) {
            throw new Exception('Reservation manager SQL Error: ' . $this->_db->errorInfo()[2]);
        }
    }

    // Get/read reservation in db
    public function get($id)
    {
        $id = (int) $id;
        $query = "SELECT `reservations`.`id`, `titre`, `description`, `debut`, `fin`,`id_utilisateur`,`login`  FROM `reservations` INNER JOIN `utilisateurs` ON reservations.id_utilisateur = utilisateurs.id WHERE `reservations`.`id` = $id";
        $q = $this->_db->query($query);
        $reservationData = $q->fetch(PDO::FETCH_ASSOC);
        return new Reservation($reservationData);
    }

    // Get en array of reservation which start between two date
    public function getByDate(DateTime $start, DateTime  $end)
    {
        $start = Reservation::formatDateForDb($start);
        $end = Reservation::formatDateForDb($end);
        $reservations = [];
        $query = "SELECT id FROM `reservations` WHERE '$start' <= `debut` AND `debut` <= '$end'";
        $q = $this->_db->query($query);
        $result = $q->fetchAll(PDO::FETCH_COLUMN);
        foreach ($result as $id) {
            $reservations[] = $this->get($id);
        }
        return $reservations;
    }

    //Special method
    public function checkIfAvailable(Reservation $reservation)
    {
        $querys = [];

        // Check stardate is not in an interval booked
        $querys[] = 'SELECT COUNT(*) FROM `reservations` WHERE `debut` < \'' . $reservation->debut() . '\' AND \'' . $reservation->debut() . '\' < `fin`';

        // Check enddate is not in an interval booked
        $querys[] = 'SELECT COUNT(*) FROM `reservations` WHERE `debut` < \'' . $reservation->fin() . '\' AND \'' . $reservation->fin() . '\' < `fin`';

        // Check if a reservation exist in requested book period
        $querys[] = 'SELECT COUNT(*) FROM `reservations` WHERE \'' . $reservation->debut() . '\' < `debut` AND `debut` < \'' . $reservation->fin() . '\'';

        // Check if a reservation exist in requested book period
        $querys[] = 'SELECT COUNT(*) FROM `reservations` WHERE \'' . $reservation->debut() . '\' < `fin` AND `fin` < \'' . $reservation->fin() . '\'';

        // Check if a reservation exist for exactly same period
        $querys[] = 'SELECT COUNT(*) FROM `reservations` WHERE `debut` = \'' . $reservation->debut() . '\' AND \'' . $reservation->fin() . '\' = `fin`';

        foreach ($querys as $query) {
            $q = $this->_db->query($query);
            $result = $q->fetch(PDO::FETCH_COLUMN);
            if ($result > 0) {
                return FALSE;
            }
            $q->closeCursor();
        }

        return TRUE;
    }
}
