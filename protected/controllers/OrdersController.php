<?php

class OrdersController extends FrontController
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
				'actions'=>array('step1'),
				'users'=>array('*'),
			),
		);
	}


    public function actionCreate($step = 1)
    {
        $model = new Orders('step'.$step);
        $model->attributes = Yii::app()->session->get('orderState', array());
        if ( isset(Yii::app()->request->cookies['__prefferedOrder']) ) {
            $prefferedState = unserialize( Yii::app()->request->cookies['__prefferedOrder']->value );
            if ( $step == 1 ) {
                if ( empty($model->paytype) ) $model->paytype = $prefferedState['paytype'];
            } else if ( $step == 2 ) {
                if ( empty($model->recipient_firstname) ) $model->recipient_firstname = $prefferedState['recipient_firstname'];
                if ( empty($model->recipient_family) ) $model->recipient_family = $prefferedState['recipient_family'];
                if ( empty($model->recipient_lastname) ) $model->recipient_lastname = $prefferedState['recipient_lastname'];
                if ( empty($model->client_email) ) $model->client_email = $prefferedState['client_email'];
                if ( empty($model->client_phone) ) $model->client_phone = $prefferedState['client_phone'];
            }
        }
        $model->cart_id = Yii::app()->user->dbCart->id;
        if ( isset($_POST['Orders']) ) {
            $model->attributes = $_POST['Orders'];
            if ( $step == 2 and $model->preffered ) {
                $cookie = new CHttpCookie('__prefferedOrder', serialize($model->attributes));
                $cookie->expire = time() + 60 * 60 * 24 * 180;
                Yii::app()->request->cookies['__prefferedOrder'] = $cookie;
            }
            if ( $model->validate() ) {
                $orderState = Yii::app()->session->get('orderState', array());
                foreach ( $model->attributes as $attribute => $value ) {
                    if ( empty($value) )
                        continue;
                    $orderState[$attribute] = $value;
                }
                Yii::app()->session->add('orderState', $orderState);
                if ( $step < 3 ) {
                    $this->redirect($this->createUrl('/orders/create', array('step'=>$step + 1)));
                } else {
                    $model->save(false);
                    Yii::app()->session->remove('orderState');
                    $this->redirect('success');
                }
            }
        }

        Yii::app()->setImport(array('application.helpers.AbarisHtml'));
        $assetsPath = $this->getAssetsUrl('application');
        Yii::app()->clientScript->registerCssFile($assetsPath.'/css/order.css', '', 500);
        Yii::app()->clientScript->registerCssFile($assetsPath.'/css/catalog.css', '', 600);
        Yii::app()->clientScript->registerScriptFile($assetsPath.'/js/orders.js', CClientScript::POS_END);
        $this->render('step'.$step, array(
            'model'=>$model,
        ));
    }


    public function actionSuccess()
    {
        $this->render('success');
    }
}
