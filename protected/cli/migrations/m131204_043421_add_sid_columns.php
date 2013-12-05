<?php
/**
 * Миграция m131204_043421_add_sid_columns
 *
 * @property string $prefix
 */
 
class m131204_043421_add_sid_columns extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{brands}}', 'sid', 'varchar(20)');
        $this->addColumn('{{auto_models}}', 'sid', 'varchar(20)');
        $this->addColumn('{{engines}}', 'sid', 'varchar(20)');
        $this->dropColumn('{{depot}}', 'id_1C');
        $this->addColumn('{{depot}}', 'sid', 'varchar(20)');
        $this->addColumn('{{details}}', 'sid', 'varchar(20)');
    }
 
    public function safeDown()
    {
        $this->dropColumn('{{brands}}', 'sid');
        $this->dropColumn('{{auto_models}}', 'sid');
        $this->dropColumn('{{engines}}', 'sid');
        $this->addColumn('{{depot}}', 'id_1C', 'integer');
        $this->dropColumn('{{depot}}', 'sid');
        $this->dropColumn('{{details}}', 'sid');
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