<?php

/**
* This is the model class for table "{{adaptabillity}}".
*
* The followings are the available columns in table '{{adaptabillity}}':
    * @property integer $id
    * @property integer $detail_id
    * @property integer $auto_model_id
    * @property integer $engine_model_id
    * @property string $description
*/
class Adaptabillity extends CActiveRecord
{
    public function tableName()
    {
        return '{{adaptabillity}}';
    }


    public function rules()
    {
        return array(
            array('detail_id, auto_model_id, engine_model_id', 'required'),
            array('detail_id, auto_model_id, engine_model_id', 'numerical', 'integerOnly'=>true),
            array('description', 'safe'),
            // The following rule is used by search().
            array('id, detail_id, auto_model_id, engine_model_id, description', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'detail'=>array(self::BELONGS_TO, 'Details', 'detail_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'detail_id' => 'Ссылка на деталь',
            'auto_model_id' => 'Модель автомобиля',
            'engine_model_id' => 'Модель двигателя',
            'description' => 'Описание',
        );
    }




    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('detail_id',$this->detail_id);
		$criteria->compare('auto_model_id',$this->auto_model_id);
		$criteria->compare('engine_model_id',$this->engine_model_id);
		$criteria->compare('description',$this->description,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


}
