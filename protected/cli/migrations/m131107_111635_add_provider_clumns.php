<?php
/**
 * Миграция m131107_111635_add_provider_clumns
 *
 * @property string $prefix
 */
 
class m131107_111635_add_provider_clumns extends CDbMigration
{
    // таблицы к удалению, можно использовать '{{table}}'
	private $dropped = array();
 
    public function safeUp()
    {
        $this->_checkTables();
        $this->addColumn('{{providers}}', 'name_excel_column', 'int(2)');
        $this->addColumn('{{providers}}', 'producer_excel_column', 'int(2)');
        $this->addColumn('{{providers}}', 'article_excel_column', 'int(2)');
        $this->addColumn('{{providers}}', 'price_excel_column', 'int(2)');
        $this->addColumn('{{providers}}', 'instock_excel_column', 'int(2)');
        $this->addColumn('{{providers}}', 'start_row', 'int(2)');
    }
 
    public function safeDown()
    {
        $this->dropColumn('{{providers}}', 'name_excel_column');
        $this->dropColumn('{{providers}}', 'producer_excel_column');
        $this->dropColumn('{{providers}}', 'article_excel_column');
        $this->dropColumn('{{providers}}', 'price_excel_column');
        $this->dropColumn('{{providers}}', 'instock_excel_column');
        $this->dropColumn('{{providers}}', 'start_row');
    }
 
    /**
     * Удаляет таблицы, указанные в $this->dropped из базы.
     * Наименование таблиц могут сожержать двойные фигурные скобки для указания
     * необходимости добавления префикса, например, если указано имя {{table}}
     * в действительности будет удалена таблица 'prefix_table'.
     * Префикс таблиц задается в файле конфигурации (для консоли).
     */
    private function _checkTables ()
    {

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