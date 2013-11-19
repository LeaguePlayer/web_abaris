<?php

/**
* This is the model class for table "{{depot}}".
*
* The followings are the available columns in table '{{depot}}':
    * @property integer $id
    * @property string $name
    * @property string $address
*/
class Depot extends CActiveRecord
{
    public function tableName()
    {
        return '{{depot}}';
    }


    public function rules()
    {
        return array(
            array('name, address', 'length', 'max'=>255),
            // The following rule is used by search().
            array('id, name, address', 'safe', 'on'=>'search'),
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
            'name' => 'Наименование',
            'address' => 'Адрес',
        );
    }




    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


}
