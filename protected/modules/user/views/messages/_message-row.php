<div class="catalog-grid-row">
    <div class="container">
        <div class="row-fluid">
            <div class="field span1">
                <div class="valign-text">
                    <p>
                        <span class="blue-check">
                            <input name="Messages[checked][]" value="<?=$data->id;?>" id="check<?=$data->id;?>" type="checkbox"/>
                            <label for="check<?=$data->id?>"></label>
                        </span>
                    </p>
                </div>
            </div>
            <div class="field span2">
                <div class="valign-text">
                    <p><?=SiteHelper::russianDate($data->create_time);?></p>
                </div>
            </div>
            <div class="field span7">
                <div class="valign-text">
                    <p>
                    <?php
                        if ($data->isRead()) {
                            echo $data->message;
                        } else {
                            echo $data->strongMessage;
                            $data->markAsRead();
                        }
                    ?>
                    </p>
                </div>
            </div>
            <div class="field span2">
                <div class="valign-text">
                    <p><?=$data->from?></p>
                </div>
            </div>
        </div>
    </div>
</div>
