<?php

/**
* This is the model class for table "{{details_no_found}}".
*
* The followings are the available columns in table '{{details_no_found}}':
    * @property integer $id
    * @property string $username
    * @property string $mail
    * @property string $article
    * @property string $date_find
*/
class DetailsNoFound extends CActiveRecord
{
	public $cnt;
	
    public function tableName()
    {
        return '{{details_no_found}}';
    }


    public function rules()
    {
        return array(
            array('article, date_find', 'required'),
            array('username, mail', 'length', 'max'=>255),
            array('article', 'length', 'max'=>50),
            // The following rule is used by search().
            array('id, username, mail, article, date_find', 'safe', 'on'=>'search'),
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
            'username' => 'Имя пользователя',
            'mail' => 'e-mail пользователя',
            'article' => 'Артикул',
            'date_find' => 'Дата поиска',
			'cnt' =>'Количество запросов',
        );
    }




    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('mail',$this->mail,true);
		$criteria->compare('article',$this->article,true);
		$criteria->compare('date_find',$this->date_find,true);
        $criteria->group = "article";
		$criteria->select = "article, count(*) as cnt";
		$criteria->order = "cnt DESC";

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
        return 'Не найденные запчасти';
    }


}
