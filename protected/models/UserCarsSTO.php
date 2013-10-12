<?php

/**
* This is the model class for table "{{user_cars_STO}}".
*
* The followings are the available columns in table '{{user_cars_STO}}':
    * @property integer $id
    * @property integer $user_car_id
    * @property string $maintenance_date
    * @property string $maintenance_name
    * @property string $maintenance_type
    * @property double $maintenance_cost
    * @property double $azs_cost
    * @property integer $status
    * @property integer $sort
    * @property integer $create_time
    * @property integer $update_time
*/
class UserCarsSTO extends EActiveRecord
{
    const MT_REPAIR_CHASSIS = 1;
    const MT_REPAIR_POWERUNIT = 2;
    const MT_REPAIR_BRAKESYSTEM = 3;
    const MT_REPAIR_ELECTRICAL = 4;
    const MT_REPAIR_BODY = 5;
    const MT_INSTALL_EQUIPMENT = 6;
    const MT_PAINTING_CARS = 7;
    const MT_TIRE = 8;
    const MT_TO = 9;


    public static function getMaintenanceTypes()
    {
        return array(
            self::MT_TO => 'Прохождение ТО',
            self::MT_REPAIR_CHASSIS => 'Ремонт ходовой части авто',
            self::MT_REPAIR_POWERUNIT => 'Ремонт силовой части авто',
            self::MT_REPAIR_BRAKESYSTEM => 'Ремонт тормозной системы',
            self::MT_REPAIR_ELECTRICAL => 'Ремонт электрической части',
            self::MT_INSTALL_EQUIPMENT => 'Установка дополнительного оборудования',
            self::MT_REPAIR_BODY => 'Ремонт кузова и бамперов авто',
            self::MT_PAINTING_CARS => 'Покраска авто и его частей',
            self::MT_TIRE => 'Шиномонтаж',
        );
    }


    public function getMaintenanceTypeLabel()
    {
        $types = self::getMaintenanceTypes();
        return $types[$this->maintenance_type];
    }


    public function tableName()
    {
        return '{{user_cars_STO}}';
    }


    public function rules()
    {
        return array(
            array('user_car_id', 'required'),
            array('user_car_id, status, sort, create_time, update_time', 'numerical', 'integerOnly'=>true),
            array('maintenance_cost, azs_cost', 'numerical'),
            array('maintenance_name', 'length', 'max'=>45),
            array('maintenance_date, maintenance_type', 'safe'),
            // The following rule is used by search().
            array('id, user_car_id, maintenance_date, maintenance_name, maintenance_type, maintenance_cost, azs_cost, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
			"user_car"=>array(self::BELONGS_TO, "UserCars", "user_car_id")
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_car_id' => 'Модель автомобиля',
            'maintenance_date' => 'Дата прохождения ТО',
            'maintenance_name' => 'Название ТО',
            'maintenance_type' => 'Вид работ',
            'maintenance_cost' => 'Сумма затрат',
            'azs_cost' => 'Затраты на АЗС',
            'status' => 'Статус',
            'sort' => 'Вес для сортировки',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата последнего редактирования',
        );
    }


    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('user_car_id',$this->user_car_id);
		$criteria->compare('maintenance_date',$this->maintenance_date,true);
		$criteria->compare('maintenance_name',$this->maintenance_name,true);
		$criteria->compare('maintenance_type',$this->maintenance_type,true);
		$criteria->compare('maintenance_cost',$this->maintenance_cost);
		$criteria->compare('azs_cost',$this->azs_cost);
		$criteria->compare('status',$this->status);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
        $criteria->order = 'sort';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function translition()
    {
        return 'СТО';
    }
}
