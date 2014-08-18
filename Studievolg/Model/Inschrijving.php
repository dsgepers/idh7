<?php
namespace Studievolg\Model;

/**
 * Inschrijving Entity 
 * 
 * @class Inschrijving
 * @package Model
 * @author 23IDH7B1 
 * @version 1.0
 */
class Inschrijving extends DB{

    // Class variables
    protected $_planningID;
    protected $_gebruikerID;
    protected $_datumtijd;
    protected $_cijfer;
    protected $_beoordeling;
    protected $_aanwezig;
    
    /**
     * Find an inschrijving by it's planning and gebruiker ID
     * @param Integer   $planningID
     * @param Integer   $gebruikerID
     * @return void
     */
    public static function find($planningID, $gebruikerID){
        $conn   = static::connection();
        $sql    = "SELECT *"
                . " FROM Inschrijving"
                . " WHERE planningID = " . $conn->real_escape_string($planningID)
                . " AND gebruikerID = " . $conn->real_escape_string($gebruikerID)
                . " LIMIT 1";
        
        // Perform query
        $result = $conn->query($sql);
        
        // Fetch the assocaitive array
        while ($obj = $result->fetch_object()){
            return new Inschrijving($obj);
        }
        
    }
    
    /**
     * Find inschrijvingen by it's planning ID
     * @param Integer $planningID
     * @return \Studievolg\Model\Inschrijving
     */
    public static function findByPlanningID($planningID){
        $conn   = static::connection();
        $sql    = "SELECT *"
                . " FROM Inschrijving"
                . " WHERE planningID = " . $conn->real_escape_string($planningID);
        
        // Perform the query
        $result = $conn->query($sql);

        // Fetch the associative array
        $inschrijvingen = array();
        while ($obj = $result->fetch_object()){
            $inschrijvingen[] = new Inschrijving($obj);
        }
        
        return $inschrijvingen;
    }
    
    /**
     * Update the the inschrijving
     * @return void
     */
    public function update(){
        $conn = static::connection();
        $sql = "UPDATE Inschrijving SET"
            . " cijfer = " . $conn->real_escape_string($this->_cijfer) . ", "
            . " beoordeling = " . $conn->real_escape_string($this->_beoordeling)
            . " WHERE planningID = " . $conn->real_escape_string($this->_planningID)
            . " AND gebruikerID = " . $conn->real_escape_string($this->_gebruikerID);
        
        // Perform the update
        $conn->query($sql);
        
        // Return the amount of affected rows
        return $conn->affected_rows;
    }
    
    /**
     * Gets the value of planningID.
     *
     * @return Integer
     */
    public function getPlanningID(){
        return $this->_planningID;    
    }
    
    /**
     * Sets the value of planningID.
     *
     * @param Integer $planningID 
     * @return self
     */
    public function setPlanningID($planningID){
        $this->_planningID = $planningID;
        return $this;
    }
    
    /**
     * Gets the value of gebruikerID.
     *
     * @return Integer
     */
    public function getGebruikerID(){
        return $this->_gebruikerID;    
    }
    
    /**
     * Sets the value of gebruikerID.
     *
     * @param Integer $gebruikerID 
     * @return self
     */
    public function setGebruikerID($gebruikerID){
        $this->_gebruikerID = $gebruikerID;
        return $this;
    }
    
    /**
     * Gets the value of datumtijd.
     *
     * @return String
     */
    public function getDatumtijd(){
        return $this->_datumtijd;    
    }
    
    /**
     * Sets the value of datumtijd.
     *
     * @param String $id 
     * @return self
     */
    public function setDatumtijd($datumtijd){
        $this->_datumtijd = $datumtijd;
        return $this;
    }
    
    /**
     * Gets the value of cijfer.
     *
     * @return Double
     */
    public function getCijfer(){
        return $this->_cijfer;    
    }
    
    /**
     * Sets the value of cijfer.
     *
     * @param Double $id 
     * @return self
     */
    public function setCijfer($cijfer){
        $this->_cijfer = $cijfer;
        return $this;
    }
    
    /**
     * Gets the value of beoordeling.
     *
     * @return Integer
     */
    public function getBeoordeling(){
        return $this->_beoordeling;    
    }
    
    /**
     * Sets the value of beoordeling.
     *
     * @param Integer $beoordeling
     * @return self
     */
    public function setBeoordeling($beoordeling){
        $this->_beoordeling = $beoordeling;
        return $this;
    }
    
    /**
     * Gets the value of aanwezig.
     *
     * @return Integer
     */
    public function getAanwezig(){
        return $this->_aanwezig;    
    }
    
    /**
     * Sets the value of aanwezig.
     *
     * @param Integer $aanwezig
     * @return self
     */
    public function setAanwezig($aanwezig){
        $this->_aanwezig = $aanwezig;
        return $this;
    }
    
    /**
     * Gets the Planning object
     * 
     * @return Planning
     */
    public function getPlanning(){
        $planning = Planning::find($this->_planningID);
        return $planning;
    } 
    
    /**
     * Gets the Gebruiker object
     * 
     * @return Gebruiker
     */
    public function getGebruiker(){
        $gebruiker = Gebruiker::find($this->_gebruikerID);
        return $gebruiker;
    }
}
?>