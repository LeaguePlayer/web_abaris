<?php

/**
* This is the model class for table "{{depot_positions}}".
*
* The followings are the available columns in table '{{depot_positions}}':
    * @property integer $depot_id
    * @property integer $position_id
*/
class DepotPosition extends CActiveRecord
{
    public function tableName()
    {
        return '{{depot_positions}}';
    }


    public function rules()
    {
        return array(
            array('depot_id, position_id', 'required'),
            array('depot_id, position_id', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            array('depot_id, position_id', 'safe', 'on'=>'search'),
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
            'depot_id' => 'Склад',
            'position_id' => 'Товар',
        );
    }




    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('depot_id',$this->depot_id);
		$criteria->compare('position_id',$this->position_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


}
