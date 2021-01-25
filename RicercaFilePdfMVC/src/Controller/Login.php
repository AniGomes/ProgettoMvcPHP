<?php
declare(strict_types=1);

namespace SimpleMVC\Controller;
use SimpleMVC\Model\LoginManager;
use SimpleMVC\Model\Session;
use League\Plates\Engine;
use Psr\Http\Message\ServerRequestInterface;

class Login implements ControllerInterface
{
    protected $login;
    protected $plates;
    protected $session;

    public function __construct(LoginManager $login, Engine $plates, Session $session)
    {
        $this->login = $login;
		$this->plates = $plates;
        $this->session = $session;
        $this->session->init();
    }

    public function execute(ServerRequestInterface $request)
    {

        $postData = $request->getParsedBody();

        // memorizo utente na session 
        $this->session->add('email', $postData['email']);//conflito UnitTest
        //var_dump($this->session->getAll());
       

        if($request->getMethod() === 'GET') { 
            $this->renderLoginForm();
            return;
        }

        
        $email = $postData['email'];
        $password = $postData['password'];        

        if(true === $this->login->loginVerify($email, $password)) {//view
            header("Location: /upload");
        }

        if(false === $this->login->loginVerify($email, $password)) {
            $this->renderLoginForm('Credenziali Invalidi..Riprova!');
            
        } 
       		
	
    }

    private function renderLoginForm(string $error = ''): void
    {
        echo $this->plates->render('login', [
            'error' => $error
        ]);
    }
    


}
