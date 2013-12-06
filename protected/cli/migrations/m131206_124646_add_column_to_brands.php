<?php
/**
 * Миграция m131206_124646_add_column_to_brands
 *
 * @property string $prefix
 */
 
class m131206_124646_add_column_to_brands extends CDbMigration
{
 
    public function safeUp()
    {
        $this->addColumn('{{brands}}', 'country', 'varchar(45)');
        $this->dropColumn('{{details}}', 'producer_name');
        $this->dropColumn('{{details}}', 'producer_country');
    }
 
    public function safeDown()
    {
        $this->dropColumn('{{brands}}', 'country');
        $this->addColumn('{{details}}', 'producer_country', 'varchar(100)');
        $this->addColumn('{{details}}', 'producer_name', 'varchar(256)');
    }
 
    /**
     * Добавляет префикс таблицы при необходимости
     * @param $name - имя таблицы, заключенное в скобки, например {{имя}}
     * @return string
     */
    protected function tableName($name)
    {
        if($this->getDbConnection()->tablePrefix!==null && strpos($name,'{{')!==false)
            $realName=preg_replace('/{{(.*?)}}/',$this->getDbConnection()->tablePrefix.'$1',$name);
        else
            $realName=$name;
        return $realName;
    }
 
    /**
     * Получение установленного префикса таблиц базы данных
     * @return mixed
     */
    protected function getPrefix(){
        return $this->getDbConnection()->tablePrefix;
    }
}