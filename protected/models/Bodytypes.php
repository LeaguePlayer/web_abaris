<?php

/**
* This is the model class for table "{{bodytypes}}".
*
* The followings are the available columns in table '{{bodytypes}}':
    * @property integer $id
    * @property string $name
*/
class Bodytypes extends CActiveRecord
{
    public function tableName()
    {
        return '{{bodytypes}}';
    }


    public function rules()
    {
        return array(
            array('name', 'length', 'max'=>45),
            // The following rule is used by search().
            array('id, name', 'safe', 'on'=>'search'),
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
            'name' => 'Тип кузова',
        );
    }




    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
        $criteria->order = 'name';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


}
