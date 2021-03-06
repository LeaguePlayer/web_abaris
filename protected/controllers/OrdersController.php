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
        $count = 0;
        $archived = 0;
        foreach ( Yii::app()->cart->getPositions() as $position ) {
            if ( !$position->isArchived() )
                $count++;
            else
                $archived++;
        }
        if ( $count == 0 ) {
            $this->render('//site/message', array('message'=>'Ваша корзина пуста'));
            Yii::app()->end();
        }
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
        } else {
            $user = Yii::app()->user->model();
            $model->recipient_firstname = $user->profile->first_name;
            $model->recipient_family = $user->profile->last_name;
            $model->recipient_lastname = $user->profile->father_name;
            $model->client_email = $user->email;
            $model->client_phone = $user->profile->phone;
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
                    $cost = Yii::app()->cart->getCost(true);
                    $dbCart = Yii::app()->user->getDbCart();
                    $delivery_price = $dbCart->getDeliveryPrice($cost);

                    $model->self_transport = $dbCart->self_transport;
                    $model->delivery_price = $delivery_price;
                    $model->full_cost = $cost + $delivery_price;
                    $model->order_status = Orders::ORDERSTATUS_NOPAYD;
                    $prevSID = Yii::app()->db->createCommand()->select('MAX(sid)')->from('{{orders}}')->queryScalar();
                    $model->SID = $prevSID + 1;
                    $model->save(false);
                    $userDiscount = Yii::app()->user->getDiscount();
                    foreach (Yii::app()->cart->getPositions() as $position) {
                        if ( $position->isArchived() )
                            continue;
                        $orderPosition = new OrderPositions();
                        $orderPosition->order_id = $model->id;
                        $orderPosition->position_id = $position->id;
                        $orderPosition->position_key = $position->getId();
                        $orderPosition->name = $position->name;
                        $orderPosition->count = $position->getQuantity();
                        $orderPosition->cost = $position->getPrice();
                        $orderPosition->discount = $position->discount + $userDiscount;
                        $orderPosition->save();
                        Yii::app()->cart->remove($position->getId());
                    }
                    Yii::app()->session->remove('orderState');
                    Yii::app()->user->setState('__remindSTO', false);
                    $this->redirect('success');
                }
            }
        }

        Yii::app()->setImport(array('application.helpers.AbarisHtml'));
        $assetsPath = $this->getAssetsUrl('application');
        Yii::app()->clientScript->registerCssFile($assetsPath.'/css/order.css', '', 500);
        Yii::app()->clientScript->registerCssFile($assetsPath.'/css/catalog.css', '', 600);
        Yii::app()->clientScript->registerCssFile($assetsPath.'/css/animate-custom.css', '', 600);
        Yii::app()->clientScript->registerScriptFile($assetsPath.'/js/orders.js', EClientScript::POS_BEGIN);
        $this->render('step'.$step, array(
            'model'=>$model,
        ));
    }


    public function actionSuccess()
    {
        $this->render('success');
    }


    public function actionView($id)
    {
        $model = $this->loadModel('Orders', $id, array('with'=>'positions'));
        if ( Yii::app()->request->isAjaxRequest ) {
            $this->renderPartial('view', array('model'=>$model));
            Yii::app()->end();
        }

        $this->render('view', array('model'=>$model));
    }
}
