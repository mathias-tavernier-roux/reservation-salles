<?php
class UsersManager
{
    protected $_db;

    const CONNEXION_FORBIDEN = FALSE;
    const CONNEXION_GRANTED = TRUE;

    public function __construct($db)
    {
        // link to db expected
        $this->_db = $db;
    }

    // CRU(D)

    //Create user in db
    public function add(User $user)
    {
        $q = $this->_db->prepare("INSERT INTO `utilisateurs`(`login`, `password`) VALUES(:login,:password) ;");
        $q->execute([':login' => $user->login(), ':password' => $user->password()]);
        if (!$q) {
            throw new Exception('SQL Error: ' . $this->_db->errorInfo()[2]);
        }
    }

    //Get user in db and create an return an new user object instance of User class
    public function get($info)
    {
        if (is_string($info)) {
            $q = $this->_db->query("SELECT * FROM `utilisateurs` WHERE `login`='$info';");
        } elseif (is_int($info)) {
            $q = $this->_db->query("SELECT * FROM `utilisateurs` WHERE `id`=$info;");
        } else {
            throw new Exception('Users manager: id (int) or login (string) expected.');
        }
        if (!$q) {
            throw new Exception('SQL Error: ' . $this->_db->errorInfo()[2]);
        }
        $userData = $q->fetch(PDO::FETCH_ASSOC);
        return new User($userData);
    }

    // Update login and password
    public function update(User $user)
    {
        $query = 'UPDATE `utilisateurs` SET `login`=\'' . $user->login() . '\', `password`=\'' . $user->password() . '\' WHERE `id`=' . $user->id();
        $q = $this->_db->exec($query);
        if (!$q) {
            throw new Exception('SQL Error: ' . $this->_db->errorInfo()[2]);
        }
    }

    /** Check login and password, return true if granted false if forbiden */
    public function checkConnexion($login, $password)
    {
        $q = $this->_db->query("SELECT * FROM utilisateurs WHERE `login`='$login'");
        $userData = $q->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $userData['password'])) {
            return self::CONNEXION_GRANTED;
        } else {
            return self::CONNEXION_FORBIDEN;
        }
    }
}
