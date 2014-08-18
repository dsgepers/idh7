<?php
namespace Studievolg\Controller\Docent;

class DocentController extends \Studievolg\Controller\BaseController {
    
    /**
     * Function to create new tentamen
     * @return void
     */
    public function createExam(){
        session_start(); 
		$this->checkAuth();
			
        $view = new \Studievolg\Classes\View (ROOT . "/views/Docent/createexam.phtml");
 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $errors = array();
			if(trim($_POST['vak']) == '')
				$errors[] = "Het veld 'Vak' is verplicht";
			if(trim($_POST['periode']) == '')
				$errors[] = "Het veld 'Periode' is verplicht";
			if(trim($_POST['aantal_studenten']) == '')
				$errors[] = "Het veld 'Aantal studenten' is verplicht";
			if(!is_numeric($_POST['aantal_studenten']))	
				$errors[] = "Het veld 'Aantal studenten' dient numeriek te zijn.";
				
            if (count($errors) > 0){
				$html = "<ul class='errors'>";
				foreach($errors as $err)
					$html .= "<li>{$err}</li>";
				$html .= "</ul>";
				$_SESSION['error'] = $html;
            }
            else {
                $exam = new \Studievolg\Model\Tentamen();
                $exam -> setCode($_POST['tentamencode']);
                $exam -> setVak ($_POST['vak']);
                $exam -> setPeriode ($_POST['periode']);
                $exam -> setAantalStudenten($_POST['aantal_studenten']);
                $exam -> setComputerlokaal($_POST['computerlokaal']=='Ja'?1:0);
                $exam -> setSurveillant($_POST['surveillant']=='Ja'?1:0);
                $result = $exam -> save();
                if ($result > 0){
                    $_SESSION['success'] = "Het tentamen is succesvol ingevoerd.";
					header("Location: /docent/");
					return;
                }
                else { 
                    $_SESSION['error'] ="Er is iets fout gegaan bij het opslaan."; 
                }   
            }   
			$view->input = $_POST;
        }
        $view->render();
    }
    
    /**
     * Function to show an overview of all exams
     * @return void
     */
    public function overviewExam(){
		session_start();
		$this->checkAuth();
			
        $view = new \Studievolg\Classes\View(ROOT . "/views/Docent/overviewexam.phtml");
        
        // Get all the exams currently in the database
        $allTentamens = \Studievolg\Model\Tentamen::findAll();
        
        // Loop through tentamens and get the status based on the planning
        $tentamens = array();
        foreach ($allTentamens as $tentamen){
            // Reset status to default
            $status = array(
                "code"      => 0,
                "desc"      => "Status niet bekend",
                "planning1" => "0000-00-00 00:00:00",
                "planning2" => "0000-00-00 00:00:00"
            );
            
            // Get all the rosters that belong to this exam
            $planningen = \Studievolg\Model\Planning::findByTentamenCode($tentamen->getCode());
            
            // Status: There are no rosters available so the exam is ready to be planned
            if (count($planningen) < 1){
                $status["code"] = 1;
                $status["desc"] = "Gereed voor inplannen";
            } else {
                // Parameters to check if the date is in the past and the attendance has 
                // been filled in
                $dateInThePast  = false;
                $attendance     = true;
                
                $today          = strtotime(date("Y-m-d"));
                
				if(array_key_exists(0, $planningen))
                $status["planning1"] = date("d-m-Y H:i:s", strtotime($planningen[0]->getDatumtijd()));
				if(array_key_exists(1,$planningen))
					$status["planning2"] = date("d-m-Y H:i:s", strtotime($planningen[1]->getDatumtijd()));
                
                // Loop thorough the rosters
                foreach($planningen as $planning){
                    $planningDate = date("Y-m-d", strtotime($planning->getDatumtijd()));
                    
                    if (strtotime($planningDate) < $today){
                        $dateInThePast = true;
                        
                        // Get all the inschrijvingen for this roster
                        $inschrijvingen = \Studievolg\Model\Inschrijving::findByPlanningID($planning->getID());
                        
                        // Loop through the inschrijvingen
                        foreach ($inschrijvingen as $inschrijving){
                            // Check the result and attendance
                            if ($inschrijving->getAanwezig() == null){
                                
                                // Set attendance on false
                                $attendance = false;
                            }
                        }                        
                    }
                }
                
                // Check the date in the past parameter
                if ($dateInThePast && !$attendance){
                    // Date is in the past and the attendance hasn't been filled in
                    $status["code"] = 2;
                    $status["desc"] = "Gereed om cijfers in te voeren";
                } else if ($dateInThePast && $attendance) {
                    // Date is in the past and the attendance has been filled in
                    $status["code"] = 4;
                    $status["desc"] = "Cijferoverzicht beschikbaar";
                } else {
                    $status["code"] = 3;
                    $status["desc"] = "Ingepland";
                }
            }
            
            // Add the tentamen to the array (view)
            $tentamens[] = array(
                "tentamen"  => $tentamen,
                "status"    => $status
            );
        }
        
        $view->tentamens = $tentamens;
        $view->render();
    }

    /**
     * Function to show the exam results
     * @param String    $tentamenCode
     * @return void
     */
    public function overviewExamResults($tentamenCode){
	session_start();
	$this->checkAuth();		
		
        $view 	 = new \Studievolg\Classes\View();     

        // Get the exam and set the data in the view
        $tentamen       = \Studievolg\Model\Tentamen::find($tentamenCode);
        $view->tentamen = $tentamen;
        
        // Get the rosters for the exam
        $planningen = \Studievolg\Model\Planning::findByTentamenCode($tentamenCode);

        // Get the inschrijvingen for the planningen and set them in the view
        $planning = array();
        foreach ($planningen as $cplanning){
            $inschrijvingen = \Studievolg\Model\Inschrijving::findByPlanningID($cplanning->getID());

            $planning[] = array(
                "planning"          => $cplanning,
                "inschrijvingen"    => $inschrijvingen
            );
        }

	$view->planning = $planning;
        $view->setView(ROOT . "/views/Docent/overviewexamresults.phtml");
        $view->render();
    }
    
    /**
     * Function to show / input the exam results
     * @param String    $tentamenCode
     * @return void
     */
    public function inputExamResults($tentamenCode){
		session_start();
		$this->checkAuth();		
		
        $view 	 = new \Studievolg\Classes\View();     

        // Get the exam and set the data in the view
        $tentamen       = \Studievolg\Model\Tentamen::find($tentamenCode);
        $view->tentamen = $tentamen;
        
        // Get the rosters for the exam
        $planningen = \Studievolg\Model\Planning::findByTentamenCode($tentamenCode);
        
        // Check if the form has been submitted for saving
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["inputexamresult"])){
            // Unset the button in $_POST
            unset($_POST["inputexamresult"]);

	    $success = 1;

            // Loop through the rosters
            foreach ($planningen as $value){
                $planningID = $value->getID();              

                // Check if the POST contains results for this planning
                if (isset($_POST['cijfer_' . $planningID]) && 
                    isset($_POST['beoordeling_' . $planningID])){
                    
                    // Get the array_keys and cijfers and beoordelingen
                    $gebruikers     = array_keys($_POST['cijfer_' . $planningID]);
                    $cijfers        = $_POST['cijfer_' . $planningID];
                    $beoordelingen  = $_POST['beoordeling_' . $planningID];
                    
                    // Loop through the gebruikers and update the inschrijving
                    foreach ($gebruikers as $value){
                        // Get the inschrijving
                        $inschrijving = \Studievolg\Model\Inschrijving::find($planningID, $value);
                        
                        // Check if the cijfer is numeric
                        if (is_numeric($cijfers[$value])){
                            $inschrijving->setCijfer($cijfers[$value]);
                        } else {
                            if(trim($cijfers[$value]) == ''){
                                $inschrijving->setCijfer('NULL');
                            } else {
                                $success = 0;
                            }
                        }
                        
                        if (empty($beoordelingen[$value]) || $beoordelingen[$value] == ""){
                            $inschrijving->setBeoordeling('NULL');
                        } else {
                            $inschrijving->setBeoordeling($beoordelingen[$value]);
                        }
                        
                        $inschrijving->update();
                    }
                    // End update of all inschrijvingen
                }

 
            }
			
            if ($success == 1){
                $_SESSION["success"] = "Alle cijfers zijn succesvol opgeslagen";
                header("Location: /");
                return;
            } else {
	           $_SESSION["warning"] = "Niet alle cijfers zijn opgeslagen";
            }
            // End loop through planningen
        } 

        // Get the inschrijvingen for the planningen and set them in the view
        $planning = array();
        foreach ($planningen as $cplanning){
            $inschrijvingen = \Studievolg\Model\Inschrijving::findByPlanningID($cplanning->getID());

            $planning[] = array(
                "planning"          => $cplanning,
                "inschrijvingen"    => $inschrijvingen
            );
        }

        $view->planning = $planning;
        $view->setView(ROOT . "/views/Docent/inputexamresult.phtml");
        $view->render();
    }

}