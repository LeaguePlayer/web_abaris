<?php

/**
* This is the model class for table "{{messages}}".
*
* The followings are the available columns in table '{{messages}}':
    * @property integer $id
    * @property string $message
    * @property integer $status
    * @property integer $user_id
    * @property string $from
    * @property integer $create_time
    * @property integer $update_time
*/
class Messages extends CActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_READ = 1;

    public static function getStatusAliases()
    {
        return array(
            self::STATUS_NEW => 'Новые',
            self::STATUS_READ => 'Прочитанные',
        );
    }


    public function getCurrentStatusLabel()
    {
        $labels = self::getStatusAliases();
        return $labels[$this->status];
    }


    public function tableName()
    {
        return '{{messages}}';
    }


    public function rules()
    {
        return array(
            array('status, user_id, create_time, update_time', 'numerical', 'integerOnly'=>true),
            array('from', 'length', 'max'=>150),
            array('message', 'safe'),
            // The following rule is used by search().
            array('id, message, status, user_id, from, create_time, update_time', 'safe', 'on'=>'search'),
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
            'message' => 'Текст сообщения',
            'status' => 'Статус',
            'user_id' => 'Пользователь',
            'from' => 'От кого',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата последнего редактирования',
        );
    }


    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('from',$this->from,true);
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

    public function isRead()
    {
        return !($this->status == self::STATUS_NEW);
    }

    public function getStrongMessage()
    {
        return '<b>'.$this->message.'</b>';
    }

    public function markAsRead()
    {
        $this->status = self::STATUS_READ;
        $this->save(false);
    }
}
