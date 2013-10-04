<?php
/**
 * Test discount is applied when there are more than one item in position:
 * if there are two items in the same position (two equal products), add $rate % discount
 * to the first item.
 */
class TestDiscount extends IEDiscount {

    private $userDiscount = 0;

    public function apply(IECartPosition $position = null) {
        $user = Yii::app()->user->model();
        $userDiscount = $user !== null ? $user->discount : 0;
        if ( $position !== null ) {
            $this->processApply($position);
            return;
        }
        foreach ($this->shoppingCart as $position) {
            $this->processApply($position);
        }
    }

    private function processApply(IECartPosition $position)
    {
        if ( $position->cartInfo->status == CartDetails::STATUS_ARCHIVED )
            return;
        if ($position->getQuantity() > 0) {
            $discount = $position->discount + $this->userDiscount;
            $discountPrice = $discount * $position->getPrice() *$position->getQuantity() / 100;
            $position->addDiscountPrice($discountPrice);
        }
    }
}
