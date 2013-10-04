<?php

class AccessoryController extends FrontController
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
		$this->render('view',array(
			'model'=>$this->loadModel('Details', $id),
		));
	}

	
	public function actionIndex()
	{
        $criteria = new CDbCriteria();
        $criteria->compare('type', Details::TYPE_ACCESSORY);
        $criteria->compare('status', Details::STATUS_PUBLISH);
        $criteria->order = 'name';
        $accessories = Details::model()->findAll($criteria);
		$dataProvider=new CActiveDataProvider('Details', array(
            'criteria'=>$criteria,
        ));
        Yii::app()->clientScript->registerCssFile( $this->getAssetsUrl().'/css/catalog.css' );
        Yii::app()->clientScript->registerScriptFile( $this->getAssetsUrl().'/js/catalog.js', CClientScript::POS_END );
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
}
