<?php
/**
 * Миграция m131108_034233_add_details_columns
 *
 * @property string $prefix
 */
 
class m131108_034233_add_details_columns extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{details}}', 'non_identyfing', 'int(1)');
    }
 
    public function safeDown()
    {
        $this->dropColumn('{{details}}', 'non_identyfing');
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