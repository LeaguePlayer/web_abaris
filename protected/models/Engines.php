<?php

/**
* This is the model class for table "{{engines}}".
*
* The followings are the available columns in table '{{engines}}':
    * @property integer $id
    * @property string $name
    * @property string $alias
    * @property double $volume
    * @property integer $fuel
    * @property double $power
    * @property string $description
    * @property integer $status
    * @property integer $sort
    * @property integer $create_time
    * @property integer $update_time
*/
class Engines extends EActiveRecord
{
    const FUEL_BENZINE = 1;
    const FUEL_DIESEL = 2;
    const FUEL_GAS = 3;

    public function getFuelTypes($type = null)
    {
        $types = array(
            self::FUEL_BENZINE => 'Бензин',
            self::FUEL_DIESEL => 'Дизель',
            self::FUEL_GAS => 'Газ',
        );
        if ($type !== null)
            return $types[$type];
        else
            return $types;
    }

    public function tableName()
    {
        return '{{engines}}';
    }


    public function rules()
    {
        return array(
            array('fuel, status, sort, create_time, update_time', 'numerical', 'integerOnly'=>true),
            array('volume, power', 'numerical'),
            array('name, alias', 'length', 'max'=>100),
            array('description', 'safe'),
            // The following rule is used by search().
            array('id, name, volume, fuel, power, description, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Название',
            'alias' => "Сокращенное название",
            'volume' => 'Объем двигателя',
            'fuel' => 'Тип топлива',
            'power' => 'Мощность',
            'description' => 'Описание',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->name);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('fuel',$this->fuel);
		$criteria->compare('power',$this->power);
		$criteria->compare('description',$this->description,true);
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

    public function getFuelType()
    {
        if ( !$this->fuel )
            return '–';
        return $this->getFuelTypes($this->fuel);
    }
}
