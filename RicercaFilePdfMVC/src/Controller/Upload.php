<?php
declare(strict_types=1);

namespace SimpleMVC\Controller;
use SimpleMVC\Model\UploadManager;
use SimpleMVC\Model\Session;
use League\Plates\Engine;
use Psr\Http\Message\ServerRequestInterface;


class Upload implements ControllerInterface
{
    
    protected $upload;
    protected $plates;
    protected $session; 


    public function __construct(UploadManager $upload, Engine $plates, Session $session)
    {
        $this->upload = $upload;
        $this->plates = $plates;
        //accesso restrito session
		$this->session = $session;
		$this->session->init();
		if($this->session->getStatus() === 1 || empty($this->session->get('email')))
        exit('Access Denied');
     
    }

    public function execute(ServerRequestInterface $request)
    {
        if($this->session->getStatus() === 1 || empty($this->session->get('email'))){
            $this->upload->logout();
        }     

        else{ 

            echo $this->plates->render('upload');

            $fileName= $request->getUploadedFiles(['clientFilename']);
           // $fileOrigin= $_FILES['fileToUpload']['tmp_name'];
            $fileOrigin= $request->getUploadedFiles(['uri']);

            $FileStore= "pdf/" . $fileName;

       
           $this->upload->uploadFile($fileName, $fileOrigin, $FileStore);   
           $files = $request->getUploadedFiles(['clientFilename']);
           echo $files;
            


        } 
        
        
	
    }
}
  


            

            