<?php

/**
* This is the model class for table "{{details}}".
*
* The followings are the available columns in table '{{details}}':
    * @property integer $id
    * @property string $article
    * @property string $name
    * @property double $price
    * @property integer $in_stock
    * @property string $dt_delivery_date
    * @property string $img_photo
    * @property string $wswg_description
    * @property integer $brand_id
    * @property integer $category_id
    * @property integer $status
    * @property integer $sort
    * @property integer $create_time
    * @property integer $update_time
*/
Yii::import('application.behaviors.UploadableImageBehavior');
class Details extends EActiveRecord implements IECartPosition
{
    public function tableName()
    {
        return '{{details}}';
    }

    /**
     * @return mixed id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float price
     */
    public function getPrice()
    {
        return $this->price;
    }


    public function rules()
    {
        return array(
            array('article, name, price, brand_id, category_id', 'required'),
            array('in_stock, brand_id, category_id, status, sort, create_time, update_time', 'numerical', 'integerOnly'=>true),
            array('price', 'numerical'),
            array('article', 'length', 'max'=>45),
            array('name, img_photo', 'length', 'max'=>256),
            array('dt_delivery_date, wswg_description', 'safe'),
            // The following rule is used by search().
            array('id, article, name, price, in_stock, dt_delivery_date, img_photo, wswg_description, brand_id, category_id, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'brand'=>array(self::BELONGS_TO, 'Brands', 'brand_id'),
            'category'=>array(self::BELONGS_TO, 'DetailCategory', 'category_id'),
            'adaptAutoModels'=>array(self::MANY_MANY, 'AutoModels', Adaptabillity::model()->tableName().'(detail_id, auto_model_id)'),
            'analogs'=>array(self::MANY_MANY, 'Details', AnalogDetails::model()->tableName().'(original_id, analog_id)'),
            //'analogsInStock'=>array(self::MANY_MANY, 'Details', AnalogDetails::model()->tableName().'(original_id, analog_id)', 'condition'=>'analogsInStock.in_stock>0'),
            //'analogsNonInStock'=>array(self::MANY_MANY, 'Details', AnalogDetails::model()->tableName().'(original_id, analog_id)', 'condition'=>'analogsInStock.in_stock=0'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'article' => 'Артикул',
            'name' => 'Наименование детали',
            'price' => 'Стоимтость',
            'in_stock' => 'В наличии',
            'dt_delivery_date' => 'Примерная дата доставки',
            'img_photo' => 'Фото',
            'wswg_description' => 'Описание',
            'brand_id' => 'Бренд',
            'category_id' => 'Категория',
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
					'small' => array(
						'resize' => array(0, 125),
					),
				),
			),
        ));
    }


    public function scopes()
    {
        return array(
            'withAnalogsInStock'=>array(
                'with'=>'analogs',
                'condition'=>'analogs.in_stock>0',
            )
        );
    }


    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('article',$this->article,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('in_stock',$this->in_stock);
		$criteria->compare('dt_delivery_date',$this->dt_delivery_date,true);
		$criteria->compare('img_photo',$this->img_photo,true);
		$criteria->compare('wswg_description',$this->wswg_description,true);
		$criteria->compare('brand_id',$this->brand_id);
		$criteria->compare('category_id',$this->category_id);
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

    public function translition()
    {
        return 'Запчасти';
    }

	public function beforeSave()
	{
		if (!empty($this->dt_delivery_date))
			$this->dt_delivery_date = Yii::app()->date->toMysql($this->dt_delivery_date);
		return parent::beforeSave();
	}

	public function afterFind()
	{
		parent::afterFind();
		if ( in_array($this->scenario, array('insert', 'update')) ) { 
			$this->dt_delivery_date = ($this->dt_delivery_date !== '0000-00-00' ) ? date('d-m-Y', strtotime($this->dt_delivery_date)) : '';
		}
	}

    public function getUrl()
    {
        return Yii::app()->urlManager->createUrl('/details/view', array('id', $this->id));
    }

    public function toStringInStock()
    {
        return !empty($this->in_stock) ? is_numeric($this->in_stock) ? $this->in_stock.' шт.' : $this->in_stock : '—';
    }

    public function toStringPrice()
    {
        return SiteHelper::priceFormat($this->price, 'руб.');
    }

    public function onUpdateInCart($event)
    {

    }
}
