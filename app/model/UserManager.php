<?php

namespace App\Model;

use Nette;
use Nette\Security as NS;
use Nette\Security\Passwords;

class UserManager implements NS\IAuthenticator
{
    use Nette\SmartObject;

    /**
     * @var Nette\Database\Context
     */
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    function authenticate(array $credentials)
    {
        list($email, $password) = $credentials;
        $row = $this->database->table('users')
            ->where('email', $email)->fetch();

        if (!$row) {
            throw new NS\AuthenticationException('Uživatel nebyl nalezen.');
        }

        if (!NS\Passwords::verify($password, $row->password)) {
            throw new NS\AuthenticationException('Chybné heslo.');
        }

        return new NS\Identity($row->id, $row->role, ['nickname' => $row->nickname]);
    }

    public function getUser($userId)
    {
        return $this->database->table('users')->get($userId); //když nedostane z databáze, vrací NULL
    }

    public function getUsers()
    {
        return $this->database->table('users');
    }

    public function saveUser($values)
    {
        if(isset($values->password2)){
            unset($values->password2);
            $values->password = Passwords::hash($values->password);
        }
        
        if($values->id){
            $user = $this->database->table('users')->get($values->id);
            $user->update($values);
        }else{
            $values->role = "guest"; // iniciální role po registraci
            $user = $this->database->table('users')->insert($values);           
        }
        return $user;
    }
}