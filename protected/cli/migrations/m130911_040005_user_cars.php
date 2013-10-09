<?php
/**
 * Миграция m130911_040005_user_cars
 *
 * @property string $prefix
 */
 
class m130911_040005_user_cars extends CDbMigration
{
    // таблицы к удалению, можно использовать '{{table}}'
	private $dropped = array('{{user_cars}}');
 
    public function __construct()
    {
        $this->execute('SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;');
        $this->execute('SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;');
        $this->execute('SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE="NO_AUTO_VALUE_ON_ZERO";');
    }
 
    public function __destruct()
    {
        $this->execute('SET SQL_MODE=@OLD_SQL_MODE;');
        $this->execute('SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;');
        $this->execute('SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;');
    }
 
    public function safeUp()
    {
        $this->_checkTables();
 
        $this->createTable('{{user_cars}}', array(
            'id' => 'pk', // auto increment

			'brand' => "VARCHAR(45) NOT NULL COMMENT 'Марка авто'",
			'model' => "VARCHAR(45) COMMENT 'Модель авто'",
			'year' => "TINYINT COMMENT 'Год выпуска'",
			'VIN' => "VARCHAR(20) COMMENT 'ВИН'",
			'mileage' => "FLOAT COMMENT 'Пробег'",
            'user_id' => "integer COMMENT 'Пользователь'",
			'status' => "tinyint COMMENT 'Статус'",
			'sort' => "integer COMMENT 'Вес для сортировки'",
            'create_time' => "integer COMMENT 'Дата создания'",
            'update_time' => "integer COMMENT 'Дата последнего редактирования'",
        ),
        'ENGINE=MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci');
    }
 
    public function safeDown()
    {
        $this->_checkTables();
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
        if (empty($this->dropped)) return;
 
        $table_names = $this->getDbConnection()->getSchema()->getTableNames();
        foreach ($this->dropped as $table) {
            if (in_array($this->tableName($table), $table_names)) {
                $this->dropTable($table);
            }
        }
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
