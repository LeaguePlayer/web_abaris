<?php

/**
* This is the model class for table "{{user_involces}}".
*
* The followings are the available columns in table '{{user_involces}}':
    * @property integer $id
    * @property string $invoice_number
    * @property string $date
    * @property string $cost
    * @property integer $status
    * @property string $attache_file
    * @property integer $user_id
    * @property integer $sort
    * @property integer $create_time
    * @property integer $update_time
    * @property integer $pay_status
*/
class UserInvoices extends EActiveRecord
{
    const STATUS_NOPAYD = 0;
    const STATUS_PAYD = 1;
    public static function getStatusLabels()
    {
        return array(
            self::STATUS_NOPAYD => 'Не оплачено',
            self::STATUS_PAYD => 'Оплачено',
        );
    }

    public function tableName()
    {
        return '{{user_involces}}';
    }


    public function rules()
    {
        return array(
            array('pay_status, status, user_id, sort, create_time, update_time', 'numerical', 'integerOnly'=>true),
            array('invoice_number, cost', 'length', 'max'=>45),
            array('attache_file', 'length', 'max'=>256),
            array('date', 'safe'),
            // The following rule is used by search().
            array('id, invoice_number, date, cost, status, attache_file, user_id, sort, create_time, update_time', 'safe', 'on'=>'search'),
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
            'invoice_number' => 'Номер счета',
            'date' => 'Дама',
            'cost' => 'Стоимость',
            'status' => 'Статус',
            'attache_file' => 'Файл',
            'user_id' => 'ID пользователя',
            'sort' => 'Вес для сортировки',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата последнего редактирования',
        );
    }




    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('invoice_number',$this->invoice_number,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('pay_status',$this->pay_status);
		$criteria->compare('status',$this->status);
		$criteria->compare('attache_file',$this->attache_file,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('sort',$this->sort);
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

    public function translition()
    {
        return 'Счета пользователей';
    }

    public function getPayStatus()
    {
        $labels = self::getStatusLabels();
        return $labels[$this->status];
    }

    public function isPayd()
    {
        return $this->pay_status == self::STATUS_PAYD;
    }

    public function getPrintUrl()
    {
        return Yii::app()->createUrl('/userInvoices/print', array('id'=>$this->id));
    }
}
