<?php
Yii::import('appext.phpexcelreader.JPhpExcelReader');

class ProvidersController extends AdminController
{
    protected $translateMap = array(
        " " => "",
        "." => "",
        "/" => "",
        "(" => "",
        ")" => "",
        "-" => "",
    );

	public function actionPrice()
    {
        $providers = Providers::model()->findAll();

        if ( isset($_POST['Providers']) ) {
            foreach ( $providers as $i => $item ) {
                $item->priceFile = CUploadedFile::getInstance($item, "[$i]priceFile");
                if ($item->validate() ) {
                    $this->parseXLS($item);
                }
            }
        }

        $this->render('price', array(
            'providers' => $providers
        ));
    }

    protected function parseXLS(Providers $model)
    {
        if ( $model->priceFile instanceof CUploadedFile ) {
            $data=new JPhpExcelReader($model->priceFile->getTempName());
            for ( $i = $model->start_row; $i <= $data->rowcount(); $i++ ) {
                $name = iconv('cp1251', 'utf8', $data->value($i, $model->name_excel_column));
                $article = iconv('cp1251', 'utf8', $data->value($i, $model->article_excel_column));
                $brandName = iconv('cp1251', 'utf8', $data->value($i, $model->producer_excel_column));
                $price = iconv('cp1251', 'utf8', $data->value($i, $model->price_excel_column));
                $inStock = iconv('cp1251', 'utf8', $data->value($i, $model->instock_excel_column));

                $articleAlias = strtolower( SiteHelper::translit($article, $this->translateMap) );

                $command = Yii::app()->db->createCommand();
//                $provider_positions = $command->select('detail_id')
//                    ->from('{{detail_provider}}')
//                    ->where('provider_id=:id', array(':id'=>$model->id))->queryAll();
//                $command->reset();
//                echo $command->update('{{details}}', array(
//                    'in_stock' => 0
//                ), array('and',
//                    'id IN (SELECT detail_id FROM {{detail_provider}} WHERE provider_id=:prov_id)',
//                    array(':prov_id'=>$model->id)
//                ));

                if ( !Details::model()->exists('article_alias=:alias', array(':alias'=>$articleAlias)) ) {
                    $command->insert('{{details}}', array(
                        'name' => $name,
                        'article' => $article,
                        'article_alias' => $articleAlias,
                        'price' => $price,
                        'producer_name' => $brandName,
                        'brand_id' => $this->getBrandId($brandName),
                        'non_identyfing' => 1,
                    ));
                    $command->reset();
                } else {
                    $command->update('{{details}}', array(
                    ),  'article_alias=:article_alias', array(':article_alias'=>$articleAlias));
                    $command->reset();
                }
            }
            return true;
        }
    }

    protected function getBrandId($brandName)
    {
        $brand = Brands::model()->findByAttributes(array('name'=>$brandName));
        if ( $brand === null ) {
            $brand = new Brands;
            $brand->name = $brandName;
            $brand->save(false);
        }
        return $brand->id;
    }
}
