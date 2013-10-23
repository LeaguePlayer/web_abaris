<?php

class UserInvoicesController extends FrontController
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
                'actions'=>array('print'),
                'users'=>array('*'),
            ),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	public function actionView($id)
	{
        $model = $this->loadModel('UserInvoices', $id);
        if ( Yii::app()->request->isAjaxRequest ) {
            $this->renderPartial('view', array('model'=>$model));
            Yii::app()->end();
        }
		$this->render('view',array(
			'model'=>$model,
		));
	}

    public function actionPrint($id)
    {
        $this->layout='//layouts/print';
        $invoice = $this->loadModel('UserInvoices', $id);
        $this->render('print', array('model'=>$invoice));
    }
}
