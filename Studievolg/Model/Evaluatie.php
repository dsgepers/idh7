<?php
namespace Studievolg\Model;

/**
 * Evaluatie Entity 
 * 
 * @class Evaluatie
 * @package Model
 * @author 23IDH7B1 
 * @version 1.0
 */
class Evaluatie extends DB{

    // Class variables
    protected $_ID;
    protected $_datumtijd;
    protected $_cijfer;
    protected $_document;
    protected $_tentamenCode;
    protected $_gebruikerID;
    
    /**
     * Find the Evaluatie by code
     * 
     * @param String $code
     * @return Evaluatie
     */
    public static function findByTentamenCodeAndUserId($code, $userId){
        $conn = static::connection();
        
        $sql = "SELECT *"
            . " FROM Evaluatie"
            . " WHERE tentamenCode = '" . $conn->real_escape_string($code) 
            . "' AND gebruikerID = " . $conn->real_escape_string($userId)
            . " LIMIT 1";
        $result = $conn->query($sql);
        
        while($obj = $result->fetch_object()){
            return new Evaluatie($obj);
        }    
    }

    /**
     * Find the Evaluatie by code
     * 
     * @param String $code
     * @return Evaluatie
     */
    public static function getByTentamenCode($code){
        $conn = static::connection();
        
        $sql = "SELECT *"
            . " FROM Evaluatie"
            . " WHERE tentamenCode = '{$conn->real_escape_string($code)}';";
        $result = $conn->query($sql);
        $returns = array();
        while($obj = $result->fetch_object()){
            $returns[] = new Evaluatie($obj);
        }    
        return $returns;
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
     * Gets the value of ID.
     *
     * @return String
     */
    public function getDatumtijd(){
        return $this->_datumtijd;    
    }
    
    /**
     * Sets the value of ID.
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
     * Gets the value of document.
     *
     * @return String
     */
    public function getDocument(){
        return $this->_document;    
    }
    
    /**
     * Sets the value of document.
     *
     * @param String $document
     * @return self
     */
    public function setDocument($document){
        $this->_document = $document;
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
     * Save a Evaluatie object to the database
     * 
     * @return Integer
     */
    public function save(){
        $conn = static::connection();
        $sql = "INSERT INTO Evaluatie (datumtijd, cijfer, document, tentamenCode, gebruikerID)"
            . " VALUES ('" . $conn->real_escape_string($this->_datumtijd) . "', "
            . "'" . $conn->real_escape_string($this->_cijfer) . "', "
            . "'" . $conn->real_escape_string($this->_document) . "', '"
            . $conn->real_escape_string($this->_tentamenCode) . "', "
            . $conn->real_escape_string($this->_gebruikerID) . ")";
        
        // Perform query    
        $result = $conn->query($sql);

        // Return the number of affected rows
        return $conn->affected_rows;
    }
}