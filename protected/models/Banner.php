<?php

/**
* This is the model class for table "{{banners}}".
*
* The followings are the available columns in table '{{banners}}':
    * @property integer $id
    * @property string $img_photo
    * @property string $url
    * @property integer $target
    * @property string $title
    * @property string $description
    * @property integer $status
    * @property integer $sort
    * @property integer $create_time
    * @property integer $update_time
*/
class Banner extends EActiveRecord
{
    const TARGET_BLANK = 1;
    const TARGET_SELF = 2;

    public static function constants($type)
    {
        switch ( $type ) {
            case 'target':
                return array(
                    self::TARGET_BLANK => 'В новом окне',
                    self::TARGET_SELF => 'В текущем окне',
                );
            default:
                return array();
        }
    }

    public function getCurrentTarget()
    {
        $labels = self::constants('target');
        return $labels[$this->target];
    }

    public function tableName()
    {
        return '{{banners}}';
    }


    public function rules()
    {
        return array(
            array('target, status, sort, create_time, update_time', 'numerical', 'integerOnly'=>true),
            array('img_photo, url, title', 'length', 'max'=>255),
            array('description', 'safe'),
            // The following rule is used by search().
            array('id, img_photo, url, target, title, description, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
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
            'img_photo' => 'Превью',
            'url' => 'Ссылка',
            'target' => 'Тип ссылки',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'status' => 'Статус',
            'sort' => 'Вес для сортировки',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата последнего редактирования',
        );
    }


    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
        	'imgBehaviorPhoto' => array(
				'class' => 'application.behaviors.UploadableImageBehavior',
				'attributeName' => 'img_photo',
				'versions' => array(
					'icon' => array(
						'centeredpreview' => array(90, 90),
					),
					'small' => array(
						'resize' => array(200, 180),
					),
                    'main' => array(
                        'centeredpreview' => array(322, 106),
                    )
				),
			),
        ));
    }


    public function published($limit=3)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition'=>'status='.self::STATUS_PUBLISH,
            'order'=>'sort',
            'limit'=>$limit,
        ));
        return $this;
    }


    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('img_photo',$this->img_photo,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('target',$this->target);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
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


}
