<?php
Yii::import('application.extensions.vendor.SimpleXMLReader.library.SimpleXMLReader');

class AbarisXMLParser extends SimpleXMLReader
{

    const LIMIT = 100;
    private $counter = 0;

    protected $currentPositionAttributes;
    protected $currentAdaptabillities;
    protected $currentAnalogs;


    protected $associations;


    protected $categoryCommand;


    public function __construct()
    {
        $this->registerCallback('Товар', array($this, 'callbackPositionBegin'), XMLREADER::ELEMENT);
        $this->registerCallback('Товар', array($this, 'callbackPositionEnd'), XMLREADER::END_ELEMENT);
        $this->registerCallback('Производитель', array($this, 'callbackProducer'), XMLREADER::ELEMENT);
        $this->registerCallback('Применение', array($this, 'callbackAdaptabillity'), XMLREADER::ELEMENT);
        $this->registerCallback('Аналоги', array($this, 'callbackAnalogs'), XMLREADER::ELEMENT);

        $this->currentAdaptabillities = array();
        $this->currentAnalogs = array();
        $this->currentPositionAttributes = null;

        $this->categoryCommand = Yii::app()
            ->createCommand("UPDATE tbl_detail_category
                SET (parent_id=:parent_id, name=:name, level=:level) WHERE id=:id
            IF @@ROWCOUNT=0
                INSERT INTO tbl_detail_category (id, parent_id, name, level)
                VALUES (:id, :parent_id, :name, :level)");
    }

    protected function getAssociationValue($type, $code)
    {
        return $this->associations[$type][$code];
    }

    protected function setAssociationValue($type, $code, $assocValue)
    {
        $this->associations[$type][$code] = $assocValue;
    }


    // Начало нода Товары
    protected function callbackPositionBegin($reader)
    {
        if (  (++$this->counter) >= self::LIMIT  )
            return false;

        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $this->currentTovarAttributes = array();
        foreach ( $xml->attributes() as $name => $attribute ) {
            $this->currentPositionAttributes[$name] = trim( (string)$attribute );
        }

        return true;
    }

    // Производитель
    protected function callbackProducer($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $this->currentPositionAttributes['Производитель'] = trim( (string)$attributes->{'Наименование'} );
        $this->currentPositionAttributes['Страна'] = trim( (string)$attributes->{'Страна'} );
        $this->currentPositionAttributes['Оригинал'] = trim( (string)$attributes->{'Оригинал'} );
        return true;
    }


    // Применение
    protected function callbackAdaptabillity($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $adaptabillity = array('Код' => trim( (string)$attributes->{'Код'} ));

        $modelAuto = $xml->{'МодельАвто'};
        if ( $modelAuto ) {
            foreach ( $modelAuto->attributes() as $key => $attribute ) {
                $adaptabillity[$key] = trim( (string)$attribute );
            }
        }

        $this->currentAdaptabillities[] = $adaptabillity;
        return true;
    }


    // Аналоги
    protected function callbackAnalogs($reader)
    {
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $this->currentAnalogs[] = trim( (string)$attributes->{'Код'} );
        return true;
    }


    // Конец нода Товары
    protected function callbackPositionEnd($reader)
    {
        $this->savePosition();
        $this->reset();
        return true;
    }


    protected function reset()
    {
        $this->currentPositionAttributes = null;
        $this->currentAdaptabillities = array();
        $this->currentAnalogs = array();
    }

    protected function savePosition()
    {
        if($this->currentPositionAttributes['ЭтоГруппа'] === '0') {
            $code = $this->currentPositionAttributes['Код'];
            $parentCode = ($this->currentPositionAttributes['Родитель']) ? $this->currentPositionAttributes['Родитель'] : 0;
            $name = $this->currentPositionAttributes['Наименование'];
            $this->saveCategory($code, $parentCode, $name, 0);
            return;
        }
    }

    protected function saveCategory($code, $parentCode, $name, $level)
    {
        $id = (int)$code;
        $parentId = (int)$parentCode;
        $this->categoryCommand->bindParam(':id', $id, PDO::PARAM_INT);
        $this->categoryCommand->bindParam(':parent_id', $parentId, PDO::PARAM_INT);
        $this->categoryCommand->bindParam(':name', $name, PDO::PARAM_STR);
        $this->categoryCommand->bindParam(':level', $level, PDO::PARAM_INT);
        $this->categoryCommand->execute();
    }
}