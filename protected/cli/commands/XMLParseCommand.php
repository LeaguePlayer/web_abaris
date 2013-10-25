<?php
Yii::import('application.components.AbarisXMLParser');

class XMLParseCommand extends CConsoleCommand {
    public function run($args) {
        $SLASH = DIRECTORY_SEPARATOR;


        $parser = new AbarisXMLParser();
        $file = __DIR__.$SLASH.'..'.$SLASH.'..'.$SLASH.'..'.$SLASH.'dump'.$SLASH.'абарис-23.10.13.xml';
        $parser->open($file);
        $parser->parse();
        $parser->close();
    }
}
?>
