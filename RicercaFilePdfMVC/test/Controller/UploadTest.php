<?php
declare(strict_types=1);

namespace SimpleMVC\Test\Controller;
use SimpleMVC\Model\UploadManager;
use League\Plates\Engine;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use SimpleMVC\Controller\Upload;
use SimpleMVC\Model\Session;
use SimpleMVC\Controller\ControllerInterface;

final class UploadTest extends TestCase
{
    public function setUp(): void
    {
        $this->plates = new Engine('src/View');
        $this->uploadManager = $this->createMock(UploadManager::class);
        $this->session = $this->createMock(Session::class);

        $this->upload = new Upload($this->uploadManager, $this->plates, $this->session);
        $this->request = $this->createMock(ServerRequestInterface::class);
    }

    public function testLoginIsIstanceOfControllerInterface()
    {
        $this->assertInstanceOf(ControllerInterface::class, $this->upload);
    }

    public function testExecuteRenderUploadView(): void
    {
        $this->expectOutputString($this->plates->render('upload'));
        $this->upload->execute($this->request);
    }

    

   
}
