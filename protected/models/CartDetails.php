<?php

/**
* This is the model class for table "{{cart_details}}".
*
* The followings are the available columns in table '{{cart_details}}':
    * @property integer $id
    * @property integer $cart_id
    * @property integer $detail_id
    * @property integer $count
    * @property integer $status
    * @property integer $create_time
    * @property integer $update_time
*/
class CartDetails extends CActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_ARCHIVED = 2;
    public static function getStatusAliases($status = 0)
    {
        $aliases = array(
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_ARCHIVED => 'Отложен',
        );
        if ($status > 0)
            return $aliases[$status];
        return $aliases;
    }


    public function tableName()
    {
        return '{{cart_details}}';
    }


    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
            )
        );
    }


    public function rules()
    {
        return array(
            array('cart_id, detail_id', 'required'),
            array('cart_id, detail_id, count, status, create_time, update_time', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            array('id, cart_id, detail_id, count, status, create_time, update_time', 'safe', 'on'=>'search'),
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
            'cart_id' => 'Корзина',
            'detail_id' => 'Товар',
            'count' => 'Количество',
            'discount' => 'Скидка',
            'status' => 'Статус',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата последнего редактирования',
        );
    }


    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('cart_id',$this->cart_id);
		$criteria->compare('detail_id',$this->detail_id);
		$criteria->compare('count',$this->count);
		$criteria->compare('status',$this->status);
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


    public function beforeSave()
    {
        if ( parent::beforeSave() ) {
            if ( empty($this->status) ) {
                $this->status = self::STATUS_ACTIVE;
            }
            return true;
        }
        return false;
    }

    public function isArchived()
    {
        return $this->status == self::STATUS_ARCHIVED;
    }
}
