<?php
namespace Studievolg\Model;

abstract class DB{
	
	protected static $_conn;

	/**
	* Construct the object, accepts an array or an object as param
	* @var $data object/array auto fills the object
	*/
	public function __construct($data = null){
		if(is_object($data)){
			$data = get_object_vars($data);	
		}
		if(is_array($data)) {
    		foreach($data as $y => $x){
    			if(property_exists($this, "_".$y)){
                    $var = "_" . $y;
    				$this->$var = $x;
                }
    		}  
		}
        
	}	

	public function connection()	{

		if(!$_conn instanceof \mysqli){
			$settings 	= include(ROOT . '/database.php');

			$host 		= $settings['host'];
			$dbname 	= $settings['name'];
			$username 	= $settings['user'];
			$password 	= $settings['pass'];

			static::$_conn = new \mysqli($host, $username, $password, $dbname);
		}
		return static::$_conn;
	}

}