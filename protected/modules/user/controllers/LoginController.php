<?php

class LoginController extends FrontController
{
	public $defaultAction = 'login';
    public $layout = '//layouts/main';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastViset();
					if (Yii::app()->getBaseUrl()."/index.php" === Yii::app()->user->returnUrl)
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}

            if ( Yii::app()->request->isAjaxRequest ) {
                $this->renderPartial('/user/_ajaxlogin', array('model'=>$model));
                Yii::app()->end();
            }
			// display the login form
            $this->cs->registerCssFile($this->getAssetsUrl('application').'/css/login.css');
            $this->cs->registerScriptFile($this->getAssetsUrl('application').'/js/sign_up.js', CClientScript::POS_END);
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit_at = date('Y-m-d H:i:s');
		$lastVisit->save();
	}
}