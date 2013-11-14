<?php

/**
* This is the model class for table "{{providers}}".
*
* The followings are the available columns in table '{{providers}}':
    * @property integer $id
    * @property string $name
    * @property integer $day_count
    * @property integer $name_excel_column
    * @property integer $producer_excel_column
    * @property integer $article_excel_column
    * @property integer $price_excel_column
    * @property integer $instock_excel_column
    * @property integer $start_row
*/
class Providers extends CActiveRecord
{
    public $priceFile;

    public function tableName()
    {
        return '{{providers}}';
    }


    public function rules()
    {
        return array(
            array('day_count, name_excel_column, producer_excel_column, article_excel_column, price_excel_column, instock_excel_column, start_row', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>255),
            array('priceFile', 'file', 'allowEmpty'=>true, 'types'=>array('xls')),
            // The following rule is used by search().
            array('id, name, day_count, name_excel_column, producer_excel_column, article_excel_column, price_excel_column, instock_excel_column, start_row', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Поставщик',
            'day_count' => 'Время доставки до Тюмени (в днях)',
            'name_excel_column' => 'Номер колонки для наименования товара',
            'producer_excel_column' => 'Номер колонки для названия производителя',
            'article_excel_column' => 'Номер колонки для артикула товара',
            'price_excel_column' => 'Номер колонки для цены товара',
            'instock_excel_column' => 'Номер колонки "В наличии"',
            'start_row' => 'Номер строки, с которой парсер начнет считывать данные',
        );
    }




    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('day_count',$this->day_count);
		$criteria->compare('name_excel_column',$this->name_excel_column);
		$criteria->compare('producer_excel_column',$this->producer_excel_column);
		$criteria->compare('article_excel_column',$this->article_excel_column);
		$criteria->compare('price_excel_column',$this->price_excel_column);
		$criteria->compare('instock_excel_column',$this->instock_excel_column);
		$criteria->compare('start_row',$this->start_row);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


}
