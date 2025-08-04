<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $idcard;
	public $email;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('idcard, email', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('email', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 * @param string $attribute the name of the attribute to be validated.
	 * @param array $params additional parameters passed with rule when being executed.
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity = new UserIdentity($this->idcard,$this->email);
			
			if(!$this->_identity->authenticate()){
				
				switch($this->_identity->errorCode){
					case UserIdentity::ERROR_USERNAME_INVALID:
						//$this->addError('email','');
						$this->addError('idcard','Incorrect ID CARD.');
					break;
					
					case UserIdentity::ERROR_PASSWORD_INVALID:
						$this->addError('email','Incorrect Email.');
						//$this->addError('idcard','');
					break;
					
					default:
						$this->addError('email','Incorrect Email.');
						$this->addError('idcard','Incorrect ID CARD.');
					break;
					
				}
			
				//exit(print_r($this->_identity->authenticate()));
		
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->idcard,$this->email);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
