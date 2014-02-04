<?php
/**
 * Миграция m140204_044603_add_columns_to_orders
 *
 * @property string $prefix
 */
 
class m140204_044603_add_columns_to_orders extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{orders}}', 'self_transport', 'int(1)');
        $this->addColumn('{{orders}}', 'delivery_price', 'DECIMAL');
    }
 
    public function safeDown()
    {
        $this->dropColumn('{{orders}}', 'self_transport');
        $this->dropColumn('{{orders}}', 'delivery_price');
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