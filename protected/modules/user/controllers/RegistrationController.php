<?php

class RegistrationController extends FrontController
{
	public $defaultAction = 'registration';
    public $layout = '//layouts/main';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	/**
	 * Registration user
	 */
	public function actionRegistration($step = 1)
    {
        Profile::$regMode = true;
        $model = new RegistrationForm('step'.$step);
        $profile=new Profile();
        $model->user_type = RegistrationForm::USERTYPE_PHYSIC;
        $registrationState = Yii::app()->session->get('registrationState', array());
        $model->attributes = $registrationState;
        if ( !isset(Yii::app()->request->cookies['_smsCodeLife']) )
            $model->smsCode = null;
        $profile->attributes = Yii::app()->session->get('profileState', array());

        $invalidStep = $model->getInvalidPreviousStep($step);
        if ( $invalidStep !== null ) {
            $this->redirect($this->createUrl('/user/registration', array('step'=>$invalidStep)));
        }

        if ( $step == 3 ) {
            $userCars = array(new UserCars());
        }

        if ( isset($_POST['UpdateSmsCode']) ) {
            $model->updateSMSCode($profile->phone);
            $registrationState['smsCode'] = $model->smsCode;
            Yii::app()->session->add('registrationState', $registrationState);
            $this->refresh();
        }

        // ajax validator
        if (isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
        {
            echo UActiveForm::validate(array($model,$profile));
            Yii::app()->end();
        }

        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->controller->module->profileUrl);
        } else {
            if(isset($_POST['RegistrationForm'])) {
                $model->attributes=$_POST['RegistrationForm'];
                $profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
                $modelValid = $model->validate();
                if($profile->validate() and $modelValid)
                {
                    $registrationState = Yii::app()->session->get('registrationState', array());
                    foreach ( $_POST['RegistrationForm'] as $attribute => $value ) {
                        if ( empty($value) )
                            continue;
                        $registrationState[$attribute] = $value;
                    }
                    if ( $step == 1 ) {
                        if ( $model->smsCode === null )
                            $model->updateSMSCode($profile->phone);
                        $registrationState['smsCode'] = $model->smsCode;
                    }
                    Yii::app()->session->add('registrationState', $registrationState);
                    $profileState = Yii::app()->session->get('profileState', array());
                    foreach ( $profile->attributes as $attribute => $value ) {
                        if ( empty($value) )
                            continue;
                        $profileState[$attribute] = $value;
                    }
                    Yii::app()->session->add('profileState', $profileState);

                    if ( $step < 3 ) {
                        $this->redirect($this->createUrl('/user/registration', array('step'=>$step + 1)));
                    }
                    $sourcePassword = $model->password;
                    $model->activkey=UserModule::encrypting(microtime().$model->password);
                    $model->password=UserModule::encrypting($model->password);
                    $model->verifyPassword=UserModule::encrypting($model->verifyPassword);
                    $model->superuser=0;
                    $model->status=User::STATUS_ACTIVE;

                    if ($model->save()) {
                        $profile->user_id=$model->id;
                        $profile->save();
                        if ( isset($_POST['UserCars']) ) {
                            foreach ( $_POST['UserCars'] as $postCar ) {
                                $emptyRecord = empty($postCar['brand'])
                                and empty($postCar['model'])
                                and empty($postCar['year'])
                                and empty($postCar['VIN']);
                                if ($emptyRecord)
                                    continue;
                                $userCar = new UserCars();
                                $userCar->attributes = $postCar;
                                $userCar->user_id = $model->id;
                                $userCar->save();
                            }
                        }
                        Yii::app()->session->remove('registrationState');
                        Yii::app()->session->remove('profileState');
                        $this->sendActivationInfo($model, $sourcePassword);
                        $this->redirect('/user/registration/success');
                    }
                }
            }
            if ( Yii::app()->request->isAjaxRequest ) {
                echo $this->renderPartial('/user/registration_step'.$step,array('model'=>$model,'profile'=>$profile, 'userCars'=>$userCars));
                Yii::app()->end();
            }
            $this->cs->registerCssFile($this->getAssetsUrl().'/css/registration.css');
            $this->cs->registerScriptFile($this->getAssetsUrl('application').'/js/sign_up.js', CClientScript::POS_END);
            $this->cs->registerScriptFile($this->getAssetsUrl().'/js/registration.js', CClientScript::POS_END);
            $this->render('/user/registration_step'.$step,array('model'=>$model,'profile'=>$profile, 'userCars'=>$userCars));
        }
	}


    public function actionSuccess()
    {
        if ( Yii::app()->request->isAjaxRequest )
            $this->renderPartial('/user/success');
        else
            $this->render('/user/success');
    }


    protected function sendActivationInfo($user, $sourcePassword)
    {
        /*
        if (Yii::app()->controller->module->sendActivationMail) {
            $activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $user->activkey, "email" => $user->email));
            UserModule::sendMail($user->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
        }

        if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
            $identity=new UserIdentity($user->username,$sourcePassword);
            $identity->authenticate();
            Yii::app()->user->login($identity,0);
            $this->redirect(Yii::app()->controller->module->returnUrl);
        } else {
            if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
                Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
            } elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
                Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
            } elseif(Yii::app()->controller->module->loginNotActiv) {
                Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
            } else {
                Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
            }
            $this->refresh();
        }
        */
        return true;
    }
}