<?php
/**
 * Миграция m131120_074417_alter_column_cart_details
 *
 * @property string $prefix
 */
 
class m131120_074417_alter_column_cart_details extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{cart_details}}', 'detail_key', 'varchar(25)');
        $this->createIndex('cartdetails_detailkey_index', '{{cart_details}}', 'detail_key');
    }
 
    public function safeDown()
    {
        $this->dropIndex('cartdetails_detailkey_index', '{{cart_details}}');
        $this->dropColumn('{{cart_details}}', 'detail_key');
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