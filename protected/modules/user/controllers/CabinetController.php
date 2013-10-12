<?php

class CabinetController extends FrontController
{
    public $defaultAction = 'cars';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('cars','carForm', 'sto', 'stoForm', 'orders'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

	public function init ()
    {
		parent::init();
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application')."/css/admin.css", '', 500);
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application')."/css/catalog.css", '', 600);
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application')."/css/form.css", '', 700);
        Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application')."/css/alertify/alertify-core.css", '', 800);
        Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application')."/css/alertify/alertify-default.css", '', 900);
        Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl('application')."/js/vendor/alertify.js", CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl('application')."/js/admin.js", CClientScript::POS_END);
		return true;
	}
	
	public function actionCars ()
    {
        if ( isset($_POST['Cars']) and !empty($_POST['Cars']['checked']) ) {
            switch ( $_POST['action'] ) {
                case 'delete':
                    $criteria = new CDbCriteria();
                    $criteria->addInCondition('id', $_POST['Cars']['checked']);
                    $criteria->compare('user_id', Yii::app()->user->id);
                    UserCars::model()->deleteAll($criteria);
                    break;
            }
        }
		$criteria = new CDbCriteria();
        $criteria->compare('user_id', Yii::app()->user->id);
		$dataUserListCars = new CActiveDataProvider("UserCars", array(
            'criteria' => $criteria,
            "pagination" => array(
                "pageSize" => 10,
            ),
        ));

        if ( Yii::app()->request->isAjaxRequest ) {
            echo $this->renderPartial("cars", array("dataUserListCars" => $dataUserListCars));
            Yii::app()->end();
        }
		$this->render("cars", array("dataUserListCars" => $dataUserListCars));
	}


	
	public function actionCarForm ($id = false) {
		if ($id){
			$user_car = UserCars::model()->findByPk($id);
		} else {
			$user_car = new UserCars;
		}
		
		if (isset($_POST["UserCars"])){
            $user_car->attributes=$_POST['UserCars'];

            if($user_car->save()){
                $this->redirect(array('/user/cabinet'));
            }
		}
		if (Yii::app()->request->isAjaxRequest){
			$this->renderPartial("carsForm", array("user_car" => $user_car));
		}else{
			$this->render("carsForm", array("user_car" => $user_car));
		}
	}


	
	public function actionSto ()
    {
        $stoFinder = new UserCarsSTO();
        if ( isset($_POST['UserSTO']) and !empty($_POST['UserSTO']['checked']) ) {
            switch ( $_POST['action'] ) {
                case 'delete':
                    $criteria = new CDbCriteria();
                    $criteria->addInCondition('id', $_POST['UserSTO']['checked']);
                    UserCarsSTO::model()->deleteAll($criteria);
                    break;
            }
        }
        $criteria = new CDbCriteria();
        $criteria->with = "user_car";
        $criteria->compare('user_car.user_id', Yii::app()->user->id);
        $dataUserListSTO = new CActiveDataProvider('UserCarsSTO', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 1000
            ),
        ));
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial("sto", array(
                'stoFinder'=>$stoFinder,
                "dataUserListSTO" => $dataUserListSTO,
            ));
        }else{
            $this->render("sto", array(
                'stoFinder'=>$stoFinder,
                "dataUserListSTO" => $dataUserListSTO,
            ));
        }
	}


	
	public function actionStoForm ($id = false) {
		$userCars = Yii::app()->user->model()->cars;
		if ($id){
			$model = UserCarsSTO::model()->with("user_car")->findByPk($id);
		}else{
            $model = new UserCarsSTO;
		}
		
		if (isset($_POST["UserCarsSTO"])){
            $model->attributes=$_POST['UserCarsSTO'];
            if($model->save()){
                $this->redirect(array('cabinet/sto'));
            }
		}
		
		if (Yii::app()->request->isAjaxRequest){
			$this->renderPartial("stoForm", array("model" => $model, "userCars" => $userCars));
		} else {
			$this->render("stoForm", array("model" => $model, "userCars" => $userCars));
		}
	}


    public function actionOrders()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('cart_id', Yii::app()->user->dbCart->id);
        $ordersDataProvider = new CActiveDataProvider("Orders", array(
            'criteria' => $criteria,
            "pagination" => array(
                "pageSize" => 10,
            ),
        ));

        //if ( Yii::app()->request->isAjaxRequest ) {
        //    echo $this->renderPartial("cars", array("dataUserListCars" => $dataUserListCars));
        //    Yii::app()->end();
        //}
        $this->render("orders", array(
            "ordersDataProvider" => $ordersDataProvider
        ));
    }
}
