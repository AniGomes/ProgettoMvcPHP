<?php
declare(strict_types=1);

namespace SimpleMVC\Test\Controller;
use SimpleMVC\Model\LoginManager;
use SimpleMVC\Model\Session;
use League\Plates\Engine;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use SimpleMVC\Controller\Login;
use SimpleMVC\Controller\ControllerInterface;


final class LoginTest extends TestCase
{
    public function setUp(): void
    {
        //crio mock
        $this->plates = new Engine('src/View');
        $this->loginManager = $this->createMock(LoginManager::class);
        $this->session = $this->createMock(Session::class);

        $this->login = new Login($this->loginManager,$this->plates, $this->session);
        $this->request = $this->createMock(ServerRequestInterface::class);
      
    }

    public function testLoginIsIstanceOfControllerInterface()
    {
        $this->assertInstanceOf(ControllerInterface::class, $this->login);
    }


    public function testExecuteMethodIsGet()
    {
        $this->request
            ->method('getMethod')
            ->willReturn('GET');

        $this->expectOutputString($this->plates->render('login'));
        $this->login->execute($this->request);
    }

    
    // public function testLoginVerifyUnknownEmail()
    // {
    //     //digo q o metodo fetch retornara vuoto pq entra na segunda if do metodo verify significqa resultado ce ma vuotp pq email sbagliata
    //     $this->loginManager 
    //     ->method('loginVerify')
    //     ->willReturn(false);

    //     //$this->login->execute($this->request);
    //     //asset false pq aspetto emaile pwd diverse di quelle del db
    //    $this->assertFalse($this->login->loginVerify('anielle@gmail.com', '1234'));        
    // }

    // public function testExecuteInvalidCredentials()
    // {
    //     $this->request
    //         ->method('getMethod')
    //         ->willReturn('POST');

        // $this->request
        //     ->method('getParsedBody')
        //     ->willReturn([
        //         'email' => 'email', 
        //         'password' => 'password'
        //     ]);

    //     $this->loginManager
    //             ->method('loginVerify')
    //             ->willReturn(false);

    //     $this->expectOutputString($this->plates->render('login', [
    //         'error' => 'wrong email or password'
    //     ]));
    //     $this->login->execute($this->request);
    // } 

    

   
    
    

    // public function testVerifyUnknownEmail()
    // {
    //     //digo q o metodo fetch retornara vuoto pq entra na segunda if do metodo verify significqa resultado ce ma vuotp pq email sbagliata
    //      $this->result->method('fetch')
    //         ->willReturn([]);

    //     //asset false pq aspetto emaile pwd diverse di quelle del db
    //    $this->assertFalse($this->login->loginVerify('anielle@gmail.com', '1234'));        
    // }



    // public function testVerifyValidEmailInvalidPassword()
    // {
    //     $this->sth->method('fetch')
    //         ->willReturn([//fetch retorna array con la pwd giusta
    //             'password' => '$2y$10$h28.fQ/09rr.v68Jn7NKZuxeycXuuCxmKGXfezhQOnoU4PUH6n0Ri'
    //         ]);

    //     //aki faz assert false con la pwd sbagliata e email giusto
    //     $this->assertFalse($this->login->verify('validEmail', 'pwdFalse'));


        
    // }

    // public function testVerifyValidEmailAndPassword()
    // {
    //     $this->sth->method('fetch')
    //         ->willReturn([
    //             'password' => '$2y$10$h28.fQ/09rr.v68Jn7NKZuxeycXuuCxmKGXfezhQOnoU4PUH6n0Ri'
    //         ]);

        
    //     $this->assertTrue($this->login->verify('foo@bar.com', 'test'));

        
    // }
}
