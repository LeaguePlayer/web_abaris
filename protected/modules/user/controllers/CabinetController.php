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
                'actions'=>array('cars','carForm', 'sto', 'stoForm', 'orders', 'invoices', 'archiveOrder', 'unarchiveOrder'),
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
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('user')."/css/cabinet.css", '', 800);
        Yii::app()->clientScript->registerCssFile($this->getAssetsUrl('application').'/css/cupertino/jquery-ui-1.9.2.custom.min.css');
        Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl('application')."/js/admin.js", CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl('application')."/js/vendor/jquery.printPage.js", CClientScript::POS_END);

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

        $carsFinder = new UserCars('search');
        $carsFinder->unsetAttributes();
        if ( isset( $_GET['UserCars'] ) ) {
            $carsFinder->attributes = $_GET['UserCars'];
            $criteria = new CDbCriteria();
            $criteria->compare('user_id', Yii::app()->user->id);
            $criteria->compare('brand', $carsFinder->brand, true);
            $criteria->compare('model', $carsFinder->model, true);
            $criteria->compare('year', $carsFinder->year);
            $criteria->compare('VIN', $carsFinder->VIN, true);
            $criteria->compare('mileage', $carsFinder->mileage);
            $dataUserListCars = new CActiveDataProvider("UserCars", array(
                'criteria' => $criteria,
                "pagination" => array(
                    "pageSize" => 10,
                ),
            ));
            $this->renderPartial('_cars_grid_body', array(
                'dataUserListCars' => $dataUserListCars
            ));
            Yii::app()->end();
        }


		$criteria = new CDbCriteria();
        $criteria->compare('user_id', Yii::app()->user->id);
        $criteria->compare('brand', $carsFinder->brand);
        $criteria->compare('model', $carsFinder->model);
        $criteria->compare('year', $carsFinder->year);
        $criteria->compare('VIN', $carsFinder->VIN);
        $criteria->compare('mileage', $carsFinder->mileage);
		$dataUserListCars = new CActiveDataProvider("UserCars", array(
            'criteria' => $criteria,
            "pagination" => array(
                "pageSize" => 10,
            ),
        ));

        if ( Yii::app()->request->isAjaxRequest ) {
            echo $this->renderPartial("cars", array(
                'carsFinder' => $carsFinder,
                "dataUserListCars" => $dataUserListCars
            ));
            Yii::app()->end();
        }
		$this->render("cars", array(
            'carsFinder' => $carsFinder,
            "dataUserListCars" => $dataUserListCars
        ));
	}


	
	public function actionCarForm ($id = false) {
		if ($id){
			$user_car = UserCars::model()->findByPk($id);
		} else {
			$user_car = new UserCars('add');
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


	
	public function actionSto()
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
            $model->maintenance_date = date('Y-m-d', strtotime($model->maintenance_date));
            if($model->save()){
                $this->redirect(array('cabinet/sto'));
            }
		}

        if (!empty($model->maintenance_date))
            $model->maintenance_date = date('d.m.Y', strtotime($model->maintenance_date));
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
        $criteria->order = 'archived, id DESC';
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

    public function actionArchiveOrder($id)
    {
        $order = $this->loadModel('Orders', $id);
        $order->archived = Orders::IS_ARCHIVED;
        $order->save(false);
        $this->redirect('/user/cabinet/orders');
    }

    public function actionUnarchiveOrder($id)
    {
        $order = $this->loadModel('Orders', $id);
        $order->archived = Orders::IS_UNARCHIVED;
        $order->save(false);
        $this->redirect('/user/cabinet/orders');
    }

    public function actionInvoices()
    {
        $invoiceFinder = new UserInvoices();
        $invoiceFinder->unsetAttributes();
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', Yii::app()->user->id);
        $invoicesDataProvider = new CActiveDataProvider('UserInvoices', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 1000,
            )
        ));
        $this->render("invoices", array(
            "invoicesDataProvider" => $invoicesDataProvider,
            'invoiceFinder' => $invoiceFinder,
        ));
    }
}
