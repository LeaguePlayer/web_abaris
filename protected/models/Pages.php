<?php

/**
* This is the model class for table "{{pages}}".
*
* The followings are the available columns in table '{{pages}}':
    * @property integer $id
    * @property string $title
    * @property string $alias
    * @property string $menu_title
    * @property string $wswg_content
    * @property string $meta_title
    * @property string $meta_key
    * @property string $meta_description
    * @property integer $status
    * @property integer $sort
    * @property integer $create_time
    * @property integer $update_time
*/
class Pages extends EActiveRecord
{
    const PAGESECTION_GENERAL = 0;
    const PAGESECTION_SHOP = 1;
    const PAGESECTION_CONTACT = 2;

    public static function getPageSections($sectionIndex = null)
    {
        $sections = array(
            self::PAGESECTION_GENERAL => 'Общий раздел',
            self::PAGESECTION_SHOP => 'Интрнет-магазин',
            self::PAGESECTION_CONTACT => 'Контактная информация',
        );
        if ($sectionIndex !== null)
            return $sections[$sectionIndex];
        else
            return $sections;
    }

    public function getPageSection()
    {
        return self::getPageSections($this->section);
    }

    public function tableName()
    {
        return '{{pages}}';
    }

    public function rules()
    {
        return array(
            array('title', 'required'),
            array('status, section, sort, create_time, update_time', 'numerical', 'integerOnly'=>true),
            array('title, alias, menu_title, meta_title', 'length', 'max'=>255),
            array('wswg_content, meta_key, meta_description', 'safe'),
            // The following rule is used by search().
            array('id, title, alias, menu_title, wswg_content, meta_title, meta_key, meta_description, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
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
            'title' => 'Название',
            'alias' => 'Идентификатор',
            'menu_title' => 'Название в меню',
            'wswg_content' => 'Контент',
            'meta_title' => 'Meta Title',
            'section' => 'Раздел',
            'meta_key' => 'Meta Key',
            'meta_description' => 'Meta Description',
            'status' => 'Статус',
            'sort' => 'Вес для сортировки',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата последнего редактирования',
        );
    }


    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('menu_title',$this->menu_title,true);
		$criteria->compare('wswg_content',$this->wswg_content,true);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_key',$this->meta_key,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('status',$this->status);
        $criteria->compare('section',$this->section);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
        $criteria->order = 'section, sort';

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
            if ( empty( $this->alias ) )
                $this->alias = SiteHelper::translit($this->title);
            if ( empty( $this->menu_title ) )
                $this->menu_title = $this->title;
            if ( empty( $this->meta_title ) )
                $this->meta_title = $this->title;
            if ( empty( $this->wswg_content ) )
                $this->wswg_content = "<p>Пустая страница</p>";
            return true;
        }
        return false;
    }

    public function getViewUrl()
    {
        return Yii::app()->urlManager->createUrl('/pages/view', array('id'=>$this->alias));
    }
}
