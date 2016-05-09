<?php
/**
 * @author Oliver Blum <blumanski@gmail.com>
 * @date 2016-01-02
 * 
 * Regarding validation, I try to get the validation as close as possible to the action
 * It is better that way as you look at it and you know exactley what validation is in place
 * and nothing can happen inbetwen.
 *  
 *
 * Menu Model database
 */

Namespace Bang\Modules\Dashboard\Models;

Use \Bang\PdoWrapper, PDO, \Bang\Helper, Bang\Modules\Dashboard\Models\Mail;

class Db extends \Bang\SuperModel
{
    /**
     * PDO
     * @var object
     */
    private $PDO;
    
    /**
     * ErrorLog object
     * @var object
     */
    private $ErrorLog;
    
    /**
     * Session instance
     * @var object
     */
    private $Session;
    
    /**
     * instance of language object
     * @var object
     */
    private $Lang;
    
    /**
     * Mail instance
     * @var object
     */
    private $Mail;
    
    /**
     * Contains an array with the current users data
     * @var array
     */
    private $User = array();
    
    /**
     * Set up the db model
     * @param object $di
     */
    public function __construct(\stdClass $di)
    {
        $this->PdoWrapper      	= $di->PdoWrapper;
        $this->ErrorLog 		= $di->ErrorLog;
        $this->Session	 		= $di->Session;
        $this->View				= $di->View;
        $this->Lang				= $di->View->Lang;
        
        $this->User				= $this->Session->getUser();
    }
    
    /**
     * Set mail instance
     * @param Bang\Modules\Account\Models $Mail
     */
    public function setMailInstance(\Bang\Modules\Dashboard\Models\Mail $Mail)
    {
    	$this->Mail = $Mail;
    }
    
    /**
     * Get system messaged by type
     * @param string $type
     * @return array|boolean
     */
	public function getSystemMessages(string $type = 'app')
	{
		if($type != 'app' && $type != 'db' && $type != 'security') {
			return false;
		}
		
		$query = "SELECT * FROM `".$this->addTable('error_log')."`
					WHERE 
						`type` = :type
					
					ORDER BY `id` DESC LIMIT 20
		";
		
		try {
			 
			$this->PdoWrapper->prepare($query);
			$this->PdoWrapper->bindValue(':type', $type, PDO::PARAM_STR);
			$this->PdoWrapper->execute();
			 
			$result = $this->PdoWrapper->fetchAssocList();
			 
			if(is_array($result) && count($result)) {
				return $result;
			}
			 
		} catch (\PDOException $e) {
			 
			$message = $e->getMessage();
			$message .= $e->getTraceAsString();
			$message .= $e->getCode();
			$this->ErrorLog->logError('DB', $message, __METHOD__ .' - Line: '. __LINE__);
		}
		
		return false;
	}
    
    
    /**
     * Must be in all classes
     * @return array
     */
    public function __debugInfo() {
    
    	$reflect	= new \ReflectionObject($this);
    	$varArray	= array();
    
    	foreach ($reflect->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
    		$propName = $prop->getName();
    		 
    		if($propName !== 'DI') {
    			//print '--> '.$propName.'<br />';
    			$varArray[$propName] = $this->$propName;
    		}
    	}
    
    	return $varArray;
    }
}