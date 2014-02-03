<?php
/**
 * Миграция m140203_094456_add_transport_column_to_cart
 *
 * @property string $prefix
 */
 
class m140203_094456_add_transport_column_to_cart extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{cart}}', 'self_transport', 'int(1)');
    }
 
    public function safeDown()
    {
        $this->dropColumn('{{cart}}', 'self_transport');
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