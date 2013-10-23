<?php

class BrandsController extends FrontController
{
	public $layout='//layouts/simple';

	
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

	
	public function actionView($alias)
	{
        $model = Brands::model()->findByAttributes(array('alias'=>$alias));
        if ( Yii::app()->request->isAjaxRequest ) {
            $this->renderPartial('view',array(
                'model'=>$model,
            ));
            Yii::app()->end();
        }
		$this->render('view',array(
			'model'=>$model,
		));
	}

	
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Brands');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
}
