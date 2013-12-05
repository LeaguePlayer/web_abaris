<?php
Yii::import('application.extensions.vendor.SimpleXMLReader.library.SimpleXMLReader');

class AbarisXMLParserAnalogs extends SimpleXMLReader
{
    protected $currentPosId;
    protected $existsPositions;
    protected $existsAnalogs;

    protected $counter = 0;

    public function __construct()
    {
        $this->registerCallback('Товары', array($this, 'cbStart'), XMLREADER::ELEMENT);
        $this->registerCallback('Товар', array($this, 'cbPositionOpen'), XMLREADER::ELEMENT);
        $this->registerCallback('Аналоги', array($this, 'cbAnalog'), XMLREADER::ELEMENT);
        $this->registerCallback('Товары', array($this, 'cbFinish'), XMLREADER::END_ELEMENT);
        $this->reset();
    }

    protected function reset()
    {
        $this->currentPosId = null;
    }

    protected function cbStart($reader)
    {
        echo "Обработка аналогов\n";
        $positions = Yii::app()->db->createCommand()
            ->select('id, sid')
            ->from('{{details}}')
            ->queryAll();
        $this->existsPositions = CHtml::listData($positions, 'sid', 'id');
        unset($positions);

        $analogs = Yii::app()->db->createCommand()
            ->select('original_id, analog_id')
            ->from('{{analog_details}}')
            ->order('original_id')
            ->queryAll();
        $count = count($analogs);
        for ( $i = 0; $i < $count; $i++ ) {
            $originalId = $analogs[$i]['original_id'];
            $analogId = $analogs[$i]['analog_id'];
            $this->existsAnalogs[$originalId][] = $analogId;
        }
        unset($analogs);
        return true;
    }

    protected function cbFinish($reader)
    {
        unset($this->existsPositions);
        unset($this->existsAnalogs);
        return true;
    }

    protected function cbPositionOpen($reader)
    {
        $this->reset();
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $positionSid = trim( (string)$attributes->{'Код'} );
        if ( isset($this->existsPositions[$positionSid]) ) {
            $this->currentPosId = $this->existsPositions[$positionSid];
        }
        echo $this->counter++; echo "\n";
        return true;
    }

    protected function cbAnalog($reader)
    {
        if ( !$this->currentPosId )
            return true;

        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $analogSid = trim( (string)$attributes->{'Код'} );

        if ( !isset($this->existsPositions[$analogSid]) )
            return true;
        $analogId = $this->existsPositions[$analogSid];

        $hasAnalog = isset($this->existsAnalogs[$this->currentPosId]) &&
            in_array($analogId, $this->existsAnalogs[$this->currentPosId]);

        if ( $hasAnalog )
            return true;

        Yii::app()->db->createCommand()->insert('{{analog_details}}', array(
            'original_id'=>$this->currentPosId,
            'analog_id'=>$analogId
        ));
        $this->existsAnalogs[$this->currentPosId][] = $analogId;

        return true;
    }
}