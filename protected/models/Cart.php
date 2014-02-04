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
            array('user_id, self_transport', 'numerical', 'integerOnly'=>true),
            array('SID', 'length', 'max'=>20),
            // The following rule is used by search().
            array('id, SID, user_id', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'cart_details' => array(self::HAS_MANY, 'CartDetails', 'cart_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'Номер корзины',
            'SID' => '№ карты',
            'user_id' => 'Пользователь',
            'self_transport' => 'Самовывоз',
        );
    }


    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('SID',$this->SID,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('self_transport',$this->user_id);
        $criteria->order = 'id';

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

    public function getUserEmail()
    {
        if ( $this->user )
            return $this->user->email;
        else
            return '';
    }

    public function getDeliveryPrice($price)
    {
        if ( +$this->self_transport ) {
            return 0;
        }
        $priceRanges = array(
            array(
                'from' => 0,
                'to' => 5000,
                'price' => 1000,
            ),
            array(
                'from' => 5000,
                'to' => 10000,
                'price' => 500,
            ),
            array(
                'from' => 10000,
                'to' => 9999999999,
                'price' => 200,
            ),
        );

        foreach ( $priceRanges as $range ) {
            if ( $range['from'] < $price && $price <= $range['to'] )
                return $range['price'];
        }

        return 0;
    }
}
