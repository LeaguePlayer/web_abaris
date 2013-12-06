<?php
Yii::import('application.components.*');
Yii::import('application.models.*');

class XMLParseCommand extends CConsoleCommand {
    public function run($args) {
        $SLASH = DIRECTORY_SEPARATOR;
        $dumpPath = __DIR__.$SLASH.'..'.$SLASH.'..'.$SLASH.'..'.$SLASH.'dump'.$SLASH;
        $files = scandir($dumpPath);

        // Формат файлов 'абарис-дд.мм.гг.xml'
        $lastUploadedFile = '';
        $timeMark = 0;
        foreach ($files as $file) {
            $nameParts = explode('-', $file);
            if ( count($nameParts) < 2 || $nameParts[0] !== 'абарис' )
                continue;
            $fileInfo = pathinfo($nameParts[1]);
            $dateParts = explode('.', $fileInfo['filename']);
            $dateUpload = mktime(0, 0, 0, $dateParts[1], $dateParts[0], $dateParts[2]);
            if ( $dateUpload > $timeMark ) {
                $lastUploadedFile = $file;
                $timeMark = $dateUpload;
            }
        }
        echo $lastUploadedFile."\n";
        $file = $dumpPath.$lastUploadedFile;
        try {
            set_time_limit(0);
            $parser = new AbarisXMLParserGeneral();
            $parser->open($file);
            $parser->parse();
            $parser->close();

            // Второй проход файла для чтения аналогов
            $parser = new AbarisXMLParserAnalogs();
            $parser->open($file);
            $parser->parse();
            $parser->close();
        } catch ( CException $e ) {
            echo $e->getMessage();
        }
    }
}
?>
