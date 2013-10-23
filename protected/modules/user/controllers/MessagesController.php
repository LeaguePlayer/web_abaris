<?php

class MessagesController extends FrontController
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
			'model'=>$this->loadModel('Messages', $id),
		));
	}

	
	public function actionIndex()
	{
        if ( isset($_POST['Messages']) and !empty($_POST['Messages']['checked']) ) {

            switch ( $_POST['Messages']['action'] ) {
                case 'delete':
                    $criteria = new CDbCriteria();
                    $criteria->addInCondition('id', $_POST['Messages']['checked']);
                    $criteria->compare('user_id', Yii::app()->user->id);
                    Messages::model()->deleteAll($criteria);
                    break;
            }
        }

        $criteria = new CDbCriteria();
        $criteria->compare('user_id', Yii::app()->user->id);
        $criteria->order = 'status, create_time';
		$dataProvider=new CActiveDataProvider('Messages', array(
            'criteria'=>$criteria
        ));

        if ( Yii::app()->request->isAjaxRequest ) {
            $this->renderPartial('index',array(
                'dataProvider'=>$dataProvider,
            ));
            Yii::app()->end();
        }

        Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application')."/css/catalog.css", '', 600);
        Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application')."/css/admin.css", '', 500);
        Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl('user')."/js/messages.js", CClientScript::POS_END);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
}
