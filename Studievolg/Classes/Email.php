<?php

namespace Studievolg\Classes;
/**
 * Email class
 *
 * @class Email
 * @author DDP4IA5
 */
Class Email{
	
	/**
	 * Class variables
	 */
	private $_to;
	private $_subject;
	private $_message;
	
	/**
	 * Constructor
	 */
	public function __construct(){
	
	}
	
	/**
	 * Send the email
	 *
	 * @return void
	 */
	public function send(){
		// Headers
		$headers = 'From: webmaster@schepe.rs' . PHP_EOL;
		
		// Send mail
		mail($this->_to, 
			 $this->_subject, 
			 $this->_message,
			 $headers);
	}
	
	/**
	 * Get to
	 *
	 * @return String
	 */
	public function getTo(){
		return $this->_to;
	}
	
	/**
	 * Get subject
	 *
	 * @return String
	 */
	public function getSubject(){
		return $this->_subject;
	}
	
	/**
	 * Get message
	 *
	 * @return String
	 */
	public function getMessage(){
		return $this->_message;
	}
	
	/**
	 * Set to 
	 * 
	 * @param String	$to
	 * @return void
	 */
	public function setTo($to){
		$this->_to = $to;
	}
	
	/**
	 * Set subject
	 * 
	 * @param String	$subject
	 * @return void
	 */
	public function setSubject($subject){
		$this->_subject = $subject;
	}
	
	/**
	 * Set message
	 * 
	 * @param String	$message
	 * @return void
	 */
	public function setMessage($message){
		$this->_message = $message;
	}
}