<?php
/*
 * Если много чего непонятно, проще переписать парсер заново
 */

Yii::import('application.extensions.vendor.SimpleXMLReader.library.SimpleXMLReader');

class AbarisXMLParserGeneral extends SimpleXMLReader
{
    protected $currentPosition;
    protected $currentStocks;
    protected $currentFullStock;
    protected $existsPositions;
    protected $existCategories;
    protected $existDepot;
    protected $existsStocks;
    protected $existsAuto;
    protected $existsEngines;
    protected $existsAdaptAuto;
    protected $existsAdaptEngines;
    protected $existsBrands;


    protected $counter = 0;

    public function __construct()
    {
        $this->registerCallback('Выгрузка', array($this, 'cbStart'), XMLREADER::ELEMENT);
        $this->registerCallback('Выгрузка', array($this, 'cbFinish'), XMLREADER::END_ELEMENT);
        $this->registerCallback('ГруппыАвтомобилей', array($this, 'cbBrandsStart'), XMLREADER::ELEMENT);
        $this->registerCallback('ГруппаАвтомобилей', array($this, 'cbBrand'), XMLREADER::ELEMENT);
        $this->registerCallback('Автомобили', array($this, 'cbAutoStart'), XMLREADER::ELEMENT);
        $this->registerCallback('Автомобиль', array($this, 'cbAuto'), XMLREADER::ELEMENT);
        $this->registerCallback('Двигатели', array($this, 'cbEnginesStart'), XMLREADER::ELEMENT);
        $this->registerCallback('Двигатель', array($this, 'cbEngine'), XMLREADER::ELEMENT);
        $this->registerCallback('ДвигателиДляАвтомобилей', array($this, 'cbAutoEnginesStart'), XMLREADER::ELEMENT);
        $this->registerCallback('ДвигательДляАвтомобиля', array($this, 'cbAutoEngine'), XMLREADER::ELEMENT);
        $this->registerCallback('Склады', array($this, 'cbDepotStart'), XMLREADER::ELEMENT);
        $this->registerCallback('Склад', array($this, 'cbDepot'), XMLREADER::ELEMENT);
        $this->registerCallback('ГруппыТоваров', array($this, 'cbCategoriesStart'), XMLREADER::ELEMENT);
        $this->registerCallback('ГруппаТоваров', array($this, 'cbCategory'), XMLREADER::ELEMENT);
        $this->registerCallback('Товары', array($this, 'cbPositionsStart'), XMLREADER::ELEMENT);
        $this->registerCallback('Товар', array($this, 'cbPositionOpen'), XMLREADER::ELEMENT);
        $this->registerCallback('Производитель', array($this, 'cbProducer'), XMLREADER::ELEMENT);
        $this->registerCallback('Остаток', array($this, 'cbStock'), XMLREADER::ELEMENT);
        $this->registerCallback('Товар', array($this, 'cbPositionClose'), XMLREADER::END_ELEMENT);
        $this->registerCallback('Товары', array($this, 'cbPositionsFinish'), XMLREADER::END_ELEMENT);
        $this->registerCallback('ПримененияДеталей', array($this, 'cbAdaptStart'), XMLREADER::ELEMENT);
        $this->registerCallback('ПрименениеДеталей', array($this, 'cbAdapt'), XMLREADER::ELEMENT);
        $this->registerCallback('ПримененияДеталей', array($this, 'cbAdaptFinish'), XMLREADER::END_ELEMENT);
        $this->reset();
    }

    protected function reset()
    {
        $this->currentPosition = array();
        $this->currentStocks = array();
        $this->currentFullStock = 0;
    }



    protected function cbStart($reader)
    {
        return true;
    }

    protected function cbFinish($reader)
    {
        //echo "Готово!\n";
        return true;
    }

    protected function cbBrandsStart($reader)
    {
        echo "Обработка брендов\n";
        return true;
    }

    protected function cbAutoStart($reader)
    {
        echo "Обработка автомобилей\n";
        return true;
    }

    protected function cbEnginesStart($reader)
    {
        echo "Обработка двигателей\n";
        return true;
    }

    protected function cbAutoEnginesStart($reader)
    {
        echo "Привязка двигателей к автомобилям\n";
        Yii::app()->db->createCommand()->truncateTable('{{auto_engines}}');
        return true;
    }

    protected function cbDepotStart($reader)
    {
        echo "Обработка складов\n";
        Yii::app()->db->createCommand()->truncateTable('{{depot}}');
        return true;
    }

    protected function cbCategoriesStart($reader)
    {
        echo "Обработка категорий\n";
        Yii::app()->db->createCommand()->truncateTable('{{detail_category}}');
        return true;
    }


    /*
     * Узел ГруппаАвтомобилей
     *
     * array(
     *      'Код'          => <Код>,
     *      'Наименование' => <Наименование>,
     *      'Сокращение'   => <Сокращение>,
     *      'ЭтоГруппа'    => всегда 1,
     *      'Родитель'     => всегда пусто,
     * )
     */
    protected function cbBrand($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $name = trim( (string)$attributes->{'Наименование'} );
        $alias = strtolower( SiteHelper::translit($name) );
        $sid = trim( (string)$attributes->{'Код'} );
        $brand = Yii::app()->db->createCommand()
            ->select('sid')
            ->from('{{brands}}')
            ->where('alias=:alias', array(':alias'=>$alias))
            ->queryRow();
        if ( !$brand ) {
            Yii::app()->db->createCommand()->insert('{{brands}}', array(
                'alias'=>$alias,
                'name'=>$name,
                'sid'=>$sid,
            ));
        } else if ($brand['sid'] != $sid) {
            Yii::app()->db->createCommand()->update('{{brands}}', array(
                'sid'=>$sid,
            ), 'alias=:alias', array(':alias'=>$alias));
        }
        return true;
    }

    /*
     * Узел Автомобиль
     *
     * array(
     *      'Код'          => <Код>,
     *      'Наименование' => <Наименование>,
     *      'Сокращение'   => <Сокращение>,
     *      'ЭтоГруппа'    => всегда 0,
     *      'Родитель'     => <Код Группы Автомобилей>,
     * )
     */
    protected function cbAuto($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $sid = trim( (string)$attributes->{'Код'} );
        $name = trim( (string)$attributes->{'Наименование'} );
        $alias = trim( (string)$attributes->{'Сокращение'} );
        if ( !$alias ) {
            $alias = strtolower( SiteHelper::translit($name) );
        }
        $brandSid = trim( (string)$attributes->{'Родитель'} );

        $auto = Yii::app()->db->createCommand()
            ->select('sid')
            ->from('{{auto_models}}')
            ->where('alias=:alias', array(':alias'=>$alias))
            ->queryRow();
        $brandId = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{brands}}')
            ->where('sid=:sid', array(':sid'=>$brandSid))
            ->queryScalar();
        if ( !$auto ) {
            Yii::app()->db->createCommand()->insert('{{auto_models}}', array(
                'alias'=>$alias,
                'name'=>$name,
                'sid'=>$sid,
                'brand_id'=>$brandId
            ));
        } else if ($auto['sid'] != $sid) {
            Yii::app()->db->createCommand()->update('{{auto_models}}', array(
                'sid'=>$sid,
            ), 'alias=:alias', array(':alias'=>$alias));
        }
        return true;
    }

    /*
     * Узел Двигатель
     *
     * array(
     *      'Код'          => <Код>,
     *      'Наименование' => <Наименование>,
     *      'Сокращение'   => <Сокращение>,
     * )
     */
    protected function cbEngine($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $name = trim( (string)$attributes->{'Наименование'} );
        $alias = trim( (string)$attributes->{'Сокращение'} );
        if ( !$alias ) {
            $alias = strtolower( SiteHelper::translit($name) );
        }
        $sid = trim( (string)$attributes->{'Код'} );
        $engine = Yii::app()->db->createCommand()
            ->select('sid')
            ->from('{{engines}}')
            ->where('alias=:alias', array(':alias'=>$alias))
            ->queryRow();
        if ( !$engine ) {
            Yii::app()->db->createCommand()->insert('{{engines}}', array(
                'alias'=>$alias,
                'name'=>$name,
                'sid'=>$sid,
            ));
        } else if ($engine['sid'] != $sid) {
            Yii::app()->db->createCommand()->update('{{engines}}', array(
                'sid'=>$sid,
            ), 'alias=:alias', array(':alias'=>$alias));
        }
        return true;
    }


    /*
     * Узел Двигатель
     *
     * array(
     *      'Двигатель' => <Код двигателя>,
     *      'Владелец'   => <Код автомобиля>,
     * )
     */
    protected function cbAutoEngine($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $engineSid = trim( (string)$attributes->{'Двигатель'} );
        $autoSid = trim( (string)$attributes->{'Владелец'} );

        $engineId = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{engines}}')
            ->where('sid=:sid', array(':sid'=>$engineSid))
            ->queryScalar();
        $autoId = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{auto_models}}')
            ->where('sid=:sid', array(':sid'=>$autoSid))
            ->queryScalar();
        if ( is_numeric($engineId) && is_numeric($autoId) ) {
            Yii::app()->db->createCommand()->insert('{{auto_engines}}', array(
                'engine_id'=>$engineId,
                'auto_model_id'=>$autoId
            ));
        }
        return true;
    }


    /*
     * Узел Склад
     *
     * array(
     *      'Код'            => <Код>,
     *      'Наименование'   => <Наименование>,
     * )
     */
    protected function cbDepot($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $sid = trim( (string)$attributes->{'Код'} );
        $name = trim( (string)$attributes->{'Наименование'} );
        Yii::app()->db->createCommand()->insert('{{depot}}', array(
            'name'=>$name,
            'sid'=>$sid,
        ));
        return true;
    }


    /*
     * Узел Склад
     *
     * array(
     *      'Код'            => <Код>,
     *      'Наименование'   => <Наименование>,
     * )
     */
    protected function cbCategory($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $sid = trim( (string)$attributes->{'Код'} );
        $name = trim( (string)$attributes->{'Наименование'} );
        Yii::app()->db->createCommand()->insert('{{detail_category}}', array(
            'name'=>$name,
            'sid'=>$sid,
            'level'=>0
        ));
        return true;
    }

    protected function cbPositionsStart($reader)
    {
        echo "Обработка товаров\n";
        Yii::app()->db->createCommand()->truncateTable('{{depot_positions}}');
        $positions = Yii::app()->db->createCommand()
            ->select('id, sid, in_stock, article_alias, price')
            ->from('{{details}}')
            ->queryAll();
        $count = count( $positions );
        for ( $i = 0; $i < $count; $i++ ) {
            $this->existsPositions[$positions[$i]['article_alias']] = array(
                'id'=>$positions[$i]['id'],
                'sid'=>$positions[$i]['sid'],
                'in_stock'=>$positions[$i]['in_stock']
            );
        }
        unset($positions);

        $brands = Yii::app()->db->createCommand()
            ->select('alias, id')
            ->from('{{brands}}')
            ->queryAll();
        $this->existsBrands = CHtml::listData($brands, 'alias', 'id');
        unset($brands);

        $categories = Yii::app()->db->createCommand()
            ->select('id, sid')
            ->from('{{detail_category}}')
            ->queryAll();
        $this->existCategories = CHtml::listData($categories, 'sid', 'id');
        unset($categories);

        $depot = Yii::app()->db->createCommand()
            ->select('id, sid')
            ->from('{{depot}}')
            ->queryAll();
        $this->existDepot = CHtml::listData($depot, 'sid', 'id');
        unset($depot);
//        print_r($this->existCategories);
//        echo memory_get_usage(); die();
        return true;
    }

    protected function cbPositionsFinish($reader)
    {
        unset($this->existsPositions);
        unset($this->existsCategories);
        unset($this->existsDepot);
        unset($this->existsStocks);
        unset($this->existsBrands);
        return true;
    }

    /*
     * Узел ГруппаАвтомобилей
     *
     * array(
     *      'Код'          => <Код>,
     *      'Наименование' => <Наименование>,
     *      'Сокращение'   => <Сокращение>,
     *      'ЭтоГруппа'    => всегда 1,
     *      'Родитель'     => всегда пусто,
     * )
     */
    protected function cbPositionOpen($reader)
    {
        $this->reset();
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        foreach ( $xml->attributes() as $name => $attribute ) {
            $key = (string)$name;
            $this->currentPosition[$key] = trim( (string)$attribute );
        }
        return true;
    }

    // Производитель
    protected function cbProducer($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $this->currentPosition['producer'] = array(
            'Производитель' => trim( (string)$attributes->{'Наименование'} ),
            'Страна' => trim( (string)$attributes->{'Страна'} ),
            'Оригинал' => (int)$attributes->{'Оригинал'},
        );
        return true;
    }

    // Остатки
    protected function cbStock($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $depotSid = trim( (string)$attributes->{'КодСклада'} );
        $inStock = (int)$attributes->{'Остаток'};
        $price = (float)$attributes->{'Цена'};
        $this->currentStocks[$depotSid] = array(
            'in_stock'=>$inStock,
            'price'=>$price
        );
        $this->currentFullStock += $inStock;
        return true;
    }

    protected function cbPositionClose($reader)
    {
        $article = trim( $this->currentPosition['Артикул'] );
        $articleAlias = trim ($this->currentPosition['АртикулПоиска'] );
        if ( $article === '' && $articleAlias === '' ) {
            return true;
        }

        //echo $this->counter++; echo "\n";

        if ( $article === '' )
            $article = $articleAlias;
        if ( $articleAlias === '' )
            $articleAlias = strtolower($article);

        $sid = $this->currentPosition['Код'];
        $name = $this->currentPosition['Наименование'];
        $categorySid = $this->currentPosition['Родитель'];

        if ( isset($this->currentPosition['producer']) ) {
            $producerName = trim($this->currentPosition['producer']['Производитель']);
            $producerCountry = trim($this->currentPosition['producer']['Страна']);
            $producerAlias = strtolower( SiteHelper::translit($producerName) );
            if ( !isset($this->existsBrands[$producerAlias]) ) {
                Yii::app()->db->createCommand()->insert('{{brands}}', array(
                    'alias'=>$producerAlias,
                    'name'=>$producerName,
                    'country'=>$producerCountry,
                ));
                $brandId = Yii::app()->db->getLastInsertID();
                $this->existsBrands[$producerAlias] = $brandId;
            } else {
                $brandId = $this->existsBrands[$producerAlias];
            }
            $isOriginal = (int)$this->currentPosition['producer']['Оригинал'];
        } else {
            $brandId = 0;
            $isOriginal = 0;
        }

        $position = isset($this->existsPositions[$articleAlias]) ? $this->existsPositions[$articleAlias] : null;

        if ( !$position ) {
            $categoryId = $this->existCategories[$categorySid];
            Yii::app()->db->createCommand()->insert('{{details}}', array(
                'article'=>$article,
                'article_alias'=>$articleAlias,
                'name'=>$name,
                'sid'=>$sid,
                'in_stock'=>$this->currentFullStock,
                'category_id'=>$categoryId,
                'is_original'=>$isOriginal,
                'brand_id'=>$brandId,
            ));
            $positionId = Yii::app()->db->getLastInsertID();
            $this->existsPositions[$articleAlias] = array(
                'id'=>$positionId,
                'sid'=>$sid,
                'in_stock'=>$this->currentFullStock,
            );
        } else if ( $position['in_stock'] != $this->currentFullStock || $position['sid'] != $sid ) {
            Yii::app()->db->createCommand()->update('{{details}}', array(
                'name'=>$name,
                'sid'=>$sid,
                'in_stock'=>$this->currentFullStock,
            ), 'id=:id', array(':id'=>$position['id']));
            $positionId = $position['id'];
            $this->existsPositions[$articleAlias] = array(
                'id'=>$positionId,
                'sid'=>$sid,
                'in_stock'=>$this->currentFullStock,
            );
        } else {
            $positionId = $position['id'];
        }


        foreach ( $this->currentStocks as $depotSid => $depotInfo ) {
            $depotId = $this->existDepot[$depotSid];
            if ( !isset($this->existsStocks[$positionId.$depotId]) ) {
                Yii::app()->db->createCommand()->insert('{{depot_positions}}', array(
                    'depot_id'=>$depotId,
                    'position_id'=>$positionId,
                    'stock'=>$depotInfo['in_stock'],
                    'price'=>$depotInfo['price']
                ));
                $this->existsStocks[$positionId.$depotId] = array(
                    'in_stock'=>$depotInfo['in_stock'],
                    'price'=>$depotInfo['price']
                );
            } else if ( $this->existsStocks[$positionId.$depotId]['in_stock'] != $depotInfo['in_stock'] || $this->existsStocks[$positionId.$depotId]['price'] != $depotInfo['price'] ) {
                Yii::app()->db->createCommand()->update('{{depot_positions}}', array(
                        'stock'=>$depotInfo['in_stock'],
                        'price'=>$depotInfo['price'],
                    ), 'depot_id=:depot_id AND position_id=:position_id', array(
                        ':depot_id'=>$depotId,
                        ':position_id'=>$positionId)
                );
            }
        }
        return true;
    }


    protected function cbAdaptStart($reader)
    {
        echo "Обработка применений товаров\n";
        //$this->counter = 0;

        $positions = Yii::app()->db->createCommand()
            ->select('id, sid')
            ->from('{{details}}')
            ->queryAll();
        $this->existsPositions = CHtml::listData($positions, 'sid', 'id');
        unset($positions);

        $auto = Yii::app()->db->createCommand()
            ->select('id, sid')
            ->from('{{auto_models}}')
            ->queryAll();
        $this->existsAuto = CHtml::listData($auto, 'sid', 'id');
        unset($auto);

        $engines = Yii::app()->db->createCommand()
            ->select('id, sid')
            ->from('{{engines}}')
            ->queryAll();
        $this->existsEngines = CHtml::listData($engines, 'sid', 'id');
        unset($engines);

        $adaptabillities = Yii::app()->db->createCommand()
            ->select('detail_id, auto_model_id, engine_model_id')
            ->from('{{adaptabillity}}')
            ->queryAll();

        $count = count($adaptabillities);

        for ( $i = 0; $i < $count; $i++ ) {
            $detailId = $adaptabillities[$i]['detail_id'];
            $autoId = $adaptabillities[$i]['auto_model_id'];
            $engineId = $adaptabillities[$i]['engine_model_id'];
            if ( $autoId )
                $this->existsAdaptAuto[$detailId][] = $autoId;
            if ( $engineId )
                $this->existsAdaptEngines[$detailId][] = $engineId;
        }
        unset($adaptabillities);
        unset($detailId);
        unset($autoId);
        unset($engineId);

        //echo memory_get_usage(); die();

        return true;
    }


    protected function cbAdaptFinish($reader)
    {
        unset($this->existsPositions);
        unset($this->existsAuto);
        unset($this->existsEngines);
        unset($this->existsAdaptAuto);
        unset($this->existsAdaptEngines);
        return true;
    }


    // Применение деталей
    protected function cbAdapt($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();

        $positionSid = trim( (string)$attributes->{'Владелец'} );
        $autoSid = trim( (string)$attributes->{'Автомобиль'} );
        $engineSid = trim( (string)$attributes->{'Двигатель'} );

        if ( !isset($this->existsPositions[$positionSid]) ) {
            return true;
        }
        //echo $this->counter++; echo "\n";
        $positionId = $this->existsPositions[$positionSid];

        $autoId = isset($this->existsAuto[$autoSid]) ? $this->existsAuto[$autoSid] : null;
        $engineId = isset($this->existsEngines[$engineSid]) ? $this->existsEngines[$engineSid] : null;

        if ( !$autoId && !$engineId )
            return true;

        if ( $autoId ) {
            if ( !isset($this->existsAdaptAuto[$positionId]) || !in_array($autoId, $this->existsAdaptAuto[$positionId]) ) {
                Yii::app()->db->createCommand()->insert('{{adaptabillity}}', array(
                    'detail_id'=>$positionId,
                    'auto_model_id'=>$autoId,
                    'engine_model_id'=>null
                ));
                $this->existsAdaptAuto[$positionId][] = $autoId;
            }
        }

        if ( $engineId ) {
            if ( !isset($this->existsAdaptEngines[$positionId]) || !in_array($engineId, $this->existsAdaptEngines[$positionId]) ) {
                Yii::app()->db->createCommand()->insert('{{adaptabillity}}', array(
                    'detail_id'=>$positionId,
                    'auto_model_id'=>null,
                    'engine_model_id'=>$engineId
                ));
                $this->existsAdaptEngines[$positionId][] = $engineId;
            }
        }

        return true;
    }
}