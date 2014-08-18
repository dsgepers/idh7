<?php
namespace Studievolg\Model;

/**
 * Planning Entity 
 * 
 * @class Planning
 * @package Model
 * @author 23IDH7B1 
 * @version 1.0
 */
class Planning extends DB{

    // Class variables
    protected $_ID;
    protected $_datumtijd;
    protected $_tentamenCode;
    protected $_gebruikerID;
    protected $_lokaalCode;
    
    /**
     * Find the Planning by ID
     * 
     * @param Integer $id
     * @return Planning
     */
    public static function find($id){
        $conn = static::connection();
	$sql = "SELECT *"
            . " FROM Planning"
            . " WHERE ID = " . $conn->real_escape_string($id)
            . " LIMIT 1";

        // Perform query
	$result = $conn->query($sql);
        
        // Fetch the associative array
	while($obj = $result->fetch_object()){
            return new Planning($obj);
	}
    }
    
    /**
     * Find the planning by it's tentamen code
     * 
     * @param String    $tentamenCode
     * @return Mixed
     */
    public static function findByTentamenCode($tentamenCode){
        $conn = static::connection();
        $sql = "SELECT *"
            . " FROM Planning"
            . " WHERE tentamenCode = '" . $conn->real_escape_string($tentamenCode) . "'"
            . " LIMIT 2";
        
        // Perform query
        $result = $conn->query($sql);
        
        // Fetch the associative array
        $planning = array();
        while($obj = $result->fetch_object()){
            $planning[] = new Planning($obj);
        }
        
        return $planning;
    }

    /**
     * Gets the value of ID.
     *
     * @return Integer
     */
    public function getID(){
        return $this->_ID;    
    }
    
    /**
     * Sets the value of ID.
     *
     * @param Integer $id 
     * @return self
     */
    public function setID($id){
        $this->_ID = $id;
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
     * @param String $datumtijd 
     * @return self
     */
    public function setDatumtijd($datumtijd){
        $this->_datumtijd = $datumtijd;
        return $this;
    }
    
    /**
     * Gets the value of tentamenCode.
     *
     * @return String
     */
    public function getTentamenCode(){
        return $this->_tentamenCode;    
    }
    
    /**
     * Sets the value of tentamenCode.
     *
     * @param String $tentamenCode
     * @return self
     */
    public function setTentamenCode($tentamenCode){
        $this->_tentamenCode = $tentamenCode;
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
     * Gets the value of lokaalCode.
     *
     * @return String
     */
    public function getLokaalCode(){
        return $this->_lokaalCode;    
    }
    
    /**
     * Sets the value of lokaalCode.
     *
     * @param String $lokaalCode 
     * @return self
     */
    public function setLokaalCode($lokaalCode){
        $this->_lokaalCode = $lokaalCode;
        return $this;
    }
    
    /**
     * Gets the Tentamen object
     * 
     * @return Tentamen
     */
    public function getTentamen(){
        $tentamen = Tentamen::find($this->_tentamenCode);
        return $tentamen;    
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
    
    /**
     * Gets the Lokaal object
     * 
     * @return Lokaal
     */
    public function getLokaal(){
        $lokaal = Lokaal::find($this->_lokaalCode);
        return $lokaal;    
    }
    
}
?>