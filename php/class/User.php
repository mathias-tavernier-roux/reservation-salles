<?php



class User
{
    protected $_id;
    protected $_login;
    protected $_password;

    // Object construction (hydrate with data)
    public function __construct(array $userData)
    {
        $this->hydrate($userData);
    }

    public function hydrate(array $userData)
    {
        foreach ($userData as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Setters
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        } else {
            throw new Exception('User Id: positive integer expected.');
        }
    }

    public function setLogin($login)
    {
        if (is_string($login)) {
            $this->_login = $login;
        } else {
            throw new Exception('User Login: string expected.');
        }
    }

    public function setPassword($password)
    {
        if (is_string($password)) {
            if (strlen($password) > 0) {
                if (substr($password, 0, 7) == '$2y$10$') { // Password already encrypted coming from db
                    $this->_password = $password;
                } else {
                    $this->_password = password_hash($password, PASSWORD_BCRYPT);
                }
            } else {
                throw new Exception('User password: more than 0 char expected.');
            }
        } else {
            throw new Exception('User password: string expected.');
        }
    }

    // Getters
    public function id()
    {
        return $this->_id;
    }

    public function login()
    {
        return $this->_login;
    }

    public function password()
    {
        return $this->_password;
    }


    //Specific methods
    public function checkPasswords($passwordConf)
    {
        // Return true if encrypted password and clear password are equal
        if (password_verify($passwordConf, $this->_password)) {
            return true;
        } else {
            return false;
        }
    }
}
