<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Feedback extends CFormModel
{
	public $username;
	public $email;
	public $message;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('username, message', 'required'),
			array('email', 'email'),
			array('message', 'length', 'max'=>1000),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>"Как Вас зовут ?",
			'email'=>"E-mail",
			'message'=>"Текст сообщения",
		);
	}


}
