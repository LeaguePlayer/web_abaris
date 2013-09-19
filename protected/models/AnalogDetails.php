<?php

/**
* This is the model class for table "{{analog_details}}".
*
* The followings are the available columns in table '{{analog_details}}':
    * @property integer $original_id
    * @property integer $analog_id
    * @property integer $sort
*/
class AnalogDetails extends CActiveRecord
{
    public function tableName()
    {
        return '{{analog_details}}';
    }


    public function rules()
    {
        return array(
            array('original_id, analog_id', 'required'),
            array('original_id, analog_id, sort', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            array('original_id, analog_id, sort', 'safe', 'on'=>'search'),
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
            'original_id' => 'Оригинал',
            'analog_id' => 'Аналог',
            'sort' => 'Вес для сортировки',
        );
    }




    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('original_id',$this->original_id);
		$criteria->compare('analog_id',$this->analog_id);
		$criteria->compare('sort',$this->sort);
        $criteria->order = 'sort';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


}
