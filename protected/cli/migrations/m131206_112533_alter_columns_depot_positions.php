<?php
/**
 * Миграция m131206_112533_alter_columns_depot_positions
 *
 * @property string $prefix
 */
 
class m131206_112533_alter_columns_depot_positions extends CDbMigration
{
 
    public function safeUp()
    {
        $this->addColumn('{{depot_positions}}', 'price', 'DECIMAL');
    }
 
    public function safeDown()
    {
        $this->dropColumn('{{depot_positions}}', 'price');
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