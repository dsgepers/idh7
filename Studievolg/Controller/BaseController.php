<?php 
namespace Studievolg\Controller;

/**
 * BaseController
 */
use \Studievolg\Model\Tentamen;
use \Studievolg\Model\Evaluatie;

class BaseController {

    /**
     * Authenticates and logs the user in.
     * @return void
     */
	public function authenticate(){

        //Check if user is already logged in
        session_start();
        if($_SESSION['user'] instanceof \Studievolg\Model\Gebruiker && $_SESSION['user']->getRol()->getNaam() == "Docent")
            header("Location: /docent/");

        //Init view script
		$view = new \Studievolg\Classes\View(ROOT . '/views/login.phtml');

        //Has login form been submitted via post request?
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Attempt to fetch user from the DB
            $user = \Studievolg\Model\Gebruiker::findByUsername($_POST['username']);
            //Check if a user was found, and verify the password
            if($user instanceof \Studievolg\Model\Gebruiker && $user->getWachtwoord() == md5($_POST['password'])){
                //Place user object in session, and redirect to dashboard
				
				if($user->getRol()->getNaam() == 'Docent'){
					$_SESSION['user'] = $user;
					$_SESSION['success'] = "U bent succesvol ingelogd!";
					header("Location: /docent/");
					die;
				}else{
					$_SESSION['error'] = "Alleen docenten mogen hier inloggen!";
					$_SESSION['user'] = null;
					header("Location: /");
					die;
				}
            }
            else
            {
                $_SESSION['error'] = "Er is een fout opgetreden bij het inloggen, probeer het nogmaals!";
            }
        }
        //Render view script
        $view->render();
	}

    /**
     * Clears the session and logs the user out.
     * @return void
     */
    public function logout(){
        session_start();
        $_SESSION['success'] = "U bent succesvol uitgelogd!";
        $_SESSION['user'] = null;
        header("Location: /");
    }

    public function evaluateExam($examCode) 
    {
        $this->checkAuth();
        $view = new \Studievolg\Classes\View(ROOT . '/views/Docent/evaluateexam.phtml');

        $existingEvaluation = Evaluatie::findByTentamenCodeAndUserId($examCode, $_SESSION['user']->getID());
        if($existingEvaluation instanceof Evaluatie) {
            $_SESSION['warning'] = "U heeft dit tentamen ({$examCode}) al geëvalueert.";
            header("Location: /docent/");
            return;
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $exam = Tentamen::find($examCode);
            if($exam instanceof Tentamen) {

                $storage = new \Upload\Storage\FileSystem(STORAGE_PATH);
                $file = new \Upload\File('evaluatie', $storage); 
                $filename = uniqid();
                $file->setName($filename);
                $validation = new \Upload\Validation\Size('5M');
                $validation->setMessage("Ongeldige bestandsgrootte.");

                $file->addValidations($validation); 
                try 
                {
                    if($file->getMimetype() != 'application/msword' && $file->getMimetype() != 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                    {
                        $_SESSION['error'] = "Het ge&uuml;ploade document moet een .doc of .docx bestand zijn.";
                    }
                    elseif(!is_numeric($_POST['cijfer'])) 
                    {
                        $_SESSION['error'] = "Het cijfer veld is verplicht en moet een cijfer zijn.";
                    } 
                    else 
                    {
                        $file->upload($filename);
                        $evaluation = new Evaluatie;
                        $evaluation->setDatumtijd(date('Y-m-d H:i:s'));
                        $evaluation->setCijfer($_POST['cijfer']);
                        $evaluation->setDocument($file->getNameWithExtension());
                        $evaluation->setTentamenCode($examCode);
                        $evaluation->setGebruikerID($_SESSION['user']->getID());
                        if($evaluation->save()) 
                        {
                            $this->sendFile($file, $evaluation);
                            $_SESSION['success'] = "Uw evaluatie voor {$examCode} is opgeslagen!.";
                            header("Location: /docent/");
                            return;
                        } 
                        else 
                        {
                            $_SESSION['error'] = "Uw evaluatie voor {$examCode} is niet correct opgeslagen.";
                        }
                    }
                } 
                catch(\Exception $e) 
                {
                    foreach($file->getErrors() as $error)
                    $_SESSION['error'] .= "-" . $error . "<br/>";
                }
                
            }
        }
        $view->examCode = $examCode;
        $view->render();

    }
	
		
	protected function checkAuth()
	{	
		session_start();
		if(!$_SESSION['user'] instanceof \Studievolg\Model\Gebruiker || $_SESSION['user']->getRol()->getNaam() != "Docent") {
			$_SESSION['user'] = null;
            header("Location: /");
		}
	}

    protected function sendFile(\Upload\File $file, \Studievolg\Model\Evaluatie $evaluatie) 
    {
        $message = \Swift_Message::newInstance()
        ->setSubject('Evaluatie van ' . $evaluatie->getTentamen()->getCode())
        ->setFrom(array('dennis@schepe.rs' => 'Studievolg Cijferregistratie'))
        ->setTo(array('dennis@schepe.rs'))
        ->setBody("
            Evaluatie: \r\n
            -Tentamen: {$evaluatie->getTentamen()->getCode()}
            -Periode: {$evaluatie->getTentamen()->getPeriode()}
            -Evaluatie Cijfer: {$evaluatie->getCijfer()}/5\r\n
            Geëvalueert door: {$evaluatie->getGebruiker()->getVoornaam()} {$evaluatie->getGebruiker()->getTussenvoegsel()} {$evaluatie->getGebruiker()->getAchternaam()}")
        ->attach(\Swift_Attachment::fromPath(STORAGE_PATH . '/' . $file->getNameWithExtension()));

        $transport = \Swift_MailTransport::newInstance();
        $mailer = \Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }



}