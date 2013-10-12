<div class="catalog-grid-row">
    <div class="container">
        <div class="row-fluid">
            <div class="field span1">
                <div class="valign-text">
                    <p>
                        <span class="blue-check">
                            <input name="UserSTO[checked][]" value="<?=$data->id;?>" id="check<?=$data->id;?>" type="checkbox"/>
                            <label for="check<?=$data->id?>"></label>
                        </span>
                    </p>
                </div>
            </div>
            <div class="field span2">
                <div class="valign-text">
                    <p><?=$data->user_car->brand?></p>
                </div>
            </div>
            <div class="field span2">
                <div class="valign-text">
                    <p><?=SiteHelper::russianDate($data->maintenance_date);?></p>
                </div>
            </div>
            <div class="field span2">
                <div class="valign-text">
                    <p><?=$data->maintenance_name?></p>
                </div>
            </div>
            <div class="field span2">
                <div class="valign-text">
                    <p><?=$data->getMaintenanceTypeLabel()?></p>
                </div>
            </div>
            <div class="field span1">
                <div class="valign-text">
                    <p><?=$data->maintenance_cost?></p>
                </div>
            </div>
            <div class="field span1">
                <div class="valign-text">
                    <p><?=$data->azs_cost?></p>
                </div>
            </div>
            <div class="field span1">
                <div class="valign-text">
                    <p><a href="<?=$this->createUrl("cabinet/stoform", array("id" => $data->id))?>" class="pencil"></a></p>
                </div>
            </div>
        </div>
    </div>
</div>