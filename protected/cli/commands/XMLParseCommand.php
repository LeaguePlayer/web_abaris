<?php
Yii::import('application.components.*');
Yii::import('application.models.*');

class XMLParseCommand extends CConsoleCommand {
    public function run($args) {
        $SLASH = DIRECTORY_SEPARATOR;
        $parser = new AbarisXMLParser();
        $file = __DIR__.$SLASH.'..'.$SLASH.'..'.$SLASH.'..'.$SLASH.'dump'.$SLASH.'abaris-23.10.13.xml';
        try {
            $parser->open($file);
            $parser->parse();
            $parser->close();
        } catch ( CException $e ) {
            echo $e->getMessage();
        }
    }
}
?>
