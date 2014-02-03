<?php
/**
 * Миграция m140116_064148_add_column_to_order_positions
 *
 * @property string $prefix
 */
 
class m140116_064148_add_column_to_order_positions extends CDbMigration
{
    public function safeUp()
    {
//        $this->dropPrimaryKey('orderpos_id_pk', '{{order_positions}}');
        $this->addColumn('{{order_positions}}', 'position_key', 'varchar(40)');
    }
 
    public function safeDown()
    {
//        $this->dropPrimaryKey('orderpos_id_pk', '{{order_positions}}');
        $this->dropColumn('{{order_positions}}', 'position_key');
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