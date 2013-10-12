<?php

/**
* This is the model class for table "{{profiles}}".
*
* The followings are the available columns in table '{{profiles}}':
    * @property integer $user_id
    * @property string $first_name
    * @property string $last_name
    * @property string $company_name
    * @property string $jur_name
    * @property string $INN
    * @property string $KPP
    * @property string $account_number
    * @property string $director_fio
    * @property integer $taxation_system
    * @property string $phone
    * @property string $BIC
    *
    * The followings are the available model relations:
            * @property Users $user
    */
class Profiles extends EActiveRecord
{
    public function tableName()
    {
        return '{{profiles}}';
    }


    public function rules()
    {
        return array(
            array('taxation_system', 'numerical', 'integerOnly'=>true),
            array('first_name, last_name, jur_name', 'length', 'max'=>255),
            array('company_name, director_fio, BIC', 'length', 'max'=>100),
            array('INN, KPP, account_number', 'length', 'max'=>40),
            array('phone', 'length', 'max'=>20),
            // The following rule is used by search().
            array('user_id, first_name, last_name, company_name, jur_name, INN, KPP, account_number, director_fio, taxation_system, phone, BIC', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
                    'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'company_name' => 'Company Name',
            'jur_name' => 'Jur Name',
            'INN' => 'Inn',
            'KPP' => 'Kpp',
            'account_number' => 'Account Number',
            'director_fio' => 'Director Fio',
            'taxation_system' => 'Taxation System',
            'phone' => 'Phone',
            'BIC' => 'Bic',
        );
    }




    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('jur_name',$this->jur_name,true);
		$criteria->compare('INN',$this->INN,true);
		$criteria->compare('KPP',$this->KPP,true);
		$criteria->compare('account_number',$this->account_number,true);
		$criteria->compare('director_fio',$this->director_fio,true);
		$criteria->compare('taxation_system',$this->taxation_system);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('BIC',$this->BIC,true);
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
        return 'Профили пользователей';
    }


}
