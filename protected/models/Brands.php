<?php

/**
* This is the model class for table "{{brands}}".
*
* The followings are the available columns in table '{{brands}}':
    * @property integer $id
    * @property string $alias
    * @property string $name
    * @property string $img_logo
    * @property string $wswg_description
    * @property integer $status
    * @property integer $sort
    * @property integer $create_time
    * @property integer $update_time
*/
class Brands extends EActiveRecord
{
    public function tableName()
    {
        return '{{brands}}';
    }


    public function rules()
    {
        return array(
            array('name', 'required'),
            array('status, sort, create_time, update_time', 'numerical', 'integerOnly'=>true),
            array('alias, name', 'length', 'max'=>45),
            array('img_logo', 'length', 'max'=>256),
            array('wswg_description', 'safe'),
            // The following rule is used by search().
            array('id, alias, name, img_logo, wswg_description, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
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
            'alias' => 'Идентификатор',
            'name' => 'Название',
            'img_logo' => 'Логотип',
            'wswg_description' => 'Описание',
            'status' => 'Статус',
            'sort' => 'Вес для сортировки',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата последнего редактирования',
        );
    }


    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
        	'imgBehaviorLogo' => array(
				'class' => 'application.behaviors.UploadableImageBehavior',
				'attributeName' => 'img_logo',
				'versions' => array(
                    'icon' => array(
                        'resize' => array(60, 0),
                    ),
                    'medium' => array(
                        'resize' => array(180, 0),
                    )
				),
			),
        ));
    }


    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('img_logo',$this->img_logo,true);
		$criteria->compare('wswg_description',$this->wswg_description,true);
		$criteria->compare('status',$this->status);
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

    public function beforeSave()
    {
        if ( parent::beforeSave() ) {
            if ( empty($this->alias) ) {
                $this->alias = strtolower(SiteHelper::translit($this->name));
            }
            return true;
        }
        return false;
    }

    public function getViewUrl()
    {
        return Yii::app()->urlManager->createUrl('/brands/view', array('alias'=>$this->alias));
    }
}
