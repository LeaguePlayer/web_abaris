<?php
Yii::import('appext.phpexcelreader.JPhpExcelReader');

class ProvidersController extends AdminController
{
    protected $translateMap = array(
        " " => "",
        "." => "",
        "/" => "-",
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
        $positions = CHtml::listData(Yii::app()->db->createCommand()
            ->select('article_alias, id')
            ->from('{{details}}')
            ->queryAll(), 'article_alias', 'id');

        $brands = CHtml::listData(Yii::app()->db->createCommand()
            ->select('alias, id')
            ->from('{{brands}}')
            ->queryAll(), 'alias', 'id');

        $providerPositions = array();

        $command = Yii::app()->db->createCommand();
        $command->delete('{{provider_positions}}', 'provider_id=:provider_id', array(
            ':provider_id'=>$model->id
        ));
        if ( $model->priceFile instanceof CUploadedFile ) {
            $data=new JPhpExcelReader($model->priceFile->getTempName());
            $rowCounter = 0;
            for ( $i = $model->start_row; $i <= $data->rowcount(); $i++ ) {
                $rowCounter++;
                $name = iconv('cp1251', 'utf8', $data->value($i, $model->name_excel_column));
                if ( empty($name) )
                    continue;
                $inStock = (int)iconv('cp1251', 'utf8', $data->value($i, $model->instock_excel_column));
                if ( $inStock == 0 )
                    continue;
                $article = iconv('cp1251', 'utf8', $data->value($i, $model->article_excel_column));
                if ( empty($article) )
                    continue;
                $brandName = iconv('cp1251', 'utf8', $data->value($i, $model->producer_excel_column));
                $price = iconv('cp1251', 'utf8', $data->value($i, $model->price_excel_column));

                $articleAlias = strtolower( SiteHelper::translit($article, $this->translateMap) );
                $brandAlias = strtolower( SiteHelper::translit($brandName, $this->translateMap) );

                if ( !isset($positions[$articleAlias]) ) {
                    if ( !isset($brands[$brandAlias]) ) {
                        $command->reset();
                        $command->insert('{{brands}}', array(
                            'name'=>$brandName,
                            'alias'=>$brandAlias,
                        ));
                        $brandId = Yii::app()->db->getLastInsertID();
                        $brands[$brandAlias] = $brandId;
                    } else {
                        $brandId = $brands[$brandAlias];
                    }
                    $command->reset();
                    $command->insert('{{details}}', array(
                        'name' => $name,
                        'article' => $article,
                        'article_alias' => $articleAlias,
                        'brand_id' => $brandId,
                        'category_id'=>0,
                        'non_identyfing' => 1,
                        'is_original'=>strpos($brandAlias, 'hyundai') != 0
                            || strpos($brandAlias, 'kia') != 0
                            || $brandAlias == 'ssangyong'
                            || $brandAlias == 'daewoo'
                            || $brandAlias == 'chevrolet'
                    ));
                    $posId = Yii::app()->db->getLastInsertID();
                    $positions[$articleAlias] = $posId;
                } else {
                    $posId = $positions[$articleAlias];
                }
                $command->reset();
                if ( !isset( $providerPositions[$model->id.$posId] ) ) {
                    $command->insert('{{provider_positions}}', array(
                        'provider_id'=>$model->id,
                        'position_id'=>$posId,
                        'price'=>$price,
                        'stock'=>$inStock,
                        'delivery_time'=>$model->day_count
                    ));
                    $providerPositions[$model->id.$posId] = $inStock;
                }

            }
            unset($positions);
            unset($brands);
            return $rowCounter;
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

    public function actionUploadPrice($id)
    {
        $provider = Providers::model()->findByPk($id);
        if ( isset($_POST['Providers']) ) {
            $provider->priceFile = CUploadedFile::getInstance($provider, "priceFile");
            if ( $provider->save() ) {
                if ( $rowsReaded = $this->parseXLS($provider) ) {
                    Yii::app()->user->setFlash('success_parse', "Почитано {$rowsReaded} строк");
                }
            }
        }
        $this->render('upload_price', array(
            'provider'=>$provider
        ));
    }
}
