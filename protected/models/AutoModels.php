<?php

/**
* This is the model class for table "{{auto_models}}".
*
* The followings are the available columns in table '{{auto_models}}':
    * @property integer $id
    * @property string $name
    * @property integer $brand_id
    * @property string $img_photo
    * @property string $description
    * @property string $release_date
    * @property integer $number_doors
    * @property integer $engine_model_id
    * @property integer $bodytype_id
    * @property string $VIN
    * @property integer $status
    * @property integer $sort
    * @property integer $create_time
    * @property integer $update_time
*/
class AutoModels extends EActiveRecord
{
    public function tableName()
    {
        return '{{auto_models}}';
    }


    public function rules()
    {
        return array(
            array('name', 'required'),
            array('brand_id, number_doors, engine_model_id, bodytype_id, status, sort, create_time, update_time', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>100),
            array('img_photo', 'length', 'max'=>256),
            array('VIN', 'length', 'max'=>20),
            array('description, release_date', 'safe'),
            // The following rule is used by search().
            array('id, name, brand_id, img_photo, description, release_date, number_doors, engine_model_id, bodytype_id, VIN, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
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
            'name' => 'Модель',
            'brand_id' => 'Марка',
            'img_photo' => 'Фото',
            'description' => 'Описание',
            'release_date' => 'Дата выпуска',
            'number_doors' => 'Количество дверей',
            'engine_model_id' => 'Модель двигателя',
            'bodytype_id' => 'Тип кузова',
            'VIN' => 'VIN',
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
					)
				),
			),
        ));
    }


    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('brand_id',$this->brand_id);
		$criteria->compare('img_photo',$this->img_photo,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('release_date',$this->release_date,true);
		$criteria->compare('number_doors',$this->number_doors);
		$criteria->compare('engine_model_id',$this->engine_model_id);
		$criteria->compare('bodytype_id',$this->bodytype_id);
		$criteria->compare('VIN',$this->VIN,true);
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
