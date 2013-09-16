<?php

class CabinetController extends FrontController
{
	
	public function init () {
		parent::init();
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl()."/css/admin.css", '', 500);
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl()."/css/form.css", '', 600);
		return true;
	}
	
	public function actionCars () {		
		if (isset($_POST["deleteCar"])){
			$deletesCar = new CDbCriteria;
			$deletesCar->addInCondition("id", $_POST["deleteCar"]);
			UserCars::model()->deleteAll($deletesCar);
		}
		
		$dataUserListCars = new CActiveDataProvider("UserCars", array("pagination" => array("pageSize" => 10)));
		
		$this->render("cars", array("dataUserListCars" => $dataUserListCars));
	}
	
	public function actionCarForm ($id = false) {
		if ($id){
			$user_car = UserCars::model()->findByPk($id);
		}else{
			$user_car = new UserCars;
		}
		
		if (isset($_POST["UserCars"])){
				$user_car->attributes=$_POST['UserCars'];
				
				if($user_car->save()){
					$this->redirect(array('/cabinet/cars'));
				}
		}
		
		if (Yii::app()->request->isAjaxRequest){
			$this->renderPartial("carsForm", array("user_car" => $user_car));
		}else{
			$this->render("carsForm", array("user_car" => $user_car));
		}
	}
	
	public function actionSto () {
		
		if (isset($_POST["deleteCar"])){
			$deletesCar = new CDbCriteria;
			$deletesCar->addInCondition("id", $_POST["deleteCar"]);
			UserCarsSTO::model()->deleteAll($deletesCar);
		}
		
		if (isset($_POST["UserCars"])){
				$list_user_car_STO->attributes=$_POST['UserCars'];
				
				if($list_user_car_STO->save()){
					$this->redirect(array('/cabinet/sto'));
				}
		}
		
		$list_user_car_STO = UserCarsSTO::model()->with("user_car")->findAll();
		$this->render("sto", array("list_user_car_STO" => $list_user_car_STO));
	}
	
	public function actionStoForm ($id = false) {
		//$user_cars = UserCars::model()->findByAttributes(array("user_id" => Yii::app()->user->id));
		$user_cars = UserCars::model()->findAll();
		if ($id){
			$user_car_STO = UserCarsSTO::model()->with("user_car")->findByPk($id);
		}else{
			$user_car_STO = new UserCarsSTO;
		}
		
		if (isset($_POST["UserCarsSTO"])){
				$user_car_STO->attributes=$_POST['UserCarsSTO'];
				
				if($user_car_STO->save()){
					$this->redirect(array('/cabinet/sto'));
				}
		}
		
		if (Yii::app()->request->isAjaxRequest){
			$this->renderPartial("stoForm", array("user_car_STO" => $user_car_STO, "user_cars" => $user_cars));
		}else{
			$this->render("stoForm", array("user_car_STO" => $user_car_STO, "user_cars" => $user_cars));
		}
	}
}
