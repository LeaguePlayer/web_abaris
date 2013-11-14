<?php

class SiteController extends FrontController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex($do = false)
	{
        if ( ($this->brand === null) or ($do == 'select_brand') ) {
            $this->layout = '//layouts/headband';
            $criteria = new CDbCriteria();
            $criteria->addInCondition('alias', array('hyundai', 'kia', 'chevrolet', 'daewoo', 'ssang_yong'));
            $brands = Brands::model()->findAll($criteria);
            $this->render('select_brand', array('brands'=>$brands));
            Yii::app()->end();
        }

        Yii::app()->clientScript->registerCssFile( $this->getAssetsUrl().'/css/main980.css' );
        $this->render('index');
	}

    public function actionChangeBrand($alias)
    {
        $brand = Brands::model()->findByAttributes(array('alias'=>$alias));
        if ( $brand !== null ) {
            $brandState['id'] = $brand->id;
            $brandState['logo'] = $brand->getImageUrl('icon');
            $brandState['name'] = $brand->name;
            $brandState['alias'] = $brand->alias;
            $cookie = new CHttpCookie(self::COOKIE_VAR_CURRENT_BRAND, CJSON::encode($brandState));
            Yii::app()->request->cookies[self::COOKIE_VAR_CURRENT_BRAND] = $cookie;
            $this->redirect(array('site/index', 'brand'=>$brand->alias));
        }
    }
	
	
	public function actionFeedback()
	{
		$model = new Feedback();
		
		
		if( isset($_POST['Feedback']) )
		{
			$model->attributes = $_POST['Feedback'];
			
			if($model->validate())
			{
				// если валидация пройдена - отправляем сообщение для главного админа сайта	
				
				$template_email_for_admin = 
				"Добрый день!
				<br><br>
				На Ваш сайт поступило обращение от пользователя <strong>%username%</strong>, с указаным емейл адресом <a href='mailto:%email%?subject=Ответ на ваше сообщение с сайта abarisparts.ru'>%email%</a>.
				<br>
				Текст обращения:
				<br>
				<strong>%message%</strong>
				";
					
				$replaces = array("%username%" => $model->username, "%email%" => $model->email, "%message%" => $model->message);
				$template_email_for_admin = strtr($template_email_for_admin, $replaces);
				
				SiteHelper::sendMail("Обратная связь с сайта abarisparts.ru", $template_email_for_admin, Settings::getOption('email_admin'));
				
				// если пользователь указал почту и она валидна, то отправляем дублирующее сообщение пользователю
				if($model->validate(array('email')) and !empty($model->email) )
				{
						$template_email_for_user = 
						"Добрый день, %username%!
						<br><br>
						Мы благодарим за обращение в нашу компанию. Абарис заботится о каждом своем клиенте. Мы постараемся обработать вашу заявку как можно быстрее.
						<br>
						Данные полученные нами:
						<br>
						<strong>Имя:</strong> %username%
						<br>
						<strong>Email:</strong> %email%
						<br>
						<strong>Текст сообщения: </strong>
						<br>
						%message%
						";
							
						$replaces = array("%username%" => $model->username, "%email%" => $model->email, "%message%" => $model->message);
						$template_email_for_user = strtr($template_email_for_user, $replaces);
						
						SiteHelper::sendMail("Обратная связь с сайта abarisparts.ru", $template_email_for_user, $model->email);
				}
				
				$this->redirect('thanks');
			}
				
		}
		
		if(Yii::app()->user->getState('email')) $model->email = Yii::app()->user->getState('email');
		if(Yii::app()->user->getState('first_name')) $model->username = Yii::app()->user->getState('first_name');
		
		
		Yii::app()->clientScript->registerCssFile( $this->getAssetsUrl().'/css/feedback.css' );
		
		if(Yii::app()->request->isAjaxRequest)
			echo $this->renderPartial('feedback', array( 'model'=>$model ));
		else
			 $this->render('feedback', array( 'model'=>$model ));
	}
	
	
	public function actionThanks()
	{
		if(Yii::app()->request->isAjaxRequest)
			$this->renderPartial('thanks');
		else
		{
			Yii::app()->clientScript->registerCssFile( $this->getAssetsUrl().'/css/feedback.css' );
			$this->render('thanks');
		}
	}


	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
        $this->layout = '//layouts/main';
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}


    public function actionSearch()
    {
        $this->layout = '//layouts/main';

    }
}
