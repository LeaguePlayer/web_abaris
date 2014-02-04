<div class="ajax-modal">

    <h3>Список заказанных товаров</h3>

    <table class="orders-table">
        <thead>
            <th>Название товара</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Всего</th>
        </thead>
        <tbody>
            <?php $full_cost = 0 ?>
            <?php foreach ( $model->positions as $position ): ?>
                <tr>
                    <?php
                        $posCost = $position->count * $position->cost;
                        $full_cost += $posCost;
                    ?>
                    <td><?= $position->name ?></td>
                    <td><?= SiteHelper::priceFormat($position->cost).' р.' ?></td>
                    <td><?= $position->count ?></td>
                    <td><?= SiteHelper::priceFormat($posCost).' р.' ?></td>
                </tr>
            <?php endforeach; ?>
            <?php
                $deliveryPriceText = $model->self_transport ? '–' : SiteHelper::priceFormat($model->delivery_price).' р.';
                $full_cost += (+$model->delivery_price);
            ?>
            <tr>
                <td>Доставка</td>
                <td><?= $deliveryPriceText ?></td>
                <td></td>
                <td><?= $deliveryPriceText ?></td>
            </tr>
            <tr>
                <td colspan="3">Итого</td>
                <td class="total"><?= SiteHelper::priceFormat($full_cost).' р.' ?></td>
            </tr>
        </tbody>
    </table>

</div>
