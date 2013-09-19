<?php

/**
* This is the model class for table "{{detail_category}}".
*
* The followings are the available columns in table '{{detail_category}}':
    * @property integer $id
    * @property string $name
    * @property integer $parent_id
    * @property integer $level
*/
class DetailCategory extends CActiveRecord
{
    public function tableName()
    {
        return '{{detail_category}}';
    }


    public function rules()
    {
        return array(
            array('parent_id, level', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>255),
            // The following rule is used by search().
            array('id, name, parent_id, level', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'parent'=>array(self::BELONGS_TO, 'DetailCategory', 'parent_id'),
            'childs'=>array(self::HAS_MANY, 'DetailCategory', 'parent_id', 'order'=>'childs.name'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Наименование категории',
            'parent_id' => 'Родительская категория',
            'level' => 'Вложенность',
        );
    }


    public function search()
    {
        $criteria=new CDbCriteria;
        $criteria->with = array('parent', 'childs');
        $criteria->compare('t.level', 0);
        $criteria->order = 't.name';

        $categories = DetailCategory::model()->findAll($criteria);

        $data = array();
        foreach ($categories as $category) {
            $data[] = $category;
            foreach ( $category->childs as $childCategory ) {
                $data[] = $childCategory;
            }
        }

        return new CArrayDataProvider($data, array(
            'pagination'=>array(
                'pageSize'=>1000,
            )
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function getRootCategories()
    {
        return CHtml::listData( self::model()->findAllByAttributes(array('level'=>0)), 'id', 'name' );
    }

    public function beforeSave()
    {
        if ( parent::beforeSave() ) {
            if ( empty($this->parent_id) )
                $this->level = 0;
            else
                $this->level = 1;
            return true;
        }
        return false;
    }
}
