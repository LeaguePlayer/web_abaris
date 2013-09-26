<?php
/**
 * Test discount is applied when there are more than one item in position:
 * if there are two items in the same position (two equal products), add $rate % discount
 * to the first item.
 */
class TestDiscount extends IEDiscount {
    /**
     * Discount %
     */

    public function apply() {
        $user = Yii::app()->user->model();
        $userDiscount = $user !== null ? $user->discount : 0;
        foreach ($this->shoppingCart as $position) {
            $quantity = $position->getQuantity();
            if ($quantity > 0) {
                $discount = $position->discount + $userDiscount;
                $discountPrice = $discount * $position->getPrice() / 100;
                $position->addDiscountPrice($discountPrice);
            }
        }
    }
}
