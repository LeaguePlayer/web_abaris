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
            $criteria->addInCondition('alias', array('Hyundai', 'Kia_Motors', 'Chevrolet', 'Daewoo', 'Ssang_Yong'));
            $brands = Brands::model()->findAll($criteria);
            $this->render('select_brand', array('brands'=>$brands));
            Yii::app()->end();
        }

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
            $this->redirect('/');
        }
    }


	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
        $this->layout = '//layouts/error';
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}
