<?php
/**
 * Миграция m131119_061933_add_column_to_depot
 *
 * @property string $prefix
 */
 
class m131119_061933_add_column_to_depot extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{depot}}', 'id_1C', 'integer');
    }
 
    public function safeDown()
    {
        $this->dropColumn('{{depot}}', 'id_1C');
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