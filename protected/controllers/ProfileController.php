<?php

class ProfileController extends FrontController
{
	public $defaultAction = 'login';
    public $layout = '//layouts/main';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
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
			// display the login form
            $this->cs->registerCssFile($this->getAssetsUrl().'/css/login.css');
			$this->render('profile/login',array('model'=>$model));
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit_at = date('Y-m-d H:i:s');
		$lastVisit->save();
	}
}
