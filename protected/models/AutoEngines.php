<?php

/**
* This is the model class for table "{{auto_engines}}".
*
* The followings are the available columns in table '{{auto_engines}}':
    * @property integer $auto_model_id
    * @property integer $engine_id
*/
class AutoEngines extends CActiveRecord
{
    public function tableName()
    {
        return '{{auto_engines}}';
    }


    public function rules()
    {
        return array(
            array('auto_model_id, engine_id', 'required'),
            array('auto_model_id, engine_id', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            array('auto_model_id, engine_id', 'safe', 'on'=>'search'),
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
            'auto_model_id' => 'Модель авто',
            'engine_id' => 'Модель двигателя',
        );
    }




    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('auto_model_id',$this->auto_model_id);
		$criteria->compare('engine_id',$this->engine_id);
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
