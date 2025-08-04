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
	public function __construct($idcard,$email)

	{

		$this->idcard=$idcard;

		$this->email=$email;


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
		$arr_admin_user = array("adm1n01","adm1n02","adm1n03","adm1n04");
		
		
		if(in_array($this->idcard,$arr_admin_user)){
			//เช็ค user
			switch($this->idcard){
				case "adm1n01" :
					if($this->email == "Sena@2020*"){
						$this->errorCode = self::ERROR_NONE;
						$this->setState('user_type', "admin");
						$this->setState('name', "Admin01");
						$this->setState('lname', "Sena");
						$this->setState('role', "admin");
						$this->setState('project', "admin1");
						
						$this->_id = 1;
					}else{
						$this->errorCode = self::ERROR_PASSWORD_INVALID;
					}
				
				break;
				
				case "adm1n02":
					if($this->email == "Sena@2020*"){
						$this->errorCode = self::ERROR_NONE;
						$this->setState('user_type', "admin");
						$this->setState('name', "Admin02");
						$this->setState('lname', "Sena");
						$this->setState('role', "admin");
						$this->setState('project', "admin2");
						$this->_id = 2;
					}else{
						$this->errorCode = self::ERROR_PASSWORD_INVALID;
					}
				break;
				
				case "adm1n03":
					if($this->email == "Sena@2020*"){
						$this->errorCode = self::ERROR_NONE;
						$this->setState('user_type', "admin");
						$this->setState('name', "Admin03");
						$this->setState('lname', "Sena");
						$this->setState('role', "admin");
						$this->setState('project', "admin3");
						$this->_id = 3;
					}else{
						$this->errorCode = self::ERROR_PASSWORD_INVALID;
					}
				break;
				case "adm1n04":
					if($this->email == "PAss@2020*"){
						$this->errorCode = self::ERROR_NONE;
						$this->setState('user_type', "admin");
						$this->setState('name', "Super");
						$this->setState('lname', "Admin");
						$this->setState('role', "admin");
						$this->_id = 4;
					}else{
						$this->errorCode = self::ERROR_PASSWORD_INVALID;
					}
				break;
				
			}
			
			
			return !$this->errorCode;
		}else{
			
            $users = Agent::model()->findByAttributes(array('idcard'=>$this->idcard));
			
            if($users === null) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;   
             
            }
            else if($this->email != $users->email) {

                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            }
            else {           
                $this->errorCode = self::ERROR_NONE;
				$this->setState('name', $users->fname);
				$this->setState('lname', $users->lname);
                $this->_id = $users->id;
				$this->setState('code_ref', $users->idcard);
				
            }
			
            return !$this->errorCode;
		}
			
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
	public function getuser_type() {
		return $this->_user_type;
	}
	
}
	
