<?php

/**
* This is the model class for table "{{cart}}".
*
* The followings are the available columns in table '{{cart}}':
    * @property integer $id
    * @property string $SID
    * @property integer $user_id
*/
class Cart extends CActiveRecord
{
    public function tableName()
    {
        return '{{cart}}';
    }


    public function rules()
    {
        return array(
            array('user_id', 'numerical', 'integerOnly'=>true),
            array('SID', 'length', 'max'=>20),
            // The following rule is used by search().
            array('id, SID, user_id', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'cart_details' => array(self::HAS_MANY, 'CartDetails', 'cart_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'SID' => '№ карты',
            'user_id' => 'Ссылка на пользователя',
        );
    }


    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('SID',$this->SID,true);
		$criteria->compare('user_id',$this->user_id);
        $criteria->order = 'sort';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    public function beforeSave()
    {
        if ( parent::beforeSave() ) {
            if ( empty($this->SID) ) {
                $this->SID = uniqid();
                $this->user_id = Yii::app()->user->id;
            }
            return true;
        }
        return false;
    }


    public function updatePosition($position)
    {

    }
}
