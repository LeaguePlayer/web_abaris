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
        $this->registerCallback('ПримененияДеталей', array($this, 'cbAdaptStart'), XMLREADER::ELEMENT);
        $this->registerCallback('ПрименениеДеталей', array($this, 'cbAdapt'), XMLREADER::ELEMENT);
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
        echo "Подождите...\n";
        return true;
    }

    protected function cbFinish($reader)
    {
        echo "Готово!\n";
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
        Yii::app()->db->createCommand()->delete('{{auto_engines}}');
        return true;
    }

    protected function cbDepotStart($reader)
    {
        echo "Обработка складов\n";
        Yii::app()->db->createCommand()->delete('{{depot}}');
        return true;
    }

    protected function cbCategoriesStart($reader)
    {
        echo "Обработка категорий\n";
        Yii::app()->db->createCommand()->delete('{{detail_category}}');
        return true;
    }

    protected function cbPositionsStart($reader)
    {
        echo "Обработка товаров\n";
        Yii::app()->db->createCommand()->delete('{{depot_positions}}');
        return true;
    }

    protected function cbAdaptStart($reader)
    {
        echo "Обработка применений товаров\n";
        $this->counter = 0;
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
        echo $this->counter++; echo "\n";

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
        $this->currentStocks[$depotSid] = $inStock;
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
        if ( $article === '' )
            $article = $articleAlias;
        if ( $articleAlias === '' )
            $articleAlias = strtolower($article);

        $sid = $this->currentPosition['Код'];
        $name = $this->currentPosition['Наименование'];
        $categorySid = $this->currentPosition['Родитель'];
        $price = (float)$this->currentPosition['Цена'];
        if ( isset($this->currentPosition['producer']) ) {
            $producerName = trim($this->currentPosition['producer']['Производитель']);
            $producerCountry = trim($this->currentPosition['producer']['Страна']);
            $isOriginal = (int)$this->currentPosition['producer']['Оригинал'];
        } else {
            $producerName = '';
            $producerCountry = '';
            $isOriginal = 0;
        }

        $position = Yii::app()->db->createCommand()
            ->select('id, sid')
            ->from('{{details}}')
            ->where('article_alias=:alias', array(':alias'=>$articleAlias))
            ->queryRow();

        if ( !$position ) {
            $categoryId = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{detail_category}}')
                ->where('sid=:sid', array(':sid'=>$categorySid))
                ->queryScalar();
            Yii::app()->db->createCommand()->insert('{{details}}', array(
                'article'=>$article,
                'article_alias'=>$articleAlias,
                'name'=>$name,
                'price'=>$price,
                'sid'=>$sid,
                'in_stock'=>$this->currentFullStock,
                'category_id'=>$categoryId,
                'producer_name'=>$producerName,
                'producer_country'=>$producerCountry,
                'is_original'=>$isOriginal,
            ));
            $positionId = Yii::app()->db->getLastInsertID();
        } else {
            Yii::app()->db->createCommand()->update('{{details}}', array(
                'name'=>$name,
                'price'=>$price,
                'sid'=>$sid,
                'in_stock'=>$this->currentFullStock,
            ), 'article_alias=:alias', array(':alias'=>$articleAlias));
            $positionId = $position['id'];
        }

        foreach ( $this->currentStocks as $depotSid => $inStock ) {
            $depotId = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{depot}}')
                ->where('sid=:sid', array(':sid'=>$depotSid))
                ->queryScalar();

            $currentStock = Yii::app()->db->createCommand()
                ->select('stock')
                ->from('{{depot_positions}}')
                ->where('depot_id=:depot_id AND position_id=:position_id', array(
                    ':depot_id'=>$depotId,
                    ':position_id'=>$positionId))
                ->queryScalar();
            if ( !$currentStock ) {
                Yii::app()->db->createCommand()->insert('{{depot_positions}}', array(
                    'depot_id'=>$depotId,
                    'position_id'=>$positionId,
                    'stock'=>$inStock
                ));
            } else if ( $currentStock != $inStock ) {
                Yii::app()->db->createCommand()->update('{{depot_positions}}', array(
                    'stock'=>$inStock
                ), 'depot_id=:depot_id AND position_id=:position_id', array(
                    ':depot_id'=>$depotId,
                    ':position_id'=>$positionId)
                );
            }


        }
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

        $positionId  = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{details}}')
            ->where('sid=:sid', array(':sid'=>$positionSid))
            ->queryScalar();
        if ( !$positionId ) {
            return true;
        }

        echo $this->counter++; echo "\n";

        if ( $autoSid !== '' )
            $autoId  = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{auto_models}}')
                ->where('sid=:sid', array(':sid'=>$autoSid))
                ->queryScalar();
        else
            $autoId = null;
        if ( $engineSid !== '' )
            $engineId  = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{engines}}')
                ->where('sid=:sid', array(':sid'=>$engineSid))
                ->queryScalar();
        else
            $engineId = null;

        if ( !$autoId && !$engineId )
            return true;

        if ( !$autoId ) $autoId = null;
        if ( !$engineId ) $engineId = null;

        $adapt = Yii::app()->db->createCommand()
            ->select('detail_id')
            ->from('{{adaptabillity}}')
            ->where('detail_id=:position_id AND auto_model_id=:auto_id AND engine_model_id=:engine_id', array(
                ':position_id'=>$positionId,
                ':auto_id'=>$autoId,
                ':engine_id'=>$engineId))
            ->queryRow();
        if ( !$adapt ) {
            Yii::app()->db->createCommand()->insert('{{adaptabillity}}', array(
                'detail_id'=>$positionId,
                'auto_model_id'=>$autoId,
                'engine_model_id'=>$engineId
            ));
        }

        return true;
    }
}