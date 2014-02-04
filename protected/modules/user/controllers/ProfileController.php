<?php

class ProfileController extends FrontController
{
	public $defaultAction = 'edit';
	public $layout='//layouts/main';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	/**
	 * Shows a particular model.
	 */
	public function actionProfile()
	{
		$model = $this->loadUser();
	    $this->render('profile',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}

	public function init ()
    {
		parent::init();
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application')."/css/admin.css", '', 500);
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application')."/css/catalog.css", '', 600);
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application')."/css/form.css", '', 700);
        Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application')."/css/alertify/alertify-core.css", '', 800);
        Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application')."/css/alertify/alertify-default.css", '', 900);
        Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl('application')."/js/vendor/alertify.js", CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl('application')."/js/admin.js", CClientScript::POS_END);
		return true;
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
		$model = User::model()->notsafe()->findByPk( Yii::app()->user->id );
        if ( $model === null ) {
            $this->redirect(Yii::app()->controller->module->loginUrl);
        }
		$profile=$model->profile;

        $currentPassword = $model->password;
		$model->password = '';
		
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
            if ( empty($model->password) ) {
                $model->password = $currentPassword;
            } else {
                $model->password = UserModule::encrypting($model->password);
            }
			$profile->attributes=$_POST['Profile'];
			if($model->validate()&&$profile->validate()) {
                $profile->phone = str_replace(array("+7", " ", "(", ")", "-"), "", $profile->phone);
				$model->save(false);
				$profile->save(false);
				Yii::app()->user->setFlash('profileMessage',UserModule::t("Changes is saved."));
				$this->redirect(array('/user/profile'));
			} else $profile->validate();
		}

		$this->render('edit',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						$new_password->save();
						Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
						$this->redirect(array("profile"));
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
     * @return \CActiveRecord|null
     */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}
}