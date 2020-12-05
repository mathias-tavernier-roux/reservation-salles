<?php
class Reservation
{
    protected $_id;
    protected $_titre;
    protected $_description;
    protected $_debut;
    protected $_fin;
    protected $_id_utilisateur;
    protected $_login;

    // Regular expression partern for Date & time
    const DATE = '20[0-9]{2}[\D][0-1]{1}[0-9]{1}[\D][0-3]{1}[0-9]{1}';
    const TIME = '[0-2]{1}[0-9]{1}[\D][0-5]{1}[0-9]{1}';

    // Object construction (hydrate with data)
    public function __construct(array $reservationData)
    {
        $this->hydrate($reservationData);
    }

    public function hydrate(array $reservationData)
    {
        foreach ($reservationData as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    //Setters 
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        } else {
            throw new Exception('Reservation id: positive integer expected.');
        }
    }

    public function setId_utilisateur($id_utilisateur)
    {
        $id_utilisateur = (int) $id_utilisateur;
        if ($id_utilisateur > 0) {
            $this->_id_utilisateur = $id_utilisateur;
        } else {
            throw new Exception('Reservation id_utilisateur: positive integer expected.');
        }
    }

    public function setDescription($description)
    {
        if (is_string($description)) {
            $this->_description = $description;
        } else {
            throw new Exception('Reservation description: string expected.');
        }
    }

    public function setTitre($titre)
    {
        if (is_string($titre)) {
            $this->_titre = $titre;
        } else {
            throw new Exception('Reservation titre: string expected.');
        }
    }

    public function setLogin($login)
    {
        if (is_string($login)) {
            $this->_login = $login;
        } else {
            throw new Exception('Reservation login: string expected.');
        }
    }

    public function setDebut($debut)
    {
        $regExp = '~^' . SELF::DATE . '[\s\D]' . SELF::TIME . '~';
        if (is_string($debut)) {
            if (preg_match($regExp, $debut)) {
                if (strlen($debut) == 16) {
                    $debut .= ':00';
                }
                $this->_debut = $this->formatDateForDb($debut);
            } else {
                throw new Exception('Reservation debut: pattern type YYYY/MM/DD HH:MM expected, ' . $debut);
            }
        } else {
            throw new Exception('Reservation debut: string expected.');
        }
    }

    public function setFin($fin)
    {
        $regExp = '~^' . SELF::DATE . '[\s\D]' . SELF::TIME . '~';
        if (is_string($fin)) {
            if (preg_match($regExp, $fin)) {
                if (strlen($fin) == 16) {
                    $fin .= ':00';
                }
                $this->_fin = $this->formatDateForDb($fin);
            } else {
                throw new Exception('Reservation fin: pattern type YYYY/MM/DD HH:MM expected, ' . $fin);
            }
        } else {
            throw new Exception('Reservation fin: string expected.');
        }
    }

    //Getters
    public function id()
    {
        return $this->_id;
    }

    public function id_utilisateur()
    {
        return $this->_id_utilisateur;
    }

    public function description()
    {
        return $this->_description;
    }

    public function titre()
    {
        return $this->_titre;
    }

    public function login()
    {
        return $this->_login;
    }

    public function debut()
    {
        return $this->_debut;
    }

    public function fin()
    {
        return $this->_fin;
    }

    //Special method
    public function checkDateConsistency()
    {
        $dateDebut = DateTime::createFromFormat('Y#m#d*H#i#s', $this->debut());
        $dateFin = DateTime::createFromFormat('Y#m#d*H#i#s', $this->fin());
        $dateNow = new Datetime('now');

        if (((int)$dateDebut->format('H') < 8) || ((int)$dateFin->format('H') < 8) || ((int)$dateDebut->format('H') > 19) | ((int)$dateFin->format('H') > 19)) {
            throw new Exception('Reservation date consitency: reservation allowed from 08 to 19.');
        }

        if (($dateDebut < $dateNow) || ($dateFin < $dateNow)) {
            throw new Exception('Reservation date consitency: room can\'t be booked in past.');
        }

        if (((int)$dateDebut->format('d') - (int)$dateFin->format('d')) > 1) {
            throw new Exception('Reservation date consitency: room can\'t be booked for more than one day.');
        }

        if (!($dateDebut < $dateFin)) {
            throw new Exception('Reservation date consitency: Start time must be anterior at end time. Minimum booked time is one complete hour. Hours are tronqued in booking reservation system (10:50 => 10:00)');
        } else {
            return TRUE;
        }
    }

    public static function formatDateForDb($date)
    {
        if (is_string($date)) {
            $date = DateTime::createFromFormat('Y#m#d*H#i#s', $date);
        }
        return $date->format('Y-m-d H:00:00');
    }

    /** Return a DateTime object is string formated as Y#m#d*H#i#s or Y#m#d*H#i is given */
    public static function dateFromStringToDateTimeObject($date)
    {
        if (is_string($date)) {
            if (strlen($date) == 16) {
                $date .= ':00';
            }
            $date = DateTime::createFromFormat('Y#m#d*H#i#s', $date);
        }
        return $date;
    }
}
