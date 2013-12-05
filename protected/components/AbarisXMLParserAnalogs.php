<?php
Yii::import('application.extensions.vendor.SimpleXMLReader.library.SimpleXMLReader');

class AbarisXMLParserAnalogs extends SimpleXMLReader
{
    protected $currentPosId;

    public function __construct()
    {
        $this->registerCallback('Товары', array($this, 'cbStart'), XMLREADER::ELEMENT);
        $this->registerCallback('Товар', array($this, 'cbPositionOpen'), XMLREADER::ELEMENT);
        $this->registerCallback('Аналоги', array($this, 'cbAnalog'), XMLREADER::ELEMENT);
        $this->reset();
    }

    protected function reset()
    {
        $this->currentPosId = null;
    }

    protected function cbStart($reader)
    {
        echo "Обработка аналогов\n";
        return true;
    }

    protected function cbPositionOpen($reader)
    {
        $this->reset();
        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $positionSid = trim( (string)$attributes->{'Код'} );

        $this->currentPosId = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{details}}')
            ->where('sid=:sid', array(':sid'=>$positionSid))
            ->queryScalar();

        return true;
    }

    protected function cbAnalog($reader)
    {
        if ( !$this->currentPosId )
            return true;

        $xml = $reader->expandSimpleXml('1.0', 'cp1251');
        $attributes = $xml->attributes();
        $analogSid = trim( (string)$attributes->{'Код'} );

        $analogId = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{details}}')
            ->where('sid=:sid', array(':sid'=>$analogSid))
            ->queryScalar();

        if ( !$analogId )
            return true;

        $hasAnalog = Yii::app()->db->createCommand()
            ->select('original_id')
            ->from('{{analog_details}}')
            ->where('original_id=:original_id AND analog_id=:analog_id', array(
                ':original_id'=>$this->currentPosId,
                ':analog_id'=>$analogId))
            ->queryScalar();

        if ( $hasAnalog )
            return true;

        Yii::app()->db->createCommand()->insert('{{analog_details}}', array(
            'original_id'=>$this->currentPosId,
            'analog_id'=>$analogId
        ));

        return true;
    }
}