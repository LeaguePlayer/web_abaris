<?php

/**
* This is the model class for table "{{user_cars}}".
*
* The followings are the available columns in table '{{user_cars}}':
    * @property integer $id
    * @property string $brand
    * @property string $model
    * @property integer $year
    * @property string $VIN
    * @property double $mileage
    * @property integer $status
    * @property integer $sort
    * @property integer $create_time
    * @property integer $update_time
*/
class UserCars extends EActiveRecord
{
    public function tableName()
    {
        return '{{user_cars}}';
    }


    public function rules()
    {
        return array(
            array('brand, model', 'required'),
            array('year, status, sort, create_time, update_time', 'numerical', 'integerOnly'=>true),
            array('mileage', 'numerical'),
            array('brand, model', 'length', 'max'=>45),
            array('VIN', 'length', 'max'=>20),
            // The following rule is used by search().
            array('id, brand, model, year, VIN, mileage, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'sto' => array(self::HAS_MANY, 'UserCarsSTO', 'user_car_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'brand' => 'Марка авто',
            'model' => 'Модель авто',
            'year' => 'Год выпуска',
            'VIN' => 'ВИН',
            'mileage' => 'Пробег',
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
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('year',$this->year);
		$criteria->compare('VIN',$this->VIN,true);
		$criteria->compare('mileage',$this->mileage);
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
        return 'Авто пользователя';
    }

    public function beforeSave()
    {
    	if (parent::beforeSave()) {
            if ( empty($this->user_id) )
                $this->user_id = Yii::app()->user->id;
    		return true;
    	}
    	return false;
    }
}
