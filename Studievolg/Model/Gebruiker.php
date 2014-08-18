<?php 
namespace Studievolg\Model;

/**
 * Gebruiker Entity 
 * 
 * @class Gebruiker
 * @package Model
 * @author 23IDH7B1 
 * @version 1.0
 */
class Gebruiker extends DB{

    // Class variables
	protected $_ID;
	protected $_voornaam;
	protected $_tussenvoegsel;
	protected $_achternaam;
	protected $_geslacht;
	protected $_geboortedatum;
	protected $_gebruikersnaam;
	protected $_wachtwoord;
	protected $_rolID;
	
    /**
     * Find the Gebruiker by ID
     * 
     * @param Integer $id
     * @return Gebruiker
     */
    public static function find($id) {
        $conn = static::connection();
	$sql = "SELECT *"
            . " FROM Gebruiker"
            . " WHERE ID = " . $conn->real_escape_string($id)
            . " LIMIT 1";

	$result = $conn->query($sql);
        
        while($obj = $result->fetch_object()){
            return new Gebruiker($obj);
        }
    }
    
    /**
     * Find the Gebruiker by username
     * 
     * @param String $username
     * @return Gebruiker
     */
    public static function findByUsername($username) {
	$conn = static::connection();
	$sql = "SELECT *"
            . " FROM Gebruiker"
            . " WHERE gebruikersnaam = '" . $conn->real_escape_string($username) . "'"
            . " LIMIT 1";

	$result = $conn->query($sql);
        
	while($obj = $result->fetch_object()){
            return new Gebruiker($obj);
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
     * @param Integer $ID
     * @return self
     */
    public function setID($ID){
        $this->_ID = $ID;
        return $this;
    }

    /**
     * Gets the value of voornaam.
     *
     * @return String
     */
    public function getVoornaam(){
        return $this->_voornaam;
    }

    /**
     * Sets the value of voornaam.
     *
     * @param String $voornaam
     * @return self
     */
    public function setVoornaam($voornaam){
        $this->_voornaam = $voornaam;
        return $this;
    }

    /**
     * Gets the value of tussenvoegsel.
     *
     * @return String
     */
    public function getTussenvoegsel(){
        return $this->_tussenvoegsel;
    }

    /**
     * Sets the value of tussenvoegsel.
     *
     * @param String $tussenvoegsel
     * @return self
     */
    public function setTussenvoegsel($tussenvoegsel){
        $this->_tussenvoegsel = $tussenvoegsel;
        return $this;
    }

    /**
     * Gets the value of achternaam.
     *
     * @return String
     */
    public function getAchternaam(){
        return $this->_achternaam;
    }

    /**
     * Sets the value of achternaam.
     *
     * @param String $achternaam
     * @return self
     */
    public function setAchternaam($achternaam){
        $this->_achternaam = $achternaam;
        return $this;
    }

    /**
     * Gets the value of geslacht.
     *
     * @return String
     */
    public function getGeslacht(){
        return $this->_geslacht;
    }

    /**
     * Sets the value of geslacht.
     *
     * @param String $geslacht
     * @return self
     */
    public function setGeslacht($geslacht){
        $this->_geslacht = $geslacht;
        return $this;
    }

    /**
     * Gets the value of geboortedatum.
     *
     * @return String
     */
    public function getGeboortedatum(){
        return $this->_geboortedatum;
    }

    /**
     * Sets the value of geboortedatum.
     *
     * @param String $geboortedatum
     * @return self
     */
    public function setGeboortedatum($geboortedatum){
        $this->_geboortedatum = $geboortedatum;
        return $this;
    }

    /**
     * Gets the value of gebruikersnaam.
     *
     * @return String
     */
    public function getGebruikersnaam(){
        return $this->_gebruikersnaam;
    }

    /**
     * Sets the value of gebruikersnaam.
     *
     * @param String $gebruikersnaam
     * @return self
     */
    public function setGebruikersnaam($gebruikersnaam){
        $this->_gebruikersnaam = $gebruikersnaam;
        return $this;
    }

    /**
     * Gets the value of wachtwoord.
     *
     * @return String
     */
    public function getWachtwoord(){
        return $this->_wachtwoord;
    }

    /**
     * Sets the value of wachtwoord.
     *
     * @param String $wachtwoord
     * @return self
     */
    public function setWachtwoord($wachtwoord){
        $this->_wachtwoord = $wachtwoord;
        return $this;
    }

    /**
     * Gets the value of rolID.
     *
     * @return Integer
     */
    public function getRolID(){
        return $this->_rolID;
    }

    /**
     * Sets the value of rolID.
     *
     * @param Integer $rolID
     * @return self
     */
    public function setRolID($rolID){
        $this->_rolID = $rolID;
        return $this;
    }
    
    /**
     * Gets the Rol object
     * 
     * @return Rol
     */
    public function getRol(){
        $rol = Rol::find($this->_rolID);
        return $rol;
    }
}