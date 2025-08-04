<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	private $_code_ref;
	private $_project;
	private $_project_view;
	private $_user_type;
	public $idcard;
	public $email;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function __construct($username,$password)

	{

		$this->username=$username;

		$this->password=$password;


	}
		 
	public function authenticate()
	{
		/*$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		
		//print_r($users);
		//exit();
		if(!isset($users[$this->idcard]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->idcard]!==$this->email)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;*/

			
            $users = AgUser::model()->findByAttributes(array('username'=>$this->username));
			
            if($users === null) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;   
             
            }
            else if($this->password != $users->password) {

                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            }
            else {           
                $this->errorCode = self::ERROR_NONE;
				$this->setState('user_type', "admin");
				$this->setState('role', $users->role);
				$this->setState('project', $users->project);
				$this->setState('project_view', $users->project_view);

				//$this->setState('name', $users->fname);
				//$this->setState('lname', $users->lname);
                $this->_id = $users->id;
				//$this->setState('code_ref', $users->idcard);
				
            }
			
            return !$this->errorCode;
		}
			

	
	public function getId() {
		return $this->_id;
	}
	public function getcode_ref() {
		return $this->_code_ref;
	}
	public function getproject() {
		return $this->_project;
	}
	public function getproject_view() {
		return $this->_project_view;
	}
	
	public function getuser_type() {
		return $this->_user_type;
	}
	
}
	
