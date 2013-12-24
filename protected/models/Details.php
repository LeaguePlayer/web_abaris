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
    * @property integer $virtualType in depot or from provider
    * @property integer $virtualId id depot or id provider
    * @property double $discount
*/
Yii::import('application.behaviors.UploadableImageBehavior');
class Details extends EActiveRecord implements IECartPosition
{
    const TYPE_DETAIL = 0;
    const TYPE_ACCESSORY = 1;
    const TYPE_CONSUMABLE = 2;

    const VIRTUALTYPE_PROVIDER = 1;
    const VIRTUALTYPE_DEPOT = 2;

    /*
     * При просмотре товара на странице браузера
     * один и тот же товар может быть выведен несколько раз с разбивкой либо по складу,
     * либо по поставщикам (при этом будет различаться цена и время доставки).
     * Параметры virtualType и virtualId введены для того, чтобы различать товары в корзине с одинаковыми
     * артикулом и id-шником, но различным виртуальным типом.
     * См. метод actionView в классе DetailsController
     */
    public $virtualType;
    public $virtualId;

    public static function getDetailTypes($type = false)
    {
        $types = array(
            self::TYPE_DETAIL => 'Запчасти',
            self::TYPE_ACCESSORY => 'Аксессуары',
            self::TYPE_CONSUMABLE => 'Расходные материалы',
        );
        return ($type) ? $types[$type] : $types;
    }

    public function tableName()
    {
        return '{{details}}';
    }

    private $_cartKey;
    public function setCartKey($key)
    {
        $this->_cartKey = $key;
        $keyParts = explode('_', $key);
        $this->id = $keyParts[0];
        $this->virtualType = $keyParts[1];
        $this->virtualId = $keyParts[2];
    }
    public function getCartKey()
    {
        if ( $this->_cartKey === null )
            $this->_cartKey = $this->id.'_'.$this->virtualType.'_'.$this->virtualId;
        return $this->_cartKey;
    }

    /**
     * @return mixed id
     */
    public function getId()
    {
        if ($this->virtualType === null)
            return $this->id;
        else {
            return $this->getCartKey();
        }
    }

    private $_price;
    /**
     * @return float price
     */
    public function getPrice()
    {
        if ( $this->_price === null ) {
            switch ( $this->virtualType ) {
                case self::VIRTUALTYPE_DEPOT:
                    foreach ( $this->depotPositions as $depotPos ) {
                        if ( $this->virtualId === $depotPos->depot_id ) {
                            $this->_price = $depotPos->price;
                            break;
                        }
                    }
                    break;
                case self::VIRTUALTYPE_PROVIDER:
                    foreach ( $this->providerPositions as $providerPos ) {
                        if ( $this->virtualId === $providerPos->provider_id ) {
                            $this->_price = $providerPos->price;
                            break;
                        }
                    }
                    break;
                default:
                    $this->_price = 0;
            }
        }
        return $this->_price;
    }

    private $_delivery_time;
    /**
     * @return float price
     */
    public function getDeliveryTime()
    {
        if ( $this->_delivery_time === null ) {
            switch ( $this->virtualType ) {
                case self::VIRTUALTYPE_DEPOT:
                    $this->_delivery_time = 0;
                    break;
                case self::VIRTUALTYPE_PROVIDER:
                    foreach ( $this->providerPositions as $providerPos ) {
                        if ( $this->virtualId === $providerPos->provider_id ) {
                            $this->_delivery_time = $providerPos->delivery_time;
                            break;
                        }
                    }
                    break;
                default:
                    $this->_delivery_time = 0;
            }
        }
        return $this->_delivery_time;
    }

    public function rules()
    {
        return array(
            array('article, name, price', 'required'),
            array('in_stock, brand_id, category_id, status, sort, create_time, update_time, delivery_time', 'numerical', 'integerOnly'=>true),
            array('price, discount', 'numerical'),
            array('type', 'numerical', 'integerOnly'=>true),
            array('article, article_alias', 'length', 'max'=>45),
            array('name, img_photo', 'length', 'max'=>256),

            array('virtualType, virtualId', 'safe'),

            array('id, article, article_alias, name, price, type, discount, img_photo, wswg_description, brand_id, status', 'safe', 'on'=>'duplicate'),
            // The following rule is used by search().
            array('id, article, name, price, discount, in_stock, delivery_time, img_photo, wswg_description, brand_id, category_id, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'brand'=>array(self::BELONGS_TO, 'Brands', 'brand_id'),
            'category'=>array(self::BELONGS_TO, 'DetailCategory', 'category_id'),
            'adaptAutoModels'=>array(self::MANY_MANY, 'AutoModels', Adaptabillity::model()->tableName().'(detail_id, auto_model_id)'),
            'analogs'=>array(self::MANY_MANY, 'Details', AnalogDetails::model()->tableName().'(original_id, analog_id)'),
//            'cartInfo'=>array(self::HAS_ONE, 'CartDetails', '', 'on'=>'cartInfo.detail_key=:detail_key', 'condition'=>'cart_id=:cart_id', 'params'=>array(':cart_id'=>$cart->id, ':detail_key'=>$this->getId())),
            'adaptAutoModels'=>array(self::MANY_MANY, 'AutoModels', Adaptabillity::model()->tableName().'(detail_id, auto_model_id)'),
            'depot'=>array(self::MANY_MANY, 'Depot', DepotPosition::model()->tableName().'(position_id, depot_id)'),
            'depotPositions'=>array(self::HAS_MANY, 'DepotPosition', 'position_id'),
            'providers'=>array(self::MANY_MANY, 'Provider', ProviderPosition::model()->tableName().'(position_id, provider_id)'),
            'providerPositions'=>array(self::HAS_MANY, 'ProviderPosition', 'position_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'article' => 'Артикул',
            'article_alias' => 'Артикул поиска',
            'name' => 'Наименование товара',
            'price' => 'Стоимость',
            'in_stock' => 'В наличии',
            'delivery_time' => 'Время доставки (в днях)',
            'img_photo' => 'Фото',
            'wswg_description' => 'Описание',
            'brand_id' => 'Бренд',
            'category_id' => 'Категория',
            'status' => 'Статус',
            'sort' => 'Вес для сортировки',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата последнего редактирования',
            'discount' => 'Скидка',
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


    public function search($type = 0)
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('article',$this->article);
		$criteria->compare('article_alias',$this->article_alias);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('in_stock',$this->in_stock);
		$criteria->compare('delivery_time',$this->delivery_time);
		$criteria->compare('img_photo',$this->img_photo,true);
		$criteria->compare('wswg_description',$this->wswg_description,true);
		$criteria->compare('brand_id',$this->brand_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
        $criteria->compare('type', $type);

        $criteria->order = 'sort';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>100
            ),
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

    public function getUrl()
    {
        return Yii::app()->urlManager->createUrl('/details/view', array('id', $this->id));
    }

    public function getStockSpecify()
    {
        switch ( $this->virtualType ) {
            case self::VIRTUALTYPE_DEPOT:
                $depotId = $this->virtualId;
                $depot = Depot::model()->findByPk($depotId);
                return $depot->name;
            case self::VIRTUALTYPE_PROVIDER:
                $providerId = $this->virtualId;
                $provider = Providers::model()->findByPk($providerId);
                return $provider->name;
            default:
                return '';
        }
    }

    /*
     * 1) Если товар есть на складе выводить информацию о количестве с рабивкой по складам
     * 2) Если нет
     */
    public function toStringStock()
    {
        if ( $this->in_stock > 0 ) {
            return $this->in_stock.' шт.';
        }
        return '–';
    }

    public function toStringPrice()
    {
        if ( $this->price > 0 )
            return SiteHelper::priceFormat($this->price, 'руб.');
        else
            return '—';
    }

    public function toStringDeliveryTime()
    {
        if ( $this->getDeliveryTime() == 0 )
            return 'Сегодня';
        return $this->getDeliveryTime().' дней';
    }

    public function isArchived()
    {
        return $this->cartInfo->isArchived();
    }

    public function archivate()
    {
        if ( $this->isArchived() )
            return true;
        $this->cartInfo->status = CartDetails::STATUS_ARCHIVED;
        $this->cartInfo->save(false);
    }

    public function unarchivate()
    {
        if ( !$this->isArchived() )
            return true;
        $this->cartInfo->status = CartDetails::STATUS_ACTIVE;
        $this->cartInfo->save(false);
    }

    public function cmpStatus($a, $b)
    {
        if ( $a->cartInfo->status == $b->cartInfo->status )
            return 0;
        else if ($a->cartInfo->status > $b->cartInfo->status)
            return -1;
        else
            return 1;
    }
	
	public static function detailNotFound($article)
	{
		
			$detailNoFound = new DetailsNoFound;
			if(Yii::app()->user->getState('first_name')) $detailNoFound->username = Yii::app()->user->getState('first_name');
			if(Yii::app()->user->getState('email')) $detailNoFound->mail = Yii::app()->user->getState('email');
			$detailNoFound->article = $article;
			$detailNoFound->date_find = date('Y-m-d');
			$detailNoFound->save();
			
            return $detailNoFound;
	}

    public function duplicate()
    {
        $instance = new Details('duplicate');
        $instance->attributes = $this->attributes;
        return $instance;
    }

    private $_cartInfo;
    public function getCartInfo()
    {
        if ( $this->_cartInfo === null ) {
            $cart = Yii::app()->user->getDbCart();
            $this->_cartInfo = CartDetails::model()->findByAttributes(array(
                'cart_id' => $cart->id,
                'detail_key' => $this->getId()
            ));
        }
        return $this->_cartInfo;
    }

    public function isVirtual()
    {
        return $this->virtualType !== null;
    }
}
