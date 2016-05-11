<?php
/**
 * @author Oliver Blum <blumanski@gmail.com>
 * @date 2016-01-02
 *
 * Ajax controller
 * Does not implement the interface
 * Does not need templates
 * 
 */

Namespace Bang\Modules\Dashboard;

Use Bang\Modules\Dashboard\Models\Db,
	Bang\Modules\Dashboard\Models\Mail,
	Bang\Tools\PusherWrapper,
    Bang\Helper;

class ajaxController extends \Bang\SuperController
{
	/**
	 * Modules DB Model
	 * @var object
	 */
	private $Data;
	
	/**
	 * View object
	 * @var object
	 */
	private $View;
	
	/**
	 * ErrorLog object
	 * @var object
	 */
	private $ErrorLog;
	
	/**
	 * Instance of Language object
	 * @var object
	 */
	private $Lang;
	
	/**
	 * Instance of Mail object
	 * @var object
	 */
	private $Mail;
	
	
	private $S3;
	
	/*
	 * Set up the class environment
	 * @param object $di
	 */
    public function __construct(\stdClass $di)
    {
        $this->path     		= dirname(dirname(__FILE__));
    	// assign class variables
    	$this->ErrorLog 		= $di->ErrorLog;
    	$this->View				= $di->View;
    	$this->Session          = $di->Session;
    	$this->Lang				= $di->View->Lang;
    	
    	// Get the current language loaded
    	$currentLang = $this->View->Lang->LangLoaded;
    	
    	$this->Overwrite = $this->getBackTplOverwrite();
    	$this->Pusher			= new PusherWrapper();

    	// Add module language files to language array
    	$this->View->Lang->addLanguageFile($this->path.'/lang/'.$currentLang);
    	$this->View->addStyle($this->View->TemplatePath.'min/css/account/assets/scss/account.min.css', 0);

    	// every action function in this class needs a permission check
    	// in this case, I can add it to the constructor
    	$this->testPermisions();
    	
    	$this->Data	= new Db($di);
    	$this->Mail	= new Mail($di);
    	$this->Data->setMailInstance($this->Mail);
    	
    	// AWS instance
    	$this->S3 = new \Bang\Tools\Awss3();
    }
    
    /**
     * upload avatar via ajax request
     */
    public function avataruploadAction()
    {
        $post  = Helper::getRequestParams('post');
        $files = Helper::getRequestParams('files');

        // if anything was send in post, it may has to get decoded
        if(Helper::isAjax() === true) {
        	$post  = Helper::prepareAjaxValues($post);
        }
        
        $response = false;
        
        if(is_array($files) && isset($files['file']) && isset($files['file']['tmp_name']) && !empty($files['file']['tmp_name'])) {
        	
        	$filename = $this->S3->putObject($files['file']['tmp_name'], $files['file']['name'], 'avatars/');
        	
        	if($filename !== false && !empty($filename)) {
        		
        		if($this->Data->updateCurrentUsersAvatar($filename) === true) {
        			
        			$this->Session->setToUser('avatar', $filename);
        			
        			die(json_encode(array('response' => 'success')));
        			
        		} else {
        			
        			die(json_encode(array('response' => 'failed', 'error' => 'db update')));
        			
        		}
        	}
        }
        
        die(json_encode(array('response' => 'failed')));
    }
    
    /**
     * Send a chat message to pusher
     */
    public function chatMessageAction()
    {
    	$post = Helper::getRequestParams('post');
    	$post = Helper::prepareAjaxValues($post);
    	
    	// trigger pusher notification, only if pusher config data is set
    	if(isset(CONFIG['pusher']) && isset(CONFIG['pusher']['appid']) && !empty(CONFIG['pusher']['appid'])) {
    	
    		if(is_array($post) && isset($post['message']) && !empty($post['message'])) {
    		
    			$identifier = substr(md5($this->Session->getUserEmail()), 0, 12);
    			$user = $this->Session->getUser();
    			 
    			$data['message'] 		= htmlspecialchars($post['message'], ENT_QUOTES, 'UTF-8');
    			$data['date']			= date('Y-m-d H:i:s');
    			$data['identifier'] 	= $identifier;
    			$data['username'] 		= $user['username'];
    			$this->Pusher->triggerEvent(CONFIG['pusher']['chatchannel'], 'intern_chat', $data);
    			
    			die(json_encode(array('outcome' => 'success', 'message' => 'Send message to pusher..')));
    			
    		}
    	}
    	
    	die(json_encode(array('outcome' => 'false', 'message' => 'in move node methos')));
    }
    
    /**
     * Permission test
     * 1. Test if user is logged in
     */
    private function testPermisions()
    {
    	// 1. if user is not logegd in, redirect to login with message
    	if($this->Session->loggedIn() === false || $this->Session->hasPermission(1) !== true) {
    		$this->Session->setError($this->Lang->get('application_notlogged_in'));
    		Helper::redirectTo('/account/index/login/');
    		exit;
    	}
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
