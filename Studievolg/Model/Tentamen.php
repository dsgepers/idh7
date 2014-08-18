<?php
namespace Studievolg\Model;

/**
 * Tentamen Entity 
 * 
 * @class Tentamen
 * @package Model
 * @author 23IDH7B1 
 * @version 1.0
 */
class Tentamen extends DB{
    
    // Class variables
    protected $_code;
    protected $_vak;
    protected $_periode;
    protected $_aantalStudenten;
    protected $_computerlokaal;
    protected $_surveillant;
    protected $_gebruikerID;
    
    /**
     * Find the Tentamen by code
     * 
     * @param String $code
     * @return Tentamen
     */
    public static function find($code){
        $conn = static::connection();
		
        $sql = "SELECT *"
            . " FROM Tentamen"
            . " WHERE code = '" . $conn->real_escape_string($code) . "'"
            . " LIMIT 1";
		$result = $conn->query($sql);
        
		while($obj = $result->fetch_object()){
			return new Tentamen($obj);
		}    
    }
    
    /**
     * Find all the Tentamens
     * 
     * @return Tentamen[]
     */
    public static function findAll(){
        $conn = static::connection();
        
        $sql = "SELECT *"
            . " FROM Tentamen";
        
        // Perform query
        $result = $conn->query($sql);
        
        $tentamen = array();
        while($obj = $result->fetch_object()){
            $tentamen[] = new Tentamen($obj);
        }
        
        return $tentamen;
    }
    
    /**
     * Save a Tentamen object to the database
     * 
     * @return Integer
     */
    public function save(){
        $conn = static::connection();
        $sql = "INSERT INTO Tentamen (code, vak, periode, aantalStudenten, computerlokaal, surveillant, gebruikerID)"
            . " VALUES ('" . $conn->real_escape_string($this->_code) . "', "
            . "'" . $conn->real_escape_string($this->_vak) . "', "
            . "'" . $conn->real_escape_string($this->_periode) . "', "
            . $conn->real_escape_string($this->_aantalStudenten) . ", "
            . $conn->real_escape_string($this->_computerlokaal) . ", "
            . $conn->real_escape_string($this->_surveillant) . ", "
            . $conn->real_escape_string($_SESSION['user']->getID()) . ")";
        
        // Perform query    
        $result = $conn->query($sql);

        // Return the number of affected rows
        return $conn->affected_rows;
    }
    
    /**
     * Gets the value of code.
     * 
     * @return String
     */
    public function getCode(){
        return $this->_code;
    }
    
    /**
     * Sets the value of code.
     * 
     * @param String $code
     * @return self
     */
    public function setCode($code){
        $this->_code = $code;
        return $this;
    }
    
    /**
     * Gets the value of vak.
     * 
     * @return String
     */
    public function getVak(){
        return $this->_vak;
    }
    
    /**
     * Sets the value of vak.
     * 
     * @param String $code
     * @return self
     */
    public function setVak($vak){
        $this->_vak = $vak;
        return $this;
    }
    
    /**
     * Gets the value of periode.
     * 
     * @return String
     */
    public function getPeriode(){
        return $this->_periode;
    }
    
    /**
     * Sets the value of periode.
     * 
     * @param String $periode
     * @return self
     */
    public function setPeriode($periode){
        $this->_periode = $periode;
        return $this;
    }
    
    /**
     * Gets the value of aantalStudenten.
     * 
     * @return Integer
     */
    public function getAantalStudenten(){
        return $this->_aantalStudenten;
    }
    
    /**
     * Sets the value of code.
     * 
     * @param Integer $code
     * @return self
     */
    public function setAantalStudenten($aantalStudenten){
        $this->_aantalStudenten = $aantalStudenten;
        return $this;
    }
    
    /**
     * Gets the value of computerlokaal.
     * 
     * @return Integer
     */
    public function getComputerlokaal(){
        return $this->_computerlokaal;
    }
    
    /**
     * Sets the value of computerlokaal.
     * 
     * @param Integer $computerlokaal
     * @return self
     */
    public function setComputerlokaal($computerlokaal){
        $this->_computerlokaal = $computerlokaal;
        return $this;
    }
    
    /**
     * Gets the value of surveillant.
     * 
     * @return Integer
     */
    public function getSurveillant(){
        return $this->_surveillant;
    }
    
    /**
     * Sets the value of surveillant.
     * 
     * @param Integer $surveillant
     * @return self
     */
    public function setSurveillant($surveillant){
        $this->_surveillant = $surveillant;
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