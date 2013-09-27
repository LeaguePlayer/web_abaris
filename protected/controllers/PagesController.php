<?php

class PagesController extends FrontController
{
	public $layout='//layouts/main';

	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	public function actionView($id)
	{
        if ( is_numeric($id) ) {
            $model = $this->loadModel('Pages', $id);
        } else {
            $model = Pages::model()->findByAttributes(array('alias'=>$id));
            if ( $model === null )
                throw new CHttpException(404, 'Страница не найдена');
        }
		$this->render('view',array(
			'model'=>$model,
		));
	}

	
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Pages');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
}
