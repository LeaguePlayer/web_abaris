<?php

/**
* This is the model class for table "{{provider_positions}}".
*
* The followings are the available columns in table '{{provider_positions}}':
    * @property integer $provider_id
    * @property integer $position_id
    * @property integer $stock
    * @property string $price
    * @property integer $delivery_time
*/
class ProviderPosition extends CActiveRecord
{
    public function tableName()
    {
        return '{{provider_positions}}';
    }


    public function rules()
    {
        return array(
            array('provider_id, position_id', 'required'),
            array('provider_id, position_id, stock, delivery_time', 'numerical', 'integerOnly'=>true),
            array('price', 'length', 'max'=>10),
            // The following rule is used by search().
            array('provider_id, position_id, stock, price, delivery_time', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'provider'=>array(self::BELONGS_TO, 'Providers', 'provider_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'provider_id' => 'Поставщик',
            'position_id' => 'Товар',
            'stock' => 'Наличие',
            'price' => 'Цена',
            'delivery_time' => 'Время доставки(в днях)',
        );
    }




    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('provider_id',$this->provider_id);
		$criteria->compare('position_id',$this->position_id);
		$criteria->compare('stock',$this->stock);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('delivery_time',$this->delivery_time);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


}
