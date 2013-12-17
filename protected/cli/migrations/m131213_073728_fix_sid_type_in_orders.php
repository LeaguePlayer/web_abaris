<?php
/**
 * Миграция m131213_073728_fix_sid_type_in_orders
 *
 * @property string $prefix
 */
 
class m131213_073728_fix_sid_type_in_orders extends CDbMigration
{
 
    public function safeUp()
    {
        $this->alterColumn('{{orders}}', 'SID', 'int(11)');
    }
 
    public function safeDown()
    {
        $this->alterColumn('{{orders}}', 'SID', 'varchar(20)');
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