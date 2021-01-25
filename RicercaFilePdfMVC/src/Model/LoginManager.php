<?php 
declare(strict_types=1);

namespace SimpleMVC\Model;
use SimpleMVC\Model\Session;
use PDO;


class LoginManager
{
	protected $con;
	protected $session;

	public function __construct(PDO $con, Session $session)
	{
		$this->con = $con;
        $this->session = $session;
	}

    public function loginVerify(string $email, string $password) : bool 
    {
        
        $statement = $this->con->prepare('SELECT email, password FROM users WHERE email=:email');
        $statement->execute([ ':email' => $email ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if(empty($result)) {
            return false;
        }
        
        return password_verify($password, $result['password']);
        

    }

}
        
		

    		



