<?php 
declare(strict_types=1);

namespace SimpleMVC\Model;
use SimpleMVC\Model\Session;
use PDO;
use Smalot\PdfParser\Parser;

class UploadManager
{
    
	protected $con;
    protected $parser; 
    protected $session; 

	public function __construct(PDO $con, Parser $parser, Session $session)
	{
		$this->con = $con;
        $this->parser = $parser;
        //accesso restrito session
		$this->session = $session;
		$this->session->init();
		if($this->session->getStatus() === 1 || empty($this->session->get('email')))
     		exit('Access Denied');

	}

    public function uploadFile($fileName,$fileOrigin, $fileStore)
    {


       
        if (isset($_REQUEST['upload'])){

			if(isset($_FILES['fileToUpload'])){
       
				if ($_FILES['fileToUpload']['type'] === "application/pdf") {

					if (!file_exists($fileStore)) {

					move_uploaded_file($fileOrigin, $fileStore); 

						if($_FILES['fileToUpload']['error'] == 0) {
							print "File caricato con successo!";
						
							//estrazione contenuto com parser
							$path= 'pdf'; 
							//$fnamePath= utf8_decode($_FILES["fileToUpload"]["name"]);				
							$fnamePath= $fileName;				
			
							$pdf = $this->parser->parseFile("$path/$fnamePath");  
							$content = $pdf->getText();//prendo o texto forma de stringa	
							
							

							//inserzione db 
							$sth = $this->con->prepare("INSERT INTO files (filename, content) VALUES (:filename, :content)");
							$sth->bindParam(':filename', $fileName);
							$sth->bindParam(':content',$content); 
							$sth->execute();
						
						}
					}else
					print "Questo file già esiste nella cartella!!";	

				}else
				print "ERRORE: ".$_FILES['fileToUpload']['name']." non è di estensione PDF o è inesistente!";
				
			}else
			print("Seleziona un file!!");
        
		}
			

					
	}




	public function logout()
  	{
		$this->session->close();
		header('location: /');
  	}
        
    


}
