<?php
namespace Studievolg\Model;

/**
 * Rol Entity 
 * 
 * @class Rol
 * @package Model
 * @author 23IDH7B1 
 * @version 1.0
 */
class Rol extends DB{
    
    // Class variables
    protected $_ID;
    protected $_naam;   
    
    /**
     * Find the Rol by ID
     * 
     * @param Integer $id
     * @return Rol
     */
    public function find($id){
        $conn = static::connection();
		$sql = "SELECT *"
            . " FROM Rol"
            . " WHERE ID = " . $conn->real_escape_string($id)
            . " LIMIT 1";

		$result = $conn->query($sql);
        
		while($obj = $result->fetch_object()){
			return new Rol($obj);
		} 
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
     * Gets the value of naam.
     *
     * @return Integer
     */
    public function getNaam(){
        return $this->_naam;
    }
    
    /**
     * Sets the value of naam.
     *
     * @param String $naam
     * @return self
     */
    public function setNaam($naam){
        $this->_naam = $naam;
        return $this;
    }
}
?>