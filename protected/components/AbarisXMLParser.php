<?php
/*
 * Если много чего непонятно, проще переписать парсер заново
 */

Yii::import('application.extensions.vendor.SimpleXMLReader.library.SimpleXMLReader');

class AbarisXMLParser extends SimpleXMLReader
{
    protected $currentPositionAttributes;
    protected $currentAdaptabillities;
    protected $currentAnalogs;


    protected $brands = array();
    protected $autoModels = array();
    protected $engines = array();
    protected $positions = array();
    protected $categories = array();
    protected $adaptabillities = array();
    protected $autoEngines = array();
    protected $analogs = array();


    protected $positionIdAssociations = array();
    protected $positionCategories = array();
    protected $positionAnalogs = array();

    protected $callbabackBegin = 0;
    protected $callbabackEnd = 0;
    protected $currentPos = 0;


    public function __construct()
    {
        $this->registerCallback('Товар', array($this, 'callbackPositionBegin'), XMLREADER::ELEMENT);
        $this->registerCallback('Товар', array($this, 'callbackPositionEnd'), XMLREADER::END_ELEMENT);
        $this->registerCallback('Производитель', array($this, 'callbackProducer'), XMLREADER::ELEMENT);
        $this->registerCallback('Применение', array($this, 'callbackAdaptabillity'), XMLREADER::ELEMENT);
        $this->registerCallback('Аналоги', array($this, 'callbackAnalogs'), XMLREADER::ELEMENT);
        $this->registerCallback('Товары', array($this, 'callbackStart'), XMLREADER::ELEMENT);
        $this->registerCallback('Товары', array($this, 'callbackFinish'), XMLREADER::END_ELEMENT);

        $this->init();

        $this->currentAdaptabillities = array();
        $this->currentAnalogs = array();
        $this->currentPositionAttributes = null;
    }

    protected function init()
    {
        $brands = Yii::app()->db->createCommand()->select('id, name')->from('tbl_brands')->queryAll();
        $this->brands = CHtml::listData($brands, 'name', 'id');

        $autoModels = Yii::app()->db->createCommand()->select('id, alias')->from('tbl_auto_models')->queryAll();
        $this->autoModels = CHtml::listData($autoModels, 'alias', 'id');

        $engines = Yii::app()->db->createCommand()->select('id, alias')->from('tbl_engines')->queryAll();
        $this->engines = CHtml::listData($engines, 'alias', 'id');

        $positions = Yii::app()->db->createCommand()->select('id, article_alias')->from('tbl_details')->queryAll();
        $this->positions = CHtml::listData($positions, 'article_alias', 'id');

        $categories = Yii::app()->db->createCommand()->select('id, sid')->from('tbl_detail_category')->queryAll();
        $this->categories = CHtml::listData($categories, 'sid', 'id');

        $adaptabillities = Yii::app()->db->createCommand()->select('detail_id, auto_model_id, engine_model_id')
            ->from('tbl_adaptabillity')->queryAll();
        foreach ( $adaptabillities as $adaptabillity )
            $this->adaptabillities[$adaptabillity['detail_id']][] = array(
                'auto_id'=>$adaptabillity['auto_model_id'],
                'engine_id'=>$adaptabillity['engine_model_id']);

        $autoEngines = Yii::app()->db->createCommand()->select('auto_model_id, engine_id')
            ->from('tbl_auto_engines')->queryAll();
        foreach ( $autoEngines as $autoEngine )
            $this->autoEngines[$autoEngine['auto_model_id']][] = $autoEngine['engine_id'];

        $analogs = Yii::app()->db->createCommand()->select('original_id, analog_id')->from('tbl_analog_details')->queryAll();
        foreach ( $analogs as $analogRow )
            $this->analogs[$analogRow['original_id']][] = $analogRow['analog_id'];
    }





    protected function hasBrand($brandName)
    {
        foreach ( $this->brands as $name => $id ) {
            if ( strtolower($name) === strtolower($brandName) )
                return true;
        }
        return false;
    }

    protected function getBrandId($brandName)
    {
        return $this->brands[$brandName];
    }

    protected function saveBrand($brandName)
    {
        $brand = new Brands;
        $brand->name = $brandName;
        if ($brand->save(false))
            $this->brands[$brandName] = $brand->id;
        return $brand->id;
    }






    protected function hasAuto($autoAlias)
    {
        foreach ( $this->autoModels as $alias => $id ) {
            if ( strtolower($alias) === strtolower($autoAlias) )
                return true;
        }
        return false;
    }

    protected function getAutoId($alias)
    {
        return $this->autoModels[$alias];
    }

    protected function saveAuto($name, $alias, $brandId)
    {
        $auto = new AutoModels();
        $auto->name = $name;
        $auto->alias = $alias;
        $auto->brand_id = $brandId;
        $auto->status = AutoModels::STATUS_PUBLISH;
        if ($auto->save(false))
            $this->autoModels[$alias] = $auto->id;
        return $auto->id;
    }





    protected function hasEngine($engineAlias)
    {
        foreach ( $this->engines as $alias => $id ) {
            if ( strtolower($alias) === strtolower($engineAlias) )
                return true;
        }
        return false;
    }

    protected function getEngineId($alias)
    {
        return $this->engines[$alias];
    }

    protected function saveEngine($name, $alias)
    {
        $engine = new Engines();
        $engine->name = $name;
        $engine->alias = $alias;
        $engine->status = Engines::STATUS_PUBLISH;
        if ($engine->save(false))
            $this->engines[$alias] = $engine->id;
        return $engine->id;
    }





    protected function hasPosition($articleAlias)
    {
        return isset($this->positions[$articleAlias]);
    }

    protected function getPositionId($articleAlias)
    {
        return $this->positions[$articleAlias];
    }

    protected function insertPosition($name, $article, $article_alias, $in_stock, $price,
                                      $brand_id, $producer_name, $producer_country, $is_original)
    {
        $db = Yii::app()->db;
        $command = $db->createCommand();
        $affectedRows = $command->insert('tbl_details', array(
            'name' => $name,
            'article' => $article,
            'article_alias' => strtolower($article_alias),
            'in_stock' => $in_stock,
            'price' => $price,
            'producer_name' => $producer_name,
            'producer_country' => $producer_country,
            'brand_id' => $brand_id,
            'is_original' => $is_original
        ));
        if ( $affectedRows > 0 ) {
            $id = $db->getLastInsertID();
            $this->positions[$article_alias] = $id;
            return $id;
        }
        return false;
    }

    protected function updatePosition($id, $name, $article, $article_alias, $in_stock, $price,
                                      $brand_id, $producer_name, $producer_country, $is_original)
    {
        $db = Yii::app()->db;
        $command = $db->createCommand();
        $command->update('tbl_details', array(
            'name' => $name,
            'article' => $article,
            'article_alias' => strtolower($article_alias),
            'in_stock' => $in_stock,
            'price' => $price,
            'producer_name' => $producer_name,
            'producer_country' => $producer_country,
            'brand_id' => $brand_id,
            'is_original' => $is_original
        ), 'id=:id', array(':id'=>$id));
    }

    protected function updatePositionCategory($id, $category_id)
    {
        $db = Yii::app()->db;
        $command = $db->createCommand();
        $command->update('tbl_details', array(
            'category_id' => $category_id,
        ), 'id=:id', array(':id'=>$id));
    }





    protected function hasCategory($code)
    {
        foreach ( $this->categories as $sid => $id ) {
            if ( strtolower($sid) === strtolower($code) )
                return true;
        }
        return false;
    }

    protected function getCategoryId($sid)
    {
        if ( !isset($this->categories[$sid]) )
            return 0;
        return $this->categories[$sid];
    }

    protected function saveCategory($name, $parent_id, $level, $code)
    {
        $category = new DetailCategory();
        $category->name = $name;
        $category->parent_id = $parent_id;
        $category->level = $level;
        $category->sid = $code;
        if ($category->save(false))
            $this->categories[$code] = $category->id;
        return $category->id;
    }





    protected function hasAdaptabillity($posId, $autoId, $engineId)
    {
        if ( !isset($this->adaptabillities[$posId]) )
            return false;
        foreach ( $this->adaptabillities[$posId] as $adapt ) {
            if ( $autoId == $adapt['auto_id'] && $engineId == $adapt['engine_id'] )
                return true;
        }
        return false;
    }


    protected function saveAdaptabillity($posId, $autoId, $engineId)
    {
        $db = Yii::app()->db;
        $command = $db->createCommand();
        $affectedRows = $command->insert('tbl_adaptabillity', array(
            'detail_id' => $posId,
            'auto_model_id' => $autoId,
            'engine_model_id' => $engineId
        ));
        if ( $affectedRows > 0 ) {
            $this->adaptabillities[$posId][] = array('auto_id'=>$autoId, 'engine_id'=>$engineId);
            return $db->getLastInsertID();
        }
        return false;
    }





    protected function hasAutoEngine($autoId, $engineId)
    {
        if ( !isset($this->autoEngines[$autoId]) )
            return false;
        foreach ( $this->autoEngines[$autoId] as $dbEngineId ) {
            if ( $engineId == $dbEngineId )
                return true;
        }
        return false;
    }


    protected function saveAutoEngine($autoId, $engineId)
    {
        $db = Yii::app()->db;
        $command = $db->createCommand();
        $affectedRows = $command->insert('tbl_auto_engines', array(
            'auto_model_id' => $autoId,
            'engine_id' => $engineId
        ));
        if ( $affectedRows > 0 ) {
            $this->autoEngines[$autoId][] = $engineId;
            return $db->getLastInsertID();
        }
        return false;
    }





    protected function hasAnalog($originalId, $analogId)
    {
        if ( !isset($this->analogs[$originalId]) )
            return false;
        foreach ( $this->analogs[$originalId] as $dbAnalogId ) {
            if ( $analogId == $dbAnalogId )
                return true;
        }
        return false;
    }


    protected function saveAnalog($originalId, $analogId)
    {
        $db = Yii::app()->db;
        $command = $db->createCommand();
        $affectedRows = $command->insert('tbl_analog_details', array(
            'original_id' => $originalId,
            'analog_id' => $analogId
        ));
        if ( $affectedRows > 0 ) {
            $this->analogs[$originalId][] = $analogId;
            return $db->getLastInsertID();
        }
        return false;
    }






    protected function callbackStart($reader)
    {
        echo "Подождите...";
        return true;
    }


    // Начало нода Товар
    /*
     * array(
     *      'Код'           => <Код>,
     *      'Наименование'  => <Наименование>,
     *      'ЭтоГруппа'     => <ЭтоГруппа>,
     *      'Родитель'      => <Родитель>,
     *      'Артикул'       => <Артикул>,
     *      'АртикулПоиска' => <АртикулПоиска>,
     *      'Цена'          => <Цена>,
     *      'Остаток'       => <Остаток>
     * )
     */
    protected function callbackPositionBegin($reader)
    {
        // Проверяю, завршилась ли обработка предыдущего узла
        // По идее после обработки каждого узла, массив $this->currentPositionAttributes обнуляется
        // Это по-видимому ошибка синтаксиса в xml-файле, когда отсутствует закрывающий тэг "Товар",
        // но допускаю, что это может быть и мой косяк (см. метод callbackPositionEnd)
        if ( !empty( $this->currentPositionAttributes ) )
            return true;

        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        foreach ( $xml->attributes() as $name => $attribute ) {
            $this->currentPositionAttributes[$name] = trim( (string)$attribute );
        }
        $this->callbabackBegin++;
        return true;
    }

    // Производитель
    protected function callbackProducer($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $this->currentPositionAttributes['producer'] = array(
            'Производитель' => trim( (string)$attributes->{'Наименование'} ),
            'Страна' => trim( (string)$attributes->{'Страна'} ),
            'Оригинал' => trim( (string)$attributes->{'Оригинал'} ),
        );
        $brandName = $this->currentPositionAttributes['producer']['Производитель'];
        if ( !empty($brandName) ) {
            if ( !$this->hasBrand($brandName) )
                $this->saveBrand($brandName);
            $this->currentPositionAttributes['producer']['id'] = $this->getBrandId($brandName);
        }
        return true;
    }


    /*
     * Применение
     *
     * <Код> => array(
     *      'auto'   => array(
     *          'КодМарки'          => <КодМарки>,
     *          'НаименованиеМарки' => <НаименованиеМарки>,
     *          'КодМодели'         => КодМодели,
     *          'СокрМодельАвто'    => СокрМодельАвто
     *      ),
     *      'engine' => array(
     *          'КодКатегории'          => <КодКатегории>,
     *          'НаименованиеКатегории' => <НаименованиеКатегории>,
     *          'КодМодели'             => <КодМодели>,
     *          'НаименованиеМодели'    => <НаименованиеМодели>,
     *          'СокрМодельДвигателя'   => <СокрМодельДвигателя>
     *      )
     * )
     */
    protected function callbackAdaptabillity($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');

        $modelAuto = $xml->{'МодельАвто'};
        if ( $modelAuto ) {
            $autoAttributes = array();
            foreach ( $modelAuto->attributes() as $key => $attribute ) {
                $autoAttributes[$key] = trim( (string)$attribute );
            }
            $brandName = $autoAttributes['НаименованиеМарки'];
            if ( !$this->hasBrand($brandName) ) {
                $this->saveBrand($brandName);
            }
            $autoAlias = $autoAttributes['СокрМодельАвто'];
            if ( !$this->hasAuto($autoAlias) ) {
                $autoName = $autoAttributes['НаименованиеМодели'];
                $this->saveAuto($autoName, $autoAlias, $this->getBrandId($brandName));
            }
            $this->currentAdaptabillities['auto'][] = $autoAlias;
        }


        $modelEngine = $xml->{'МодельДвигателя'};
        if ( $modelEngine ) {
            $engineAttributes = array();
            foreach ( $modelEngine->attributes() as $key => $attribute ) {
                $engineAttributes[$key] = trim( (string)$attribute );
            }
            $engineAlias = $engineAttributes['СокрМодельДвигателя'];
            if (!$this->hasEngine($engineAlias) ) {
                $engineName = $engineAttributes['НаименованиеМодели'];
                $this->saveEngine($engineName, $engineAlias);
            }
            $this->currentAdaptabillities['engine'][] = $engineAlias;
        }
        return true;
    }


    /*
     * Аналоги
     *
     * <Код>
     */
    protected function callbackAnalogs($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $this->currentAnalogs[] = trim( (string)$attributes->{'Код'} );
        return true;
    }


    // Конец ноды Товар
    // Перед выходом из метода важно вызвать reset()!
    protected function callbackPositionEnd($reader)
    {
        $code = (int) $this->currentPositionAttributes['Код'];
        $name = $this->currentPositionAttributes['Наименование'];

        $itsCategory = ($this->currentPositionAttributes['ЭтоГруппа'] === '1');

        if ($itsCategory) {
            // Сохранение категории
            if ( !$this->hasCategory($code) )
                $this->saveCategory($name, 0, 0, $code);

            $this->reset();
            return true;
        }

        $id = null;
        $article = $this->currentPositionAttributes['Артикул'];
        $article_alias = $this->currentPositionAttributes['АртикулПоиска'];
        $price = floatval($this->currentPositionAttributes['Цена']);
        $in_stock = (int) $this->currentPositionAttributes['Остаток'];

        if ( isset($this->currentPositionAttributes['producer']) ) {
            $producer_name = $this->currentPositionAttributes['producer']['Производитель'];
            $producer_country = $this->currentPositionAttributes['producer']['Страна'];
            $is_original = (int) $this->currentPositionAttributes['producer']['Оригинал'];
        } else {
            $producer_name = "";
            $producer_country = "";
            $is_original = 0;
        }

        if ( isset($this->currentPositionAttributes['producer']['id']) )
            $brand_id = $this->currentPositionAttributes['producer']['id'];
        else
            $brand_id = 0;

        if ( $this->hasPosition($article_alias) ) {
            $posId = $this->getPositionId($article_alias);
            $this->updatePosition($posId, $name, $article, $article_alias,
                                  $in_stock, $price, $brand_id, $producer_name,
                                  $producer_country, $is_original);
        } else {
            $posId = $this->insertPosition($name, $article, $article_alias,
                                  $in_stock, $price, $brand_id, $producer_name,
                                  $producer_country, $is_original);
        }

        // Обновление информации о соответствии моделей авто и двигателей
//        if ( isset($this->currentAdaptabillities['auto']) && isset($this->currentAdaptabillities['engine']) ) {
//            foreach ( $this->currentAdaptabillities['auto'] as $autoAlias ) {
//                $autoId = $this->getAutoId($autoAlias);
//                foreach ( $this->currentAdaptabillities['engine'] as $engineAlias ) {
//                    $engineId = $this->getEngineId($engineAlias);
//                    if ( !$this->hasAutoEngine($autoId, $engineId) )
//                        $this->saveAutoEngine($autoId, $engineId);
//                }
//            }
//        }


        if ( !$posId ) {
            $this->reset();
            return true;
        }


        // Сохранение кода категории, соответсвующей данному товару
        // На данном этапе категории с кодом, записанном в атрибуте "Родитель" может еще не существовать в бд
        // (я не использую id-ки из xml в качестве ключей для записей), поэтому
        // присваивание категории товарам будет произведено в дополнительном цикле
        // по окончании парсинга
        $categoryCode = (int) $this->currentPositionAttributes['Родитель'];
        $this->positionCategories[$posId] = $categoryCode;


        // Обработка применения товаров
        if ( isset($this->currentAdaptabillities['auto']) )
            foreach ( $this->currentAdaptabillities['auto'] as $alias ) {
                $autoId = $this->getAutoId($alias);
                if ( !$this->hasAdaptabillity($posId, $autoId, null) )
                    $this->saveAdaptabillity($posId, $autoId, null);
            }

        if ( isset($this->currentAdaptabillities['engine']) )
            foreach ( $this->currentAdaptabillities['engine'] as $alias ) {
                $engineId = $this->getEngineId($alias);
                if ( !$this->hasAdaptabillity($posId, null, $engineId) )
                    $this->saveAdaptabillity($posId, null, $engineId);
            }

        // Сохранение соответсвия между идентификаторами товара на сайте и в 1С
        $this->positionIdAssociations[$code] = $posId;

        // Сохранение аналогов для обработки по окончанию парсинга
        foreach ($this->currentAnalogs as $positionCode)
            $this->positionAnalogs[$posId][] = (int) $positionCode;

        $this->reset();
        return true;
    }


    protected function reset()
    {
        $this->currentPositionAttributes = null;
        $this->currentAdaptabillities = array();
        $this->currentAnalogs = array();
    }

    protected function callbackFinish($reader)
    {
        echo "\nОбновление категорий...";
        // Сохранение категорий товаров
        foreach ( $this->positionCategories as $posId => $catCode ) {
            $catId = $this->getCategoryId($catCode);
            if ( $catId > 0 )
                $this->updatePositionCategory($posId, $catId);
        }

        echo "\nОбновление аналогов...";
        // Сохранение аналогов
        foreach ( $this->positionAnalogs as $posId => $analogs ) {
            foreach ( $analogs as $analogCode ) {
                if ( isset($this->positionIdAssociations[$analogCode]) ) {
                    $analogId = $this->positionIdAssociations[$analogCode];
                    if ( !$this->hasAnalog($posId, $analogId) )
                        $this->saveAnalog($posId, $analogId);
                }
            }
        }
        echo "\nГотово!\n";
        return true;
    }
}