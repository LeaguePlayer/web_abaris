<?php

/**
* This is the model class for table "{{orders}}".
*
* The followings are the available columns in table '{{orders}}':
    * @property integer $id
    * @property string $SID
    * @property string $paytype
    * @property integer $order_status
    * @property integer $cart_id
    * @property string $recipient_firstname
    * @property string $recipient_family
    * @property string $recipient_lastname
    * @property string $client_comment
    * @property string $client_email
    * @property string $client_phone
    * @property string $order_date
    * @property string $delivery_date
    * @property integer $status
    * @property integer $sort
    * @property integer $create_time
    * @property integer $update_time
    * @property decimal $full_cost
    * @property integer $archived
*/
class Orders extends EActiveRecord
{
    public $preffered = false;
    public $confirm;
    public $recipientFio;

    const PAYTYPE_CASH = 'cash';
    const PAYTYPE_VISA = 'visa';
    const PAYTYPE_MASTERCARD = 'mastercard';
    const PAYTYPE_MAIL = 'mail';
    const PAYTYPE_YANDEX = 'yandex';
    const PAYTYPE_SBERBANK = 'sberbank';
    const PAYTYPE_WEBMONEY = 'webmoney';
    public function getPaytypes($type = false)
    {
        $paytypes = array(
            self::PAYTYPE_CASH => 'Наличный расчет',
            self::PAYTYPE_VISA => 'VISA',
            self::PAYTYPE_MASTERCARD => 'MasterCard',
            self::PAYTYPE_MAIL => 'Деньги@Mail.ru',
            self::PAYTYPE_YANDEX => 'Яндекс.Деньги',
            self::PAYTYPE_SBERBANK => 'Сбербанк Онл@йн',
            self::PAYTYPE_WEBMONEY => 'Web Money',
        );
        return ( $type ) ? $paytypes[$type] : $paytypes;
    }
    public function getCurrentPaytype()
    {
        return self::getPaytypes($this->paytype);
    }


    const ORDERSTATUS_NOPAYD = 0;
    const ORDERSTATUS_WORK = 1;
    const ORDERSTATUS_PAYD = 2;
    public static function getStatusLabels()
    {
        return array(
            self::ORDERSTATUS_NOPAYD => 'Не оплачено',
            self::ORDERSTATUS_PAYD => 'Оплачено',
            self::ORDERSTATUS_WORK => 'В работе',
        );
    }

    public function isPayd()
    {
        return $this->order_status == self::ORDERSTATUS_PAYD;
    }

    public function isNopayd()
    {
        return $this->order_status == self::ORDERSTATUS_NOPAYD;
    }

    public function isWork()
    {
        return $this->order_status == self::ORDERSTATUS_WORK;
    }


    const IS_UNARCHIVED = 0;
    const IS_ARCHIVED = 1;
    public function isArchived()
    {
        return $this->archived == self::IS_ARCHIVED;
    }


    public function tableName()
    {
        return '{{orders}}';
    }


    public function rules()
    {
        return array(
            //array('paytype, recipient_firstname, recipient_family, recipient_lastname, client_email, client_phone', 'required'),
            //array('order_status, cart_id, status, sort, create_time, update_time', 'numerical', 'integerOnly'=>true),
            //array('SID, paytype, client_phone', 'length', 'max'=>20),
            //array('recipient_firstname, recipient_family, recipient_lastname', 'length', 'max'=>45),
            //array('client_email', 'length', 'max'=>100),
            //array('client_comment, order_date, delivery_date', 'safe'),
            // The following rule is used by search().
            //array('id, SID, paytype, order_status, cart_id, recipient_firstname, recipient_family, recipient_lastname, client_comment, client_email, client_phone, order_date, delivery_date, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
            array('paytype', 'required', 'on'=>'step1'),
            array('paytype', 'length', 'max'=>20, 'on'=>'step1'),

            array('paytype', 'safe', 'on'=>'step2'),
            array('recipient_firstname, recipient_family, recipient_lastname, client_email, client_phone', 'required', 'on'=>'step2'),
            array('recipient_firstname, recipient_family, recipient_lastname', 'length', 'max'=>45, 'on'=>'step2'),
            array('client_phone', 'length', 'max'=>20, 'on'=>'step2'),
            array('client_email', 'length', 'max'=>100, 'on'=>'step2'),
            array('client_email', 'email', 'on'=>'step2'),
            array('client_comment, preffered', 'safe', 'on'=>'step2'),

            array('paytype, recipient_firstname, recipient_family, recipient_lastname, client_comment, client_email, client_phone', 'safe', 'on'=>'step3'),
            array('confirm', 'required', 'on'=>'step3'),

            array('paytype', 'required', 'on'=>'admin'),
            array('paytype', 'length', 'max'=>20, 'on'=>'admin'),
            array('recipient_firstname, recipient_family, recipient_lastname, client_email, client_phone', 'required', 'on'=>'admin'),
            array('recipient_firstname, recipient_family, recipient_lastname', 'length', 'max'=>45, 'on'=>'admin'),
            array('client_phone', 'length', 'max'=>20, 'on'=>'admin'),
            array('client_email', 'length', 'max'=>100, 'on'=>'admin'),
            array('client_email', 'email', 'on'=>'admin'),

            array('id, SID, paytype, order_status, cart_id, recipient_firstname, recipient_family, recipient_lastname, client_comment, client_email, client_phone, order_date, delivery_date, status, sort, create_time, update_time, recipientFio', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'cart' => array(self::BELONGS_TO, 'Cart', 'cart_id'),
            'positions' => array(self::HAS_MANY, 'OrderPositions', 'order_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'SID' => 'Номер заказа',
            'paytype' => 'Способ оплаты',
            'order_status' => 'Текщий статус заказа',
            'cart_id' => 'Номер корзины',
            'recipient_firstname' => 'Имя получателя',
            'recipient_family' => 'Фамилия получателя',
            'recipient_lastname' => 'Отчество получателя',
            'client_comment' => 'Комментарий заказчика',
            'client_email' => 'Email заказчика',
            'client_phone' => 'Телефон заказчика',
            'order_date' => 'Дата заказа',
            'delivery_date' => 'Примерная дата доставки',
            'status' => 'Статус',
            'sort' => 'Вес для сортировки',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата последнего редактирования',
            'preffered' => 'Использовать условия оплаты и ввденные личные данные этого заказа в качестве предпочтительных',
            'confirm' => 'Я согласен с '.CHtml::link('данными условиями', '#').' (Условия обслуживания)',
            'recipientFio' => 'Заказчик',
        );
    }




    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('SID',$this->SID,true);
		$criteria->compare('paytype',$this->paytype,true);
		$criteria->compare('order_status',$this->order_status);
		$criteria->compare('cart_id',$this->cart_id);
        if ( !empty($this->recipientFio) ) {
            $queryParts = explode(' ', $this->recipientFio);
            $sql = '';
            foreach ( $queryParts as $key => $part ) {
                if ( $key !== 0 )
                    $sql .= ' OR ';
                $sql .= 'recipient_firstname LIKE :part'.$key.' OR recipient_family LIKE :part'.$key.' OR recipient_lastname LIKE :part'.$key;
                $criteria->params[':part'.$key] = '%'.$part.'%';
            }
        }
		$criteria->compare('client_comment',$this->client_comment,true);
		$criteria->compare('client_email',$this->client_email,true);
		$criteria->compare('client_phone',$this->client_phone,true);
        if ( !empty($this->order_date) ) {
            $criteria->compare('order_date', date('Y-m-d', strtotime($this->order_date)),true);
        }
		$criteria->compare('delivery_date',$this->delivery_date,true);
		$criteria->compare('full_cost',$this->full_cost);
		$criteria->compare('status',$this->status);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
        $criteria->order = 'order_status';

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
        return 'Заказы';
    }

    public function getRecipientFio()
    {
        return $this->recipient_family.' '.$this->recipient_firstname.' '.$this->recipient_lastname;
    }

    public function getViewUrl()
    {
        return Yii::app()->createUrl('/orders/view', array('id' => $this->id));
    }

    public function getOrderStatus()
    {
        if ( $this->isArchived() ) {
            return 'В архиве';
        }
        $labels = self::getStatusLabels();
        return $labels[$this->order_status];
    }

    public function beforeSave()
    {
    	if (parent::beforeSave()) {
            if ( empty($this->order_date) )
                $this->order_date = date('Y-m-d H:i');
    		return true;
    	}
    	return false;
    }

    public function getArchiveAction()
    {
        if ( $this->isArchived() )
            return Yii::app()->urlManager->createUrl('/user/cabinet/unarchiveOrder', array('id'=>$this->id));
        else
            return Yii::app()->urlManager->createUrl('/user/cabinet/archiveOrder', array('id'=>$this->id));
    }
}
