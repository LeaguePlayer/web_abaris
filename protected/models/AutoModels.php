<?php

/**
* This is the model class for table "{{auto_models}}".
*
* The followings are the available columns in table '{{auto_models}}':
    * @property integer $id
    * @property string $name
    * @property string $alias
    * @property integer $brand_id
    * @property string $img_photo
    * @property string $description
    * @property string $dt_release_date
    * @property string $dt_end_release_date
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
            array('brand_id, number_doors, bodytype_id, status, sort, create_time, update_time', 'numerical', 'integerOnly'=>true),
            array('name, alias', 'length', 'max'=>100),
            array('img_photo', 'length', 'max'=>256),
            array('VIN', 'length', 'max'=>20),
            array('description, dt_release_date, dt_end_release_date', 'safe'),
            // The following rule is used by search().
            array('id, name, brand_id, img_photo, description, dt_release_date, dt_end_release_date, number_doors, bodytype_id, VIN, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'engines'=>array(self::MANY_MANY, 'Engines', AutoEngines::model()->tableName().'(auto_model_id, engine_id)'),
            'bodytype'=>array(self::BELONGS_TO, 'Bodytypes', 'bodytype_id'),
            'brand'=>array(self::BELONGS_TO, 'Brands', 'brand_id'),
            'adaptDetails'=>array(self::MANY_MANY, 'Details', Adaptabillity::model()->tableName().'(auto_model_id, detail_id)'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Модель',
            'alias' => 'Сокращенное название',
            'brand_id' => 'Марка',
            'img_photo' => 'Фото',
            'description' => 'Описание',
            'dt_release_date' => 'Дата выпуска',
            'dt_end_release_date' => 'Дата окончания выпуска',
            'number_doors' => 'Количество дверей',
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
                        'resize' => array(117, 64),
                    ),
                    'medium' => array(
                        'resize' => array(217, 0),
                    ),
                    'big' => array(
                        'resize' => array(415, 0),
                    ),
                ),
            ),
        ));
    }


    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->name);
		$criteria->compare('brand_id',$this->brand_id);
		$criteria->compare('img_photo',$this->img_photo,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('dt_release_date',$this->dt_release_date,true);
		$criteria->compare('dt_end_release_date',$this->dt_end_release_date,true);
		$criteria->compare('number_doors',$this->number_doors);
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

	public function beforeSave()
	{
		if (!empty($this->dt_release_date))
			$this->dt_release_date = Yii::app()->date->toMysql($this->dt_release_date);
		if (!empty($this->dt_end_release_date))
			$this->dt_end_release_date = Yii::app()->date->toMysql($this->dt_end_release_date);
		return parent::beforeSave();
	}

	public function afterFind()
	{
		parent::afterFind();
		if ( in_array($this->scenario, array('insert', 'update')) ) { 
			$this->dt_release_date = ($this->dt_release_date !== '0000-00-00' ) ? date('d-m-Y', strtotime($this->dt_release_date)) : '';
			$this->dt_end_release_date = ($this->dt_end_release_date !== '0000-00-00' ) ? date('d-m-Y', strtotime($this->dt_end_release_date)) : '';
		}
	}

    public function getReleaseYear()
    {
        return !empty($this->dt_release_date)
            ? date('Y', strtotime($this->dt_release_date))
            : '';
    }

    public function getEndReleaseYear()
    {
        return !empty($this->dt_end_release_date)
            ? date('Y', strtotime($this->dt_end_release_date))
            : 'наст. время';
    }

    public function getDetailInfo()
    {
        $result = array();
        if ( !empty($this->bodytype) ) {

            $result['bodytype'] = array(
                'label'=>'Тип кузова',
                'value'=>$this->bodytype->name
            );
        }
        if ( !empty($this->number_doors) ) {
            $result['number_doors'] = array(
                'label'=>'Количество дверей',
                'value'=>$this->number_doors,
            );;
        }
        return $result;
    }
}
