<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User {
	public $verifyPassword;
	public $verifyCode;
    public $smsCode;

    protected $smsCodeExpire = 900;
	
	public function rules() {
		$rules = array(
			array('password, verifyPassword, email', 'required', 'on'=>'step1'),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols)."), 'on'=>'step1'),
			array('email', 'email', 'on'=>'step1'),
            array('user_type', 'numerical', 'integerOnly' => true, 'on'=>'step1'),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists."), 'on'=>'step1'),
            array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect."), 'on'=>'step1'),

            array('password, verifyPassword, email, user_type, smsCode', 'safe', 'on' => 'step2'),
            array('verifyCode', 'verifySmsCode', 'expire'=>$this->smsCodeExpire, 'on'=>'step2'),

            array('password, verifyPassword, email, user_type, smsCode, verifyCode', 'safe', 'on' => 'step3'),
		);
		return $rules;
	}

    public function attributeLabels()
    {
        return array(
            'password'=>"Придумайте пароль",
            'verifyPassword'=>"Повторите пароль",
            'email'=>"Введите Ваш E-mail адрес",
        );
    }

    public function getInvalidPreviousStep($currentStep)
    {
        for ( $step = 1; $step < $currentStep; $step++ ) {
            $this->setScenario('step'.$step);
            if ( !$this->validate() ) {
                $this->setScenario('step'.$currentStep);
                return $step;
            }
        }
        $this->setScenario('step'.$currentStep);
        return null;
    }

    public function verifySmsCode($attribute, $params) {
        if ( (string)$this->{$attribute} === (string)$this->smsCode and isset(Yii::app()->request->cookies['_smsCodeLife']) )
            return true;
        $this->addError($attribute, "Код введен неверно. Попробуйте еще раз.");
        return false;
    }

    public function afterSave()
    {
        parent::afterSave();
        unset(Yii::app()->request->cookies['_smsCodeLife']);
    }

    public function updateSMSCode($phone)
    {
        $this->smsCode = SiteHelper::genRandomDigit();
        $cookie = new CHttpCookie('_smsCodeLife', true);
        $cookie->expire = time() + $this->smsCodeExpire;
        Yii::app()->request->cookies['_smsCodeLife'] = $cookie;
        $smsSender = Yii::app()->sms;
        $smsSender->send($this->smsCode, $phone);
    }
}