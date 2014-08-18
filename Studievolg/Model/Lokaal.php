<?php
namespace Studievolg\Model;

/**
 * Lokaal Entity 
 * 
 * @class Lokaal
 * @package Model
 * @author 23IDH7B1 
 * @version 1.0
 */
class Lokaal extends DB{

    // Class variables
    protected $_code;
    protected $_aantalPlaatsen;
    protected $_computerlokaal;
    
    /**
     * Find the Lokaal by code
     * 
     * @param String $code
     * @return Lokaal
     */
    public function find($code){
        $conn = static::connection();
		$sql = "SELECT *"
            . " FROM Lokaal"
            . " WHERE coce = '" . $conn->real_escape_string($id) . "'"
            . " LIMIT 1";

		$result = $conn->query($sql);
        
		while($obj = $result->fetch_object()){
			return new Lokaal($obj);
		} 
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
     * Gets the value of aantalStudenten.
     *
     * @return Integer
     */
    public function getAantalStudenten(){
        return $this->_aantalStudenten;    
    }
    
    /**
     * Sets the value of aantalStudenten.
     *
     * @param Integer $aantalStudenten 
     * @return self
     */
    public function setStudenten($aantalStudenten){
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
}
?>